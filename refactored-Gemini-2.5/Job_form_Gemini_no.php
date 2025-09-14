<?php

// A single variable to hold the state of our application (e.g., form status, errors).
$response = [
    'is_submitted' => false,
    'success' => false,
    'message' => '',
    'errors' => []
];

// --- Form Processing Logic ---
// Process the form only if the request method is POST.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response['is_submitted'] = true;

    // --- 1. Retrieve and Sanitize POST Values ---
    // Use the ternary operator with isset() for cleaner default value assignment in PHP 5.5.
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $bdate = isset($_POST['bdate']) ? $_POST['bdate'] : '';
    $education = isset($_POST['education']) ? $_POST['education'] : '';
    $speci = isset($_POST['speci']) ? $_POST['speci'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $branch = isset($_POST['branch']) ? $_POST['branch'] : '';
    // The 'path' variable appears to be unused for file saving after this line
    // but relies on $_POST['name'] which might be empty.
    // Consider how you intend to use 'path' and if it needs to be set only after validation.
    $path = 'cv\\' . $name; 
    $ip = $_SERVER['REMOTE_ADDR'];

    // --- 2. Server-Side Validation ---
    // A robust validation process is crucial for security and data integrity.
    if (empty($name)) { $response['errors']['name'] = 'الاسم مطلوب.'; }
    if (empty($bdate)) { $response['errors']['bdate'] = 'تاريخ الميلاد مطلوب.'; }
    if (empty($education)) { $response['errors']['education'] = 'المؤهل العلمي مطلوب.'; }
    if (empty($speci)) { $response['errors']['speci'] = 'التخصص مطلوب.'; }
    if (empty($phone)) { $response['errors']['phone'] = 'رقم الهاتف مطلوب.'; }
    // Ensure email is not empty before validating as a filter.
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $response['errors']['email'] = 'البريد الإلكتروني غير صالح.'; }
    if (empty($branch)) { $response['errors']['branch'] = 'الفرع مطلوب.'; }

    // --- 3. Secure File Upload Validation ---
    if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
        $cv_file = $_FILES['cv'];
        $file_size = $cv_file['size'];
        $file_tmp_name = $cv_file['tmp_name'];

        // a. Check file size (e.g., max 5MB)
        if ($file_size > 5 * 1024 * 1024) {
            $response['errors']['cv'] = 'يجب أن يكون حجم الملف أقل من 5 ميغابايت.';
        }

        // b. Check MIME type (more reliable than extension)
        // Ensure the fileinfo extension is enabled in php.ini
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo) {
            $mime_type = finfo_file($finfo, $file_tmp_name);
            $allowed_mime_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            if (!in_array($mime_type, $allowed_mime_types)) {
                $response['errors']['cv'] = 'نوع الملف غير مسموح به. يرجى إرفاق ملف PDF أو DOCX.';
            }
            finfo_close($finfo);
        } else {
            $response['errors']['cv'] = 'خطأ في تهيئة التحقق من نوع الملف.'; // Fileinfo extension not enabled
        }
    } else {
        $response['errors']['cv'] = 'إرفاق السيرة الذاتية مطلوب.';
    }

    // --- 4. Process Data if Validation Passes ---
    if (empty($response['errors'])) {
        try {
            // Include database configuration (ensure this file is secure and outside the web root)
            require 'database.php';

            // Extract original file extension
            $original_filename = basename($_FILES["cv"]["name"]);
            $extension = pathinfo($original_filename, PATHINFO_EXTENSION);

            // Connect to the database
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Prepared statements prevent SQL injection attacks.
            $sql = "INSERT INTO cv (name, bdate, education, speci, phone, email, branch, path, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $q = $pdo->prepare($sql);
            // The extension is stored in the DB, not the full path.
            $q->execute([$name, $bdate, $education, $speci, $phone, $email, $branch, $extension, $ip]);

            // --- Secure File Handling ---
            // Create a new, unique, and sanitized filename for security.
            $last_id = $pdo->lastInsertId();
            $new_filename = "cv_" . $last_id . "_" . uniqid() . "." . $extension;
            $upload_path = "CV/" . $new_filename;

            // Use move_uploaded_file() as it provides checks to ensure the file was uploaded via POST.
            if (move_uploaded_file($_FILES["cv"]["tmp_name"], $upload_path)) {
                $response['success'] = true;
                $response['message'] = 'تم حفظ البيانات بنجاح! شكراً لتقديمك.';
            } else {
                $response['message'] = 'حدث خطأ أثناء تحميل الملف.';
            }

            Database::disconnect();
        } catch (PDOException $e) {
            // In a production environment, log this error instead of displaying it.
            $response['message'] = 'خطأ في قاعدة البيانات: ' . $e->getMessage();
        } catch (Exception $e) {
            $response['message'] = 'حدث خطأ غير متوقع: ' . $e->getMessage();
        }
    }
}

