<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$input = json_decode(file_get_contents('php://input'), true);
$studentId = (int)($input['student_id'] ?? 0);
$scenarioId = (float)($input['scenario_id'] ?? 0);
$scenarioId = round($scenarioId, 1);
$questionId = (int)($input['question_id'] ?? 0);
$selectedOption = $input['selected_option'] ?? '';
$isCorrect = !empty($input['is_correct']);

if ($studentId !== $_SESSION['user_id'] || $scenarioId <= 0 || $questionId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid data']);
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $stmt = $pdo->prepare("
        INSERT INTO question_responses (student_id, scenario_id, question_id, selected_option, is_correct)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$studentId, $scenarioId, $questionId, $selectedOption, $isCorrect]);
    echo json_encode(['success' => true]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
}
?>