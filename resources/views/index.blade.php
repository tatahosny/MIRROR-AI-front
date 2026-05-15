<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>المرآة الذكية</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap"
        rel="stylesheet">
    <link
        href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css"
        rel="stylesheet">
    <script
        src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
    @vite(['resources/css/style.css', 'resources/js/main.js'])
</head>

<body>
    <!-- مؤشر الماوس الوهمي (اختياري لكن مفيد للتفاعل مع المرآة) -->
    <div id="virtual-cursor" class="virtual-cursor"></div>

    <div id="camera-container">
        <div id="liveView" class="videoView">
            <!-- Loading Screen -->
            <div class="loading-screen" id="loading-screen">
                <div class="spinner"></div>
                <p>جاري التحميل...</p>
            </div>

            <div id="video-wrapper" class="hidden">
                <video id="webcam" autoplay playsinline></video>
                <canvas class="output_canvas" id="output_canvas"></canvas>

                <div class="mirror-overlay">
                    <!-- عناصر المرآة الذكية مثل الوقت والتاريخ والطقس (مستقبلاً) -->
                    <div class="mirror-header">
                        <div class="clock" id="mirror-clock">12:00</div>
                        <div class="date" id="mirror-date">الأحد، 1
                            يناير</div>
                    </div>

                    <p id='gesture_output' class="output"></p>
                </div>

                <!-- Quality Warnings Overlay (Centered Alerts) -->
                <div id="quality-warnings" class="center-warnings">
                    <div id="warning-lighting" class="center-alert hidden">
                        <span class="alert-icon">💡</span>
                        <span class="alert-text">إضاءة غير مناسبة</span>
                    </div>
                    <div id="warning-angle" class="center-alert hidden">
                        <span class="alert-icon">👤</span>
                        <span class="alert-text">يرجى النظر للمرآة</span>
                    </div>
                    <div id="warning-position" class="center-alert hidden">
                        <span class="alert-icon">📐</span>
                        <span class="alert-text">اضبط المسافة</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- معرض الصور الملتقطة -->
    <div id="captured-photos" class="captured-photos"></div>

    <!-- Sidebar للتحليل الذكي -->
    <div id="analysis-sidebar" class="analysis-sidebar">
        <div class="sidebar-header">
            <h3>تحليل البشرة ✨</h3>
            <button id="close-sidebar" class="close-btn">×</button>
        </div>

        <div class="sidebar-content">
            <div id="analysis-loading" class="analysis-item hidden">
                <div class="mini-spinner"></div>
                <p>جاري التحليل البشرة...</p>
            </div>

            <div id="analysis-text-container" class="analysis-item">
                <p id="analysis-summary" class="typing-text"></p>
            </div>

            <div id="analysis-results" class="analysis-item hidden">
                <div class="skin-type-badge">
                    <span>نوع البشرة:</span>
                    <strong id="result-skin-type">-</strong>
                </div>

                <div class="scores-grid" id="scores-grid">
                    <!-- ستضاف السكورات هنا برمجياً -->
                </div>

                <div class="details-section">
                    <button id="view-details-btn" class="details-btn">عرض التفاصيل التحليلية 📊</button>
                    <button id="send-analysis-btn" class="details-btn send-btn mt-2">ارسال الصورة ومتابعة التحليل 📲</button>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div id="qr-modal" class="concerns-modal hidden">
        <div class="modal-backdrop"></div>
        <div class="modal-container qr-container">
            <div class="modal-header">
                <h3>امسح الكود للمتابعة 🤳</h3>
                <button id="close-qr-modal" class="close-btn">×</button>
            </div>
            <div class="modal-body text-center">
                <p class="mb-4">سيتم نقلك إلى لوحة التحكم الخاصة بك لمتابعة حالة بشرتك</p>
                <div id="qrcode" class="flex justify-center mb-6"></div>
                <p class="text-sm text-zinc-500">يمكنك تسجيل الدخول أو إنشاء حساب جديد</p>
            </div>
        </div>
    </div>


    <!-- Modal لتفاصيل المشاكل المكتشفة -->
    <div id="concerns-modal" class="concerns-modal hidden">
        <div class="modal-backdrop"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h3>التفاصيل الجلدية المكتشفة 🩺</h3>
                <button id="close-modal" class="close-btn">×</button>
            </div>
            <div id="concerns-body" class="modal-body">
                <!-- ستضاف التفاصيل هنا برمجياً -->
            </div>
        </div>
    </div>

    <!-- Hidden elements required by existing JS -->
    <button id="toggle-camera-btn" style="display:none;"></button>
    <div id="video-blend-shapes" style="display:none;"></div>
</body>

</html>
