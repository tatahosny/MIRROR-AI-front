import {
  GestureRecognizer,
  FaceLandmarker,
  FilesetResolver,
  DrawingUtils
} from "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3";
import QRCode from 'qrcode';


const SETTINGS = {
  faceDetectionEnabled: true,
  showFaceGrid: true,
  handPicEnabled: true,
  smilePicEnabled: false,
  countdownSeconds: 3,
  showHandTracking: true,
  showGestureStatus: true
};

let gestureRecognizer;
let faceLandmarker;
let runningMode = "VIDEO";
let enableWebcamButton;
let webcamRunning = false;

const video = document.getElementById("webcam");
const canvasElement = document.getElementById("output_canvas");
const canvasCtx = canvasElement.getContext("2d");
const gestureOutput = document.getElementById("gesture_output");
const videoWrapper = document.getElementById("video-wrapper");
const loadingScreen = document.getElementById("loading-screen");

const virtualCursor = document.getElementById("virtual-cursor");
let lastClickTime = 0;
const CLICK_COOLDOWN = 1000;

function updateClock() {
  const clockEl = document.getElementById("mirror-clock");
  const dateEl = document.getElementById("mirror-date");
  if (!clockEl || !dateEl) return;

  const now = new Date();
  const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
  clockEl.innerText = now.toLocaleTimeString('ar-SA', timeOptions);

  const dateOptions = { weekday: 'long', month: 'long', day: 'numeric' };
  dateEl.innerText = now.toLocaleDateString('ar-SA', dateOptions);
}
setInterval(updateClock, 1000);
updateClock();

// MediaPipe
const createGestureRecognizer = async () => {
  const vision = await FilesetResolver.forVisionTasks(
    "https://cdn.jsdelivr.net/npm/@mediapipe/tasks-vision@0.10.3/wasm"
  );
  gestureRecognizer = await GestureRecognizer.createFromOptions(vision, {
    baseOptions: {
      modelAssetPath:
        "https://storage.googleapis.com/mediapipe-models/gesture_recognizer/gesture_recognizer/float16/1/gesture_recognizer.task",
      delegate: "GPU"
    },
    runningMode: runningMode
  });

  faceLandmarker = await FaceLandmarker.createFromOptions(vision, {
    baseOptions: {
      modelAssetPath: `https://storage.googleapis.com/mediapipe-models/face_landmarker/face_landmarker/float16/1/face_landmarker.task`,
      delegate: "GPU"
    },
    outputFaceBlendshapes: true,
    runningMode: runningMode,
    numFaces: 1
  });

  enableCam();
};
createGestureRecognizer();

function hasGetUserMedia() {
  return !!(navigator.mediaDevices && navigator.mediaDevices.getUserMedia);
}

if (!hasGetUserMedia()) {
  console.warn("getUserMedia() is not supported by your browser");
  alert("متصفحك لا يدعم الوصول للكاميرا.");
}

function enableCam() {
  if (!gestureRecognizer || !faceLandmarker) {
    return;
  }

  webcamRunning = true;
  loadingScreen.style.display = "none";
  videoWrapper.classList.remove("hidden");
  virtualCursor.style.display = "block";

  const constraints = {
    video: {
      width: 1920,
      height: 1080
    }
  };

  navigator.mediaDevices.getUserMedia(constraints).then(function (stream) {
    video.srcObject = stream;
    video.addEventListener("loadeddata", predictWebcam);
  }).catch((err) => {
    console.error("خطأ في الوصول للكاميرا:", err);
    alert("يرجى السماح بالوصول للكاميرا لتعمل المرآة الذكية.");
  });
}

let lastVideoTime = -1;
let results = undefined;
let faceResults = undefined;

let isFaceQualityGood = false;
let lastQualityCheckTime = 0;

let cursorX = window.innerWidth / 2;
let cursorY = window.innerHeight / 2;
let smoothedX = cursorX;
let smoothedY = cursorY;

