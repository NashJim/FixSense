<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Simple function to populate database with ExtraNotes files
function populateExtraNotes($pdo) {
    // Clear existing notes first
    try {
        $pdo->exec("DELETE FROM extra_notes");
        // Reset AUTO_INCREMENT to start fresh
        $pdo->exec("ALTER TABLE extra_notes AUTO_INCREMENT = 1");
    } catch(PDOException $e) {
        echo "Error clearing database: " . $e->getMessage();
    }
    
    // Define all the files we know exist in ExtraNotes folder
    $notesData = [
        [
            'title' => 'Brake System Components',
            'description' => 'Comprehensive guide to brake system parts, operation, and troubleshooting procedures.',
            'file_path' => 'ExtraNotes/BrakePart.pdf',
            'file_size' => '2.5 MB'
        ],
        [
            'title' => 'Clutch System Parts',
            'description' => 'Detailed information about clutch components, mechanisms, and common issues.',
            'file_path' => 'ExtraNotes/ClutchPart.pdf',
            'file_size' => '3.1 MB'
        ],
        [
            'title' => 'Cooling System Parts',
            'description' => 'Essential knowledge about engine cooling system components and maintenance.',
            'file_path' => 'ExtraNotes/CoolingPart.pdf',
            'file_size' => '2.8 MB'
        ],
        [
            'title' => 'Engine Parts',
            'description' => 'Complete overview of engine components, functions, and diagnostic procedures.',
            'file_path' => 'ExtraNotes/EnginePart.pdf',
            'file_size' => '4.2 MB'
        ],
        [
            'title' => 'Fuel System Components',
            'description' => 'In-depth coverage of fuel system parts, operation, and troubleshooting methods.',
            'file_path' => 'ExtraNotes/FuelPart.pdf',
            'file_size' => '3.7 MB'
        ],
        [
            'title' => 'Suspension System',
            'description' => 'Understanding suspension components, types, and common repair procedures.',
            'file_path' => 'ExtraNotes/Sus.pdf',
            'file_size' => '2.9 MB'
        ],
        [
            'title' => 'Transmission Parts',
            'description' => 'Comprehensive guide to transmission components and diagnostic techniques.',
            'file_path' => 'ExtraNotes/TransmissionPart.pdf',
            'file_size' => '3.5 MB'
        ],
        [
            'title' => 'Wheels and Tires',
            'description' => 'Essential information about wheel components, tire types, and maintenance.',
            'file_path' => 'ExtraNotes/WheelsPart.pdf',
            'file_size' => '2.3 MB'
        ]
    ];
    
    // Insert each file into database with sequential IDs
    $id = 1;
    foreach ($notesData as $note) {
        try {
            $stmt = $pdo->prepare("INSERT INTO extra_notes (id, title, description, file_path, file_size, uploaded_by, created_at) VALUES (?, ?, ?, ?, ?, 6, NOW())");
            $stmt->execute([
                $id,
                $note['title'],
                $note['description'],
                $note['file_path'],
                $note['file_size']
            ]);
            $id++;
        } catch(PDOException $e) {
            echo "Error inserting " . $note['title'] . ": " . $e->getMessage() . "<br>";
        }
    }
}

// Only populate/sync if specifically requested (e.g., ?sync=1)
if (isset($_GET['sync']) && $_GET['sync'] == '1') {
    populateExtraNotes($pdo);
}

// Fetch notes from database
try {
    $stmt = $pdo->query("SELECT * FROM extra_notes ORDER BY created_at DESC");
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $notes = [];
    error_log("Error fetching notes: " . $e->getMessage());
    // Display error for debugging
    echo "Database Error: " . $e->getMessage();
}

