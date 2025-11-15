<?php
// filepath: c:\xampp\htdocs\fixsense\editScenario.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'lecturer') {
    header("Location: project.php");
    exit();
}
$fullName = htmlspecialchars($_SESSION['full_name']);
$pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
$id = intval($_GET['id'] ?? 0);

// Dapatkan scenario
$stmt = $pdo->prepare("SELECT * FROM scenarios WHERE id = ?");
$stmt->execute([$id]);
$scenario = $stmt->fetch();
if (!$scenario) { echo "Scenario not found!"; exit(); }

// Dapatkan steps & options
$stepsStmt = $pdo->prepare("SELECT * FROM steps WHERE scenario_id = ? ORDER BY step_number ASC");
$stepsStmt->execute([$id]);
$steps = $stepsStmt->fetchAll();

foreach ($steps as &$step) {
    $opts = $pdo->prepare("SELECT * FROM options WHERE step_id = ?");
    $opts->execute([$step['id']]);
    $step['options'] = $opts->fetchAll();
}
unset($step);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Update scenario
        // handle image upload (optional)
$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads';
if (!is_dir($uploadsDir)) {
    mkdir($uploadsDir, 0755, true);
}

$newImagePath = $scenario['image_path']; // keep existing by default
if (!empty($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
    $file = $_FILES['image_file'];
    if ($file['error'] !== UPLOAD_ERR_OK) throw new Exception("Upload error: " . $file['error']);
    $check = @getimagesize($file['tmp_name']);
    if ($check === false) throw new Exception("Uploaded file is not a valid image.");

    $allowedExt = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt)) throw new Exception("Unsupported image format.");

    $targetFilename = "scenario_{$id}." . $ext;
    $targetPath = $uploadsDir . DIRECTORY_SEPARATOR . $targetFilename;

    // Delete old file if exists
    if (!empty($scenario['image_path']) && strpos($scenario['image_path'], 'uploads/') === 0) {
        $oldPath = __DIR__ . DIRECTORY_SEPARATOR . $scenario['image_path'];
        if (is_file($oldPath) && realpath($oldPath) !== realpath($targetPath)) {
            @unlink($oldPath);
        }
    }

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("Failed to move uploaded file.");
    }

    $newImagePath = 'uploads/' . $targetFilename;
}