async function predictWebcam() {
  const webcamElement = document.getElementById("webcam");
  let nowInMs = Date.now();
  const faceDetectionEnabled = SETTINGS.faceDetectionEnabled;

  if (video.currentTime !== lastVideoTime) {
    lastVideoTime = video.currentTime;
    results = gestureRecognizer.recognizeForVideo(video, nowInMs);
    if (faceDetectionEnabled && faceLandmarker) {
      faceResults = faceLandmarker.detectForVideo(video, nowInMs);
    } else {
      faceResults = undefined;
    }
  }

  if (webcamElement.videoWidth) {
    canvasElement.width = webcamElement.videoWidth;
    canvasElement.height = webcamElement.videoHeight;
  }

  canvasCtx.save();
  canvasCtx.clearRect(0, 0, canvasElement.width, canvasElement.height);
  const drawingUtils = new DrawingUtils(canvasCtx);

  if (results.landmarks && results.landmarks.length > 0) {
    if (SETTINGS.showHandTracking) {
      for (const landmarks of results.landmarks) {
        drawingUtils.drawConnectors(
          landmarks,
          GestureRecognizer.HAND_CONNECTIONS,
          { color: "#00FF00", lineWidth: 3 }
        );
        drawingUtils.drawLandmarks(landmarks, { color: "#FF0000", lineWidth: 1 });
      }
    }

    controlWebsite(results);
  }

  // Draw face landmarks
  if (faceResults && faceResults.faceLandmarks) {
    for (const landmarks of faceResults.faceLandmarks) {

      if (SETTINGS.showFaceGrid) {
        drawingUtils.drawConnectors(
          landmarks,
          FaceLandmarker.FACE_LANDMARKS_TESSELATION,
          { color: "rgba(255, 255, 255, 0.2)", lineWidth: 0.5 }
        );

        drawingUtils.drawConnectors(
          landmarks,
          FaceLandmarker.FACE_LANDMARKS_RIGHT_EYE,
          { color: "rgba(255, 255, 255, 0.4)", lineWidth: 1.5 }
        );
        drawingUtils.drawConnectors(
          landmarks,
          FaceLandmarker.FACE_LANDMARKS_RIGHT_EYEBROW,
          { color: "rgba(255, 255, 255, 0.4)", lineWidth: 1.5 }
        );
        drawingUtils.drawConnectors(
          landmarks,
          FaceLandmarker.FACE_LANDMARKS_LEFT_EYE,
          { color: "rgba(255, 255, 255, 0.4)", lineWidth: 1.5 }
        );
        drawingUtils.drawConnectors(
          landmarks,
          FaceLandmarker.FACE_LANDMARKS_LEFT_EYEBROW,
          { color: "rgba(255, 255, 255, 0.4)", lineWidth: 1.5 }
        );
        drawingUtils.drawConnectors(
          landmarks,
          FaceLandmarker.FACE_LANDMARKS_FACE_OVAL,
          { color: "rgba(255, 255, 255, 0.4)", lineWidth: 1.5 }
        );
      }
    }
  }

  // Update face quality warnings
  updateFaceQuality(faceResults);

  // Check for smile
  if (faceResults && faceResults.faceBlendshapes && faceResults.faceBlendshapes.length > 0) {
    let smileScore = 0;
    const blendShapes = faceResults.faceBlendshapes[0].categories;
    const mouthSmileLeft = blendShapes.find(shape => shape.categoryName === 'mouthSmileLeft');
    const mouthSmileRight = blendShapes.find(shape => shape.categoryName === 'mouthSmileRight');

    if (mouthSmileLeft && mouthSmileRight) {
      smileScore = (mouthSmileLeft.score + mouthSmileRight.score) / 2;
    }

    // Trigger picture if smile score is above threshold
    const smilePicEnabled = SETTINGS.smilePicEnabled;
    if (smileScore > 0.6 && smilePicEnabled) {
      takePicture();
    }
  }

  canvasCtx.restore();

  if (results.gestures && results.gestures.length > 0) {
    if (SETTINGS.showGestureStatus) {
      gestureOutput.style.display = "block";
      const categoryName = results.gestures[0][0].categoryName;
      gestureOutput.innerText = categoryName;
    } else {
      gestureOutput.style.display = "none";
    }
  } else {
    gestureOutput.style.display = "none";
  }

  if (webcamRunning === true) {
    window.requestAnimationFrame(predictWebcam);
  }
}