function formatFileSize($bytes) {
    // If it's already formatted (contains 'MB', 'KB'), return as is
    if (is_string($bytes) && (strpos($bytes, 'MB') !== false || strpos($bytes, 'KB') !== false)) {
        return $bytes;
    }
    
    // Otherwise format as usual
    if ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } else {
        return $bytes . ' B';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extra Notes - FixSense</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/darkmode.css">
    <script src="js/darkmode-fixed.js"></script>
    <style>
        /* Gunakan warna dari project.html */
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
            background-color: white;
            color: var(--dark-color);
            line-height: 1.6;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Styles - Sama macam project.html */
        header {
            background-color: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            position: relative;
        }
        
        .logo {
            display: flex;
            align-items: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .logo i {
            margin-right: 10px;
            color: var(--secondary-color);
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .nav-links li {
            margin-left: 30px;
        }
        
        .nav-links a {
            text-decoration: none;
            color: var(--dark-color);
            font-weight: 500;
            transition: color 0.3s;
            position: relative;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s;
        }
        
        .nav-links a:hover::after {
            width: 100%;
        }
        
        .auth-buttons {
            display: flex;
            gap: 15px;
        }
        
        .mobile-toggle {
            display: none;
            font-size: 1.5rem;
            cursor: pointer;
        }

        /* Main Content */
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

        /* Notes Grid */
        .notes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .note-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            cursor: pointer; /* Tunjukkan ia boleh diklik */
        }

        .note-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-hover-shadow);
        }

        .card-header {
            padding: 20px;
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            color: white;
        }

        .card-header h3 {
            font-size: 1.3rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-body {
            padding: 20px;
        }

        .card-body p {
            color: var(--dark-gray);
            margin-bottom: 20px;
            font-size: 0.95rem;
        }

        .card-footer {
            padding: 0 20px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            background-color: var(--primary-color);
            color: white;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn:hover {
            background-color: #1648b5;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: #e55a2b;
        }

        .btn-outline {
            background-color: transparent;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
        }

        .btn-outline:hover {
            background-color: rgba(26, 86, 219, 0.1);
        }

        .note-meta {
            font-size: 0.85rem;
            color: var(--dark-gray);
        }

        /* PDF Viewer Section */
        #pdf-viewer-section {
            display: none; /* Tersembunyi secara default */
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: var(--card-shadow);
            margin-bottom: 40px;
        }

        #pdf-viewer-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--gray-color);
        }

        #pdf-title {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin: 0;
        }

        #pdf-viewer {
            width: 100%;
            height: 70vh; /* Tinggi tetap untuk paparan PDF */
            border: 1px solid var(--gray-color);
        }

        /* Footer - Sama macam project.html */
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

        /* Responsive */
        @media (max-width: 768px) {
            .mobile-toggle {
                display: block;
            }
            
            .auth-buttons {
                display: none; /* Hide on mobile to save space */
            }
            
            .nav-links {
                position: fixed;
                top: 80px;
                right: -100%;
                flex-direction: column;
                background-color: white;
                width: 80%;
                height: calc(100vh - 80px);
                padding: 20px;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
                transition: right 0.3s ease;
                z-index: 99;
                left: auto;
                transform: none;
            }
            
            .nav-links.active {
                right: 0;
            }
            
            .nav-links li {
                margin: 15px 0;
            }
            
            .page-title {
                font-size: 1.8rem;
            }
            
            .notes-grid {
                grid-template-columns: 1fr;
            }
            
            #pdf-viewer {
                height: 50vh; /* Kurangkan tinggi untuk skrin kecil */
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <a href="project.html" class="logo">
                    <i class="fas fa-tools"></i>FixSense
                </a>
                <ul class="nav-links">
                    <li><a href="project.php">Home</a></li>
                    <li><a href="#" onclick="checkAuth('simulationSelection.php')">Simulations</a></li>
                    <li><a href="#" onclick="checkAuth('ai-chatbot.php')">AI Chatbot</a></li>
                    <li><a href="#" onclick="checkAuth('studentPerformance.php')">Performance</a></li>
                    <li><button id="darkModeToggle" class="dark-mode-btn">
                            <i class="fas fa-moon"></i>
                        </button></li>
                </ul>
                <div class="mobile-toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main>
        <div class="container">
            <div class="page-header">
                <h1 class="page-title">Extra Learning Notes</h1>
                <p class="page-subtitle">Supplementary materials to enhance your understanding of automotive troubleshooting concepts.</p>
            </div>

            <!-- PDF Viewer Section -->
            <div id="pdf-viewer-section">
                <div id="pdf-viewer-header">
                    <h2 id="pdf-title">Fundamentals</h2>
                    <div>
                        <a href="#" id="pdf-download-btn" class="btn btn-outline" download><i class="fas fa-download"></i> Download PDF</a>
                        <button id="close-pdf-btn" class="btn btn-secondary"><i class="fas fa-times"></i> Close</button>
                    </div>
                </div>
                <embed id="pdf-viewer" src="" type="application/pdf">
            </div>

            <!-- Notes Grid -->
           <h2 style="text-align: center; margin-bottom: 30px; color: var(--primary-color);">Available Notes</h2>
<div class="notes-grid">
    <?php if (count($notes) > 0): ?>
        <?php foreach ($notes as $note): ?>
        <div class="note-card" data-pdf-src="<?= htmlspecialchars($note['file_path']) ?>" data-title="<?= htmlspecialchars($note['title']) ?>">
            <div class="card-header">
                <h3><i class="fas fa-file-pdf"></i> <?= htmlspecialchars($note['title']) ?></h3>
            </div>
            <div class="card-body">
                <p><?= htmlspecialchars($note['description']) ?></p>
                <div class="note-meta">
                    <i class="fas fa-calendar"></i> <?= htmlspecialchars($note['created_at']) ?><br>
                    <i class="fas fa-file"></i> <?= is_numeric($note['file_size']) ? formatFileSize($note['file_size']) : htmlspecialchars($note['file_size']) ?>
                </div>
            </div>
            <div class="card-footer">
                <a href="<?= htmlspecialchars($note['file_path']) ?>" class="btn btn-outline" download><i class="fas fa-download"></i> Download</a>
                <span class="note-meta">PDF</span>
            </div>
        </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div style="text-align: center; padding: 40px; color: var(--dark-gray); grid-column: 1 / -1;">
            <i class="fas fa-file-pdf" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.5;"></i>
            <h3>No notes available</h3>
            <p>No extra notes have been added to the database yet.</p>
        </div>
    <?php endif; ?>
</div>
            
        </div>
    </main>

    <!-- Footer -->
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
                        <li><a href="project.html">Home</a></li>
                        <li><a href="index.html">Simulations</a></li>
                        <li><a href="#">AI Chatbot</a></li>
                        <li><a href="#">Performance Tracking</a></li>
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
        // Mobile Navigation Toggle - Sama macam project.html
        document.querySelector('.mobile-toggle').addEventListener('click', function() {
            document.querySelector('.nav-links').classList.toggle('active');
        });
        
        // Close mobile menu when clicking a link
        document.querySelectorAll('.nav-links a').forEach(link => {
            link.addEventListener('click', () => {
                document.querySelector('.nav-links').classList.remove('active');
            });
        });

        // --- Bahagian baru untuk paparan PDF ---
        const pdfViewerSection = document.getElementById('pdf-viewer-section');
        const pdfViewer = document.getElementById('pdf-viewer');
        const pdfTitle = document.getElementById('pdf-title');
        const pdfDownloadBtn = document.getElementById('pdf-download-btn');
        const closePdfBtn = document.getElementById('close-pdf-btn');
        const noteCards = document.querySelectorAll('.note-card');

        // Fungsi untuk membuka paparan PDF
        function openPdfViewer(pdfSrc, title) {
            pdfViewer.src = pdfSrc;
            pdfTitle.textContent = title;
            pdfDownloadBtn.href = pdfSrc; // Tetapkan href untuk butang download
            pdfViewerSection.style.display = 'block'; // Tunjukkan bahagian PDF

            // Scroll ke bahagian PDF
            pdfViewerSection.scrollIntoView({ behavior: 'smooth' });
        }

        // Fungsi untuk menutup paparan PDF
        function closePdfViewer() {
            pdfViewerSection.style.display = 'none';
            pdfViewer.src = ''; // Kosongkan sumber untuk memberhentikan pemuatan
        }

        // Tambah event listener ke setiap kad nota
        noteCards.forEach(card => {
            const pdfSrc = card.getAttribute('data-pdf-src');
            const title = card.getAttribute('data-title');

            // Klik pada kad (selain butang download)
            card.addEventListener('click', function(event) {
                // Jika yang diklik bukan butang download, buka PDF
                if (!event.target.closest('.btn-outline')) {
                    openPdfViewer(pdfSrc, title);
                }
                // Jika butang download diklik, biarkan default behaviour (download) berlaku
            });
        });

        // Event listener untuk butang tutup
        closePdfBtn.addEventListener('click', closePdfViewer);

        // Authentication check function
        function checkAuth(targetPage) {
            <?php if (isset($_SESSION['user_id']) || isset($_SESSION['lecturer_id'])): ?>
                // User is logged in, allow access
                window.location.href = targetPage;
            <?php else: ?>
                // User is not logged in, redirect to login
                alert('Please login to access this feature.');
                window.location.href = 'login.php';
            <?php endif; ?>
        }

    </script>
</body>
</html>