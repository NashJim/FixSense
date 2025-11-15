<?php
// MINIMAL PASSWORD RESET - No fancy features, just works
$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Basic validation
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $message = 'All fields are required.';
    } elseif ($newPassword !== $confirmPassword) {
        $message = 'Passwords do not match.';
    } elseif (strlen($newPassword) < 8) {
        $message = 'Password must be at least 8 characters.';
    } else {
        // Database connection
        try {
            $pdo = new PDO(
                "mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 
                'u748339007_fixsense25_use', 
                'FixSense25'
            );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Find user
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if (!$user) {
                $message = 'No user found with email: ' . htmlspecialchars($email);
            } else {
                // Update password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                
                if ($updateStmt->execute([$hashedPassword, $user['id']])) {
                    if ($updateStmt->rowCount() > 0) {
                        $message = 'SUCCESS! Password updated. You can now login.';
                        $success = true;
                    } else {
                        $message = 'Error: No rows updated. User ID: ' . $user['id'];
                    }
                } else {
                    $message = 'Error: Failed to execute update query.';
                }
            }
        } catch (Exception $e) {
            $message = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Minimal Password Reset</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
        .container { background: #f9f9f9; padding: 30px; border-radius: 10px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #007bff; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .message { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .back-link { text-align: center; margin-top: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        
        <?php if ($message): ?>
            <div class="message <?php echo $success ? 'success' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required minlength="8">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </div>
                
                <button type="submit">Update Password</button>
            </form>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="project.php">Back to Login</a>
        </div>
    </div>
</body>
</html>