$stmt = $pdo->prepare("UPDATE scenarios 
    SET title=?, description=?, category=?, image_path=?, 
        root_cause=?, solution=?, learning=? 
    WHERE id=?");
$stmt->execute([
    $_POST['title'],
    $_POST['description'],
    $_POST['category'],
    $newImagePath,
    $_POST['root_cause'],
    $_POST['solution'],
    $_POST['learning'],
    $id
]);



        // Padam steps/options yang dibuang
        $existingStepIds = array_column($steps, 'id');
        $postedSteps = json_decode($_POST['steps_json'], true);
        $postedStepIds = [];
        foreach ($postedSteps as $s) {
            if (isset($s['id']) && is_numeric($s['id'])) $postedStepIds[] = $s['id'];
        }
        $deletedStepIds = array_diff($existingStepIds, $postedStepIds);
        foreach ($deletedStepIds as $sid) {
            $pdo->prepare("DELETE FROM options WHERE step_id=?")->execute([$sid]);
            $pdo->prepare("DELETE FROM steps WHERE id=?")->execute([$sid]);
        }

        // Update/add steps & options
        foreach ($postedSteps as $i => $step) {
            if (isset($step['id']) && is_numeric($step['id'])) {
                // Update step
                $pdo->prepare("UPDATE steps SET description=?, step_number=? WHERE id=?")
                    ->execute([$step['description'], $i + 1, $step['id']]);
                $stepId = $step['id'];
            } else {
                // Insert step baru
                $pdo->prepare("INSERT INTO steps (scenario_id, step_number, description) VALUES (?, ?, ?)")
                    ->execute([$id, $i + 1, $step['description']]);
                $stepId = $pdo->lastInsertId();
            }

            // Padam options yang dibuang
            $optStmt = $pdo->prepare("SELECT id FROM options WHERE step_id=?");
            $optStmt->execute([$stepId]);
            $existingOptIds = $optStmt->fetchAll(PDO::FETCH_COLUMN);
            $postedOptIds = [];
            foreach ($step['options'] as $opt) {
                if (isset($opt['id']) && is_numeric($opt['id'])) $postedOptIds[] = $opt['id'];
            }
            $deletedOptIds = array_diff($existingOptIds, $postedOptIds);
            foreach ($deletedOptIds as $oid) {
                $pdo->prepare("DELETE FROM options WHERE id=?")->execute([$oid]);
            }

            // Update/add options
            foreach ($step['options'] as $opt) {
                $isCorrect = !empty($opt['isCorrect']) ? 1 : 0;
                if (isset($opt['id']) && is_numeric($opt['id'])) {
                    $pdo->prepare("UPDATE options SET text=?, is_correct=?, explanation=? WHERE id=?")
                        ->execute([$opt['text'], $isCorrect, $opt['explanation'], $opt['id']]);
                } else {
                    $pdo->prepare("INSERT INTO options (step_id, text, is_correct, explanation) VALUES (?, ?, ?, ?)")
                        ->execute([$stepId, $opt['text'], $isCorrect, $opt['explanation']]);
                }
            }
        }

        header("Location: lecturer.php?msg=Scenario+updated+successfully!");
        exit();
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Scenario - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        
    /* === MULA: Gaya dari project.php (dikemas kini) === */
     :root {
    --primary-color: #1a56db;
    --secondary-color: #ff6b35;
    --dark-color: #2d3748;
    --light-color: #f7fafc;
    --gray-color: #e2e8f0;
    --dark-gray: #718096;
    --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    --card-hover-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

body {
    background-color: #f1f5f9;
    color: var(--dark-color);
    line-height: 1.6;
    transition: background-color 0.3s, color 0.3s;
}

.container {
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* === BACK BUTTON STYLING === */
.title-with-back {
    display: flex;
    align-items: flex-start;
    gap: 20px;
    margin-bottom: 40px;
    padding-top: 20px;
}

.back-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    color: #1a56db;
    font-weight: 600;
    background: linear-gradient(135deg, #ffffff, #e6f7ff);
    padding: 10px 20px;
    border-radius: 50px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    margin-top: 8px; /* Align with title */
}

.back-btn:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg, #ffeedf, #ffd9c2);
    color: #ff6b35;
}

.back-btn i {
    background: #1a56db;
    color: white;
    border-radius: 50%;
    padding: 6px;
    font-size: 0.9rem;
}

.back-btn:hover i {
    background: #ff6b35;
    color: white;
}

.title-content {
    flex: 1;
}

main {
    padding: 40px 0;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
}

.page-title {
    font-size: 2.2rem;
    color: var(--primary-color);
    margin-bottom: 15px;
}

.page-subtitle {
    color: var(--dark-gray);
    font-size: 1.1rem;
    max-width: 700px;
    margin: 0 auto;
}

.form-container {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: var(--card-shadow);
    margin-bottom: 30px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: var(--dark-color);
}

.form-group input,
.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid var(--gray-color);
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
    background-color: white;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
}

.form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.steps-section {
    background: white;
    border-radius: 10px;
    padding: 30px;
    box-shadow: var(--card-shadow);
    margin-bottom: 30px;
}

.section-title {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.steps-container {
    margin-top: 20px;
    padding: 15px;
    background-color: #f5f5f5;
    border-radius: 5px;
}

.step-card {
    background: #f8fafc;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    border-left: 4px solid var(--primary-color);
}

.step-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.step-number {
    font-weight: bold;
    font-size: 1.2rem;
    color: var(--primary-color);
}

.step-actions {
    display: flex;
    gap: 10px;
}

.btn-step {
    padding: 6px 12px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 0.9rem;
}

.btn-add-step {
    background-color: var(--primary-color);
    color: white;
}

.btn-add-step:hover {
    background-color: #1648b5;
}

.btn-remove-step {
    background-color: #dc3545;
    color: white;
}

.btn-remove-step:hover {
    background-color: #c82333;
}

.options-container {
    margin-top: 15px;
}

.option-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.option-row input,
.option-row select {
    flex: 1;
}

.option-row .btn-option {
    padding: 6px 10px;
    border-radius: 4px;
    border: none;
    cursor: pointer;
    font-size: 0.85rem;
}

.btn-add-option {
    background-color: #28a745;
    color: white;
}

.btn-add-option:hover {
    background-color: #218838;
}

.btn-remove-option {
    background-color: #dc3545;
    color: white;
}

.btn-remove-option:hover {
    background-color: #c82333;
}

.btn {
    display: inline-block;
    padding: 12px 24px;
    border-radius: 4px;
    font-weight: 600;
    font-size: 16px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #1a56db;
    background: var(--primary-color);
    color: #ffffff;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.btn-secondary {
    background: #ff6b35;
    background: var(--secondary-color);
}

.btn-secondary:hover {
    background: #e55a2b;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
    margin-top: 20px;
}

footer {
    background-color: var(--dark-color);
    color: white;
    padding: 60px 0 30px;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 40px;
    margin-bottom: 40px;
}

.footer-column h3 {
    font-size: 1.3rem;
    margin-bottom: 20px;
    position: relative;
    padding-bottom: 10px;
}

.footer-column h3::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 2px;
    background-color: var(--secondary-color);
}

.footer-column ul {
    list-style: none;
}

.footer-column ul li {
    margin-bottom: 12px;
}

.footer-column ul li a {
    color: #cbd5e0;
    text-decoration: none;
    transition: color 0.3s;
}

.footer-column ul li a:hover {
    color: white;
}

.social-links {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.social-links a {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background-color: #4a5568;
    border-radius: 50%;
    color: white;
    transition: background-color 0.3s;
}

.social-links a:hover {
    background-color: var(--secondary-color);
}

.footer-bottom {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid #4a5568;
    color: #cbd5e0;
    font-size: 0.9rem;
}

@media (max-width: 768px) {
    .page-title {
        font-size: 1.8rem;
    }

    .form-actions {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }
}

.step-card.active {
    border-color: #ff6b35;
    box-shadow: 0 0 0 2px #ff6b3533;
}

body.dark-mode {
    background-color: #0f172a !important;
    color: #f1f5f9 !important;
}

.dark-mode header {
    background-color: #0f172a !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3) !important;
}

.dark-mode .logo {
    color: #93c5fd !important;
}

.dark-mode .logo i {
    color: #fb923c !important;
}

.dark-mode .nav-links a {
    color: #f1f5f9 !important;
}

.dark-mode .nav-links a:hover {
    color: #fb923c !important;
}

.dark-mode .nav-links a::after {
    background-color: #fb923c !important;
}

.dark-mode .back-link {
    background: #1e293b !important;
    color: #93c5fd !important;
    border-color: #334155 !important;
}

.dark-mode .back-link:hover {
    background: #334155 !important;
    color: #fb923c !important;
}

.dark-mode .back-link i {
    color: inherit !important;
}

body.dark-mode .btn {
    color: #ffffff;
}

body.dark-mode .btn-secondary {
    color: #ffffff;
}
    
   
    /* === TAMAT: Responsif === */

    </style>
    <style>
        /* Untuk highlight step yang sedang diedit */
        .step-card.active { border-color: #ff6b35; box-shadow: 0 0 0 2px #ff6b3533; }
    </style>
</head>
<body>
    <main>
        <div class="container">
            <div class="page-header">
                <div class="title-with-back">
                    <a href="lecturer.php" class="back-btn">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                    <div class="title-content">
                        <h1 class="page-title">Edit Troubleshooting Scenario</h1>
                        <p class="page-subtitle">Update interactive scenarios for students to practice problem-solving skills.</p>
                    </div>
                </div>
            </div>
            <?php if ($error): ?>
                <div style="background:#fee; color:#c33; padding:12px; border-radius:6px; margin-bottom:20px;">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            <div class="form-container">
                <form id="scenarioForm" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="scenarioTitle">Scenario Title *</label>
                        <input type="text" id="scenarioTitle" name="title" value="<?= htmlspecialchars($scenario['title']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="scenarioDescription">Scenario Description *</label>
                        <textarea id="scenarioDescription" name="description" required><?= htmlspecialchars($scenario['description']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="scenarioCategory">Category *</label>
                        <select id="scenarioCategory" name="category" required>
                            <option value="">Select a Category</option>
                            <option value="Engine Problems" <?= $scenario['category']=='Engine Problems'?'selected':'' ?>>Engine Problems</option>
                            <option value="Brake System Problems" <?= $scenario['category']=='Brake System Problems'?'selected':'' ?>>Brake System Problems</option>
                            <option value="Air-Suspension Problems" <?= $scenario['category']=='Air-Suspension Problems'?'selected':'' ?>>Air-Suspension Problems</option>
                        </select>
                    </div>
                   
                    <div class="form-group">
    <label for="image_file">Upload New Image (Optional)</label>

    <!-- Current Image -->
    <?php if (!empty($scenario['image_path'])): ?>
        <img 
            id="previewImage"
            src="<?= htmlspecialchars($scenario['image_path']) ?>" 
            alt="Current image" 
            style="display:block; width:200px; height:150px; object-fit:contain; border-radius:8px; border:1px solid #ddd; background:#f8f8f8; margin-bottom:10px;"
        >
    <?php else: ?>
        <img 
            id="previewImage"
            src="#" 
            alt="Preview" 
            style="display:none; width:200px; height:150px; object-fit:contain; border-radius:8px; border:1px solid #ddd; background:#f8f8f8; margin-bottom:10px;"
        >
    <?php endif; ?>

    <input type="file" id="image_file" name="image_file" accept="image/*">
    <small>Upload a new image to replace the existing one.</small>
</div>



                    <hr style="margin:25px 0;">
<h3 style="color:#1a56db;">Final Diagnosis Information</h3>

<div class="form-group">
    <label for="root_cause">Root Cause *</label>
    <textarea name="root_cause" id="root_cause" required><?= htmlspecialchars($scenario['root_cause']) ?></textarea>
</div>

<div class="form-group">
    <label for="solution">Solution *</label>
    <textarea name="solution" id="solution" required><?= htmlspecialchars($scenario['solution']) ?></textarea>
</div>

<div class="form-group">
    <label for="learning">Learning Outcome *</label>
    <textarea name="learning" id="learning" required><?= htmlspecialchars($scenario['learning']) ?></textarea>
</div>

                    <input type="hidden" id="stepsJsonInput" name="steps_json">
                </form>
            </div>

            <div class="steps-section">
                <h2 class="section-title"><i class="fas fa-project-diagram"></i> Scenario Steps</h2>
                <p>Add the decision points and possible outcomes for your scenario.</p>
                <div class="steps-container" id="stepsContainer"></div>
            </div>

            <div class="form-actions">
                <a href="manageScenario.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" form="scenarioForm" class="btn">Save Changes</button>
            </div>
        </div>
    </main>

    <!-- Footer (copy dari createScenario.php) -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h3>FixSense</h3>
                    <p>Master Troubleshooting, Anytime, Anywhere. Web-based platform for technical skill development in automotive, electrical, and electronics fields.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-column">
                    <h3>Quick Links</h3>
                    <ul>
                        <li><a href="lecturer.html">Dashboard</a></li>
                        <li><a href="#">Manage Scenarios</a></li>
                        <li><a href="#">AI Chatbot</a></li>
                        <li><a href="#">Manage Extra Notes</a></li>
                        <li><a href="lecturer.html">Settings</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Resources</h3>
                    <ul>
                        <li><a href="#">Getting Started Guide</a></li>
                        <li><a href="#">Troubleshooting Manual</a></li>
                        <li><a href="#">Video Tutorials</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Technical Support</a></li>
                    </ul>
                </div>
                
                <div class="footer-column">
                    <h3>Contact Us</h3>
                    <ul>
                        <li><i class="fas fa-envelope"></i> support@fixsense.com</li>
                        <li><i class="fas fa-phone"></i> +60 xx xxx xxxx</li>
                        <li><i class="fas fa-map-marker-alt"></i> ILP Kuantan, Pahang</li>
                    </ul>
                    <ul style="margin-top: 20px;">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 FixSense. All rights reserved. Developed for ILP Kuantan Technical Education.</p>
            </div>
        </div>
    </footer>

    <script>
        // --- Dinamik Step/Option (pre-fill dari DB) ---
        let stepsData = <?= json_encode($steps) ?>;
        let stepCounter = stepsData.length || 1;

        function renderSteps() {
            const stepsContainer = document.getElementById('stepsContainer');
            stepsContainer.innerHTML = '';
            stepsData.forEach((step, sIdx) => {
                const stepCard = document.createElement('div');
                stepCard.className = 'step-card';
                stepCard.setAttribute('data-step-id', sIdx + 1);

                stepCard.innerHTML = `
                    <div class="step-header">
                        <div class="step-number">Step ${sIdx + 1}</div>
                        <div class="step-actions">
                            <button type="button" class="btn-step btn-remove-step" onclick="removeStep(${sIdx})" ${stepsData.length === 1 ? 'style="display:none;"' : ''}><i class="fas fa-trash"></i> Remove</button>
                            <button type="button" class="btn-step btn-add-step" onclick="addStep(${sIdx})"><i class="fas fa-plus"></i> Add Step</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Step Description *</label>
                        <textarea class="step-description" placeholder="Describe the situation at this step..." required>${step.description ?? ''}</textarea>
                    </div>
                    <div class="options-container">
                        <label>Options for this step:</label>
                        ${renderOptions(step.options || [], sIdx)}
                    </div>
                `;
                stepsContainer.appendChild(stepCard);
            });
        }

        function renderOptions(options, stepIdx) {
            let html = '';
            options.forEach((opt, oIdx) => {
                html += `
                <div class="option-row">
                    <input type="text" class="option-text" placeholder="Option text..." value="${opt.text ? escapeHtml(opt.text) : ''}" required data-opt-idx="${oIdx}">
                    <select class="option-correct">
                        <option value="false" ${opt.is_correct == 0 ? 'selected' : ''}>Incorrect</option>
                        <option value="true" ${opt.is_correct == 1 ? 'selected' : ''}>Correct</option>
                    </select>
                    <input type="text" class="option-explanation" placeholder="Explanation if chosen..." value="${opt.explanation ? escapeHtml(opt.explanation) : ''}" required>
                    <button type="button" class="btn-option btn-remove-option" onclick="removeOption(${stepIdx},${oIdx})"><i class="fas fa-trash"></i></button>
                </div>
                `;
            });
            html += `
                <div class="option-row">
                    <input type="text" class="option-text" placeholder="Option text..." required>
                    <select class="option-correct">
                        <option value="false">Incorrect</option>
                        <option value="true">Correct</option>
                    </select>
                    <input type="text" class="option-explanation" placeholder="Explanation if chosen..." required>
                    <button type="button" class="btn-option btn-add-option" onclick="addOption(${stepIdx}, this)"><i class="fas fa-plus"></i></button>
                </div>
            `;
            return html;
        }

        function addStep(afterIdx = null) {
            const newStep = { description: '', options: [] };
            if (afterIdx === null || afterIdx === stepsData.length - 1) {
                stepsData.push(newStep);
            } else {
                stepsData.splice(afterIdx + 1, 0, newStep);
            }
            stepCounter = stepsData.length;
            renderSteps();
        }

        function removeStep(idx) {
            if (stepsData.length > 1) {
                stepsData.splice(idx, 1);
                renderSteps();
            }
        }

        function addOption(stepIdx, btn) {
            const row = btn.closest('.option-row');
            const text = row.querySelector('.option-text').value;
            const isCorrect = row.querySelector('.option-correct').value === 'true';
            const explanation = row.querySelector('.option-explanation').value;
            if (!text || !explanation) {
                alert('Please fill in option text and explanation.');
                return;
            }
            stepsData[stepIdx].options = stepsData[stepIdx].options || [];
            stepsData[stepIdx].options.push({ text, isCorrect, explanation });
            renderSteps();
        }

        function removeOption(stepIdx, optIdx) {
            stepsData[stepIdx].options.splice(optIdx, 1);
            renderSteps();
        }

        // Escape HTML for value attributes
        function escapeHtml(text) {
            return text.replace(/&/g, "&amp;")
                       .replace(/</g, "&lt;")
                       .replace(/>/g, "&gt;")
                       .replace(/"/g, "&quot;")
                       .replace(/'/g, "&#039;");
        }

        // Pre-fill stepsData with IDs for update/delete
        stepsData = stepsData.map(step => ({
            id: step.id,
            description: step.description,
            options: (step.options || []).map(opt => ({
                id: opt.id,
                text: opt.text,
                isCorrect: opt.is_correct == 1,
                explanation: opt.explanation
            }))
        }));

        renderSteps();

        // On submit, serialize all steps/options
        document.getElementById('scenarioForm').addEventListener('submit', function(e) {
            // Sync textarea/inputs to stepsData
            document.querySelectorAll('.step-card').forEach((card, sIdx) => {
                stepsData[sIdx].description = card.querySelector('.step-description').value;
                // Sync options
                let options = [];
                card.querySelectorAll('.option-row').forEach((optRow, oIdx) => {
                    const text = optRow.querySelector('.option-text').value;
                    const isCorrect = optRow.querySelector('.option-correct').value === 'true';
                    const explanation = optRow.querySelector('.option-explanation').value;
                    // Only push if not the last (add option row)
                    if (optRow.querySelector('.btn-add-option')) return;
                    // Keep id if exists
                    const optId = stepsData[sIdx].options[oIdx] && stepsData[sIdx].options[oIdx].id ? stepsData[sIdx].options[oIdx].id : undefined;
                    options.push({ id: optId, text, isCorrect, explanation });
                });
                stepsData[sIdx].options = options;
            });
            document.getElementById('stepsJsonInput').value = JSON.stringify(stepsData);
        });

        // === Image preview (Edit Scenario) ===
document.getElementById('image_file').addEventListener('change', function(e) {
    const [file] = e.target.files;
    const preview = document.getElementById('previewImage');
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});

    </script>
</body>
</html>