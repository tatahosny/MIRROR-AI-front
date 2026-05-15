<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductUsage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $cleansers = Category::create([
            'name' => 'المنظفات',
            'description' => 'منتجات تنظيف البشرة وإزالة الشوائب',
        ]);

        $moisturizers = Category::create([
            'name' => 'المرطبات',
            'description' => 'منتجات لترطيب البشرة وحماية الحاجز الواقي',
        ]);

        $serums = Category::create([
            'name' => 'السيروم العلاجي',
            'description' => 'تركيبات مركزة لعلاج مشاكل محددة في البشرة',
        ]);

        $sunscreens = Category::create([
            'name' => 'الحماية من الشمس',
            'description' => 'كريمات الحماية من الأشعة فوق البنفسجية',
        ]);

        // 2. Create Products & Usages

        // --- Cleanser ---
        $p1 = Product::create([
            'category_id' => $cleansers->id,
            'name' => 'لـومينا غسول رغوي لطيف',
            'description' => 'غسول يومي يوازن درجة حموضة البشرة ويزيل الزيوت الزائدة دون جفاف.',
            'price' => 120.00,
            'image_url' => 'https://example.com/images/cleanser-1.jpg',
            'stock' => 50,
            'ingredients' => 'حمض الهيالورونيك، سيراميد، نياسيناميد',
        ]);

        ProductUsage::create([
            'product_id' => $p1->id,
            'suitable_for_skin_types' => 'Normal, Oily, Combination',
            'suitable_for_concerns' => 'breakouts, pore_clarity',
            'usage_frequency' => 'مرتين يومياً',
            'usage_time' => 'صباحاً ومساءً',
            'how_to_use' => 'دلكي كمية صغيرة على بشرة مبللة لدقيقة واحدة ثم اشطفي بالماء الفاتر.',
            'amount_to_use' => 'ضغطة واحدة من العبوة',
            'warnings' => 'تجنب ملامسة العينين.',
            'priority' => 1,
            'is_essential' => true,
        ]);

        // --- Moisturizer ---
        $p2 = Product::create([
            'category_id' => $moisturizers->id,
            'name' => 'لـومينا كريم ترطيب ليلي مكثف',
            'description' => 'كريم غني بالسيراميد لترميم حاجز البشرة المتضرر.',
            'price' => 180.00,
            'image_url' => 'https://example.com/images/moisturizer-1.jpg',
            'stock' => 30,
            'ingredients' => 'سيراميد NP، زبدة الشيا، ببتيدات',
        ]);

        ProductUsage::create([
            'product_id' => $p2->id,
            'suitable_for_skin_types' => 'Dry, Normal, Sensitive',
            'suitable_for_concerns' => 'aging, redness',
            'usage_frequency' => 'مرة واحدة يومياً',
            'usage_time' => 'مساءً',
            'how_to_use' => 'يوزع على الوجه والرقبة بعد السيروم كآخر خطوة في الروتين.',
            'amount_to_use' => 'كمية بحجم حبة البازلاء',
            'warnings' => 'للاستخدام الخارجي فقط.',
            'priority' => 1,
            'is_essential' => true,
        ]);

        // --- Serum ---
        $p3 = Product::create([
            'category_id' => $serums->id,
            'name' => 'لـومينا سيروم فيتامين سي للنضارة',
            'description' => 'سيروم قوي ومستقر لتفتيح البقع الداكنة وتوحيد لون البشرة.',
            'price' => 250.00,
            'image_url' => 'https://example.com/images/serum-1.jpg',
            'stock' => 20,
            'ingredients' => '15% فيتامين سي نقي، حمض الفيروليك، فيتامين E',
        ]);

        ProductUsage::create([
            'product_id' => $p3->id,
            'suitable_for_skin_types' => 'All types',
            'suitable_for_concerns' => 'pigmentation, radiance',
            'usage_frequency' => 'مرة واحدة يومياً',
            'usage_time' => 'صباحاً',
            'how_to_use' => 'ضعي 3-4 قطرات على الوجه بعد التنظيف وقبل الترطيب.',
            'amount_to_use' => '3-4 قطرات',
            'warnings' => 'قد يسبب وخزاً خفيفاً في البداية. يجب استخدام واقي شمس.',
            'priority' => 2,
            'is_essential' => false,
        ]);

        // --- Sunscreen ---
        $p4 = Product::create([
            'category_id' => $sunscreens->id,
            'name' => 'لـومينا واقي شمس الشفاف SPF 50',
            'description' => 'حماية واسعة المدى لا تترك أثراً أبيض، مناسبة لجميع ألوان البشرة.',
            'price' => 200.00,
            'image_url' => 'https://example.com/images/sunscreen-1.jpg',
            'stock' => 100,
            'ingredients' => 'أكسيد الزنك، مستخلص الشاي الأخضر',
        ]);

        ProductUsage::create([
            'product_id' => $p4->id,
            'suitable_for_skin_types' => 'All types, Sensitive',
            'suitable_for_concerns' => 'aging, redness, pigmentation',
            'usage_frequency' => 'يومياً',
            'usage_time' => 'صباحاً',
            'how_to_use' => 'يوزع بوفرة قبل التعرض للشمس بـ 15 دقيقة. يكرر كل ساعتين.',
            'amount_to_use' => 'كمية طول إصبعين للوجه والرقبة',
            'warnings' => 'أعد الاستخدام بعد السباحة أو التعرق.',
            'priority' => 1,
            'is_essential' => true,
        ]);

        // --- Acne Treatment ---
        $p5 = Product::create([
            'category_id' => $serums->id,
            'name' => 'لـومينا جل علاج البثور السريع',
            'description' => 'جل شفاف يستهدف الحبوب النشطة ويقلل الالتهاب فوراً.',
            'price' => 95.00,
            'image_url' => 'https://example.com/images/acne-gel.jpg',
            'stock' => 45,
            'ingredients' => '2% حمض الساليسيليك، زيت شجرة الشاي',
        ]);

        ProductUsage::create([
            'product_id' => $p5->id,
            'suitable_for_skin_types' => 'Oily, Combination',
            'suitable_for_concerns' => 'breakouts, redness',
            'usage_frequency' => 'عند الحاجة',
            'usage_time' => 'مساءً',
            'how_to_use' => 'يوضع موضعياً على الحبة فقط ولا يوزع على كامل الوجه.',
            'amount_to_use' => 'نقطة صغيرة جداً',
            'warnings' => 'قد يسبب جفافاً في منطقة الحبة.',
            'priority' => 3,
            'is_essential' => false,
        ]);
    }
}
