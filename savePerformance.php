<?php
session_start();
header('Content-Type: application/json');

// Only logged-in students can submit
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
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
    echo json_encode(['error' => 'Database connection failed']);
    exit();
}

// Get data from POST
$input = json_decode(file_get_contents('php://input'), true);
$scenario_id = (float)($input['scenario_id'] ?? 0);
$score = (int)($input['score'] ?? 0);

if ($scenario_id <= 0 || $score < 0 || $score > 100) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit();
}

$status = ($score >= 70) ? 'passed' : 'failed'; // Adjust passing threshold as needed

try {
    $stmt = $pdo->prepare("
        INSERT INTO performance (student_id, scenario_id, score, status)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$_SESSION['user_id'], $scenario_id, $score, $status]);

    echo json_encode([
        'success' => true,
        'message' => 'Performance saved successfully',
        'status' => $status
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save performance']);
}
?>