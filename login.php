<?php
session_start();

// Only set JSON and CORS headers for POST requests (API calls)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Accept");
} else {
    // For GET requests, redirect to the main application
    header("Location: project.php");
    exit();
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
    http_response_code(500);
    echo json_encode(['message' => 'Database connection failed']);
    exit;
}

$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

// Handle both JSON and form POST data
if ($input && is_array($input)) {
    // JSON input
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';
} else {
    // Form POST input
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
}

if (!$email || !$password) {
    http_response_code(400);
    echo json_encode(['message' => 'Email and password required']);
    exit;
}

$stmt = $pdo->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password'])) {
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
        'redirect' => $redirect
    ]);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid email or password']);
}
