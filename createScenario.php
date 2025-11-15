<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}
$fullName = htmlspecialchars($_SESSION['full_name']);
$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $category = $_POST['category'];
        $baseIdMap = [
            'Engine Problems' => 1.0,
            'Brake System Problems' => 2.0,
            'Air-Suspension Problems' => 3.0,
            'Air-Conditioning Problems' => 4.0,
            'Fuel System Problems' => 5.0,
            'Cooling System Problems' => 6.0,
            'Transmission System Problems' => 7.0,
            'Suspension System Problems' => 8.0,
            'Electrical System Problems' => 9.0,
            'Clutch System Problems' => 10.0,
            'Exhaust System Problems' => 11.0,
            'Wheels System Problems' => 12.0
            
        ];
        $baseId = $baseIdMap[$category] ?? 2.0;

        $stmt = $pdo->prepare("SELECT MAX(id) as max_id FROM scenarios WHERE category = ?");
        $stmt->execute([$category]);
        $maxId = $stmt->fetch()['max_id'];

        $newId = ($maxId === null) ? $baseId : $maxId + 0.1;
       // --- Handle image upload (baru) ---
$imagePath = null;
if (!empty($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['image_file'];
    $uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $filename = time() . '' . preg_replace('/[^a-zA-Z0-9.-]/', '_', $file['name']);
    $targetPath = $uploadsDir . DIRECTORY_SEPARATOR . $filename;

    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $imagePath = 'uploads/' . $filename;
    }
}