?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>طلب توظيف | النخبة التقنية العالمية</title>
    <meta name="description" content="قدم طلب توظيف لدى النخبة التقنية العالمية. املأ النموذج وأرفق سيرتك الذاتية للانضمام إلى فريقنا في فروعنا المختلفة.">

    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Droid+Arabic+Kufi&display=swap" as="style">
    <link rel="preload" href="images/slider/1.0.jpg" as="image">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Droid+Arabic+Kufi&display=swap">
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5522099409048778" crossorigin="anonymous"></script>

    <style>
        /* --- CORE CSS: Inlined for Performance --- */
        :root {
            --primary-color: #369;
            --secondary-color: #800000;
            --text-color: #333;
            --light-gray: #f8f9fa;
            --bs-font-sans-serif: 'Droid Arabic Kufi', sans-serif;
        }
        body {
            font-family: var(--bs-font-sans-serif);
            background-color: #fff;
            color: var(--text-color);
            line-height: 1.6;
        }
        /* --- Bootstrap 5 Essentials (Navbar, Grid, Forms, Buttons, Carousel) --- */
        .container-fluid { width: 100%; padding-right: 15px; padding-left: 15px; margin-right: auto; margin-left: auto; }
        .row { display: flex; flex-wrap: wrap; margin-right: -15px; margin-left: -15px; }
        .navbar { position: relative; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; padding: .5rem 1rem; }
        .navbar-expand-lg .navbar-nav { flex-direction: row; }
        .navbar-nav .nav-link { padding-right: .5rem; padding-left: .5rem; }
        .navbar-nav .dropdown-menu { position: absolute; }
        .dropdown-toggle::after { display: inline-block; margin-left: .255em; vertical-align: .255em; content: ""; border-top: .3em solid; border-right: .3em solid transparent; border-bottom: 0; border-left: .3em solid transparent; }
        .carousel { position: relative; }
        .carousel-inner { position: relative; width: 100%; overflow: hidden; }
        .carousel-item { position: relative; display: none; width: 100%; transition: transform .6s ease-in-out; }
        .carousel-item.active { display: block; }
        .carousel-control-prev, .carousel-control-next { position: absolute; top: 0; bottom: 0; z-index: 1; display: flex; align-items: center; justify-content: center; width: 15%; color: #fff; text-align: center; opacity: .5; transition: opacity .15s ease; }
        .carousel-control-prev:hover, .carousel-control-next:hover { opacity: .9; }
        .carousel-control-prev-icon, .carousel-control-next-icon { display: inline-block; width: 2rem; height: 2rem; background-repeat: no-repeat; background-position: 50%; background-size: 100% 100%; }
        .carousel-control-prev-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e"); }
        .carousel-control-next-icon { background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23fff'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e"); }
        .form-label { margin-bottom: .5rem; display: inline-block; }
        .form-control { display: block; width: 100%; padding: .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #212529; background-color: #fff; background-clip: padding-box; border: 1px solid #ced4da; border-radius: .25rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
        .form-select { display: block; width: 100%; padding: .375rem 2.25rem .375rem .75rem; font-size: 1rem; font-weight: 400; line-height: 1.5; color: #212529; background-color: #fff; border: 1px solid #ced4da; border-radius: .25rem; }
        .btn { display: inline-block; font-weight: 400; color: #212529; text-align: center; vertical-align: middle; cursor: pointer; user-select: none; background-color: transparent; border: 1px solid transparent; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; border-radius: .25rem; }
        .btn-success { color: #fff; background-color: #198754; border-color: #198754; }
        .btn-secondary { color: #fff; background-color: #6c757d; border-color: #6c757d; }
        .alert { position: relative; padding: 1rem 1rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: .25rem; }
        .alert-info { color: #0c5460; background-color: #d1ecf1; border-color: #bee5eb; }
        .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
        .alert-danger { color: #721c24; background-color: #f8d7da; border-color: #f5c6cb; }
        .invalid-feedback { display: none; width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545; }
        .is-invalid ~ .invalid-feedback { display: block; }
        .text-center { text-align: center !important; }
        .mb-3 { margin-bottom: 1rem !important; }
        .mt-4 { margin-top: 1.5rem !important; }
        .py-4 { padding-top: 1.5rem !important; padding-bottom: 1.5rem !important; }
        .w-75 { width: 75% !important; }
        .mx-auto { margin-right: auto !important; margin-left: auto !important; }

        /* --- Custom Theme Styles --- */
        .navbar-custom { background-color: var(--light-gray); border-bottom: 1px solid #ddd; font-weight: bold; }
        .carousel-container {
            /* Prevents CLS by reserving space for the carousel before images load */
            aspect-ratio: 1200 / 300; /* Use the aspect ratio of your images */
            background-color: #eee; /* Placeholder background */
            width: 100%;
            overflow: hidden;
        }
        .carousel-container img { width: 100%; height: 100%; object-fit: cover; }
        .ad-slot {
            display: block;
            width: 100%;
            min-height: 50px; /* Prevents CLS from ads loading */
            margin: 1rem auto;
            background-color: #f0f0f0;
            text-align: center;
            line-height: 50px;
        }
        .footer {
            background-color: var(--light-gray);
            color: var(--text-color);
            border-top: 1px solid #ddd;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">النخبة التقنية</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavbar">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                           <li class="nav-item"><a class="nav-link" href="index.php">البداية</a></li>
                         <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/WorldTechnicalElite" target="_blank" rel="noopener">فيسبوك</a></li>
                         <li class="nav-item"><a class="nav-link" href="Application_form.php">طلب التحاق</a></li>
                         <li class="nav-item"><a class="nav-link active" aria-current="page" href="Job_form.php">طلب توظيف</a></li>
                         <li class="nav-item dropdown">
                             <a class="nav-link dropdown-toggle" href="#" id="diplomasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                 دبلوماتنا
                             </a>
                             <ul class="dropdown-menu" aria-labelledby="diplomasDropdown">
                                 <li><a class="dropdown-item" href="programs/Decore.php">التصميم الداخلي والديكور</a></li>
                                 <li><a class="dropdown-item" href="programs/Maintenance.php">الصيانة الشامل</a></li>
                             </ul>
                         </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="https://wt-elite.net/login.php">تسجيل الدخول</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container-fluid mx-auto mt-4 py-4" style="max-width: 900px; padding-top: 80px !important;">

        <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner carousel-container">
                <div class="carousel-item active">
                    <img src="images/slider/1.0.jpg" alt="إعلان ترويجي 1" loading="eager" fetchpriority="high">
                </div>
                <div class="carousel-item">
                    <img src="images/slider/1.2.jpg" alt="إعلان ترويجي 2" loading="lazy">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <?php if ($response['is_submitted']): ?>
                    <?php if ($response['success']): ?>
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">تم بنجاح!</h4>
                            <p><?php echo htmlspecialchars($response['message']); ?></p>
                            <hr>
                            <a href="index.php" class="btn btn-secondary">العودة إلى الرئيسية</a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-danger" role="alert">
                               <h4 class="alert-heading">خطأ في التقديم</h4>
                            <p><?php echo htmlspecialchars($response['message'] ? $response['message'] : 'يرجى مراجعة الأخطاء أدناه وتصحيحها.'); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if (!$response['success']): ?>
                    <h1 class="mb-4">طلب توظيف</h1>
                    <form class="text-end" action="Job_form.php" method="post" enctype="multipart/form-data" >

                        <div class="mb-3">
                            <label for="name" class="form-label">الاسم الكامل</label>
                            <input type="text" id="name" name="name" class="form-control <?php echo isset($response['errors']['name']) ? 'is-invalid' : ''; ?>" required autocomplete="name">
                            <div class="invalid-feedback"><?php echo isset($response['errors']['name']) ? $response['errors']['name'] : ''; ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="bdate" class="form-label">تاريخ الميلاد</label>
                            <input type="date" id="bdate" name="bdate" class="form-control <?php echo isset($response['errors']['bdate']) ? 'is-invalid' : ''; ?>" required autocomplete="bday">
                             <div class="invalid-feedback"><?php echo isset($response['errors']['bdate']) ? $response['errors']['bdate'] : ''; ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="education" class="form-label">المؤهل العلمي</label>
                            <select id="education" name="education" class="form-select <?php echo isset($response['errors']['education']) ? 'is-invalid' : ''; ?>" required>
                                <option value="دكتوراه">دكتوراه</option>
                                <option value="ماجستير">ماجستير</option>
                                <option value="بكالوريوس" selected>بكالوريوس</option>
                                <option value="دبلوم">دبلوم</option>
                                <option value="ثانوية عامة">ثانوية عامة</option>
                            </select>
                            <div class="invalid-feedback"><?php echo isset($response['errors']['education']) ? $response['errors']['education'] : ''; ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="speci" class="form-label">التخصص</label>
                            <input type="text" id="speci" name="speci" class="form-control <?php echo isset($response['errors']['speci']) ? 'is-invalid' : ''; ?>" required autocomplete="organization-title">
                            <div class="invalid-feedback"><?php echo isset($response['errors']['speci']) ? $response['errors']['speci'] : ''; ?></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="tel" id="phone" name="phone" class="form-control <?php echo isset($response['errors']['phone']) ? 'is-invalid' : ''; ?>" required autocomplete="tel">
                            <div class="invalid-feedback"><?php echo isset($response['errors']['phone']) ? $response['errors']['phone'] : ''; ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" id="email" name="email" class="form-control <?php echo isset($response['errors']['email']) ? 'is-invalid' : ''; ?>" required autocomplete="email">
                             <div class="invalid-feedback"><?php echo isset($response['errors']['email']) ? $response['errors']['email'] : ''; ?></div>
                        </div>

                        <div class="mb-3">
                            <label for="branch" class="form-label">الفرع الذي ترغب العمل به</label>
                            <select id="branch" name="branch" class="form-select <?php echo isset($response['errors']['branch']) ? 'is-invalid' : ''; ?>" required>
                                <option value="جنين" selected>جنين</option>
                                <option value="رام الله">رام الله</option>
                                <option value="نابلس">نابلس</option>
                                <option value="الخليل">الخليل</option>
                                <option value="طوباس">طوباس</option>
                                <option value="يطا">يطا</option>
                            </select>
                            <div class="invalid-feedback"><?php echo isset($response['errors']['branch']) ? $response['errors']['branch'] : ''; ?></div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="cv" class="form-label">إرفاق السيرة الذاتية (PDF, DOCX)</label>
                            <input type="file" id="cv" name="cv" class="form-control <?php echo isset($response['errors']['cv']) ? 'is-invalid' : ''; ?>" required accept=".pdf,.doc,.docx">
                             <div class="invalid-feedback"><?php echo isset($response['errors']['cv']) ? $response['errors']['cv'] : ''; ?></div>
                        </div>

                        <hr>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg">حفظ وإرسال</button>
                            <a class="btn btn-secondary btn-lg" href="index.php">إلغاء</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer mt-auto py-4 text-center">
        <div class="container">
            <strong>النخبة التقنية العالمية © 2016 - <?php echo date("Y"); ?></strong>
            <br>
            <a href="mailto:info@wt-elite.net" style="color: var(--text-color);">info@wt-elite.net</a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous" defer></script>
</body>
</html>