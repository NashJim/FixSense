<?php
// 1. Copy array $scenarios dari simulationBrake.php ke sini
$scenarios = [
    // ───────────────────────────────────────
    // SCENARIO 1: Vehicle Sits Too Low
    // ───────────────────────────────────────
    'air_suspension_low_ride_height' => [
        'title' => 'Vehicle Sits Too Low',
        'image' => 'https://images.unsplash.com/photo-1503376780353-7e6e3d32c6f4?w=900&auto=format&fit=crop',
        'root_cause' => 'Slow air leak in rear air spring (air bag) causing gradual loss of pressure overnight.',
        'solution' => 'Replace leaking air spring and inspect air lines for abrasion.',
        'learning' => 'Air suspension leaks often manifest as low ride height after sitting—always perform an overnight pressure test.',
        'steps' => [
            [
                'problem' => "Customer reports vehicle is noticeably lower on one corner in the morning, but rises after driving.",
                'question' => "What should you do FIRST to verify the customer's concern?",
                'options' => [
                    ['text' => 'A) Replace the air spring immediately', 'isCorrect' => false],
                    ['text' => 'B) Visually inspect the vehicle\'s ride height on level ground', 'isCorrect' => true],
                    ['text' => 'C) Scan for engine fault codes', 'isCorrect' => false],
                    ['text' => 'D) Test the brake pedal', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Always start with a visual inspection to confirm uneven ride height before any diagnostics. Measure from wheel center to fender lip and compare side-to-side for quantitative data.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Visually inspect the vehicle\'s ride height on level ground.<br>Reason: Never replace parts without first confirming the symptom. Start with observation. Engine codes and brake tests won\'t identify air suspension leaks.'
            ],
            [
                'problem' => "Vehicle is 2 inches lower on the left rear. Suspension raises normally when started.",
                'question' => "What should you do NEXT to check for an air leak?",
                'options' => [
                    ['text' => 'A) Measure shock absorber damping force', 'isCorrect' => false],
                    ['text' => 'B) Perform an overnight soapy water test on air springs and lines', 'isCorrect' => true],
                    ['text' => 'C) Check transmission fluid level', 'isCorrect' => false],
                    ['text' => 'D) Replace the compressor relay', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Soapy water creates visible bubbles at leak sites—even tiny pinhole leaks. Apply solution to air springs, fittings, and lines while system is pressurized to identify escape points.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Perform an overnight soapy water test on air springs and lines.<br>Reason: Only a pressure/leak test can confirm an air leak. Other systems are unrelated. Shock measurements and fluid checks won\'t identify air leaks.'
            ],
            [
                'problem' => "Bubbles appear at the bottom crimp of the left rear air spring.",
                'question' => "What should you do NEXT?",
                'options' => [
                    ['text' => 'A) Apply rubber sealant and re-inflate', 'isCorrect' => false],
                    ['text' => 'B) Swap left and right air springs', 'isCorrect' => false],
                    ['text' => 'C) Replace the leaking air spring with a new OEM unit', 'isCorrect' => true],
                    ['text' => 'D) Ignore—it\'s minor', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air springs operate under high pressure and constant flexing—patches fail quickly. Replacement is the only safe fix. Crimp area leaks indicate internal bladder failure that cannot be repaired.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Replace the leaking air spring with a new OEM unit.<br>Reason: Temporary repairs are unsafe and short-lived. Always replace a leaking air spring. Swapping sides just moves the problem.'
            ],
            [
                'problem' => "New air spring installed. System holds pressure overnight.",
                'question' => "What should you do NEXT before returning the vehicle?",
                'options' => [
                    ['text' => 'A) Inspect all air lines for chafing near suspension travel points', 'isCorrect' => true],
                    ['text' => 'B) Top off engine oil', 'isCorrect' => false],
                    ['text' => 'C) Reset the infotainment system', 'isCorrect' => false],
                    ['text' => 'D) Rotate the tires', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air lines often wear at articulation points. Securing them prevents repeat failures. Check where lines pass through body panels and near moving suspension components for abrasion damage.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Inspect all air lines for chafing near suspension travel points.<br>Reason: A complete repair includes checking for other potential failure points. Engine oil and infotainment don\'t affect air suspension reliability.'
            ],
            [
                'problem' => "After repair, ride height is correct but the vehicle feels bouncy on bumps.",
                'question' => "What should you check NEXT?",
                'options' => [
                    ['text' => 'A) Oxygen sensors', 'isCorrect' => false],
                    ['text' => 'B) Fuel injectors', 'isCorrect' => false],
                    ['text' => 'C) Cabin air filter', 'isCorrect' => false],
                    ['text' => 'D) Shock absorbers (dampers)', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air springs control height; shocks control oscillation. Worn dampers cause bounciness even with correct ride height. The air spring replacement may have revealed pre-existing shock wear.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Shock absorbers (dampers).<br>Reason: Ride quality issues after height correction point directly to worn shock absorbers. Engine sensors and filters don\'t affect suspension damping.'
            ],
            [
                'problem' => "Left rear shock is leaking fluid.",
                'question' => "What is the correct service procedure?",
                'options' => [
                    ['text' => 'A) Replace only the leaking shock', 'isCorrect' => false],
                    ['text' => 'B) Replace both rear shocks as a pair', 'isCorrect' => true],
                    ['text' => 'C) Rebuild the shock in-house', 'isCorrect' => false],
                    ['text' => 'D) Tighten the mounting bolts and retest', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Shocks wear evenly. Replacing in pairs ensures balanced handling, braking, and tire wear. Mismatched damping rates create unstable handling characteristics and uneven tire wear patterns.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace both rear shocks as a pair.<br>Reason: Mismatched damping causes instability and uneven tire wear. Single shock replacement creates handling imbalances.'
            ],
            [
                'problem' => "Customer frequently uses 'Off-Road' or 'Lift' mode on highways.",
                'question' => "What advice should you give to extend air suspension life?",
                'options' => [
                    ['text' => 'A) Use lift mode as often as possible', 'isCorrect' => false],
                    ['text' => 'B) Disable the air suspension system', 'isCorrect' => false],
                    ['text' => 'C) Use lift mode only at speeds under 25 mph', 'isCorrect' => true],
                    ['text' => 'D) Drive faster to reduce compressor runtime', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Elevated ride height increases load on air springs and compressor—designed for low-speed use only. High-speed operation in lift mode creates excessive stress that accelerates component failure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Use lift mode only at speeds under 25 mph.<br>Reason: Highway use in lift mode causes excessive stress and premature failure. Disabling the system isn\'t practical, and speed doesn\'t reduce compressor wear.'
            ],
            [
                'problem' => "After repair, system works but displays 'Service Suspension' after 2 days.",
                'question' => "What critical step was likely missed after replacing the air spring?",
                'options' => [
                    ['text' => 'A) Wheel alignment', 'isCorrect' => false],
                    ['text' => 'B) Battery disconnection', 'isCorrect' => false],
                    ['text' => 'C) Tire pressure reset', 'isCorrect' => false],
                    ['text' => 'D) Ride height sensor calibration using a factory scan tool', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The ECU must relearn neutral ride height after component replacement. Without calibration, it detects "incorrect height." Factory scan tools access suspension-specific calibration routines.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Ride height sensor calibration using a factory scan tool.<br>Reason: Physical repair isn\'t enough—electronic relearning is mandatory in modern systems. Alignment and battery resets don\'t address suspension calibration.'
            ],
            [
                'problem' => "Customer reports the same issue returned after 6 months.",
                'question' => "What underlying condition might be causing repeated failures?",
                'options' => [
                    ['text' => 'A) Using premium fuel', 'isCorrect' => false],
                    ['text' => 'B) Frequent car washes', 'isCorrect' => false],
                    ['text' => 'C) Compressor overheating from restricted airflow', 'isCorrect' => true],
                    ['text' => 'D) Proper tire inflation', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Compressors mounted in enclosed areas can overheat if airflow is blocked by debris. Overheating causes premature seal failure and repeated air spring damage from excessive cycling.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Compressor overheating from restricted airflow.<br>Reason: Repeated failures suggest systemic issues. Fuel quality and washing don\'t affect air suspension components.'
            ],
            [
                'problem' => "All repairs completed successfully.",
                'question' => "What final verification ensures long-term reliability?",
                'options' => [
                    ['text' => 'A) Check engine oil level only', 'isCorrect' => false],
                    ['text' => 'B) Verify radio operation', 'isCorrect' => false],
                    ['text' => 'C) Inspect windshield wipers', 'isCorrect' => false],
                    ['text' => 'D) Extended test drive with multiple height adjustments', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Comprehensive testing validates repairs under real-world conditions. Test all height modes, check for leaks during operation, and verify system stability during various driving scenarios.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Extended test drive with multiple height adjustments.<br>Reason: Only dynamic testing confirms complete system functionality. Static inspections miss operational issues.'
            ]
        ]
    ],

    // ───────────────────────────────────────
    // SCENARIO 2: Won't Raise or Level
    // ───────────────────────────────────────
    'air_suspension_no_raise' => [
        'title' => 'Won\'t Raise or Level',
        'image' => 'https://images.unsplash.com/photo-1542362567-b07e54358753?w=900&auto=format&fit=crop',
        'root_cause' => 'Failed air suspension compressor due to seized motor from moisture ingress.',
        'solution' => 'Replace compressor assembly and check air dryer condition.',
        'learning' => 'Compressors fail when the air dryer is saturated—always inspect/replace the dryer during compressor replacement.',
        'steps' => [
            [
                'problem' => "Vehicle remains low after startup. No attempt to raise. No warning lights.",
                'question' => "What should you do FIRST?",
                'options' => [
                    ['text' => 'A) Replace the air springs', 'isCorrect' => false],
                    ['text' => 'B) Check engine oil level', 'isCorrect' => false],
                    ['text' => 'C) Listen for compressor operation during startup', 'isCorrect' => true],
                    ['text' => 'D) Scan for ABS codes', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>If the compressor doesn\'t run, the system can\'t build pressure. Audible confirmation is the fastest initial check. Listen near the compressor location for motor sounds during ignition-on height correction.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Listen for compressor operation during startup.<br>Reason: Always verify if the actuator (compressor) is even trying to work before deeper diagnostics. Air spring replacement won\'t help if no air is being supplied.'
            ],
            [
                'problem' => "No sound from compressor. Scan tool shows no faults. Height sensors read correctly.",
                'question' => "What should you do NEXT to isolate the issue?",
                'options' => [
                    ['text' => 'A) Check voltage at the compressor connector while commanding a raise', 'isCorrect' => true],
                    ['text' => 'B) Replace the compressor immediately', 'isCorrect' => false],
                    ['text' => 'C) Bleed the brake system', 'isCorrect' => false],
                    ['text' => 'D) Refill coolant', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Measuring voltage confirms if the problem is electrical (relay, fuse, wiring) or mechanical (compressor failure). Use a multimeter to verify 12V+ at the compressor connector during activation commands.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check voltage at the compressor connector while commanding a raise.<br>Reason: Never replace expensive parts without verifying power delivery first. Brake and coolant systems are unrelated to air suspension operation.'
            ],
            [
                'problem' => "12V present at compressor, but it doesn't run or make noise.",
                'question' => "What does this indicate?",
                'options' => [
                    ['text' => 'A) Air tank is over-pressurized', 'isCorrect' => false],
                    ['text' => 'B) Compressor motor is seized or electrically open', 'isCorrect' => true],
                    ['text' => 'C) Battery needs replacement', 'isCorrect' => false],
                    ['text' => 'D) Height sensor is miscalibrated', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Power is present, but no operation = internal compressor failure—often due to moisture-induced corrosion. The motor windings may be open or the mechanical components seized from lack of maintenance.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Compressor motor is seized or electrically open.<br>Reason: When power is confirmed, the fault lies in the load (compressor), not the control circuit. Height sensors wouldn\'t prevent compressor operation.'
            ],
            [
                'problem' => "Compressor removed. Shaft is seized and won't turn by hand.",
                'question' => "What maintenance item likely contributed to this failure?",
                'options' => [
                    ['text' => 'A) Old engine air filter', 'isCorrect' => false],
                    ['text' => 'B) Infrequent tire rotation', 'isCorrect' => false],
                    ['text' => 'C) Saturated air dryer that failed to remove moisture', 'isCorrect' => true],
                    ['text' => 'D) Using ethanol-blended fuel', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The air dryer absorbs moisture from compressed air. When saturated, water enters the system, causing rust and seizure. The desiccant material has limited capacity and requires periodic replacement.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Saturated air dryer that failed to remove moisture.<br>Reason: Dryers are service items—often ignored until compressor failure occurs. Engine filters and fuel type don\'t affect air compressor operation.'
            ],
            [
                'problem' => "New compressor installed.",
                'question' => "What should you ALWAYS do at the same time?",
                'options' => [
                    ['text' => 'A) Flush the coolant system', 'isCorrect' => false],
                    ['text' => 'B) Change spark plugs', 'isCorrect' => false],
                    ['text' => 'C) Reset the radio code', 'isCorrect' => false],
                    ['text' => 'D) Replace the air dryer', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>OEMs require dryer replacement with compressor to prevent recurrence. It\'s a critical preventive step. The old dryer contains moisture that would immediately contaminate the new compressor.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Replace the air dryer.<br>Reason: A new compressor with an old dryer = repeat failure within months. Other maintenance items don\'t affect air suspension reliability.'
            ],
            [
                'problem' => "After replacement, compressor cycles every 10 minutes while parked.",
                'question' => "What should you investigate NEXT?",
                'options' => [
                    ['text' => 'A) Replace the battery', 'isCorrect' => false],
                    ['text' => 'B) Check for air leaks using soapy water', 'isCorrect' => true],
                    ['text' => 'C) Update navigation software', 'isCorrect' => false],
                    ['text' => 'D) Adjust headlight aim', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Frequent cycling indicates air loss. The compressor is compensating for a leak somewhere in the system. Normal systems hold pressure for days—frequent activation means air is escaping.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check for air leaks using soapy water.<br>Reason: Normal systems hold pressure for days—not minutes. Cycling = leak. Battery and software issues don\'t cause compressor cycling.'
            ],
            [
                'problem' => "No leaks found. System holds pressure for 24 hours.",
                'question' => "What electronic component could falsely trigger compressor cycling?",
                'options' => [
                    ['text' => 'A) Faulty ride height or pressure sensor', 'isCorrect' => true],
                    ['text' => 'B) Dirty MAF sensor', 'isCorrect' => false],
                    ['text' => 'C) Weak alternator', 'isCorrect' => false],
                    ['text' => 'D) Clogged fuel filter', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>A faulty sensor may report low pressure incorrectly, causing unnecessary compressor activation. Use scan tool data to compare sensor readings with actual system pressure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Faulty ride height or pressure sensor.<br>Reason: Always verify sensor data with a scan tool before condemning hardware. MAF and fuel systems don\'t interact with air suspension.'
            ],
            [
                'problem' => "After repair, system works but displays 'Service Suspension' after 2 days.",
                'question' => "What post-repair step ensures long-term reliability?",
                'options' => [
                    ['text' => 'A) Replace all four tires', 'isCorrect' => false],
                    ['text' => 'B) Perform ride height sensor calibration with a scan tool', 'isCorrect' => true],
                    ['text' => 'C) Clean the throttle body', 'isCorrect' => false],
                    ['text' => 'D) Reset the clock', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Calibration allows the ECU to learn the new neutral position. Skipping it causes false error codes. Factory scan tools access manufacturer-specific calibration routines.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Perform ride height sensor calibration with a scan tool.<br>Reason: Modern suspensions are software-dependent—calibration is non-optional. Tire replacement and throttle cleaning don\'t affect suspension calibration.'
            ],
            [
                'problem' => "Customer wants to prevent future compressor failures.",
                'question' => "What maintenance schedule should you recommend?",
                'options' => [
                    ['text' => 'A) Compressor replacement every year', 'isCorrect' => false],
                    ['text' => 'B) Monthly system fluid changes', 'isCorrect' => false],
                    ['text' => 'C) Air dryer replacement every 3-5 years or 50,000 miles', 'isCorrect' => true],
                    ['text' => 'D) Weekly air spring inspection', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Preventive dryer replacement removes moisture before it damages the compressor. This simple maintenance extends compressor life significantly and is much cheaper than compressor replacement.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Air dryer replacement every 3-5 years or 50,000 miles.<br>Reason: Proactive maintenance prevents failures. Excessive replacement schedules waste money and aren\'t necessary.'
            ],
            [
                'problem' => "All systems functioning correctly.",
                'question' => "What customer education prevents unnecessary service visits?",
                'options' => [
                    ['text' => 'A) Recommend weekly compressor replacement', 'isCorrect' => false],
                    ['text' => 'B) Explain normal compressor operation sounds', 'isCorrect' => true],
                    ['text' => 'C) Suggest ignoring all suspension noises', 'isCorrect' => false],
                    ['text' => 'D) Advise disabling the system permanently', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Educate customers about normal compressor sounds (moderate humming during height adjustment) versus abnormal noises (grinding, excessive vibration). This prevents unnecessary concern about normal operation.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Explain normal compressor operation sounds.<br>Reason: Customer education prevents unnecessary returns. Excessive maintenance or system disabling isn\'t practical.'
            ]
        ]
    ],

    // ───────────────────────────────────────
    // SCENARIO 3: Noisy Air Compressor
    // ───────────────────────────────────────
    'air_suspension_noisy_compressor' => [
        'title' => 'Noisy Air Compressor',
        'image' => 'https://images.unsplash.com/photo-1605733513597-a8f8341084e6?w=900&auto=format&fit=crop',
        'root_cause' => 'Worn compressor motor bearings and degraded internal seals causing grinding and whining noises.',
        'solution' => 'Replace compressor assembly and air dryer.',
        'learning' => 'Compressor noise often precedes complete failure—address it early to avoid being stranded with a collapsed suspension.',
        'steps' => [
            [
                'problem' => "Loud grinding/whining noise from front wheel well when vehicle starts to raise.",
                'question' => "What should you do FIRST to confirm the source?",
                'options' => [
                    ['text' => 'A) Replace the AC compressor', 'isCorrect' => false],
                    ['text' => 'B) Check power steering fluid', 'isCorrect' => false],
                    ['text' => 'C) Test alternator output', 'isCorrect' => false],
                    ['text' => 'D) Command a suspension raise and listen near the compressor', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Correlating noise with compressor activation confirms the source. Location + timing = diagnosis. Use the vehicle\'s height controls to activate the compressor while listening at the source.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Command a suspension raise and listen near the compressor.<br>Reason: Don\'t guess—verify by reproducing the symptom under controlled conditions. AC and power steering operate independently of suspension commands.'
            ],
            [
                'problem' => "Noise occurs ONLY during inflation, not while driving.",
                'question' => "What does this tell you about the fault?",
                'options' => [
                    ['text' => 'A) It could be the AC compressor', 'isCorrect' => false],
                    ['text' => 'B) The noise is definitely from the air suspension compressor', 'isCorrect' => true],
                    ['text' => 'C) Power steering pump is failing', 'isCorrect' => false],
                    ['text' => 'D) Engine bearings are worn', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>System-specific operation isolates the fault. Only the air compressor runs during height adjustment. Other components operate continuously or under different conditions.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) The noise is definitely from the air suspension compressor.<br>Reason: Timing eliminates other rotating components—this is diagnostic logic. AC and power steering operate during different vehicle states.'
            ],
            [
                'problem' => "Compressor runs longer than usual and sounds labored.",
                'question' => "What underlying condition could be overworking the compressor?",
                'options' => [
                    ['text' => 'A) High outside temperature', 'isCorrect' => false],
                    ['text' => 'B) New set of alloy wheels', 'isCorrect' => false],
                    ['text' => 'C) Undetected air leak in the system', 'isCorrect' => true],
                    ['text' => 'D) Full windshield washer reservoir', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>An air leak forces the compressor to run continuously to maintain pressure, accelerating internal wear. Extended run times indicate the compressor is struggling to reach target pressure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Undetected air leak in the system.<br>Reason: Overwork leads to premature bearing and seal failure—always check for leaks first. Temperature and wheels don\'t affect compressor workload.'
            ],
            [
                'problem' => "Soapy water test reveals a small leak at an air line fitting.",
                'question' => "Should you still replace the noisy compressor?",
                'options' => [
                    ['text' => 'A) No—fix the leak and the noise will stop', 'isCorrect' => false],
                    ['text' => 'B) Yes—noise indicates irreversible internal damage', 'isCorrect' => true],
                    ['text' => 'C) Only if the customer agrees to extra cost', 'isCorrect' => false],
                    ['text' => 'D) Wait until it stops working completely', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Grinding/whining means bearings or seals are worn. Fixing the leak won\'t restore mechanical integrity. The compressor has already suffered internal damage from overwork.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Yes—noise indicates irreversible internal damage.<br>Reason: Noise = symptom of internal wear, not just workload. The compressor is already failing. Waiting for complete failure risks being stranded.'
            ],
            [
                'problem' => "New compressor and dryer installed.",
                'question' => "What maintenance schedule should you recommend to the customer?",
                'options' => [
                    ['text' => 'A) Replace the air dryer every 50,000 miles or 4 years', 'isCorrect' => true],
                    ['text' => 'B) Never service the air suspension', 'isCorrect' => false],
                    ['text' => 'C) Use lift mode daily', 'isCorrect' => false],
                    ['text' => 'D) Avoid washing the undercarriage', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Proactive dryer replacement removes moisture before it damages the compressor—extending system life. This preventive maintenance is much cheaper than compressor replacement.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace the air dryer every 50,000 miles or 4 years.<br>Reason: Preventive maintenance avoids $600+ repairs later. Dryers are not "lifetime" parts. Regular washing actually helps prevent corrosion.'
            ],
            [
                'problem' => "After 1 week, noise returns.",
                'question' => "What should you verify FIRST?",
                'options' => [
                    ['text' => 'A) Engine oil viscosity', 'isCorrect' => false],
                    ['text' => 'B) Tire pressure monitoring system', 'isCorrect' => false],
                    ['text' => 'C) Headlight bulb type', 'isCorrect' => false],
                    ['text' => 'D) Correct compressor part number and proper mounting', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Aftermarket compressors may be low quality. Also, missing isolators or loose mounts cause vibration/noise. Verify the compressor matches OEM specifications and all mounting hardware is properly installed.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Correct compressor part number and proper mounting.<br>Reason: Recurrence often points to incorrect part or poor installation—not a new failure. Engine oil and lighting don\'t affect compressor operation.'
            ],
            [
                'problem' => "After repair, system works but displays 'Service Suspension' after 2 days.",
                'question' => "What step ensures the ECU recognizes the new hardware?",
                'options' => [
                    ['text' => 'A) Disconnect the battery for 10 minutes', 'isCorrect' => false],
                    ['text' => 'B) Drive at highway speed for 30 minutes', 'isCorrect' => false],
                    ['text' => 'C) Replace the key fob battery', 'isCorrect' => false],
                    ['text' => 'D) Perform ride height sensor calibration with a scan tool', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Calibration is required after replacing suspension components so the ECU learns the new baseline. Factory scan tools access manufacturer-specific calibration routines that reset adaptation values.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Perform ride height sensor calibration with a scan tool.<br>Reason: The system won\'t "trust" new parts without electronic relearning—battery reset won\'t help. Driving alone doesn\'t trigger calibration routines.'
            ],
            [
                'problem' => "Compressor makes clicking sounds during operation.",
                'question' => "What does this specific noise indicate?",
                'options' => [
                    ['text' => 'A) Normal compressor operation', 'isCorrect' => false],
                    ['text' => 'B) Worn piston rings or valve mechanism', 'isCorrect' => true],
                    ['text' => 'C) Loose electrical connection', 'isCorrect' => false],
                    ['text' => 'D) Air in the power steering system', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Clicking or tapping noises during compression indicate internal mechanical wear. The piston, connecting rod, or valve mechanism has excessive clearance, creating the audible clicking sound.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Worn piston rings or valve mechanism.<br>Reason: Specific noise patterns indicate specific failures. Electrical issues cause different symptoms, and power steering is separate.'
            ],
            [
                'problem' => "Customer reports compressor runs frequently in hot weather.",
                'question' => "What is the likely cause?",
                'options' => [
                    ['text' => 'A) Normal thermal expansion of air in the system', 'isCorrect' => true],
                    ['text' => 'B) Failing air temperature sensor', 'isCorrect' => false],
                    ['text' => 'C) Wrong type of compressor oil', 'isCorrect' => false],
                    ['text' => 'D) Overfilled windshield washer fluid', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air expands when heated, increasing system pressure. The ECU may vent excess pressure, then the compressor runs to restore proper level. This is normal operation in extreme temperatures.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Normal thermal expansion of air in the system.<br>Reason: Physics explains this behavior—air expands when heated. Temperature sensors monitor ambient air, not system pressure.'
            ],
            [
                'problem' => "All repairs completed successfully.",
                'question' => "What final verification ensures customer satisfaction?",
                'options' => [
                    ['text' => 'A) Check engine oil only', 'isCorrect' => false],
                    ['text' => 'B) Verify radio presets', 'isCorrect' => false],
                    ['text' => 'C) Inspect wiper blades', 'isCorrect' => false],
                    ['text' => 'D) Demonstrate proper operation and explain normal sounds', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Customer education prevents unnecessary returns. Demonstrate the repair, show normal operation sounds, and explain what to expect during different driving conditions.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Demonstrate proper operation and explain normal sounds.<br>Reason: Comprehensive verification includes customer education. Basic maintenance checks don\'t validate the specific repair.'
            ]
        ]
    ],

    // ───────────────────────────────────────
    // SCENARIO 4: Hissing Sound / Air Leak
    // ───────────────────────────────────────
    'air_suspension_leaking_air' => [
        'title' => 'Hissing Sound / Air Leak',
        'image' => 'https://images.unsplash.com/photo-1542362567-b07e54358753?w=900&auto=format&fit=crop',
        'root_cause' => 'Cracked air line at suspension articulation point due to repeated flexing and UV degradation.',
        'solution' => 'Replace damaged air line section and secure with protective loom.',
        'learning' => 'Air lines fail at high-movement areas—always inspect routing and use protective sleeves during repair.',
        'steps' => [
            [
                'problem' => "Audible hissing sound from under the vehicle, especially when parked.",
                'question' => "What should you do FIRST?",
                'options' => [
                    ['text' => 'A) Replace all air springs', 'isCorrect' => false],
                    ['text' => 'B) Spray soapy water along all air lines and fittings', 'isCorrect' => true],
                    ['text' => 'C) Check exhaust manifold for cracks', 'isCorrect' => false],
                    ['text' => 'D) Refill transmission fluid', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Soapy water is the fastest, safest way to pinpoint high-pressure air leaks. Bubbles form instantly at the leak site. Systematically check all lines, fittings, and air spring surfaces.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Spray soapy water along all air lines and fittings.<br>Reason: Never guess—use a proven diagnostic method. Exhaust or fluid leaks sound different and won\'t create bubbles with soapy water.'
            ],
            [
                'problem' => "Bubbles form at a kinked section of air line near the left front control arm.",
                'question' => "What is the correct repair procedure?",
                'options' => [
                    ['text' => 'A) Wrap with electrical tape', 'isCorrect' => false],
                    ['text' => 'B) Apply silicone sealant', 'isCorrect' => false],
                    ['text' => 'C) Cut out damaged section and install new OEM air line with proper fittings', 'isCorrect' => true],
                    ['text' => 'D) Tighten the fitting with a pipe wrench', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air lines must withstand 150+ PSI and constant flexing. Only OEM-spec replacement ensures safety and durability. Use proper flare tools and compression fittings designed for air suspension systems.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Cut out damaged section and install new OEM air line with proper fittings.<br>Reason: Temporary fixes fail catastrophically under pressure. Never use tape or sealant on air lines. Over-tightening damages fittings.'
            ],
            [
                'problem' => "New line installed.",
                'question' => "What should you add to prevent future failure at this location?",
                'options' => [
                    ['text' => 'A) Install split loom or rubber grommet where the line contacts metal', 'isCorrect' => true],
                    ['text' => 'B) Paint the line black', 'isCorrect' => false],
                    ['text' => 'C) Apply heat wrap', 'isCorrect' => false],
                    ['text' => 'D) Nothing—OEM didn\'t use protection', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Protective sleeves prevent abrasion at high-movement points. Many modern vehicles include them from the factory. Use UV-resistant loom material that withstands environmental exposure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Install split loom or rubber grommet where the line contacts metal.<br>Reason: Prevention is part of a complete, professional repair—not an afterthought. Painting and heat wrap don\'t prevent abrasion.'
            ],
            [
                'problem' => "After repair, compressor runs frequently while parked.",
                'question' => "What should you do NEXT?",
                'options' => [
                    ['text' => 'A) Replace the battery', 'isCorrect' => false],
                    ['text' => 'B) Update the vehicle software', 'isCorrect' => false],
                    ['text' => 'C) Perform a full-system soapy water test again', 'isCorrect' => true],
                    ['text' => 'D) Adjust the parking brake', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Vehicles often have multiple leaks. Always retest the entire system after any repair. One leak found ≠ only leak present. Frequent cycling means more air loss somewhere.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Perform a full-system soapy water test again.<br>Reason: Multiple leaks are common in aging systems. Battery and software issues don\'t cause compressor cycling.'
            ],
            [
                'problem' => "Second leak found at rear air spring fitting.",
                'question' => "How should you properly seal the fitting during reassembly?",
                'options' => [
                    ['text' => 'A) Use Teflon tape on all threads', 'isCorrect' => false],
                    ['text' => 'B) Hand-tighten only', 'isCorrect' => false],
                    ['text' => 'C) Overtighten to prevent leaks', 'isCorrect' => false],
                    ['text' => 'D) Use thread sealant rated for air systems and torque to specification', 'isCorrect' => true],
                ],
                'feedbackCorrect' => '✅ Correct!<br>Many air fittings use O-rings or metal seals. Teflon tape can block ports or cause leaks. Use manufacturer-specified sealants and follow torque specifications to avoid damaging components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Use thread sealant rated for air systems and torque to specification.<br>Reason: Proper sealing technique prevents recurrence and avoids thread damage. Teflon tape shreds can clog small passages.'
            ],
            [
                'problem' => "After all repairs, system holds pressure for 48 hours.",
                'question' => "What final step ensures the system operates correctly long-term?",
                'options' => [
                    ['text' => 'A) Perform ride height sensor calibration with a scan tool', 'isCorrect' => true],
                    ['text' => 'B) Replace the cabin air filter', 'isCorrect' => false],
                    ['text' => 'C) Reset the trip odometer', 'isCorrect' => false],
                    ['text' => 'D) Wash the engine bay', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Even if height looks correct, the ECU may still detect "drift" without calibration—triggering warning lights later. Factory scan tools access manufacturer-specific calibration routines.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Perform ride height sensor calibration with a scan tool.<br>Reason: Electronic systems require validation—not just mechanical repair. Calibration is essential. Cabin filters and odometers don\'t affect suspension operation.'
            ],
            [
                'problem' => "Customer reports hissing returns after driving over rough roads.",
                'question' => "What does this indicate about the repair?",
                'options' => [
                    ['text' => 'A) Normal operation', 'isCorrect' => false],
                    ['text' => 'B) Compressor failure', 'isCorrect' => false],
                    ['text' => 'C) Fitting loosened from vibration', 'isCorrect' => true],
                    ['text' => 'D) Tire pressure issue', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Vibration-specific leaks indicate loose fittings or inadequate strain relief. Road vibrations can loosen improperly torqued connections or cause unprotected lines to chafe against components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Fitting loosened from vibration.<br>Reason: Vibration patterns point to mechanical issues. Normal operation doesn\'t create hissing, and compressors don\'t cause specific road-condition leaks.'
            ],
            [
                'problem' => "Multiple leaks found throughout the system.",
                'question' => "What systemic issue might be causing widespread failures?",
                'options' => [
                    ['text' => 'A) UV degradation from sun exposure', 'isCorrect' => true],
                    ['text' => 'B) Using premium fuel', 'isCorrect' => false],
                    ['text' => 'C) Frequent car washes', 'isCorrect' => false],
                    ['text' => 'D) Proper maintenance', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>UV radiation breaks down rubber and plastic components over time. Multiple simultaneous failures suggest systemic aging rather than isolated incidents. This is common in vehicles with high sun exposure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) UV degradation from sun exposure.<br>Reason: Environmental factors cause widespread component aging. Fuel quality and washing don\'t affect air line integrity.'
            ],
            [
                'problem' => "All leaks repaired, system holding pressure.",
                'question' => "What preventive maintenance should you recommend?",
                'options' => [
                    ['text' => 'A) Monthly line replacement', 'isCorrect' => false],
                    ['text' => 'B) Annual visual inspection of all air lines and fittings', 'isCorrect' => true],
                    ['text' => 'C) Weekly pressure testing', 'isCorrect' => false],
                    ['text' => 'D) Daily compressor operation checks', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Annual inspections catch developing issues before they cause failures. Visual checks during routine maintenance identify worn protection, loose fittings, and early signs of degradation.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Annual visual inspection of all air lines and fittings.<br>Reason: Preventive inspection is practical and effective. Excessive maintenance schedules waste resources.'
            ],
            [
                'problem' => "Customer wants to understand why air lines fail.",
                'question' => "What are the primary failure mechanisms?",
                'options' => [
                    ['text' => 'A) Electrical surges', 'isCorrect' => false],
                    ['text' => 'B) Wrong fuel type', 'isCorrect' => false],
                    ['text' => 'C) Software glitches', 'isCorrect' => false],
                    ['text' => 'D) UV degradation, abrasion, and fatigue from flexing', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air lines fail from environmental exposure (UV), physical damage (abrasion), and mechanical stress (flex fatigue). Understanding these mechanisms helps customers recognize early warning signs.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) UV degradation, abrasion, and fatigue from flexing.<br>Reason: Physical and environmental factors cause air line failures. Electrical and software issues affect different systems.'
            ]
        ]
    ],

    // ───────────────────────────────────────
    // SCENARIO 5: Intermittent Height Fluctuations
    // ───────────────────────────────────────
    'air_suspension_height_fluctuations' => [
        'title' => 'Intermittent Height Fluctuations',
        'image' => 'https://images.unsplash.com/photo-1564053489984-317bbd824340?w=900&auto=format&fit=crop',
        'root_cause' => 'Failing ride height sensors providing inconsistent readings to the suspension control module.',
        'solution' => 'Replace faulty height sensors and perform system calibration.',
        'learning' => 'Height sensors are the eyes of the air suspension system—their failure causes erratic behavior that mimics mechanical issues.',
        'steps' => [
            [
                'problem' => "Vehicle height changes randomly while driving, with no pattern to the fluctuations.",
                'question' => "What should you check FIRST?",
                'options' => [
                    ['text' => 'A) Ride height sensor readings with a scan tool', 'isCorrect' => true],
                    ['text' => 'B) Replace all air springs immediately', 'isCorrect' => false],
                    ['text' => 'C) Check engine coolant temperature', 'isCorrect' => false],
                    ['text' => 'D) Test alternator output', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Monitor live sensor data while reproducing the symptom. Erratic height changes with stable mechanical components point to sensor or electrical issues rather than air leaks.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Ride height sensor readings with a scan tool.<br>Reason: Always verify electronic inputs before condemning mechanical components. Coolant and charging systems don\'t affect suspension height.'
            ],
            [
                'problem' => "Scan tool shows front left sensor reading fluctuates wildly while other sensors are stable.",
                'question' => "What does this indicate?",
                'options' => [
                    ['text' => 'A) Normal sensor operation', 'isCorrect' => false],
                    ['text' => 'B) Faulty sensor or damaged wiring', 'isCorrect' => true],
                    ['text' => 'C) Compressor overload', 'isCorrect' => false],
                    ['text' => 'D) Low system voltage', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Single sensor instability indicates component-specific failure. The erratic signal causes the ECU to make incorrect height adjustments, creating the fluctuation symptom.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Faulty sensor or damaged wiring.<br>Reason: Isolated sensor issues point to component failure. System-wide problems would affect multiple sensors simultaneously.'
            ],
            [
                'problem' => "Sensor linkage is loose and wobbles in its mount.",
                'question' => "How does this cause height fluctuations?",
                'options' => [
                    ['text' => 'A) Improves system accuracy', 'isCorrect' => false],
                    ['text' => 'B) Reduces compressor workload', 'isCorrect' => false],
                    ['text' => 'C) Increases fuel economy', 'isCorrect' => false],
                    ['text' => 'D) Creates false height readings that trigger constant corrections', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Loose linkages allow the sensor arm to move independently of the suspension, sending false position data. The ECU constantly corrects for these erroneous readings, creating the fluctuation cycle.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Creates false height readings that trigger constant corrections.<br>Reason: Mechanical play in sensor linkages directly causes inaccurate measurements. This doesn\'t improve any system functions.'
            ],
            [
                'problem' => "New sensor installed with proper linkage connection.",
                'question' => "What critical step must follow hardware replacement?",
                'options' => [
                    ['text' => 'A) Tire rotation', 'isCorrect' => false],
                    ['text' => 'B) System calibration using factory scan tool', 'isCorrect' => true],
                    ['text' => 'C) Engine oil change', 'isCorrect' => false],
                    ['text' => 'D) Fuel system cleaning', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The ECU must learn the new sensor\'s range and neutral position. Factory scan tools access manufacturer-specific calibration routines that teach the system the correct height parameters.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) System calibration using factory scan tool.<br>Reason: Sensor replacement requires electronic calibration. Mechanical maintenance doesn\'t affect suspension calibration.'
            ],
            [
                'problem' => "After calibration, fluctuations continue but are less severe.",
                'question' => "What should you investigate NEXT?",
                'options' => [
                    ['text' => 'A) Replace the compressor', 'isCorrect' => false],
                    ['text' => 'B) Install larger air springs', 'isCorrect' => false],
                    ['text' => 'C) Check sensor wiring for intermittent connections', 'isCorrect' => true],
                    ['text' => 'D) Adjust tire pressure', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Intermittent wiring issues can cause similar symptoms to sensor failures. Check for corroded connectors, damaged insulation, or loose terminals in the sensor circuit.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Check sensor wiring for intermittent connections.<br>Reason: Continued issues after sensor replacement suggest wiring problems. Compressor and air spring changes won\'t fix electrical issues.'
            ],
            [
                'problem' => "Wiring harness shows chafing where it passes through body panel.",
                'question' => "What is the proper repair method?",
                'options' => [
                    ['text' => 'A) Wrap with electrical tape only', 'isCorrect' => false],
                    ['text' => 'B) Disconnect the sensor', 'isCorrect' => false],
                    ['text' => 'C) Ignore the damage', 'isCorrect' => false],
                    ['text' => 'D) Repair wires and add protective conduit', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Proper wire repair includes soldering or crimping with heat shrink, then installing protective conduit to prevent recurrence. Route the harness away from sharp edges and moving components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Repair wires and add protective conduit.<br>Reason: Temporary fixes lead to repeat failures. Professional repairs address both the damage and the cause.'
            ],
            [
                'problem' => "All repairs completed, but system still shows occasional errors.",
                'question' => "What might be causing persistent issues?",
                'options' => [
                    ['text' => 'A) Wrong engine oil weight', 'isCorrect' => false],
                    ['text' => 'B) Dirty cabin air filter', 'isCorrect' => false],
                    ['text' => 'C) Suspension control module adaptation needs reset', 'isCorrect' => true],
                    ['text' => 'D) Low windshield washer fluid', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The control module may have learned incorrect adaptation values from the faulty sensor. Factory scan tools can reset adaptation data and allow the system to relearn from scratch.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Suspension control module adaptation needs reset.<br>Reason: Electronic systems store learned behaviors that may need clearing. Maintenance items don\'t affect suspension electronics.'
            ],
            [
                'problem' => "Customer reports fluctuations only occur in specific weather conditions.",
                'question' => "What environmental factor might affect sensor operation?",
                'options' => [
                    ['text' => 'A) Moisture ingress in electrical connectors', 'isCorrect' => true],
                    ['text' => 'B) Air temperature affecting tire pressure', 'isCorrect' => false],
                    ['text' => 'C) Sun angle on the dashboard', 'isCorrect' => false],
                    ['text' => 'D) Wind speed during driving', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Moisture in electrical connectors can create intermittent circuits that fail under specific humidity or temperature conditions. Dielectric grease and proper sealing prevent this issue.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Moisture ingress in electrical connectors.<br>Reason: Weather-dependent electrical issues point to connector problems. Tire pressure changes affect ride height but not fluctuations.'
            ],
            [
                'problem' => "Multiple sensors show correlated fluctuation patterns.",
                'question' => "What does this suggest about the problem?",
                'options' => [
                    ['text' => 'A) Normal system operation', 'isCorrect' => false],
                    ['text' => 'B) Common power or ground issue affecting multiple sensors', 'isCorrect' => true],
                    ['text' => 'C) Compressor performance issue', 'isCorrect' => false],
                    ['text' => 'D) Air spring failure', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Correlated sensor issues suggest shared electrical infrastructure problems. Check common power supplies, ground points, and data bus connections that serve multiple sensors.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Common power or ground issue affecting multiple sensors.<br>Reason: Multiple component failures are unlikely to occur simultaneously. Shared electrical issues explain correlated symptoms.'
            ],
            [
                'problem' => "All issues resolved, system stable.",
                'question' => "What verification process ensures complete repair?",
                'options' => [
                    ['text' => 'A) Visual inspection only', 'isCorrect' => false],
                    ['text' => 'B) Check engine oil level', 'isCorrect' => false],
                    ['text' => 'C) Extended test drive monitoring live sensor data', 'isCorrect' => true],
                    ['text' => 'D) Verify radio operation', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Monitor live sensor data during various driving conditions to verify stability. Check for consistent readings during acceleration, braking, cornering, and over rough surfaces.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Extended test drive monitoring live sensor data.<br>Reason: Dynamic testing validates repairs under real conditions. Static inspections miss intermittent issues.'
            ]
        ]
    ],

    // ───────────────────────────────────────
    // SCENARIO 6: Compressor Overheating
    // ───────────────────────────────────────
    'air_suspension_compressor_overheating' => [
        'title' => 'Compressor Overheating',
        'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=900&auto=format&fit=crop',
        'root_cause' => 'Restricted compressor cooling due to debris blockage and inadequate airflow.',
        'solution' => 'Clean compressor cooling fins and ensure proper airflow path integrity.',
        'learning' => 'Air compressors generate significant heat during operation—proper cooling is essential for longevity and reliable performance.',
        'steps' => [
            [
                'problem' => "Compressor shuts off after short operation with thermal protection error codes.",
                'question' => "What should you check FIRST?",
                'options' => [
                    ['text' => 'A) Engine coolant temperature', 'isCorrect' => false],
                    ['text' => 'B) Compressor cooling fins and airflow path', 'isCorrect' => true],
                    ['text' => 'C) Transmission fluid level', 'isCorrect' => false],
                    ['text' => 'D) Battery state of charge', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Thermal shutdown indicates overheating. Start with visual inspection of cooling fins for debris blockage and verify the airflow path isn\'t obstructed by leaves, mud, or other materials.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Compressor cooling fins and airflow path.<br>Reason: Thermal issues require cooling system inspection first. Engine and transmission systems operate independently.'
            ],
            [
                'problem' => "Cooling fins are packed with mud and leaves.",
                'question' => "How does this affect compressor operation?",
                'options' => [
                    ['text' => 'A) Improves compressor efficiency', 'isCorrect' => false],
                    ['text' => 'B) Reduces noise levels', 'isCorrect' => false],
                    ['text' => 'C) Increases system pressure', 'isCorrect' => false],
                    ['text' => 'D) Prevents heat dissipation, causing rapid overheating', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Blocked cooling fins prevent air from carrying heat away from the compressor. The internal temperature rises rapidly, triggering thermal protection shutdown to prevent damage.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Prevents heat dissipation, causing rapid overheating.<br>Reason: Cooling fins require clear airflow. Blockages don\'t improve any aspect of compressor performance.'
            ],
            [
                'problem' => "After cleaning, compressor still overheats during extended use.",
                'question' => "What should you investigate NEXT?",
                'options' => [
                    ['text' => 'A) Replace the compressor immediately', 'isCorrect' => false],
                    ['text' => 'B) Check for system leaks causing extended compressor runtime', 'isCorrect' => true],
                    ['text' => 'C) Install larger cooling fins', 'isCorrect' => false],
                    ['text' => 'D) Add external cooling fan', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Air leaks force the compressor to run continuously to maintain pressure. Extended operation generates excessive heat that overwhelms even a clean cooling system.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check for system leaks causing extended compressor runtime.<br>Reason: Overheating after cleaning suggests excessive workload. Component replacement should follow leak diagnosis.'
            ],
            [
                'problem' => "Multiple small leaks found at various fittings.",
                'question' => "How do these leaks contribute to overheating?",
                'options' => [
                    ['text' => 'A) Improve system cooling', 'isCorrect' => false],
                    ['text' => 'B) Reduce compressor workload', 'isCorrect' => false],
                    ['text' => 'C) Force compressor to run longer to maintain pressure', 'isCorrect' => true],
                    ['text' => 'D) Increase system efficiency', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Multiple leaks create continuous pressure loss, requiring the compressor to run frequently. Extended operation generates heat faster than the cooling system can dissipate it.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Force compressor to run longer to maintain pressure.<br>Reason: Leaks increase compressor workload, not reduce it. More work = more heat generation.'
            ],
            [
                'problem' => "All leaks repaired, but compressor still runs hot in summer.",
                'question' => "What environmental factor affects compressor cooling?",
                'options' => [
                    ['text' => 'A) High ambient temperatures reduce cooling efficiency', 'isCorrect' => true],
                    ['text' => 'B) Summer fuel blends', 'isCorrect' => false],
                    ['text' => 'C) Tire pressure changes', 'isCorrect' => false],
                    ['text' => 'D) Air conditioning usage', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Hot ambient air has reduced capacity to carry heat away from the compressor. Summer temperatures can push marginal cooling systems beyond their design limits.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) High ambient temperatures reduce cooling efficiency.<br>Reason: Physics dictates cooling efficiency. Fuel, tires, and AC don\'t directly affect compressor cooling.'
            ],
            [
                'problem' => "Compressor is mounted in enclosed space with limited airflow.",
                'question' => "What modification might improve cooling?",
                'options' => [
                    ['text' => 'A) Wrap compressor in insulation', 'isCorrect' => false],
                    ['text' => 'B) Relocate to engine compartment', 'isCorrect' => false],
                    ['text' => 'C) Add ventilation ducts or shrouds to guide airflow', 'isCorrect' => true],
                    ['text' => 'D) Reduce system pressure', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Strategic ducting can channel airflow through the compressor\'s cooling fins. This improves heat dissipation without requiring major component relocation.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Add ventilation ducts or shrouds to guide airflow.<br>Reason: Improving existing cooling is more practical than major modifications. Insulation would make overheating worse.'
            ],
            [
                'problem' => "After improvements, compressor still overheats during towing.",
                'question' => "What driving advice should you give?",
                'options' => [
                    ['text' => 'A) Tow at higher speeds', 'isCorrect' => false],
                    ['text' => 'B) Allow cool-down periods during extended heavy use', 'isCorrect' => true],
                    ['text' => 'C) Disable air suspension', 'isCorrect' => false],
                    ['text' => 'D) Use lift mode continuously', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Towing creates continuous load leveling demands. Periodic rest stops allow the compressor to cool, preventing thermal shutdown and extending component life.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Allow cool-down periods during extended heavy use.<br>Reason: Practical usage advice prevents problems. Higher speeds and lift mode increase compressor workload.'
            ],
            [
                'problem' => "Compressor shows signs of thermal damage on housing.",
                'question' => "What indicates the compressor has suffered from chronic overheating?",
                'options' => [
                    ['text' => 'A) Bright shiny appearance', 'isCorrect' => false],
                    ['text' => 'B) Improved compression efficiency', 'isCorrect' => false],
                    ['text' => 'C) Reduced noise levels', 'isCorrect' => false],
                    ['text' => 'D) Discolored or melted plastic components', 'isCorrect' => true]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Heat damage shows as discolored, warped, or melted plastic parts. Chronic overheating accelerates wear on internal seals and bearings, reducing compressor lifespan.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Discolored or melted plastic components.<br>Reason: Visual evidence confirms thermal stress. Overheating doesn\'t improve any aspect of performance.'
            ],
            [
                'problem' => "All cooling improvements completed.",
                'question' => "What monitoring method verifies the repair effectiveness?",
                'options' => [
                    ['text' => 'A) Visual inspection only', 'isCorrect' => false],
                    ['text' => 'B) Measure compressor run times and monitor temperature with scan tool', 'isCorrect' => true],
                    ['text' => 'C) Check engine oil quality', 'isCorrect' => false],
                    ['text' => 'D) Verify headlight operation', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Monitor compressor operation during extended use. Reduced run times and stable temperature readings indicate effective cooling improvements and leak-free operation.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Measure compressor run times and monitor temperature with scan tool.<br>Reason: Quantitative data validates improvements. Visual checks alone don\'t confirm thermal performance.'
            ],
            [
                'problem' => "Customer wants to prevent future overheating issues.",
                'question' => "What regular maintenance prevents cooling problems?",
                'options' => [
                    ['text' => 'A) Monthly compressor replacement', 'isCorrect' => false],
                    ['text' => 'B) Weekly system pressure increases', 'isCorrect' => false],
                    ['text' => 'C) Annual inspection and cleaning of compressor cooling area', 'isCorrect' => true],
                    ['text' => 'D) Daily cooling fin polishing', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Regular cleaning during routine maintenance prevents debris accumulation. Annual inspections catch developing issues before they cause overheating and component damage.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Annual inspection and cleaning of compressor cooling area.<br>Reason: Preventive maintenance is practical and effective. Excessive schedules waste resources.'
            ]
        ]
    ]
];

$scenarioMapping = [
    'air_suspension_low_ride_height' => '3.0',
    'air_suspension_no_raise' => '3.1',
    'air_suspension_noisy_compressor' => '3.2',
    'air_suspension_leaking_air' => '3.3',
    'air_suspension_height_fluctuations' => '3.4',
    'air_suspension_compressor_overheating' => '3.5'
];

try {
    $pdo = new PDO("mysql:host=localhost;dbname=u748339007_fixsense25_db;charset=utf8mb4", 'u748339007_fixsense25_use', 'FixSense25');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    foreach ($scenarios as $key => $scenario) {
        $scenarioId = $scenarioMapping[$key];

        // ✅ Insert scenario (pastikan semua column ikut table sebenar)
        $stmt = $pdo->prepare("
            INSERT INTO scenarios 
            (id, title, description, category, image_path, created_by, root_cause, solution, learning)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $scenarioId,
            $scenario['title'],
            $scenario['steps'][0]['problem'],
            'Air-Suspension Problems', //
            $scenario['image'],
            6, // lecturer ID
            $scenario['root_cause'] ?? 'N/A',
            $scenario['solution'] ?? 'N/A',
            $scenario['learning'] ?? 'N/A'
        ]);

        // ✅ Insert steps & options
        $stepNum = 1;
        foreach ($scenario['steps'] as $step) {
            $stmtStep = $pdo->prepare("
                INSERT INTO steps (scenario_id, step_number, description)
                VALUES (?, ?, ?)
            ");
            $stmtStep->execute([$scenarioId, $stepNum, $step['problem']]);
            $stepId = $pdo->lastInsertId();

            foreach ($step['options'] as $opt) {
                $stmtOpt = $pdo->prepare("
                    INSERT INTO options (step_id, text, is_correct, explanation)
                    VALUES (?, ?, ?, ?)
                ");
                $stmtOpt->execute([
                    $stepId,
                    $opt['text'],
                    $opt['isCorrect'] ? 1 : 0,
                    $opt['isCorrect'] ? $step['feedbackCorrect'] : $step['feedbackIncorrect']
                ]);
            }

            $stepNum++;
        }
    }

    echo "<h3 style='color:green;'>✅ Migration complete successfully!</h3>";

} catch (PDOException $e) {
    echo "<h3 style='color:red;'>❌ Migration failed: " . $e->getMessage() . "</h3>";
}
?>