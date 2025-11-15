<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: project.php");
    exit();
}

// Sambung ke database
$pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');

// Ambil semua scenario kategori Clutch System dari database
$stmt = $pdo->prepare("SELECT * FROM scenarios WHERE category = ? ORDER BY id DESC");
$stmt->execute(['Clutch System Problems']);
$scenarios = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Clutch Problems - FixSense</title>
  <link rel="stylesheet" href="css/AutomotivePart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <!-- Mobile Optimization -->
  <link rel="stylesheet" href="css/mobile-optimization.css">
</head>
<body>
  <header>
    <h2>FixSense - Clutch System Troubleshooting</h2>
  </header>
  <div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
      <a href="simulationSelection.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Automotive Parts</a>
      <div style="display: flex; gap: 10px;">
        <a href="#" target="_blank" class="youtube-btn">
          <i class="fab fa-youtube"></i> Watch Animation
        </a>
        <a href="clutch_tools.php" class="tools-button">
          <i class="fas fa-wrench"></i> Clutch Tools
        </a>
      </div>
    </div>
    <h1>Clutch System Problems</h1>
    <ul class="problem-list">
      <!-- Hardcoded problems -->
      <?php foreach ($scenarios as $s): ?>
    <li>
        <a href="simulationClutch.php?scenario_id=<?= $s['id'] ?>">
            <i class="fas fa-tools"></i>
            <span><?= htmlspecialchars($s['title']) ?></span>
        </a>
    </li>
<?php endforeach; ?>
        
    </ul>
  </div>
  
  <!-- Mobile Optimization -->
  <script src="js/mobile-optimization.js"></script>
</body>
</html>