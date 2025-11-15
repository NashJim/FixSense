<?php
// DIAGNOSTIC - Password Reset Debug
echo "<h1>Password Reset Diagnostic</h1>";
echo "<p>Time: " . date('Y-m-d H:i:s') . "</p>";

// Test database connection first
echo "<h2>1. Testing Database Connection...</h2>";
$host = 'localhost';
$db = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    echo "✅ Database connection successful<br>";
    
    // Test user lookup
    echo "<h2>2. Testing User Lookup...</h2>";
    $stmt = $pdo->prepare("SELECT COUNT(*) as user_count FROM users");
    $stmt->execute();
    $result = $stmt->fetch();
    echo "✅ Found " . $result['user_count'] . " users in database<br>";
    
    // Test a sample user
    $stmt = $pdo->prepare("SELECT id, email FROM users LIMIT 1");
    $stmt->execute();
    $sampleUser = $stmt->fetch();
    if ($sampleUser) {
        echo "✅ Sample user: ID=" . $sampleUser['id'] . ", Email=" . $sampleUser['email'] . "<br>";
        
        // Test password update
        echo "<h2>3. Testing Password Update...</h2>";
        $testPassword = 'TestPassword123!';
        $hashedPassword = password_hash($testPassword, PASSWORD_DEFAULT);
        
        echo "Original password hash length: " . strlen($hashedPassword) . "<br>";
        
        // Try to update (we'll rollback)
        $pdo->beginTransaction();
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $result = $updateStmt->execute([$hashedPassword, $sampleUser['id']]);
        $rowsAffected = $updateStmt->rowCount();
        
        echo "Update result: " . ($result ? 'Success' : 'Failed') . "<br>";
        echo "Rows affected: " . $rowsAffected . "<br>";
        
        if ($rowsAffected > 0) {
            echo "✅ Password update test successful<br>";
        } else {
            echo "❌ Password update failed - no rows affected<br>";
        }
        
        // Rollback the test
        $pdo->rollback();
        echo "✅ Test changes rolled back<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Database error: " . $e->getMessage() . "<br>";
    echo "Error code: " . $e->getCode() . "<br>";
}

echo "<hr>";
echo "<h2>4. File Check</h2>";
echo "This diagnostic file exists: ✅<br>";
echo "Current file: " . __FILE__ . "<br>";
echo "PHP Version: " . phpversion() . "<br>";

echo "<hr>";
echo "<h2>5. Instructions</h2>";
echo "<p><strong>If you see this page, it means:</strong></p>";
echo "<ul>";
echo "<li>Your server is running PHP correctly</li>";
echo "<li>You can upload and execute PHP files</li>";
echo "<li>The issue is likely with the specific password reset file</li>";
echo "</ul>";

echo "<p><strong>Next steps:</strong></p>";
echo "<ol>";
echo "<li>Make sure you've uploaded the updated reset-password-form.php to your live server</li>";
echo "<li>Clear your browser cache completely</li>";
echo "<li>Try accessing reset-password-form.php again</li>";
echo "</ol>";
?>