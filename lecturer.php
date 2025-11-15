<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: project.php");
    exit();
}

// Redirect if logged in as student (only lecturers allowed)
if ($_SESSION['role'] !== 'lecturer') {
    header("Location: studentDashboard.php");
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

$host = 'localhost';
$db = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';
$dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Fetch student information instead of performance data
$stmt = $pdo->query("
    SELECT 
        u.id,
        u.full_name,
        u.email,
        u.created_at,
        COUNT(p.id) as total_scenarios,
        ROUND(AVG(p.score), 1) as average_score,
        MAX(p.completed_at) as last_activity
    FROM users u
    LEFT JOIN performance p ON u.id = p.student_id
    WHERE u.role = 'student'
    GROUP BY u.id, u.full_name, u.email, u.created_at
    ORDER BY u.full_name ASC
");
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lecturer Dashboard - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css?v=<?= time() ?>">
    <style>
        /* Page-specific styles - Modern & Colorful Design */
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 50px 40px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: heroFloat 6s ease-in-out infinite;
        }

        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        .hero h1 {
            font-size: 3rem;
            margin-bottom: 20px;
            color: white;
            line-height: 1.2;
            font-weight: 700;
            position: relative;
            z-index: 2;
        }

        .hero p {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 30px;
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            font-size: 1rem;
            margin: 0 10px 10px 0;
            position: relative;
            z-index: 2;
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .btn-outline:first-of-type {
            background: linear-gradient(135deg, #e67e22, #d35400);
            border-color: #d35400;
        }

        .btn-outline:first-of-type:hover {
            background: linear-gradient(135deg, #d35400, #c0392b);
            transform: translateY(-3px) scale(1.05);
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 15px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .action-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s;
        }

        .action-card:hover::before {
            left: 100%;
        }

        .action-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .action-card i {
            font-size: 3rem;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .action-card:nth-child(1) i { color: #3498db; }
        .action-card:nth-child(2) i { color: #e67e22; }
        .action-card:nth-child(3) i { color: #27ae60; }
        .action-card:nth-child(4) i { color: #8e44ad; }
        .action-card:nth-child(5) i { color: #e74c3c; }

        .action-card:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        .action-card h4 {
            margin-bottom: 10px;
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .action-card p {
            color: #7f8c8d;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .action-card a {
            text-decoration: none;
            color: inherit;
        }

        .performance-section {
            background: white;
            padding: 40px;
            margin: 30px 0;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .performance-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(135deg, #3498db, #e67e22);
        }

        .performance-section h2 {
            font-size: 2rem;
            margin-bottom: 30px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .performance-section h2::before {
            content: '';
            width: 50px;
            height: 4px;
            background: linear-gradient(135deg, #3498db, #e67e22);
            border-radius: 2px;
        }

        .table-container {
            max-height: 500px;
            overflow-y: auto;
            overflow-x: auto;
            border: 1px solid #e5e7eb;
            border-radius: 15px;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .table-container table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .table-container thead tr {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .table-container th {
            padding: 18px 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        .table-container td {
            padding: 18px 15px;
            border-bottom: 1px solid #f1f3f4;
            transition: background-color 0.2s ease;
        }

        .table-container tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-container::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f8f9fa;
            border-radius: 6px;
            margin: 4px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #3498db, #e67e22);
            border-radius: 6px;
            border: 2px solid #f8f9fa;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #2980b9, #d35400);
        }

        .table-container::-webkit-scrollbar-corner {
            background: #f8f9fa;
        }

        /* Add scroll indicator */
        .table-container::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent 0%, rgba(52, 152, 219, 0.3) 50%, transparent 100%);
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .table-container:hover::after {
            opacity: 1;
        }

        /* Enhanced status badges */
        .table-container span[style*="background:#d1fae5"] {
            background: linear-gradient(135deg, #d4edda, #c3e6cb) !important;
            color: #155724 !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        .table-container span[style*="background:#fee2e2"] {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb) !important;
            color: #721c24 !important;
            padding: 6px 12px !important;
            border-radius: 20px !important;
            font-size: 0.8rem !important;
            font-weight: 600 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
        }

        /* Student information table styles */
        .student-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .student-avatar-small {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: linear-gradient(135deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }

        .email-cell {
            color: #7f8c8d !important;
            font-size: 0.9rem;
        }

        .email-cell i {
            margin-right: 8px;
            color: #bdc3c7;
        }

        .count-badge {
            background: linear-gradient(135deg, #e3f2fd, #bbdefb);
            color: #1565c0;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .score-badge {
            padding: 4px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            text-align: center;
            min-width: 60px;
            display: inline-block;
        }

        .score-excellent {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .score-good {
            background: linear-gradient(135deg, #d1ecf1, #bee5eb);
            color: #0c5460;
        }

        .score-fair {
            background: linear-gradient(135deg, #fff3cd, #ffeaa7);
            color: #856404;
        }

        .score-poor {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        .no-data, .no-activity {
            color: #bdc3c7;
            font-style: italic;
            font-size: 0.85rem;
        }

        .scenarios-count {
            text-align: center;
        }

        .activity-cell {
            font-size: 0.9rem;
            color: #6c757d;
        }

        /* Scroll hint styling */
        .scroll-hint {
            text-align: center;
            padding: 15px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 0 0 15px 15px;
            color: #6c757d;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            animation: scrollHintPulse 2s ease-in-out infinite;
        }

        @keyframes scrollHintPulse {
            0%, 100% { opacity: 0.7; }
            50% { opacity: 1; }
        }

        .scroll-hint i {
            animation: scrollArrowBounce 1.5s ease-in-out infinite;
        }

        @keyframes scrollArrowBounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(3px); }
        }

        /* Dark mode enhancements */
        body.dark-mode .hero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
        }

        body.dark-mode .action-card,
        body.dark-mode .performance-section {
            background-color: #1e293b !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
        }

        body.dark-mode .action-card h4,
        body.dark-mode .performance-section h2 {
            color: #93c5fd !important;
        }

        body.dark-mode .action-card p {
            color: #cbd5e1 !important;
        }

        body.dark-mode .table-container thead tr {
            background: linear-gradient(135deg, #374151, #4b5563) !important;
        }

        body.dark-mode .table-container th {
            color: #e5e7eb !important;
            border-bottom-color: #6b7280 !important;
        }

        body.dark-mode .table-container td {
            border-bottom-color: #374151 !important;
            color: #e5e7eb !important;
        }

        body.dark-mode .table-container tbody tr:hover {
            background-color: #374151 !important;
        }

        body.dark-mode .table-container {
            border-color: #4b5563 !important;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .hero {
                padding: 30px 20px;
            }

            .hero h1 {
                font-size: 2.2rem;
            }

            .btn-outline {
                width: 100%;
                max-width: 280px;
                justify-content: center;
                margin: 5px 0;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }

            .performance-section {
                padding: 25px 20px;
            }

            .table-container {
                font-size: 0.85rem;
            }

            .table-container th,
            .table-container td {
                padding: 12px 10px;
            }
        }
    </style>
</head>

<body>
    <div class="lecturer-layout">
        <?= generateSidebar('lecturer.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">Lecturer Dashboard</h1>
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
                <!-- Hero Section -->
                <div class="hero">
                    <h1>Welcome to Your Automotive Teaching Hub</h1>
                    <p>Manage your troubleshooting simulations, track student progress, and enhance learning outcomes in automotive technology.</p>
                    <a href="createScenario.php" class="btn-outline"><i class="fas fa-edit"></i> Create New Scenario</a>
                    <a href="manageScenario.php" class="btn-outline"><i class="fas fa-edit"></i> Manage Scenarios</a>
                </div>
                
                <!-- Student Information Section -->
                <section class="performance-section">
                    <h2><i class="fas fa-users"></i> Student Information</h2>

                    <?php if ($students): ?>
                        <div class="table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-user"></i> Student Name</th>
                                        <th><i class="fas fa-envelope"></i> Email</th>
                                        <th><i class="fas fa-calendar-plus"></i> Joined Date</th>
                                        <th><i class="fas fa-chart-bar"></i> Total Scenarios</th>
                                        <th><i class="fas fa-percentage"></i> Average Score</th>
                                        <th><i class="fas fa-clock"></i> Last Activity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr class="table-row">
                                            <td class="student-name">
                                                <div class="student-info">
                                                    <div class="student-avatar-small">
                                                        <?= strtoupper(substr($student['full_name'], 0, 1)) ?>
                                                    </div>
                                                    <span><?= htmlspecialchars($student['full_name']) ?></span>
                                                </div>
                                            </td>
                                            <td class="email-cell">
                                                <i class="fas fa-envelope"></i>
                                                <?= htmlspecialchars($student['email']) ?>
                                            </td>
                                            <td class="date-cell">
                                                <?= date('M d, Y', strtotime($student['created_at'])) ?>
                                            </td>
                                            <td class="scenarios-count">
                                                <span class="count-badge">
                                                    <?= $student['total_scenarios'] ?> scenarios
                                                </span>
                                            </td>
                                            <td class="score-cell">
                                                <?php if ($student['average_score']): ?>
                                                    <span class="score-badge score-<?= $student['average_score'] >= 80 ? 'excellent' : ($student['average_score'] >= 70 ? 'good' : ($student['average_score'] >= 60 ? 'fair' : 'poor')) ?>">
                                                        <?= $student['average_score'] ?>%
                                                    </span>
                                                <?php else: ?>
                                                    <span class="no-data">No attempts</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="activity-cell">
                                                <?php if ($student['last_activity']): ?>
                                                    <?= date('M d, Y • H:i', strtotime($student['last_activity'])) ?>
                                                <?php else: ?>
                                                    <span class="no-activity">No activity</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (count($students) > 5): ?>
                            <div class="scroll-hint">
                                <i class="fas fa-arrow-down"></i>
                                <span>Scroll to view all <?= count($students) ?> students</span>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="no-data-message">
                            <i class="fas fa-users"></i>
                            <p>No students registered yet.</p>
                            <span>Students will appear here once they create accounts.</span>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- Quick Actions -->
                <div class="quick-actions">
                    <div class="action-card">
                        <i class="fas fa-download"></i>
                        <h4><a href="exportStudentReports.php">Export Student Reports</a></h4>
                        <p>Download detailed student performance reports in PDF or CSV format.</p>
                    </div>

                    <div class="action-card">
                        <i class="fas fa-robot"></i>
                        <h4><a href="aiChatbotLecturer.php">AI Chatbot Assistant</a></h4>
                        <p>Get quick answers to technical questions using our AI-powered assistant.</p>
                    </div>

                    <a href="helpSupport.php" class="action-card">
                        <i class="fas fa-question-circle"></i>
                        <h4>Help & Support</h4>
                        <p>Access user guides, FAQs, and contact support for assistance.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Ensure sidebar is properly positioned
        document.addEventListener('DOMContentLoaded', function() {
            // Force layout recalculation
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebar) {
                sidebar.style.position = 'fixed';
                sidebar.style.left = '0';
                sidebar.style.top = '0';
                sidebar.style.width = '250px';
                sidebar.style.height = '100vh';
                sidebar.style.zIndex = '1000';
                sidebar.style.backgroundColor = 'white';
                sidebar.style.boxShadow = '2px 0 10px rgba(0,0,0,0.1)';
            }
            
            if (mainContent) {
                mainContent.style.marginLeft = '250px';
            }

            // Dark mode toggle functionality
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;

            // Check saved preference
            const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
            if (isDarkMode) {
                body.classList.add('dark-mode');
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }

            // Toggle on click
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', () => {
                    body.classList.toggle('dark-mode');
                    const isNowDark = body.classList.contains('dark-mode');
                    localStorage.setItem('darkMode', isNowDark ? 'enabled' : 'disabled');
                    darkModeToggle.innerHTML = isNowDark ?
                        '<i class="fas fa-sun"></i>' :
                        '<i class="fas fa-moon"></i>';
                });
            }

            // Mobile sidebar toggle
            if (window.innerWidth <= 768) {
                const toggleBtn = document.createElement('button');
                toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
                toggleBtn.className = 'mobile-toggle';
                toggleBtn.style.cssText = `
                    position: fixed;
                    top: 20px;
                    left: 20px;
                    z-index: 1001;
                    background: var(--primary-color);
                    color: white;
                    border: none;
                    padding: 10px;
                    border-radius: 6px;
                    cursor: pointer;
                `;
                
                document.body.appendChild(toggleBtn);
                
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                });
            }
        });
    </script>
</body>

</html>