function controlWebsite(results) {
  const landmarks = results.landmarks[0];
  const gestures = results.gestures[0];
  const indexTip = landmarks[8];
  const thumbTip = landmarks[4];

  const targetX = (1 - indexTip.x) * window.innerWidth;
  const targetY = indexTip.y * window.innerHeight;

  smoothedX = smoothedX + (targetX - smoothedX) * 0.3;
  smoothedY = smoothedY + (targetY - smoothedY) * 0.3;

  virtualCursor.style.left = `${smoothedX}px`;
  virtualCursor.style.top = `${smoothedY}px`;

  const pinchDistance = Math.hypot(indexTip.x - thumbTip.x, indexTip.y - thumbTip.y);
  const isPinching = pinchDistance < 0.035; // click

  const now = Date.now();
  if (isPinching) {
    virtualCursor.classList.add("clicking");

    if (now - lastClickTime > CLICK_COOLDOWN) {
      const targetElement = document.elementFromPoint(smoothedX, smoothedY);
      if (targetElement) {
        if (typeof targetElement.click === 'function') {
          targetElement.click();
          console.log("تم النقر التفاعلي على:", targetElement);
        }
      }
      lastClickTime = now;
    }
  } else {
    virtualCursor.classList.remove("clicking");
  }

  if (gestures && gestures.length > 0) {
    const gestureName = gestures[0].categoryName;

    if (!isPinching) {
      if (gestureName === "Open_Palm") {
        const handPicEnabled = SETTINGS.handPicEnabled;
        if (handPicEnabled) {
          takePicture();
        }
      }
    }
  }
}

let lastPictureTime = 0;
const PICTURE_COOLDOWN = 5000;
let isTakingPicture = false;

function takePicture() {
  const now = Date.now();
  if (now - lastPictureTime < PICTURE_COOLDOWN || isTakingPicture) return;

  if (!isFaceQualityGood || isAnalyzing) {
    return; // لا تلتقط إن كانت الجودة سيئة أو إذا كان هناك تحليل قيد التنفيذ
  }

  lastPictureTime = now;
  isTakingPicture = true;

  let count = SETTINGS.countdownSeconds;
  if (isNaN(count) || count < 0) count = 0;

  if (count === 0) {
    captureFrame();
    isTakingPicture = false;
    return;
  }

  // Create countdown element
  const countdownEl = document.createElement("div");
  countdownEl.style.position = "fixed";
  countdownEl.style.top = "50%";
  countdownEl.style.left = "50%";
  countdownEl.style.transform = "translate(-50%, -50%)";
  countdownEl.style.fontSize = "10rem";
  countdownEl.style.color = "white";
  countdownEl.style.fontWeight = "bold";
  countdownEl.style.textShadow = "0px 0px 30px rgba(0,0,0,0.8)";
  countdownEl.style.zIndex = "10000";
  countdownEl.style.pointerEvents = "none";
  document.body.appendChild(countdownEl);

  countdownEl.innerText = count;

  const countdownInterval = setInterval(() => {
    count--;
    if (count > 0) {
      countdownEl.innerText = count;
    } else {
      clearInterval(countdownInterval);
      countdownEl.remove();
      captureFrame();
      isTakingPicture = false;
    }
  }, 1000);
}

