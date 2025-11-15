<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}
$fullName = htmlspecialchars($_SESSION['full_name']);
$initials = strtoupper(substr($fullName, 0, 1) . (strpos($fullName, ' ') ? substr($fullName, strpos($fullName, ' ') + 1, 1) : ''));

$pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');

// Dapatkan semua pelajar
$stmt = $pdo->prepare("SELECT id, full_name FROM users WHERE role = 'student' ORDER BY full_name ASC");
$stmt->execute();
$allStudents = $stmt->fetchAll();

// Proses carian
$searchTerm = $_GET['search'] ?? '';
$students = $allStudents;
if ($searchTerm) {
    $students = array_filter($allStudents, function($student) use ($searchTerm) {
        return stripos($student['full_name'], $searchTerm) !== false;
    });
}

// Dapatkan pelajar yang dipilih (dari URL)
$selectedStudentId = $_GET['student_id'] ?? null;
$studentName = '';
$records = [];
$overallAccuracy = 0;
$totalScenarios = 0;
$categoryProgress = [];
$recentActivity = [];

if ($selectedStudentId) {
    // Dapatkan nama pelajar
    $stmt = $pdo->prepare("SELECT full_name FROM users WHERE id = ?");
    $stmt->execute([$selectedStudentId]);
    $studentRow = $stmt->fetch();
    if ($studentRow) {
        $studentName = $studentRow['full_name'];

        // Dapatkan data prestasi
        $stmt = $pdo->prepare("
            SELECT scenario_id, score, status, completed_at
            FROM performance
            WHERE student_id = ?
            ORDER BY completed_at DESC
        ");
        $stmt->execute([$selectedStudentId]);
        $records = $stmt->fetchAll();

        // Kira statistik
        $totalScenarios = count($records);
        $overallAccuracy = $totalScenarios > 0 ? round(array_sum(array_column($records, 'score')) / $totalScenarios) : 0;

        // Mapping scenario
        $scenarioTitles = [
            1.0 => 'Car Won\'t Start',
            2.0 => 'Hard Brake Pedal',
            2.1 => 'Brake Lamp Always On',
            2.2 => 'Brake Lights Not Working',
            2.3 => 'Spongy Brake Pedal',
            2.4 => 'Brake Lights Not Working (Engine Off)',
            2.5 => 'Car Pulls When Braking'
        ];

        $scenarioCategories = [
            1.0 => 'Engine Diagnostics',
            2.0 => 'Brake System',
            2.1 => 'Brake System',
            2.2 => 'Brake System',
            2.3 => 'Brake System',
            2.4 => 'Brake System',
            2.5 => 'Brake System'
        ];

        // Kira kemajuan mengikut kategori
        $categoryScores = [];
        foreach ($records as $r) {
            $cat = $scenarioCategories[$r['scenario_id']] ?? 'Other';
            if (!isset($categoryScores[$cat])) {
                $categoryScores[$cat] = [];
            }
            $categoryScores[$cat][] = $r['score'];
        }

        $categoryProgress = [];
        foreach ($categoryScores as $cat => $scores) {
            $categoryProgress[$cat] = round(array_sum($scores) / count($scores));
        }
        // Pastikan semua kategori ada
        $allCategories = ['Engine Diagnostics', 'Brake System', 'Suspension & Steering', 'Electrical Circuits'];
        foreach ($allCategories as $cat) {
            if (!isset($categoryProgress[$cat])) {
                $categoryProgress[$cat] = 0;
            }
        }

        // Aktiviti terkini
        $recentActivity = [];
        foreach (array_slice($records, 0, 4) as $r) {
            $recentActivity[] = [
                'type' => 'completed',
                'title' => 'Scenario Completed',
                'description' => 'Diagnosed "' . ($scenarioTitles[$r['scenario_id']] ?? 'Unknown') . '" with ' . $r['score'] . '% accuracy.',
                'time' => date('g:i A', strtotime($r['completed_at']))
            ];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Class Performance - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Gaya yang sama seperti lecturer.php */
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

        body {
            background-color: white;
            color: var(--dark-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            padding: 20px 0;
            z-index: 100;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 20px 20px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--gray-color);
        }

        .logo i {
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .logo span {
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--primary-color);
        }

        .nav-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-item {
            margin-bottom: 15px;
            padding-left: 20px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: var(--dark-gray);
            font-size: 0.95rem;
            transition: all 0.3s ease;
            padding: 8px 0;
            border-radius: 6px;
        }

        .nav-link:hover {
            background-color: #f1f5f9;
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: white;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 20px;
            background-color: #f7f7f7;
            min-height: 100vh;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding: 0 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
        }

        .search-box {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            padding: 8px 12px;
            border: 1px solid var(--gray-color);
            border-radius: 4px;
            font-size: 0.95rem;
        }

        .search-box button {
            padding: 8px 16px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Student List */
        .student-list-section {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
        }

        .student-list-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .student-list-header h2 {
            margin: 0;
            color: var(--primary-color);
        }

        .student-list {
            max-height: 300px;
            overflow-y: auto;
        }

        .student-item {
            padding: 10px;
            border-bottom: 1px solid var(--gray-color);
            cursor: pointer;
        }

        .student-item:hover {
            background-color: #f1f5f9;
        }

        .student-item.active {
            background-color: #dbeafe;
            font-weight: bold;
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

        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--dark-gray);
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <i class="fas fa-tools"></i>
            <span>FixSense</span>
        </div>
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="lecturer.php" class="nav-link">
                    <i class="fas fa-home"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="manageScenario.php" class="nav-link">
                    <i class="fas fa-car"></i> Manage Automotive Scenarios
                </a>
            </li>
            <li class="nav-item">
                <a href="manageExtraNotes.php" class="nav-link">
                    <i class="fas fa-book"></i> Manage Extra Notes
                </a>
            </li>
            <li class="nav-item">
                <a href="viewClassPerformance.php" class="nav-link active">
                    <i class="fas fa-chart-bar"></i> View Class Performance
                </a>
            </li>
            <li class="nav-item">
                <a href="profile.php" class="nav-link">
                    <i class="fas fa-cog"></i> Profile
                </a>
            </li>
            <li class="nav-item">
                <a href="logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="header">
            <h1 class="page-title">View Class Performance</h1>
            <div class="search-box">
                <form method="GET">
                    <input type="text" name="search" placeholder="Search by student name..." value="<?= htmlspecialchars($searchTerm) ?>">
                    <button type="submit"><i class="fas fa-search"></i> Search</button>
                </form>
            </div>
            <div class="user-actions">
                <div class="user-avatar"><?= $initials ?></div>
                <span><?= $fullName ?></span>
            </div>
        </div>

        <!-- Student List -->
        <div class="student-list-section">
            <div class="student-list-header">
                <h2>Student List</h2>
            </div>
            <?php if (empty($students)): ?>
                <p class="no-data">No students found.</p>
            <?php else: ?>
                <div class="student-list">
                    <?php foreach ($students as $student): ?>
                        <div class="student-item <?= $student['id'] == $selectedStudentId ? 'active' : '' ?>" 
                             onclick="window.location='?student_id=<?= $student['id'] ?>&search=<?= urlencode($searchTerm) ?>'">
                            <?= htmlspecialchars($student['full_name']) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Student Performance -->
        <?php if ($selectedStudentId && $studentName): ?>
            <h2 style="font-size: 1.8rem; margin-bottom: 20px; color: var(--primary-color);">Performance: <?= htmlspecialchars($studentName) ?></h2>

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
                            <div class="progress-fill" style="width: <?= $score ?>%;"></div>
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
                                <p>The student has not completed any scenarios.</p>
                                <span class="activity-time">-</span>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php else: ?>
            <div class="no-data">
                <p>Please select a student to view their performance.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>