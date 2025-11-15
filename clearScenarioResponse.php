<?php
session_start();
header('Content-Type: application/json');

// Only logged-in students can clear responses
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$scenarioId = (int)($input['scenario_id'] ?? 0);

if ($scenarioId <= 0) {
    echo json_encode(['error' => 'Invalid scenario ID']);
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Delete all responses for this student + scenario
    $stmt = $pdo->prepare("DELETE FROM question_responses WHERE student_id = ? AND scenario_id = ?");
    $stmt->execute([$_SESSION['user_id'], $scenarioId]);

    echo json_encode([
        'success' => true,
        'deleted_rows' => $stmt->rowCount()
    ]);
} catch (Exception $e) {
    // Log error for debugging
    error_log("Clear responses error: " . $e->getMessage());
    
    // Always return JSON, even on error
    echo json_encode([
        'success' => false,
        'error' => 'Database error'
    ]);
}
?>