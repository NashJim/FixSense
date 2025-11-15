<?php
session_start();
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Accept");

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

// Database config
$host = 'localhost';
$db   = 'u748339007_fixsense25_db';
$user = 'u748339007_fixsense25_use';
$pass = 'FixSense25';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(['message' => 'Database connection failed: ' . $e->getMessage()]);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Debug: Log the input
error_log("Login input: " . json_encode($input));

$email = $input['email'] ?? '';
$password = $input['password'] ?? '';

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Email and password required. Received email: ' . $email . ', password: ' . (!empty($password) ? '[provided]' : '[empty]')]);
    exit;
}

// Debug: Check if user exists
$stmt = $pdo->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user) {
    // User not found - let's see what users we have
    $stmt = $pdo->query("SELECT email FROM users");
    $allUsers = $stmt->fetchAll();
    $userList = array_column($allUsers, 'email');
    
    http_response_code(401);
    echo json_encode([
        'message' => 'User not found with email: ' . $email,
        'available_users' => $userList
    ]);
    exit;
}

// Debug: Check password verification
$passwordVerified = password_verify($password, $user['password']);
error_log("Password verification for {$email}: " . ($passwordVerified ? 'SUCCESS' : 'FAILED'));
error_log("Stored hash: " . $user['password']);

if ($user && $passwordVerified) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['full_name'] = $user['full_name'];
    $_SESSION['email'] = $user['email'];
    $_SESSION['role'] = $user['role'];

    // Redirect based on role
    $redirect = 'project.php'; // student
    if ($user['role'] === 'lecturer') {
        $redirect = 'lecturer.php';
    } elseif ($user['role'] === 'admin') {
        $redirect = 'admin.php';
    }

    echo json_encode([
        'success' => true,
        'redirect' => $redirect,
        'user' => [
            'id' => $user['id'],
            'name' => $user['full_name'],
            'email' => $user['email'],
            'role' => $user['role']
        ]
    ]);
} else {
    http_response_code(401);
    echo json_encode([
        'message' => 'Invalid email or password',
        'debug' => [
            'user_found' => !empty($user),
            'password_verified' => $passwordVerified ?? false,
            'email_attempted' => $email
        ]
    ]);
}
?>