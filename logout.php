<?php
session_start();
session_destroy();

// Optional: Send JSON response for AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    echo json_encode(['success' => true]);
} else {
    // For direct access, redirect
    header("Location: project.php");
    exit();
}
?>