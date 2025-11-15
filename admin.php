<?php
session_start();
$_SESSION['admin_mode'] = true;
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: project.php");
    exit();
}

// DB connection
$host = 'localhost';
$db = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

// Handle actions
$message = '';
$error = '';

// Delete user
if (isset($_POST['delete_user'])) {
    $userId = (int)$_POST['user_id'];
    if ($userId !== $_SESSION['user_id']) {
        try {
            $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$userId]);
            $message = 'User deleted successfully.';
        } catch (Exception $e) {
            $error = 'Failed to delete user.';
        }
    } else {
        $error = 'You cannot delete your own account.';
    }
}

// Add new user
if (isset($_POST['add_user'])) {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';

    // Validate
    if (empty($fullName) || empty($email) || empty($password) || !in_array($role, ['student', 'lecturer', 'admin'])) {
        $error = 'All fields are required. Role must be student, lecturer, or admin.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = 'Email already exists.';
        } else {
            // Hash password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            try {
                $pdo->prepare("
                    INSERT INTO users (full_name, email, password, role, created_at)
                    VALUES (?, ?, ?, ?, NOW())
                ")->execute([$fullName, $email, $hashedPassword, $role]);
                $message = 'New user added successfully.';
            } catch (Exception $e) {
                $error = 'Failed to add user. Please try again.';
            }
        }
    }
}

// Edit existing user
if (isset($_POST['edit_user'])) {
    $userId = (int)($_POST['user_id'] ?? 0);
    $fullName = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prevent editing self in a way that breaks access
    if ($userId === $_SESSION['user_id'] && $role !== 'admin') {
        $error = 'You cannot change your own role away from admin.';
    } elseif (empty($userId) || empty($fullName) || empty($email) || !in_array($role, ['student', 'lecturer', 'admin'])) {
        $error = 'Invalid input. All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Check email uniqueness (allow same email if it's the same user)
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $userId]);
        if ($stmt->fetch()) {
            $error = 'Email already used by another user.';
        } else {
            try {
                if (!empty($password)) {
                    // Update with new password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $pdo->prepare("
                        UPDATE users 
                        SET full_name = ?, email = ?, password = ?, role = ? 
                        WHERE id = ?
                    ")->execute([$fullName, $email, $hashedPassword, $role, $userId]);
                } else {
                    // Update without changing password
                    $pdo->prepare("
                        UPDATE users 
                        SET full_name = ?, email = ?, role = ? 
                        WHERE id = ?
                    ")->execute([$fullName, $email, $role, $userId]);
                }
                $message = 'User updated successfully.';
            } catch (Exception $e) {
                $error = 'Failed to update user. Please try again.';
            }
        }
    }
}

