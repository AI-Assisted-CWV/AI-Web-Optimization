<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    session_start();
    ob_start(); // The rest of your code follows

        // Session and authorization check
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true || $_SESSION['role'] !== 'admin') {
            header('Location: ../login.php?loginError=1');
            exit;
        }

        // Include database connection
        include '../database.php';
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // --- Pagination Logic ---
        $rec_limit = 8;
        $sql_count = "SELECT count(*) as items FROM course";
        $q_count = $pdo->prepare($sql_count);
        $q_count->execute();
        $row = $q_count->fetch(PDO::FETCH_ASSOC);
        $rec_count = $row['items'];
        $page_count = ceil($rec_count / $rec_limit);

        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max(1, min($page, $page_count)); // Ensure page is within valid range
        $start = ($page - 1) * $rec_limit;

        // --- Search Logic ---
        $search_term = '';
        $is_search = false;
        if (isset($_POST['submit']) && !empty($_POST['search'])) {
            $search_term = '%' . $_POST['search'] . '%';
            $is_search = true;
            $start = 0;
            $rec_limit = 1000; // Show all results for a search
        } else {
            $search_term = '%%';
        }

        // --- Data Fetching ---
        $sql_data = "SELECT * FROM course where Title like ? or Weeks like ? or Hours like ? or Teacher_Spec like ? or Level like ? LIMIT $start, $rec_limit";
        $q_data = $pdo->prepare($sql_data);
        $q_data->execute(array($search_term,$search_term,$search_term ,$search_term,$search_term));
        $results = $q_data->fetchAll(PDO::FETCH_ASSOC);
        $results_count = $q_data->rowCount();
    ?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جدول المواد - النخبة التقنية العالمية</title>
    <meta name="description" content="إدارة وعرض جدول المواد الدراسية في مركز النخبة التقنية العالمية.">
    <meta name="author" content="النخبة التقنية العالمية">
    <link rel="canonical" href="https://www.wt-elite.net/admin/c_index_mod.php">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Droid+Arabic+Kufi&display=swap">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">

    <style>
        :root {
            --footer-bg: #E6E6E6;
            --footer-text: #000;
            --footer-border: #000;
        }
        body {
            font-family: 'Droid Arabic Kufi', serif;
            padding-top: 70px; /* For fixed navbar */
        }
        .navbar-nav>li>a {
            font-weight: bold;
        }
        .table th, .table td {
            text-align: right;
            vertical-align: middle;
        }
        .pagination {
            margin: 0;
        }
        #footer {
            background-color: var(--footer-bg);
            color: var(--footer-text);
            font-weight: 100;
            font-size: 14px;
            text-align: center;
            width: 100%;
            float: right;
            border-top: 1px solid var(--footer-border);
            padding: 15px;
            margin-top: 30px;
        }
        .action-btn {
            margin: 2px;
        }
        .adsbygoogle {
            display: block;
            min-height: 50px;
            margin: 20px auto;
        }
        .search-form {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: center;
        }
    </style>

    <link rel="icon" href="../favicon.ico" type="image/x-icon">

