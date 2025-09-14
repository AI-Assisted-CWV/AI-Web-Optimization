<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] === false || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php?loginError=1');
    exit;
}
require_once '../database.php';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>جدول المواد</title>
  <meta name="description" content="إدارة جدول المواد - النخبة التقنية العالمية">
  <meta name="author" content="WT Elite">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css">
  <link rel="stylesheet" href="../css/print.css">
  <link rel="stylesheet" href="../css/myStyle.css">
  <style>
    body { font-family: 'Cairo', sans-serif; background-color: #f8f9fa; }
    table th, table td { vertical-align: middle !important; }
    .navbar-brand img { height: 24px; }
    footer { background-color: #eee; padding: 1rem; text-align: center; font-size: 14px; color: #000; }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php"><span class="glyphicon glyphicon-home"></span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="https://www.facebook.com/WorldTechnicalElite" target="_blank"><img src="../images/icons/f.png" alt="Facebook" width="20" height="20"></a></li>
        <li class="nav-item"><a class="nav-link" href="#" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a></li>
        <li class="nav-item"><a class="nav-link" href="t_index.php">المدرسين</a></li>
        <li class="nav-item"><a class="nav-link" href="e_index.php">الموظفين</a></li>
        <li class="nav-item"><a class="nav-link" href="s_index.php">الطلاب</a></li>
        <li class="nav-item"><a class="nav-link" href="u_index.php">المستخدمين</a></li>
        <li class="nav-item"><a class="nav-link" href="c_index.php">المواد</a></li>
        <li class="nav-item"><a class="nav-link" href="semester.php">المحاضرات</a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">الامور المالية</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="walletAll.php">محفظة الموظفين</a></li>
            <li><a class="dropdown-item" href="fees_report.php">التحصيل</a></li>
            <li><a class="dropdown-item" href="payments.php">المصروفات</a></li>
            <li><a class="dropdown-item" href="deposit.php">الايداعات</a></li>
            <li><a class="dropdown-item" href="sale.php">مبيعات الفروع</a></li>
            <li><a class="dropdown-item" href="fees_report_all.php">تحصيل الفروع</a></li>
            <li><a class="dropdown-item" href="ch.php">الشيكات</a></li>
            <li><a class="dropdown-item" href="box.php">الصندوق</a></li>
          </ul>
        </li>
      </ul>

      <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">اختر الفرع</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="changeBranch.php?branch=Ramallah_D">رام الله - التطويرية</a></li>
            <li><a class="dropdown-item" href="changeBranch.php?branch=Ramallah">رام الله</a></li>
            <li><a class="dropdown-item" href="changeBranch.php?branch=Nablus">نابلس</a></li>
            <li><a class="dropdown-item" href="changeBranch.php?branch=Hebron">الخليل</a></li>
            <li><a class="dropdown-item" href="changeBranch.php?branch=Yatta">يطا</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php"><span class="glyphicon glyphicon-log-out"></span> (<?php echo htmlspecialchars($_SESSION['userName']); ?>) تسجيل الخروج</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main class="container mt-5 pt-5">
  <h1 class="text-center my-4">جدول المواد</h1>

  <?php
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $rec_limit = 8;
    $page = isset($_GET['page']) ? max(0, intval($_GET['page']) - 1) : 0;
    $start = $page * $rec_limit;

    $stmt = $pdo->query("SELECT COUNT(*) as items FROM course");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['items'];
    $page_count = ceil($total / $rec_limit);

    echo '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
    for ($i = 1; $i <= $page_count; $i++) {
        $active = ($i === $page + 1) ? 'active' : '';
        echo "<li class='page-item $active'><a class='page-link' href='?page=$i'>صفحة $i</a></li>";
    }
    echo '</ul></nav>';

    $search = isset($_POST['search']) ? '%' . $_POST['search'] . '%' : '%%';
    $limit = isset($_POST['search']) ? 10000 : $rec_limit;

    $sql = "SELECT * FROM course WHERE Title LIKE ? OR Weeks LIKE ? OR Hours LIKE ? OR Teacher_Spec LIKE ? OR Level LIKE ? LIMIT $start, $limit";
    $q = $pdo->prepare($sql);
    $q->execute([$search, $search, $search, $search, $search]);

    if (isset($_POST['search'])) {
        if ($q->rowCount() == 0) {
            echo '<div class="alert alert-danger">لا يوجد نتائج.</div>';
        } else {
            echo '<div class="alert alert-success">تم العثور على ' . $q->rowCount() . ' سجل.</div>';
        }
    }
  ?>

  <form action="ca_delete.php" method="post">
    <div class="mb-3">
      <a href="c_create.php" class="btn btn-success btn-sm">مادة جديدة</a>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle text-center">
        <thead class="table-light">
          <tr>
            <th>#</th><th>رقم المادة</th><th>العنوان</th><th>الأسابيع</th><th>الساعات</th><th>مستوى المدرس</th><th>مستوى الدارس</th><th>ملاحظات</th><th>الإجراء</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $q->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
              <td><input type="checkbox" name="c_id[]" value="<?= htmlspecialchars($row['Course_ID']) ?>"></td>
              <td><?= htmlspecialchars($row['Course_ID']) ?></td>
              <td><?= htmlspecialchars($row['Title']) ?></td>
              <td><?= htmlspecialchars($row['Weeks']) ?></td>
              <td><?= htmlspecialchars($row['Hours']) ?></td>
              <td><?= htmlspecialchars($row['Teacher_Spec']) ?></td>
              <td><?= htmlspecialchars($row['Level']) ?></td>
              <td><?= htmlspecialchars($row['Notes']) ?></td>
              <td>
                <a href="c_update.php?id=<?= $row['Course_ID'] ?>" class="btn btn-sm btn-success">تعديل</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </form>

  <form method="post" class="my-3">
    <input name="search" type="text" class="form-control mb-2" placeholder="ابحث عن مادة">
    <input type="submit" class="btn btn-success btn-sm" value="بحث">
  </form>

</main>

<footer>
  <p><strong>النخبة التقنية العالمية 2016 - 2023</strong><br>info@wt-elite.net <span class="glyphicon glyphicon-envelope"></span></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>
