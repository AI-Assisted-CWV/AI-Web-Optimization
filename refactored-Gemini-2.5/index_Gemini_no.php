<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>النخبة التقنية العالمية | مركز تدريب مهني في فلسطين</title>
    <meta name="description" content="النخبة التقنية العالمية: مركز تدريب مهني رائد في فلسطين يقدم دبلومات مهنية مصدقة من وزارة العمل في تخصصات مثل التصميم، الصيانة، وإدارة الأعمال. فروعنا في رام الله، جنين، نابلس، والمزيد.">
    <meta name="author" content="النخبة التقنية العالمية">
    <link rel="canonical" href="https://wt-elite.net/">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Droid+Arabic+Kufi&display=swap" rel="stylesheet">

    <style>
        /* --- General Reset & Base Styles --- */
        :root {
            --primary-color: #369;
            --dark-blue: #006;
            --text-color: #000;
            --light-gray: #E9E9E9;
            --white: #FFF;
            --border-color: #000;
            --footer-bg: #E6E6E6;
            --font-family-main: 'Droid Arabic Kufi', sans-serif;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family-main);
            background-color: #f0f0f0; /* Lighter background for the entire page */
            line-height: 1.8;
            color: var(--text-color);
            text-align: justify;
        }

        .container {
            width: 85%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: bold;
        }

        a:hover, a:focus-visible {
            text-decoration: underline;
            opacity: 0.8;
        }
        
        /* Use a consistent focus outline for accessibility */
        :focus-visible {
            outline: 3px solid var(--primary-color);
            outline-offset: 2px;
            border-radius: 4px;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }
        
        .icon {
            display: inline-block;
            width: 1.2em;
            height: 1.2em;
            vertical-align: middle;
            margin-inline-end: 8px;
        }

        /* --- Header & Navigation --- */
        .main-header {
            background-color: var(--white);
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .main-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .nav-links {
            display: none; /* Hidden by default on mobile */
            list-style: none;
            flex-direction: column; /* Stack vertically on mobile */
            width: 100%;
            position: absolute;
            top: 60px; /* Position below header */
            right: 0;
            background-color: var(--white);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .nav-links.active {
            display: flex;
        }

        .nav-links li a {
            display: block;
            padding: 15px 20px;
            color: var(--text-color);
            font-weight: bold;
            font-size: 16px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .nav-links li a:hover {
            background-color: #f8f8f8;
        }

        .dropdown {
            position: relative;
        }

        .dropdown-menu {
            display: none;
            list-style: none;
            background-color: var(--white);
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
            padding-right: 20px;
        }

        .dropdown:hover .dropdown-menu,
        .dropdown-toggle:focus + .dropdown-menu,
        .dropdown-menu:hover {
            display: block;
        }
        
        .nav-toggle {
            display: block; /* Visible on mobile */
            background: none;
            border: none;
            cursor: pointer;
            padding: 10px;
        }
        
        .nav-toggle .icon-bar {
            display: block;
            width: 22px;
            height: 2px;
            background-color: var(--text-color);
            border-radius: 1px;
            margin: 4px 0;
        }

        /* Desktop navigation styles */
        @media (min-width: 992px) {
            .nav-toggle { display: none; }
            .nav-links {
                display: flex;
                flex-direction: row;
                position: static;
                width: auto;
                box-shadow: none;
                background: none;
            }
            .nav-links li a { border-bottom: none; }
            .nav-links > li { margin-inline-start: 10px; }
            .dropdown-menu {
                position: absolute;
                top: 100%;
                right: 0;
                background-color: var(--white);
                min-width: 200px;
                z-index: 1001;
                padding: 0;
            }
            .dropdown-menu li a {
                padding: 12px 15px;
            }
        }

        /* --- Main Content --- */
        main {
            padding-top: 80px; /* Space for fixed header */
        }
        
        /* --- Carousel --- */
        .carousel {
            position: relative;
            overflow: hidden;
            width: 100%;
            aspect-ratio: 16 / 7; /* Prevent layout shift */
            background-color: #eee;
        }

        .carousel-inner {
            display: flex;
            height: 100%;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-item {
            min-width: 100%;
            height: 100%;
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .carousel-control {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background-color: rgba(0, 0, 0, 0.3);
            color: var(--white);
            border: none;
            cursor: pointer;
            padding: 15px;
            border-radius: 50%;
            z-index: 10;
        }
        .carousel-control.prev { left: 15px; }
        .carousel-control.next { right: 15px; }
        .carousel-control:hover { background-color: rgba(0, 0, 0, 0.6); }

        /* --- Page Layout & Panels --- */
        .page-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin-top: 2rem;
        }

        .main-content { flex: 2 1 50%; }
        .sidebar { flex: 1 1 25%; }
        
        @media (max-width: 991px) {
            .page-grid { flex-direction: column; }
        }

        .panel {
            background-color: var(--white);
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .panel-heading {
            background-color: var(--primary-color);
            color: var(--white);
            padding: 15px 20px;
            font-size: 1.2rem;
            border-bottom: 2px dashed var(--border-color);
        }

        .panel-body {
            padding: 20px;
        }

        /* --- Static Facebook Facade --- */
        .facebook-facade {
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 16px;
            text-align: center;
            background-color: #f7f8fa;
        }
        
        .facebook-facade h3 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }
        
        .facebook-facade p {
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: #666;
        }
        
        .facebook-facade .btn-facebook {
            display: inline-flex;
            align-items: center;
            background-color: #1877F2;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.2s;
        }
        
        .facebook-facade .btn-facebook:hover {
            background-color: #166fe5;
            text-decoration: none;
        }
        
        /* --- About Us Section --- */
        .about-us .logo {
            max-width: 100px;
            margin: 0 auto 1rem;
        }
        
        /* --- Branches Section --- */
        .branches-list {
            list-style: none;
        }
        .branches-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .branches-list li:last-child {
            border-bottom: none;
        }
        .branches-list strong {
            color: var(--primary-color);
        }

        /* --- Footer --- */
        .main-footer {
            background-color: var(--footer-bg);
            color: var(--text-color);
            text-align: center;
            padding: 2rem 1rem;
            margin-top: 2rem;
            border-top: 1px solid #ccc;
            font-size: 14px;
        }
        .main-footer a {
            color: var(--text-color);
        }

    </style>
</head>
<body>

    <header class="main-header">
        <nav class="main-nav" aria-label="Main Navigation">
            <a href="index.php" class="navbar-brand" style="font-weight:bold; font-size: 1.2rem;">النخبة التقنية العالمية</a>
            
            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation" aria-expanded="false" aria-controls="navLinks">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            
            <ul class="nav-links" id="navLinks">
                <li><a href="index.php"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8h5z"></path></svg>البداية</a></li>
                <li><a href="https://www.facebook.com/WorldTechnicalElite" target="_blank" rel="noopener noreferrer"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M22 12c0-5.52-4.48-10-10-10S2 6.48 2 12c0 4.84 3.44 8.87 8 9.8V15H8v-3h2V9.5C10 7.57 11.57 6 13.5 6H16v3h-1.5c-1 0-1.5.5-1.5 1.5V12h3l-.5 3h-2.5v6.8c4.56-.93 8-4.96 8-9.8z"></path></svg>فيسبوك</a></li>
                <li><a href="Application_form.php"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34a.9959.9959 0 00-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"></path></svg>طلب التحاق</a></li>
                <li><a href="Job_form.php"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>طلب توظيف</a></li>
                <li><a href="mail.php" target="_blank"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg>البريد الالكتروني</a></li>
                <li><a href="http://hrm.wt-elite.net" target="_blank"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>شؤون الموظفين</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" aria-haspopup="true">دبلوماتنا&nbsp;<span>▼</span></a>
                    <ul class="dropdown-menu">
                        <li><a href="programs/Decore.php">التصميم الداخلي والديكور</a></li>
                        <li><a href="programs/Maintenance.php">الصيانة الشاملة</a></li>
                        <li><a href="programs/Graphic.php">الجرافيك ديزاين</a></li>
                        <li><a href="programs/Media.php">الصحافة والإعلام</a></li>
                        <li><a href="programs/Tourist.php">السياحة والفندقة</a></li>
                        <li><a href="programs/BAdministration.php">إدارة الأعمال</a></li>
                        <li><a href="programs/Electricity.php">التركيبات الكهربائية</a></li>
                    </ul>
                </li>
                 <li><a href="https://wt-elite.net/login.php"><svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v-2h8v2zm0-4h-8v-2h8v2zm0-4h-8V9h8v2z"></path></svg>تسجيل الدخول</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        
        <section class="carousel" id="imageCarousel" aria-roledescription="carousel" aria-label="صور تعريفية">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/slider/1.0.jpg" alt="صورة تعريفية لمركز النخبة التقنية العالمية" width="1200" height="500" loading="eager">
                </div>
                <div class="carousel-item">
                    <img src="images/slider/1.2.jpg" alt="صورة تشجيعية لتعلم مهارة جديدة" width="1200" height="500" loading="lazy">
                </div>
            </div>
            <button class="carousel-control prev" aria-label="Previous Slide">❮</button>
            <button class="carousel-control next" aria-label="Next Slide">❯</button>
        </section>
        
        <hr style="margin: 2rem 0; border: 0; border-top: 1px solid #ddd;">
        
        <div class="page-grid">
            
            <section class="main-content" aria-labelledby="facebook-heading">
                <div class="facebook-facade">
<iframe
        loading="lazy"
        src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FWorldTechnicalElite&tabs=timeline&width=340&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false"
        width="340"
        height="500"
        style="border:none;overflow:hidden"
        scrolling="no"
        frameborder="0"
        allowfullscreen="true"
        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
        title="صفحة فيسبوك النخبة التقنية العالمية"
      ></iframe>
                </div>
            </section>

            <aside class="sidebar">
                <section class="panel about-us" aria-labelledby="about-us-heading">
                    <h2 class="panel-heading" id="about-us-heading">من نحن</h2>
                    <div class="panel-body">
                        <svg class="logo" viewBox="0 0 100 100" aria-label="شعار النخبة التقنية العالمية"><circle cx="50" cy="50" r="45" fill="#369"/><text x="50" y="60" font-size="30" fill="white" text-anchor="middle" font-family="sans-serif">WTE</text></svg>
                        <p>
                            النخبة التقنية العالمية هي احد أهم مراكز التدريب المهني في فلسطين, حيث تقدم النخبة مجموعة من برامج الدبلومات المهنية المصدقة من وزارة العمل الفلسطينية. تأسست النخبة لاتاحة الفرصة امام الشباب لاكتساب المهارات العلمية والفنية للدخول الى سوق العمل. وتعمل النخبة الان في سبع محافظات وهي: جنين، طوباس، نابلس، سلفيت، رام الله، الخليل، ويطا.
                        </p>
                    </div>
                </section>
            </aside>

        </div>

        <section class="panel" aria-labelledby="branches-heading">
            <h2 class="panel-heading" id="branches-heading">فروعنا</h2>
            <div class="panel-body">
                <ol class="branches-list">
                    <li><strong>رام الله:</strong> مقابل مسجد جمال عبد الناصر - مجمع الفهد التجاري الطابق السادس - <a href="tel:0592911116">0592911116</a></li>
                    <li><strong>جنين:</strong> مقابل النمر مول - مجمع الانيس - الطابق الخامس - <a href="tel:0592911154">0592911154</a></li>
                    <li><strong>نابلس:</strong> مجمع الصابر "ستي سنتر" - الطابق الثالث - <a href="tel:059291117">059291117</a> (الرقم غير مكتمل)</li>
                    <li><strong>الخليل:</strong> عين سارة - برج العز - الطابق الثالث - <a href="tel:059291118">059291118</a> (الرقم غير مكتمل)</li>
                    <li><strong>يطا:</strong> الرقعة -مجمع زمزم- الطابق الثالث - <a href="tel:059291115">059291115</a> (الرقم غير مكتمل)</li>
                    <li><strong>سلفيت:</strong> عمارة الزيتونة الطابق الارضي مقابل بنك فلسطين</li>
                </ol>
            </div>
        </section>

    </main>

    <footer class="main-footer">
        <p><strong>النخبة التقنية العالمية 2016 - 2025</strong></p>
        <address>
            <a href="mailto:info@wt-elite.net">
                <svg class="icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"></path></svg>
                info@wt-elite.net
            </a>
        </address>
    </footer>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Accessible Navigation Toggle ---
        const navToggle = document.getElementById('navToggle');
        const navLinks = document.getElementById('navLinks');

        if (navToggle && navLinks) {
            navToggle.addEventListener('click', () => {
                const isExpanded = navToggle.getAttribute('aria-expanded') === 'true';
                navToggle.setAttribute('aria-expanded', !isExpanded);
                navLinks.classList.toggle('active');
            });
        }

        // --- Lightweight & Accessible Carousel ---
        const carousel = document.getElementById('imageCarousel');
        if (carousel) {
            const carouselInner = carousel.querySelector('.carousel-inner');
            const items = carousel.querySelectorAll('.carousel-item');
            const prevButton = carousel.querySelector('.carousel-control.prev');
            const nextButton = carousel.querySelector('.carousel-control.next');
            let currentIndex = 0;
            const totalItems = items.length;

            function updateCarousel() {
                carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
                // Update active item for screen readers or future styling
                items.forEach((item, index) => {
                    item.classList.toggle('active', index === currentIndex);
                });
            }

            nextButton.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % totalItems;
                updateCarousel();
            });

            prevButton.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + totalItems) % totalItems;
                updateCarousel();
            });
            
            // Optional: Auto-play functionality
            setInterval(() => {
                nextButton.click();
            }, 5000);
        }
    });
    </script>

</body>
</html>