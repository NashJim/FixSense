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

$stmt = $pdo->query("SELECT * FROM scenarios ORDER BY id DESC");
$scenarios = $stmt->fetchAll();

// Function to generate sidebar with active page
function generateSidebar($activePage) {
    $menuItems = [
        'lecturer.php' => ['icon' => 'fas fa-home', 'title' => 'Dashboard'],
        'manageScenario.php' => ['icon' => 'fas fa-car', 'title' => 'Manage Automotive Scenarios'],
        'createScenario.php' => ['icon' => 'fas fa-plus-circle', 'title' => 'Create New Scenario'],
        'manageExtraNotes.php' => ['icon' => 'fas fa-book', 'title' => 'Manage Extra Notes'],
        'studentPerformance.php' => ['icon' => 'fas fa-chart-bar', 'title' => 'Student Performance Tracking'],
        'exportStudentReports.php' => ['icon' => 'fas fa-file-export', 'title' => 'Export Student Reports'],
        'helpSupport.php' => ['icon' => 'fas fa-question-circle', 'title' => 'Help & Support'],
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Scenarios - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Additional styles for this page */
        .scenarios-container {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-header h2 {
            color: var(--primary-color);
            font-size: 1.8rem;
            margin: 0;
        }

        .btn-create {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            background: linear-gradient(135deg, var(--primary-color), #1648b5);
            color: white;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(26, 86, 219, 0.2);
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(26, 86, 219, 0.3);
        }

        .scenarios-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .scenarios-table th,
        .scenarios-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .scenarios-table th {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.95rem;
        }

        .scenarios-table tbody tr {
            transition: all 0.3s ease;
        }

        .scenarios-table tbody tr:hover {
            background-color: #f8fafc;
            transform: translateX(5px);
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-edit {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-delete:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--dark-gray);
        }

        .empty-state i {
            font-size: 4rem;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        /* Dark mode overrides */
        .dark-mode .scenarios-container {
            background: #1e293b !important;
            box-shadow: 0 4px 16px rgba(0,0,0,0.3) !important;
        }

        .dark-mode .page-header h2 {
            color: #93c5fd !important;
        }

        .dark-mode .scenarios-table th {
            background: linear-gradient(135deg, #0f172a, #1e293b) !important;
            color: #f1f5f9 !important;
        }

        .dark-mode .scenarios-table td {
            color: #f1f5f9 !important;
            border-bottom-color: #334155 !important;
        }

        .dark-mode .scenarios-table tbody tr:hover {
            background-color: #334155 !important;
        }

        .dark-mode .empty-state {
            color: #cbd5e1 !important;
        }

        .dark-mode .empty-state h3 {
            color: #f1f5f9 !important;
        }

        /* Force sidebar styling to override any conflicts */
        .lecturer-layout .sidebar {
            width: 250px !important;
            background: white !important;
            position: fixed !important;
            left: 0 !important;
            top: 0 !important;
            height: 100vh !important;
            z-index: 1000 !important;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1) !important;
        }

        .lecturer-layout .main-content {
            margin-left: 250px !important;
            width: calc(100% - 250px) !important;
        }
    </style>
</head>
<body>
    <div class="lecturer-layout">
        <?= generateSidebar('manageScenario.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">Manage Scenarios</h1>
                <div class="user-actions">
                    <button id="darkModeToggle" class="dark-mode-btn">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="user-avatar"><?= $initials ?></div>
                    <span><?= $fullName ?></span>
                </div>
            </div>

            <div class="content-body">
                <div class="scenarios-container">
                    <div class="page-header">
                        <h2>Automotive Scenarios</h2>
                        <a href="createScenario.php" class="btn-create">
                            <i class="fas fa-plus"></i> Create New Scenario
                        </a>
                    </div>

                    <?php if (empty($scenarios)): ?>
                        <div class="empty-state">
                            <i class="fas fa-car"></i>
                            <h3>No Scenarios Found</h3>
                            <p>Start by creating your first automotive troubleshooting scenario.</p>
                        </div>
                    <?php else: ?>
                        <table class="scenarios-table">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Created By</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($scenarios as $s): ?>
                                <tr>
                                    <td data-label="Title"><?= htmlspecialchars($s['title']) ?></td>
                                    <td data-label="Category"><?= htmlspecialchars($s['category']) ?></td>
                                    <td data-label="Created By"><?= htmlspecialchars($s['created_by']) ?></td>
                                    <td data-label="Actions">
                                        <div class="action-buttons">
                                            <a href="editScenario.php?id=<?= $s['id'] ?>" class="btn btn-edit">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="deleteScenario.php?id=<?= $s['id'] ?>" class="btn btn-delete" 
                                               onclick="return confirm('Are you sure you want to delete this scenario? This action cannot be undone.')">
                                                <i class="fas fa-trash"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
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
                
                // Mobile-optimized sidebar functionality
                toggleBtn.addEventListener('click', () => {
                    sidebar.classList.toggle('mobile-open');
                    
                    // Create overlay if not exists
                    let overlay = document.querySelector('.sidebar-overlay');
                    if (!overlay) {
                        overlay = document.createElement('div');
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
                        
                        overlay.addEventListener('click', () => {
                            sidebar.classList.remove('mobile-open');
                            overlay.style.display = 'none';
                        });
                    }
                    
                    overlay.style.display = sidebar.classList.contains('mobile-open') ? 'block' : 'none';
                });

                // Add mobile table functionality
                document.body.classList.add('mobile-view');
                
                // Swipe gesture for table navigation
                const table = document.querySelector('.scenarios-table');
                if (table) {
                    let startX = 0;
                    let isScrolling = false;
                    
                    table.addEventListener('touchstart', function(e) {
                        startX = e.touches[0].clientX;
                        isScrolling = false;
                    });
                    
                    table.addEventListener('touchmove', function(e) {
                        isScrolling = true;
                    });
                    
                    table.addEventListener('touchend', function(e) {
                        if (!isScrolling) {
                            const endX = e.changedTouches[0].clientX;
                            const diffX = startX - endX;
                            
                            // Add visual feedback for swipe
                            if (Math.abs(diffX) > 50) {
                                table.style.transform = `translateX(${diffX > 0 ? '-' : ''}10px)`;
                                setTimeout(() => {
                                    table.style.transform = 'translateX(0)';
                                }, 200);
                            }
                        }
                    });
                }
            }
        });
    </script>

    <script src="js/darkmode.js"></script>
</body>
</html>