function updateFaceQuality(currentFaceResults) {
  const warningPos = document.getElementById('warning-position');
  const warningAngle = document.getElementById('warning-angle');
  const warningLighting = document.getElementById('warning-lighting');

  if (!warningPos || !warningAngle || !warningLighting) return;

  const now = Date.now();
  if (now - lastQualityCheckTime < 250) return; // run max 4 times per second
  lastQualityCheckTime = now;

  if (!currentFaceResults || !currentFaceResults.faceLandmarks || currentFaceResults.faceLandmarks.length === 0) {
    warningPos.classList.remove('hidden');
    warningPos.querySelector('.alert-text').innerText = 'لم يتم العثور على وجه';
    warningPos.querySelector('.alert-icon').innerText = '👤';
    warningAngle.classList.add('hidden');
    warningLighting.classList.add('hidden');
    isFaceQualityGood = false;
    return;
  }

  const landmarks = currentFaceResults.faceLandmarks[0];

  // 1. Check Face Position
  let minX = 1, maxX = 0, minY = 1, maxY = 0;
  for (const lm of landmarks) {
    if (lm.x < minX) minX = lm.x;
    if (lm.x > maxX) maxX = lm.x;
    if (lm.y < minY) minY = lm.y;
    if (lm.y > maxY) maxY = lm.y;
  }

  const faceWidth = maxX - minX;
  const faceHeight = maxY - minY;
  const faceCenterX = minX + faceWidth / 2;
  const faceCenterY = minY + faceHeight / 2;

  let isPositionGood = true;
  if (faceCenterX < 0.35 || faceCenterX > 0.65 || faceCenterY < 0.35 || faceCenterY > 0.65) {
    isPositionGood = false;
    warningPos.querySelector('.alert-text').innerText = 'ضع وجهك في منتصف المرآة';
    warningPos.querySelector('.alert-icon').innerText = '📐';
  } else if (faceWidth < 0.15) {
    isPositionGood = false;
    warningPos.querySelector('.alert-text').innerText = 'اقترب أكثر من المرآة';
    warningPos.querySelector('.alert-icon').innerText = '🔍';
  } else if (faceWidth > 0.75) {
    isPositionGood = false;
    warningPos.querySelector('.alert-text').innerText = 'ابتعد قليلاً عن المرآة';
    warningPos.querySelector('.alert-icon').innerText = '🔙';
  }

  if (isPositionGood) {
    warningPos.classList.add('hidden');
  } else {
    warningPos.classList.remove('hidden');
  }

  // 2. Check Face Angle
  const nose = landmarks[1];
  const leftEye = landmarks[33];
  const rightEye = landmarks[263];

  const distLeft = Math.abs(nose.x - leftEye.x);
  const distRight = Math.abs(nose.x - rightEye.x);
  const ratio = distLeft / (distRight + 0.0001); // avoid division by zero

  const eyesY = (leftEye.y + rightEye.y) / 2;
  const noseToEyesY = nose.y - eyesY;
  const noseRatio = noseToEyesY / faceHeight;

  let isAngleGood = true;
  if (ratio < 0.5 || ratio > 2.0) {
    isAngleGood = false;
  } else if (noseRatio < 0.1 || noseRatio > 0.4) {
    isAngleGood = false;
  }

  if (isAngleGood) {
    warningAngle.classList.add('hidden');
  } else {
    warningAngle.classList.remove('hidden');
  }

  // 3. Check Lighting
  let isLightingGood = true;
  const videoEl = document.getElementById('webcam');
  if (videoEl && videoEl.videoWidth > 0) {
    const tempCanvas = document.createElement('canvas');
    tempCanvas.width = 64;
    tempCanvas.height = 64;
    const tCtx = tempCanvas.getContext('2d');
    tCtx.drawImage(videoEl, 0, 0, 64, 64);
    const imgData = tCtx.getImageData(0, 0, 64, 64).data;
    let sumB = 0;
    for (let i = 0; i < imgData.length; i += 4) {
      sumB += (0.2126 * imgData[i] + 0.7152 * imgData[i + 1] + 0.0722 * imgData[i + 2]);
    }
    const avgBrightness = sumB / (64 * 64);
    if (avgBrightness < 40) {
      isLightingGood = false;
      warningLighting.querySelector('.alert-text').innerText = 'الإضاءة منخفضة جداً';
      warningLighting.querySelector('.alert-icon').innerText = '🌑';
    } else if (avgBrightness > 230) {
      isLightingGood = false;
      warningLighting.querySelector('.alert-text').innerText = 'الإضاءة قوية جداً';
      warningLighting.querySelector('.alert-icon').innerText = '☀️';
    }
  }

  if (isLightingGood) {
    warningLighting.classList.add('hidden');
  } else {
    warningLighting.classList.remove('hidden');
  }

  isFaceQualityGood = isPositionGood && isAngleGood && isLightingGood;
}