// --- Insert scenario ---
$stmt = $pdo->prepare("INSERT INTO scenarios (id, title, description, category, image_path, created_by, root_cause, solution, learning)
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([
    $newId,
    $_POST['title'],
    $_POST['description'],
    $_POST['category'],
    $imagePath,
    $_SESSION['user_id'],
    $_POST['root_cause'],
    $_POST['solution'],
    $_POST['learning']
]);



        $steps = json_decode($_POST['steps_json'], true);
        foreach ($steps as $i => $step) {
            $stmt = $pdo->prepare("INSERT INTO steps (scenario_id, step_number, description) VALUES (?, ?, ?)");
            $stmt->execute([$newId, $i + 1, $step['description']]);
            $stepId = $pdo->lastInsertId();

            // Cari teks jawapan betul
            $correctText = '';
            foreach ($step['options'] as $opt) {
                if (!empty($opt['isCorrect'])) {
                    $correctText = $opt['text'];
                    break;
                }
            }

            foreach ($step['options'] as $opt) {
                $isCorrect = !empty($opt['isCorrect']) ? 1 : 0;
                if ($isCorrect) {
                    // Option betul: guna explanation asal
                    $explanation = "✅ Correct! <br>" . nl2br($opt['explanation']);
                } else {
                    // Option salah: bina format automatik
                    $explanation = "❌ Incorrect.<br>✅ Correct answer: $correctText<br>Reason: " . nl2br($opt['explanation']);
                }
                $stmt = $pdo->prepare("INSERT INTO options (step_id, text, is_correct, explanation) VALUES (?, ?, ?, ?)");
                $stmt->execute([$stepId, $opt['text'], $isCorrect, $explanation]);
            }
        }

        header("Location: lecturer.php?msg=Scenario+created+successfully!");
        exit();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Scenario - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<style>
    /* === MULA: Gaya dari project.php (dikemas kini) === */
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
        background-color: #f1f5f9; /* Warna latar belakang utama */
        color: var(--dark-color);
        line-height: 1.6;
        transition: background-color 0.3s, color 0.3s; /* Untuk dark mode */
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* === SIMPLIFIED HEADER WITH BACK BUTTON ONLY === */
    .title-with-back {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 40px;
        padding-top: 20px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        color: #1a56db;
        font-weight: 600;
        background: linear-gradient(135deg, #ffffff, #e6f7ff);
        padding: 10px 20px;
        border-radius: 50px;
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
        transition: all 0.3s ease;
        margin-top: 8px; /* Align with title */
    }

    .back-btn:hover {
        transform: translateY(-3px);
        background: linear-gradient(135deg, #ffeedf, #ffd9c2);
        color: #ff6b35;
    }

    .back-btn i {
        background: #1a56db;
        color: white;
        border-radius: 50%;
        padding: 6px;
        font-size: 0.9rem;
    }

    .back-btn:hover i {
        background: #ff6b35;
        color: white;
    }

    .title-content {
        flex: 1;
    }

    /* Content styling */
    .logo {
        display: flex;
        align-items: center;
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        text-decoration: none;
    }

    .logo i {
        margin-right: 10px; /* Ruang ikon & teks seperti project.php */
        color: var(--secondary-color);
    }

    /* Nav Links */
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

    /* Auth Buttons */
    .auth-buttons {
        display: flex;
        gap: 15px;
        align-items: center; /* Pastikan butang sejajar */
    }

    .mobile-toggle {
        display: none;
        font-size: 1.5rem;
        cursor: pointer;
    }
    /* --- TAMAT: Bahagian Header yang Diubah --- */

    /* === TAMAT: Gaya dari project.php === */

    /* === MULA: Gaya Dark Mode (Selaras dengan project.php) === */
    body.dark-mode {
        background-color: #0f172a !important;
        color: #f1f5f9 !important;
    }

    /* Header Dark Mode */
    .dark-mode header {
        background-color: #0f172a !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
    }

    .dark-mode .logo {
        color: #93c5fd !important;
    }

    .dark-mode .logo i {
        color: #fb923c !important;
    }

    .dark-mode .nav-links a {
        color: #f1f5f9 !important;
    }

    .dark-mode .nav-links a:hover {
        color: #fb923c !important;
    }

    .dark-mode .nav-links a::after {
        background-color: #fb923c !important;
    }

    /* Back Button Dark Mode */
    .dark-mode .back-link {
        background: #1e293b !important;
        color: #93c5fd !important;
        border-color: #334155 !important;
    }

    .dark-mode .back-link:hover {
        background: #334155 !important;
        color: #fb923c !important;
    }

    .dark-mode .back-link i {
        color: inherit !important;
    }
    /* === TAMAT: Gaya Dark Mode === */

    /* === MULA: Gaya Kandungan Utama (Form Scenario) === */
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

    /* Form Styling */
    .form-container {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--dark-color);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid var(--gray-color);
        border-radius: 4px;
        font-size: 1rem;
        transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary-color);
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    /* Steps Section */
    .steps-section {
        background: white;
        border-radius: 10px;
        padding: 30px;
        box-shadow: var(--card-shadow);
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .steps-container {
        /* Untuk menempatkan langkah-langkah */
        margin-top: 20px;
        padding: 15px;
        background-color: #f5f5f5;
        border-radius: 5px;
    }

    .step-card {
        background: #f8fafc;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid var(--primary-color);
    }

    .step-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .step-number {
        font-weight: bold;
        font-size: 1.2rem;
        color: var(--primary-color);
    }

    .step-actions {
        display: flex;
        gap: 10px;
    }

    .btn-step {
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
    }

    .btn-add-step {
        background-color: var(--primary-color);
        color: white;
    }

    .btn-add-step:hover {
        background-color: #1648b5;
    }

    .btn-remove-step {
        background-color: #dc3545;
        color: white;
    }

    .btn-remove-step:hover {
        background-color: #c82333;
    }

    /* Options inside a step */
    .options-container {
        margin-top: 15px;
    }

    .option-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .option-row input,
    .option-row select {
        flex: 1;
    }

    .option-row .btn-option {
        padding: 6px 10px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 0.85rem;
    }

    .btn-add-option {
        background-color: #28a745;
        color: white;
    }

    .btn-add-option:hover {
        background-color: #218838;
    }

    .btn-remove-option {
        background-color: #dc3545;
        color: white;
    }

    .btn-remove-option:hover {
        background-color: #c82333;
    }

    /* Buttons */
    .btn {
        display: inline-block;
        padding: 12px 24px;
        background-color: var(--primary-color);
        color: white;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 16px;
    }

    .btn:hover {
        background-color: #1648b5;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-secondary {
        background-color: var(--secondary-color);
    }

    .btn-secondary:hover {
        background-color: #e55a2b;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
    }

    /* Footer - Sama macam project.php */
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

    /* === TAMAT: Gaya Kandungan Utama === */

    /* === MULA: Responsif (Selaras dengan project.php) === */
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

        .form-actions {
            flex-direction: column;
        }

        .btn {
            width: 100%;
        }

        /* Susun atur header untuk mobile */
        .nav-left {
           order: 1;
        }
        .logo {
            order: 2;
            flex-grow: 1; /* Biarkan logo di tengah */
            justify-content: center;
        }
        .nav-links {
            order: 3;
        }
        .auth-buttons {
            order: 4;
        }
    }
    /* === TAMAT: Responsif === */

</style>
</head>
<body>
    <!-- Mobile Toggle Button -->
    <button class="mobile-toggle desktop-only" id="mobileToggle">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="page-header">
                <div class="title-with-back">
                    <a href="lecturer.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div class="title-content">
                        <h1 class="page-title">Create New Troubleshooting Scenario</h1>
                        <p class="page-subtitle">Build interactive scenarios for students to practice problem-solving skills.</p>
                    </div>
                </div>
            </div>

            <?php if ($error): ?>
                <div style="background:#fee; color:#c33; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form id="scenarioForm" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="scenarioTitle">Scenario Title *</label>
                        <input type="text" id="scenarioTitle" name="title" placeholder="e.g., Diagnose a Faulty Car Battery" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="scenarioDescription">Scenario Description *</label>
                        <textarea id="scenarioDescription" name="description" placeholder="Describe the initial problem or situation..." required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="scenarioCategory">Category *</label>
                        <select id="scenarioCategory" name="category" required>
                            <option value="">Select a Category</option>
                            <option value="Engine Problems">Engine Problems</option>
                            <option value="Brake System Problems">Brake System Problems</option>
                            <option value="Air-Suspension Problems">Air-Suspension Problems</option>
                            <option value="Air-Conditioning Problems">Air-Conditioning Problems</option>
                            <option value="Fuel System Problems">Fuel System Problems</option>
                            <option value="Cooling System Problems">Cooling System Problems</option>
                            <option value="Transmission System Problems">Transmission System Problems</option>
                            <option value="Suspension System Problems">Suspension System Problems</option>
                            <option value="Electrical System Problems">Electrical System Problems</option>
                            <option value="Clutch System Problems">Clutch System Problems</option>
                            <option value="Exhaust System Problems">Exhaust System Problems</option>
                            <option value="Wheels System Problems">Wheels System Problems</option>
                        </select>
                    </div>

                    

                    <div class="form-group">
    <label for="image_file">Upload Image (Optional)</label>

    <!-- Preview box -->
    <img 
        id="previewImage"
        src="#" 
        alt="Image preview"
        style="display:none; width: 200px; height: 150px; object-fit: contain; border-radius:8px; border:1px solid #ddd; background:#f8f8f8; margin-bottom:10px;"
    >

    <input type="file" id="image_file" name="image_file" accept="image/*">
    <small>Upload a related image for this scenario (JPG, PNG).</small>
</div>



                    <hr style="margin:25px 0;">
<h3 style="color:#1a56db;">Final Diagnosis Information</h3>

<div class="form-group">
    <label for="root_cause">Root Cause *</label>
    <textarea name="root_cause" id="root_cause" placeholder="Explain the root cause..." required></textarea>
</div>

<div class="form-group">
    <label for="solution">Solution *</label>
    <textarea name="solution" id="solution" placeholder="Explain the solution..." required></textarea>
</div>

<div class="form-group">
    <label for="learning">Learning Outcome *</label>
    <textarea name="learning" id="learning" placeholder="State what the student should learn..." required></textarea>
</div>
                    <input type="hidden" id="stepsJsonInput" name="steps_json">
                </form>
            </div>

            <div class="steps-section">
                <h2 class="section-title"><i class="fas fa-project-diagram"></i> Scenario Steps</h2>
                <p>Add the decision points and possible outcomes for your scenario.</p>

                <div class="steps-container" id="stepsContainer">
                    <div class="step-card" data-step-id="1">
                        <div class="step-header">
                            <div class="step-number">Step 1</div>
                            <div class="step-actions">
                                <button type="button" class="btn-step btn-remove-step" onclick="removeStep(this)" style="display: none;"><i class="fas fa-trash"></i> Remove</button>
                                <button type="button" class="btn-step btn-add-step" onclick="addStep()"><i class="fas fa-plus"></i> Add Step</button>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Step Description *</label>
                            <textarea class="step-description" placeholder="Describe the situation at this step..." required></textarea>
                        </div>

                        <div class="options-container">
                            <label>Options for this step:</label>
                            <div class="option-row">
                                <input type="text" class="option-text" placeholder="Option A text..." required>
                                <select class="option-correct">
                                    <option value="false">Incorrect</option>
                                    <option value="true">Correct</option>
                                </select>
                                <input type="text" class="option-explanation" placeholder="Explanation if chosen..." required>
                                <button type="button" class="btn-option btn-add-option" onclick="addOption(this)"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="lecturer.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" form="scenarioForm" class="btn">Save Scenario</button>
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
                        <li><a href="lecturer.html">Dashboard</a></li>
                        <li><a href="#">Manage Scenarios</a></li>
                        <li><a href="#">AI Chatbot</a></li>
                        <li><a href="#">Manage Extra Notes</a></li>
                        <li><a href="lecturer.html">Settings</a></li>
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
        // --- Script untuk dinamik form ---
        let stepCounter = 1;

        function addStep() {
            stepCounter++;
            const stepsContainer = document.getElementById('stepsContainer');
            const newStepCard = document.createElement('div');
            newStepCard.className = 'step-card';
            newStepCard.setAttribute('data-step-id', stepCounter);
            newStepCard.innerHTML = `
                <div class="step-header">
                    <div class="step-number">Step ${stepCounter}</div>
                    <div class="step-actions">
                        <button type="button" class="btn-step btn-remove-step" onclick="removeStep(this)"><i class="fas fa-trash"></i> Remove</button>
                        <button type="button" class="btn-step btn-add-step" onclick="addStep()"><i class="fas fa-plus"></i> Add Step</button>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Step Description *</label>
                    <textarea class="step-description" placeholder="Describe the situation at this step..." required></textarea>
                </div>

                <div class="options-container">
                    <label>Options for this step:</label>
                    <div class="option-row">
                        <input type="text" class="option-text" placeholder="Option A text..." required>
                        <select class="option-correct">
                            <option value="false">Incorrect</option>
                            <option value="true">Correct</option>
                        </select>
                        <input type="text" class="option-explanation" placeholder="Explanation if chosen..." required>
                        <button type="button" class="btn-option btn-add-option" onclick="addOption(this)"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
            `;
            stepsContainer.appendChild(newStepCard);
            const previousStep = stepsContainer.querySelector(`.step-card[data-step-id="${stepCounter - 1}"]`);
            if (previousStep) {
                previousStep.querySelector('.btn-add-step').style.display = 'none';
            }
        }

        function removeStep(button) {
            const stepCard = button.closest('.step-card');
            if (stepCard) {
                stepCard.remove();
                const allSteps = document.querySelectorAll('.step-card');
                allSteps.forEach((step, index) => {
                    step.querySelector('.step-number').textContent = `Step ${index + 1}`;
                    step.setAttribute('data-step-id', index + 1);
                });
                stepCounter = allSteps.length;
            }
        }

        function addOption(button) {
            const optionsContainer = button.closest('.options-container');
            const newOptionRow = document.createElement('div');
            newOptionRow.className = 'option-row';
            newOptionRow.innerHTML = `
                <input type="text" class="option-text" placeholder="Option text..." required>
                <select class="option-correct">
                    <option value="false">Incorrect</option>
                    <option value="true">Correct</option>
                </select>
                <input type="text" class="option-explanation" placeholder="Explanation if chosen..." required>
                <button type="button" class="btn-option btn-remove-option" onclick="removeOption(this)"><i class="fas fa-trash"></i></button>
            `;
            optionsContainer.appendChild(newOptionRow);
        }

        function removeOption(button) {
            const optionRow = button.closest('.option-row');
            if (optionRow) {
                optionRow.remove();
            }
        }

        document.getElementById('scenarioForm').addEventListener('submit', function(e) {
            // Add confirmation dialog before submission
            const confirmed = confirm('Are you sure you want to create this scenario? Please review all steps and options before confirming.');
            
            if (!confirmed) {
                e.preventDefault();
                return false;
            }
            
            const steps = [];
            document.querySelectorAll('.step-card').forEach(card => {
                const stepDesc = card.querySelector('.step-description').value;
                const options = [];
                card.querySelectorAll('.option-row').forEach(optRow => {
                    const text = optRow.querySelector('.option-text').value;
                    const isCorrect = optRow.querySelector('.option-correct').value === 'true';
                    const explanation = optRow.querySelector('.option-explanation').value;
                    options.push({ text, isCorrect, explanation });
                });
                steps.push({ description: stepDesc, options });
            });
            document.getElementById('stepsJsonInput').value = JSON.stringify(steps);
        });

        // === Image preview (Create Scenario) ===
        document.getElementById('image_file').addEventListener('change', function(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('previewImage');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            } else {
                preview.src = '#';
                preview.style.display = 'none';
            }
        });

        // === Mobile optimizations ===
        document.addEventListener('DOMContentLoaded', function() {
            // Touch-friendly form enhancements
            const formInputs = document.querySelectorAll('input, select, textarea');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    if (window.innerWidth <= 768) {
                        setTimeout(() => {
                            this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    }
                });
            });
            
            // Mobile-specific validations and optimizations
            if (window.innerWidth <= 768) {
                document.body.classList.add('mobile-view');
                
                // Optimize image preview for mobile
                const imageInput = document.getElementById('image_file');
                const preview = document.getElementById('previewImage');
                
                if (preview) {
                    preview.style.width = '100%';
                    preview.style.maxWidth = '300px';
                    preview.style.height = 'auto';
                }
                
                // Add mobile-friendly step management
                const stepCards = document.querySelectorAll('.step-card');
                stepCards.forEach(card => {
                    card.classList.add('fade-in-mobile');
                });
            }
            
            // Prevent zoom on iOS when focusing inputs
            if (/iPad|iPhone|iPod/.test(navigator.userAgent)) {
                const metaTag = document.querySelector('meta[name="viewport"]');
                if (metaTag) {
                    metaTag.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
                }
            }
        });

       
    </script>
</body>
</html>