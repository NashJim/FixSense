<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'student') {
    header("Location: project.php");
    exit();
}

$pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

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
} //else. letak sini balik nanti

/*
$scenarios = [
    'car_wont_start' => [
        'title' => 'Car Won\'t Start',
        'image' => 'https://images.unsplash.com/photo-1580246814056-ae5492d55c6b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'steps' => [
            [
                'problem' => "You are called to diagnose a vehicle that won’t start. The driver says the key turns, but the engine doesn’t crank at all — no sound, no movement.",
                'question' => "What is the most appropriate first step to take?",
                'options' => [
                    ['text' => 'A) Check the fuel level in the tank.', 'isCorrect' => false],
                    ['text' => 'B) Check the battery voltage and connections.', 'isCorrect' => true],
                    ['text' => 'C) Replace the spark plugs.', 'isCorrect' => false],
                    ['text' => 'D) Check the air filter condition.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>The first thing to check when an engine won’t crank is the battery. Low voltage or loose/corroded terminals can prevent the starter from engaging, as per the Automotive Troubleshooting Manual.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Fuel level, spark plugs, and air filters are irrelevant if the engine isn’t cranking. Always begin with the starting system.'
            ],
            [
                'problem' => "You measure the battery voltage at 10.2V (engine off). Terminals are corroded and loose.",
                'question' => "What should you do next?",
                'options' => [
                    ['text' => 'A) Jump-start the car and send the customer away.', 'isCorrect' => false],
                    ['text' => 'B) Clean terminals, tighten connections, and retest voltage.', 'isCorrect' => true],
                    ['text' => 'C) Replace the alternator immediately.', 'isCorrect' => false],
                    ['text' => 'D) Check engine compression.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>As stated in the manual: “Inspect and clean battery terminals and posts... Be sure cables are in good condition.” Corrosion increases resistance and prevents proper current flow to the starter.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Never jump-start without diagnosing the root cause. A weak battery may indicate a charging issue, but cleaning and testing comes first.'
            ],
            [
                'problem' => "After cleaning and tightening, battery voltage is 12.6V, but the car still won’t crank. You hear a single click from the engine bay when turning the key.",
                'question' => "What is the most likely cause?",
                'options' => [
                    ['text' => 'A) Faulty fuel injector', 'isCorrect' => false],
                    ['text' => 'B) Defective starter solenoid or starter motor', 'isCorrect' => true],
                    ['text' => 'C) Clogged air filter', 'isCorrect' => false],
                    ['text' => 'D) Bad spark plug wires', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A single click typically indicates the starter solenoid is engaging but the motor isn’t turning — a classic sign of starter failure, as described in the Starting System section of the manual.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>These components are part of the fuel/ignition system, which only matter after the engine cranks.'
            ],
            [
                'problem' => "You test the starter control circuit and confirm 12V reaches the solenoid, but the starter motor does not engage.",
                'question' => "What action should be taken?",
                'options' => [
                    ['text' => 'A) Adjust valve clearance', 'isCorrect' => false],
                    ['text' => 'B) Bleed the brake system', 'isCorrect' => false],
                    ['text' => 'C) Replace the starter motor assembly.', 'isCorrect' => true],
                    ['text' => 'D) Rotate the tires', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>With proper voltage at the solenoid and no motor operation, the starter is faulty. Replacement is the correct repair, per standard troubleshooting procedure.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>These actions are unrelated to the starting system. Always follow the diagnostic tree: power → signal → load.'
            ],
            [
                'problem' => "After replacing the starter, the engine cranks strongly but does not start.",
                'question' => "What system should be checked next?",
                'options' => [
                    ['text' => 'A) Ignition system (spark)', 'isCorrect' => true],
                    ['text' => 'B) Tire pressure', 'isCorrect' => false],
                    ['text' => 'C) Windshield washer fluid', 'isCorrect' => false],
                    ['text' => 'D) Air conditioning compressor', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>For an engine to start, it needs fuel, spark, and compression. Since it now cranks, check for spark at the plugs — a core step in ignition system diagnosis per the manual.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>These are maintenance items, not starting-critical systems. Focus on the ignition or fuel system next.'
            ],
            [
                'problem' => "You confirm no spark at the plugs. The ignition coil receives power, but the distributor cap is cracked and damp.",
                'question' => "What should you do?",
                'options' => [
                    ['text' => 'A) Add engine oil', 'isCorrect' => false],
                    ['text' => 'B) Replace distributor cap and rotor.', 'isCorrect' => true],
                    ['text' => 'C) Check the fuse for the brake light circuit', 'isCorrect' => false],
                    ['text' => 'D) Inflate spare tire', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>As noted in the Ignition System section: “Inspect distributor cap and rotor... moisture or cracks can cause misfire or no-start.” Always replace as a set.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>These actions do not address the lack of spark. Moisture in a cracked cap prevents high-voltage delivery.'
            ],
            [
                'problem' => "After replacing the cap and rotor, the engine starts and runs smoothly. The customer asks if anything else should be checked.",
                'question' => "What is the best professional practice now?",
                'options' => [
                    ['text' => 'A) Drive away immediately', 'isCorrect' => false],
                    ['text' => 'B) Record the repair in maintenance history and test-verify operation.', 'isCorrect' => true],
                    ['text' => 'C) Sell the customer new tires', 'isCorrect' => false],
                    ['text' => 'D) Ignore the battery since it worked', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>The Automotive Troubleshooting Manual emphasizes: “Report the repair and update vehicle maintenance records.” This ensures traceability and helps prevent repeat failures.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Professional technicians always document repairs. Also, the weak battery may indicate a deeper charging issue — consider testing the alternator output.'
            ]
        ]
    ],

    'engine_overheating' => [
        'title' => 'Engine Overheating',
        'image' => 'https://images.unsplash.com/photo-1572224076472-7f025e597486?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'steps' => [
            [
                'problem' => "A customer reports their engine temperature gauge is reading hot, and steam is coming from the hood. The engine has been running for 20 minutes in traffic.",
                'question' => "What is the most appropriate first step to take?",
                'options' => [
                    ['text' => 'A) Immediately add coolant to the radiator while engine is running.', 'isCorrect' => false],
                    ['text' => 'B) Turn off the engine and let it cool down before inspecting.', 'isCorrect' => true],
                    ['text' => 'C) Check the air filter for clogging.', 'isCorrect' => false],
                    ['text' => 'D) Replace the thermostat.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Safety first! Never open a hot radiator cap. Let the engine cool to avoid scalding and potential damage. As per the manual: “Check cooling system for leaks after engine cools.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Adding coolant to a hot, pressurized system can cause burns or damage. Always wait for the engine to cool.'
            ],
            [
                'problem' => "After letting the engine cool, you find the coolant reservoir is empty. There are visible wet spots under the car near the radiator.",
                'question' => "What is the next step?",
                'options' => [
                    ['text' => 'A) Top up with water and drive to the shop.', 'isCorrect' => false],
                    ['text' => 'B) Inspect hoses, radiator, and water pump for leaks.', 'isCorrect' => true],
                    ['text' => 'C) Replace the fan belt.', 'isCorrect' => false],
                    ['text' => 'D) Flush the entire cooling system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Visible leaks indicate a physical breach in the system. As per the manual’s checklist: “Inspect radiator, hoses, and water pump for leaks.” Address the leak before refilling.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Topping up without fixing the leak will only provide a temporary fix. Flushing is unnecessary until the leak is repaired.'
            ],
            [
                'problem' => "You locate a small crack in the lower radiator hose. After replacing the hose, you refill the coolant and start the engine. The temperature gauge rises again after 10 minutes.",
                'question' => "What should you check next?",
                'options' => [
                    ['text' => 'A) Check the thermostat for proper operation.', 'isCorrect' => true],
                    ['text' => 'B) Replace the radiator cap.', 'isCorrect' => false],
                    ['text' => 'C) Check the timing belt tension.', 'isCorrect' => false],
                    ['text' => 'D) Install a larger radiator.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A stuck-closed thermostat prevents coolant circulation, causing overheating. As per the manual: “Check thermostat operation during winter checks.” Test by removing and boiling it to see if it opens.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>While a bad radiator cap can cause issues, it usually results in boil-over, not gradual overheating. Timing belts don’t affect cooling.'
            ],
            [
                'problem' => "You remove the thermostat and test it in boiling water. It does not open.",
                'question' => "What action should be taken?",
                'options' => [
                    ['text' => 'A) Clean the thermostat housing.', 'isCorrect' => false],
                    ['text' => 'B) Replace the thermostat.', 'isCorrect' => true],
                    ['text' => 'C) Adjust the fan clutch.', 'isCorrect' => false],
                    ['text' => 'D) Add more coolant.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A thermostat that fails to open must be replaced. As per the manual: “Replace any component that fails its functional test.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Cleaning won’t fix a mechanically failed thermostat. Fan clutch adjustment is for airflow, not coolant flow.'
            ],
            [
                'problem' => "After replacing the thermostat, you run the engine for 20 minutes. The temperature gauge stays in the normal range, but you notice the cooling fan is not turning on.",
                'question' => "What should you check?",
                'options' => [
                    ['text' => 'A) Check the fan relay and fuse.', 'isCorrect' => true],
                    ['text' => 'B) Replace the water pump.', 'isCorrect' => false],
                    ['text' => 'C) Bleed the cooling system.', 'isCorrect' => false],
                    ['text' => 'D) Check the oil level.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>If the fan doesn’t turn on, check electrical components like the relay and fuse. The manual states: “Check fan motor ground and connectors” if the fan doesn’t operate.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>The water pump circulates coolant, but the fan is electrically controlled. Bleeding is for air pockets, not fan operation.'
            ],
            [
                'problem' => "You replace the fan relay and fuse. The fan now turns on when the engine gets warm. You take the car for a test drive.",
                'question' => "What is the final step to ensure the repair is successful?",
                'options' => [
                    ['text' => 'A) Drive on the highway for 30 minutes to verify.', 'isCorrect' => false],
                    ['text' => 'B) Record the repair and update maintenance records.', 'isCorrect' => true],
                    ['text' => 'C) Replace the radiator cap as a precaution.', 'isCorrect' => false],
                    ['text' => 'D) Do nothing; the job is done.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Documenting the repair is essential for future reference and warranty claims. As per the manual: “Record all repairs in the vehicle maintenance log.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Always document repairs. Highway driving is not necessary for verification — a normal city drive suffices.'
            ]
        ]
    ],

    'unusual_engine_noise' => [
        'title' => 'Unusual Engine Noise',
        'image' => 'https://images.unsplash.com/photo-1572224076472-7f025e597486?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'steps' => [
            [
                'problem' => "The customer complains of a loud knocking sound from the engine when accelerating. The noise disappears when idling.",
                'question' => "What is the most likely cause?",
                'options' => [
                    ['text' => 'A) Loose exhaust manifold bolts.', 'isCorrect' => false],
                    ['text' => 'B) Detonation (pinging) due to low-octane fuel or incorrect timing.', 'isCorrect' => true],
                    ['text' => 'C) Worn spark plugs.', 'isCorrect' => false],
                    ['text' => 'D) Low transmission fluid.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Knocking under acceleration is often detonation, caused by low-octane fuel, advanced timing, or carbon buildup. As per the manual: “Detonation can occur if ignition timing is too advanced or fuel octane is too low.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Exhaust leaks cause hissing or popping, not knocking. Spark plugs affect misfires, not knock. Transmission noise is separate.'
            ],
            [
                'problem' => "You check the ignition timing and find it is 5 degrees advanced beyond specification. The customer uses regular unleaded fuel.",
                'question' => "What should you do?",
                'options' => [
                    ['text' => 'A) Advise the customer to use premium fuel.', 'isCorrect' => false],
                    ['text' => 'B) Retard the ignition timing to factory specs.', 'isCorrect' => true],
                    ['text' => 'C) Replace the spark plugs.', 'isCorrect' => false],
                    ['text' => 'D) Install a performance chip.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Advanced timing causes pre-ignition and detonation. Adjusting to factory specifications resolves the issue. The manual states: “Adjust ignition timing to correct value during tune-up.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Using premium fuel is a temporary fix. Replacing plugs won’t fix timing. Performance chips may worsen the problem.'
            ],
            [
                'problem' => "After adjusting the timing, the knocking noise persists. You notice the engine is running hotter than usual.",
                'question' => "What should you check next?",
                'options' => [
                    ['text' => 'A) Check for carbon buildup in the combustion chambers.', 'isCorrect' => true],
                    ['text' => 'B) Replace the oxygen sensor.', 'isCorrect' => false],
                    ['text' => 'C) Check the air filter.', 'isCorrect' => false],
                    ['text' => 'D) Add engine oil.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Carbon buildup increases compression and can cause detonation. As per the manual: “Clean carbon deposits from combustion chambers during major tune-ups.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Oxygen sensors affect emissions, not knock. Air filters affect airflow, not combustion chamber conditions.'
            ],
            [
                'problem' => "You perform a cylinder compression test and find one cylinder has significantly lower compression than the others.",
                'question' => "What is the most likely cause?",
                'options' => [
                    ['text' => 'A) Worn piston rings or valves.', 'isCorrect' => true],
                    ['text' => 'B) Faulty fuel injector.', 'isCorrect' => false],
                    ['text' => 'C) Bad ignition coil.', 'isCorrect' => false],
                    ['text' => 'D) Clogged EGR valve.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Low compression in one cylinder indicates mechanical wear — typically worn rings or valves. The manual states: “Check compression to identify mechanical engine problems.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Fuel injectors and coils cause misfires, not low compression. EGR valves affect emissions, not compression.'
            ],
            [
                'problem' => "You decide to inspect the cylinder head. You find the intake valve is bent and not seating properly.",
                'question' => "What action should be taken?",
                'options' => [
                    ['text' => 'A) Grind the valve face.', 'isCorrect' => false],
                    ['text' => 'B) Replace the damaged valve and recondition the valve seat.', 'isCorrect' => true],
                    ['text' => 'C) Adjust valve clearance.', 'isCorrect' => false],
                    ['text' => 'D) Install a new head gasket.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A bent valve cannot seal properly and must be replaced. As per the manual: “Replace any valve that is bent or burned.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Grinding won’t fix a bent valve. Valve clearance adjustment affects timing, not sealing. Head gaskets are for coolant/oil leaks.'
            ],
            [
                'problem' => "After replacing the valve, you reassemble the engine and start it. The knocking noise is gone, but you hear a faint tapping sound at idle.",
                'question' => "What could this be?",
                'options' => [
                    ['text' => 'A) Hydraulic lifter noise due to low oil pressure or dirty oil.', 'isCorrect' => true],
                    ['text' => 'B) Timing belt slap.', 'isCorrect' => false],
                    ['text' => 'C) Alternator bearing noise.', 'isCorrect' => false],
                    ['text' => 'D) Power steering pump whine.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Hydraulic lifters can make a tapping sound if oil pressure is low or oil is dirty. As per the manual: “Check oil level and viscosity during routine maintenance.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Timing belts make slapping noises, but usually at higher RPMs. Alternator and power steering noises are different in character.'
            ],
            [
                'problem' => "You change the engine oil and filter. The tapping noise disappears. You take the car for a test drive.",
                'question' => "What is the final step?",
                'options' => [
                    ['text' => 'A) Tell the customer to change oil every 3,000 miles.', 'isCorrect' => false],
                    ['text' => 'B) Record the repair and update maintenance records.', 'isCorrect' => true],
                    ['text' => 'C) Recommend a full engine overhaul.', 'isCorrect' => false],
                    ['text' => 'D) Do nothing; the job is done.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Documenting the repair is essential for future reference. As per the manual: “Maintain accurate records of all service performed.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Always document repairs. Recommending an overhaul is premature without further diagnostics.'
            ]
        ]
    ],

    'loss_of_power' => [
        'title' => 'Loss of Power',
        'image' => 'https://images.unsplash.com/photo-1572224076472-7f025e597486?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'steps' => [
            [
                'problem' => "The customer reports the engine feels sluggish and lacks power, especially when accelerating uphill. Fuel economy has also decreased.",
                'question' => "What is the most appropriate first step to take?",
                'options' => [
                    ['text' => 'A) Check the air filter for clogging.', 'isCorrect' => true],
                    ['text' => 'B) Replace the fuel pump.', 'isCorrect' => false],
                    ['text' => 'C) Check the transmission fluid level.', 'isCorrect' => false],
                    ['text' => 'D) Reset the engine computer.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A clogged air filter restricts airflow, causing poor combustion and loss of power. As per the manual: “Check air filter condition during weekly checks.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Replacing the fuel pump is premature. Transmission fluid affects shifting, not engine power. Resetting the computer won’t fix a mechanical issue.'
            ],
            [
                'problem' => "You remove the air filter and find it is heavily clogged with dirt and debris. You replace it with a new one.",
                'question' => "What should you check next?",
                'options' => [
                    ['text' => 'A) Check the fuel pressure.', 'isCorrect' => true],
                    ['text' => 'B) Replace the spark plugs.', 'isCorrect' => false],
                    ['text' => 'C) Check the timing belt.', 'isCorrect' => false],
                    ['text' => 'D) Bleed the brake system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Low fuel pressure can cause loss of power. As per the manual: “Check fuel pump operation if engine lacks power.” Use a fuel pressure gauge to verify.',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Spark plugs affect misfires, not consistent power loss. Timing belts affect timing, not fuel delivery.'
            ],
            [
                'problem' => "You test the fuel pressure and find it is below specification. You suspect the fuel pump.",
                'question' => "What should you do?",
                'options' => [
                    ['text' => 'A) Replace the fuel pump.', 'isCorrect' => false],
                    ['text' => 'B) Check the fuel filter for clogging.', 'isCorrect' => true],
                    ['text' => 'C) Check the ignition coil.', 'isCorrect' => false],
                    ['text' => 'D) Add fuel additive.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A clogged fuel filter can restrict fuel flow and cause low pressure. As per the manual: “Replace fuel filter periodically to prevent clogging.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Replacing the pump without checking the filter is premature. Ignition coils affect spark, not fuel pressure.'
            ],
            [
                'problem' => "You replace the fuel filter. The fuel pressure is now within specification, but the engine still lacks power.",
                'question' => "What should you check next?",
                'options' => [
                    ['text' => 'A) Check the oxygen sensor.', 'isCorrect' => true],
                    ['text' => 'B) Replace the throttle body.', 'isCorrect' => false],
                    ['text' => 'C) Check the PCV valve.', 'isCorrect' => false],
                    ['text' => 'D) Install a performance air intake.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>A faulty oxygen sensor can cause the engine to run rich or lean, leading to power loss. As per the manual: “Check oxygen sensor during emission checks.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Throttle bodies can cause hesitation, not consistent power loss. PCV valves affect emissions, not power directly.'
            ],
            [
                'problem' => "You test the oxygen sensor and find it is faulty. You replace it with a new one.",
                'question' => "What is the next step?",
                'options' => [
                    ['text' => 'A) Clear the trouble codes and test drive.', 'isCorrect' => true],
                    ['text' => 'B) Replace the catalytic converter.', 'isCorrect' => false],
                    ['text' => 'C) Change the engine oil.', 'isCorrect' => false],
                    ['text' => 'D) Install a cold air intake.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>After replacing a sensor, clear any stored trouble codes and test drive to verify the repair. As per the manual: “Clear codes and verify repair during road test.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Replacing the catalytic converter is unnecessary unless it’s clogged. Oil changes and intakes won’t fix a sensor issue.'
            ],
            [
                'problem' => "After clearing codes and test driving, the engine runs smoothly and power is restored. The customer asks what caused the issue.",
                'question' => "What is the best explanation to give?",
                'options' => [
                    ['text' => 'A) The air filter was clogged, and the oxygen sensor was faulty.', 'isCorrect' => true],
                    ['text' => 'B) The engine needed a major overhaul.', 'isCorrect' => false],
                    ['text' => 'C) The transmission was slipping.', 'isCorrect' => false],
                    ['text' => 'D) The battery was weak.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>The root cause was a combination of restricted airflow and incorrect air/fuel mixture due to a faulty sensor. As per the manual: “Address multiple causes systematically.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>An overhaul is unnecessary for this issue. Transmission slipping and weak batteries cause different symptoms.'
            ],
            [
                'problem' => "The customer is satisfied with the repair. What is the final step?",
                'options' => [
                    ['text' => 'A) Record the repair and update maintenance records.', 'isCorrect' => true],
                    ['text' => 'B) Charge extra for diagnostic time.', 'isCorrect' => false],
                    ['text' => 'C) Recommend a tune-up.', 'isCorrect' => false],
                    ['text' => 'D) Do nothing; the job is done.', 'isCorrect' => false]
                ],
                'question' => "What is the best professional practice now?",
                'feedbackCorrect' => '✅ <strong>Correct!</strong><br>Documenting the repair is essential for future reference. As per the manual: “Maintain accurate records of all service performed.”',
                'feedbackIncorrect' => '❌ <strong>Incorrect.</strong><br>Always document repairs. Charging extra for diagnostics is unethical if not agreed upon. Tune-ups are recommended separately.'
            ]
        ]
    ]
];
$scenarioData = $scenarios[$scenarioKey] ?? $scenarios['car_wont_start'];
$steps = json_encode($scenarioData['steps']);
$scenarioId = $scenarioMapping[$scenarioKey] ?? 3.0;
*/
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
        <h2>FixSense - Engine System Troubleshooting</h2>
    </header>

    <div class="container">
        <a href="engine.php" class="btn btn-secondary" style="margin-bottom: 20px; text-decoration: none;">
            ← Back to Engine Problems
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
            <a href="engine.php" class="btn btn-secondary" style="margin-bottom: 20px; text-decoration: none;">
              ← Back to Engine Problems
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