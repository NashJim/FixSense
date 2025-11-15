<?php
session_start();
$isLoggedIn = isset($_SESSION['user_id']);
$fullName = $isLoggedIn ? htmlspecialchars($_SESSION['full_name']) : '';
$firstName = $isLoggedIn ? explode(' ', trim($fullName))[0] : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Access Denied</title>
        <style>
            body {
                font-family: "Segoe UI", sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background: #f8f9fa;
                color: #e74c3c;
            }
            .message {
                text-align: center;
                padding: 30px;
                border: 2px solid #e74c3c;
                border-radius: 10px;
                background: white;
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .message h2 {
                margin: 0 0 15px;
                font-size: 1.5rem;
            }
            .message p {
                margin: 0;
                color: #2c3e50;
            }
        </style>
    </head>
    <body>
        <div class="message">
            <h2>⚠️ Admin Access Restricted</h2>
            <p>You\'re an admin. Your job is to monitor and manage the platform, not join them. You don\'t belong here. Sorry...<br>Redirecting to Admin Dashboard...</p>
        </div>
        <script>
            setTimeout(function() {
                window.location.href = "admin.php";
            }, 4500); // Redirect after 4.5 seconds
        </script>
    </body>
    </html>';
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FixSense - Master Troubleshooting, Anytime, Anywhere</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/darkmode.css">
    <!-- Mobile Optimization -->
    <link rel="stylesheet" href="css/mobile-optimization.css">
    <link rel="stylesheet" href="css/project.css">
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="#" class="logo">
                    <i class="fas fa-tools"></i>FixSense
                </a>
                <ul class="nav-links">
                    <li class="mobile-close" style="display: none;">
                        <span style="font-size: 1.5rem; cursor: pointer; color: var(--primary-color);">
                            <i class="fas fa-times"></i>
                        </span>
                    </li>
                    <li><a href="#">Home</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="simulationSelection.php">Simulations</a></li>
                    <?php else: ?>
                        <li><a href="#" id="simulationsLink">Simulations</a></li>
                    <?php endif; ?>

                    <li><a href="ai-chatbot.php">AI Chatbot</a></li>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="studentDashboard.php">Performance Tracking</a></li>
                    <?php endif; ?>
                    <?php if ($isLoggedIn): ?>
                        <li><a href="profile.php">Profile</a></li>
                    <?php endif; ?>
                    
                    <!-- Mobile Auth Section -->
                    <li class="mobile-auth" style="display: none; margin-top: 20px; padding-top: 20px; border-top: 2px solid var(--primary-color);">
                        <?php if ($isLoggedIn): ?>
                            <div style="text-align: center; margin-bottom: 15px;">
                                <span style="color: var(--primary-color); font-weight: 600; font-size: 1.1rem;">
                                    Hello, <?= $firstName ?>
                            </div>
                            <button id="mobileLogoutBtn" class="btn" style="width: 100%; background: #e74c3c; border: none; padding: 12px; border-radius: 8px; color: white; font-weight: 600;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        <?php else: ?>
                            <button id="mobileLoginBtn" class="btn mobile-auth-btn" style="width: 100%; margin-bottom: 10px; padding: 12px; border-radius: 8px; background: var(--primary-color); color: white; border: none; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </button>
                            <button id="mobileRegisterBtn" class="btn btn-secondary mobile-auth-btn" style="width: 100%; padding: 12px; border-radius: 8px; background: #34495e; color: white; border: none; font-weight: 600; cursor: pointer;">
                                <i class="fas fa-user-plus"></i> Register
                            </button>
                        <?php endif; ?>
                    </li>
                </ul>
                <div class="auth-buttons">
                    <?php if ($isLoggedIn): ?>
                        <span id="greeting" style="color: white; background: #2c3e50; padding: 8px 16px; border-radius: 4px; font-weight: 600;">
                            Hello, <?= $firstName ?>
                        </span>
                        <button id="logoutBtn" class="btnLogout" style="background: #e74c3c; margin-left: 10px;">Logout</button>
                    <?php else: ?>
                        <a href="#" class="btn" onclick="openModal(); return false;">Login</a>
                        <a href="#" class="btn btn-secondary" onclick="openRegisterModal(); return false;">Register</a>
                    <?php endif; ?>
                </div>
                <div class="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-bg hero-right"></div>
        <div class="hero-bg hero-left"></div>
        <div class="container">
            <div class="hero-content">
                <h1>Practice Real-World Troubleshooting Skills</h1>
                <p>For Automotive Fields</p>

                <!-- Introduction to ILP Kuantan -->
                <p style="font-size: 1.1rem; color: var(--dark-color); margin-bottom: 25px; max-width: 600px;">
                    Developed for students and instructors at <strong>Institute Latihan Perindustrian (ILP) Kuantan</strong>, Pahang.
                    As a key Technical and Vocational Education and Training (TVET) institution, ILP Kuantan is committed to
                    producing skilled graduates ready for Industry 4.0. FixSense supports that goal by providing flexible,
                    interactive troubleshooting practice in automotive fields, complementing hands-on workshop training.
                </p>

                <div class="search-bar">
                    <input type="text" placeholder="Search Scenarios (e.g., Car Won't Start)">
                    <button><i class="fas fa-search"></i> Search</button>
                </div>

                <div class="cta-buttons">
                    <?php if ($isLoggedIn): ?>
                        <a href="simulationSelection.php" class="btn">Start Simulation</a>
                    <?php else: ?>
                        <a href="#" class="btn" id="startSimulationBtn">Start Simulation</a>
                    <?php endif; ?>
                    <a href="extra_notes.php" class="btn btn-secondary">Extra Notes</a>
                </div>

                <div class="hero-stats">
                    <div class="stat">
                        <div class="stat-value">50+</div>
                        <div class="stat-label">Scenarios Available</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Key Features</h2>
            <p class="section-subtitle">FixSense provides comprehensive troubleshooting training through interactive
                simulations, AI assistance, and performance tracking</p>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-puzzle-piece"></i>
                    </div>
                    <h3>Interactive Simulations</h3>
                    <p>Step-by-step decision-making with instant feedback for automotive troubleshooting scenarios.
                        Practice real-world problems in a risk-free environment.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>AI Chatbot Assistance</h3>
                    <p>Get real-time guidance for troubleshooting questions. The AI chatbot provides step-by-step
                        explanations and industry-standard diagnostic sequences to help you understand the "why" behind
                        solutions.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Performance Analytics</h3>
                    <p>Track your progress and identify weak areas through detailed performance reports. Visualize your
                        improvement over time with comprehensive analytics and actionable insights.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works" id="how-it-works">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <p class="section-subtitle">Master troubleshooting skills through our structured learning approach</p>

            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-icon">
                        <i class="fas fa-list-ul"></i>
                    </div>
                    <h3>Choose a Scenario</h3>
                    <p>Select from a range of realistic problems like "Diagnose a Faulty Car Battery" across automotive
                        domain.</p>
                </div>

                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-icon">
                        <i class="fas fa-project-diagram"></i>
                    </div>
                    <h3>Solve Step-by-Step</h3>
                    <p>Make decisions at each troubleshooting stage, following industry-standard diagnostic sequences.
                        Your choices determine the path and outcome of the simulation.</p>
                </div>

                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-icon">
                        <i class="fas fa-comment-dots"></i>
                    </div>
                    <h3>Get Instant Feedback</h3>
                    <p>Receive immediate explanations for your choices, highlighting correct approaches and identifying
                        mistakes with detailed reasoning based on industry best practices.</p>
                </div>

                <div class="step">
                    <div class="step-number">4</div>
                    <div class="step-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h3>Review & Improve</h3>
                    <p>Analyze your performance reports to understand your strengths and areas for improvement. Retake
                        scenarios to reinforce learning and track your progress over time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="testimonial-section">
        <div class="container">
            <div class="testimonial">
                <p class="testimonial-content">"FixSense helped me understand car diagnostics better than textbooks! The
                    interactive simulations made me think like a professional technician, and the instant feedback
                    helped me learn from my mistakes immediately."</p>
                <p class="testimonial-author">— ILP Kuantan Student</p>
            </div>

            <div class="preview-image">
                <img src="simulation.jpg"
                    alt="FixSense Simulation Interface">
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Enhance Your Troubleshooting Skills?</h2>
            <p>Join hundreds of students at ILP Kuantan who are using FixSense to practice real-world technical
                problem-solving anytime, anywhere.</p>
            <div class="cta-buttons">
                <a href="project.php" class="btn">Get Started as Student</a>
                <a href="#" class="btn btn-secondary">Learn More as Lecturer</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FixSense</h3>
                    <p>Master Troubleshooting, Anytime, Anywhere. Web-based platform for technical skill development in
                        automotive fields.</p>
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
                        <li><a href="studentDashboard.php">Performance Tracking</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="faq.php">FAQs</a></li>
                        <li><a href="technical-support.php">Technical Support</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> fixsense25@gmail.com</li>
                        <li><i class="fas fa-phone"></i> +60 17-725 0232</li>
                        <li><i class="fas fa-map-marker-alt"></i> ILP Kuantan, Pahang</li>
                    </ul>
                    <ul style="margin-top: 20px;">
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="terms-of-service.php">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; 2025 FixSense. All rights reserved. Developed for ILP Kuantan Technical Education.</p>
            </div>
        </div>
        <!-- LOGIN MODAL -->
        <div class="modal-overlay" id="loginModal">
            <div class="modal">
                <span class="close-btn" onclick="closeModal()">&times;</span>
                <div class="header">
                    <div class="login-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h2>Welcome Back</h2>
                    <p>Sign in to your FixSense account</p>
                </div>
                <div class="form-container">
                    <div class="input-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" placeholder="Enter your email" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" id="loginPassword" placeholder="Enter your password" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('loginPassword', this)"></i>
                        </div>
                    </div>

                    <button class="login-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        Sign In
                    </button>

                    <div class="footer">
                        <p><a href="#" onclick="switchToRegister()">Don't have an account? <strong>Create one</strong></a></p>
                        <p><a href="#" onclick="switchToForgotPassword(); return false;" class="forgot-link">Forgot your password?</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- REGISTER MODAL -->
        <div class="modal-overlay" id="registerModal">
            <div class="modal">
                <span class="close-btn" onclick="closeRegisterModal()">&times;</span>
                <div class="header">
                    <div class="login-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <h2>Join FixSense</h2>
                    <p>Create your account and start learning</p>
                </div>
                <div class="form-container">
                    <div class="input-group">
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input type="text" name="full_name" placeholder="Enter your full name" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input type="email" name="email" placeholder="Enter your email" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="password" id="registerPassword" placeholder="Create a password" required minlength="8">
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('registerPassword', this)"></i>
                        </div>
                        <div class="password-requirements">
                            <p>Password must contain:</p>
                            <ul>
                                <li id="length" class="invalid">At least 8 characters</li>
                                <li id="uppercase" class="invalid">One uppercase letter</li>
                                <li id="lowercase" class="invalid">One lowercase letter</li>
                                <li id="number" class="invalid">One number</li>
                            </ul>
                        </div>
                    </div>

                    <div class="input-group">
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm your password" required>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmPassword', this)"></i>
                        </div>
                        <span id="passwordMatchError" class="error-message"></span>
                    </div>

                    <!-- ROLE SELECTION -->
                    <div class="input-group role-selection">
                        <label class="role-label">I am a:</label>
                        <div class="role-options">
                            <button type="button" class="btn-role btn-selected" data-role="student">
                                <i class="fas fa-graduation-cap"></i>
                                Student
                            </button>
                            <button type="button" class="btn-role" data-role="lecturer">
                                <i class="fas fa-chalkboard-teacher"></i>
                                Lecturer
                            </button>
                        </div>
                        <input type="hidden" name="role" id="selectedRole" value="student">
                    </div>

                    <button class="login-btn" type="submit">
                        <i class="fas fa-user-plus"></i>
                        Create Account
                    </button>

                    <div class="footer">
                        <p>
                            Already have an account?
                            <a href="#" onclick="switchToLogin()">
                                <strong>Sign in here</strong>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FORGOT PASSWORD MODAL -->
        <div class="modal-overlay" id="forgotPasswordModal">
            <div class="modal">
                <span class="close-btn" onclick="closeForgotPasswordModal()">&times;</span>
                <div class="header">
                    <div class="icon">
                        <i class="fas fa-key"></i>
                    </div>
                    <h2>Reset Password</h2>
                    <p>Enter your email to receive reset instructions</p>
                </div>
                <div class="form">
                    <div class="input-group">
                        <div class="input-container">
                            <i class="fas fa-envelope"></i>
                            <input type="email" id="resetEmail" placeholder="Enter your email address" required>
                        </div>
                    </div>

                    <button class="login-btn" id="sendResetBtn">
                        <i class="fas fa-paper-plane"></i>
                        Send Reset Link
                    </button>

                    <div class="footer">
                        <p>
                            Remember your password?
                            <a href="#" onclick="switchToLogin()">
                                <strong>Back to Sign In</strong>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PASSWORD RESET SUCCESS MODAL -->
        <div class="modal-overlay" id="resetSuccessModal">
            <div class="modal">
                <span class="close-btn" onclick="closeResetSuccessModal()">&times;</span>
                <div class="header">
                    <div class="icon" style="color: #27ae60;">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h2>Reset Link Sent!</h2>
                    <p>Check your email for password reset instructions</p>
                </div>
                <div class="form">
                    <div style="text-align: center; padding: 20px; color: #666;">
                        <p>We've sent a password reset link to your email address. Please check your inbox and follow the instructions to reset your password.</p>
                        <p style="margin-top: 15px;"><strong>Note:</strong> The link will expire in 1 hour.</p>
                    </div>

                    <button class="login-btn" onclick="closeResetSuccessModal()">
                        <i class="fas fa-arrow-left"></i>
                        Back to Login
                    </button>
                </div>
            </div>
        </div>

        </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Role Selection Setup
            const roleButtons = document.querySelectorAll('.btn-role');
            const hiddenInput = document.getElementById('selectedRole');

            roleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove selection from all
                    roleButtons.forEach(btn => btn.classList.remove('btn-selected'));

                    // Add selection to clicked
                    this.classList.add('btn-selected');

                    // Update hidden input
                    const role = this.getAttribute('data-role');
                    hiddenInput.value = role;

                    console.log("Selected role:", role);
                });
            });

            // Initialize: Select Student by default
            document.querySelector('.btn-role[data-role="student"]').classList.add('btn-selected');
            hiddenInput.value = 'student';

            // === Modal Functions ===
            function openModal() {
                document.getElementById("loginModal").style.display = "flex";
            }

            function closeModal() {
                document.getElementById("loginModal").style.display = "none";
            }

            function openRegisterModal() {
                document.getElementById("registerModal").style.display = "flex";
            }

            function closeRegisterModal() {
                document.getElementById("registerModal").style.display = "none";
            }

            // Forgot Password Modal Functions
            function openForgotPasswordModal() {
                document.getElementById("forgotPasswordModal").style.display = "flex";
            }

            function closeForgotPasswordModal() {
                document.getElementById("forgotPasswordModal").style.display = "none";
            }

            function openResetSuccessModal() {
                document.getElementById("resetSuccessModal").style.display = "flex";
            }

            function closeResetSuccessModal() {
                document.getElementById("resetSuccessModal").style.display = "none";
            }

            // Switch between Login & Register
            function switchToLogin() {
                closeRegisterModal();
                closeForgotPasswordModal();
                closeResetSuccessModal();
                openModal();
            }

            function switchToRegister() {
                closeModal();
                closeForgotPasswordModal();
                closeResetSuccessModal();
                openRegisterModal();
            }

            function switchToForgotPassword() {
                closeModal();
                closeRegisterModal();
                openForgotPasswordModal();
            }
            // Attach modal to navbar buttons
            const loginBtn = document.querySelector('.auth-buttons .btn');
            if (loginBtn) {
                loginBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openModal();
                });
            }

            const registerBtn = document.querySelector('.auth-buttons .btn.btn-secondary');
            if (registerBtn) {
                registerBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    openRegisterModal();
                });
            }

            // Attach close buttons
            const closeLoginBtn = document.querySelector('#loginModal .close-btn');
            if (closeLoginBtn) {
                closeLoginBtn.addEventListener('click', closeModal);
            }

            const closeRegisterBtn = document.querySelector('#registerModal .close-btn');
            if (closeRegisterBtn) {
                closeRegisterBtn.addEventListener('click', closeRegisterModal);
            }

            // Forgot Password Modal Event Listeners
            const closeForgotBtn = document.querySelector('#forgotPasswordModal .close-btn');
            if (closeForgotBtn) {
                closeForgotBtn.addEventListener('click', closeForgotPasswordModal);
            }

            const closeResetSuccessBtn = document.querySelector('#resetSuccessModal .close-btn');
            if (closeResetSuccessBtn) {
                closeResetSuccessBtn.addEventListener('click', closeResetSuccessModal);
            }

            // Send Reset Email Button
            const sendResetBtn = document.getElementById('sendResetBtn');
            if (sendResetBtn) {
                sendResetBtn.addEventListener('click', handlePasswordReset);
            }

            // Forgot Password Link
            const forgotLink = document.querySelector('.forgot-link');
            if (forgotLink) {
                forgotLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    switchToForgotPassword();
                });
            }

            // === Login Modal Links ===
            const createAccountLink = document.querySelector('#loginModal .footer a');
            if (createAccountLink) {
                createAccountLink.addEventListener('click', switchToRegister);
            }

            const loginHereLink = document.querySelector('#registerModal .footer a');
            if (loginHereLink) {
                loginHereLink.addEventListener('click', switchToLogin);
            }
            const startSimBtn = document.getElementById('startSimulationBtn');
            if (startSimBtn) {
                startSimBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert("Please log in to access simulations.");
                    openModal();
                });
            }

            const simulationsLink = document.getElementById('simulationsLink');
            if (simulationsLink) {
                simulationsLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    alert("Please log in to access simulations.");
                    openModal();
                });
            }

            // === Mobile Navigation Toggle ===
            const mobileToggle = document.querySelector('.mobile-toggle');
            const navLinks = document.querySelector('.nav-links');
            const mobileClose = document.querySelector('.mobile-close span');
            const mobileLogoutBtn = document.querySelector('#mobileLogoutBtn');
            // Note: body variable declared later in dark mode section

            function closeMobileMenu() {
                navLinks.classList.remove('active');
                document.body.style.overflow = '';
            }

            function openMobileMenu() {
                navLinks.classList.add('active');
                document.body.style.overflow = 'hidden';
            }

            // Make closeMobileMenu available globally for mobile auth buttons
            window.closeMobileMenu = closeMobileMenu;

            mobileToggle.addEventListener('click', function() {
                if (navLinks.classList.contains('active')) {
                    closeMobileMenu();
                } else {
                    openMobileMenu();
                }
            });

            // Close button in mobile menu
            if (mobileClose) {
                mobileClose.addEventListener('click', closeMobileMenu);
            }

            // Mobile logout button
            if (mobileLogoutBtn) {
                mobileLogoutBtn.addEventListener('click', function() {
                    closeMobileMenu();
                    // Trigger the same logout function as desktop
                    if (window.handleLogout) {
                        window.handleLogout();
                    } else {
                        window.location.href = 'logout.php';
                    }
                });
            }

            // Mobile auth buttons (Login/Register)
            const mobileLoginBtn = document.getElementById('mobileLoginBtn');
            const mobileRegisterBtn = document.getElementById('mobileRegisterBtn');

            if (mobileLoginBtn) {
                console.log('Mobile login button found and listener attached');
                mobileLoginBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Mobile login button clicked');
                    closeMobileMenu();
                    setTimeout(() => {
                        console.log('Opening login modal');
                        openModal();
                    }, 300); // Small delay to allow menu to close
                });
            } else {
                console.log('Mobile login button not found');
            }

            if (mobileRegisterBtn) {
                console.log('Mobile register button found and listener attached');
                mobileRegisterBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Mobile register button clicked');
                    closeMobileMenu();
                    setTimeout(() => {
                        console.log('Opening register modal');
                        openRegisterModal();
                    }, 300); // Small delay to allow menu to close
                });
            } else {
                console.log('Mobile register button not found');
            }

            // Close mobile menu when clicking a link
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (navLinks.classList.contains('active') && 
                    !navLinks.contains(e.target) && 
                    !mobileToggle.contains(e.target)) {
                    closeMobileMenu();
                }
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });

            // === API Configuration ===
            const API_BASE_URL = window.location.origin;

            // === Login Function ===
            async function handleLogin(event) {
                event.preventDefault();

                const email = document.querySelector('#loginModal input[type="email"]').value;
                const password = document.querySelector('#loginModal input[type="password"]').value;

                try {
                    const response = await fetch(`${API_BASE_URL}/login.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        credentials: 'include', // Important for Sanctum
                        body: JSON.stringify({
                            email: email,
                            password: password
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        console.log('Login successful:', data);
                        closeModal();
                        alert('Login successful!');
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message || 'Login failed');
                    }
                } catch (error) {
                    console.error('Login error:', error);
                    alert('An error occurred during login');
                }
            }

            // === Register Function ===
            async function handleRegister(event) {
                event.preventDefault();

                const fullName = document.querySelector('#registerModal input[name="full_name"]').value;
                const email = document.querySelector('#registerModal input[name="email"]').value;
                const password = document.querySelector('#registerModal input[name="password"]').value;
                const confirmPassword = document.querySelector('#registerModal input[name="confirm_password"]').value;
                const role = document.getElementById('selectedRole').value;

                if (password !== confirmPassword) {
                    alert('Passwords do not match');
                    return;
                }

                try {
                    const response = await fetch(`${API_BASE_URL}/register.php`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            full_name: fullName,
                            email: email,
                            password: password,
                            password_confirmation: confirmPassword,
                            role: role
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        console.log('Registration successful:', data);
                        closeRegisterModal();
                        alert('Registration successful! Please login.');
                        openModal();
                    } else {
                        alert(data.message || 'Registration failed');
                    }
                } catch (error) {
                    console.error('Registration error:', error);
                    alert('An error occurred during registration');
                }
            }

            // === Password Reset Function ===
            async function handlePasswordReset(event) {
                event.preventDefault();

                const email = document.getElementById('resetEmail').value;
                const sendResetBtn = document.getElementById('sendResetBtn');

                if (!email) {
                    alert('Please enter your email address');
                    return;
                }

                // Immediately redirect to local reset form with email parameter (no email sending)
                // This avoids server/email issues and works reliably on Hostinger
                try {
                    sendResetBtn.disabled = true;
                    sendResetBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Redirecting...';
                    const target = `reset-password-form.php?email=${encodeURIComponent(email)}`;
                    closeForgotPasswordModal();
                    window.location.href = target;
                } catch (error) {
                    console.error('Reset password redirect error:', error);
                    alert('Could not open the reset page. Please try again.');
                } finally {
                    // Re-enable button if user returns
                    sendResetBtn.disabled = false;
                    sendResetBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Reset Link';
                }
            }

            // === Logout Function ===
            async function handleLogout() {
                try {
                    const response = await fetch('logout.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });
                    if (response.ok) {
                        // Clear session on client side
                        document.getElementById('greeting').remove();
                        document.getElementById('logoutBtn').remove();
                        alert('You have been logged out.');
                        window.location.reload(); // Refresh to update UI
                    }
                } catch (error) {
                    console.error('Logout error:', error);
                    alert('An error occurred during logout');
                }
            }

            // === Attach Form Submissions ===
            const loginForm = document.querySelector('#loginModal .login-btn');
            if (loginForm) {
                loginForm.addEventListener('click', handleLogin);
            }

            const registerForm = document.querySelector('#registerModal .login-btn');
            if (registerForm) {
                registerForm.addEventListener('click', handleRegister);
            }

            const logoutBtn = document.getElementById('logoutBtn');
            if (logoutBtn) {
                logoutBtn.addEventListener('click', handleLogout);
            }

            // Dark mode toggle - Inline solution
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            
            console.log('Dark mode script loaded', darkModeToggle); // Debug
            
            // Check saved preference (default to light mode)
            const isDarkMode = localStorage.getItem('darkMode') === 'true';
            
            // Apply initial theme
            if (isDarkMode) {
                body.classList.add('dark-mode');
                if (darkModeToggle) darkModeToggle.innerHTML = '<i class="fas fa-sun"></i>';
            } else {
                body.classList.remove('dark-mode');
                if (darkModeToggle) darkModeToggle.innerHTML = '<i class="fas fa-moon"></i>';
            }
            
            // Add click event
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    console.log('Dark mode button clicked!'); // Debug log
                    
                    // Toggle dark mode
                    body.classList.toggle('dark-mode');
                    const isNowDark = body.classList.contains('dark-mode');
                    
                    console.log('Dark mode is now:', isNowDark); // Debug
                    
                    // Save preference
                    localStorage.setItem('darkMode', isNowDark);
                    
                    // Update button icon
                    darkModeToggle.innerHTML = isNowDark ? 
                        '<i class="fas fa-sun"></i>' : 
                        '<i class="fas fa-moon"></i>';
                });
            } else {
                console.error('Dark mode toggle button not found!');
            }
        });

        // Password Toggle Function
        function togglePassword(inputId, icon) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Password Validation
        const registerPassword = document.getElementById('registerPassword');
        const confirmPassword = document.getElementById('confirmPassword');
        const passwordMatchError = document.getElementById('passwordMatchError');

        if (registerPassword) {
            registerPassword.addEventListener('input', function() {
                const password = this.value;
                
                // Check length
                const lengthCheck = document.getElementById('length');
                if (password.length >= 8) {
                    lengthCheck.classList.remove('invalid');
                    lengthCheck.classList.add('valid');
                } else {
                    lengthCheck.classList.remove('valid');
                    lengthCheck.classList.add('invalid');
                }

                // Check uppercase
                const uppercaseCheck = document.getElementById('uppercase');
                if (/[A-Z]/.test(password)) {
                    uppercaseCheck.classList.remove('invalid');
                    uppercaseCheck.classList.add('valid');
                } else {
                    uppercaseCheck.classList.remove('valid');
                    uppercaseCheck.classList.add('invalid');
                }

                // Check lowercase
                const lowercaseCheck = document.getElementById('lowercase');
                if (/[a-z]/.test(password)) {
                    lowercaseCheck.classList.remove('invalid');
                    lowercaseCheck.classList.add('valid');
                } else {
                    lowercaseCheck.classList.remove('valid');
                    lowercaseCheck.classList.add('invalid');
                }

                // Check number
                const numberCheck = document.getElementById('number');
                if (/[0-9]/.test(password)) {
                    numberCheck.classList.remove('invalid');
                    numberCheck.classList.add('valid');
                } else {
                    numberCheck.classList.remove('valid');
                    numberCheck.classList.add('invalid');
                }

                // Check password match
                if (confirmPassword.value && confirmPassword.value !== password) {
                    passwordMatchError.textContent = 'Passwords do not match';
                } else {
                    passwordMatchError.textContent = '';
                }
            });
        }

        if (confirmPassword) {
            confirmPassword.addEventListener('input', function() {
                if (this.value !== registerPassword.value) {
                    passwordMatchError.textContent = 'Passwords do not match';
                } else {
                    passwordMatchError.textContent = '';
                }
            });
        }

        // Prevent form submission if passwords don't match or requirements not met
        const registerForm = document.getElementById('registerModal')?.querySelector('form');
        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                const password = registerPassword.value;
                const confirm = confirmPassword.value;

                // Check if passwords match
                if (password !== confirm) {
                    e.preventDefault();
                    passwordMatchError.textContent = 'Passwords do not match';
                    return false;
                }

                // Check password requirements
                if (password.length < 8 || !/[A-Z]/.test(password) || 
                    !/[a-z]/.test(password) || !/[0-9]/.test(password)) {
                    e.preventDefault();
                    alert('Please meet all password requirements');
                    return false;
                }
            });
        }
    </script>
    <!-- Mobile Optimization -->
    <script src="js/mobile-optimization.js"></script>
</body>

</html>