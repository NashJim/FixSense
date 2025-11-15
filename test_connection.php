<?php
// Simple database connection test
$host = 'localhost';
$db   = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';
$charset = 'utf8mb4';

echo "<h2>Database Connection Test</h2>";

try {
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Test if users table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Users table exists!</p>";
        
        // Count users
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $count = $stmt->fetch()['count'];
        echo "<p style='color: green;'>✓ Users table has $count users!</p>";
        
        // Show first few users (email only for security)
        $stmt = $pdo->query("SELECT email, role FROM users LIMIT 3");
        $users = $stmt->fetchAll();
        echo "<p><strong>Sample users:</strong></p>";
        echo "<ul>";
        foreach ($users as $user) {
            echo "<li>Email: {$user['email']}, Role: {$user['role']}</li>";
        }
        echo "</ul>";
        
    } else {
        echo "<p style='color: red;'>✗ Users table does not exist!</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed!</p>";
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

// Test PHP version and extensions
echo "<h3>PHP Environment</h3>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>PDO Available: " . (extension_loaded('pdo') ? 'Yes' : 'No') . "</p>";
echo "<p>PDO MySQL Available: " . (extension_loaded('pdo_mysql') ? 'Yes' : 'No') . "</p>";
echo "<p>Session Support: " . (function_exists('session_start') ? 'Yes' : 'No') . "</p>";
?>