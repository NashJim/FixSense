<?php
// 1. Copy array $scenarios dari simulationBrake.php ke sini
    $scenarios = [

   'car_wont_start' => [
    'title' => 'Car Won\'t Start',
    'image' => 'https://images.unsplash.com/photo-1580246814056-ae5492d55c6b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Corroded and loose battery terminals causing insufficient power to the starter, compounded by a faulty starter motor and cracked distributor cap.',
    'solution' => 'Clean and secure the battery terminals, replace the defective starter motor, and install a new distributor cap and rotor.',
    'learning' => 'Follow a systematic approach when diagnosing a no-start condition: check for power delivery first (battery & connections), then control signal (ignition/starter), and finally mechanical load (starter or engine rotation).',

    'steps' => [
        [
            'problem' => "Customer complains the car won’t start. The key turns but the engine doesn’t crank — no sound, no movement.",
            'question' => "What should you check first before assuming any major fault?",
            'options' => [
                ['text' => 'A) Battery voltage and terminal condition.', 'isCorrect' => true],
                ['text' => 'B) Spark plug gap.', 'isCorrect' => false],
                ['text' => 'C) Fuel level in tank.', 'isCorrect' => false],
                ['text' => 'D) Throttle body cleanliness.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>The first check for a no-crank condition is the power source — the battery. Low voltage or corroded terminals can prevent enough current from reaching the starter motor.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Battery voltage and terminal condition.<br>Reason: Spark or fuel checks come later; if the engine doesn’t even crank, electrical power delivery is the first step.'
        ],
        [
            'problem' => "You measure the battery at 10.2V and notice corrosion on both terminals.",
            'question' => "What should you do next to confirm if the battery is the main issue?",
            'options' => [
                
                ['text' => 'A) Replace the alternator immediately.', 'isCorrect' => false],
                ['text' => 'B) Clean and tighten terminals, then retest voltage and attempt to crank.', 'isCorrect' => true],
                ['text' => 'C) Jump-start and return car without further inspection.', 'isCorrect' => false],
                ['text' => 'D) Check tire pressure for resistance.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Loose or corroded terminals can drop voltage under load. Cleaning and tightening ensures proper contact before condemning other parts. Always retest after this step.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Clean and tighten terminals, then retest.<br>Reason: Alternator and tires have nothing to do with an initial no-crank situation.'
        ],
        [
            'problem' => "After cleaning, battery voltage rises to 12.6V but the engine still doesn’t crank. You hear a single click when turning the key.",
            'question' => "What should you check next to narrow down the fault?",
            'options' => [
                
                ['text' => 'A) Fuel pump relay.', 'isCorrect' => false],
                ['text' => 'B) Air filter housing.', 'isCorrect' => false],
                ['text' => 'C) Ignition timing.', 'isCorrect' => false],
                ['text' => 'D) Starter solenoid and motor function.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A single click means the solenoid activates but the motor doesn’t spin — classic symptom of starter motor failure or internal wear. Time to test starter circuit continuity.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Starter solenoid and motor function.<br>Reason: The sound indicates electrical contact at solenoid level, not a fuel or air issue.'
        ],
        [
            'problem' => "You test the starter circuit and find 12V present at the solenoid terminal, but the starter motor still doesn’t engage.",
            'question' => "What’s the most logical action to take next?",
            'options' => [
                ['text' => 'A) Replace the starter motor assembly.', 'isCorrect' => true],
                ['text' => 'B) Check fuel injector spray pattern.', 'isCorrect' => false],
                ['text' => 'C) Adjust valve clearance.', 'isCorrect' => false],
                ['text' => 'D) Reset the ECU.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Voltage present but no motor operation confirms an internal starter fault. Replacement of the motor assembly is the proper next step.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace the starter motor.<br>Reason: The circuit delivers voltage correctly, meaning failure is inside the starter unit itself.'
        ],
        [
            'problem' => "After replacing the starter, the engine now cranks normally but still won’t start.",
            'question' => "Since the engine now turns, what system should you check next?",
            'options' => [
                
                ['text' => 'A) Steering alignment.', 'isCorrect' => false],
                ['text' => 'B) Air conditioning relay.', 'isCorrect' => false],
                ['text' => 'C) Ignition system for spark presence.', 'isCorrect' => true],
                ['text' => 'D) Exhaust muffler for leaks.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Now that cranking is restored, the next stage is to check for spark. No ignition signal means the engine can rotate but cannot fire.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Ignition system for spark presence.<br>Reason: Cranking restored — now check ignition sequence before moving to fuel system.'
        ],
        [
            'problem' => "You find there’s no spark at the plugs even though ignition coil has power. The distributor cap is cracked and slightly damp inside.",
            'question' => "What should be your corrective action?",
            'options' => [
                
                ['text' => 'A) Clean spark plugs only.', 'isCorrect' => false],
                ['text' => 'B) Recharge the battery again.', 'isCorrect' => false],
                ['text' => 'C) Adjust alternator belt tension.', 'isCorrect' => false],
                ['text' => 'D) Replace the distributor cap and rotor as a set.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Cracks and moisture in the distributor prevent voltage transfer to plugs. Replacing the cap and rotor ensures consistent spark delivery and prevents misfires.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Replace distributor cap and rotor.<br>Reason: Cleaning plugs won’t restore ignition if spark never reaches them.'
        ],
        [
            'problem' => "After replacing the cap and rotor, the engine starts smoothly. The customer asks what else should be done to finish the repair properly.",
            'question' => "What’s the final professional step you should perform?",
            'options' => [
                
                ['text' => 'A) Replace all tires to improve cranking load.', 'isCorrect' => false],
                ['text' => 'B) Record the repair and verify system operation with a full start test.', 'isCorrect' => true],
                ['text' => 'C) Ignore the battery since the car now runs.', 'isCorrect' => false],
                ['text' => 'D) Disconnect the alternator for testing.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Professional technicians always verify the full repair cycle — ensure smooth starting, log the work done, and retest after idling to confirm reliability. Documentation also helps for future service history.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Record the repair and verify system operation.<br>Reason: Maintenance records and post-repair verification ensure accountability and prevent repeat issues.'
        ]
    ]
],

'engine_overheating' => [
    'title' => 'Engine Overheating',
    'image' => 'https://images.unsplash.com/photo-1598976847148-1d7a5e0c3b6f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'A stuck-closed thermostat and degraded engine coolant causing restricted circulation and poor heat dissipation during load.',
    'solution' => 'Replace the thermostat, flush and refill the cooling system with the correct coolant mixture, and inspect the radiator fan and cap for proper function.',
    'learning' => 'Overheating can result from coolant restriction, fan failure, or poor maintenance. Always inspect the cooling system systematically — coolant level, flow, pressure, and temperature response — before replacing any part.',

    'steps' => [
        [
            'problem' => "The customer reports that the temperature gauge rises into the red zone during slow traffic but drops back to normal when driving at highway speed.",
            'question' => "What is the first thing you should check?",
            'options' => [
                
                ['text' => 'A) Tire pressure levels.', 'isCorrect' => false],
                ['text' => 'B) Spark plug gaps.', 'isCorrect' => false],
                ['text' => 'C) Coolant level and any visible leaks.', 'isCorrect' => true],
                ['text' => 'D) Fuel injector spray pattern.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>This pattern (overheating at low speed, normal at high) suggests poor coolant circulation or airflow at idle. Always start by confirming proper coolant level and leak-free system — the foundation of all cooling diagnostics.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Coolant level and any visible leaks.<br>Reason: Low coolant or a small leak can cause air pockets and unstable cooling flow, especially noticeable in stop-and-go conditions.'
        ],
        [
            'problem' => "You inspect the reservoir and find the coolant below the MIN mark, with dried residue around the radiator cap area.",
            'question' => "What should you do next?",
            'options' => [
                
                ['text' => 'A) Replace the alternator belt immediately.', 'isCorrect' => false],
                ['text' => 'B) Add more oil to the engine.', 'isCorrect' => false],
                ['text' => 'C) Pressure-test the cooling system to locate any leaks.', 'isCorrect' => true],
                ['text' => 'D) Remove the thermostat right away.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A pressure test reveals whether coolant loss is due to a worn radiator cap, cracked hose, or internal leak. Diagnosing leaks before adding fluid prevents masking the real cause.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Pressure-test the cooling system.<br>Reason: Simply adding coolant doesn’t fix the leak source — overheating will recur without proper sealing.'
        ],
        [
            'problem' => "The pressure test shows a slow leak at the radiator cap seal. After replacing the cap, coolant level stabilizes but the engine still overheats during idling.",
            'question' => "Which component should you check next?",
            'options' => [
                
                ['text' => 'A) Air filter housing.', 'isCorrect' => false],
                ['text' => 'B) Brake fluid reservoir.', 'isCorrect' => false],
                ['text' => 'C) Transmission oil pan.', 'isCorrect' => false],
                ['text' => 'D) Radiator fan operation and temperature switch.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>If the temperature rises at idle, it often indicates insufficient airflow. Checking the radiator fan and its temperature switch ensures cooling efficiency when the car is stationary.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Radiator fan operation and temperature switch.<br>Reason: At idle, airflow from driving is absent, so fan performance becomes the key cooling factor.'
        ],
        [
            'problem' => "You start the engine and notice the radiator fan doesn’t activate even as temperature climbs near 100°C.",
            'question' => "What’s the most likely cause?",
            'options' => [
                ['text' => 'A) Faulty temperature sensor or fan relay.', 'isCorrect' => true],
                ['text' => 'B) Dirty spark plugs.', 'isCorrect' => false],
                ['text' => 'C) Slipping alternator pulley.', 'isCorrect' => false],
                ['text' => 'D) Low brake fluid.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>The fan should engage around 90–95°C. If not, test the temperature sensor and relay — both control fan activation based on coolant temperature.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Faulty temperature sensor or fan relay.<br>Reason: These components directly control fan engagement — unrelated systems like spark or brakes cannot affect cooling fans.'
        ],
        [
            'problem' => "You replace the fan relay and confirm the fan now activates properly, but the temperature still spikes above normal after 10 minutes of idling.",
            'question' => "What’s the next logical step?",
            'options' => [
                
                ['text' => 'A) Inspect the wiper motor.', 'isCorrect' => false],
                ['text' => 'B) Check the thermostat operation in hot water.', 'isCorrect' => true],
                ['text' => 'C) Test horn relay.', 'isCorrect' => false],
                ['text' => 'D) Check tire alignment.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A thermostat stuck closed blocks coolant flow to the radiator, trapping heat in the engine block. Testing it in hot water shows whether it opens at the correct temperature.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check thermostat operation.<br>Reason: The thermostat regulates coolant circulation — other options have no role in temperature regulation.'
        ],
        [
            'problem' => "The thermostat fails to open during the hot-water test.",
            'question' => "What is the correct repair procedure?",
            'options' => [
                
                ['text' => 'A) Leave it removed permanently.', 'isCorrect' => false],
                ['text' => 'B) Add cold water directly into radiator when hot.', 'isCorrect' => false],
                ['text' => 'C) Replace the thermostat and refill with proper coolant mix.', 'isCorrect' => true],
                ['text' => 'D) Tighten spark plug gaps.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Installing a new thermostat restores proper temperature regulation. Always refill with the correct 50/50 coolant mix to ensure thermal efficiency and corrosion protection.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Replace the thermostat and refill properly.<br>Reason: Removing the thermostat can cause the engine to run too cool, reducing efficiency and causing uneven heating cycles.'
        ],
        [
            'problem' => "After thermostat replacement, the engine temperature improves but still rises slightly during long climbs.",
            'question' => "What should you inspect next to confirm full cooling performance?",
            'options' => [
                ['text' => 'A) Radiator fins for dirt blockage or restricted airflow.', 'isCorrect' => true],
                ['text' => 'B) Steering column joints.', 'isCorrect' => false],
                ['text' => 'C) Door seals.', 'isCorrect' => false],
                ['text' => 'D) Washer fluid reservoir.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Dust, bugs, or debris clogging the radiator fins reduce airflow and heat dissipation, especially under load. Cleaning them restores cooling capacity.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Radiator fins for dirt blockage.<br>Reason: Restricted airflow across the radiator prevents effective heat transfer, worsening heat buildup on climbs.'
        ],
        [
            'problem' => "You clean the radiator fins and confirm good airflow. Now, coolant still appears dark and rusty inside the reservoir.",
            'question' => "What does this suggest?",
            'options' => [
               
                ['text' => 'A) Faulty battery electrolyte.', 'isCorrect' => false],
                ['text' => 'B) Low refrigerant charge.', 'isCorrect' => false],
                ['text' => 'C) Worn-out timing belt.', 'isCorrect' => false],
                ['text' => 'D) Old or contaminated coolant that needs a full system flush.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Rusty coolant indicates corrosion and reduced thermal transfer. Flushing the system and refilling with new coolant restores circulation efficiency.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Contaminated coolant.<br>Reason: Old coolant loses its additives and promotes corrosion, which traps heat and leads to recurring overheating.'
        ],
        [
            'problem' => "You flush the system and refill with new coolant. During the road test, temperature remains stable even under load.",
            'question' => "What should you do next to verify the repair is complete?",
            'options' => [
                
                ['text' => 'A) Adjust clutch pedal height.', 'isCorrect' => false],
                ['text' => 'B) Replace the fuel pump.', 'isCorrect' => false],
                ['text' => 'C) Recheck cooling pressure and inspect for leaks after cooldown.', 'isCorrect' => true],
                ['text' => 'D) Add octane booster.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Rechecking pressure ensures no slow leaks remain and verifies the system holds consistent pressure — a key sign of successful repair.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Recheck cooling pressure.<br>Reason: Post-repair pressure testing confirms the integrity of your fix and ensures long-term reliability.'
        ],
        [
            'problem' => "After confirming stable pressure, the customer asks how to prevent overheating in the future.",
            'question' => "What’s the best maintenance advice to give?",
            'options' => [
                
                ['text' => 'A) Leave the radiator cap loose for airflow.', 'isCorrect' => false],
                ['text' => 'B) Add water from any source when low.', 'isCorrect' => false],
                ['text' => 'C) Ignore small coolant loss if temperature stays normal.', 'isCorrect' => false],
                ['text' => 'D) Regularly check coolant level and flush every 2 years.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Routine fluid checks and scheduled coolant flushes prevent corrosion and scale buildup, keeping the cooling system efficient for years.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Check level and flush periodically.<br>Reason: Cooling system neglect is the top cause of overheating recurrence — prevention is always cheaper than repair.'
        ],
        [
            'problem' => "You finalize the service. The engine maintains normal temperature across all conditions.",
            'question' => "What final documentation step should you complete?",
            'options' => [
                
                ['text' => 'A) Close the bonnet and skip paperwork.', 'isCorrect' => false],
                ['text' => 'B) Record coolant type, pressure test results, and replaced parts in the service log.', 'isCorrect' => true],
                ['text' => 'C) Reset the radio presets.', 'isCorrect' => false],
                ['text' => 'D) Inflate tires to maximum pressure.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Recording all repair data ensures traceability, customer confidence, and easier follow-up if temperature issues reoccur later.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Record coolant type and results.<br>Reason: Documentation is a key part of professional diagnostic practice and quality assurance.'
        ]
    ]
],

'unusual_engine_noise' => [
    'title' => 'Unusual Engine Noise',
    'image' => 'https://images.unsplash.com/photo-1600701357885-7efc6413b21d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Low engine oil level and worn valve lifters causing ticking and knocking noises during acceleration.',
    'solution' => 'Inspect and top up engine oil, replace worn lifters or adjust valve clearance, and ensure proper lubrication pressure.',
    'learning' => 'Engine noises can indicate early mechanical wear or lubrication failure. Identifying the sound’s rhythm, location, and relation to RPM is critical to pinpointing the affected component before severe damage occurs.',

    'steps' => [
        [
            'problem' => "Customer complains of a light tapping or ticking sound from the engine that increases with RPM.",
            'question' => "What’s the first thing to check before assuming internal damage?",
            'options' => [
               
                ['text' => 'A) Tire tread wear.', 'isCorrect' => false],
                ['text' => 'B) Cabin air filter.', 'isCorrect' => false],
                ['text' => 'C) Engine oil level and condition.', 'isCorrect' => true],
                ['text' => 'D) Radiator coolant cap.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Low or dirty engine oil is a leading cause of ticking or knocking sounds. Lubrication problems reduce hydraulic lifter performance and increase friction between moving parts.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Engine oil level and condition.<br>Reason: Engine noise often starts when oil flow or pressure is insufficient — unrelated components like tires or filters can’t create rhythmic engine ticking.'
        ],
        [
            'problem' => "You check the dipstick and find the oil below the minimum mark, appearing dark and sludgy.",
            'question' => "What’s the correct next step?",
            'options' => [
                
                ['text' => 'A) Add coolant to compensate.', 'isCorrect' => false],
                ['text' => 'B) Disconnect the battery.', 'isCorrect' => false],
                ['text' => 'C) Replace the fuel injectors.', 'isCorrect' => false],
                ['text' => 'D) Drain and replace the oil and filter before running the engine again.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Old or contaminated oil can thicken, blocking passages and starving components of lubrication. Always perform a full oil and filter change to restore proper oil pressure and cleanliness.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Replace oil and filter.<br>Reason: Adding coolant or unrelated actions won’t resolve poor lubrication — it’s vital to flush out old, degraded oil before further testing.'
        ],
        [
            'problem' => "After changing the oil, the ticking sound improves slightly but still persists during idle and light acceleration.",
            'question' => "What area should be inspected next?",
            'options' => [
                ['text' => 'A) Valve lifters and rocker arms for wear or clearance issues.', 'isCorrect' => true],
                ['text' => 'B) Air conditioning compressor clutch.', 'isCorrect' => false],
                ['text' => 'C) Wiper linkage.', 'isCorrect' => false],
                ['text' => 'D) Radiator fan housing.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Tapping that matches engine speed often comes from worn valve lifters or incorrect valve clearance. These components rely heavily on consistent oil pressure to function quietly.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Valve lifters and rocker arms.<br>Reason: Internal valvetrain noise differs from accessory or external noises like A/C or fan operation.'
        ],
        [
            'problem' => "You remove the valve cover and find one lifter with excessive clearance and poor oil feed.",
            'question' => "What’s the best corrective action?",
            'options' => [
                ['text' => 'A) Replace the faulty lifter and inspect oil passage for blockage.', 'isCorrect' => true],
                ['text' => 'B) Add octane booster to the fuel.', 'isCorrect' => false],
                ['text' => 'C) Clean the throttle body.', 'isCorrect' => false],
                ['text' => 'D) Tighten alternator belt.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Replacing the worn lifter and clearing any oil passage blockage restores normal hydraulic function and eliminates the ticking source.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace faulty lifter.<br>Reason: The sound originates from valvetrain wear — fuel additives or external adjustments won’t solve the internal oil pressure issue.'
        ],
        [
            'problem' => "After replacing the faulty lifter, the engine idles smoothly but a deeper knocking sound appears under heavy acceleration.",
            'question' => "Which component should you inspect next?",
            'options' => [
                
                ['text' => 'A) Brake caliper pistons.', 'isCorrect' => false],
                ['text' => 'B) Power steering fluid level.', 'isCorrect' => false],
                ['text' => 'C) Connecting rod bearings for wear or play.', 'isCorrect' => true],
                ['text' => 'D) Door hinges.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A deep knock that increases with load suggests bearing wear. Rod bearing clearance increases due to oil starvation, producing a metallic thud at each combustion stroke.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Connecting rod bearings.<br>Reason: The load-dependent knock comes from internal engine bottom-end components, not external systems.'
        ],
        [
            'problem' => "You remove the oil pan and notice fine metal shavings and play in one connecting rod bearing.",
            'question' => "What should be done next to prevent catastrophic failure?",
            'options' => [
                
                ['text' => 'A) Add thicker oil to mask the noise.', 'isCorrect' => false],
                ['text' => 'B) Replace the damaged bearing and inspect the crankshaft journals.', 'isCorrect' => true],
                ['text' => 'C) Ignore it if performance feels normal.', 'isCorrect' => false],
                ['text' => 'D) Replace spark plug wires.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Replacing the worn bearing and checking crankshaft wear prevents total engine seizure. Ignoring or masking the sound risks complete bearing failure and rod damage.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace the damaged bearing and inspect crankshaft.<br>Reason: Temporary fixes or thicker oil won’t restore bearing clearance — proper mechanical repair is mandatory.'
        ],
        [
            'problem' => "After replacing the bearing and refilling with fresh oil, the knock disappears. However, slight rattling is heard during cold starts for a few seconds.",
            'question' => "What’s the most probable cause?",
            'options' => [
                
                ['text' => 'A) Faulty alternator pulley.', 'isCorrect' => false],
                ['text' => 'B) Worn clutch release bearing.', 'isCorrect' => false],
                ['text' => 'C) Normal delay in oil pressure buildup before full lubrication.', 'isCorrect' => true],
                ['text' => 'D) Blocked air filter.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A brief rattle on cold start is common until oil fully circulates. It shouldn’t persist more than a few seconds — otherwise, oil pressure or filter issues should be checked.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Normal oil pressure buildup delay.<br>Reason: This mild start-up sound differs from mechanical faults — it’s due to momentary oil film absence.'
        ],
        [
            'problem' => "You verify oil pressure is within spec and the noise disappears once warm. The customer asks how to prevent this from recurring.",
            'question' => "What’s the best maintenance advice?",
            'options' => [
                ['text' => 'A) Perform regular oil and filter changes at manufacturer intervals.', 'isCorrect' => true],
                ['text' => 'B) Use any leftover oil from other cars.', 'isCorrect' => false],
                ['text' => 'C) Drive at high RPMs when cold.', 'isCorrect' => false],
                ['text' => 'D) Delay oil changes until the warning light appears.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Fresh, clean oil maintains hydraulic pressure and lubrication film thickness, protecting internal components from wear and abnormal noise.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Follow proper oil change intervals.<br>Reason: Irregular or mixed oil use leads to premature wear, poor lubrication, and noise recurrence.'
        ],
        [
            'problem' => "You complete all tests and confirm the engine runs quietly and smoothly under all conditions.",
            'question' => "What should be the final documentation step?",
            'options' => [
                
                ['text' => 'A) Close the bonnet and skip paperwork.', 'isCorrect' => false],
                ['text' => 'B) Reset wiper position.', 'isCorrect' => false],
                ['text' => 'C) Refill windshield washer fluid.', 'isCorrect' => false],
                ['text' => 'D) Record oil type, pressure readings, and replaced components in the service report.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Proper documentation ensures maintenance traceability and builds customer trust. It also helps diagnose future issues with a complete service history.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Record oil type and replaced parts.<br>Reason: Service documentation is part of professional workshop practice — skipping it risks losing repair evidence.'
        ]
    ]
],

'low_oil_pressure_warning' => [
    'title' => 'Low Oil Pressure Warning',
    'image' => 'https://images.unsplash.com/photo-1589391886645-d51941baf7cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Insufficient oil level and worn oil pump causing reduced pressure in the lubrication system, leading to intermittent warning light activation.',
    'solution' => 'Inspect oil level, pressure sender, and pump; replace worn components and ensure correct oil grade is used.',
    'learning' => 'Low oil pressure can destroy an engine within minutes if ignored. Understanding how lubrication flow, viscosity, and pressure sensors interact helps prevent severe mechanical damage.',

    'steps' => [
        [
            'problem' => "While driving, the low oil pressure warning light flashes intermittently at idle but disappears when revving the engine.",
            'question' => "What should you check first before assuming a mechanical failure?",
            'options' => [
                
                ['text' => 'A) Battery voltage output.', 'isCorrect' => false],
                ['text' => 'B) Cabin air filter.', 'isCorrect' => false],
                ['text' => 'C) Coolant reservoir cap.', 'isCorrect' => false],
                ['text' => 'D) Engine oil level and condition on the dipstick.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Low oil level is the most common reason for pressure warnings. The pump can’t draw sufficient oil from the sump, especially during idling where flow is minimal.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Check oil level and condition.<br>Reason: The oil pressure system depends on proper lubrication volume — unrelated components like battery or filters have no effect.'
        ],
        [
            'problem' => "You pull the dipstick and see the oil level below the minimum mark, with the oil appearing dark and thin.",
            'question' => "What’s the next proper action before starting the engine again?",
            'options' => [
                
                ['text' => 'A) Disconnect the fuel pump.', 'isCorrect' => false],
                ['text' => 'B) Replace spark plugs.', 'isCorrect' => false],
                ['text' => 'C) Top up with the manufacturer-recommended oil grade or perform a full oil change.', 'isCorrect' => true],
                ['text' => 'D) Add water to dilute the oil.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Operating with low or degraded oil risks bearing and camshaft damage. Always refill or replace the oil to restore proper viscosity and lubrication film before running the engine.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Add or replace oil properly.<br>Reason: Oil dilution or unrelated component service doesn’t address the lack of lubrication.'
        ],
        [
            'problem' => "After topping up, the light stays off temporarily but reappears once the engine reaches operating temperature.",
            'question' => "What does this behaviour most likely indicate?",
            'options' => [
                
                ['text' => 'A) Low fuel pressure.', 'isCorrect' => false],
                ['text' => 'B) Weak oil pump or worn internal bearings reducing pressure at high temperature.', 'isCorrect' => true],
                ['text' => 'C) Failing alternator diode.', 'isCorrect' => false],
                ['text' => 'D) Faulty oxygen sensor.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Hot oil becomes thinner, and if pump clearances or bearings are worn, pressure drops below safe limits — triggering the warning again.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Weak oil pump or worn bearings.<br>Reason: These are direct causes of pressure loss; other sensors or systems are unrelated.'
        ],
        [
            'problem' => "You connect a mechanical oil pressure gauge. At idle, pressure reads only 10 psi — below specification.",
            'question' => "What’s the next diagnostic step?",
            'options' => [
                ['text' => 'A) Check for oil leaks, clogged pickup screen, or worn pump gears.', 'isCorrect' => true],
                ['text' => 'B) Replace coolant thermostat.', 'isCorrect' => false],
                ['text' => 'C) Adjust throttle cable.', 'isCorrect' => false],
                ['text' => 'D) Clean brake fluid reservoir.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A clogged pickup or worn pump gears reduce oil flow. Inspecting these components confirms if pressure loss is mechanical or just due to restricted circulation.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check oil pickup or pump gears.<br>Reason: Pressure testing focuses on the lubrication circuit — unrelated adjustments won’t affect readings.'
        ],
        [
            'problem' => "Upon removing the oil pan, you find sludge buildup near the pickup screen and metallic debris inside the sump.",
            'question' => "What should be done before reassembling?",
            'options' => [
                
                ['text' => 'A) Just add fresh oil and close it back.', 'isCorrect' => false],
                ['text' => 'B) Wipe debris with a cloth and ignore small particles.', 'isCorrect' => false],
                ['text' => 'C) Increase idle RPM to boost pressure.', 'isCorrect' => false],
                ['text' => 'D) Thoroughly clean the pan, replace the oil pickup screen, and inspect pump condition.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Cleaning the system prevents sludge from re-entering the pump and clogging passages. Replacing the pickup ensures consistent oil flow to the pump.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Clean and replace components properly.<br>Reason: Reusing contaminated parts risks re-blockage and repeat low-pressure symptoms.'
        ],
        [
            'problem' => "You replace the oil pump and clean the sump. After reassembly, the warning light stays off, and pressure reads 40 psi at idle.",
            'question' => "What else should you check before returning the vehicle to the customer?",
            'options' => [
                
                ['text' => 'A) Replace radiator cap.', 'isCorrect' => false],
                ['text' => 'B) Verify the oil pressure sender and wiring for correct sensor output.', 'isCorrect' => true],
                ['text' => 'C) Reset transmission control module.', 'isCorrect' => false],
                ['text' => 'D) Adjust parking brake cable.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Even with mechanical repair done, faulty senders or corroded connectors can falsely trigger the warning. Always verify signal accuracy to avoid false alarms.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check sender and wiring.<br>Reason: The pressure sensor circuit must provide reliable data for warning light logic.'
        ],
        [
            'problem' => "The system now shows stable readings and no leaks. Customer asks what could cause this issue again in the future.",
            'question' => "What preventive advice should you give?",
            'options' => [
                ['text' => 'A) Change oil and filter on time using the specified viscosity grade.', 'isCorrect' => true],
                ['text' => 'B) Use thicker oil to delay pressure drops.', 'isCorrect' => false],
                ['text' => 'C) Ignore minor leaks until the warning appears.', 'isCorrect' => false],
                ['text' => 'D) Overfill oil to increase pressure.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Following manufacturer intervals and oil grades maintains pressure stability. Overly thick or contaminated oil delays flow and may trigger the warning again.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Maintain correct oil grade and intervals.<br>Reason: Thicker or excessive oil can damage seals and affect circulation efficiency.'
        ],
        [
            'problem' => "During a follow-up test drive, pressure remains steady even after long idling. However, light flickers briefly when the engine is restarted hot.",
            'question' => "What’s the most likely cause of this brief flicker?",
            'options' => [
                
                ['text' => 'A) Faulty head gasket.', 'isCorrect' => false],
                ['text' => 'B) Clogged air filter.', 'isCorrect' => false],
                ['text' => 'C) Temporary pressure drop during oil drainback — normal if it extinguishes quickly.', 'isCorrect' => true],
                ['text' => 'D) Malfunctioning horn relay.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A short flicker at restart happens before the pump builds full pressure. As long as it disappears within seconds, it’s considered normal system behavior.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Temporary oil drainback.<br>Reason: This momentary flicker is not failure-related unless pressure remains low after start-up.'
        ],
        [
            'problem' => "You confirm oil pressure stability and replace the service sticker. Before closing the job, the customer asks about warning light behavior.",
            'question' => "What’s the correct explanation to provide?",
            'options' => [
                
                ['text' => 'A) It’s only a suggestion to add oil later.', 'isCorrect' => false],
                ['text' => 'B) It indicates the radiator fan is off.', 'isCorrect' => false],
                ['text' => 'C) It activates for air filter clogging.', 'isCorrect' => false],
                ['text' => 'D) The light means oil pressure is critically low; stop the engine immediately if it stays on.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>The oil pressure light warns of possible engine damage. Continuing to drive with it on can cause severe bearing or cam wear within minutes.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Stop engine immediately if light stays on.<br>Reason: It’s a critical safety warning, not a maintenance reminder.'
        ],
        [
            'problem' => "After all checks and repairs, the oil pressure remains within specification, and no warnings occur during test drives.",
            'question' => "What should be the final professional step before handing the car back?",
            'options' => [
                
                ['text' => 'A) Just erase the warning light memory.', 'isCorrect' => false],
                ['text' => 'B) Record oil pressure readings, parts replaced, and oil grade used in the service log.', 'isCorrect' => true],
                ['text' => 'C) Ignore paperwork.', 'isCorrect' => false],
                ['text' => 'D) Add refrigerant to A/C.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Documentation ensures service traceability and helps future technicians understand the repair history if similar warnings reoccur.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Record service details properly.<br>Reason: Good documentation is part of professional automotive maintenance and quality control.'
        ]
    ]
],


'excessive_oil_consumption' => [
    'title' => 'Excessive Engine Oil Consumption',
    'image' => 'https://images.unsplash.com/photo-1615197965177-93c1e2a6d3f7?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Worn piston rings and valve stem seals allowing oil to enter the combustion chamber, combined with clogged PCV system increasing crankcase pressure.',
    'solution' => 'Inspect and replace faulty valve stem seals and piston rings, service the PCV system, and use correct oil viscosity as recommended.',
    'learning' => 'Excessive oil consumption can result from internal wear or ventilation failure. Proper diagnosis involves checking leaks, compression, and oil control components — not just topping up oil.',

    'steps' => [
        [
            'problem' => "Customer complains that engine oil level drops noticeably every 500–700 km without visible oil leaks under the car.",
            'question' => "What’s the first inspection step to narrow down the cause?",
            'options' => [
                ['text' => 'A) Check for external oil leaks and inspect tailpipe for blue smoke.', 'isCorrect' => true],
                ['text' => 'B) Check tire pressure.', 'isCorrect' => false],
                ['text' => 'C) Flush the radiator.', 'isCorrect' => false],
                ['text' => 'D) Clean the throttle body.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Visible blue exhaust smoke or oil stains indicate whether oil is burning internally or leaking externally — an essential first step before disassembly.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check for leaks and tailpipe smoke.<br>Reason: Blue smoke means oil enters the combustion chamber, while leaks show external loss — both are key indicators.'
        ],
        [
            'problem' => "You notice slight blue smoke during cold start that disappears after warming up.",
            'question' => "What is the most probable cause?",
            'options' => [
                ['text' => 'A) Worn valve stem seals allowing oil seepage overnight.', 'isCorrect' => true],
                ['text' => 'B) Cracked radiator hose.', 'isCorrect' => false],
                ['text' => 'C) Dirty air filter.', 'isCorrect' => false],
                ['text' => 'D) Weak alternator belt.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Oil sitting on valve stems overnight seeps into cylinders through worn seals, causing blue smoke on startup that fades once the seals expand with heat.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Worn valve stem seals.<br>Reason: Blue smoke on startup points to top-end oil leakage, not cooling or electrical issues.'
        ],
        [
            'problem' => "You perform a compression test, and readings show all cylinders are slightly low and uneven.",
            'question' => "What’s the best next diagnostic test to confirm ring wear?",
            'options' => [
                
                ['text' => 'A) Test the horn circuit.', 'isCorrect' => false],
                ['text' => 'B) Conduct a wet compression or leak-down test.', 'isCorrect' => true],
                ['text' => 'C) Replace fuel injectors.', 'isCorrect' => false],
                ['text' => 'D) Drain the brake fluid.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Adding oil in a wet compression test helps determine if worn piston rings are the source of pressure loss — higher readings confirm ring leakage.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Wet compression test.<br>Reason: This test isolates whether pressure loss comes from piston rings or valves, not fuel or brake systems.'
        ],
        [
            'problem' => "Wet compression test shows a significant pressure increase when oil is added to the cylinders.",
            'question' => "What does this result indicate?",
            'options' => [
                
                ['text' => 'A) Head gasket leak.', 'isCorrect' => false],
                ['text' => 'B) Weak ignition coil.', 'isCorrect' => false],
                ['text' => 'C) Worn piston rings causing blow-by and oil burning.', 'isCorrect' => true],
                ['text' => 'D) Faulty temperature sensor.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>The oil temporarily seals the piston rings, raising compression — confirming ring wear that allows both pressure and oil to pass into the combustion chamber.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Worn piston rings.<br>Reason: Only piston ring wear causes such improvement when oil is added; other faults don’t affect compression like this.'
        ],
        [
            'problem' => "You also inspect the PCV (Positive Crankcase Ventilation) valve and find it stuck closed.",
            'question' => "How can a blocked PCV valve contribute to oil consumption?",
            'options' => [
                ['text' => 'A) It increases crankcase pressure, forcing oil past seals and rings.', 'isCorrect' => true],
                ['text' => 'B) It reduces coolant flow through the radiator.', 'isCorrect' => false],
                ['text' => 'C) It decreases fuel injector pressure.', 'isCorrect' => false],
                ['text' => 'D) It weakens spark plug voltage.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>When crankcase gases can’t escape, pressure pushes oil into the intake or combustion chamber, mimicking ring or seal failure symptoms.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Blocked PCV increases crankcase pressure.<br>Reason: The PCV system controls internal ventilation — unrelated to coolant, fuel, or ignition systems.'
        ],
        [
            'problem' => "You clean and test the PCV system, but oil consumption remains high. There’s no external leak, but exhaust smoke continues under acceleration.",
            'question' => "What does blue smoke under load typically indicate?",
            'options' => [
                
                ['text' => 'A) Coolant boiling in the radiator.', 'isCorrect' => false],
                ['text' => 'B) Fuel injector leakage.', 'isCorrect' => false],
                ['text' => 'C) Dirty throttle body.', 'isCorrect' => false],
                ['text' => 'D) Oil passing piston rings during high cylinder pressure.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Blue smoke during acceleration shows that oil is entering the combustion chamber past worn piston rings under high compression load.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Oil passing piston rings.<br>Reason: Coolant or fuel faults create white or black smoke, not the blue haze typical of oil burning.'
        ],
        [
            'problem' => "You inspect spark plugs and find oily carbon deposits on several of them.",
            'question' => "What’s the proper next step to confirm internal oil burning?",
            'options' => [
                
                ['text' => 'A) Replace the battery.', 'isCorrect' => false],
                ['text' => 'B) Perform a borescope inspection of piston tops and cylinder walls.', 'isCorrect' => true],
                ['text' => 'C) Adjust throttle cable.', 'isCorrect' => false],
                ['text' => 'D) Add coolant flush.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A borescope allows visual confirmation of oil residue and scoring on piston walls, which verifies internal oil burning rather than external leakage.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Borescope inspection.<br>Reason: Only this test visually confirms oil entry into cylinders — electrical or cooling actions are unrelated.'
        ],
        [
            'problem' => "Borescope confirms oil residue and mild wall wear on two cylinders. Compression remains marginally acceptable.",
            'question' => "What’s the most cost-effective repair approach at this stage?",
            'options' => [
                
                ['text' => 'A) Immediately replace the entire engine block.', 'isCorrect' => false],
                ['text' => 'B) Repaint valve cover.', 'isCorrect' => false],
                ['text' => 'C) Replace clutch plate.', 'isCorrect' => false],
                ['text' => 'D) Replace valve stem seals and service the PCV system first before engine overhaul.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Addressing top-end leaks and PCV issues may significantly reduce oil consumption before resorting to expensive rebuilds.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Replace seals and service PCV first.<br>Reason: Minor internal wear can often be managed without full overhaul if leaks are isolated to the top end.'
        ],
        [
            'problem' => "After replacing valve stem seals and servicing PCV, oil consumption improves but still slightly exceeds normal limits.",
            'question' => "What should you recommend next to the customer?",
            'options' => [
                ['text' => 'A) Monitor oil usage closely and plan for ring and cylinder overhaul if it worsens.', 'isCorrect' => true],
                ['text' => 'B) Add thicker oil without diagnosis.', 'isCorrect' => false],
                ['text' => 'C) Drive faster to clear carbon.', 'isCorrect' => false],
                ['text' => 'D) Ignore the issue.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Moderate oil consumption after partial repair suggests ring wear. Continued monitoring ensures damage doesn’t accelerate before overhaul is scheduled.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Monitor and plan overhaul.<br>Reason: Increasing viscosity or ignoring symptoms only delays proper mechanical repair.'
        ],
        [
            'problem' => "The customer asks for maintenance tips to minimize future oil consumption.",
            'question' => "What preventive measure is most effective?",
            'options' => [
               
                ['text' => 'A) Overfill the crankcase slightly.', 'isCorrect' => false],
                ['text' => 'B) Use correct oil grade, change it on schedule, and clean the PCV system periodically.', 'isCorrect' => true],
                ['text' => 'C) Drive without warming up the engine.', 'isCorrect' => false],
                ['text' => 'D) Mix two oil grades for better viscosity.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Proper viscosity and timely oil changes prevent sludge formation and maintain sealing efficiency — reducing oil loss through rings and valves.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Maintain oil grade and PCV cleanliness.<br>Reason: Overfilling or mixing oils disrupts pressure balance and can worsen oil burning.'
        ]
    ]
],

'engine_misfire_under_load' => [
    'title' => 'Engine Misfire Under Load',
    'image' => 'https://images.unsplash.com/photo-1623752064448-04a4b43c9c3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Faulty ignition coil and worn spark plugs causing weak spark under high load conditions, combined with a partially clogged fuel injector on one cylinder.',
    'solution' => 'Replace defective ignition coil and spark plugs, clean the fuel injector, and verify proper ignition voltage and fuel pressure under load.',
    'learning' => 'A misfire under load usually indicates weak ignition or fuel delivery. Always diagnose systematically — start from ignition, then fuel, and finally mechanical compression.',

    'steps' => [
        [
            'problem' => "Customer complains that the engine shakes and loses power when accelerating or climbing hills, but idles smoothly.",
            'question' => "What’s the first system you should inspect to confirm the cause?",
            'options' => [
                ['text' => 'A) Ignition system (spark plugs, coils, and leads).', 'isCorrect' => true],
                ['text' => 'B) Cooling fan circuit.', 'isCorrect' => false],
                ['text' => 'C) Power window fuse.', 'isCorrect' => false],
                ['text' => 'D) Brake fluid reservoir.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Misfire under acceleration often happens when the ignition system can’t produce enough voltage to fire under cylinder pressure. Start diagnosis by checking spark plugs and coils.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Ignition system.<br>Reason: Load-related misfire points to weak spark, not unrelated systems like cooling or electrical accessories.'
        ],
        [
            'problem' => "You remove the spark plugs and find one plug with heavy carbon deposits and another with oil fouling.",
            'question' => "What does this pattern suggest?",
            'options' => [
                ['text' => 'A) Uneven combustion due to weak spark or oil entering a cylinder.', 'isCorrect' => true],
                ['text' => 'B) Low coolant in the radiator.', 'isCorrect' => false],
                ['text' => 'C) Misaligned serpentine belt.', 'isCorrect' => false],
                ['text' => 'D) Faulty headlight wiring.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Carbon and oil fouling indicate poor combustion efficiency — possibly weak ignition voltage or oil contamination in a specific cylinder.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Uneven combustion.<br>Reason: Spark plug deposits directly reflect combustion issues, not cooling or accessory faults.'
        ],
        [
            'problem' => "You test ignition coils with an oscilloscope and find one coil producing inconsistent secondary voltage spikes.",
            'question' => "What should you do next?",
            'options' => [
                
                ['text' => 'A) Replace the alternator.', 'isCorrect' => false],
                ['text' => 'B) Flush the coolant system.', 'isCorrect' => false],
                ['text' => 'C) Swap the suspect coil to another cylinder and retest misfire pattern.', 'isCorrect' => true],
                ['text' => 'D) Add engine oil additive.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Swapping coils is a simple and effective method to confirm if the misfire moves with the coil, verifying that it’s the actual fault component.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Swap and retest coil.<br>Reason: Coil-swap diagnosis isolates the fault — unrelated components won’t affect ignition performance.'
        ],
        [
            'problem' => "After swapping coils, the misfire follows the coil to a different cylinder.",
            'question' => "What does this result confirm?",
            'options' => [
                
                ['text' => 'A) The throttle cable is too loose.', 'isCorrect' => false],
                ['text' => 'B) The clutch is slipping.', 'isCorrect' => false],
                ['text' => 'C) The ignition coil is faulty and must be replaced.', 'isCorrect' => true],
                ['text' => 'D) The oxygen sensor is contaminated.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>When a misfire moves with the coil, it confirms a weak or intermittent coil output — the direct cause of load-related misfire.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Faulty ignition coil.<br>Reason: The misfire tracking the coil rules out other unrelated systems.'
        ],
        [
            'problem' => "You replace the faulty coil and clear error codes. After a test drive, the misfire improves but still occurs occasionally during hard acceleration.",
            'question' => "What should be the next area to check?",
            'options' => [
                
                ['text' => 'A) Steering fluid level.', 'isCorrect' => false],
                ['text' => 'B) Fuel injector performance and spray pattern.', 'isCorrect' => true],
                ['text' => 'C) Air filter cleanliness.', 'isCorrect' => false],
                ['text' => 'D) Door lock mechanism.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>If ignition is fixed but misfire persists, it may be due to restricted fuel flow or clogged injectors. Inspect injector spray using a balance or flow test.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Fuel injector check.<br>Reason: Misfire during load also occurs from uneven fuel delivery — not mechanical or accessory components.'
        ],
        [
            'problem' => "You perform an injector balance test and find cylinder 3 has a noticeably lower fuel drop than others.",
            'question' => "What’s the logical next repair step?",
            'options' => [
                
                ['text' => 'A) Replace the exhaust manifold.', 'isCorrect' => false],
                ['text' => 'B) Adjust alternator belt tension.', 'isCorrect' => false],
                ['text' => 'C) Add coolant sealer.', 'isCorrect' => false],
                ['text' => 'D) Clean or replace the injector on cylinder 3.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Low fuel drop means reduced injector flow — cleaning or replacing it ensures even fuel delivery to all cylinders for balanced combustion.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Clean/replace injector.<br>Reason: Exhaust or cooling components don’t influence injector flow rate.'
        ],
        [
            'problem' => "After cleaning the injector, all cylinders now show balanced fuel delivery. However, a slight misfire still occurs at high RPM.",
            'question' => "What should you verify next?",
            'options' => [
                
                ['text' => 'A) Coolant fan operation.', 'isCorrect' => false],
                ['text' => 'B) Brake pad thickness.', 'isCorrect' => false],
                ['text' => 'C) Engine compression and cylinder sealing.', 'isCorrect' => true],
                ['text' => 'D) Cabin filter condition.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Compression loss on one cylinder causes misfire under load because the air-fuel mixture fails to ignite effectively under high pressure.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Compression check.<br>Reason: Uneven compression can mimic ignition faults and must be ruled out before further repair.'
        ],
        [
            'problem' => "Compression readings are within specification, and misfire no longer occurs after replacing plugs, coil, and cleaning injectors.",
            'question' => "What final action ensures the repair is complete and reliable?",
            'options' => [
                ['text' => 'A) Perform a final road test and verify OBD live data for smooth ignition timing.', 'isCorrect' => true],
                ['text' => 'B) Replace the radiator fan motor.', 'isCorrect' => false],
                ['text' => 'C) Wash the engine bay.', 'isCorrect' => false],
                ['text' => 'D) Remove the catalytic converter.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A road test under load with live data ensures ignition timing, injector pulse, and coil activity remain stable — confirming no remaining misfire or fault codes.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Perform road test and verify live data.<br>Reason: Final confirmation ensures the issue is resolved before customer delivery.'
        ],
        [
            'problem' => "Customer asks how to prevent future misfires, especially when driving long distances or uphill.",
            'question' => "What’s the best preventive maintenance advice?",
            'options' => [
                
                ['text' => 'A) Overfill engine oil for lubrication.', 'isCorrect' => false],
                ['text' => 'B) Replace spark plugs at recommended intervals and use high-quality fuel.', 'isCorrect' => true],
                ['text' => 'C) Disconnect battery after every drive.', 'isCorrect' => false],
                ['text' => 'D) Avoid idling completely.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Fresh plugs and clean fuel maintain consistent ignition under high load. Following maintenance intervals prevents weak spark and injector clogging.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace spark plugs and use quality fuel.<br>Reason: Preventive maintenance targets combustion reliability — overfilling or disconnecting power provides no benefit.'
        ]
    ]
],

'engine_knocking_detonation' => [
    'title' => 'Engine Knocking and Detonation Noise',
    'image' => 'https://images.unsplash.com/photo-1619535908947-75794e2bdaa5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Premature combustion (detonation) caused by excessive carbon buildup, incorrect ignition timing, and use of low-octane fuel under high load.',
    'solution' => 'Clean combustion chambers, adjust ignition timing to specifications, and advise use of correct octane-rated fuel.',
    'learning' => 'Engine knock is often the result of improper timing or poor fuel quality. Early detection prevents piston and bearing damage. Always verify timing, compression ratio, and carbon deposits when diagnosing detonation.',

    'steps' => [
        [
            'problem' => "Customer reports a metallic 'pinging' or 'knocking' sound from the engine when accelerating, especially under load or uphill driving.",
            'question' => "What’s the most likely system to inspect first?",
            'options' => [
                
                ['text' => 'A) Power steering pump.', 'isCorrect' => false],
                ['text' => 'B) Radiator fan relay.', 'isCorrect' => false],
                ['text' => 'C) Door lock actuator.', 'isCorrect' => false],
                ['text' => 'D) Ignition timing and combustion system.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Knocking or pinging under acceleration often indicates incorrect ignition timing or detonation caused by poor combustion control. The timing system should always be checked first.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Ignition timing and combustion system.<br>Reason: Mechanical noises from accessories differ — detonation noise is internal and linked to timing or mixture issues.'
        ],
        [
            'problem' => "You scan for fault codes and find none, but live data shows ignition timing advance reaching 45° BTDC under load.",
            'question' => "What does this suggest?",
            'options' => [
                
                ['text' => 'A) Alternator output is low.', 'isCorrect' => false],
                ['text' => 'B) Air filter is slightly dirty.', 'isCorrect' => false],
                ['text' => 'C) Timing advance is excessive for the current load, risking detonation.', 'isCorrect' => true],
                ['text' => 'D) Coolant is too cold.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Excessive advance timing ignites the air-fuel mixture too early, causing multiple flame fronts and the metallic knock sound. Timing must match load and RPM.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Excessive timing advance.<br>Reason: Detonation is caused by early combustion, not air filtration or alternator issues.'
        ],
        [
            'problem' => "You verify the knock sensor function using a scan tool — it detects signal but the ECU shows no timing retard under knock condition.",
            'question' => "What should you do next?",
            'options' => [
                ['text' => 'A) Check knock sensor circuit and connection integrity.', 'isCorrect' => true],
                ['text' => 'B) Replace spark plugs immediately.', 'isCorrect' => false],
                ['text' => 'C) Inspect radiator cap pressure rating.', 'isCorrect' => false],
                ['text' => 'D) Refill transmission oil.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>If the ECU receives no valid signal to retard timing, a poor knock sensor connection or faulty wiring can prevent correction — allowing detonation to continue unchecked.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check knock sensor circuit.<br>Reason: Knock control relies on proper sensor feedback, not coolant or transmission components.'
        ],
        [
            'problem' => "Knock sensor wiring is intact. You inspect spark plugs and find heavy carbon deposits on all four plugs.",
            'question' => "What could this condition contribute to?",
            'options' => [
                
                ['text' => 'A) Excess coolant evaporation.', 'isCorrect' => false],
                ['text' => 'B) Pre-ignition and detonation due to carbon hot spots.', 'isCorrect' => true],
                ['text' => 'C) Belt misalignment.', 'isCorrect' => false],
                ['text' => 'D) Weak engine mounts.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Carbon buildup retains heat and can ignite the mixture prematurely — a key cause of knocking even when timing is correct. Cleaning combustion chambers is essential.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Carbon deposits causing pre-ignition.<br>Reason: Hot carbon particles create spontaneous ignition sources leading to detonation.'
        ],
        [
            'problem' => "You clean the plugs and combustion chambers, then use a borescope to inspect the piston tops — light carbon remains but no damage is seen.",
            'question' => "What’s the next diagnostic step?",
            'options' => [
                
                ['text' => 'A) Test windshield washer motor.', 'isCorrect' => false],
                ['text' => 'B) Verify brake pedal free play.', 'isCorrect' => false],
                ['text' => 'C) Check fuel quality and octane rating used by the customer.', 'isCorrect' => true],
                ['text' => 'D) Replace air filter immediately.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Using lower-octane fuel than recommended can lead to spontaneous combustion under compression — causing knock even with correct timing and clean components.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Check fuel octane.<br>Reason: Low octane reduces detonation resistance, leading to knock in high-compression or turbo engines.'
        ],
        [
            'problem' => "Customer confirms using regular 91-octane fuel, but the manufacturer recommends 95-octane for that engine.",
            'question' => "What is the appropriate immediate recommendation?",
            'options' => [
                
                ['text' => 'A) Add engine oil to fuel tank.', 'isCorrect' => false],
                ['text' => 'B) Drain and refill with correct 95-octane or higher fuel.', 'isCorrect' => true],
                ['text' => 'C) Replace radiator hoses.', 'isCorrect' => false],
                ['text' => 'D) Adjust tire pressure.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Incorrect octane fuel ignites too early, especially under load. Using manufacturer-specified fuel ensures proper combustion timing and prevents knock damage.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Use higher-octane fuel.<br>Reason: Octane rating determines resistance to pre-ignition, not unrelated maintenance items.'
        ],
        [
            'problem' => "After refueling with 95-octane, knock noise decreases but is still slightly present at high RPM.",
            'question' => "What adjustment should now be verified?",
            'options' => [
                
                ['text' => 'A) Idle air control valve position.', 'isCorrect' => false],
                ['text' => 'B) Coolant temperature gauge reading.', 'isCorrect' => false],
                ['text' => 'C) Base ignition timing with timing light according to manufacturer specs.', 'isCorrect' => true],
                ['text' => 'D) Cabin blower speed.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Improper base timing can still cause light knock — especially if the distributor or crank sensor is slightly out of calibration. Verifying timing ensures complete accuracy.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Verify base timing.<br>Reason: Knock intensity relates directly to spark advance; idle air or coolant readings don’t control combustion timing.'
        ],
        [
            'problem' => "You reset the ignition timing to specification and retest. Knock noise is now gone and performance is smooth.",
            'question' => "What final verification should you perform before returning the vehicle?",
            'options' => [
                ['text' => 'A) Road test under load and monitor knock sensor data for normal correction activity.', 'isCorrect' => true],
                ['text' => 'B) Replace wiper blades.', 'isCorrect' => false],
                ['text' => 'C) Inspect tail lamp operation.', 'isCorrect' => false],
                ['text' => 'D) Repaint engine cover.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Monitoring knock feedback ensures the ECU now responds correctly under load — confirming sensor, timing, and fuel quality are all functioning properly.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Road test and monitor knock data.<br>Reason: A complete test verifies that detonation control operates normally in real conditions.'
        ],
        [
            'problem' => "After the road test, all readings are stable and no knock is detected. The customer asks how to avoid recurrence.",
            'question' => "What’s the best maintenance advice to prevent future knocking?",
            'options' => [
                ['text' => 'A) Use manufacturer-recommended octane fuel and perform regular combustion cleaning.', 'isCorrect' => true],
                ['text' => 'B) Avoid long drives.', 'isCorrect' => false],
                ['text' => 'C) Always drive with A/C off.', 'isCorrect' => false],
                ['text' => 'D) Overfill the fuel tank.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Using proper octane and keeping the combustion chambers clean ensures stable combustion and prevents pre-ignition or carbon hot spots.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Use proper fuel and cleaning.<br>Reason: Preventive care maintains combustion efficiency and avoids detonation recurrence.'
        ]
    ]
],

'engine_stalling_idle' => [
    'title' => 'Engine Stalling at Idle',
    'image' => 'https://images.unsplash.com/photo-1602872029935-6603f5ccbdcf?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Carbon buildup and vacuum leaks affecting idle air control (IAC) valve operation, combined with dirty throttle body and unstable fuel delivery at low RPM.',
    'solution' => 'Clean throttle body and IAC valve, inspect vacuum hoses for leaks, verify fuel pressure, and perform ECU idle relearn procedure.',
    'learning' => 'When diagnosing stalling at idle, check the balance between air, fuel, and spark delivery. Carbon deposits, vacuum leaks, and incorrect idle control values are the most common causes.',

    'steps' => [
        [
            'problem' => "Customer complains the engine often stalls when stopping at traffic lights or when idling in neutral. Restarting the car is possible but the idle feels rough.",
            'question' => "What’s the first diagnostic step you should take?",
            'options' => [
                
                ['text' => 'A) Inspect tire pressure.', 'isCorrect' => false],
                ['text' => 'B) Test the horn function.', 'isCorrect' => false],
                ['text' => 'C) Observe the idle RPM and check for fluctuations or low idle speed.', 'isCorrect' => true],
                ['text' => 'D) Check wiper motor operation.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Before disassembly, visually confirm the idle condition. If the RPM fluctuates or drops below normal range, it points to an air or fuel delivery imbalance.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Observe idle RPM.<br>Reason: The issue occurs at idle, so checking engine load behavior is the first logical step.'
        ],
        [
            'problem' => "You observe that idle RPM drops to 500 rpm before stalling. When restarting, idle temporarily recovers to normal.",
            'question' => "Which component is responsible for maintaining stable idle speed?",
            'options' => [
                
                ['text' => 'A) Alternator pulley.', 'isCorrect' => false],
                ['text' => 'B) Radiator fan switch.', 'isCorrect' => false],
                ['text' => 'C) Fuel filler cap.', 'isCorrect' => false],
                ['text' => 'D) Idle Air Control (IAC) valve.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>The IAC valve regulates the amount of bypass air during idle. A sticking or carbon-coated IAC can cause unstable RPM or stalling when returning to idle.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Idle Air Control (IAC) valve.<br>Reason: The alternator or cooling system does not control idle airflow — the IAC does.'
        ],
        [
            'problem' => "You remove the IAC valve and find heavy carbon deposits around the valve pintle and throttle plate.",
            'question' => "What’s the correct next step?",
            'options' => [
                
                ['text' => 'A) Replace engine oil immediately.', 'isCorrect' => false],
                ['text' => 'B) Clean the throttle body and IAC valve using throttle cleaner.', 'isCorrect' => true],
                ['text' => 'C) Tighten battery terminals.', 'isCorrect' => false],
                ['text' => 'D) Adjust clutch cable.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Carbon buildup restricts airflow through the throttle and IAC passages. Cleaning restores the valve’s ability to respond correctly to ECU commands at idle.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Clean the throttle body and IAC.<br>Reason: Deposits in the air path are the direct cause of unstable idle.'
        ],
        [
            'problem' => "After cleaning, idle improves slightly but still dips occasionally. You spray carb cleaner around the intake area and notice RPM increases slightly near a hose joint.",
            'question' => "What does this result suggest?",
            'options' => [
                
                ['text' => 'A) Dirty fuel injectors.', 'isCorrect' => false],
                ['text' => 'B) Weak alternator bearing.', 'isCorrect' => false],
                ['text' => 'C) Vacuum leak at the intake hose or gasket.', 'isCorrect' => true],
                ['text' => 'D) Faulty coolant sensor.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>An increase in RPM when spraying carb cleaner indicates air is entering the system unmetered, confirming a vacuum leak. This causes lean mixture and idle instability.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Vacuum leak.<br>Reason: Only unmetered air entering after the throttle body causes this RPM reaction.'
        ],
        [
            'problem' => "You locate a cracked vacuum hose connected to the intake manifold.",
            'question' => "What should you do before replacing the hose?",
            'options' => [
                
                ['text' => 'A) Replace spark plugs.', 'isCorrect' => false],
                ['text' => 'B) Add coolant additive.', 'isCorrect' => false],
                ['text' => 'C) Check all other vacuum lines and fittings for similar cracks or leaks.', 'isCorrect' => true],
                ['text' => 'D) Disconnect the ECU.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Vacuum leaks often occur in multiple points, especially on older rubber hoses. Inspecting all lines prevents missing another air leak that could reintroduce the same symptom.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Check all vacuum lines.<br>Reason: Multiple leaks can exist simultaneously, so replacing only one without inspection isn’t reliable.'
        ],
        [
            'problem' => "After replacing all cracked hoses, idle is smoother but the RPM still fluctuates slightly when A/C or headlights are turned ON.",
            'question' => "Which system might not be compensating for additional electrical load?",
            'options' => [
                
                ['text' => 'A) Cooling fan relay.', 'isCorrect' => false],
                ['text' => 'B) Power steering fluid pump.', 'isCorrect' => false],
                ['text' => 'C) Cabin air filter.', 'isCorrect' => false],
                ['text' => 'D) Idle load compensation via ECU or alternator feedback.', 'isCorrect' => true]
            ],
            'feedbackCorrect' => '✅ Correct!<br>When load increases (like A/C or lights ON), the ECU should slightly raise idle speed. If it doesn’t, check alternator signal wiring or ECU idle control logic.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Idle load compensation.<br>Reason: This is an ECU-controlled function linked to idle control, not the cooling or steering system.'
        ],
        [
            'problem' => "You scan ECU data and notice short-term fuel trim is at -15% at idle, suggesting a rich mixture.",
            'question' => "What’s the most likely cause of a rich mixture at idle?",
            'options' => [
                ['text' => 'A) Contaminated or leaking fuel injector.', 'isCorrect' => true],
                ['text' => 'B) Air filter too clean.', 'isCorrect' => false],
                ['text' => 'C) Low brake fluid level.', 'isCorrect' => false],
                ['text' => 'D) Faulty radiator hose clamp.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Leaking injectors or poor spray patterns can deliver excess fuel at idle, over-enriching the mixture and causing roughness or stalling when O2 correction is limited.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Fuel injector issue.<br>Reason: Rich conditions are caused by excess fuel or poor air control, not unrelated mechanical parts.'
        ],
        [
            'problem' => "You clean and test the injectors; fuel trim normalizes. The engine idles steadily now. However, after battery disconnection, idle becomes unstable again.",
            'question' => "What procedure must be performed after cleaning or battery reset?",
            'options' => [
                ['text' => 'A) Idle relearn procedure via ECU.', 'isCorrect' => true],
                ['text' => 'B) Replace alternator belt.', 'isCorrect' => false],
                ['text' => 'C) Bleed brake lines.', 'isCorrect' => false],
                ['text' => 'D) Adjust wheel alignment.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>After cleaning or resetting power, the ECU forgets its idle parameters. Performing an idle relearn allows it to recalibrate airflow and fuel trim for stable idle operation.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Idle relearn.<br>Reason: ECU reset requires relearning idle parameters; mechanical parts are unaffected.'
        ],
        [
            'problem' => "After performing the idle relearn, the engine idles perfectly even under load. The customer asks how to maintain this condition.",
            'question' => "What maintenance advice should be provided?",
            'options' => [
                
                ['text' => 'A) Disconnect the battery often.', 'isCorrect' => false],
                ['text' => 'B) Clean throttle body and replace air filter periodically.', 'isCorrect' => true],
                ['text' => 'C) Never use the A/C.', 'isCorrect' => false],
                ['text' => 'D) Drive with fuel cap loose.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Periodic cleaning prevents carbon buildup on the throttle and idle control valve, maintaining smooth idle response and proper airflow control.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Regular throttle and filter maintenance.<br>Reason: Consistent airflow cleanliness ensures stable idle operation long-term.'
        ],
        [
            'problem' => "You confirm smooth idle after test drive — no stalling or fluctuations observed under various loads.",
            'question' => "What should be documented in the final report?",
            'options' => [
                ['text' => 'A) Idle speed, fuel trim data, and components cleaned/replaced.', 'isCorrect' => true],
                ['text' => 'B) Tire rotation sequence.', 'isCorrect' => false],
                ['text' => 'C) Radio preset numbers.', 'isCorrect' => false],
                ['text' => 'D) Windshield washer refill date.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Recording idle RPM, trim data, and service actions ensures traceability and helps identify future performance deviations.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Document idle and fuel data.<br>Reason: Professional documentation supports consistency in engine diagnostic history.'
        ]
    ]
],

'engine_rough_acceleration' => [
    'title' => 'Engine Hesitation or Rough Acceleration',
    'image' => 'https://images.unsplash.com/photo-1613687369289-2473dfc8cf7e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Irregular air-fuel mixture or weak spark during throttle increase caused by dirty MAF sensor, clogged fuel injectors, faulty ignition coil, or deteriorated spark plugs.',
    'solution' => 'Clean or replace the MAF sensor, ensure proper fuel pressure and injector spray pattern, replace faulty ignition components, and verify oxygen sensor feedback for smooth throttle transition.',
    'learning' => 'Rough acceleration happens when fuel delivery, air metering, and ignition timing fail to synchronize. Systematic step-by-step testing avoids unnecessary parts replacement.',

    'steps' => [
        [
            'problem' => "Customer reports the car jerks and hesitates when accelerating from a stop or merging onto the highway.",
            'question' => "What’s the most logical first check to perform?",
            'options' => [
                
                ['text' => 'A) Replace the tires immediately.', 'isCorrect' => false],
                ['text' => 'B) Check brake pad wear.', 'isCorrect' => false],
                ['text' => 'C) Scan for diagnostic trouble codes (DTCs) using an OBD-II scanner.', 'isCorrect' => true],
                ['text' => 'D) Top up windshield washer fluid.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Scanning for stored codes provides a baseline of possible electronic issues — misfire, sensor faults, or air/fuel imbalances often trigger the check engine light before mechanical symptoms appear.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Scan for DTCs.<br>Reason: Acceleration hesitation is related to combustion performance, not braking or cosmetic components.'
        ],
        [
            'problem' => "You scan and find no stored DTCs. However, live data shows fluctuating MAF (Mass Air Flow) readings when the throttle is opened steadily.",
            'question' => "What does unstable MAF data suggest?",
            'options' => [
                
                ['text' => 'A) Faulty alternator diode.', 'isCorrect' => false],
                ['text' => 'B) Weak horn relay.', 'isCorrect' => false],
                ['text' => 'C) Contaminated or faulty MAF sensor.', 'isCorrect' => true],
                ['text' => 'D) Low coolant temperature.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Erratic MAF readings cause the ECU to deliver inconsistent fuel quantities, leading to lean or rich mixtures during acceleration. Cleaning or replacing the sensor usually restores stable readings.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Dirty or failing MAF sensor.<br>Reason: Unstable airflow data directly affects acceleration smoothness — unrelated systems like the alternator or horn don’t.'
        ],
        [
            'problem' => "You clean the MAF sensor and retest. Acceleration improves slightly but occasional jerking remains under moderate throttle.",
            'question' => "What should you check next to confirm proper fuel delivery?",
            'options' => [
                ['text' => 'A) Measure fuel pressure at the rail using a pressure gauge.', 'isCorrect' => true],
                ['text' => 'B) Inspect radiator hoses.', 'isCorrect' => false],
                ['text' => 'C) Check transmission mount alignment.', 'isCorrect' => false],
                ['text' => 'D) Tighten battery terminals.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Fuel pressure testing verifies that the pump and regulator can maintain consistent flow under load — a weak pump or clogged filter often causes stuttering on acceleration.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check fuel pressure.<br>Reason: Acceleration depends on steady fuel supply; unrelated parts like radiator or mounts have no effect.'
        ],
        [
            'problem' => "Fuel pressure is slightly below specification at idle and drops further when revved.",
            'question' => "What’s the most likely cause of this pressure drop?",
            'options' => [
                
                ['text' => 'A) Overcharged A/C system.', 'isCorrect' => false],
                ['text' => 'B) Faulty wiper motor.', 'isCorrect' => false],
                ['text' => 'C) Loose wheel nuts.', 'isCorrect' => false],
                ['text' => 'D) Weak or failing fuel pump.', 'isCorrect' => true],
            ],
            'feedbackCorrect' => '✅ Correct!<br>A weak pump can’t maintain sufficient flow when demand rises, causing lean conditions that produce hesitation or surging during throttle input.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Weak fuel pump.<br>Reason: Only inadequate fuel pressure causes such a drop during acceleration.'
        ],
        [
            'problem' => "You replace the fuel pump and confirm correct pressure. The engine now accelerates better but still stumbles slightly at mid-range RPM.",
            'question' => "What’s the next logical step?",
            'options' => [
                
                ['text' => 'A) Refill brake fluid.', 'isCorrect' => false],
                ['text' => 'B) Check spark plugs and ignition coils for weak spark.', 'isCorrect' => true],
                ['text' => 'C) Replace radiator cap.', 'isCorrect' => false],
                ['text' => 'D) Inspect tire valve caps.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A partially fouled spark plug or weak ignition coil produces intermittent misfire under load. This often appears as a stumble during mid-acceleration even with good fuel pressure.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Inspect spark plugs and coils.<br>Reason: Ignition faults are a major cause of rough or inconsistent throttle response.'
        ],
        [
            'problem' => "You find one spark plug heavily worn and its coil slightly corroded at the connector.",
            'question' => "What repair action is best in this case?",
            'options' => [
                
                ['text' => 'A) Spray WD-40 on the plug and reinstall it.', 'isCorrect' => false],
                ['text' => 'B) Increase plug gap manually.', 'isCorrect' => false],
                ['text' => 'C) Disconnect the oxygen sensor.', 'isCorrect' => false],
                ['text' => 'D) Replace both the spark plug and ignition coil for that cylinder.', 'isCorrect' => true],
            ],
            'feedbackCorrect' => '✅ Correct!<br>Replacing both ensures complete spark restoration — corroded coil terminals increase resistance, while worn plugs struggle to ignite a compressed mixture effectively.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Replace plug and coil.<br>Reason: Temporary cleaning can’t fix weak spark performance under engine load.'
        ],
        [
            'problem' => "After replacing the components, acceleration improves further but slight hesitation occurs at light throttle cruising speed.",
            'question' => "Which sensor could cause this if it feeds incorrect feedback to the ECU?",
            'options' => [
                ['text' => 'A) Oxygen (O2) sensor giving incorrect mixture data.', 'isCorrect' => true],
                ['text' => 'B) Coolant temperature sensor.', 'isCorrect' => false],
                ['text' => 'C) Crankshaft position sensor.', 'isCorrect' => false],
                ['text' => 'D) Intake air temperature sensor.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A slow or contaminated O2 sensor sends false mixture readings, causing the ECU to constantly overcorrect fuel trim, leading to surging or hesitation during cruise acceleration.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Faulty O2 sensor.<br>Reason: Incorrect oxygen feedback confuses the ECU’s air-fuel balance, especially under partial throttle.'
        ],
        [
            'problem' => "You replace the O2 sensor and reset adaptive fuel trims. The engine now accelerates smoothly with no hesitation.",
            'question' => "What final verification should be done before returning the car?",
            'options' => [
               
                ['text' => 'A) Measure wheel alignment.', 'isCorrect' => false],
                ['text' => 'B) Replace engine oil immediately.', 'isCorrect' => false],
                ['text' => 'C) Road-test under various load conditions and monitor live fuel trim data.', 'isCorrect' => true],
                ['text' => 'D) Inspect tail light bulbs.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Live data monitoring confirms stable short- and long-term fuel trims under acceleration and cruise, proving proper combustion and sensor feedback response.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Perform dynamic road-test.<br>Reason: This ensures all engine systems maintain balance under real load conditions.'
        ],
        [
            'problem' => "After the test drive, performance is restored and acceleration is linear. The customer asks how to prevent this issue in the future.",
            'question' => "What maintenance advice should you give?",
            'options' => [
                
                ['text' => 'A) Avoid changing spark plugs regularly.', 'isCorrect' => false],
                ['text' => 'B) Use quality fuel and clean the MAF sensor every 6–12 months.', 'isCorrect' => true],
                ['text' => 'C) Overfill fuel tank at every refill.', 'isCorrect' => false],
                ['text' => 'D) Spray lubricant into intake manifold.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Clean fuel and sensors prevent carbon buildup and data inaccuracy. Periodic MAF cleaning maintains proper air metering, ensuring smooth throttle response long-term.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Use quality fuel and clean MAF periodically.<br>Reason: Preventive maintenance keeps sensors and injectors operating within calibrated parameters.'
        ],
        [
            'problem' => "You document the repair and show before-and-after fuel trim graphs to the customer.",
            'question' => "Why is this documentation valuable for future reference?",
            'options' => [
                
                ['text' => 'A) It increases resale value automatically.', 'isCorrect' => false],
                ['text' => 'B) It prevents exhaust smoke forever.', 'isCorrect' => false],
                ['text' => 'C) It validates the diagnostic process and helps identify early sensor degradation later.', 'isCorrect' => true],
                ['text' => 'D) It adjusts the idle speed automatically.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Keeping sensor and fuel trim data provides a benchmark for future diagnostics, proving that the issue was properly resolved and ensuring consistency in engine performance.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Data documentation validates diagnostics.<br>Reason: Technical data logging is standard practice in professional automotive servicing.'
        ]
    ]
],


'engine_hard_start_when_hot' => [
    'title' => 'Engine Hard to Start When Hot',
    'image' => 'https://images.unsplash.com/photo-1583912268184-f0b0a8f6e9b5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
    'root_cause' => 'Fuel pressure regulator internal leak causing loss of fuel pressure after shutdown, leading to vapor lock and hard restart when engine heat soaks the fuel rail.',
    'solution' => 'Replace faulty fuel pressure regulator, inspect injector seals, and verify residual pressure holds after shutdown according to specifications.',
    'learning' => 'A hot start issue often relates to fuel system pressure loss or vapor formation. Always check fuel pressure retention, injector leakage, and sensor data when diagnosing heat-related starting failures.',

    'steps' => [
        [
            'problem' => "Customer complains that the engine starts fine when cold, but after driving for a while and shutting off, it cranks long or fails to start when restarted within 10–20 minutes.",
            'question' => "What’s the first diagnostic area to check?",
            'options' => [
                ['text' => 'A) Fuel delivery system (pressure and retention).', 'isCorrect' => true],
                ['text' => 'B) Cooling system coolant level.', 'isCorrect' => false],
                ['text' => 'C) Tire pressure.', 'isCorrect' => false],
                ['text' => 'D) Air conditioning compressor clutch.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>A hard start when hot usually points to fuel delivery or vaporization issues. Checking fuel pressure and residual hold after shutdown is the logical first step in diagnosis.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Fuel delivery system.<br>Reason: Cooling or tire systems don’t affect starting sequence — this symptom aligns with pressure loss or fuel vapor lock.'
        ],
        [
            'problem' => "You connect a fuel pressure gauge and record 42 psi during idle. After shutting the engine off, the pressure drops to 0 psi within 30 seconds.",
            'question' => "What does this rapid pressure loss suggest?",
            'options' => [
                ['text' => 'A) Internal leak in fuel pressure regulator or injector.', 'isCorrect' => true],
                ['text' => 'B) Weak ignition coil.', 'isCorrect' => false],
                ['text' => 'C) Low coolant temperature.', 'isCorrect' => false],
                ['text' => 'D) Sticking throttle plate.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Fuel pressure should remain steady for minutes after shutdown. A fast drop means fuel is escaping back into the tank (check valve failure) or into the intake (leaking injector/regulator).',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Internal leak in fuel pressure regulator or injector.<br>Reason: Ignition or cooling issues wouldn’t cause rapid fuel pressure decay.'
        ],
        [
            'problem' => "You inspect the fuel rail area but see no external leaks or fuel smell.",
            'question' => "What’s the next diagnostic action to confirm the internal leak source?",
            'options' => [
                
                ['text' => 'A) Replace the spark plugs.', 'isCorrect' => false],
                ['text' => 'B) Spray carb cleaner on intake gasket.', 'isCorrect' => false],
                ['text' => 'C) Pinch the return line and observe if pressure holds.', 'isCorrect' => true],
                ['text' => 'D) Bleed the cooling system.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Clamping the return line isolates the regulator. If pressure now holds, the leak is inside the regulator. If it still drops, the injector(s) are leaking into the cylinders.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Pinch the return line and observe pressure.<br>Reason: Only isolating the return side can differentiate between regulator or injector leakage.'
        ],
        [
            'problem' => "After pinching the return line, pressure still drops rapidly. No fuel seen externally.",
            'question' => "What’s the next logical test to locate the leak path?",
            'options' => [
                
                ['text' => 'A) Test alternator output.', 'isCorrect' => false],
                ['text' => 'B) Check spark plugs for fuel wetness after sitting.', 'isCorrect' => true],
                ['text' => 'C) Inspect battery fluid level.', 'isCorrect' => false],
                ['text' => 'D) Measure tire tread depth.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>If injectors leak internally, residual pressure pushes fuel into the cylinders, leaving one or more plugs wet. This confirms injector seepage rather than regulator fault.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check spark plugs for wetness.<br>Reason: Fuel leaking into cylinders only shows through plug inspection, not electrical or battery tests.'
        ],
        [
            'problem' => "You find one spark plug wet with fuel after a hot soak period, confirming an injector leak.",
            'question' => "What’s the best next repair step?",
            'options' => [
                
                ['text' => 'A) Clean the throttle body.', 'isCorrect' => false],
                ['text' => 'B) Replace the faulty injector and recheck fuel pressure retention.', 'isCorrect' => true],
                ['text' => 'C) Flush the radiator coolant.', 'isCorrect' => false],
                ['text' => 'D) Adjust the clutch cable.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Replacing the leaking injector restores proper fuel sealing. Always recheck residual pressure after replacement to verify system integrity.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace the faulty injector.<br>Reason: Other actions don’t correct the root cause — excess fuel entering the combustion chamber during hot soak.'
        ],
        [
            'problem' => "After replacing the injector, the hot start improves but cranking is still slightly longer than normal after heat soak.",
            'question' => "What additional component might contribute to this symptom?",
            'options' => [
                ['text' => 'A) Fuel pressure regulator leaking internally.', 'isCorrect' => true],
                ['text' => 'B) Radiator fan relay.', 'isCorrect' => false],
                ['text' => 'C) Engine mount bushing.', 'isCorrect' => false],
                ['text' => 'D) A/C compressor clutch coil.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>An internal diaphragm leak in the regulator lets fuel seep into the vacuum port or return line, dropping pressure each shutdown — worsening hot starts.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Fuel pressure regulator leak.<br>Reason: Other listed parts are unrelated to the fuel holding circuit.'
        ],
        [
            'problem' => "You disconnect the regulator vacuum hose and find it smells strongly of fuel.",
            'question' => "What does this confirm?",
            'options' => [
                
                ['text' => 'A) The intake manifold gasket is leaking air.', 'isCorrect' => false],
                ['text' => 'B) The spark plugs are worn.', 'isCorrect' => false],
                ['text' => 'C) The thermostat is stuck open.', 'isCorrect' => false],
                ['text' => 'D) The regulator diaphragm is ruptured, allowing fuel into the vacuum line.', 'isCorrect' => true],
            ],
            'feedbackCorrect' => '✅ Correct!<br>Fuel in the vacuum line confirms a ruptured regulator diaphragm. This causes flooding during hot restarts as liquid fuel enters directly into the intake manifold.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: D) Regulator diaphragm rupture.<br>Reason: Air or spark issues can’t cause raw fuel to enter the vacuum line.'
        ],
        [
            'problem' => "You install a new pressure regulator and recheck system pressure — now it holds steady at 40 psi for 10 minutes after shutdown.",
            'question' => "What’s the next step to verify the repair’s effectiveness?",
            'options' => [
                
                ['text' => 'A) Replace the cabin air filter.', 'isCorrect' => false],
                ['text' => 'B) Adjust idle speed manually.', 'isCorrect' => false],
                ['text' => 'C) Perform a hot restart test after full heat soak.', 'isCorrect' => true],
                ['text' => 'D) Clean exterior engine cover.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Simulating the same hot-start condition confirms whether pressure retention solved the delay. Always retest under the same heat load as the original complaint.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: C) Hot restart test.<br>Reason: Only real-condition testing verifies the success of a fuel pressure-related fix.'
        ],
        [
            'problem' => "After a hot soak test, the engine starts instantly. Fuel pressure and sensor readings are within normal limits.",
            'question' => "What final step ensures the issue is completely resolved and documented?",
            'options' => [
                ['text' => 'A) Record pressure readings, parts replaced, and customer symptoms in the service log.', 'isCorrect' => true],
                ['text' => 'B) Add more refrigerant gas.', 'isCorrect' => false],
                ['text' => 'C) Replace spark plug wires for no reason.', 'isCorrect' => false],
                ['text' => 'D) Wash the throttle body again.', 'isCorrect' => false]
            ],
            'feedbackCorrect' => '✅ Correct!<br>Recording the diagnosis and repair process maintains professional accountability and helps trace recurring fuel issues in future visits.',
            'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Record service log.<br>Reason: Documentation is a required best practice to track performance and ensure repeat consistency.'
        ]
    ]
],







    ];

    $scenarioMapping = [
    'car_wont_start' => '1.0',
    'engine_overheating' => '1.1',
    'unusual_engine_noise' => '1.2',
    'low_oil_pressure_warning' => '1.3',
    'excessive_oil_consumption' => '1.4',
    'engine_misfire_under_load' => '1.5',
    'engine_knocking_detonation' => '1.6',
    'engine_stalling_idle' => '1.7',
    'engine_rough_acceleration' => '1.8',
    'engine_hard_start_when_hot' => '1.9',
    
   



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
            'Engine Problems', //
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