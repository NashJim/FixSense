<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}

try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$id = $_GET['id'] ?? 0;

if ($id) {
    try {
        // First delete related records (steps and options) if they exist
        $stmt = $pdo->prepare("DELETE FROM options WHERE step_id IN (SELECT id FROM steps WHERE scenario_id = ?)");
        $stmt->execute([$id]);
        
        $stmt = $pdo->prepare("DELETE FROM steps WHERE scenario_id = ?");
        $stmt->execute([$id]);
        
        // Then delete the scenario
        $stmt = $pdo->prepare("DELETE FROM scenarios WHERE id = ?");
        $stmt->execute([$id]);
        
        header("Location: manageScenario.php?msg=Scenario+deleted+successfully");
    } catch(PDOException $e) {
        header("Location: manageScenario.php?error=Failed+to+delete+scenario:+" . urlencode($e->getMessage()));
    }
} else {
    header("Location: manageScenario.php?error=Invalid+scenario+ID");
}
exit();