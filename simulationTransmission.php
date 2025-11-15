<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: project.php");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');

// Jika dynamic scenario dari DB
if (isset($_GET['scenario_id'])) {
    $scenarioId = floatval($_GET['scenario_id']);
    // Ambil scenario
    $stmt = $pdo->prepare("SELECT * FROM scenarios WHERE id = ?");
    $stmt->execute([$scenarioId]);
    $scenarioRow = $stmt->fetch();

    if (!$scenarioRow) {
        echo "<h2>Scenario not found.</h2>";
        exit();
    }

    // Ambil semua steps untuk scenario ini
    $stepsStmt = $pdo->prepare("SELECT * FROM steps WHERE scenario_id = ? ORDER BY step_number ASC");
    $stepsStmt->execute([$scenarioId]);
    $stepsRows = $stepsStmt->fetchAll();

    $steps = [];
    foreach ($stepsRows as $step) {
        // Ambil semua options untuk step ini
        $optionsStmt = $pdo->prepare("SELECT * FROM options WHERE step_id = ? ORDER BY id ASC");
        $optionsStmt->execute([$step['id']]);
        $optionsRows = $optionsStmt->fetchAll();

        $options = [];
        foreach ($optionsRows as $opt) {
            $options[] = [
                'text' => $opt['text'],
                'isCorrect' => (bool)$opt['is_correct'],
                'explanation' => $opt['explanation']
            ];
        }

        // Cari explanation untuk jawapan betul (untuk feedbackCorrect)
        $question = "What is the appropriate action for this situation?";
$feedbackCorrect = '';
$feedbackIncorrect = '';

// Ambil feedback betul & salah terus dari DB
foreach ($optionsRows as $opt) {
    if ($opt['is_correct']) {
        $feedbackCorrect = $opt['explanation'] ?? '✅ Correct!';
    } else {
        $feedbackIncorrect = $opt['explanation'] ?? '❌ Incorrect.';
    }
}


// Jika tiada option langsung, fallback
if (empty($options)) {
    $feedbackCorrect = "No options available.";
    $feedbackIncorrect = "No options available.";
}

$steps[] = [
    'problem' => $step['description'],
    'question' => $question,
    'options' => $options,
    'feedbackCorrect' => $feedbackCorrect,
    'feedbackIncorrect' => $feedbackIncorrect
];
    }

   $scenarioData = [
    'title' => $scenarioRow['title'],
    'image' => $scenarioRow['image_path'] ?? 'https://images.unsplash.com/photo-1552519507-da3b142c6e3d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'steps' => $steps,
    'root_cause' => $scenarioRow['root_cause'] ?? 'No data available.',
    'solution' => $scenarioRow['solution'] ?? 'No data available.',
    'learning' => $scenarioRow['learning'] ?? 'No data available.'
];

    $stepsJson = json_encode($scenarioData['steps']);
    $scenarioId = $scenarioRow['id']; // 👈 Gunakan ID dari DB
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($scenarioData['title']) ?> - FixSense</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f4ff, #e6f7ff);
            margin: 0;
            padding: 0;
            color: #333;
        }

        header {
            background: #1a56db;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            padding: 25px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .scenario-title {
            text-align: center;
            color: #1a56db;
            margin-bottom: 20px;
            font-size: 1.8rem;
        }

        .scenario-image {
            width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 10px;
            margin: 2px auto;
        }

        .problem-desc {
            background: #f8fafc;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 4px solid #1a56db;
        }

        .options {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 30px;
        }

        .option-btn {
            padding: 16px 20px;
            background: #e2e8f0;
            border: 2px solid #cbd5e0;
            border-radius: 12px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: left;
            font-weight: 600;
        }

        .option-btn:hover {
            background: #cbd5e0;
            transform: translateY(-2px);
        }

        .option-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .feedback {
            padding: 20px;
            border-radius: 12px;
            margin: 25px 0;
            font-size: 1.05rem;
            line-height: 1.5;
            display: none;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .feedback.correct {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-left: 5px solid #28a745;
            color: #155724;
        }

        .feedback.incorrect {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-left: 5px solid #dc3545;
            color: #721c24;
        }

        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .btn {
            padding: 14px 28px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-primary {
            background: #1a56db;
            color: white;
        }

        .btn-primary:hover {
            background: #1648b5;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .step-indicator {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #555;
        }

        .progress-bar {
            height: 8px;
            background: #e2e8f0;
            border-radius: 4px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #1a56db, #3b82f6);
            width: 0%;
            transition: width 0.5s ease;
        }
        .scenario-image-wrapper {
  width: 100%;
  max-width: 700px; /* ubah kalau nak lebih besar */
  aspect-ratio: 16 / 9;
  margin: 20px auto;
  background: #f8f8f8;
  border-radius: 10px;
  border: 1px solid #ddd;
  display: flex;
  justify-content: center;
  align-items: center;
}

.scenario-image.full {
  width: 1000%;
  height: 100%;
  object-fit: contain; /* penting: elak crop */
}

    </style>
</head>

<body>
    <header>
        <h2>FixSense - Transmission System Troubleshooting</h2>
    </header>

    <div class="container">
        <a href="transmission.php" class="btn btn-secondary" style="margin-bottom: 20px; text-decoration: none;">
            ← Back to Transmission Problems
        </a>

        <h1 class="scenario-title">Scenario: <?= htmlspecialchars($scenarioData['title']) ?></h1>

        <div class="progress-bar">
            <div class="progress-fill" id="progressBar"></div>
        </div>

        <div class="step-indicator" id="stepIndicator">Step 1 of <?= count($scenarioData['steps']) ?></div>

       <div class="scenario-image-wrapper">
  <img src="<?= htmlspecialchars($scenarioData['image']) ?>" 
       alt="Scenario Image" 
       class="scenario-image full">
</div>


        <div class="problem-desc" id="problemDesc"></div>

        <div class="options" id="optionsContainer"></div>

        <div id="feedback" class="feedback"></div>

        <div class="navigation">
            <button class="btn btn-secondary" onclick="resetScenario()">↺ Restart Scenario</button>
            <button class="btn btn-primary" onclick="nextStep()" id="nextBtn" style="display: none;">→ Next Step</button>
        </div>
    </div>

    <script>
        const scenario = {
            steps: <?= $stepsJson ?>
        };
        const scenarioId = '<?= $scenarioId ?>';
        const studentId = <?= $_SESSION['user_id'] ?>;

        let currentStep = 0;
        let score = 0;

        async function saveAnswer(questionId, selectedOption, isCorrect) {
            try {
                await fetch('saveQuestionResponse.php', { 
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        student_id: studentId,
                        scenario_id: scenarioId,
                        question_id: questionId,
                        selected_option: selectedOption,
                        is_correct: isCorrect
                    })
                });
            } catch (error) {
                console.error('Failed to save answer:', error);
            }
        }

        function initScenario() {
            updateStep();
        }

        function updateStep() {
            const step = scenario.steps[currentStep];
            const progressPercent = ((currentStep + 1) / scenario.steps.length) * 100;
            document.getElementById('progressBar').style.width = progressPercent + '%';
            document.getElementById('stepIndicator').textContent = `Step ${currentStep + 1} of ${scenario.steps.length}`;
            document.getElementById('problemDesc').innerHTML =
                `<strong>Problem:</strong> ${step.problem}<br><br><strong>${step.question}</strong>`;

            const container = document.getElementById('optionsContainer');
            container.innerHTML = '';
            step.options.forEach((opt, idx) => {
                const btn = document.createElement('button');
                btn.className = 'option-btn';
                btn.innerHTML = opt.text;
                btn.onclick = () => handleAnswer(idx, opt.isCorrect);
                container.appendChild(btn);
            });

            document.getElementById('feedback').style.display = 'none';
            document.getElementById('nextBtn').style.display = 'none';
        }

        function handleAnswer(optionIndex, isCorrect) {
            const step = scenario.steps[currentStep];
            const optionText = step.options[optionIndex].text;
            saveAnswer(currentStep + 1, optionText, isCorrect);

            const feedback = document.getElementById('feedback');
            if (isCorrect) {
                feedback.innerHTML = step.feedbackCorrect;
                feedback.className = 'feedback correct';
                score++;
            } else {
                feedback.innerHTML = step.feedbackIncorrect;
                feedback.className = 'feedback incorrect';
            }
            feedback.style.display = 'block';

            document.querySelectorAll('.option-btn').forEach(btn => btn.disabled = true);

            if (currentStep < scenario.steps.length - 1) {
                document.getElementById('nextBtn').style.display = 'inline-block';
            } else {
                document.getElementById('nextBtn').textContent = '🏁 Complete Scenario';
                document.getElementById('nextBtn').style.display = 'inline-block';
                document.getElementById('nextBtn').onclick = completeScenario;
            }
        }

        function nextStep() {
            currentStep++;
            updateStep();
        }

      
            async function completeScenario() {
    const finalScore = Math.round((score / scenario.steps.length) * 100);
    try {
        await fetch('savePerformance.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                scenario_id: scenarioId,
                score: finalScore
            })
        });
    } catch (error) {
        console.error('Failed to save performance:', error);
    }

    document.querySelector('.container').innerHTML = `
        <a href="transmission.php" class="btn btn-secondary" style="margin-bottom: 20px; text-decoration: none;">
          ← Back to Transmission Problems
        </a>
        <div style="text-align: center; padding: 40px; background: #f8fafc; border-radius: 16px; margin: 20px 0;">
          <h2 style="color: #1a56db; margin-bottom: 20px;">🎉 Scenario Complete!</h2>
          <p style="font-size: 1.2rem; margin-bottom: 30px;">You've successfully diagnosed the "<strong><?= htmlspecialchars($scenarioData['title']) ?></strong>" problem!</p>
          
          <div style="background: white; padding: 20px; border-radius: 12px; border: 2px solid #28a745; margin: 20px auto; max-width: 500px;">
            <h3 style="color: #28a745; margin-bottom: 15px;">Final Diagnosis:</h3>
            <p style="text-align: left; line-height: 1.6;">
              <strong>Root Cause:</strong> <?= nl2br(htmlspecialchars($scenarioData['root_cause'])) ?><br>
              <strong>Solution:</strong> <?= nl2br(htmlspecialchars($scenarioData['solution'])) ?><br>
              <strong>Learning:</strong> <?= nl2br(htmlspecialchars($scenarioData['learning'])) ?>
            </p>
          </div>

          <p style="font-size: 1.3rem; font-weight: bold; color: #1a56db; margin: 30px 0;">
            Score: ${score} out of ${scenario.steps.length} steps correct
          </p>
          <button class="btn btn-primary" onclick="tryAgain()">Try Again</button>
        </div>
    `;
}

       

        async function tryAgain() {
            try {
                await fetch('clearScenarioResponses.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        scenario_id: <?= $scenarioId ?>
                    })
                });
                window.location.reload();
            } catch (error) {
                console.error('Reset failed:', error);
                alert('Could not reset simulation.');
            }
        }

        function resetScenario() {
            currentStep = 0;
            score = 0;
            initScenario();
        }

        window.onload = initScenario;
    </script>
</body>

</html>