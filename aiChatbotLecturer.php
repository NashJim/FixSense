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
        'aiChatbotLecturer.php' => ['icon' => 'fas fa-robot', 'title' => 'AI Chatbot Assistant'],
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>AI Chatbot Assistant - FixSense Lecturer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
    <style>
        /* AI Chatbot specific styles for lecturer */
        .chatbot-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .chatbot-hero::before {
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

        .chatbot-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 700;
            position: relative;
            z-index: 2;
        }

        .chatbot-hero p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .ai-features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-top: 4px solid transparent;
        }

        .feature-card:nth-child(1) { border-top-color: #3498db; }
        .feature-card:nth-child(2) { border-top-color: #e67e22; }
        .feature-card:nth-child(3) { border-top-color: #27ae60; }
        .feature-card:nth-child(4) { border-top-color: #8e44ad; }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .feature-card i {
            font-size: 2.5rem;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .feature-card:nth-child(1) i { color: #3498db; }
        .feature-card:nth-child(2) i { color: #e67e22; }
        .feature-card:nth-child(3) i { color: #27ae60; }
        .feature-card:nth-child(4) i { color: #8e44ad; }

        .feature-card:hover i {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h4 {
            margin-bottom: 10px;
            color: #2c3e50;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .feature-card p {
            color: #7f8c8d;
            font-size: 0.9rem;
            line-height: 1.5;
            margin: 0;
        }

        .chatbot-container {
            background: white;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .chatbot-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(135deg, #3498db, #e67e22);
        }

        .chatbot-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .chatbot-header h2 {
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .chatbot-header h2 i {
            color: #3498db;
            font-size: 2.2rem;
        }

        .chatbot-description {
            text-align: center;
            margin-bottom: 30px;
            color: #7f8c8d;
            font-size: 1rem;
            line-height: 1.6;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .usage-examples {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
        }

        .usage-examples h3 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 1.3rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .usage-examples h3 i {
            color: #e67e22;
        }

        .example-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 15px;
        }

        .example-item {
            background: white;
            padding: 15px 20px;
            border-radius: 10px;
            border-left: 4px solid #3498db;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .example-item:nth-child(even) {
            border-left-color: #e67e22;
        }

        .example-item strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }

        .example-item span {
            color: #7f8c8d;
            font-style: italic;
            font-size: 0.9rem;
        }

        .jotform-embed {
            width: 100%;
            min-height: 700px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            background: #f8f9fa;
        }

        /* Dark mode support */
        .dark-mode .chatbot-hero {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%) !important;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4) !important;
        }

        .dark-mode .feature-card,
        .dark-mode .chatbot-container {
            background-color: #1e293b !important;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
        }

        .dark-mode .feature-card h4,
        .dark-mode .chatbot-header h2 {
            color: #93c5fd !important;
        }

        .dark-mode .feature-card p,
        .dark-mode .chatbot-description {
            color: #cbd5e1 !important;
        }

        .dark-mode .usage-examples {
            background: linear-gradient(135deg, #374151, #4b5563) !important;
        }

        .dark-mode .usage-examples h3 {
            color: #93c5fd !important;
        }

        .dark-mode .example-item {
            background-color: #334155 !important;
            color: #e5e7eb !important;
        }

        .dark-mode .example-item strong {
            color: #f1f5f9 !important;
        }

        .dark-mode .example-item span {
            color: #9ca3af !important;
        }

        .dark-mode .jotform-embed {
            background: #374151 !important;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .chatbot-hero {
                padding: 25px 20px;
            }

            .chatbot-hero h1 {
                font-size: 2rem;
            }

            .ai-features {
                grid-template-columns: 1fr;
            }

            .chatbot-container {
                padding: 25px 20px;
            }

            .chatbot-header h2 {
                font-size: 1.6rem;
                flex-direction: column;
                gap: 10px;
            }

            .example-list {
                grid-template-columns: 1fr;
            }

            .jotform-embed {
                min-height: 600px;
            }
        }
    </style>
</head>

<body>
    <div class="lecturer-layout">
        <?= generateSidebar('aiChatbotLecturer.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">
                    <i class="fas fa-robot"></i>
                    AI Chatbot Assistant
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
                <!-- Hero Section -->
                <div class="chatbot-hero">
                    <h1>AI-Powered Automotive Assistant</h1>
                    <p>Get instant technical support, troubleshooting guidance, and automotive expertise powered by advanced AI technology tailored for lecturers, students and educators.</p>
                </div>

                <!-- AI Features Grid -->
                <div class="ai-features">
                    <div class="feature-card">
                        <i class="fas fa-brain"></i>
                        <h4>Intelligent Diagnostics</h4>
                        <p>Get AI-powered analysis of automotive problems with step-by-step troubleshooting guides.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-graduation-cap"></i>
                        <h4>Teaching Support</h4>
                        <p>Access teaching materials, lesson plans, and educational content for automotive courses.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-tools"></i>
                        <h4>Technical Reference</h4>
                        <p>Quick access to specifications, repair procedures, and industry standards.</p>
                    </div>
                    <div class="feature-card">
                        <i class="fas fa-language"></i>
                        <h4>Multilingual Support</h4>
                        <p>Communicate in Bahasa Malaysia, English, or other languages for better accessibility.</p>
                    </div>
                </div>

                <!-- Usage Examples -->
                <div class="usage-examples">
                    <h3>
                        <i class="fas fa-lightbulb"></i>
                        How to Use the AI Assistant
                    </h3>
                    <div class="example-list">
                        <div class="example-item">
                            <strong>Diagnostic Questions:</strong>
                            <span>"How to diagnose brake system problems in modern vehicles?"</span>
                        </div>
                        <div class="example-item">
                            <strong>Teaching Assistance:</strong>
                            <span>"Create a lesson plan for teaching engine cooling systems"</span>
                        </div>
                        <div class="example-item">
                            <strong>Technical Specifications:</strong>
                            <span>"What are the torque specifications for wheel bolts on Toyota Camry?"</span>
                        </div>
                        <div class="example-item">
                            <strong>Student Guidance:</strong>
                            <span>"Explain carburetor adjustment procedure in simple terms"</span>
                        </div>
                        <div class="example-item">
                            <strong>Safety Procedures:</strong>
                            <span>"Safety checklist for working with automotive electrical systems"</span>
                        </div>
                        <div class="example-item">
                            <strong>Multilingual Support:</strong>
                            <span>"Bagaimana cara memeriksa sistem brek yang bermasalah?"</span>
                        </div>
                    </div>
                </div>

                <!-- Chatbot Container -->
                <div class="chatbot-container">
                    <div class="chatbot-header">
                        <h2>
                            <i class="fas fa-comments"></i>
                            Ask Your Technical Question
                        </h2>
                    </div>
                    <div class="chatbot-description">
                        Describe your automotive problem, teaching challenge, or technical question below. 
                        Our AI assistant will provide detailed guidance based on industry standards and best practices. 
                        You can ask in English, Bahasa Malaysia, or describe symptoms and get comprehensive troubleshooting steps.
                    </div>

                    <!-- AI Chatbot Embed -->
                    <iframe
                        id="jotform-iframe"
                        title="FixSense AI Chatbot Form for Lecturers"
                        src="https://agent.jotform.com/0199ba96013d7d47a6a15848e679aed8cf32"
                        frameborder="0"
                        scrolling="no"
                        class="jotform-embed">
                    </iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Jotform Auto-Resize Script -->
    <script>
        window.addEventListener('message', function(e) {
            if (/jotform/.test(e.origin)) {
                const iframe = document.getElementById('jotform-iframe');
                if (e.data && typeof e.data === 'object' && e.data.type === 'resize') {
                    iframe.style.height = e.data.height + 'px';
                }
            }
        }, false);

        // Dark mode toggle functionality
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

    <script src="js/darkmode.js"></script>
</body>
</html>