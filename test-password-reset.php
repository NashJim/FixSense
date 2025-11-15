<?php
// Simple test to verify password reset functionality
echo "<h2>Password Reset System Test</h2>";

// Test 1: Check if reset-password.php exists and is accessible
if (file_exists('reset-password.php')) {
    echo "✓ reset-password.php exists<br>";
} else {
    echo "✗ reset-password.php missing<br>";
}

// Test 2: Check if reset-password-form.php exists and is accessible
if (file_exists('reset-password-form.php')) {
    echo "✓ reset-password-form.php exists<br>";
} else {
    echo "✗ reset-password-form.php missing<br>";
}

// Test 3: Check if project.php has been updated
$projectContent = file_get_contents('project.php');
if (strpos($projectContent, 'data.reset_url') !== false) {
    echo "✓ project.php updated for reset URL handling<br>";
} else {
    echo "✗ project.php needs reset URL handling<br>";
}

echo "<br><h3>How to test the password reset:</h3>";
echo "<ol>";
echo "<li>Go to your website (fixsense25.com)</li>";
echo "<li>Click 'Forgot Password' on the login form</li>";
echo "<li>Enter an existing user's email address</li>";
echo "<li>You should be redirected to the password reset form</li>";
echo "<li>Enter a new password and confirm it</li>";
echo "<li>The password should be updated in the database</li>";
echo "</ol>";

echo "<p><strong>Note:</strong> This system uses session-based tokens instead of database tokens, so it works without needing to modify your database structure.</p>";
?>
