<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}

$fullName = htmlspecialchars($_SESSION['full_name']);
$initials = strtoupper(substr($fullName, 0, 1) . (strpos($fullName, ' ') ? substr($fullName, strpos($fullName, ' ') + 1, 1) : ''));

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Function to generate sidebar with active page
function generateSidebar($activePage) {
    $menuItems = [
        'lecturer.php' => ['icon' => 'fas fa-home', 'title' => 'Dashboard'],
        'manageScenario.php' => ['icon' => 'fas fa-car', 'title' => 'Manage Automotive Scenarios'],
        'createScenario.php' => ['icon' => 'fas fa-plus-circle', 'title' => 'Create New Scenario'],
        'manageExtraNotes.php' => ['icon' => 'fas fa-book', 'title' => 'Manage Extra Notes'],
        'studentPerformance.php' => ['icon' => 'fas fa-chart-bar', 'title' => 'Student Performance Tracking'],
        'exportStudentReports.php' => ['icon' => 'fas fa-file-export', 'title' => 'Export Student Reports'],
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

// Handle AJAX requests for student data
if (isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'get_student_performance') {
        $studentId = $_POST['student_id'];
        
        // Get student info
        $stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE id = ? AND role = 'student'");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch();
        
        if (!$student) {
            echo json_encode(['error' => 'Student not found']);
            exit();
        }
        
        // Get performance data
        $stmt = $pdo->prepare("
            SELECT p.*, s.title as scenario_title, s.category, s.description
            FROM performance p
            LEFT JOIN scenarios s ON p.scenario_id = s.id
            WHERE p.student_id = ?
            ORDER BY p.completed_at DESC
        ");
        $stmt->execute([$studentId]);
        $performances = $stmt->fetchAll();
        
        // Calculate statistics
        $totalScenarios = count($performances);
        $averageScore = $totalScenarios > 0 ? round(array_sum(array_column($performances, 'score')) / $totalScenarios, 2) : 0;
        
        // Category breakdown
        $categoryStats = [];
        foreach ($performances as $perf) {
            $cat = $perf['category'] ?? 'Other';
            if (!isset($categoryStats[$cat])) {
                $categoryStats[$cat] = ['total' => 0, 'sum' => 0];
            }
            $categoryStats[$cat]['total']++;
            $categoryStats[$cat]['sum'] += $perf['score'];
        }
        
        foreach ($categoryStats as $cat => &$stats) {
            $stats['average'] = round($stats['sum'] / $stats['total'], 2);
        }
        
        echo json_encode([
            'student' => $student,
            'performances' => $performances,
            'statistics' => [
                'total_scenarios' => $totalScenarios,
                'average_score' => $averageScore,
                'category_stats' => $categoryStats
            ]
        ]);
        exit();
    }
    
    if ($_POST['action'] === 'export_csv') {
        $studentId = $_POST['student_id'];
        
        // Get student info
        $stmt = $pdo->prepare("SELECT full_name, email FROM users WHERE id = ? AND role = 'student'");
        $stmt->execute([$studentId]);
        $student = $stmt->fetch();
        
        // Get performance data
        $stmt = $pdo->prepare("
            SELECT p.*, s.title as scenario_title, s.category, s.description
            FROM performance p
            LEFT JOIN scenarios s ON p.scenario_id = s.id
            WHERE p.student_id = ?
            ORDER BY p.completed_at DESC
        ");
        $stmt->execute([$studentId]);
        $performances = $stmt->fetchAll();
        
        // Generate CSV
        $filename = 'student_report_' . preg_replace('/[^a-zA-Z0-9]/', '_', $student['full_name']) . '_' . date('Y-m-d') . '.csv';
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        
        // CSV Headers
        fputcsv($output, [
            'Student Name', 'Email', 'Scenario Title', 'Category', 
            'Score (%)', 'Status', 'Completed Date', 'Completed Time'
        ]);
        
        // CSV Data
        foreach ($performances as $perf) {
            fputcsv($output, [
                $student['full_name'],
                $student['email'],
                $perf['scenario_title'] ?? 'N/A',
                $perf['category'] ?? 'N/A',
                $perf['score'],
                $perf['status'],
                date('Y-m-d', strtotime($perf['completed_at'])),
                date('H:i:s', strtotime($perf['completed_at']))
            ]);
        }
        
        fclose($output);
        exit();
    }
}

// Get all students for dropdown
$search = trim($_GET['search'] ?? '');
$studentsQuery = "SELECT id, full_name, email FROM users WHERE role = 'student'";
$params = [];

if ($search) {
    $studentsQuery .= " AND (full_name LIKE ? OR email LIKE ?)";
    $params = ["%$search%", "%$search%"];
}

$studentsQuery .= " ORDER BY full_name ASC";

$stmt = $pdo->prepare($studentsQuery);
$stmt->execute($params);
$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Export Student Reports - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
    <style>
        /* Export page specific styles */
        .export-container {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .search-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 25px;
            color: white;
        }

        .search-section h3 {
            margin-bottom: 20px;
            font-size: 1.4rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .search-form {
            display: flex;
            gap: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 12px 20px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .search-input:focus {
            outline: none;
            background: white;
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.3);
        }

        .search-btn {
            padding: 12px 25px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 25px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .search-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .student-selection {
            margin-bottom: 30px;
        }

        .student-dropdown {
            width: 100%;
            padding: 15px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 16px;
            background: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .student-dropdown:focus {
            outline: none;
            border-color: #1a56db;
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.1);
        }

        .performance-preview {
            display: none;
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            border-radius: 15px;
            padding: 25px;
            margin-top: 25px;
        }

        .performance-preview.show {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .student-info {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1a56db, #0d47a1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .student-details h4 {
            margin: 0;
            color: #2c3e50;
            font-size: 1.2rem;
        }

        .student-details p {
            margin: 5px 0 0 0;
            color: #7f8c8d;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: bold;
            color: #1a56db;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .export-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 25px;
        }

        .export-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            min-width: 160px;
            justify-content: center;
        }

        .export-pdf {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .export-csv {
            background: linear-gradient(135deg, #27ae60, #229954);
            color: white;
        }

        .export-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .performance-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .performance-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .performance-table th,
        .performance-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .performance-table th {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            font-weight: 600;
            color: #2c3e50;
        }

        .performance-table tbody tr:hover {
            background: #f8fafc;
        }

        .score-badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .score-excellent {
            background: #d4edda;
            color: #155724;
        }

        .score-good {
            background: #d1ecf1;
            color: #0c5460;
        }

        .score-fair {
            background: #fff3cd;
            color: #856404;
        }

        .score-poor {
            background: #f8d7da;
            color: #721c24;
        }

        .loading {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .loading i {
            font-size: 2rem;
            margin-bottom: 15px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Dark mode support */
        .dark-mode .export-container,
        .dark-mode .student-info,
        .dark-mode .stat-card,
        .dark-mode .performance-table {
            background: #1e293b !important;
            color: #f1f5f9 !important;
        }

        .dark-mode .student-dropdown {
            background: #1e293b !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }

        .dark-mode .performance-table th {
            background: linear-gradient(135deg, #0f172a, #1e293b) !important;
            color: #f1f5f9 !important;
        }

        .dark-mode .performance-table td {
            border-color: #334155 !important;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                align-items: stretch;
            }

            .search-input {
                min-width: 100%;
                margin-bottom: 10px;
            }

            .export-actions {
                flex-direction: column;
            }

            .export-btn {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .performance-table {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <div class="lecturer-layout">
        <?= generateSidebar('exportStudentReports.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">
                    <i class="fas fa-file-export"></i>
                    Export Student Reports
                </h1>
                <div class="user-actions">
                    <button id="darkModeToggle" class="dark-mode-btn">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="user-avatar"><?= $initials ?></div>
                    <span><?= $fullName ?></span>
                </div>
            </div>

            <div class="content-body">
                <div class="export-container">
                    <!-- Search Section -->
                    <div class="search-section">
                        <h3>
                            <i class="fas fa-search"></i>
                            Search Students
                        </h3>
                        <form method="GET" class="search-form">
                            <input 
                                type="text" 
                                name="search" 
                                value="<?= htmlspecialchars($search) ?>" 
                                placeholder="Search by student name or email..." 
                                class="search-input"
                            >
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i> Search
                            </button>
                        </form>
                    </div>

                    <!-- Student Selection -->
                    <div class="student-selection">
                        <h3>
                            <i class="fas fa-user-graduate"></i>
                            Select Student
                        </h3>
                        <select id="studentSelect" class="student-dropdown">
                            <option value="">Choose a student to view their performance...</option>
                            <?php foreach ($students as $student): ?>
                                <option value="<?= $student['id'] ?>">
                                    <?= htmlspecialchars($student['full_name']) ?> - <?= htmlspecialchars($student['email']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Performance Preview -->
                    <div id="performancePreview" class="performance-preview">
                        <div id="loadingIndicator" class="loading">
                            <i class="fas fa-spinner"></i>
                            <p>Loading student performance data...</p>
                        </div>
                        
                        <div id="performanceContent" style="display: none;">
                            <!-- Student Info will be populated here -->
                            <div id="studentInfo"></div>
                            
                            <!-- Statistics will be populated here -->
                            <div id="statisticsGrid"></div>
                            
                            <!-- Export Actions -->
                            <div class="export-actions">
                                <button id="exportPDF" class="export-btn export-pdf">
                                    <i class="fas fa-file-pdf"></i>
                                    Export as PDF
                                </button>
                                <button id="exportCSV" class="export-btn export-csv">
                                    <i class="fas fa-file-csv"></i>
                                    Export as CSV
                                </button>
                            </div>
                            
                            <!-- Performance Table -->
                            <div id="performanceTable"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStudentId = null;
        let currentStudentData = null;

        document.getElementById('studentSelect').addEventListener('change', function() {
            const studentId = this.value;
            if (studentId) {
                currentStudentId = studentId;
                loadStudentPerformance(studentId);
            } else {
                document.getElementById('performancePreview').classList.remove('show');
            }
        });

        function loadStudentPerformance(studentId) {
            const preview = document.getElementById('performancePreview');
            const loading = document.getElementById('loadingIndicator');
            const content = document.getElementById('performanceContent');
            
            preview.classList.add('show');
            loading.style.display = 'block';
            content.style.display = 'none';

            // AJAX request to get student performance
            fetch('exportStudentReports.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=get_student_performance&student_id=${studentId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }
                
                currentStudentData = data;
                displayStudentPerformance(data);
                
                loading.style.display = 'none';
                content.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load student performance data');
                loading.style.display = 'none';
            });
        }

        function displayStudentPerformance(data) {
            const { student, performances, statistics } = data;
            
            // Display student info
            const studentInfo = document.getElementById('studentInfo');
            const initials = student.full_name.split(' ').map(n => n[0]).join('').toUpperCase();
            
            studentInfo.innerHTML = `
                <div class="student-info">
                    <div class="student-avatar">${initials}</div>
                    <div class="student-details">
                        <h4>${student.full_name}</h4>
                        <p><i class="fas fa-envelope"></i> ${student.email}</p>
                    </div>
                </div>
            `;
            
            // Display statistics
            const statsGrid = document.getElementById('statisticsGrid');
            statsGrid.innerHTML = `
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">${statistics.total_scenarios}</div>
                        <div class="stat-label">Total Scenarios</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">${statistics.average_score}%</div>
                        <div class="stat-label">Average Score</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">${Object.keys(statistics.category_stats).length}</div>
                        <div class="stat-label">Categories Attempted</div>
                    </div>
                </div>
            `;
            
            // Display performance table
            const tableContainer = document.getElementById('performanceTable');
            let tableHTML = `
                <div class="performance-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Scenario</th>
                                <th>Category</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody>
            `;
            
            performances.forEach(perf => {
                const scoreClass = getScoreClass(perf.score);
                const date = new Date(perf.completed_at);
                
                tableHTML += `
                    <tr>
                        <td>${perf.scenario_title || 'N/A'}</td>
                        <td>${perf.category || 'N/A'}</td>
                        <td><span class="score-badge ${scoreClass}">${perf.score}%</span></td>
                        <td>${perf.status}</td>
                        <td>${date.toLocaleDateString()} ${date.toLocaleTimeString()}</td>
                    </tr>
                `;
            });
            
            tableHTML += `
                        </tbody>
                    </table>
                </div>
            `;
            
            tableContainer.innerHTML = tableHTML;
        }

        function getScoreClass(score) {
            if (score >= 90) return 'score-excellent';
            if (score >= 75) return 'score-good';
            if (score >= 60) return 'score-fair';
            return 'score-poor';
        }

        // Export functions
        document.getElementById('exportCSV').addEventListener('click', function() {
            if (!currentStudentId) {
                alert('Please select a student first');
                return;
            }
            
            // Create a form and submit it for CSV download
            const form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';
            
            const actionInput = document.createElement('input');
            actionInput.name = 'action';
            actionInput.value = 'export_csv';
            
            const studentInput = document.createElement('input');
            studentInput.name = 'student_id';
            studentInput.value = currentStudentId;
            
            form.appendChild(actionInput);
            form.appendChild(studentInput);
            document.body.appendChild(form);
            
            form.submit();
            document.body.removeChild(form);
        });

        document.getElementById('exportPDF').addEventListener('click', function() {
            if (!currentStudentData) {
                alert('Please select a student first');
                return;
            }
            
            // Generate PDF using browser's print functionality
            const printWindow = window.open('', '_blank');
            const { student, performances, statistics } = currentStudentData;
            
            const printContent = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Student Report - ${student.full_name}</title>
                    <style>
                        body { font-family: Arial, sans-serif; margin: 20px; }
                        .header { text-align: center; margin-bottom: 30px; }
                        .student-info { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
                        .stats { display: flex; justify-content: space-around; margin-bottom: 30px; }
                        .stat { text-align: center; }
                        .stat-value { font-size: 2em; font-weight: bold; color: #1a56db; }
                        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
                        th { background-color: #f8f9fa; }
                        .score-excellent { background: #d4edda; color: #155724; padding: 4px 8px; border-radius: 4px; }
                        .score-good { background: #d1ecf1; color: #0c5460; padding: 4px 8px; border-radius: 4px; }
                        .score-fair { background: #fff3cd; color: #856404; padding: 4px 8px; border-radius: 4px; }
                        .score-poor { background: #f8d7da; color: #721c24; padding: 4px 8px; border-radius: 4px; }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <h1>FixSense Student Performance Report</h1>
                        <p>Generated on ${new Date().toLocaleDateString()}</p>
                    </div>
                    
                    <div class="student-info">
                        <h2>Student Information</h2>
                        <p><strong>Name:</strong> ${student.full_name}</p>
                        <p><strong>Email:</strong> ${student.email}</p>
                    </div>
                    
                    <div class="stats">
                        <div class="stat">
                            <div class="stat-value">${statistics.total_scenarios}</div>
                            <div>Total Scenarios</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">${statistics.average_score}%</div>
                            <div>Average Score</div>
                        </div>
                        <div class="stat">
                            <div class="stat-value">${Object.keys(statistics.category_stats).length}</div>
                            <div>Categories</div>
                        </div>
                    </div>
                    
                    <h3>Performance Details</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Scenario</th>
                                <th>Category</th>
                                <th>Score</th>
                                <th>Status</th>
                                <th>Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${performances.map(perf => `
                                <tr>
                                    <td>${perf.scenario_title || 'N/A'}</td>
                                    <td>${perf.category || 'N/A'}</td>
                                    <td><span class="${getScoreClass(perf.score)}">${perf.score}%</span></td>
                                    <td>${perf.status}</td>
                                    <td>${new Date(perf.completed_at).toLocaleString()}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </body>
                </html>
            `;
            
            printWindow.document.write(printContent);
            printWindow.document.close();
            
            printWindow.onload = function() {
                printWindow.print();
                printWindow.close();
            };
        });

        // Dark mode toggle
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeBtn = document.getElementById('darkModeToggle');
            const body = document.body;
            
            // Check for saved dark mode preference
            if (localStorage.getItem('darkMode') === 'enabled') {
                body.classList.add('dark-mode');
                darkModeBtn.innerHTML = '<i class="fas fa-sun"></i>';
            }
            
            darkModeBtn.addEventListener('click', function() {
                body.classList.toggle('dark-mode');
                
                if (body.classList.contains('dark-mode')) {
                    localStorage.setItem('darkMode', 'enabled');
                    darkModeBtn.innerHTML = '<i class="fas fa-sun"></i>';
                } else {
                    localStorage.setItem('darkMode', 'disabled');
                    darkModeBtn.innerHTML = '<i class="fas fa-moon"></i>';
                }
            });

            // Mobile optimizations
            if (window.innerWidth <= 768) {
                document.body.classList.add('mobile-view');
                
                // Create mobile toggle button
                const mobileToggle = document.createElement('button');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
                mobileToggle.className = 'mobile-toggle';
                mobileToggle.style.cssText = `
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
                
                document.body.appendChild(mobileToggle);
                
                const sidebar = document.querySelector('.sidebar');
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
                `;
                document.body.appendChild(overlay);
                
                mobileToggle.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    overlay.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
                });
                
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('mobile-open');
                    overlay.style.display = 'none';
                });
            }
        });
    </script>
</body>
</html>