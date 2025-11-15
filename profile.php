<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// DB config
$host = 'localhost';
$db   = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$pdo = new PDO($dsn, $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Fetch current user
$stmt = $pdo->prepare("SELECT id, full_name, email, avatar, role FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$currentUser = $stmt->fetch();

if (!$currentUser) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Get user initials for avatar
$fullName = htmlspecialchars($currentUser['full_name']);
$initials = strtoupper(substr($currentUser['full_name'], 0, 1));

// Initialize messages
$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'update_profile') {
        $fullName = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (!$fullName || !$email) {
            $error = 'Full name and email are required.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Invalid email format.';
        } else {
            // Check if email is already taken by another user
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $currentUser['id']]);
            if ($stmt->fetch()) {
                $error = 'This email is already in use.';
            } else {
                $stmt = $pdo->prepare("UPDATE users SET full_name = ?, email = ? WHERE id = ?");
                $stmt->execute([$fullName, $email, $currentUser['id']]);
                // Update session
                $_SESSION['full_name'] = $fullName;
                $_SESSION['email'] = $email;
                $currentUser['full_name'] = $fullName;
                $currentUser['email'] = $email;
                $message = 'Profile updated successfully!';
            }
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'upload_avatar') {
        if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
            $error = 'Failed to upload file.';
        } else {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $fileType = $_FILES['avatar']['type'];
            $fileName = $_FILES['avatar']['name'];
            $tmpName = $_FILES['avatar']['tmp_name'];

            if (!in_array($fileType, $allowedTypes)) {
                $error = 'Only JPG, PNG, and GIF files are allowed.';
            } else {
                // Generate unique filename
                $extension = pathinfo($fileName, PATHINFO_EXTENSION);
                $newFileName = 'user_' . $currentUser['id'] . '_' . time() . '.' . $extension;
                $uploadPath = 'uploads/' . $newFileName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    // Delete old avatar if not default
                    if ($currentUser['avatar'] !== 'default.png') {
                        $oldAvatarPath = 'uploads/' . $currentUser['avatar'];
                        if (file_exists($oldAvatarPath) && is_file($oldAvatarPath)) {
                            unlink($oldAvatarPath);
                        }
                    }

                    // Update database
                    $stmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
                    $stmt->execute([$newFileName, $currentUser['id']]);
                    $currentUser['avatar'] = $newFileName;
                    $message = 'Profile picture updated successfully!';
                } else {
                    $error = 'Failed to save uploaded file.';
                }
            }
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'remove_avatar') {
        if ($currentUser['avatar'] !== 'default.png') {
            $oldAvatarPath = 'uploads/' . $currentUser['avatar'];
            if (file_exists($oldAvatarPath) && is_file($oldAvatarPath)) { // Check if it's a file
                unlink($oldAvatarPath);
            }
            $stmt = $pdo->prepare("UPDATE users SET avatar = 'default.png' WHERE id = ?");
            $stmt->execute([$currentUser['id']]);
            $currentUser['avatar'] = 'default.png';
            $message = 'Avatar removed successfully.';
        }
    }

    if (isset($_POST['action']) && $_POST['action'] === 'change_password') {
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        if (!$currentPassword || !$newPassword || !$confirmPassword) {
            $error = 'All password fields are required.';
        } elseif ($newPassword !== $confirmPassword) {
            $error = 'New passwords do not match.';
        } elseif (strlen($newPassword) < 6) {
            $error = 'Password must be at least 6 characters.';
        } else {
            // Verify current password
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
            $stmt->execute([$currentUser['id']]);
            $hashedPassword = $stmt->fetchColumn();

            if (!password_verify($currentPassword, $hashedPassword)) {
                $error = 'Current password is incorrect.';
            } else {
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $stmt->execute([$newHashedPassword, $currentUser['id']]);
                $message = 'Password changed successfully!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">>
    <style>
        /* Gunakan warna dari project.html */
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

        /* === DARK MODE STYLES FOR PROFILE.PHP === */
        body.dark-mode {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }

        /* Header */
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

        /* Main Content */
        .dark-mode main {
            background-color: #0f172a !important;
        }

        .dark-mode .page-header h1,
        .dark-mode .page-header p,
        .dark-mode .form-title {
            color: #93c5fd !important;
        }

        .dark-mode .profile-section,
        .dark-mode .profile-form {
            background-color: #1e293b !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
        }

        .dark-mode .profile-name,
        .dark-mode .profile-email,
        .dark-mode .profile-role,
        .dark-mode .profile-institution,
        .dark-mode .form-group label {
            color: #f1f5f9 !important;
        }

        .dark-mode .profile-role {
            color: #60a5fa !important;
        }

        .dark-mode input:disabled,
        .dark-mode select:disabled {
            background-color: #334155 !important;
            color: #cbd5e1 !important;
        }

        .dark-mode input:not(:disabled),
        .dark-mode select:not(:disabled) {
            background-color: #334155 !important;
            color: #f1f5f9 !important;
            border-color: #475569 !important;
        }

        .dark-mode .btn {
            background-color: #fb923c !important;
            color: #0f172a !important;
        }

        .dark-mode .btn:hover {
            background-color: #f97316 !important;
        }

        .dark-mode .btn-secondary {
            background-color: #60a5fa !important;
            color: #0f172a !important;
        }

        .dark-mode .btn-secondary:hover {
            background-color: #93c5fd !important;
        }

        .dark-mode .btn-outline {
            border-color: #60a5fa !important;
            color: #93c5fd !important;
        }

        .dark-mode .btn-outline:hover {
            background-color: rgba(96, 165, 250, 0.1) !important;
        }

        /* Footer */
        .dark-mode footer {
            background-color: #0f172a !important;
        }

        .dark-mode .footer-column h3 {
            color: #f1f5f9 !important;
        }

        .dark-mode .footer-column h3::after {
            background-color: #fb923c !important;
        }

        .dark-mode .footer-column ul li a,
        .dark-mode .footer-bottom,
        .dark-mode .social-links a {
            color: #cbd5e1 !important;
        }

        .dark-mode .footer-column ul li a:hover {
            color: white !important;
        }

        .dark-mode .social-links a:hover {
            background-color: #fb923c !important;
        }

        /* Avatar Upload */
        .dark-mode .current-avatar-preview {
            background: #334155 !important;
        }

        .dark-mode .profile-avatar-upload input[type="file"] {
            background: #334155 !important;
            color: #f1f5f9 !important;
            border-color: #475569 !important;
        }

        /* Smooth transition */
        body {
            transition: background-color 0.3s, color 0.3s;
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

        /* Header Styles - Sama macam project.html */
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

        /* Profile Section */
        /* === CENTERED PROFILE SECTION === */
        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 10px;
            padding: 40px 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 40px;
            text-align: center;
            max-width: 600px;
            /* Optional: limit width for large screens */
            margin: 40px auto;
            /* Center on page */
        }

        .profile-avatar-container {
            margin-bottom: 20px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
            margin: 0 auto;
            /* Center avatar within container */
        }

        .current-avatar-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .profile-avatar-upload input[type="file"] {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .profile-avatar-upload button {
            font-size: 0.9rem;
            padding: 8px 16px;
        }

        .profile-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 10px;
        }

        .profile-email,
        .profile-role,
        .profile-institution {
            color: var(--dark-gray);
            margin-bottom: 5px;
            font-size: 0.95rem;
        }

        .profile-role {
            font-weight: 500;
            color: var(--primary-color);
        }

        /* Profile Form */
        .profile-form {
            background: white;
            border-radius: 10px;
            padding: 40px 30px;
            box-shadow: var(--card-shadow);
            margin-bottom: 40px;
        }

        .form-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 25px;
            text-align: center;
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
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--gray-color);
            border-radius: 4px;
            font-size: 1rem;
            background-color: #f8fafc;
            /* Latar belakang input disabled */
        }

        /* Input disabled */
        .form-group input:disabled,
        .form-group select:disabled {
            background-color: #f1f5f9;
            color: var(--dark-gray);
            cursor: not-allowed;
        }

        .form-actions {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

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

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: rgba(26, 86, 219, 0.1);
        }

        /* Footer - Sama macam project.html */
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

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="project.php" class="logo">
                    <i class="fas fa-tools"></i>
                    FixSense
                </a>
                <ul class="nav-links">
                    <li><a href="project.php">Home</a></li>
                    <li><a href="about_us.php">About</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <?php if ($_SESSION['role'] === 'lecturer'): ?>
                            <li><a href="lecturer.php">Dashboard</a></li>
                        <?php else: ?>
                            <li><a href="studentDashboard.php">Performance</a></li>
                        <?php endif; ?>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
                <div class="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">User Profile</h1>
                <p class="page-subtitle">Manage your account information and settings</p>
            </div>
            <?php if ($message): ?>
                <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div style="background: #fee2e2; color: #b91c1c; padding: 10px; border-radius: 6px; margin-bottom: 20px; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <div class="profile-section">
                <div class="profile-avatar-container">
                    <div class="profile-avatar">
                        <?php if ($currentUser['avatar'] !== 'default.png'): ?>
                            <img src="uploads/<?= htmlspecialchars($currentUser['avatar']) ?>"
                                alt="User Avatar"
                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                        <?php else: ?>
                            <?= strtoupper(substr($currentUser['full_name'], 0, 1)) ?>
                        <?php endif; ?>
                    </div>
                </div>
                <h2 class="profile-name"><?= htmlspecialchars($currentUser['full_name']) ?></h2>
                <p class="profile-email"><?= htmlspecialchars($currentUser['email']) ?></p>
                <p class="profile-role"><?= ucfirst($currentUser['role']) ?></p>
                <p class="profile-institution">Institute Latihan Perindustrian (ILP) Kuantan</p>
            </div>

            <!-- Profile Picture Upload -->
            <div class="profile-avatar-upload" style="margin-top: 20px; text-align: center;">
                <h3>Profile Picture</h3>
                <form id="avatarUploadForm" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="upload_avatar">
                    <div style="display: flex; justify-content: center; align-items: center; gap: 20px; margin-bottom: 15px;">
                        <div class="current-avatar-preview" style="position: relative; width: 120px; height: 120px; border-radius: 50%; overflow: hidden; background: #f1f5f9;">
                            <img src="uploads/<?= htmlspecialchars($currentUser['avatar']) ?>"
                                alt="Current Avatar"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <div>
                            <input type="file" name="avatar" accept="image/*" style="margin-bottom: 10px;" required>
                            <button type="submit" class="btn" style="padding: 8px 16px; font-size: 0.9rem;">Upload New Photo</button>
                        </div>
                    </div>
                </form>
                <?php if ($currentUser['avatar'] !== 'default.png'): ?>
                    <form method="POST" style="text-align: center; margin-top: 10px;">
                        <input type="hidden" name="action" value="remove_avatar">
                        <button type="submit" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.85rem;">Remove Avatar</button>
                    </form>
                <?php endif; ?>
            </div>

            <!-- Profile Edit Form -->
            <div class="profile-form">
                <h2 class="form-title">Edit Profile Information</h2>
                <form id="profileUpdateForm" method="POST">
                    <input type="hidden" name="action" value="update_profile">
                    <div class="form-group">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="full_name" value="<?= htmlspecialchars($currentUser['full_name']) ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($currentUser['email']) ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="institution">Institution</label>
                        <input type="text" id="institution" value="Institute Latihan Perindustrian (ILP) Kuantan" disabled>
                    </div>

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select id="role" disabled>
                            <option value="student" <?= $currentUser['role'] === 'student' ? 'selected' : '' ?>>Student</option>
                            <option value="lecturer" <?= $currentUser['role'] === 'lecturer' ? 'selected' : '' ?>>Lecturer</option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" id="editProfileBtn">Edit Profile</button>
                        <button type="submit" class="btn" style="display: none;" id="saveProfileBtn">Save Changes</button>
                        <button type="button" class="btn btn-secondary" style="display: none;" id="cancelEditBtn">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- Change Password Section (Disabled for demo) -->
            <div class="profile-form">
                <h2 class="form-title">Change Password</h2>
                <form id="changePasswordForm" method="POST">
                    <input type="hidden" name="action" value="change_password">
                    <div class="form-group">
                        <label for="currentPassword">Current Password</label>
                        <input type="password" id="currentPassword" name="current_password" placeholder="Enter current password" disabled>
                    </div>

                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" name="new_password" placeholder="Enter new password" disabled>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="Confirm new password" disabled>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn btn-outline" id="editPasswordBtn">Change Password</button>
                        <button type="submit" class="btn" style="display: none;" id="savePasswordBtn">Save Password</button>
                        <button type="button" class="btn btn-secondary" style="display: none;" id="cancelPasswordBtn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FixSense</h3>
                    <p>Advanced automotive troubleshooting education platform for Institute Latihan Perindustrian (ILP) Kuantan.</p>
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
                        <li><a href="about_us.php">About Us</a></li>
                        <li><a href="#features">Features</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">Community</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>
                <div class="footer-column">
                    <h3>Contact Info</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> info@fixsense.edu</li>
                        <li><i class="fas fa-phone"></i> +60 9-XXX XXXX</li>
                        <li><i class="fas fa-map-marker-alt"></i> ILP Kuantan, Pahang</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 FixSense. All rights reserved. | Developed for ILP Kuantan</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile navigation toggle
            const mobileToggle = document.querySelector('.mobile-toggle');
            const navLinks = document.querySelector('.nav-links');
            
            mobileToggle?.addEventListener('click', () => {
                navLinks.classList.toggle('active');
            });
            
            // Profile edit functionality
            const editProfileBtn = document.getElementById('editProfileBtn');
            const saveProfileBtn = document.getElementById('saveProfileBtn');
            const cancelProfileBtn = document.getElementById('cancelEditBtn');
            const profileInputs = [
                document.getElementById('fullName'),
                document.getElementById('email')
            ];

            editProfileBtn?.addEventListener('click', () => {
                profileInputs.forEach(input => {
                    input.disabled = false;
                    input.style.backgroundColor = '#ffffff';
                });
                saveProfileBtn.style.display = 'inline-block';
                cancelProfileBtn.style.display = 'inline-block';
                editProfileBtn.style.display = 'none';
            });

            cancelProfileBtn?.addEventListener('click', () => {
                profileInputs[0].value = '<?= addslashes($currentUser['full_name']) ?>';
                profileInputs[1].value = '<?= addslashes($currentUser['email']) ?>';
                profileInputs.forEach(input => {
                    input.disabled = true;
                    input.style.backgroundColor = '#f1f5f9';
                });
                saveProfileBtn.style.display = 'none';
                cancelProfileBtn.style.display = 'none';
                editProfileBtn.style.display = 'inline-block';
            });

            // Password edit functionality
            const editPasswordBtn = document.getElementById('editPasswordBtn');
            const savePasswordBtn = document.getElementById('savePasswordBtn');
            const cancelPasswordBtn = document.getElementById('cancelPasswordBtn');
            const passwordInputs = [
                document.getElementById('currentPassword'),
                document.getElementById('newPassword'),
                document.getElementById('confirmPassword')
            ];

            editPasswordBtn?.addEventListener('click', () => {
                passwordInputs.forEach(input => {
                    input.disabled = false;
                    input.style.backgroundColor = '#ffffff';
                });
                savePasswordBtn.style.display = 'inline-block';
                cancelPasswordBtn.style.display = 'inline-block';
                editPasswordBtn.style.display = 'none';
            });

            cancelPasswordBtn?.addEventListener('click', () => {
                passwordInputs.forEach(input => {
                    input.value = '';
                    input.disabled = true;
                    input.style.backgroundColor = '#f1f5f9';
                });
                savePasswordBtn.style.display = 'none';
                cancelPasswordBtn.style.display = 'none';
                editPasswordBtn.style.display = 'inline-block';
            });
        });
    </script>
</body>
</html>