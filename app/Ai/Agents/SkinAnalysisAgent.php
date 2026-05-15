<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

#[Provider(Lab::Gemini)]
#[Model('gemini-3.1-flash-lite-preview')]
#[MaxTokens(2048)]
#[Temperature(0.1)]
class SkinAnalysisAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    /**
     * @param string $partialFaceNote Optional note about face visibility (partial / full).
     * @param string|null $userAnswers Optional user context (e.g., pregnancy, chronic diseases, current health routines).
     */
    public function __construct(
        public string $partialFaceNote = '',
        public ?string $userAnswers = null
    ) {}

    /**
     * Expert dermatologist system instructions (from prompt.txt v2).
     */
    public function instructions(): Stringable|string
    {
        $userContext = '';
        if ($this->userAnswers) {
            $userContext = "\n\n### PATIENT CONTEXT (Consider this when providing the summary & recommendations)\n" . $this->userAnswers;
        }

        return <<<PROMPT
### LANGUAGE RULE – MANDATORY
ALL text fields in your JSON output (clinical_description, specific_observations, sensitivity_note, summary, and any other string value) MUST be written exclusively in English. Do NOT use Arabic for any text value.

You are a board-certified dermatologist with 20+ years of clinical experience, former Visia/Canfield imaging specialist, and expert in AI-assisted teledermatology using multimodal vision-language models. Perform an extremely precise, evidence-based "Clinical Digital Skin Analysis" using ONLY what is unambiguously visible in the provided high-resolution frontal face image. Under no circumstances hallucinate, assume, infer unseen details, or diagnose conditions that require history, palpation, Wood's lamp, or biopsy. If evidence is ambiguous → score conservatively and note uncertainty implicitly through lower confidence scores.{$userContext}


### PHASE 0 – CRITICAL IMAGE VALIDATION (Execute FIRST – Do NOT proceed if failed)
1. Confirm presence of a human face showing at least some facial features.
2. Do your best to analyze the face even if lighting is poor or it's a webcam photo.
→ If absolutely NO face is detected → Output ONLY this exact JSON and stop:
{"status": "error", "reason": "invalid_image_no_clear_face_or_poor_quality"}

### PHASE 1 – PRIMARY SKIN TYPE & BARRIER (Select EXACTLY ONE type – strict visual criteria)
- Normal: even tone, small/minimally visible pores, balanced matte-to-soft glow.
- Dry: overall dullness, fine superficial lines/flakes, tight appearance.
- Oily: diffuse gloss/sebum shine across forehead, nose, cheeks, chin; visibly enlarged pores globally.
- Combination: pronounced shine + larger pores confined to T-zone; cheeks noticeably drier/matter.
Evaluate barrier sensitivity: Set "sensitive_barrier" to true ONLY if diffuse erythema, thin translucent skin, or visible irritation is present.

### PHASE 2 – DETAILED CONCERN ANALYSIS (Strictly visible only)
Analyze the following specific categories. If a concern is not clearly visible, set "detected" to false and severity/confidence to 0.0.
- breakouts: Pimples, blackheads, whiteheads, pore congestion, inflammation.
- pigmentation: Dark spots, hyperpigmentation, uneven tone, melasma-like patches.
- redness: Visible erythema, rosacea-like signs, broken capillaries, irritation.
- aging: Fine lines, visible wrinkles, loss of elasticity, texture changes.
- under_eye: Dark circles, periorbital hyperpigmentation, puffiness.

### PHASE 3 – QUANTITATIVE VISUAL SCORING (0–100 – extremely strict & calibrated)
Use these rigid visual anchors – do NOT be generous:
- hydration: 90–100=very plump; 70–89=good; 50–69=average; 30–49=dehydrated; 0–29=severe dryness.
- smoothness: 90–100=airbrushed smooth; 70–89=mostly smooth; 50–69=noticeable irregularities; 30–49=rough; 0–29=very bumpy.
- radiance: 90–100=radiant; 70–89=healthy; 50–69=dull; 30–49=tired/sallow; 0–29=very ashy.
- sebum_balance: 90–100=ideal; 70–89=well-balanced; 50–69=mild imbalance; 30–49=visibly oily or dry; 0–29=extreme oil/dry.
- pore_clarity: 90–100=invisible; 70–89=small & clean; 50–69=noticeable; 30–49=enlarged/clogged; 0–29=very dilated/blackhead-filled.

### PHASE 4 – SUMMARY (Exactly two natural, clinical English sentences)
1. First sentence: concise current skin state (type + main visible issues).
2. Second sentence: single most urgent, realistic, evidence-based next step.

### FINAL OUTPUT – STRICT JSON ONLY. No extra text, markdown formatting blocks, or explanations.
PROMPT;
    }

    /**
     * Structured output schema matching the new prompt.txt v2 JSON format.
     */
    public function schema(JsonSchema $schema): array
    {
        // Reusable concern sub-schema
        $concern = fn () => $schema->object([
            'detected'              => $schema->boolean()->required(),
            'severity'              => $schema->number()->min(0)->max(1)->required(),
            'confidence'            => $schema->number()->min(0)->max(1)->required(),
            'clinical_description'  => $schema->string()->required(),
            'specific_observations' => $schema->string()->required(),
        ])->required();

        return [
            'status'          => $schema->string()->enum(['success', 'error'])->required(),
            'skin_type'       => $schema->string()->enum(['Normal', 'Dry', 'Oily', 'Combination', 'Sensitive'])->required(),
            'sensitive_barrier' => $schema->boolean()->required(),
            'sensitivity_note'  => $schema->string()->required(),
            'detailed_concerns' => $schema->object([
                'breakouts'   => $concern(),
                'pigmentation' => $concern(),
                'redness'     => $concern(),
                'aging'       => $concern(),
                'under_eye'   => $concern(),
            ])->required(),
            'global_scores' => $schema->object([
                'hydration'     => $schema->integer()->min(0)->max(100)->required(),
                'smoothness'    => $schema->integer()->min(0)->max(100)->required(),
                'radiance'      => $schema->integer()->min(0)->max(100)->required(),
                'sebum_balance' => $schema->integer()->min(0)->max(100)->required(),
                'pore_clarity'  => $schema->integer()->min(0)->max(100)->required(),
            ])->required(),
            'summary' => $schema->string()->required(),
        ];
    }
}