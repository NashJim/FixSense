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
    <title>Help & Support - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css?v=<?= time() ?>">
    <link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
        /* Page-specific styles */
        .page-header {
            background: linear-gradient(135deg, #8e44ad 0%, #9b59b6 100%);
            border-radius: 20px;
            padding: 40px;
            margin-bottom: 40px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(142, 68, 173, 0.3);
            color: white;
        }

        .page-header h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }

        .help-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }

        .help-section {
            background: white;
            border-radius: 20px;
            padding: 35px 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .help-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(135deg, #3498db, #e67e22);
        }

        .help-section:nth-child(2)::before {
            background: linear-gradient(135deg, #e67e22, #d35400);
        }

        .help-section:nth-child(3)::before {
            background: linear-gradient(135deg, #27ae60, #229954);
        }

        .help-section:nth-child(4)::before {
            background: linear-gradient(135deg, #8e44ad, #7d3c98);
        }

        .help-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .help-section-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .help-icon {
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .help-section:nth-child(2) .help-icon {
            background: linear-gradient(135deg, #e67e22, #d35400);
        }

        .help-section:nth-child(3) .help-icon {
            background: linear-gradient(135deg, #27ae60, #229954);
        }

        .help-section:nth-child(4) .help-icon {
            background: linear-gradient(135deg, #8e44ad, #7d3c98);
        }

        .help-section h3 {
            color: #2c3e50;
            font-size: 1.3rem;
            font-weight: 700;
            margin: 0;
        }

        .help-list {
            list-style: none;
            padding: 0;
            margin: 15px 0 0 0;
        }

        .help-list li {
            margin-bottom: 8px;
            padding: 8px 0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            color: #2c3e50;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .help-list li::before {
            content: '•';
            color: #3498db;
            font-weight: bold;
            margin-right: 8px;
        }

        .guide-content {
            color: #2c3e50;
            line-height: 1.6;
        }

        .guide-content p {
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .guide-content strong {
            color: #2c3e50;
            font-weight: 600;
        }

        .guide-list {
            list-style: none;
            padding: 0;
            margin: 10px 0 15px 20px;
        }

        .guide-list li {
            margin-bottom: 6px;
            padding: 4px 0;
            color: #34495e;
            font-size: 0.9rem;
            position: relative;
        }

        .guide-list li::before {
            content: '→';
            color: #3498db;
            font-weight: bold;
            position: absolute;
            left: -15px;
        }

        .contact-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            color: white;
            margin-bottom: 40px;
        }

        .contact-section h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .contact-section p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .contact-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 25px 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .contact-button {
            text-decoration: none;
            color: inherit;
            display: block;
            cursor: pointer;
        }

        .contact-card:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .contact-button:hover {
            text-decoration: none;
            color: white;
        }

        .contact-card i {
            font-size: 2rem;
            margin-bottom: 15px;
            color: white;
        }

        .contact-card h4 {
            font-size: 1.1rem;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .contact-card p {
            font-size: 0.9rem;
            margin: 0;
            opacity: 0.9;
        }

        /* Dark mode support */
        body.dark-mode .help-section {
            background-color: #1e293b !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
        }

        body.dark-mode .help-section h3 {
            color: #93c5fd !important;
        }

        body.dark-mode .guide-content,
        body.dark-mode .guide-content p,
        body.dark-mode .guide-content strong {
            color: #e2e8f0 !important;
        }

        body.dark-mode .guide-list li,
        body.dark-mode .help-list li {
            color: #cbd5e1 !important;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .help-grid {
                grid-template-columns: 1fr;
            }

            .page-header {
                padding: 30px 20px;
            }

            .page-header h1 {
                font-size: 2rem;
            }

            .contact-options {
                grid-template-columns: 1fr;
            }

            .help-section {
                padding: 25px 20px;
            }

            .faq-section {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>
    <div class="lecturer-layout">
        <?= generateSidebar('helpSupport.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">Help & Support</h1>
                <div class="user-actions">
                    <button id="darkModeToggle" class="dark-mode-btn">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="user-avatar"><?= $initials ?></div>
                    <span><?= $fullName ?></span>
                </div>
            </div>

            <div class="content-body">
                <!-- Page Header -->
                <div class="page-header">
                    <h1><i class="fas fa-graduation-cap"></i> Lecturer Module User Guide</h1>
                    <p>Complete guide on how to use all features of the FixSense lecturer platform for automotive education</p>
                </div>

                <!-- Help Sections Grid -->
                <div class="help-grid">
                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            <h3>Dashboard Overview</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Welcome Section:</strong> The main dashboard displays a welcome message with your name and provides quick access to key functions.</p>
                            <p><strong>Student Performance Table:</strong> View real-time data of student attempts, scores, and completion status for all scenarios.</p>
                            <p><strong>Quick Action Cards:</strong> Four main functions are available:</p>
                            <ul class="guide-list">
                                <li>Export Student Reports - Download performance data</li>
                                <li>View Class Performance - See detailed analytics</li>
                                <li>AI Chatbot Help - Get technical assistance</li>
                                <li>Manage Extra Notes - Organize learning materials</li>
                            </ul>
                        </div>
                    </div>

                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                            <h3>Creating Scenarios</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Step 1:</strong> Click "Create New Scenario" from the sidebar or dashboard.</p>
                            <p><strong>Step 2:</strong> Fill in scenario details:</p>
                            <ul class="guide-list">
                                <li>Title - Give your scenario a descriptive name</li>
                                <li>Description - Explain the automotive problem</li>
                                <li>Learning Outcome - Define what students will learn</li>
                            </ul>
                            <p><strong>Step 3:</strong> Add scenario steps with multiple choice options:</p>
                            <ul class="guide-list">
                                <li>Describe each troubleshooting step</li>
                                <li>Provide 2-4 answer options per step</li>
                                <li>Mark correct answers and explanations</li>
                                <li>Add additional steps as needed</li>
                            </ul>
                            <p><strong>Step 4:</strong> Save the scenario to make it available to students.</p>
                        </div>
                    </div>

                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-cog"></i>
                            </div>
                            <h3>Managing Scenarios</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>View All Scenarios:</strong> Access "Manage Automotive Scenarios" from the sidebar to see all created scenarios.</p>
                            <p><strong>Edit Scenarios:</strong></p>
                            <ul class="guide-list">
                                <li>Click the edit button on any scenario</li>
                                <li>Modify title, description, or learning outcomes</li>
                                <li>Update steps and answer options</li>
                                <li>Save changes to update the scenario</li>
                            </ul>
                            <p><strong>Delete Scenarios:</strong> Use the delete button to remove outdated or incorrect scenarios.</p>
                            <p><strong>Preview:</strong> Test scenarios before students access them to ensure accuracy.</p>
                        </div>
                    </div>

                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <h3>Tracking Student Performance</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Performance Dashboard:</strong> Monitor student progress in real-time from the main dashboard.</p>
                            <p><strong>Individual Tracking:</strong></p>
                            <ul class="guide-list">
                                <li>View each student's attempt history</li>
                                <li>See scores and completion status</li>
                                <li>Track time spent on scenarios</li>
                                <li>Identify struggling students</li>
                            </ul>
                            <p><strong>Class Analytics:</strong></p>
                            <ul class="guide-list">
                                <li>Overall class performance metrics</li>
                                <li>Most challenging scenarios</li>
                                <li>Completion rates by topic</li>
                                <li>Performance trends over time</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Additional Sections -->
                <div class="help-grid">
                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h3>Managing Extra Notes</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Adding Learning Materials:</strong></p>
                            <ul class="guide-list">
                                <li>Navigate to "Manage Extra Notes" from the sidebar</li>
                                <li>Upload PDF files with automotive reference materials</li>
                                <li>Organize notes by automotive systems (engine, brake, electrical, etc.)</li>
                                <li>Ensure files are properly named and under 10MB</li>
                            </ul>
                            <p><strong>Content Organization:</strong></p>
                            <ul class="guide-list">
                                <li>Group related materials together</li>
                                <li>Use clear, descriptive filenames</li>
                                <li>Include troubleshooting guides and repair manuals</li>
                            </ul>
                        </div>
                    </div>

                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-robot"></i>
                            </div>
                            <h3>Using AI Assistant</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Getting Technical Help:</strong> The AI chatbot can assist with automotive technical questions and scenario creation.</p>
                            <p><strong>Best Practices:</strong></p>
                            <ul class="guide-list">
                                <li>Ask specific automotive technical questions</li>
                                <li>Request help with troubleshooting sequences</li>
                                <li>Get suggestions for scenario improvements</li>
                                <li>Clarify automotive terminology and concepts</li>
                            </ul>
                            <p><strong>Limitations:</strong> The AI provides general guidance but should not replace professional automotive expertise.</p>
                        </div>
                    </div>

                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <h3>Profile Management</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Account Settings:</strong></p>
                            <ul class="guide-list">
                                <li>Update personal information and contact details</li>
                                <li>Change password for security</li>
                                <li>Set notification preferences</li>
                                <li>Configure display settings</li>
                            </ul>
                            <p><strong>Security:</strong> Regularly update your password and logout when using shared computers.</p>
                        </div>
                    </div>

                    <div class="help-section">
                        <div class="help-section-header">
                            <div class="help-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <h3>Best Practices</h3>
                        </div>
                        <div class="guide-content">
                            <p><strong>Scenario Design:</strong></p>
                            <ul class="guide-list">
                                <li>Start with common automotive problems</li>
                                <li>Create progressive difficulty levels</li>
                                <li>Include real-world troubleshooting steps</li>
                                <li>Provide clear explanations for correct answers</li>
                            </ul>
                            <p><strong>Student Engagement:</strong></p>
                            <ul class="guide-list">
                                <li>Monitor progress regularly</li>
                                <li>Provide feedback on performance</li>
                                <li>Update scenarios based on student struggles</li>
                                <li>Encourage hands-on practice</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Contact Section -->
                <div class="contact-section">
                    <h2><i class="fas fa-headset"></i> Need More Help?</h2>
                    <p>Our support team is here to assist you with any questions or technical issues you may encounter.</p>
                    
                    <div class="contact-options">
                        <a href="mailto:fixsense@gmail.com?subject=FixSense Support Request&body=Hello FixSense Support Team,%0D%0A%0D%0AI need assistance with:%0D%0A%0D%0A[Please describe your issue here]%0D%0A%0D%0AThank you!" class="contact-card contact-button">
                            <i class="fas fa-envelope"></i>
                            <h4>Email Support</h4>
                            <p>fixsense@gmail.com</p>
                            <p>Click to send email</p>
                        </a>

                        <a href="tel:+60177350232" class="contact-card contact-button">
                            <i class="fas fa-phone"></i>
                            <h4>Phone Support</h4>
                            <p>+60 17 735-0232</p>
                            <p>Click to call</p>
                        </a>

                        <a href="https://maps.google.com/?q=ILP+Kuantan+Pahang" target="_blank" class="contact-card contact-button">
                            <i class="fas fa-map-marker-alt"></i>
                            <h4>Visit Us</h4>
                            <p>ILP Kuantan, Pahang</p>
                            <p>Click for directions</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
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

            // Ensure sidebar is properly positioned
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

            // Mobile sidebar toggle
            if (window.innerWidth <= 768) {
                document.body.classList.add('mobile-view');
                
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

                // Mobile-optimize contact buttons
                const contactButtons = document.querySelectorAll('.contact-button');
                contactButtons.forEach(button => {
                    button.style.minHeight = '60px';
                    button.style.padding = '20px';
                    button.style.fontSize = '16px';
                    
                    // Add haptic feedback simulation
                    button.addEventListener('touchstart', function() {
                        this.style.transform = 'scale(0.98)';
                    });
                    
                    button.addEventListener('touchend', function() {
                        setTimeout(() => {
                            this.style.transform = 'scale(1)';
                        }, 100);
                    });
                });

                // Optimize help sections for mobile reading
                const helpSections = document.querySelectorAll('.help-section');
                helpSections.forEach((section, index) => {
                    section.classList.add('fade-in-mobile');
                    section.style.animationDelay = `${index * 0.1}s`;
                });
            }
        });
    </script>
</body>
</html>