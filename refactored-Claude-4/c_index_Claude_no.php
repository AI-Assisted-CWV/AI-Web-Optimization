<?php
session_start();

// Authentication check
if (!isset($_SESSION['login']) || $_SESSION['login'] == false) {
    header('Location: ../login.php?loginError=1');
    exit;
}

// Admin role check
if ($_SESSION['role'] != 'admin') {
    header("Location: https://www.wt-elite.net/login.php?loginError=1");
    exit;
}

// Database connection and pagination logic
include '../database.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Count records for pagination
$sql = "SELECT count(*) as items FROM course";
$q = $pdo->prepare($sql);
$q->execute();
$row = $q->fetch(PDO::FETCH_ASSOC);
$rec_count = $row['items'];
$rec_limit = 8;
$page_count = ceil($rec_count / $rec_limit);

// Current page calculation
$page = isset($_GET['page']) ? (int)$_GET['page'] - 1 : 0;
$start = $rec_limit * $page;

// Search functionality
$search = "%%";
if (isset($_POST['search']) && !empty($_POST['search'])) {
    $search = '%' . $_POST['search'] . '%';
    $start = 0;
    $rec_limit = 1000000;
}

// Fetch course data
$sql = "SELECT * FROM course WHERE Title LIKE ? OR Weeks LIKE ? OR Hours LIKE ? OR Teacher_Spec LIKE ? OR Level LIKE ? LIMIT $start, $rec_limit";
$q = $pdo->prepare($sql);
$q->execute(array($search, $search, $search, $search, $search));
$courses = $q->fetchAll(PDO::FETCH_ASSOC);
$search_count = $q->rowCount();

Database::disconnect();
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>جدول المواد - النخبة التقنية العالمية</title>
    <meta name="description" content="إدارة المواد الدراسية في نظام النخبة التقنية العالمية">
    <meta name="robots" content="noindex, nofollow">
    
    <!-- Preload critical resources -->
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+Arabic:wght@400;700&display=swap"></noscript>
    
    <!-- Critical CSS inlined -->
    <style>
        /* Critical CSS for above-the-fold content */
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans Arabic', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
            line-height: 1.6;
            direction: rtl;
            text-align: right;
        }
        
        .container-fluid {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        
        /* Navbar styles */
        .navbar {
            background-color: #343a40;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .navbar-nav {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .navbar-nav a {
            color: #fff;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            transition: background-color 0.2s ease;
        }
        
        .navbar-nav a:hover,
        .navbar-nav a:focus {
            background-color: #495057;
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }
        
        /* Main content */
        .main-content {
            margin-top: 2rem;
            min-height: 60vh;
        }
        
        .page-title {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 2rem;
            font-size: 2rem;
            font-weight: 700;
        }
        
        /* Table styles */
        .table-container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 2rem;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .table th,
        .table td {
            padding: 0.75rem;
            border-bottom: 1px solid #dee2e6;
            text-align: right;
        }
        
        .table th {
            background-color: #495057;
            color: #fff;
            font-weight: 700;
            position: sticky;
            top: 0;
        }
        
        .table tbody tr:hover {
            background-color: #f8f9fa;
        }
        
        /* Button styles */
        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            margin: 0.25rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.875rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        
        .btn:focus {
            outline: 2px solid #007bff;
            outline-offset: 2px;
        }
        
        .btn-success {
            background-color: #28a745;
            color: #fff;
        }
        
        .btn-success:hover {
            background-color: #218838;
        }
        
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        
        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
        }
        
        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
            gap: 0.5rem;
        }
        
        .pagination a {
            display: block;
            padding: 0.5rem 0.75rem;
            background-color: #fff;
            border: 1px solid #dee2e6;
            color: #007bff;
            text-decoration: none;
            border-radius: 4px;
            transition: all 0.2s ease;
        }
        
        .pagination a:hover,
        .pagination a:focus {
            background-color: #e9ecef;
            outline: 2px solid #007bff;
        }
        
        .pagination .active a {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        
        /* Search form */
        .search-form {
            display: flex;
            gap: 0.5rem;
            margin: 2rem 0;
            align-items: center;
            flex-wrap: wrap;
        }
        
        .search-form input[type="text"] {
            padding: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 1rem;
            flex: 1;
            min-width: 200px;
        }
        
        /* Alert styles */
        .alert {
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
        
        /* Footer */
        .footer {
            background-color: #e6e6e6;
            color: #000;
            text-align: center;
            padding: 2rem;
            margin-top: 3rem;
            border-top: 2px solid #ddd;
        }
        
        /* Responsive design */
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .table-container {
                overflow-x: auto;
            }
            
            .table {
                min-width: 800px;
            }
            
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }
            
            .pagination {
                flex-wrap: wrap;
            }
        }
        
        /* Skip link for accessibility */
        .skip-link {
            position: absolute;
            top: -40px;
            left: 6px;
            background: #000;
            color: #fff;
            padding: 8px;
            text-decoration: none;
            border-radius: 4px;
            z-index: 1001;
        }
        
        .skip-link:focus {
            top: 6px;
        }
        
        /* Loading state */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .table th {
                border: 2px solid #000;
            }
            
            .btn {
                border: 2px solid #000;
            }
        }
        
        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
