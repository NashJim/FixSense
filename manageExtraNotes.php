<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}
$fullName = htmlspecialchars($_SESSION['full_name']);
$initials = strtoupper(substr($fullName, 0, 1) . (strpos($fullName, ' ') ? substr($fullName, strpos($fullName, ' ') + 1, 1) : ''));
$message = '';
$error = '';

// Function to generate sidebar with active page
function generateSidebar($activePage) {
    $menuItems = [
        'lecturer.php' => ['icon' => 'fas fa-home', 'title' => 'Dashboard'],
        'manageScenario.php' => ['icon' => 'fas fa-car', 'title' => 'Manage Automotive Scenarios'],
        'createScenario.php' => ['icon' => 'fas fa-plus-circle', 'title' => 'Create New Scenario'],
        'manageExtraNotes.php' => ['icon' => 'fas fa-book', 'title' => 'Manage Extra Notes'],
        'studentPerformance.php' => ['icon' => 'fas fa-chart-bar', 'title' => 'Student Performance Tracking'],
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

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
} 

// DELETE note
if (isset($_GET['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM extra_notes WHERE id = ?");
    $stmt->execute([$_GET['delete_id']]);
    header("Location: manageExtraNotes.php?msg=Note+deleted+successfully!");
    exit();
}

// UPLOAD note
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $uploadDir = 'uploads/extra_notes/';
    if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
    
    $file = $_FILES['pdf_file'];
    $fileName = uniqid() . '_' . basename($file['name']);
    $filePath = $uploadDir . $fileName;
    
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        $fileSize = round(filesize($filePath) / 1024 / 1024, 1) . ' MB';
        $stmt = $pdo->prepare("INSERT INTO extra_notes (title, description, file_path, file_size, uploaded_by) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $_POST['title'],
            $_POST['description'],
            $filePath,
            $fileSize,
            $_SESSION['user_id']
        ]);
        header("Location: manageExtraNotes.php?msg=Note+uploaded+successfully!");
        exit();
    } else {
        $error = "Failed to upload file.";
    }
}

// GET all notes
$stmt = $pdo->query("SELECT * FROM extra_notes ORDER BY created_at DESC");
$notes = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Extra Notes - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/lecturer-sidebar.css">
    <link rel="stylesheet" href="css/darkmode.css">
    <link rel="stylesheet" href="css/mobile-responsive.css?v=<?= time() ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <style>
       
        
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

    /* === HEADER MENGIKUT PROJECT.PHP (dengan Back Button) === */
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

    /* --- MULA: Bahagian Header yang Diubah --- */
    /* Back Button */
    .nav-left {
        display: flex;
        align-items: center;
    }