// Fetch data
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();
$performance = $pdo->query("
    SELECT p.*, u.full_name, u.email, sc.title AS scenario_title
    FROM performance p 
    JOIN users u ON p.student_id = u.id 
    LEFT JOIN scenarios sc ON p.scenario_id = sc.id
    ORDER BY p.completed_at DESC
")->fetchAll();
$questionResponses = $pdo->query("
    SELECT qr.*, u.full_name, sc.title AS scenario_title
    FROM question_responses qr
    JOIN users u ON qr.student_id = u.id
    LEFT JOIN scenarios sc ON qr.scenario_id = sc.id
    ORDER BY qr.answered_at DESC
    LIMIT 50
")->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* === INHERIT GLOBAL STYLES FROM project.php === */
        :root {
            --primary-color: #1a56db;
            --secondary-color: #ff6b35;
            --dark-color: #2d3748;
            --light-color: #f7fafc;
            --gray-color: #e2e8f0;
            --dark-gray: #718096;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #ffffff;
            color: var(--dark-color);
            line-height: 1.6;
            transition: background-color 0.3s, color 0.3s;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--secondary-color);
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 15px;
        }

        .btn:hover {
            background-color: #e55a2b;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background-color: var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: #1648b5;
        }

        .btn-outline {
            background: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background: var(--primary-color);
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        section {
            padding: 60px 0;
        }

        /* === HEADER (MATCH project.php) === */
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
            align-items: center;
        }

        /* === MAIN CONTENT === */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .page-title {
            font-size: 2.2rem;
            color: var(--primary-color);
            margin-bottom: 15px;
        }

        /* Tabs */
        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            border-bottom: 2px solid var(--gray-color);
        }

        .tab-btn {
            padding: 12px 24px;
            background: none;
            border: none;
            color: var(--dark-gray);
            font-weight: 600;
            cursor: pointer;
            border-bottom: 2px solid transparent;
        }

        .tab-btn.active {
            color: var(--primary-color);
            border-bottom: 2px solid var(--primary-color);
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Search Box */
        .search-box {
            margin-bottom: 20px;
            position: relative;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: 1px solid var(--gray-color);
            border-radius: 6px;
            font-size: 15px;
            transition: border-color 0.3s;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(26, 86, 219, 0.2);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
        }

        /* Tables */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-top: 20px;
        }

        .data-table th {
            background: #f8fafc;
            padding: 16px;
            text-align: left;
            font-weight: 600;
            color: var(--dark-color);
        }

        .data-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #edf2f7;
        }

        .role-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .role-student {
            background: #dbeafe;
            color: #1e40af;
        }

        .role-lecturer {
            background: #dcfce7;
            color: #166534;
        }

        .role-admin {
            background: #fde68a;
            color: #92400e;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        /* Stats */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
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
        }

        /* === MODALS (Add/Edit User) === */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 2000;
        }

        .modal {
            background: white;
            border-radius: 12px;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
            padding: 20px;
            text-align: center;
        }

        .modal-body {
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 15px;
        }

        .modal-footer {
            padding: 0 25px 25px;
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 22px;
            cursor: pointer;
            color: white;
        }

        /* No results message */
        .no-results {
            text-align: center;
            padding: 40px;
            color: var(--dark-gray);
            font-style: italic;
        }

        /* === DARK MODE === */
        body.dark-mode {
            --primary-color: #60a5fa;
            --secondary-color: #fb923c;
            --dark-color: #f1f5f9;
            --light-color: #0f172a;
            --gray-color: #1e293b;
            --dark-gray: #94a3b8;
            background-color: #0f172a !important;
            color: var(--dark-color) !important;
        }

        .dark-mode header,
        .dark-mode .data-table,
        .dark-mode .stat-card,
        .dark-mode .modal,
        .dark-mode .no-results {
            background-color: #1e293b !important;
            color: var(--dark-color) !important;
        }

        .dark-mode .data-table th {
            background: #334155 !important;
        }

        .dark-mode .data-table td,
        .dark-mode .form-group label {
            color: var(--dark-color) !important;
            border-color: #475569 !important;
        }

        .dark-mode .nav-links a {
            color: var(--dark-color) !important;
        }

        .dark-mode .nav-links a:hover {
            color: var(--secondary-color) !important;
        }

        .dark-mode .modal-header {
            background: #0f172a !important;
        }

        .dark-mode input,
        .dark-mode select {
            background: #334155 !important;
            color: var(--dark-color) !important;
            border-color: #475569 !important;
        }

        .dark-mode .close-btn {
            color: var(--dark-color) !important;
        }

        .dark-mode .search-box input {
            background: #334155 !important;
            color: var(--dark-color) !important;
            border-color: #475569 !important;
        }

        .dark-mode .search-box i {
            color: var(--dark-gray) !important;
        }
    </style>
</head>

