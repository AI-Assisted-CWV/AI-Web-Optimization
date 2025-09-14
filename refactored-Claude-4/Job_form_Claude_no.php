<?php 
	
	require 'database.php';
	
	$saved = false;
	$errors = array();

	if (!empty($_POST)) {
		
		// Sanitize and validate input
		$name = isset($_POST['name']) ? trim($_POST['name']) : '';
		$bdate = isset($_POST['bdate']) ? $_POST['bdate'] : '';
		$education = isset($_POST['education']) ? intval($_POST['education']) : '';
		$speci = isset($_POST['speci']) ? trim($_POST['speci']) : '';
		$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
		$email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : '';
		$branch = isset($_POST['branch']) ? intval($_POST['branch']) : '';
		$ip = $_SERVER['REMOTE_ADDR'];
		
		// Validation
		if (empty($name)) $errors[] = 'الاسم مطلوب';
		if (empty($bdate)) $errors[] = 'تاريخ الميلاد مطلوب';
		if (empty($education) || $education < 1 || $education > 5) $errors[] = 'المؤهل العلمي مطلوب';
		if (empty($speci)) $errors[] = 'التخصص مطلوب';
		if (empty($phone)) $errors[] = 'رقم الهاتف مطلوب';
		if (!$email) $errors[] = 'البريد الإلكتروني غير صحيح';
		if (empty($branch) || $branch < 1 || $branch > 6) $errors[] = 'الفرع مطلوب';
		
		// File validation
		if (!isset($_FILES["cv"]) || $_FILES["cv"]["error"] !== UPLOAD_ERR_OK) {
			$errors[] = 'السيرة الذاتية مطلوبة';
		} else {
			$filename = $_FILES["cv"]["name"];
			$allowed_extensions = array('pdf', 'doc', 'docx');
			$extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
			
			if (!in_array($extension, $allowed_extensions)) {
				$errors[] = 'نوع الملف غير مدعوم. يرجى رفع ملف PDF أو DOC أو DOCX';
			}
			
			if ($_FILES["cv"]["size"] > 5 * 1024 * 1024) { // 5MB limit
				$errors[] = 'حجم الملف كبير جداً. الحد الأقصى 5 ميجابايت';
			}
		}
		
		// Insert data if valid
		if (empty($errors)) {
			try {
				$pdo = Database::connect();
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$sql = "INSERT INTO cv (name,bdate,education,speci,phone,email,branch,path,ip) VALUES (?, ?, ?, ?,?,?,?,?,?)";
				$q = $pdo->prepare($sql);
				$q->execute(array($name,$bdate,$education,$speci,$phone,$email,$branch,$extension,$ip));
				
				$newfilename = $pdo->lastInsertId() . "." . $extension;
				if (!is_dir("CV")) {
					mkdir("CV", 0755, true);
				}
				move_uploaded_file($_FILES["cv"]["tmp_name"], "CV/" . $newfilename);
				
				Database::disconnect();
				$saved = true;
			} catch (Exception $e) {
				$errors[] = 'حدث خطأ في حفظ البيانات. يرجى المحاولة مرة أخرى.';
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="طلب توظيف - النخبة التقنية العالمية. تقدم بطلب للعمل معنا في أحد فروعنا المختلفة">
    <meta name="keywords" content="توظيف, وظائف, النخبة التقنية, فلسطين, جنين">
    <meta name="author" content="النخبة التقنية العالمية">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph Tags -->
    <meta property="og:title" content="طلب توظيف - النخبة التقنية العالمية">
    <meta property="og:description" content="تقدم بطلب للعمل مع النخبة التقنية العالمية">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="ar_PS">
    
    <title>طلب توظيف - النخبة التقنية العالمية</title>
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css" as="style">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" as="style">
    
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/earlyaccess/droidarabickufi.css">
    
    <style>
        :root {
            --primary-color: #336699;
            --text-color: #000066;
            --bg-color: #ffffff;
            --border-color: #000000;
            --success-color: #28a745;
            --danger-color: #dc3545;
        }
        
        body {
            font-family: 'Droid Arabic Kufi', serif, 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
            direction: rtl;
        }
        
        .navbar {
            background-color: var(--primary-color) !important;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
            font-weight: bold;
        }
        
        .navbar-nav .nav-link:hover {
            color: #f8f9fa !important;
        }
        
        .carousel-container {
            max-height: 400px;
            overflow: hidden;
        }
        
        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }
        
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .form-label {
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: var(--text-color);
        }
        
        .form-control, .form-select {
            text-align: right;
            border: 2px solid #ddd;
            border-radius: 4px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-family: inherit;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(51, 102, 153, 0.25);
        }
        
        .btn-primary {
            background-color: var(--success-color);
            border-color: var(--success-color);
            padding: 0.75rem 2rem;
            font-weight: bold;
            border-radius: 4px;
        }
        
        .btn-secondary {
            padding: 0.75rem 2rem;
            font-weight: bold;
            border-radius: 4px;
        }
        
        .alert {
            border-radius: 4px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        
        .footer {
            background-color: #e6e6e6;
            color: var(--text-color);
            padding: 2rem;
            text-align: center;
            margin-top: 3rem;
            border-top: 1px solid #ddd;
        }
        
        .loading {
            display: none;
        }
        
        .was-validated .form-control:invalid,
        .was-validated .form-select:invalid {
            border-color: var(--danger-color);
        }
        
        .was-validated .form-control:valid,
        .was-validated .form-select:valid {
            border-color: var(--success-color);
        }
        
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: var(--text-color);
            color: white;
            padding: 8px;
            text-decoration: none;
            border-radius: 0 0 4px 4px;
            z-index: 1000;
        }
        
        .skip-link:focus {
            top: 0;
        }
        
        /* Optimize for LCP */
        .hero-image {
            width: 100%;
            height: auto;
            display: block;
        }
        
        /* Reduce CLS */
        .carousel {
            aspect-ratio: 16/9;
        }
        
        @media (max-width: 768px) {
            .form-container {
                margin: 1rem;
                padding: 1rem;
            }
            
            .carousel-item img {
                height: 250px;
            }
        }
        
        /* Print styles */
        @media print {
            .navbar, .carousel, .footer {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Skip Link for Accessibility -->
    <a href="#main-content" class="skip-link">الانتقال إلى المحتوى الرئيسي</a>
    
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" role="navigation" aria-label="التنقل الرئيسي">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">النخبة التقنية العالمية</a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="تبديل القائمة">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php" aria-label="الصفحة الرئيسية">البداية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.facebook.com/WorldTechnicalElite" target="_blank" 
                           rel="noopener noreferrer" aria-label="صفحة الفيسبوك">فيسبوك</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Application_form.php">طلب التحاق</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Job_form.php" aria-current="page">طلب توظيف</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="mail.php" target="_blank" rel="noopener noreferrer">البريد الإلكتروني</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="http://hrm.wt-elite.net" target="_blank" rel="noopener noreferrer">شؤون الموظفين</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            دبلوماتنا
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="programs/Decore.php">التصميم الداخلي والديكور</a></li>
                            <li><a class="dropdown-item" href="programs/Maintenance.php">الصيانة الشاملة</a></li>
                            <li><a class="dropdown-item" href="programs/Graphic.php">الجرافيك ديزاين</a></li>
                            <li><a class="dropdown-item" href="programs/Media.php">الصحافة والإعلام</a></li>
                            <li><a class="dropdown-item" href="programs/Tourist.php">السياحة والفندقة</a></li>
                            <li><a class="dropdown-item" href="programs/BAdministration.php">إدارة الأعمال</a></li>
                            <li><a class="dropdown-item" href="programs/Electricity.php">التركيبات الكهربائية</a></li>
                        </ul>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="https://wt-elite.net/login.php">تسجيل الدخول</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Carousel -->
    <div id="heroCarousel" class="carousel slide carousel-container" data-bs-ride="carousel" data-bs-interval="5000"
         style="margin-top: 56px;" role="region" aria-label="عرض الصور">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/slider/1.0.jpg" class="d-block hero-image" alt="النخبة التقنية العالمية - صورة رئيسية" 
                     loading="eager" fetchpriority="high">
            </div>
            <div class="carousel-item">
                <img src="images/slider/1.2.jpg" class="d-block hero-image" alt="النخبة التقنية العالمية - صورة ثانية" 
                     loading="lazy">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev"
                aria-label="الصورة السابقة">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next"
                aria-label="الصورة التالية">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </div>

    <!-- Main Content -->
    <main id="main-content" class="container mt-4" role="main">
        <div class="form-container">
            
            <!-- Success/Error Messages -->
            <?php if ($saved): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>تم حفظ البيانات بنجاح!</strong> شكراً لك على التقديم.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            <?php elseif (!empty($errors)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="إغلاق"></button>
                </div>
            <?php endif; ?>

            <!-- Page Title -->
            <?php if (!$saved): ?>
                <h1 class="text-center mb-4">طلب توظيف</h1>
            <?php endif; ?>

            <?php if (!$saved): ?>
            <!-- Job Application Form -->
            <form class="needs-validation" enctype="multipart/form-data" action="Job_form.php" method="post" 
                  id="jobForm" novalidate aria-label="نموذج طلب التوظيف">
                
                <div class="mb-3">
                    <label for="name" class="form-label">الاسم *</label>
                    <input type="text" class="form-control" id="name" name="name" required 
                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           aria-describedby="nameHelp">
                    <div class="invalid-feedback">يرجى إدخال الاسم</div>
                    <small id="nameHelp" class="form-text text-muted">أدخل الاسم الثلاثي كاملاً</small>
                </div>

                <div class="mb-3">
                    <label for="bdate" class="form-label">تاريخ الميلاد *</label>
                    <input type="date" class="form-control" id="bdate" name="bdate" required
                           value="<?php echo isset($_POST['bdate']) ? htmlspecialchars($_POST['bdate'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           max="<?php echo date('Y-m-d', strtotime('-18 years')); ?>">
                    <div class="invalid-feedback">يرجى إدخال تاريخ الميلاد</div>
                </div>

                <div class="mb-3">
                    <label for="education" class="form-label">المؤهل العلمي *</label>
                    <select class="form-select" id="education" name="education" required>
                        <option value="">اختر المؤهل العلمي</option>
                        <option value="1" <?php echo (isset($_POST['education']) && $_POST['education'] == '1') ? 'selected' : ''; ?>>دكتوراه</option>
                        <option value="2" <?php echo (isset($_POST['education']) && $_POST['education'] == '2') ? 'selected' : ''; ?>>ماجستير</option>
                        <option value="3" <?php echo (isset($_POST['education']) && $_POST['education'] == '3') ? 'selected' : ''; ?>>بكالوريوس</option>
                        <option value="4" <?php echo (isset($_POST['education']) && $_POST['education'] == '4') ? 'selected' : ''; ?>>دبلوم</option>
                        <option value="5" <?php echo (isset($_POST['education']) && $_POST['education'] == '5') ? 'selected' : ''; ?>>ثانوية عامة</option>
                    </select>
                    <div class="invalid-feedback">يرجى اختيار المؤهل العلمي</div>
                </div>

                <div class="mb-3">
                    <label for="speci" class="form-label">التخصص *</label>
                    <input type="text" class="form-control" id="speci" name="speci" required
                           value="<?php echo isset($_POST['speci']) ? htmlspecialchars($_POST['speci'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           aria-describedby="speciHelp">
                    <div class="invalid-feedback">يرجى إدخال التخصص</div>
                    <small id="speciHelp" class="form-text text-muted">مثال: هندسة الحاسوب، إدارة الأعمال</small>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">رقم الهاتف *</label>
                    <input type="tel" class="form-control" id="phone" name="phone" required
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           pattern="[0-9+\-\s\(\)]+" aria-describedby="phoneHelp">
                    <div class="invalid-feedback">يرجى إدخال رقم هاتف صحيح</div>
                    <small id="phoneHelp" class="form-text text-muted">مثال: 059-1234567</small>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">البريد الإلكتروني *</label>
                    <input type="email" class="form-control" id="email" name="email" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8') : ''; ?>"
                           aria-describedby="emailHelp">
                    <div class="invalid-feedback">يرجى إدخال بريد إلكتروني صحيح</div>
                    <small id="emailHelp" class="form-text text-muted">سنستخدم هذا البريد للتواصل معك</small>
                </div>

                <div class="mb-3">
                    <label for="branch" class="form-label">الفرع المفضل للعمل *</label>
                    <select class="form-select" id="branch" name="branch" required>
                        <option value="">اختر الفرع</option>
                        <option value="1" <?php echo (isset($_POST['branch']) && $_POST['branch'] == '1') ? 'selected' : ''; ?>>جنين</option>
                        <option value="2" <?php echo (isset($_POST['branch']) && $_POST['branch'] == '2') ? 'selected' : ''; ?>>رام الله</option>
                        <option value="3" <?php echo (isset($_POST['branch']) && $_POST['branch'] == '3') ? 'selected' : ''; ?>>نابلس</option>
                        <option value="4" <?php echo (isset($_POST['branch']) && $_POST['branch'] == '4') ? 'selected' : ''; ?>>الخليل</option>
                        <option value="5" <?php echo (isset($_POST['branch']) && $_POST['branch'] == '5') ? 'selected' : ''; ?>>طوباس</option>
                        <option value="6" <?php echo (isset($_POST['branch']) && $_POST['branch'] == '6') ? 'selected' : ''; ?>>يطا</option>
                    </select>
                    <div class="invalid-feedback">يرجى اختيار الفرع</div>
                </div>

                <div class="mb-4">
                    <label for="cv" class="form-label">السيرة الذاتية *</label>
                    <input type="file" class="form-control" id="cv" name="cv" required 
                           accept=".pdf,.doc,.docx" aria-describedby="cvHelp">
                    <div class="invalid-feedback">يرجى اختيار ملف السيرة الذاتية</div>
                    <small id="cvHelp" class="form-text text-muted">
                        الملفات المدعومة: PDF, DOC, DOCX (الحد الأقصى: 5 ميجابايت)
                    </small>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary me-3" id="submitBtn">
                        <span class="loading spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                        حفظ
                    </button>
                    <a class="btn btn-secondary" href="index.php">الرجوع للخلف</a>
                </div>
            </form>
            <?php else: ?>
                <div class="text-center">
                    <h2>شكراً لك!</h2>
                    <p>تم تسليم طلبك بنجاح. سنتواصل معك قريباً.</p>
                    <a class="btn btn-primary" href="index.php">العودة للرئيسية</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer" role="contentinfo">
        <div class="container">
            <strong>النخبة التقنية العالمية 2016 - <?php echo date('Y'); ?></strong><br>
            <a href="mailto:info@wt-elite.net">info@wt-elite.net</a>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" 
            crossorigin="anonymous"></script>
    
    <script>
        // Form validation and UX improvements
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('jobForm');
            const submitBtn = document.getElementById('submitBtn');
            
            if (form) {
                // Bootstrap validation
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    } else {
                        // Show loading state
                        submitBtn.disabled = true;
                        submitBtn.querySelector('.loading').style.display = 'inline-block';
                    }
                    form.classList.add('was-validated');
                }, false);
                
                // File size validation
                const fileInput = document.getElementById('cv');
                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file && file.size > 5 * 1024 * 1024) {
                        this.setCustomValidity('حجم الملف كبير جداً. الحد الأقصى 5 ميجابايت');
                    } else {
                        this.setCustomValidity('');
                    }
                });
                
                // Real-time validation feedback
                const inputs = form.querySelectorAll('input, select');
                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.checkValidity()) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        }
                    });
                });
            }
        });
        
        // Accessibility: Focus management
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                document.body.classList.add('keyboard-navigation');
            }
        });
        
        // Performance: Lazy load non-critical images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                });
            });
            
            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }
    </script>
    
    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "النخبة التقنية العالمية",
        "url": "https://wt-elite.net",
        "email": "info@wt-elite.net",
        "address": {
            "@type": "PostalAddress",
            "addressCountry": "PS",
            "addressLocality": "جنين"
        },
        "sameAs": [
            "https://www.facebook.com/WorldTechnicalElite"
        ]
    }
    </script>
</body>
</html>