.back-link {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 0px;
  text-decoration: none;
  color: #1a56db; /* Biru gelap */
  background: linear-gradient(135deg, #ffffff, #e6f7ff);
  padding: 10px 20px;
  border-radius: 50px;
  font-weight: 600;
  font-size: 1rem;
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
  transition: all 0.3s ease;
}

.back-link i {
  background: #1a56db;
  color: white;
  border-radius: 50%;
  padding: 6px;
  font-size: 0.9rem;
}

.back-link:hover {
  transform: translateY(-3px);
  background: linear-gradient(135deg, #ffeedf, #ffd9c2);
  color: #ff6b35;
}

.back-link:hover i {
  background: #ff6b35;
  color: white;
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

    /* Dark Mode for new components */
    .dark-mode .form-container,
    .dark-mode .notes-section {
        background: linear-gradient(135deg, #1e293b, #0f172a) !important;
        border-color: #334155 !important;
    }

    .dark-mode .form-container h2,
    .dark-mode .notes-section h2 {
        color: #93c5fd !important;
    }

    .dark-mode .form-container h2 i,
    .dark-mode .notes-section h2 i {
        color: #fb923c !important;
    }

    .dark-mode .note-card {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    .dark-mode .card-header,
    .dark-mode .card-footer {
        background: #0f172a !important;
        border-color: #334155 !important;
    }

    .dark-mode .card-header h3 {
        color: #f1f5f9 !important;
    }

    .dark-mode .card-header h3 i {
        color: #ef4444 !important;
    }

    .dark-mode .card-body p {
        color: #cbd5e1 !important;
    }

    .dark-mode .note-meta {
        background: #0f172a !important;
        color: #cbd5e1 !important;
        border-left-color: #93c5fd !important;
    }

    .dark-mode .note-meta i {
        color: #93c5fd !important;
    }

    .dark-mode .alert-success {
        background: linear-gradient(135deg, #1f2937, #374151) !important;
        color: #10b981 !important;
        border-left-color: #10b981 !important;
    }

    .dark-mode .alert-error {
        background: linear-gradient(135deg, #1f2937, #374151) !important;
        color: #ef4444 !important;
        border-left-color: #ef4444 !important;
    }

    .dark-mode .empty-state {
        color: #cbd5e1 !important;
    }

    .dark-mode .empty-state h3 {
        color: #f1f5f9 !important;
    }

    .dark-mode .empty-state i {
        color: #475569 !important;
    }

    .dark-mode .page-title {
        color: #93c5fd !important;
    }

    .dark-mode .page-subtitle {
        color: #cbd5e1 !important;
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

    /* Alert Messages */
    .alert {
        padding: 15px 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left-color: #28a745;
    }

    .alert-error {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left-color: #dc3545;
    }

    /* Form Styling */
    .form-container {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border-radius: 15px;
        padding: 35px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        margin-bottom: 40px;
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }

    .form-container h2 {
        color: var(--primary-color);
        font-size: 1.8rem;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .form-container h2 i {
        color: var(--secondary-color);
        font-size: 1.6rem;
    }

    .form-group {
        margin-bottom: 25px;
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
        background: linear-gradient(135deg, var(--primary-color), #1648b5);
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 16px;
        box-shadow: 0 4px 15px rgba(26, 86, 219, 0.2);
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(26, 86, 219, 0.3);
    }

    .btn-secondary {
        background: linear-gradient(135deg, var(--secondary-color), #e55a2b);
        box-shadow: 0 4px 15px rgba(255, 107, 53, 0.2);
    }

    .btn-secondary:hover {
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
    }

    .btn-outline {
        background: transparent;
        border: 2px solid var(--primary-color);
        color: var(--primary-color);
        box-shadow: none;
    }

    .btn-outline:hover {
        background: var(--primary-color);
        color: white;
    }

    /* Notes Section */
    .notes-section {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border-radius: 15px;
        padding: 35px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
        position: relative;
        overflow: hidden;
    }

    .notes-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #28a745, #20c997);
    }

    .notes-section h2 {
        color: #28a745;
        font-size: 1.8rem;
        margin-bottom: 30px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .notes-section h2 i {
        color: #20c997;
        font-size: 1.6rem;
    }

    /* Notes Grid */
    .notes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 25px;
        margin-top: 20px;
    }

    /* Individual Note Card */
    .note-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        border: 1px solid #e2e8f0;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
    }

    .note-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #dc3545, #e74c3c);
    }

    .note-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .card-header {
        padding: 20px 25px;
        background: linear-gradient(135deg, #f8f9fa, #ffffff);
        border-bottom: 1px solid #e9ecef;
    }

    .card-header h3 {
        color: var(--dark-color);
        font-size: 1.3rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .card-header h3 i {
        color: #dc3545;
        font-size: 1.2rem;
    }

    .card-body {
        padding: 20px 25px;
    }

    .card-body p {
        color: var(--dark-gray);
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 15px;
    }

    .note-meta {
        background: #f8f9fa;
        padding: 12px 15px;
        border-radius: 8px;
        border-left: 3px solid var(--primary-color);
        font-size: 0.85rem;
        color: var(--dark-gray);
    }

    .note-meta i {
        color: var(--primary-color);
        margin-right: 6px;
    }

    .card-footer {
        padding: 20px 25px;
        background: #f8f9fa;
        border-top: 1px solid #e9ecef;
        display: flex;
        gap: 12px;
    }

    .card-footer .btn {
        flex: 1;
        text-align: center;
        padding: 10px 16px;
        font-size: 0.9rem;
    }

    /* Empty State */
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

    .empty-state p {
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto;
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
    <button class="mobile-toggle" id="mobileToggle" style="display: none;">
        <i class="fas fa-bars"></i>
    </button>
    
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="lecturer-layout">
        <?= generateSidebar('manageExtraNotes.php') ?>
        
        <div class="main-content">
            <div class="content-header">
                <h1 class="page-title">Manage Extra Notes</h1>
                <div class="user-actions">
                    <button id="darkModeToggle" class="dark-mode-btn">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="user-avatar"><?= $initials ?></div>
                    <span><?= $fullName ?></span>
                </div>
            </div>

            <div class="content-body">
            <div class="page-header">
                <h1 class="page-title">Manage Extra Learning Notes</h1>
                <p class="page-subtitle">Upload or remove supplementary PDF materials.</p>
            </div>

            <!-- Paparkan mesej berjaya -->
            <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                <?= htmlspecialchars($_GET['msg']) ?>
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Upload Form -->
            <div class="form-container">
                <h2><i class="fas fa-cloud-upload-alt"></i> Upload New Note</h2>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><i class="fas fa-heading"></i> Title *</label>
                        <input type="text" name="title" required placeholder="Enter note title (e.g., Brake System Guide)">
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-align-left"></i> Description *</label>
                        <textarea name="description" required placeholder="Describe the content and purpose of this note..." rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-file-pdf"></i> PDF File *</label>
                        <input type="file" name="pdf_file" accept=".pdf" required>
                        <small style="color: var(--dark-gray); font-size: 0.85rem; margin-top: 5px; display: block;">
                            <i class="fas fa-info-circle"></i> Only PDF files are accepted. Maximum file size: 10MB
                        </small>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn">
                            <i class="fas fa-upload"></i> Upload Note
                        </button>
                    </div>
                </form>
            </div>

            <!-- Separator Line -->
            <div style="text-align: center; margin: 50px 0; position: relative;">
                <div style="height: 2px; background: linear-gradient(90deg, transparent, #e2e8f0, transparent); margin: 20px 0;"></div>
                <div style="display: inline-block; background: #f1f5f9; padding: 0 20px; color: var(--dark-gray); font-weight: 600;">
                    <i class="fas fa-folder-open"></i> EXISTING NOTES
                </div>
            </div>

            <!-- Notes List -->
            <div class="notes-section">
                <h2><i class="fas fa-library"></i> Notes Library</h2>
                <?php if (empty($notes)): ?>
                    <div class="empty-state">
                        <i class="fas fa-folder-open"></i>
                        <h3>No Notes Available</h3>
                        <p>There are currently no extra notes uploaded. Use the form above to add your first educational material.</p>
                    </div>
                <?php else: ?>
                    <div class="notes-grid">
                        <?php foreach ($notes as $note): ?>
                        <div class="note-card">
                            <div class="card-header">
                                <h3><i class="fas fa-file-pdf"></i> <?= htmlspecialchars($note['title']) ?></h3>
                            </div>
                            <div class="card-body">
                                <p><?= htmlspecialchars($note['description']) ?></p>
                                <div class="note-meta">
                                    <div><i class="fas fa-calendar-alt"></i> <?= date('M d, Y • g:i A', strtotime($note['created_at'])) ?></div>
                                    <div style="margin-top: 5px;"><i class="fas fa-hdd"></i> File Size: <?= $note['file_size'] ?></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="<?= $note['file_path'] ?>" class="btn btn-outline" target="_blank">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                <a href="?delete_id=<?= $note['id'] ?>" class="btn btn-secondary" onclick="return confirm('Are you sure you want to delete this note? This action cannot be undone.')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>

    <!-- Mobile menu script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.querySelector('.sidebar-overlay');
            
            if (mobileMenuBtn) {
                mobileMenuBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
            }
            
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
            
            // Dark mode toggle
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
        });

        // Enhanced form validation
        document.querySelector('form').addEventListener('submit', function(e) {
            const title = document.querySelector('input[name="title"]').value.trim();
            const description = document.querySelector('textarea[name="description"]').value.trim();
            const file = document.querySelector('input[name="pdf_file"]').files[0];
            
            if (!title || !description || !file) {
                e.preventDefault();
                alert('Please fill in all required fields.');
                return;
            }
            
            if (file && file.type !== 'application/pdf') {
                e.preventDefault();
                alert('Please select a valid PDF file.');
                return;
            }
            
            // Show upload progress
            const submitBtn = e.target.querySelector('button[type="submit"]');
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Uploading...';
            submitBtn.disabled = true;
        });

        // === Mobile optimizations ===
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile toggle functionality
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const sidebar = document.querySelector('.sidebar');
            
            // Show mobile toggle on small screens
            if (window.innerWidth <= 768) {
                mobileToggle.style.display = 'block';
                document.body.classList.add('mobile-view');
            }
            
            // Mobile menu toggle
            if (mobileToggle && sidebar) {
                mobileToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('mobile-open');
                    sidebarOverlay.classList.toggle('active');
                });
                
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    sidebarOverlay.classList.remove('active');
                });
            }
            
            // Touch-friendly file upload
            const fileInput = document.querySelector('input[type="file"]');
            if (fileInput && window.innerWidth <= 768) {
                const fileLabel = fileInput.previousElementSibling;
                if (fileLabel) {
                    fileLabel.style.cursor = 'pointer';
                    fileLabel.style.padding = '15px';
                    fileLabel.style.border = '2px dashed #1a56db';
                    fileLabel.style.borderRadius = '8px';
                    fileLabel.style.textAlign = 'center';
                    fileLabel.style.display = 'block';
                    fileLabel.style.margin = '10px 0';
                }
            }
            
            // Mobile form optimizations
            const formInputs = document.querySelectorAll('input, textarea');
            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    if (window.innerWidth <= 768) {
                        setTimeout(() => {
                            this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }, 300);
                    }
                });
            });
            
            // Add mobile table optimizations
            const noteCards = document.querySelectorAll('.note-card');
            noteCards.forEach(card => {
                if (window.innerWidth <= 768) {
                    card.classList.add('fade-in-mobile');
                }
            });
        });
    </script>
</body>
</html>