function captureFrame() {
  const canvas = document.createElement("canvas");
  canvas.width = video.videoWidth;
  canvas.height = video.videoHeight;
  const ctx = canvas.getContext("2d");

  // Flip the image horizontally if the video is mirrored (which is common for webcams)
  ctx.translate(canvas.width, 0);
  ctx.scale(-1, 1);
  ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

  const dataURL = canvas.toDataURL("image/png");

  // تفعيل التحليل الذكي
  analyzeSkin(dataURL);

  const img = document.createElement("img");
  img.src = dataURL;
  img.style.width = "200px";
  img.style.borderRadius = "12px";
  img.style.border = "4px solid white";
  img.style.boxShadow = "0 8px 16px rgba(0,0,0,0.5)";

  const imgContainer = document.createElement("div");
  imgContainer.style.position = "relative";
  imgContainer.style.display = "inline-block";
  imgContainer.style.pointerEvents = "auto";
  imgContainer.style.transition = "transform 0.2s";

  const closeBtn = document.createElement("button");
  closeBtn.innerHTML = "×";
  closeBtn.title = "إزالة";
  closeBtn.style.position = "absolute";
  closeBtn.style.top = "0";
  closeBtn.style.right = "0";
  closeBtn.style.background = "#dc3545";
  closeBtn.style.color = "white";
  closeBtn.style.border = "none";
  closeBtn.style.borderRadius = "50%";
  closeBtn.style.width = "30px";
  closeBtn.style.height = "30px";
  closeBtn.style.cursor = "pointer";
  closeBtn.style.fontSize = "20px";
  closeBtn.style.lineHeight = "1";
  closeBtn.style.display = "flex";
  closeBtn.style.alignItems = "center";
  closeBtn.style.justifyContent = "center";
  closeBtn.style.boxShadow = "0 2px 4px rgba(0,0,0,0.2)";

  closeBtn.onclick = () => {
    imgContainer.style.transform = "scale(0)";
    setTimeout(() => imgContainer.remove(), 200);
  };

  imgContainer.appendChild(img);
  imgContainer.appendChild(closeBtn);

  const photosContainer = document.getElementById("captured-photos");
  if (photosContainer) {
    photosContainer.appendChild(imgContainer);
    photosContainer.scrollTop = photosContainer.scrollHeight;
  }

  const flash = document.createElement("div");
  flash.style.position = "fixed";
  flash.style.top = "0";
  flash.style.left = "0";
  flash.style.width = "100%";
  flash.style.height = "100%";
  flash.style.backgroundColor = "white";
  flash.style.zIndex = "9999";
  flash.style.opacity = "0.8";
  flash.style.transition = "opacity 0.5s ease-out";
  flash.style.pointerEvents = "none";
  document.body.appendChild(flash);

  setTimeout(() => {
    flash.style.opacity = "0";
    setTimeout(() => flash.remove(), 500);
  }, 100);
}

// --- Skin Analysis & Sidebar Logic ---

let isAnalyzing = false;
const analysisSidebar = document.getElementById("analysis-sidebar");
const closeSidebarBtn = document.getElementById("close-sidebar");
const analysisSummary = document.getElementById("analysis-summary");
const analysisLoading = document.getElementById("analysis-loading");
const analysisResults = document.getElementById("analysis-results");
const resultSkinType = document.getElementById("result-skin-type");
const scoresGrid = document.getElementById("scores-grid");
const concernsModal = document.getElementById("concerns-modal");
const concernsBody = document.getElementById("concerns-body");
const viewDetailsBtn = document.getElementById("view-details-btn");
const closeModalBtn = document.getElementById("close-modal");

let currentConcernsData = null;

if (closeSidebarBtn) {
  closeSidebarBtn.onclick = () => {
    analysisSidebar.classList.remove("open");
  };
}

if (viewDetailsBtn) {
  viewDetailsBtn.onclick = () => {
    if (currentConcernsData) {
      populateConcernsModal(currentConcernsData);
      concernsModal.classList.remove("hidden");
    }
  };
}

if (closeModalBtn) {
  closeModalBtn.onclick = () => {
    concernsModal.classList.add("hidden");
  };
}

// Close modal on backdrop click
document.querySelector(".modal-backdrop")?.addEventListener("click", () => {
  concernsModal.classList.add("hidden");
});

async function analyzeSkin(imageData) {
  isAnalyzing = true;

  // Reset and show sidebar
  analysisSidebar.classList.add("open");
  analysisSummary.innerText = "";
  analysisLoading.classList.remove("hidden");
  analysisResults.classList.add("hidden");
  scoresGrid.innerHTML = "";

  try {
    // Convert base64/DataURL to Blob for FormData
    const response_blob = await fetch(imageData);
    const blob = await response_blob.blob();

    const formData = new FormData();
    formData.append("image", blob, "capture.png");

    const response = await fetch("/api/skin-analysis", {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.content
      },
      body: formData
    });

    if (!response.ok) {
      const errorData = await response.json();
      throw new Error(errorData.message || "فشل الاتصال بالخادم");
    }

    const data = await response.json();
    const analysis = data.data; // SkinAnalysisResource wrapper
    currentAnalysisUuid = analysis.uuid;


    // Update UI with results
    let displayText = analysis.summary || "";
    if (analysis.sensitivity_note) {
      displayText += "\n\n**ملاحظة الحساسية:** " + analysis.sensitivity_note;
    }
    analysisSummary.innerText = displayText;
    analysisLoading.classList.add("hidden");

    currentConcernsData = analysis.concerns || null;

    displayFinalResults({
      skin_type: analysis.skin_type,
      global_scores: analysis.global_scores
    });

  } catch (error) {
    console.error("Skin Analysis Error:", error);
    analysisSummary.innerText = "حدث خطأ أثناء التحليل: " + error.message;
    analysisLoading.classList.add("hidden");
  } finally {
    isAnalyzing = false;
  }
}

