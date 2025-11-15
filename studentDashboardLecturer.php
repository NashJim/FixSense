<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}

// Get student ID from URL parameter
$studentId = $_GET['student_id'] ?? null;
if (!$studentId) {
    header("Location: studentPerformance.php");
    exit();
}

// DB connection
$host = 'localhost';
$db = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Get student information
$stmt = $pdo->prepare("SELECT id, full_name, email FROM users WHERE id = ? AND role = 'student'");
$stmt->execute([$studentId]);
$student = $stmt->fetch();

if (!$student) {
    header("Location: studentPerformance.php");
    exit();
}

// === Rekod login harian (untuk streak) ===
$stmt = $pdo->prepare("SELECT login_date FROM login_logs WHERE user_id = ? ORDER BY login_date DESC");
$stmt->execute([$studentId]);
$dates = $stmt->fetchAll(PDO::FETCH_COLUMN);

$currentStreak = 0;
if (!empty($dates)) {
    $tz = new DateTimeZone('Asia/Kuala_Lumpur');
    $expected = new DateTime('today', $tz);

    foreach ($dates as $d) {
        $login = new DateTime($d, $tz);
        $diff = (int)$expected->diff($login)->format('%a');

        if ($diff === 0) { 
            $currentStreak++;
            $expected->modify('-1 day');
        } elseif ($diff === 1) { 
            $currentStreak++;
            $expected->modify('-1 day');
        } else break;
    }
}