<body>
    <!-- Header (consistent with project.php) -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="project.php" class="logo">
                    <i class="fas fa-tools"></i>FixSense
                </a>
                <ul class="nav-links">
                    <li><a href="project.php">Home</a></li>
                    <li><a href="admin.php">Admin Dashboard</a></li>
                </ul>
                <div class="auth-buttons">
                    <button id="darkModeToggle" class="btn" style="background: #333; padding: 8px 12px; font-size: 14px;">
                        <i class="fas fa-moon"></i>
                    </button>
                    <span id="greeting" style="color: white; background: #2c3e50; padding: 8px 16px; border-radius: 4px; font-weight: 600;">
                        Hello Admin, <?= htmlspecialchars($_SESSION['full_name']) ?>
                    </span>
                    <button class="btn" class="btn" style="background: #e74c3c;" onclick="adminLogout()">
                        Logout
                    </button>
                </div>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Admin Dashboard</h1>
                <p>Manage users, scenarios, and performance data</p>
            </div>

            <?php if ($message): ?>
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 25px; text-align: center;">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>
            <?php if ($error): ?>
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 25px; text-align: center;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Stats Summary -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?= count($users) ?></div>
                    <div class="stat-label">Total Users</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= count($performance) ?></div>
                    <div class="stat-label">Completed Scenarios</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?= count($questionResponses) ?></div>
                    <div class="stat-label">Question Responses</div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="tabs">
                <button class="tab-btn active" data-tab="users">Users</button>
                <button class="tab-btn" data-tab="performance">Performance</button>
                <button class="tab-btn" data-tab="responses">Question Responses</button>
            </div>

            <!-- Users Tab -->
            <div class="tab-content active" id="users-tab">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="users-search" placeholder="Search by name, email, or role...">
                    </div>
                    <button class="btn btn-secondary" onclick="openAddUserModal()">+ Add New User</button>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="users-table-body">
                        <?php foreach ($users as $user): ?>
                            <tr data-search="<?= strtolower($user['full_name'] . ' ' . $user['email'] . ' ' . $user['role']) ?>">
                                <td><?= $user['id'] ?></td>
                                <td><?= htmlspecialchars($user['full_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="role-badge role-<?= $user['role'] ?>">
                                        <?= ucfirst($user['role']) ?>
                                    </span>
                                </td>
                                <td><?= date('Y-m-d', strtotime($user['created_at'])) ?></td>
                                <td class="action-buttons">
                                    <button type="button" class="btn btn-outline"
                                        onclick='openEditUserModal(
                                        <?= json_encode($user["id"]) ?>,
                                        <?= json_encode(htmlspecialchars($user["full_name"])) ?>,
                                        <?= json_encode(htmlspecialchars($user["email"])) ?>,
                                        <?= json_encode($user["role"]) ?>
                                    )'>
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <?php if ($user['id'] !== $_SESSION['user_id']): ?>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                            <button type="submit" name="delete_user" class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="users-no-results" class="no-results" style="display: none;">
                    No users found matching your search.
                </div>
            </div>

            <!-- Performance Tab -->
            <div class="tab-content" id="performance-tab">
                <div class="search-box" style="margin-bottom: 20px;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="performance-search" placeholder="Search by student name, scenario, or status...">
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Scenario</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="performance-table-body">
                        <?php foreach ($performance as $p): ?>
                            <tr data-search="<?= strtolower($p['full_name'] . ' ' . ($p['scenario_title'] ?? 'ID: ' . $p['scenario_id']) . ' ' . $p['status']) ?>">
                                <td><?= htmlspecialchars($p['full_name']) ?></td>
                                <td><?= $p['scenario_title'] ?? 'ID: ' . htmlspecialchars($p['scenario_id']) ?></td>
                                <td><?= round($p['score'], 1) ?>%</td>
                                <td>
                                    <span class="role-badge <?= $p['status'] === 'passed' ? 'role-lecturer' : 'role-student' ?>">
                                        <?= ucfirst($p['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('Y-m-d H:i', strtotime($p['completed_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="performance-no-results" class="no-results" style="display: none;">
                    No performance records found matching your search.
                </div>
            </div>

            <!-- Question Responses Tab -->
            <div class="tab-content" id="responses-tab">
                <div class="search-box" style="margin-bottom: 20px;">
                    <i class="fas fa-search"></i>
                    <input type="text" id="responses-search" placeholder="Search by student name, scenario, or answer...">
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Scenario</th>
                            <th>Q#</th>
                            <th>Answer</th>
                            <th>Correct?</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody id="responses-table-body">
                        <?php foreach ($questionResponses as $qr): ?>
                            <tr data-search="<?= strtolower($qr['full_name'] . ' ' . ($qr['scenario_title'] ?? 'ID: ' . $qr['scenario_id']) . ' ' . $qr['selected_option']) ?>">
                                <td><?= htmlspecialchars($qr['full_name']) ?></td>
                                <td><?= $qr['scenario_title'] ?? 'ID: ' . $qr['scenario_id'] ?></td>
                                <td><?= $qr['question_id'] ?></td>
                                <td><?= htmlspecialchars($qr['selected_option']) ?></td>
                                <td>
                                    <?php if ($qr['is_correct']): ?>
                                        <span class="role-badge role-lecturer">✓ Yes</span>
                                    <?php else: ?>
                                        <span class="role-badge role-student">✗ No</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('Y-m-d H:i', strtotime($qr['answered_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div id="responses-no-results" class="no-results" style="display: none;">
                    No question responses found matching your search.
                </div>
            </div>
        </div>
    </main>

    <!-- Add User Modal -->
    <div class="modal-overlay" id="addUserModal">
        <div class="modal">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('addUserModal')">&times;</span>
                <h2>Add New User</h2>
            </div>
            <form method="POST" class="modal-body">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="student">Student</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('addUserModal')">Cancel</button>
                    <button type="submit" name="add_user" class="btn btn-secondary">Add User</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal-overlay" id="editUserModal">
        <div class="modal">
            <div class="modal-header">
                <span class="close-btn" onclick="closeModal('editUserModal')">&times;</span>
                <h2>Edit User</h2>
            </div>
            <form method="POST" class="modal-body">
                <input type="hidden" name="user_id" id="edit_user_id" required>
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" id="edit_full_name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" id="edit_email" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" id="edit_role" required>
                        <option value="student">Student</option>
                        <option value="lecturer">Lecturer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="edit_password" minlength="6">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editUserModal')">Cancel</button>
                    <button type="submit" name="edit_user" class="btn btn-secondary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Tab switching
        document.querySelectorAll('.tab-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
                document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
                button.classList.add('active');
                document.getElementById(button.dataset.tab + '-tab').classList.add('active');
            });
        });

        // Search functionality
        function setupSearch(searchInputId, tableBodyId, noResultsId) {
            const searchInput = document.getElementById(searchInputId);
            const tableBody = document.getElementById(tableBodyId);
            const noResults = document.getElementById(noResultsId);

            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();
                const rows = tableBody.querySelectorAll('tr');
                let visibleCount = 0;

                rows.forEach(row => {
                    const searchData = row.getAttribute('data-search');
                    if (searchData && searchData.includes(searchTerm)) {
                        row.style.display = '';
                        visibleCount++;
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Show/hide no results message
                if (visibleCount === 0 && searchTerm.length > 0) {
                    noResults.style.display = 'block';
                } else {
                    noResults.style.display = 'none';
                }
            });
        }

        // Initialize search for each tab
        setupSearch('users-search', 'users-table-body', 'users-no-results');
        setupSearch('performance-search', 'performance-table-body', 'performance-no-results');
        setupSearch('responses-search', 'responses-table-body', 'responses-no-results');

        // Modals
        function openAddUserModal() {
            document.getElementById('addUserModal').style.display = 'flex';
        }

        function openEditUserModal(id, name, email, role) {
            document.getElementById('edit_user_id').value = id;
            document.getElementById('edit_full_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;
            document.getElementById('edit_password').value = '';
            document.getElementById('editUserModal').style.display = 'flex';
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        // Dark mode
        (function() {
            const isDark = localStorage.getItem('darkMode') === 'true';
            if (isDark) {
                document.body.classList.add('dark-mode');
                document.getElementById('darkModeToggle').innerHTML = '<i class="fas fa-sun"></i>';
            }
        })();

        document.getElementById('darkModeToggle').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark);
            this.innerHTML = isDark ?
                '<i class="fas fa-sun"></i>' :
                '<i class="fas fa-moon"></i>';
        });

        // Close modals on outside click
        window.addEventListener('click', function(e) {
            ['addUserModal', 'editUserModal'].forEach(id => {
                const modal = document.getElementById(id);
                if (e.target === modal) closeModal(id);
            });
        });

        function adminLogout() {
            if (confirm('Are you sure you want to log out?')) {
                fetch('logout.php', {
                        method: 'POST'
                    })
                    .then(() => {
                        alert('You have been logged out from the Admin Dashboard.');
                        window.location.href = 'project.php';
                    })
                    .catch(() => {
                        alert('Logout failed. Please try again.');
                    });
            }
        }
    </script>
</body>

</html>