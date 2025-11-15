<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Automotive Parts - FixSense</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      background: #f8fafc;
      color: #333;
    }

    header {
      background: #1a56db;
      color: #fff;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .container {
      max-width: 1100px;
      margin: 40px auto;
      padding: 20px;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #1a56db;
    }

    .parts-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 25px;
    }

    .part-card {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      padding: 20px;
      background: white;
      border-radius: 16px;
      text-decoration: none;
      color: #2d3748;
      font-weight: 600;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    .part-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .part-card img {
      width: 100%;
      max-height: 180px;
      object-fit: cover;
      border-radius: 12px;
      margin-bottom: 15px;
    }

    .part-card h3 {
      margin-bottom: 10px;
      color: #1a56db;
    }

    .part-card p {
      font-size: 0.95rem;
      color: #555;
      font-weight: normal;
    }

    /* Back Button */
    .back-link {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 30px;
      text-decoration: none;
      color: #1a56db;
      background: linear-gradient(135deg, #ffffff, #e6f7ff);
      padding: 12px 20px;
      border-radius: 50px;
      font-weight: 600;
      font-size: 1rem;
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
      transition: all 0.3s ease;
    }

    .back-link i {
      background: #1a56db;
      color: white;
      border-radius: 50%;
      padding: 6px;
      font-size: 0.9rem;
    }

    .back-link:hover {
      transform: translateY(-3px);
      background: linear-gradient(135deg, #ffeedf, #ffd9c2);
      color: #ff6b35;
    }

    .back-link:hover i {
      background: #ff6b35;
      color: white;
    }
  </style>
</head>

<body>
  <header>
    <h2>FixSense - Automotive Troubleshooting</h2>
  </header>

  <div class="container">
    <a href="project.php" class="back-link"><i class="fas fa-arrow-left"></i> Back to Home</a>
    <h1>Select Automotive Part</h1>

    <div class="parts-grid">

      <a href="engine.php" class="part-card">
        <img src="engine.png" alt="Engine">
        <h3>Engine System</h3>
        <p>Check engine parts, oil, and performance issues.</p>
      </a>

      <a href="brake.php" class="part-card">
        <img src="brake.jpg" alt="Brake">
        <h3>Brake System Problems</h3>
        <p>Identify and fix braking system issues.</p>
      </a>

      <a href="airsus.php" class="part-card">
        <img src="airsus.webp" alt="Air-Suspension">
        <h3>Air-Suspension Problems</h3>
        <p>Air bag, compressor, and ride height problems.</p>
      </a>

      <a href="aircond.php" class="part-card">
        <img src="airsus.jpg" alt="aircond">
        <h3>Air-Conditioning</h3>
        <p>Compressor, cooling, and blower motor issues..</p>
      </a>

      <a href="fuel.php" class="part-card">
        <img src="fuel.jpg" alt="Fuel System">
        <h3>Fuel System</h3>
        <p>Fuel pump, injector, and fuel pressure issues.</p>
      </a>

      <a href="cooling.php" class="part-card">
        <img src="cooling.jpg" alt="Cooling System">
        <h3>Cooling System</h3>
        <p>Overheating, radiator, and coolant leak checks.</p>
      </a>

      <a href="transmission.php" class="part-card">
        <img src="transmission.jpg" alt="Transmission">
        <h3>Transmission System</h3>
        <p>Gear shifting, clutch, and fluid problems.</p>
      </a>

      <a href="suspension.php" class="part-card">
        <img src="suspension.jpg" alt="Suspension">
        <h3>Suspension System</h3>
        <p>Shock absorber, spring, and control arm issues.</p>
      </a>

      <a href="electrical.php" class="part-card">
        <img src="electrical.jpg" alt="Electrical">
        <h3>Electrical System</h3>
        <p>Battery, wiring, and fuse problems.</p>
      </a>
     
      <a href="clutch.php" class="part-card">
        <img src="clutch.jpg" alt="Clutch">
        <h3>Clutch System</h3>
        <p></p>
      </a>

      <a href="exhaust.php" class="part-card">
        <img src="exhaust.jpg" alt="Exhaust">
        <h3>Exhaust System</h3>
        <p>Exhaust leak, muffler, and noise problems.</p>
      </a>

      <a href="wheels.php" class="part-card">
        <img src="wheels.jpg" alt="Wheels">
        <h3>Wheels System</h3>
        <p></p>
      </a>


    </div>
  </div>

  <script>
    // Example: save final score
    async function submitFinalScore(scenarioId, finalScore) {
      try {
        const response = await fetch('savePerformance.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            scenario_id: scenarioId,
            score: finalScore
          })
        });
        const result = await response.json();
        if (result.success) {
          alert(`Simulation completed! You ${result.status} with ${finalScore}%`);
          window.location.href = 'index.php';
        } else {
          alert('Failed to save your score: ' + (result.error || 'Unknown error'));
        }
      } catch (error) {
        console.error('Save error:', error);
        alert('Network error. Your score may not be saved.');
      }
    }
  </script>
</body>

</html>