</head>
<body>
    <!-- Skip link for screen readers -->
    <a href="#main-content" class="skip-link">انتقل إلى المحتوى الرئيسي</a>
    
    <div class="container-fluid">
        <!-- Navigation -->
        <nav class="navbar" role="navigation" aria-label="القائمة الرئيسية">
            <ul class="navbar-nav">
                <li><a href="../index.php" aria-label="الصفحة الرئيسية"><span aria-hidden="true">🏠</span> الرئيسية</a></li>
                <li><a href="https://www.facebook.com/WorldTechnicalElite" target="_blank" rel="noopener" aria-label="صفحة الفيسبوك (يفتح في نافذة جديدة)">فيسبوك</a></li>
                <li><a href="#" onclick="window.print(); return false;" aria-label="طباعة الصفحة">طباعة</a></li>
                <li><a href="t_index.php">المدرسين</a></li>
                <li><a href="e_index.php">الموظفين</a></li>
                <li><a href="s_index.php">الطلاب</a></li>
                <li><a href="u_index.php">المستخدمين</a></li>
                <li><a href="c_index.php" aria-current="page">المواد</a></li>
                <li><a href="semester.php">المحاضرات</a></li>
                <li><a href="../logout.php">تسجيل الخروج (<?php echo htmlspecialchars($_SESSION['userName']); ?>)</a></li>
            </ul>
        </nav>

        <!-- Main content -->
        <main id="main-content" class="main-content" role="main">
            <h1 class="page-title">جدول المواد</h1>
            
            <!-- Pagination -->
            <?php if (!isset($_POST['search']) || empty($_POST['search'])): ?>
            <nav aria-label="التنقل بين الصفحات">
                <ul class="pagination">
                    <?php for($index = 0; $index < $page_count; $index++): 
                        $index2 = $index + 1;
                        $active = ($index2 == ($page + 1)) ? 'active' : '';
                    ?>
                        <li class="<?php echo $active; ?>">
                            <a href="c_index_Claude_no.php?page=<?php echo $index2; ?>" 
                               <?php echo $active ? 'aria-current="page"' : ''; ?>>
                                صفحة <?php echo $index2; ?>
                            </a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
            <?php endif; ?>

            <!-- Action buttons -->
            <div style="margin-bottom: 1rem;">
                <a href="c_create.php" class="btn btn-success">مادة جديدة</a>
            </div>

            <!-- Search results alert -->
            <?php if (isset($_POST['search']) && !empty($_POST['search'])): ?>
                <?php if ($search_count == 0): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong>لا يوجد نتائج للبحث.</strong> لعرض الجدول كاملاً اترك حقل البحث فارغاً ثم اضغط على بحث.
                    </div>
                <?php else: ?>
                    <div class="alert alert-success" role="alert">
                        <strong>تم إيجاد <?php echo $search_count; ?> سجل</strong>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Course table -->
            <div class="table-container">
                <table class="table" role="table" aria-label="جدول المواد الدراسية">
                    <thead>
                        <tr>
                            <th scope="col">رقم المادة</th>
                            <th scope="col">العنوان</th>
                            <th scope="col">مدتها بالأسابيع</th>
                            <th scope="col">عدد الساعات</th>
                            <th scope="col">مستوى المدرس</th>
                            <th scope="col">مستوى الدارس</th>
                            <th scope="col">ملاحظات</th>
                            <th scope="col">الإجراء</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($courses)): ?>
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 2rem;">
                                    لا توجد مواد متاحة
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($course['Course_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($course['Title']); ?></td>
                                    <td><?php echo htmlspecialchars($course['Weeks']); ?></td>
                                    <td><?php echo htmlspecialchars($course['Hours']); ?></td>
                                    <td><?php echo htmlspecialchars($course['Teacher_Spec']); ?></td>
                                    <td><?php echo htmlspecialchars($course['Level']); ?></td>
                                    <td><?php echo htmlspecialchars($course['Notes']); ?></td>
                                    <td>
                                        <a href="c_update.php?id=<?php echo urlencode($course['Course_ID']); ?>" 
                                           class="btn btn-success btn-sm"
                                           aria-label="تعديل المادة رقم <?php echo htmlspecialchars($course['Course_ID']); ?>">
                                            تعديل
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Search form -->
            <form action="" method="post" class="search-form" role="search" aria-label="البحث في المواد">
                <label for="search-input" class="sr-only">البحث في المواد:</label>
                <input type="text" 
                       id="search-input"
                       name="search" 
                       placeholder="ابحث في المواد..."
                       value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>"
                       aria-describedby="search-help">
                <button type="submit" name="submit" class="btn btn-success">بحث</button>
                <small id="search-help" class="sr-only">
                    يمكنك البحث بالعنوان، عدد الأسابيع، الساعات، مستوى المدرس، أو مستوى الدارس
                </small>
            </form>
        </main>

        <!-- Footer -->
        <footer class="footer" role="contentinfo">
            <strong>النخبة التقنية العالمية 2016 - 2023</strong><br>
            <a href="mailto:info@wt-elite.net" aria-label="البريد الإلكتروني">info@wt-elite.net</a>
        </footer>
    </div>

    <!-- Screen reader only class -->
    <style>
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }
    </style>

    <!-- Performance optimization: Load non-critical JavaScript at the end -->
    <script>
        // Simple form validation
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('.search-form');
            const table = document.querySelector('.table-container');
            
            // Add loading state during form submission
            if (form) {
                form.addEventListener('submit', function() {
                    table.classList.add('loading');
                });
            }
            
            // Simple print optimization
            window.addEventListener('beforeprint', function() {
                document.body.classList.add('printing');
            });
            
            window.addEventListener('afterprint', function() {
                document.body.classList.remove('printing');
            });
        });
        
        // Performance monitoring
        if ('performance' in window) {
            window.addEventListener('load', function() {
                setTimeout(function() {
                    const navigation = performance.getEntriesByType('navigation')[0];
                    if (navigation && navigation.loadEventEnd > 2500) {
                        console.warn('Page load time exceeded 2.5s:', navigation.loadEventEnd);
                    }
                }, 0);
            });
        }
    </script>
</body>
</html>