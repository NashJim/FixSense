<?php
session_start();

// Simple direct password reset form
$error = '';
$success = '';
$email = '';

// Get email from URL parameter if provided
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif ($newPassword !== $confirmPassword) {
        $error = 'Passwords do not match.';
    } elseif (strlen($newPassword) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } else {
        // DB connection - same pattern as admin.php
        $host = 'localhost';
        $db = 'u748339007_fixsense25_db';
        $user = 'u748339007_fixsense25_use';
        $pass = 'FixSense25';
        
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
            
            // Verify email exists in database first
            $checkStmt = $pdo->prepare("SELECT id, email FROM users WHERE email = ?");
            $checkStmt->execute([$email]);
            $userExists = $checkStmt->fetch();
            
            if (!$userExists) {
                $error = 'No account found with this email address: ' . $email;
            } else {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                
                // Debug: Show what we're trying to update
                $userId = $userExists['id'];
                
                // Update the password in database using ID for better reliability
                $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                $result = $stmt->execute([$hashedPassword, $userId]);
                
                if ($result && $stmt->rowCount() > 0) {
                    $success = 'Password updated successfully! You can now login with your new password.';
                } else {
                    // Additional debugging information
                    $error = 'Failed to update password. Details: ';
                    $error .= 'User ID: ' . $userId . ', ';
                    $error .= 'Email: ' . $email . ', ';
                    $error .= 'Query executed: ' . ($result ? 'Yes' : 'No') . ', ';
                    $error .= 'Rows affected: ' . $stmt->rowCount() . '. ';
                    $error .= 'This might happen if the user ID or email is incorrect.';
                }
            }
        } catch (PDOException $e) {
            error_log("Password update error: " . $e->getMessage());
            $error = 'Database connection failed. Please make sure you are accessing this from the live website (fixsense25.com). Error: ' . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - FixSense</title>
    <link rel="stylesheet" href="css/project.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .reset-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }
        
        .reset-header {
            margin-bottom: 30px;
        }
        
        .reset-header i {
            font-size: 50px;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .reset-header h2 {
            color: #333;
            margin: 0;
            font-size: 28px;
        }
        
        .reset-header p {
            color: #666;
            margin: 10px 0 0 0;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        
        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        .alert-error {
            background: #fee;
            color: #c33;
            border: 1px solid #fcc;
        }
        
        .alert-success {
            background: #efe;
            color: #363;
            border: 1px solid #cfc;
        }
        
        .back-link {
            margin-top: 20px;
        }
        
        .back-link a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }
        
        .back-link a:hover {
            text-decoration: underline;
        }
        
        .password-requirements {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 13px;
        }
        
        .password-requirements h4 {
            margin: 0 0 10px 0;
            color: #333;
            font-size: 14px;
        }
        
        .password-requirements ul {
            margin: 0;
            padding-left: 20px;
            color: #666;
        }
        
        .password-requirements li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="reset-container">
        <div class="reset-header">
            <i class="fas fa-key"></i>
            <h2>Reset Your Password</h2>
            <p>Enter your email and new password below</p>
        </div>
        
        <?php if ($error): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error); ?>
                <details style="margin-top: 10px; font-size: 12px;">
                    <summary>Debug Information</summary>
                    <p>Email submitted: <?php echo htmlspecialchars($email); ?></p>
                    <p>Form submitted: <?php echo $_SERVER['REQUEST_METHOD'] === 'POST' ? 'Yes' : 'No'; ?></p>
                    <p>Time: <?php echo date('Y-m-d H:i:s'); ?></p>
                </details>
            </div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (!$success): ?>
            <div class="password-requirements">
                <h4>Password Requirements:</h4>
                <ul>
                    <li>At least 8 characters long</li>
                    <li>Contains uppercase and lowercase letters</li>
                    <li>Contains at least one number</li>
                    <li>Contains at least one special character</li>
                </ul>
            </div>
            
            <form method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required 
                           value="<?php echo htmlspecialchars($email); ?>"
                           placeholder="Enter your email address">
                </div>
                
                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required 
                           minlength="8" placeholder="Enter your new password">
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required 
                           minlength="8" placeholder="Confirm your new password">
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-save"></i> Update Password
                </button>
            </form>
        <?php endif; ?>
        
        <div class="back-link">
            <a href="project.php">
                <i class="fas fa-arrow-left"></i> Back to Login
            </a>
        </div>
    </div>

    <script>
        // Password confirmation validation
        document.getElementById('confirm_password').addEventListener('input', function() {
            const password = document.getElementById('new_password').value;
            const confirmPassword = this.value;
            
            if (password !== confirmPassword) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
        
        // Password strength validation
        document.getElementById('new_password').addEventListener('input', function() {
            const password = this.value;
            const confirmPassword = document.getElementById('confirm_password');
            
            // Reset confirm password validation when main password changes
            if (confirmPassword.value) {
                if (password !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Passwords do not match');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }
        });
    </script>
</body>
</html>