let currentAnalysisUuid = null;

const sendAnalysisBtn = document.getElementById("send-analysis-btn");
const qrModal = document.getElementById("qr-modal");
const closeQrModalBtn = document.getElementById("close-qr-modal");

if (sendAnalysisBtn) {
  sendAnalysisBtn.onclick = async () => {
    if (!currentAnalysisUuid) {
        alert("يرجى إجراء تحليل أولاً");
        return;
    }

    const portalUrl = `${window.location.origin}/login?analysis_uuid=${currentAnalysisUuid}`;
    
    // Generate QR Code
    const qrContainer = document.getElementById('qrcode');
    qrContainer.innerHTML = '';
    
    try {
        const qrDataUrl = await QRCode.toDataURL(portalUrl, {
            width: 300,
            margin: 2,
            color: {
                dark: '#000000',
                light: '#ffffff'
            }
        });
        
        const img = document.createElement('img');
        img.src = qrDataUrl;
        qrContainer.appendChild(img);
        
        qrModal.classList.remove('hidden');
    } catch (err) {
        console.error("QR Error", err);
    }
  };
}

if (closeQrModalBtn) {
    closeQrModalBtn.onclick = () => {
        qrModal.classList.add('hidden');
    };
}


function displayFinalResults(data) {
  analysisResults.classList.remove("hidden");

  const typeTranslations = {
    'Normal': 'طبيعية',
    'Dry': 'جافة',
    'Oily': 'دهنية',
    'Combination': 'مختلطة',
    'Sensitive': 'حساسة'
  };

  resultSkinType.innerText = typeTranslations[data.skin_type] || data.skin_type || "غير محدد";

  if (data.global_scores) {
    scoresGrid.innerHTML = "";
    Object.entries(data.global_scores).forEach(([key, score]) => {
      const card = document.createElement("div");
      card.className = "score-card";
      card.innerHTML = `
        <div class="score-info">
          <span>${translateScoreKey(key)}</span>
          <span>${score}%</span>
        </div>
        <div class="score-bar-bg">
          <div class="score-bar-fill" style="width: 0%"></div>
        </div>
      `;
      scoresGrid.appendChild(card);

      // Animate bar
      setTimeout(() => {
        card.querySelector(".score-bar-fill").style.width = `${score}%`;
      }, 100);
    });
  }
}

function translateScoreKey(key) {
  const translations = {
    'hydration': 'الترطيب',
    'smoothness': 'النعومة',
    'radiance': 'النضارة',
    'sebum_balance': 'توازن الدهون',
    'pore_clarity': 'نقاء المسام'
  };
  return translations[key] || key;
}

function populateConcernsModal(concerns) {
  concernsBody.innerHTML = "";

  const concernTitles = {
    'breakouts': 'البثور وحب الشباب',
    'pigmentation': 'التصبغات والبقع',
    'redness': 'الاحمرار والتهيج',
    'aging': 'علامات التقدم في السن',
    'under_eye': 'منطقة حول العين'
  };

  Object.entries(concerns).forEach(([key, data]) => {
    if (key === 'sensitivity_note') return;
    if (data.detected) {
      const item = document.createElement("div");
      item.className = "concern-item";
      item.innerHTML = `
        <h4>${concernTitles[key] || key}</h4>
        <p class="concern-desc">${data.clinical_description}</p>
        <p class="concern-desc"><strong>الملاحظات:</strong> ${data.specific_observations}</p>
        <div class="concern-meta">
          <span class="severity-tag">شدة الحالة: ${Math.round(data.severity * 100)}%</span>
          <span>مستوى الثقة: ${Math.round(data.confidence * 100)}%</span>
        </div>
      `;
      concernsBody.appendChild(item);
    }
  });

  if (concernsBody.innerHTML === "") {
    concernsBody.innerHTML = "<p style='text-align:center;'>لم يتم اكتشاف مشاكل جلدية واضحة في هذا التحليل. 🎉</p>";
  }
}

