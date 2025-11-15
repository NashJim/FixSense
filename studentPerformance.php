<?php
session_start();
 if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}

$fullName = htmlspecialchars($_SESSION['full_name']);
$initials = strtoupper(substr($fullName, 0, 1) . (strpos($fullName, ' ') ? substr($fullName, strpos($fullName, ' ') + 1, 1) : ''));

// Function to generate sidebar with active page
function generateSidebar($activePage) {
    $menuItems = [
        'lecturer.php' => ['icon' => 'fas fa-home', 'title' => 'Dashboard'],
        'manageScenario.php' => ['icon' => 'fas fa-car', 'title' => 'Manage Automotive Scenarios'],
        'createScenario.php' => ['icon' => 'fas fa-plus-circle', 'title' => 'Create New Scenario'],
        'manageExtraNotes.php' => ['icon' => 'fas fa-book', 'title' => 'Manage Extra Notes'],
        'studentPerformance.php' => ['icon' => 'fas fa-chart-bar', 'title' => 'Student Performance Tracking'],
        'profileLecturer.php' => ['icon' => 'fas fa-user-cog', 'title' => 'Profile'],
        'logout.php' => ['icon' => 'fas fa-sign-out-alt', 'title' => 'Logout']
    ];
    
    $html = '<div class="sidebar">
        <div class="logo">
            <i class="fas fa-tools"></i>
            <span>FixSense</span>
        </div>
        <ul class="nav-menu">';
    
    foreach ($menuItems as $page => $item) {
        $activeClass = ($activePage === $page) ? 'active' : '';
        $html .= "<li class=\"nav-item\">
            <a href=\"{$page}\" class=\"nav-link {$activeClass}\">
                <i class=\"{$item['icon']}\"></i> {$item['title']}
            </a>
        </li>";
    }
    
    $html .= '</ul></div>';
    return $html;
}

$pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$search = trim($_GET['search'] ?? '');
$selectedStudentId = $_GET['student_id'] ?? null;

