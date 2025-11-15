<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept");

// If this is a GET request, serve the password reset form directly
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Serve the password reset form HTML directly
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password - FixSense</title>
        <style>
            body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center; }
            .container { background: white; padding: 40px; border-radius: 15px; box-shadow: 0 15px 35px rgba(0,0,0,0.1); max-width: 400px; width: 90%; }
            .header { text-align: center; margin-bottom: 30px; }
            .header i { font-size: 50px; color: #667eea; margin-bottom: 20px; }
            .header h2 { color: #333; margin: 0; }
            .form-group { margin-bottom: 20px; }
            .form-group label { display: block; margin-bottom: 8px; color: #333; font-weight: 500; }
            .form-group input { width: 100%; padding: 12px; border: 2px solid #e1e1e1; border-radius: 8px; font-size: 16px; box-sizing: border-box; }
            .btn { width: 100%; padding: 12px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 600; cursor: pointer; }
            .alert { padding: 12px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
            .alert-error { background: #fee; color: #c33; border: 1px solid #fcc; }
            .alert-success { background: #efe; color: #363; border: 1px solid #cfc; }
            .back-link { text-align: center; margin-top: 20px; }
            .back-link a { color: #667eea; text-decoration: none; }
        </style>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    </head>
    <body>
        <div class="container">
            <div class="header">
                <i class="fas fa-key"></i>
                <h2>Reset Your Password</h2>
                <p>Enter your email and new password</p>
            </div>
            
            <div id="message"></div>
            
            <form id="resetForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email address">
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required minlength="8" placeholder="Enter your new password">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8" placeholder="Confirm your new password">
                </div>
                
                <button type="submit" class="btn" id="submitBtn">
                    <i class="fas fa-save"></i> Update Password
                </button>
            </form>
            
            <div class="back-link">
                <a href="project.php"><i class="fas fa-arrow-left"></i> Back to Login</a>
            </div>
        </div>

        <script>
            document.getElementById('resetForm').addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const email = document.getElementById('email').value;
                const newPassword = document.getElementById('new_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                const messageDiv = document.getElementById('message');
                const submitBtn = document.getElementById('submitBtn');
                
                // Clear previous messages
                messageDiv.innerHTML = '';
                
                // Validation
                if (!email || !newPassword || !confirmPassword) {
                    messageDiv.innerHTML = '<div class="alert alert-error">Please fill in all fields.</div>';
                    return;
                }
                
                if (newPassword !== confirmPassword) {
                    messageDiv.innerHTML = '<div class="alert alert-error">Passwords do not match.</div>';
                    return;
                }
                
                if (newPassword.length < 8) {
                    messageDiv.innerHTML = '<div class="alert alert-error">Password must be at least 8 characters long.</div>';
                    return;
                }
                
                // Show loading
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
                
                try {
                    const response = await fetch('reset-password.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email, new_password: newPassword, confirm_password: confirmPassword })
                    });
                    
                    const data = await response.json();
                    
                    if (response.ok && data.success) {
                        messageDiv.innerHTML = '<div class="alert alert-success"><i class="fas fa-check-circle"></i> ' + data.message + '</div>';
                        document.getElementById('resetForm').style.display = 'none';
                    } else {
                        messageDiv.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-triangle"></i> ' + (data.message || 'An error occurred') + '</div>';
                    }
                } catch (error) {
                    messageDiv.innerHTML = '<div class="alert alert-error"><i class="fas fa-exclamation-triangle"></i> Network error: ' + error.message + '</div>';
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-save"></i> Update Password';
                }
            });
        </script>
    </body>
    </html>
    <?php
    exit();
}

// Handle POST request for password update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rawInput = file_get_contents('php://input');
    $input = json_decode($rawInput, true);
    
    $email = $input['email'] ?? '';
    $newPassword = $input['new_password'] ?? '';
    $confirmPassword = $input['confirm_password'] ?? '';
    
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        http_response_code(400);
        echo json_encode(['message' => 'All fields are required']);
        exit;
    }
    
    if ($newPassword !== $confirmPassword) {
        http_response_code(400);
        echo json_encode(['message' => 'Passwords do not match']);
        exit;
    }
    
    if (strlen($newPassword) < 8) {
        http_response_code(400);
        echo json_encode(['message' => 'Password must be at least 8 characters long']);
        exit;
    }
    
    // Database connection - same as admin.php
    $host = 'localhost';
    $db = 'u748339007_fixsense25_db';
    $user = 'u748339007_fixsense25_use';
    $pass = 'FixSense25';
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
        
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            http_response_code(404);
            echo json_encode(['message' => 'No account found with email: ' . $email]);
            exit;
        }
        
        // Update password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $result = $updateStmt->execute([$hashedPassword, $user['id']]);
        
        if ($result && $updateStmt->rowCount() > 0) {
            echo json_encode([
                'success' => true,
                'message' => 'Password updated successfully! You can now login with your new password.'
            ]);
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Failed to update password. User ID: ' . $user['id'] . ', Rows affected: ' . $updateStmt->rowCount()]);
        }
        
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['message' => 'Method not allowed']);
}
?>
?>
