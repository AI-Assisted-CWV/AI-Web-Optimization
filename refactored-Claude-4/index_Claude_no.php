<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>النخبة التقنية العالمية - مركز التدريب المهني الرائد في فلسطين</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="النخبة التقنية العالمية - مركز التدريب المهني الرائد في فلسطين. دبلومات مهنية معتمدة في التصميم، الصيانة، الجرافيك، الإعلام، السياحة وإدارة الأعمال">
    <meta name="keywords" content="تدريب مهني، دبلومات، فلسطين، تصميم داخلي، جرافيك ديزاين، صيانة، سياحة، إدارة أعمال">
    <meta name="robots" content="index, follow">
    <meta name="author" content="النخبة التقنية العالمية">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="النخبة التقنية العالمية">
    <meta property="og:description" content="مركز التدريب المهني الرائد في فلسطين - دبلومات مهنية معتمدة">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_AR">
    
    <!-- Preconnect to external domains for faster loading -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://connect.facebook.net">
    <link rel="preconnect" href="https://pagead2.googlesyndication.com">
    
    <!-- Critical CSS - Inlined for LCP optimization -->
    <style>
        /* Critical Above-the-fold CSS */
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Arial, sans-serif;
            margin: 0;
            padding: 0;
            line-height: 1.6;
            color: #333;
            background-color: #fff;
        }
        
        .container-fluid {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            text-align: justify;
            direction: rtl;
        }
        
        /* Navbar Styles */
        .navbar {
            background-color: #336699;
            padding: 0.5rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        .navbar-brand {
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            text-decoration: none;
        }
        
        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 1rem;
        }
        
        .navbar-nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.3s ease;
            font-weight: bold;
        }
        
        .navbar-nav a:hover, .navbar-nav a:focus {
            background-color: rgba(255,255,255,0.2);
        }
        
        .mobile-menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.5rem;
            cursor: pointer;
        }
        
        /* Carousel Styles */
        .carousel {
            margin-top: 70px;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .carousel img {
            width: 100%;
            height: auto;
            max-height: 400px;
            object-fit: cover;
            display: block;
        }
        
        /* Panel Styles */
        .panel {
            background-color: #fff;
            border: 2px solid #336699;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .panel-heading {
            background-color: #336699;
            color: #fff;
            padding: 1rem;
            font-weight: bold;
            border-radius: 6px 6px 0 0;
            border-bottom: 2px dashed #000;
        }
        
        .panel-body {
            padding: 1.5rem;
            color: #000;
            line-height: 1.8;
        }
        
        /* Grid System */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -0.75rem;
        }
        
        .col {
            flex: 1;
            padding: 0.75rem;
        }
        
        .col-sm-12 { width: 100%; }
        .col-md-3 { width: 25%; }
        .col-md-6 { width: 50%; }
        
        /* Skip Link for Accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #000;
            color: #fff;
            padding: 8px;
            text-decoration: none;
            z-index: 100;
        }
        
        .skip-link:focus {
            top: 6px;
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .container-fluid {
                width: 95%;
            }
            
            .navbar-nav {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background-color: #336699;
                padding: 1rem;
            }
            
            .navbar-nav.active {
                display: flex;
            }
            
            .mobile-menu-toggle {
                display: block;
            }
            
            .col-md-3, .col-md-6 {
                width: 100%;
            }
            
            .row {
                flex-direction: column;
            }
        }
    </style>
    
    <!-- Structured Data for SEO -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "EducationalOrganization",
        "name": "النخبة التقنية العالمية",
        "description": "مركز التدريب المهني الرائد في فلسطين",
        "url": "https://wt-elite.net",
        "sameAs": [
            "https://www.facebook.com/WorldTechnicalElite"
        ],
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "PS",
            "addressRegion": "West Bank"
        },
        "contactPoint": {
            "@type": "ContactPoint",
            "email": "info@wt-elite.net",
            "contactType": "customer service"
        }
    }
    </script>
</head>

<body>
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link">انتقل إلى المحتوى الرئيسي</a>
    
    <!-- Navigation -->
    <nav class="navbar" role="navigation" aria-label="التنقل الرئيسي">
        <div class="navbar-container">
            <a href="/" class="navbar-brand" aria-label="الصفحة الرئيسية">النخبة التقنية</a>
            
            <button class="mobile-menu-toggle" aria-label="فتح القائمة" aria-expanded="false" aria-controls="navbar-menu">
                ☰
            </button>
            
            <ul class="navbar-nav" id="navbar-menu" role="menubar">
                <li role="none"><a href="index.php" role="menuitem">البداية</a></li>
                <li role="none"><a href="https://www.facebook.com/WorldTechnicalElite" target="_blank" rel="noopener" role="menuitem">فيسبوك</a></li>
                <li role="none"><a href="Application_form.php" role="menuitem">طلب التحاق</a></li>
                <li role="none"><a href="Job_form.php" role="menuitem">طلب توظيف</a></li>
                <li role="none"><a href="mail.php" role="menuitem">البريد الإلكتروني</a></li>
                <li role="none"><a href="http://hrm.wt-elite.net" target="_blank" rel="noopener" role="menuitem">شؤون الموظفين</a></li>
                <li role="none"><a href="https://wt-elite.net/login.php" role="menuitem">تسجيل الدخول</a></li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <!-- Main Content -->
        <main id="main-content">
            <!-- Image Carousel -->
            <section class="carousel" aria-label="صور المعهد">
                <img src="images/slider/1.0.jpg" 
                     alt="شعار النخبة التقنية العالمية" 
                     width="800" 
                     height="400" 
                     loading="eager">
            </section>

            <!-- Facebook Integration Placeholder -->
            <section aria-label="وسائل التواصل الاجتماعي">
                <div class="row">
                    <div class="col col-md-6">
                        <div class="panel">
                            <div class="panel-heading">
                                <strong>تابعونا على فيسبوك</strong>
                            </div>
                            <div class="panel-body">
                                <div style="position:relative; width:100%; height:0; padding-bottom:147.06%;">
        <iframe
          loading="lazy"
          src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FWorldTechnicalElite&tabs=timeline&height=500&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false"
          style="border:none; overflow:hidden; position:absolute; top:0; left:0; width:100%; height:100%;"
          scrolling="no"
          frameborder="0"
          allowfullscreen="true"
          allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
          title="صفحة فيسبوك النخبة التقنية العالمية"
        ></iframe>
      </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col col-md-3">
                        <div class="panel">
                            <div class="panel-heading">
                                <strong>من نحن</strong>
                            </div>
                            <div class="panel-body">
                                <div style="text-align:center; margin-bottom: 1rem;">
                                    <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='64' height='64'%3E%3Ccircle cx='32' cy='32' r='30' fill='%23336699'/%3E%3Ctext x='50%25' y='50%25' font-size='24' fill='white' text-anchor='middle' dy='.3em'%3E🏛️%3C/text%3E%3C/svg%3E" 
                                         alt="شعار المعهد" 
                                         width="64" 
                                         height="64"
                                         loading="lazy">
                                </div>
                                <p>
                                    النخبة التقنية العالمية هي أحد أهم مراكز التدريب المهني في فلسطين، حيث تقدم النخبة مجموعة من برامج الدبلومات المهنية المصدقة من وزارة العمل الفلسطينية. حيث تأسست النخبة لإتاحة الفرصة أمام الشباب لاكتساب المهارات العلمية والفنية للدخول إلى سوق العمل. وتعمل النخبة الآن في سبع محافظات وهي: جنين، طوباس، نابلس، سلفيت، رام الله، الخليل، يطا.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Branches Section -->
            <section>
                <div class="row">
                    <div class="col col-sm-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <strong>فروعنا</strong>
                            </div>
                            <div class="panel-body">
                                <ol>
                                    <li><strong>رام الله</strong>: مقابل مسجد جمال عبد الناصر - مجمع الفهد التجاري الطابق السادس - 0592911116</li>
                                    <li><strong>جنين</strong>: مقابل النمر مول - مجمع الأنيس - الطابق الخامس - 0592911154</li>
                                    <li><strong>نابلس</strong>: مجمع الصابر "ستي سنتر" - الطابق الثالث - 059291117</li>
                                    <li><strong>الخليل</strong>: عين سارة - برج العز - الطابق الثالث - 059291118</li>
                                    <li><strong>يطا</strong>: الرقعة - مجمع زمزم - الطابق الثالث - 059291115</li>
                                    <li><strong>سلفيت</strong>: عمارة الزيتونة الطابق الأرضي مقابل بنك فلسطين</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Programs Section -->
            <section>
                <div class="row">
                    <div class="col col-sm-12">
                        <div class="panel">
                            <div class="panel-heading">
                                <strong>برامجنا التدريبية</strong>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col col-md-6">
                                        <ul>
                                            <li><a href="programs/Decore.php">التصميم الداخلي والديكور</a></li>
                                            <li><a href="programs/Maintenance.php">الصيانة الشاملة</a></li>
                                            <li><a href="programs/Graphic.php">الجرافيك ديزاين</a></li>
                                            <li><a href="programs/Media.php">الصحافة والإعلام</a></li>
                                        </ul>
                                    </div>
                                    <div class="col col-md-6">
                                        <ul>
                                            <li><a href="programs/Tourist.php">السياحة والفندقة</a></li>
                                            <li><a href="programs/BAdministration.php">إدارة الأعمال</a></li>
                                            <li><a href="programs/Electricity.php">التركيبات الكهربائية</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <!-- Footer -->
        <footer class="panel" style="background-color: #f0f0f0; text-align: center; margin-top: 2rem;">
            <div class="panel-body">
                <strong>النخبة التقنية العالمية 2016 - 2024</strong><br>
                <a href="mailto:info@wt-elite.net">info@wt-elite.net</a>
            </div>
        </footer>
    </div>

    <!-- JavaScript for Mobile Menu and Performance -->
    <script>
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.querySelector('.mobile-menu-toggle');
            const navMenu = document.querySelector('.navbar-nav');
            
            if (menuToggle && navMenu) {
                menuToggle.addEventListener('click', function() {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    navMenu.classList.toggle('active');
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.navbar-container')) {
                    navMenu.classList.remove('active');
                    menuToggle.setAttribute('aria-expanded', 'false');
                }
            });

            // Lazy load external resources after page load
            setTimeout(function() {
                // Load Google Font
                const fontLink = document.createElement('link');
                fontLink.href = 'https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&display=swap';
                fontLink.rel = 'stylesheet';
                document.head.appendChild(fontLink);

                // Apply font after loading
                fontLink.onload = function() {
                    document.body.style.fontFamily = "'Amiri', 'Segoe UI', Tahoma, Arial, sans-serif";
                };
            }, 100);
        });

        // Performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const perfData = performance.getEntriesByType('navigation')[0];
                    if (perfData) {
                        console.log('LCP (estimated):', perfData.loadEventEnd - perfData.fetchStart, 'ms');
                    }
                }, 0);
            });
        }

        // Intersection Observer for animations (CLS prevention)
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, { threshold: 0.1 });

            // Observe panels for smooth animations
            document.querySelectorAll('.panel').forEach(function(panel) {
                panel.style.opacity = '0';
                panel.style.transform = 'translateY(20px)';
                panel.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(panel);
            });
        }
    </script>
</body>
</html>