if ($selectedStudentId) {
    $stmt = $pdo->prepare("
        SELECT u.id as student_id, u.full_name AS student_name,
               s.title AS scenario_title, p.scenario_id, p.score, p.status, p.completed_at
        FROM performance p
        JOIN users u ON p.student_id = u.id
        LEFT JOIN scenarios s ON p.scenario_id = s.id
        WHERE p.student_id = ?
        ORDER BY p.completed_at DESC
    ");
    $stmt->execute([$selectedStudentId]);
    $records = $stmt->fetchAll();
} else if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT u.id as student_id, u.full_name AS student_name,
               s.title AS scenario_title, p.scenario_id, p.score, p.status, p.completed_at
        FROM performance p
        JOIN users u ON p.student_id = u.id
        LEFT JOIN scenarios s ON p.scenario_id = s.id
        WHERE u.role='student' AND u.full_name LIKE ?
        ORDER BY p.completed_at DESC
    ");
    $stmt->execute(["%{$search}%"]);
    $records = $stmt->fetchAll();
} else {
    $stmt = $pdo->query("
        SELECT u.id as student_id, u.full_name AS student_name,
               s.title AS scenario_title, p.scenario_id, p.score, p.status, p.completed_at
        FROM performance p
        JOIN users u ON p.student_id = u.id
        LEFT JOIN scenarios s ON p.scenario_id = s.id
        WHERE u.role='student'
        ORDER BY p.completed_at DESC
    ");
    $records = $stmt->fetchAll();
}

if ($search !== '') {
    $stmt = $pdo->prepare("SELECT id, full_name, email FROM users WHERE role='student' AND full_name LIKE ? ORDER BY full_name ASC");
    $stmt->execute(["%{$search}%"]);
} else {
    $stmt = $pdo->query("SELECT id, full_name, email FROM users WHERE role='student' ORDER BY full_name ASC");
}
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Student Performance - FixSense</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css?v=<?= time() ?>">
<link rel="stylesheet" href="css/darkmode.css">
<link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
<script src="js/darkmode-fixed.js"></script>
<style>
/* Additional styles for this page */
.performance-section { 
    background:#fff; 
    border-radius:10px; 
    padding:30px; 
    box-shadow:var(--card-shadow); 
    margin-bottom:30px; 
}
body.dark-mode .performance-section { 
    background:#1e293b; 
    box-shadow:0 4px 8px rgba(0,0,0,0.2); 
}

.hero { 
    background:linear-gradient(135deg,#fff,#f7f7f7); 
    border-radius:15px; 
    padding:30px; 
    margin-bottom:30px; 
    text-align:center; 
    box-shadow:var(--card-shadow); 
}
body.dark-mode .hero { 
    background:linear-gradient(135deg,#1e293b,#0f172a); 
    box-shadow:0 4px 12px rgba(0,0,0,0.3); 
}
.hero h1 { 
    font-size:2rem; 
    margin-bottom:10px; 
    color:var(--dark-color); 
}
body.dark-mode .hero h1 { 
    color:#93c5fd; 
}
.hero p { 
    font-size:1rem; 
    color:var(--dark-gray); 
    margin-bottom:15px; 
}
body.dark-mode .hero p { 
    color:#cbd5e1; 
}

.btn-primary { 
    padding:10px 20px; 
    background:var(--primary-color); 
    color:white; 
    border:none; 
    border-radius:50px; 
    cursor:pointer; 
    font-weight:600; 
    box-shadow:0 4px 15px rgba(26,86,219,0.2); 
    transition:all 0.3s; 
    text-decoration:none; 
    display:inline-block; 
}
.btn-primary:hover { 
    background:#1648b5; 
    transform:translateY(-2px); 
    box-shadow:0 8px 20px rgba(26,86,219,0.3); 
}

table { 
    width:100%; 
    border-collapse:collapse; 
    font-size:0.95rem; 
}
thead tr { 
    background:#f1f5f9; 
}
body.dark-mode table thead tr { 
    background:#1e293b; 
}
th, td { 
    padding:12px; 
    text-align:left; 
    border-bottom:1px solid #eee; 
}
body.dark-mode th, body.dark-mode td { 
    border-color:#334155; 
    color:#f1f5f9; 
}

.status-pass { 
    background:#d1fae5; 
    color:#065f46; 
    padding:6px 10px; 
    border-radius:20px; 
    display:inline-block; 
}
.status-fail { 
    background:#fee2e2; 
    color:#b91c1c; 
    padding:6px 10px; 
    border-radius:20px; 
    display:inline-block; 
}

/* Student name links in table */
.student-name-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border-bottom: 1px solid transparent;
}

.student-name-link:hover {
    color: #1648b5;
    border-bottom: 1px solid #1648b5;
    transform: translateX(2px);
}

body.dark-mode .student-name-link {
    color: #93c5fd;
}

body.dark-mode .student-name-link:hover {
    color: #60a5fa;
    border-bottom-color: #60a5fa;
}

/* ------------------ Scrollable Table ------------------ */
.table-container {
    max-height: 400px;
    overflow-y: auto;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    margin-bottom: 20px;
}

.table-container::-webkit-scrollbar {
    width: 8px;
}

.table-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

body.dark-mode .table-container {
    border-color: #374151;
}

body.dark-mode .table-container::-webkit-scrollbar-track {
    background: #374151;
}

body.dark-mode .table-container::-webkit-scrollbar-thumb {
    background: #6b7280;
}

body.dark-mode .table-container::-webkit-scrollbar-thumb:hover {
    background: #9ca3af;
}

.table-container table {
    margin-bottom: 0;
}

.table-container thead th {
    position: sticky;
    top: 0;
    z-index: 10;
    background: #f1f5f9;
    border-bottom: 2px solid #d1d5db;
}

body.dark-mode .table-container thead th {
    background: #1e293b;
    border-bottom-color: #374151;
}

body.dark-mode .performance-section h2 {
    color: #93c5fd !important;
}

body.dark-mode .performance-section h2 span:last-child {
    color: #cbd5e1 !important;
}

/* ------------------ Student List Card ------------------ */
.student-list-card {
    background: #fff;
    padding: 25px 30px;
    border-radius: 15px;
    box-shadow: var(--card-shadow);
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.student-list-card:hover {
    box-shadow: var(--card-hover-shadow);
    transform: translateY(-2px);
}

body.dark-mode .student-list-card {
    background: #1e293b;
    box-shadow:0 4px 8px rgba(0,0,0,0.2);
}

.student-list-card h3 {
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 20px;
}

/* Individual student items */
.student-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 15px;
    background: #f9fafb;
    border-radius: 8px;
    margin-bottom: 10px;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
    cursor: pointer;
}

.student-item:hover {
    box-shadow: var(--card-hover-shadow);
    transform: translateY(-2px);
}

.student-item a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    text-decoration: none;
    color: var(--dark-color);
    font-weight: 600;
    padding: 5px 10px;
    transition: all 0.3s ease;
}

.student-item a:hover {
    color: var(--primary-color);
    text-decoration: underline;
}

.student-email {
    font-size: 0.9rem;
    color: var(--dark-gray);
}

body.dark-mode .student-item {
    background: #334155;
}

body.dark-mode .student-item a { 
    color:#f1f5f9; 
}
body.dark-mode .student-item a:hover { 
    color:#93c5fd; 
}
body.dark-mode .student-email { 
    color:#cbd5e1; 
}
</style>
</head>
<body>
    <div class="lecturer-layout">
        <?= generateSidebar('studentPerformance.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">Student Performance Tracking</h1>
                <div class="user-actions">
                    <button id="darkModeToggle" class="dark-mode-btn">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="user-avatar"><?= $initials ?></div>
                    <span><?= $fullName ?></span>
                </div>
            </div>

            <div class="content-body">

            <div class="content-body">
                <div class="hero">
                    <h1>Student Performance Tracking</h1>
                    <p>View all student simulation attempts. Search by student name or click a student to filter.</p>
                    <form method="get" style="margin-top:15px; display:flex; justify-content:center; gap:10px;">
                        <input type="text" name="search" placeholder="Search student name..." value="<?= htmlspecialchars($search) ?>" style="padding:8px 15px; border-radius:6px; border:1px solid var(--gray-color); width:400px;">
                        <button type="submit" class="btn-primary"><i class="fas fa-search"></i> Search</button>
                    </form>
                </div>

    <section class="performance-section">
        <h2 style="margin-bottom: 20px; color: var(--primary-color); display: flex; justify-content: space-between; align-items: center;">
            <span>Performance Records</span>
            <span style="font-size: 0.9rem; font-weight: normal; color: var(--dark-gray);">
                <?= count($records) ?> record(s) found
            </span>
        </h2>
        <?php if (!empty($records)): ?>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Student</th>
                        <th>Scenario</th>
                        <th>Score</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $r): ?>
                    <tr>
                        <td>
                            <a href="studentDashboardLecturer.php?student_id=<?= $r['student_id'] ?>" class="student-name-link">
                                <?= htmlspecialchars($r['student_name']) ?>
                            </a>
                        </td>
                        <td><?= htmlspecialchars($r['scenario_title'] ?? 'Automotive #' . $r['scenario_id']) ?></td>
                        <td><?= (int)$r['score'] ?>%</td>
                        <td><span class="<?= $r['status']==='passed'?'status-pass':'status-fail' ?>"><?= ucfirst($r['status']) ?></span></td>
                        <td><?= date('d M Y, H:i', strtotime($r['completed_at'])) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p>No performance data yet.</p>
        <?php endif; ?>
    </section>

                <div class="student-list-card">
                    <h3>Student List</h3>
                    <div class="student-list">
                        <?php if (empty($students)): ?>
                            <p>No students found.</p>
                        <?php else: ?>
                            <?php foreach ($students as $s): ?>
                            <div class="student-item">
                                <a href="studentDashboardLecturer.php?student_id=<?= $s['id'] ?>" class="student-card">
                                    <span class="student-name"><?= htmlspecialchars($s['full_name']) ?></span>
                                    <span class="student-email"><?= htmlspecialchars($s['email']) ?></span>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/darkmode-fixed.js"></script>
    <script>
        // Mobile sidebar toggle and optimizations
        document.addEventListener('DOMContentLoaded', function() {
            if (window.innerWidth <= 768) {
                document.body.classList.add('mobile-view');
                
                const sidebar = document.querySelector('.sidebar');
                const toggleBtn = document.createElement('button');
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
                toggleBtn.className = 'mobile-toggle';
                toggleBtn.style.cssText = `
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    z-index: 1001;
                    background: linear-gradient(135deg, #1a56db, #0d47a1);
                    color: white;
                    border: none;
                    padding: 12px 14px;
                    border-radius: 8px;
                    cursor: pointer;
                    box-shadow: 0 4px 15px rgba(26, 86, 219, 0.3);
                `;
                
                document.body.appendChild(toggleBtn);
                
                // Create overlay
                const overlay = document.createElement('div');
                overlay.className = 'sidebar-overlay';
                overlay.style.cssText = `
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 999;
                    display: none;
                    opacity: 0;
                    transition: opacity 0.3s ease;
                `;
                document.body.appendChild(overlay);
                
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    overlay.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
                    setTimeout(() => {
                        overlay.style.opacity = sidebar.classList.contains('mobile-open') ? '1' : '0';
                    }, 10);
                });
                
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-open');
                    overlay.style.opacity = '0';
                    setTimeout(() => {
                        overlay.style.display = 'none';
                    }, 300);
                });

                // Mobile-optimize performance tables and charts
                const performanceTables = document.querySelectorAll('table');
                performanceTables.forEach(table => {
                    // Add mobile-friendly table wrapper
                    const wrapper = document.createElement('div');
                    wrapper.style.cssText = `
                        overflow-x: auto;
                        -webkit-overflow-scrolling: touch;
                        border-radius: 8px;
                        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                    `;
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                    
                    // Add data labels for mobile
                    const headers = Array.from(table.querySelectorAll('th')).map(th => th.textContent);
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        cells.forEach((cell, index) => {
                            if (headers[index]) {
                                cell.setAttribute('data-label', headers[index]);
                            }
                        });
                    });
                });

                // Mobile-optimize forms and search
                const searchInputs = document.querySelectorAll('input[type="search"], input[type="text"]');
                searchInputs.forEach(input => {
                    input.style.fontSize = '16px'; // Prevent zoom on iOS
                    input.style.minHeight = '48px';
                    input.style.padding = '12px 15px';
                    
                    input.addEventListener('focus', function() {
                        setTimeout(() => {
                            this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    });
                });

                // Mobile-optimize buttons
                const buttons = document.querySelectorAll('button, .btn, input[type="submit"]');
                buttons.forEach(button => {
                    button.style.minHeight = '48px';
                    button.style.padding = '12px 20px';
                    button.style.fontSize = '16px';
                    button.style.touchAction = 'manipulation';
                    
                    button.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.98)';
                    });
                    
                    button.addEventListener('touchend', function() {
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 100);
                    });
                });

                // Add fade-in animation for performance sections
                const performanceSections = document.querySelectorAll('.performance-section');
                performanceSections.forEach((section, index) => {
                    section.classList.add('fade-in-mobile');
                    section.style.animationDelay = `${index * 0.1}s`;
                });
            }
        });
    </script>
</body>
</html>