// === Fetch performance data ===
$stmt = $pdo->prepare("
    SELECT scenario_id, score, status, completed_at
    FROM performance
    WHERE student_id = ?
    ORDER BY completed_at DESC
");
$stmt->execute([$studentId]);
$records = $stmt->fetchAll();

// === Kira statistik prestasi ===
$totalScenarios = count($records);
$overallAccuracy = $totalScenarios > 0 ? round(array_sum(array_column($records, 'score')) / $totalScenarios) : 0;

// === Map scenario_id ke title dan category ===
$scenarioTitles = [];
$scenarioCategories = [];

$stmt = $pdo->query("SELECT id, title, category FROM scenarios");
while ($row = $stmt->fetch()) {
    $scenarioTitles[(string)$row['id']] = $row['title'];
    $scenarioCategories[(string)$row['id']] = $row['category'];
}




// === Kira kemajuan mengikut kategori ===
$categoryScores = [];
foreach ($records as $r) {
    $id = (string)$r['scenario_id'];
    $cat = $scenarioCategories[$id] ?? 'Other';
    $categoryScores[$cat][] = $r['score'];
}


$categoryProgress = [];
foreach ($categoryScores as $cat => $scores) {
    $categoryProgress[$cat] = round(array_sum($scores) / count($scores));
}

$allCategories = array_unique(array_values($scenarioCategories));
foreach ($allCategories as $cat) {
    if (!isset($categoryProgress[$cat])) $categoryProgress[$cat] = 0;
}


// === Recent Activity (4 terkini) ===
$recentActivity = [];
foreach (array_slice($records, 0, 4) as $r) {
    $id = trim((string)$r['scenario_id']); // pastikan tak ada spacing
    $title = $scenarioTitles[$id] ?? 'Scenario #' . $id;
    // match betul guna string juga
    if (isset($scenarioTitles[$id])) {
        $title = $scenarioTitles[$id];
    } elseif (isset($scenarioTitles[(float)$id])) {
        $title = $scenarioTitles[(float)$id];
    } else {
        $title = 'Scenario #' . $id;
    }

    $recentActivity[] = [
        'type' => 'completed',
        'title' => 'Scenario Completed',
        'description' => 'You successfully diagnosed "' . $title . '" with ' . $r['score'] . '% accuracy.',
        'time' => date('g:i A', strtotime($r['completed_at']))
    ];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($student['full_name']) ?> - Performance Report - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/darkmode.css">
    <style>
        /* Your existing CSS - kept exactly as is */
        :root {
            --primary-color: #1a56db;
            --secondary-color: #ff6b35;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --gray-color: #e2e8f0;
            --dark-gray: #718096;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Dashboard Header Styles */
        .dashboard-header {
            background: linear-gradient(135deg, #ffffff, #f8fafc);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
            border: 1px solid #e2e8f0;
        }

        .back-navigation {
            margin-bottom: 20px;
        }

        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #1a56db, #1648b5);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.2);
        }

        .back-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 86, 219, 0.3);
            background: linear-gradient(135deg, #1648b5, #1a56db);
        }

        .student-info-header {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .student-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ff6b35, #e55a2b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
        }

        .student-details {
            flex: 1;
        }

        .student-name {
            font-size: 2.2rem;
            color: var(--dark-color);
            margin: 0 0 5px 0;
            font-weight: 700;
        }

        .student-email {
            color: var(--primary-color);
            font-size: 1.1rem;
            margin: 0 0 8px 0;
            font-weight: 500;
        }

        .page-subtitle {
            color: var(--dark-gray);
            font-size: 1rem;
            margin: 0;
            line-height: 1.5;
        }

        /* Dark mode for dashboard header */
        body.dark-mode .dashboard-header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            border-color: #334155;
        }

        body.dark-mode .student-name {
            color: #93c5fd;
        }

        body.dark-mode .student-email {
            color: #60a5fa;
        }

        body.dark-mode .page-subtitle {
            color: #cbd5e1;
        }

        /* Main Content */
        main {
            padding: 40px 0;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card-header i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .card-header h3 {
            font-size: 1.3rem;
            color: var(--dark-color);
        }

        .card-body p {
            margin-bottom: 15px;
        }

        /* Stats Summary */
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--dark-gray);
            font-size: 1rem;
        }

        /* Progress Section */
        .progress-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .progress-item {
            margin-bottom: 25px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-bar {
            height: 12px;
            background-color: var(--gray-color);
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 6px;
            width: 0;
            transition: width 1s ease-in-out;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--card-shadow);
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #dbeafe;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-content h4 {
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .activity-content p {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--secondary-color);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 12px;
        }

        .footer-column ul li a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #4a5568;
            border-radius: 50%;
            color: white;
            transition: background-color 0.3s;
        }

        .social-links a:hover {
            background-color: var(--secondary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #4a5568;
            color: #cbd5e0;
            font-size: 0.9rem;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }

        .dark-mode header,
        .dark-mode .card,
        .dark-mode .stat-card,
        .dark-mode .progress-section,
        .dark-mode .recent-activity,
        .dark-mode footer {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }

        .dark-mode .nav-links a {
            color: #f1f5f9 !important;
        }

        .dark-mode .nav-links a:hover {
            color: #93c5fd !important;
        }

        .dark-mode .page-title,
        .dark-mode .section-title,
        .dark-mode .card-header h3 {
            color: #93c5fd !important;
        }

        .dark-mode .stat-value {
            color: #60a5fa !important;
        }

        .dark-mode .activity-content p,
        .dark-mode .activity-time,
        .dark-mode .stat-label {
            color: #cbd5e1 !important;
        }

        .dark-mode .breadcrumb {
            color: #cbd5e1 !important;
        }

        .dark-mode .breadcrumb a {
            color: #93c5fd !important;
        }

        body {
            transition: background-color 0.3s, color 0.3s;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 80px;
                right: -100%;
                flex-direction: column;
                background-color: white;
                width: 80%;
                height: calc(100vh - 80px);
                padding: 20px;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
                transition: right 0.3s ease;
                z-index: 99;
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                margin: 15px 0;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .stats-summary {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Main Content -->
    <main style="padding-top: 40px;">
        <div class="container">
            <!-- Header Section with Back Button and Student Info -->
            <div class="dashboard-header">
                <div class="back-navigation">
                    <a href="studentPerformance.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back to Student Performance
                    </a>
                </div>
                
                <div class="student-info-header">
                    <div class="student-avatar">
                        <?= strtoupper(substr($student['full_name'], 0, 1)) ?>
                    </div>
                    <div class="student-details">
                        <h1 class="student-name"><?= htmlspecialchars($student['full_name']) ?></h1>
                        <p class="student-email"><?= htmlspecialchars($student['email']) ?></p>
                        <p class="page-subtitle">Detailed performance analysis and progress tracking</p>
                    </div>
                </div>
            </div>

            <!-- Stats Summary -->
            <div class="stats-summary">
                <div class="stat-card">
                    <div class="stat-value"><?= $overallAccuracy ?>%</div>
                    <div class="stat-label">Overall Accuracy</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= $totalScenarios ?></div>
                    <div class="stat-label">Scenarios Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= $currentStreak ?></div>
                    <div class="stat-label">Login Streak (Days)</div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        <h3>Student Profile</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?= htmlspecialchars($student['full_name']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
                        <p><strong>Institution:</strong> ILP Kuantan</p>
                        <p><strong>Student ID:</strong> #<?= $student['id'] ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-trophy"></i>
                        <h3>Student Achievements</h3>
                    </div>
                    <div class="card-body">
                        <p>Performance milestones reached:</p>
                        <ul style="margin-top: 10px; padding-left: 20px; font-size: 0.9rem;">
                            <?php if ($totalScenarios >= 1 ): ?>
                                <li>✅ First Steps (Complete 1 scenario)</li>
                            <?php endif; ?>
                            <?php if ($totalScenarios >= 5 ): ?>
                                <li>✅ Quick Learner (Complete 5 scenarios)</li>
                            <?php endif; ?>
                            <?php if ($totalScenarios >= 10 ): ?>
                                <li>✅ Rising Mechanic (Complete 10 scenarios)</li>
                            <?php endif; ?>
                            
                            <?php if ($totalScenarios >= 20  ): ?>
                                <li>✅ Automotive Pro (Complete 20 scenarios)</li> 
                            <?php endif; ?>
                            <?php if ($totalScenarios >= 30 ): ?>
                                <li>✅ Master Mechanic (Complete 30 scenarios)</li>  
                            <?php endif; ?> 
                            <?php if ($totalScenarios >= 40 ): ?>
                                <li>✅ FixSense Guru (Complete 40+ scenarios)</li>
                            <?php endif; ?>
                             <?php if ($totalScenarios >= 50 ): ?>
                                <li>✅ Master Mechanic (Complete 50+ scenarios)</li>  
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Progress Section -->
            <div class="progress-section">
                <h2 class="section-title"><i class="fas fa-chart-line"></i> Progress by Automotive Sub-System</h2>

                <?php foreach ($categoryProgress as $category => $score): ?>
                    <div class="progress-item">
                        <div class="progress-header">
                            <span><?= htmlspecialchars($category) ?></span>
                            <span><?= $score ?>%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" data-width="<?= $score ?>%"></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Recent Activity -->
            <div class="recent-activity">
                <h2 class="section-title"><i class="fas fa-history"></i> Recent Student Activity</h2>
                <ul class="activity-list">
                    <?php if (!empty($recentActivity)): ?>
                        <?php foreach ($recentActivity as $activity): ?>
                            <li class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div class="activity-content">
                                    <h4><?= htmlspecialchars($activity['title']) ?></h4>
                                    <p><?= htmlspecialchars($activity['description']) ?></p>
                                    <span class="activity-time"><?= htmlspecialchars($activity['time']) ?></span>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <li class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="activity-content">
                                <h4>No Activity Yet</h4>
                                <p>This student has not completed any simulations yet.</p>
                                <span class="activity-time">-</span>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FixSense</h3>
                    <p>Master Troubleshooting, Anytime, Anywhere. Web-based platform for technical skill development in automotive, electrical, and electronics fields.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="project.php">Home</a></li>
                        <li><a href="simulationSelection.php">Simulations</a></li>
                        <li><a href="ai-chatbot.php">AI Chatbot</a></li>
                        <li><a href="studentPerformance.php">Performance Tracking</a></li>
                        <li><a href="lecturer.php">Lecturer Portal</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#">Getting Started Guide</a></li>
                        <li><a href="#">Troubleshooting Manual</a></li>
                        <li><a href="#">Video Tutorials</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Technical Support</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> support@fixsense.com</li>
                        <li><i class="fas fa-phone"></i> +60 xx xxx xxxx</li>
                        <li><i class="fas fa-map-marker-alt"></i> ILP Kuantan, Pahang</li>
                    </ul>
                    <ul style="margin-top: 20px;">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 FixSense. All rights reserved. Developed for ILP Kuantan Technical Education.</p>
            </div>
        </div>
    </footer>

    <script src="js/darkmode-fixed.js"></script>
    <script>
        // Mobile Navigation Toggle
        document.querySelector('.mobile-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.nav-links').classList.remove('active');
            });
        });

        // Progress Bar Animation
        document.addEventListener('DOMContentLoaded', function() {
            const progressBars = document.querySelectorAll('.progress-fill');
            progressBars.forEach(bar => {
                const width = bar.getAttribute('data-width');
                setTimeout(() => {
                    bar.style.width = width;
                }, 300);
            });
        });
    </script>

    <!-- Floating Dark Mode Toggle -->
    <div class="floating-dark-mode">
        <button id="darkModeToggle" class="dark-mode-fab">
            <i class="fas fa-moon"></i>
        </button>
    </div>

    <style>
        /* Floating Dark Mode Button */
        .floating-dark-mode {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
        }

        .dark-mode-fab {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), #1648b5);
            color: white;
            border: none;
            box-shadow: 0 4px 20px rgba(26, 86, 219, 0.3);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            transition: all 0.3s ease;
            animation: float 3s ease-in-out infinite;
        }

        .dark-mode-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 25px rgba(26, 86, 219, 0.4);
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        body.dark-mode .dark-mode-fab {
            background: linear-gradient(135deg, #ff6b35, #e55a2b);
            box-shadow: 0 4px 20px rgba(255, 107, 53, 0.3);
        }

        body.dark-mode .dark-mode-fab:hover {
            box-shadow: 0 6px 25px rgba(255, 107, 53, 0.4);
        }

        /* Add some subtle animations to existing elements */
        .dashboard-header {
            animation: slideInDown 0.8s ease-out;
        }

        .stats-summary {
            animation: slideInUp 0.8s ease-out 0.2s both;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced background */
        body {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            min-height: 100vh;
        }

        body.dark-mode {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        }

        /* Mobile responsiveness for floating button */
        @media (max-width: 768px) {
            .floating-dark-mode {
                bottom: 20px;
                right: 20px;
            }
            
            .dark-mode-fab {
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }
        }
    </style>

    <script>
        // Dark mode toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            
            // Check for saved dark mode preference
            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
                darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            }
            
            darkModeToggle.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                    darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
                }
            });
        });
    </script>
