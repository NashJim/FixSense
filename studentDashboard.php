<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: project.php");
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

$studentId = $_SESSION['user_id'];

// === Rekod login harian (untuk streak) ===
$today = (new DateTime('now', new DateTimeZone('Asia/Kuala_Lumpur')))->format('Y-m-d');
$stmt = $pdo->prepare("INSERT IGNORE INTO login_logs (user_id, login_date) VALUES (?, ?)");
$stmt->execute([$studentId, $today]);

// === Kira streak login berturut ===
$stm = $pdo->prepare("SELECT login_date FROM login_logs WHERE user_id = ? ORDER BY login_date DESC");
$stm->execute([$studentId]);
$dates = $stm->fetchAll(PDO::FETCH_COLUMN);

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
    <title>Automotive Performance Tracking - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">
                    <i class="fas fa-tools"></i>FixSense
                </a>
                <ul class="nav-links">
                    <li><a href="project.php">Home</a></li>
                    <li><a href="simulationSelection.php">Simulations</a></li>
                    <li><a href="ai-chatbot.php">AI Chatbot</a></li>
                    <li><a href="studentDashboard.php">Performance</a></li>
                    <li><a href="profile.php">Profile</a></li>
                    <li>
                        <button id="darkModeToggle" class="btn" style="padding: 8px 16px; display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                </ul>
                <div class="auth-buttons">
                    <span id="greeting" style="color: white; background: #2c3e50; padding: 8px 16px; border-radius: 4px; font-weight: 600;">
                        Hello, <?= htmlspecialchars($_SESSION['full_name']) ?>
                    </span>
                    <a href="logout.php" class="btnLogout" style="background: #e74c3c; margin-left: 10px;">Logout</a>
                </div>
                <div class="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Automotive Troubleshooting Progress</h1>
                <p class="page-subtitle">Track your skill development in automotive diagnostics and problem-solving.</p>
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
                    <div class="stat-label">Current Streak (Days)</div>
                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-user"></i>
                        <h3>Your Profile</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['full_name']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['email']) ?></p>
                        <p><strong>Institution:</strong> ILP Kuantan</p>
                        <a href="profile.php" class="btn" style="margin-top: 15px; display: inline-block; padding: 8px 16px; font-size: 0.9rem;">View Profile</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-trophy"></i>
                        <h3>Achievements</h3>
                    </div>
                    <div class="card-body">
                        <p>Congratulations on your progress!</p>
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
                <h2 class="section-title"><i class="fas fa-history"></i> Recent Activity</h2>
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
                                <p>Complete your first simulation to see activity here.</p>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="automotive.html">Simulations</a></li>
                        <li><a href="#">AI Chatbot</a></li>
                        <li><a href="studentDashboard.php">Performance Tracking</a></li>
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

        // Dark Mode Toggle
        (function() {
            const isDark = localStorage.getItem('darkMode') === 'true';
            if (isDark) {
                document.body.classList.add('dark-mode');
            }
        })();

        document.getElementById('darkModeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark);
            this.innerHTML = isDark ?
                '<i class="fas fa-sun"></i>' :
                '<i class="fas fa-moon"></i>';
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
</body>

</html>