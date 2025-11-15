<?php
session_start();

// Check if user is logged in - redirect to login if not
if (!isset($_SESSION['user_id']) && !isset($_SESSION['lecturer_id'])) {
    header("Location: login.php");
    exit();
}

$isLoggedIn = isset($_SESSION['user_id']);
$fullName = $isLoggedIn ? htmlspecialchars($_SESSION['full_name']) : '';
$role = $isLoggedIn ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Chatbot Assistance - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/darkmode.css">
    <script src="js/darkmode-fixed.js"></script>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f4ff 0%, #e6f7ff 100%);
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        /* Dark Mode Styles for AI Chatbot */
        body.dark-mode {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
            color: #f1f5f9 !important;
        }
        
        header {
            background: #1a56db;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }
        
        body.dark-mode header {
            background: #1e293b !important;
            box-shadow: 0 4px 12px rgba(0,0,0,0.4) !important;
        }
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #1a56db;
            margin-bottom: 20px;
        }
        
        body.dark-mode h1 {
            color: #4f9cf9 !important;
        }
        
        .section-subtitle {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 30px;
            color: #555;
            font-size: 1.1rem;
            line-height: 1.6;
        }
        
        body.dark-mode .section-subtitle {
            color: #94a3b8 !important;
        }
        
        .chatbot-container {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: 0 auto;
        }
        
        body.dark-mode .chatbot-container {
            background: #334155 !important;
            box-shadow: 0 6px 20px rgba(0,0,0,0.3) !important;
            border: 1px solid #475569;
        }
        .chatbot-header {
            text-align: center;
            margin-bottom: 20px;
            color: #1a56db;
        }
        
        body.dark-mode .chatbot-header {
            color: #4f9cf9 !important;
        }
        
        .chatbot-description {
            text-align: center;
            margin-bottom: 25px;
            color: #555;
            font-size: 0.95rem;
        }
        
        body.dark-mode .chatbot-description {
            color: #94a3b8 !important;
        }
        .jotform-embed {
            width: 100%;
            min-height: 800px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        /* Back Button */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #ffffff, #e6f7ff);
            color: #1a56db;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            box-shadow: 0 6px 16px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        
        body.dark-mode .back-link {
            background: linear-gradient(135deg, #334155, #475569) !important;
            color: #4f9cf9 !important;
            box-shadow: 0 6px 16px rgba(0,0,0,0.3) !important;
        }
        
        .back-link i {
            background: #1a56db;
            color: white;
            border-radius: 50%;
            padding: 6px;
            font-size: 0.9rem;
        }
        
        body.dark-mode .back-link i {
            background: #4f9cf9 !important;
        }
        
        .back-link:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, #ffeedf, #ffd9c2);
            color: #ff6b35;
        }
        
        body.dark-mode .back-link:hover {
            background: linear-gradient(135deg, #475569, #64748b) !important;
            color: #ff8c65 !important;
        }
        
        .back-link:hover i {
            background: #ff6b35;
            color: white;
        }
        
        body.dark-mode .back-link:hover i {
            background: #ff8c65 !important;
        }
        /* Responsive */
        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }
            .chatbot-container {
                padding: 20px;
                margin: 0 10px;
            }
            .jotform-embed {
                min-height: 600px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
            <h2>FixSense - AI Chatbot Assistance</h2>
            <button id="darkModeToggle" class="dark-mode-btn">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </header>

    <div class="container">
        <!-- Back Button -->
        <a href="project.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Home</a>

        <h1>AI Chatbot Assistance</h1>
        <p class="section-subtitle">
            Get step-by-step troubleshooting help for automotive problems<br>
        </p>

        <div class="chatbot-container">
            <div class="chatbot-header">
                <h2>Ask a Technical Question</h2>
            </div>
            <div class="chatbot-description">
                Describe your problem (example: “Lampu brek sentiasa menyala” or “How to check free-play pedal brek?”).<br>
                Your AI Assistance will respond with guidance based on industry standards.
            </div>

            <!-- REPLACE THIS WITH YOUR JOTFORM EMBED CODE -->
            <iframe
                id="jotform-iframe"
                title="FixSense AI Chatbot Form"
                src="https://agent.jotform.com/0199ba96013d7d47a6a15848e679aed8cf32"
                frameborder="0"
                scrolling="no"
                class="jotform-embed">
            </iframe>
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
    </script>
</body>
</html>