</body>

</html>
.sidebar a{display:block;padding:12px;color:#718096;text-decoration:none;margin-bottom:8px;border-radius:6px;}
.sidebar a:hover{background:#f1f5f9;color:#1a56db;}
.main{margin-left:270px;padding:30px;}
.card{background:#fff;padding:20px;margin-bottom:20px;border-radius:10px;box-shadow:0 4px 6px rgba(0,0,0,0.1);}
.table{width:100%;border-collapse:collapse;}
.table th,.table td{padding:10px;border-bottom:1px solid #eee;text-align:left;}
.status-pass{background:#d1fae5;color:#065f46;padding:6px 10px;border-radius:20px;}
.status-fail{background:#fee2e2;color:#b91c1c;padding:6px 10px;border-radius:20px;}
 :root {
            --primary-color: #1a56db;
            --secondary-color: #ff6b35;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --gray-color: #e2e8f0;
            --dark-gray: #718096;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --card-hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }

        .logo i {
            margin-right: 10px;
            color: var(--secondary-color);
        }

        .nav-links {
            display: flex;
            list-style: none;
        }

        .nav-links li {
            margin-left: 30px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .auth-buttons {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .btnLogout {
            display: inline-block;
            padding: 12px 24px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .btnLogout:hover {
            background-color: #e55a2b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* === AUTH BUTTONS HOVER & DARK MODE STYLES === */
        .auth-buttons button {
            transition: all 0.2s ease;
        }

        /* Dark Mode Styles for Auth Buttons */
        .dark-mode .auth-buttons #greeting {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }

        .dark-mode .auth-buttons #logoutBtn {
            background-color: #ef4444 !important;
            color: white !important;
        }

        .dark-mode .auth-buttons #logoutBtn:hover {
            background-color: #dc2626 !important;
        }

        .dark-mode .auth-buttons #greeting:hover {
            background-color: #1e293b !important;
        }

        .dark-mode .auth-buttons #darkModeToggle {
            background-color: #333 !important;
        }

        .dark-mode .auth-buttons #darkModeToggle i {
            color: #f1f5f9 !important;
        }

        .mobile-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Main Content */
        main {
            padding: 40px 0;
        }

        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        .page-subtitle {
            color: var(--dark-gray);
            font-size: 1.1rem;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Dashboard Grid */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .card-header i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .card-header h3 {
            font-size: 1.3rem;
            color: var(--dark-color);
        }

        .card-body p {
            margin-bottom: 15px;
        }

        /* Stats Summary */
        .stats-summary {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .stat-label {
            color: var(--dark-gray);
            font-size: 1rem;
        }

        /* Progress Section */
        .progress-section {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 40px;
        }

        .section-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .progress-item {
            margin-bottom: 25px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .progress-bar {
            height: 12px;
            background-color: var(--gray-color);
            border-radius: 6px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background-color: var(--primary-color);
            border-radius: 6px;
            width: 0;
            transition: width 1s ease-in-out;
        }

        /* Recent Activity */
        .recent-activity {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: var(--card-shadow);
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--gray-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #dbeafe;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .activity-content {
            flex-grow: 1;
        }

        .activity-content h4 {
            margin-bottom: 5px;
            font-size: 1rem;
        }

        .activity-content p {
            color: var(--dark-gray);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 0.8rem;
            color: var(--dark-gray);
        }

        /* Footer */
        footer {
            background-color: var(--dark-color);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }

        .footer-column h3 {
            font-size: 1.3rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-column h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--secondary-color);
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 12px;
        }

        .footer-column ul li a {
            color: #cbd5e0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-column ul li a:hover {
            color: white;
        }

        .social-links {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: #4a5568;
            border-radius: 50%;
            color: white;
            transition: background-color 0.3s;
        }

        .social-links a:hover {
            background-color: var(--secondary-color);
        }

        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid #4a5568;
            color: #cbd5e0;
            font-size: 0.9rem;
        }

        /* Dark Mode */
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }

        .dark-mode header,
        .dark-mode .card,
        .dark-mode .stat-card,
        .dark-mode .progress-section,
        .dark-mode .recent-activity,
        .dark-mode footer {
            background-color: #1e293b !important;
            color: #f1f5f9 !important;
        }

        .dark-mode .nav-links a {
            color: #f1f5f9 !important;
        }

        .dark-mode .nav-links a:hover {
            color: #93c5fd !important;
        }

        .dark-mode .page-title,
        .dark-mode .section-title,
        .dark-mode .card-header h3 {
            color: #93c5fd !important;
        }

        .dark-mode .stat-value {
            color: #60a5fa !important;
        }

        .dark-mode .activity-content p,
        .dark-mode .activity-time,
        .dark-mode .stat-label {
            color: #cbd5e1 !important;
        }

        body {
            transition: background-color 0.3s, color 0.3s;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }

            .nav-links {
                position: fixed;
                top: 80px;
                right: -100%;
                flex-direction: column;
                background-color: white;
                width: 80%;
                height: calc(100vh - 80px);
                padding: 20px;
                box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
                transition: right 0.3s ease;
                z-index: 99;
            }

            .nav-links.active {
                right: 0;
            }

            .nav-links li {
                margin: 15px 0;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
            }

            .stats-summary {
                grid-template-columns: 1fr;
            }
        }
</style>
</head>
<body>
<div class="sidebar">
<h2>FixSense</h2>
<a href="lecturer.php">Dashboard</a>
<a href="studentPerformance.php">Students</a>
<a href="logout.php">Logout</a>
</div>

<div class="main">
<h1><?= htmlspecialchars($student['full_name']) ?>'s Performance</h1>

<div class="card">
<h3>Summary</h3>
<p>Total Scenarios: <?= $totalScenarios ?></p>
<p>Average Score: <?= $accuracy ?>%</p>
</div>

<div class="card">
<h3>Recent Performance</h3>
<table class="table">
<tr><th>Scenario</th><th>Score</th><th>Status</th><th>Date</th></tr>
<?php foreach($records as $r): ?>
<tr>
<td><?= $scenarioTitles[$r['scenario_id']] ?? 'Scenario #'.$r['scenario_id'] ?></td>
<td><?= $r['score'] ?>%</td>
<td><span class="<?= $r['status']==='passed'?'status-pass':'status-fail' ?>"><?= ucfirst($r['status']) ?></span></td>
<td><?= date('d M Y, H:i', strtotime($r['completed_at'])) ?></td>
</tr>
<?php endforeach; ?>
</table>
</div>

</div>
</body>
</html>