</head>
<body>
    
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar" aria-expanded="false" aria-controls="main-navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="../index.php" aria-label="Homepage">
                        <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="main-navbar">
                    <ul class="nav navbar-nav">
                        <li><a href="https://www.facebook.com/WorldTechnicalElite" target="_blank" rel="noopener noreferrer"><img src="../images/icons/f.png" alt="Facebook Page" width="20" height="20"></a></li>
                        <li><a href="#" onclick="window.print(); return false;"><span class="glyphicon glyphicon-print"></span> طباعة</a></li>
                        <li><a href="t_index.php">المدرسين</a></li>
                        <li><a href="e_index.php">الموظفين</a></li>
                        <li><a href="s_index.php">الطلاب</a></li>
                        <li><a href="u_index.php">المستخدمين</a></li>
                        <li><a href="c_index.php" class="active" aria-current="page">المواد</a></li>
                        <li><a href="semester.php">المحاضرات</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">الامور المالية <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="walletAll.php">المحفظة المالية لجميع الموظفين</a></li>
                                <li><a href="fees_report.php">التحصيل</a></li>
                                <li><a href="payments.php">المصروفات</a></li>
                                </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">الطلبات <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="application_index.php">طلبات الالتحاق</a></li>
                                <li><a href="cv.php">طلبات التوظيف</a></li>
                            </ul>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">اختر الفرع <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="changeBranch.php?branch=Ramallah_D">رام الله - التطويرية</a></li>
                                <li><a href="changeBranch.php?branch=Hebron">الخليل</a></li>
                                </ul>
                        </li>
                        <li>
                            <a href="../logout.php">
                                <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>
                                (<?php echo htmlspecialchars($_SESSION['userName']); ?>) تسجيل الخروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main class="container-fluid">
        <div class="row">
            <div class="col-xs-12 text-center">
                <h1>جدول المواد</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <ins class="adsbygoogle"
                     style="display:block"
                     data-ad-client="ca-pub-5522099409048778"
                     data-ad-slot="2938783401"
                     data-ad-format="auto"
                     data-full-width-responsive="true"></ins>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-12">
                <?php
                if ($is_search) {
                    $alert_class = $results_count > 0 ? 'alert-success' : 'alert-danger';
                    $message = $results_count > 0 ? "تم إيجاد {$results_count} سجل" : 'لا يوجد نتائج للبحث. لعرض الجدول كاملا اترك حقل البحث فارغ ثم اضغط على بحث.';
                    echo "<div class='alert {$alert_class} alert-dismissible' role='alert'>
                            <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                            <strong>{$message}</strong>
                          </div>";
                }
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6" style="margin-bottom: 10px;">
                <a href="c_create.php" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> مادة جديدة</a>
            </div>
            <div class="col-sm-6 text-center">
                <?php if (!$is_search && $page_count > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $page_count; $i++): ?>
                                <li class="<?php echo ($i == $page) ? 'active' : ''; ?>">
                                    <a href="c_index_Gemini.php?page=<?php echo $i; ?>">
                                        <?php echo $i; ?>
                                        <?php if ($i == $page): ?><span class="sr-only">(current)</span><?php endif; ?>
                                    </a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
        </div>

        <form action="ca_delete.php" method="post" id="course-form">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <caption>
                        <span class="sr-only">قائمة المواد الدراسية</span>
                    </caption>
                    <thead>
                        <tr>
                            <th scope="col">تحديد</th>
                            <th scope="col">رقم المادة</th>
                            <th scope="col">العنوان</th>
                            <th scope="col">المدة (أسابيع)</th>
                            <th scope="col">عدد الساعات</th>
                            <th scope="col">مستوى المدرس</th>
                            <th scope="col">مستوى الدارس</th>
                            <th scope="col">ملاحظات</th>
                            <th scope="col">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($results_count > 0): ?>
                            <?php foreach ($results as $row): ?>
                                <tr>
                                    <td><input type="checkbox" name="c_id[]" value="<?php echo htmlspecialchars($row['Course_ID']); ?>" aria-label="Select course <?php echo htmlspecialchars($row['Title']); ?>"></td>
                                    <td><?php echo htmlspecialchars($row['Course_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Title']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Weeks']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Hours']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Teacher_Spec']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Level']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Notes']); ?></td>
                                    <td>
                                        <a class="btn btn-success btn-sm action-btn" href="c_update.php?id=<?php echo htmlspecialchars($row['Course_ID']); ?>">تعديل</a>
                                        <a class="btn btn-danger btn-sm disabled action-btn" href="c_delete.php?id=<?php echo htmlspecialchars($row['Course_ID']); ?>" aria-disabled="true">حذف</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">لا توجد بيانات لعرضها.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>

        <form action="" method="post" class="search-form" role="search">
            <label for="search-input" class="sr-only">ابحث في المواد</label>
            <input name="search" id="search-input" type="search" class="form-control" style="max-width: 300px;" placeholder="بحث...">
            <button name="submit" type="submit" class="btn btn-primary">بحث</button>
        </form>
    </main>

    <footer id="footer">
        <p><strong>النخبة التقنية العالمية 2016 - <?php echo date("Y"); ?></strong></p>
        <p>
            <a href="mailto:info@wt-elite.net" style="color: var(--footer-text);">
                info@wt-elite.net <span class="glyphicon glyphicon-envelope"></span>
            </a>
        </p>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5522099409048778" crossorigin="anonymous"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>

    <?php
        Database::disconnect();
        ob_end_flush(); // Flush the output buffer
    ?>
</body>
</html>