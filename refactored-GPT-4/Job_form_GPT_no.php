<?php 
	
	require 'database.php';

	if ( !empty($_POST)) {
		
		// keep track post values	
		$name = $_POST['name'];
		$bdate = $_POST['bdate'];
		$education = $_POST['education'];
		$speci = $_POST['speci'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$branch = $_POST['branch'];
		$path = 'cv\\'.$_POST['name'];		
		$ip= $_SERVER['REMOTE_ADDR'];
		
		
		// validate input
		$valid = true;
	
		// insert data
		if ($valid) {
			
			$filename=$_FILES["cv"]["name"];
			$extension=end(explode(".", $filename));
			
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "INSERT INTO cv (name,bdate,education,speci,phone,email,branch,path,ip) values(?, ?, ?, ?,?,?,?,?,?)";
			$q = $pdo->prepare($sql);
			$q->execute(array($name,$bdate,$education,$speci,$phone,$email,$branch,$extension,$ip));
			

			$newfilename=$pdo->lastInsertId() .".".$extension;
			//move_uploaded_file($_FILES["cv"]["tmp_name"], "CV/" .$newfilename);
			
			Database::disconnect();
			$saved=1;
		}
	}
?>


<!-- HTML starts here -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>طلب توظيف - النخبة التقنية العالمية</title>
  <meta name="description" content="نموذج تقديم طلب توظيف لدى النخبة التقنية العالمية">
  <meta name="keywords" content="توظيف, طلب توظيف, النخبة التقنية العالمية">
  <meta name="author" content="النخبة التقنية العالمية">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
  <style>
    body { font-family: 'Noto Kufi Arabic', sans-serif; background-color: #f9f9f9; }
    .navbar { background-color: #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    footer { background-color: #e6e6e6; text-align: center; padding: 1rem; font-size: 14px; }
    label { font-weight: bold; margin-top: 1rem; }
  </style>
  <meta property="og:title" content="طلب توظيف - النخبة التقنية العالمية">
  <meta property="og:description" content="نموذج تقديم طلب توظيف لدى النخبة التقنية العالمية">
  <meta property="og:image" content="/images/og-image.jpg">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="ar_AR">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">النخبة التقنية العالمية</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">البداية</a></li>
            <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/WorldTechnicalElite" target="_blank">فيسبوك</a></li>
            <li class="nav-item"><a class="nav-link" href="Application_form.php">طلب التحاق</a></li>
            <li class="nav-item"><a class="nav-link active" aria-current="page" href="Job_form.php">طلب توظيف</a></li>
            <li class="nav-item"><a class="nav-link" href="mail.php" target="_blank">البريد الإلكتروني</a></li>
            <li class="nav-item"><a class="nav-link" href="http://hrm.wt-elite.net" target="_blank">شؤون الموظفين</a></li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="https://wt-elite.net/login.php">تسجيل الدخول</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <main class="container mt-5 pt-5">
    <h1 class="text-center mb-4">طلب توظيف</h1>

    <?php if (!empty($saved)): ?>
      <div class="alert alert-success text-center">تم حفظ البيانات بنجاح</div>
    <?php elseif (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data" class="needs-validation">
      <div class="mb-3">
        <label for="name">الاسم الكامل</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>
      <div class="mb-3">
        <label for="bdate">تاريخ الميلاد</label>
        <input type="date" class="form-control" id="bdate" name="bdate" required>
      </div>
      <div class="mb-3">
        <label for="education">المؤهل العلمي</label>
        <select class="form-select" id="education" name="education" required>
          <option value="">اختر...</option>
          <option value="1">دكتوراه</option>
          <option value="2">ماجستير</option>
          <option value="3">بكالوريوس</option>
          <option value="4">دبلوم</option>
          <option value="5">ثانوية عامة</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="speci">التخصص</label>
        <input type="text" class="form-control" id="speci" name="speci" required>
      </div>
      <div class="mb-3">
        <label for="phone">رقم الهاتف</label>
        <input type="tel" class="form-control" id="phone" name="phone" required>
      </div>
      <div class="mb-3">
        <label for="email">البريد الإلكتروني</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="branch">الفرع المرغوب</label>
        <select class="form-select" id="branch" name="branch" required>
          <option value="1">جنين</option>
          <option value="2">رام الله</option>
          <option value="3">نابلس</option>
          <option value="4">الخليل</option>
          <option value="5">طوباس</option>
          <option value="6">يطا</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="cv">ارفق السيرة الذاتية (PDF فقط)</label>
        <input class="form-control" type="file" id="cv" name="cv" accept=".pdf" required>
      </div>
      <div class="text-center">
        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="index.php" class="btn btn-secondary">للخلف</a>
      </div>
    </form>
  </main>

  <footer class="mt-5">
    <p><strong>النخبة التقنية العالمية &copy; 2016 - 2023</strong></p>
    <p><a href="mailto:info@wt-elite.net">info@wt-elite.net</a></p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>
