<?php
$scenarios = [
    'fuel_pump_failure' => [
        'title' => 'Fuel Pump Not Working',
        'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Internal fuel pump motor failure preventing fuel delivery to the engine.',
        'solution' => 'Replace the fuel pump assembly and verify electrical connections and fuel pressure.',
        'learning' => 'Always test electrical supply before replacing expensive fuel system components.',
        'steps' => [
            [
                'problem' => "Engine cranks but won't start. No fuel pump priming sound when key is turned to ON position.",
                'question' => "What should be the first diagnostic step?",
                'options' => [
                    ['text' => 'A) Replace the fuel pump immediately.', 'isCorrect' => false],
                    ['text' => 'B) Check the fuel pump fuse and relay.', 'isCorrect' => true],
                    ['text' => 'C) Clean the fuel injectors.', 'isCorrect' => false],
                    ['text' => 'D) Replace the fuel filter.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Always check electrical components first. A blown fuse or faulty relay is common and inexpensive compared to fuel pump replacement.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check the fuel pump fuse and relay.<br>Reason: Start with simple electrical checks before replacing expensive components.'
            ],
            [
                'problem' => "Fuse is intact and relay clicks audibly, but still no pump sound or fuel pressure.",
                'question' => "What should be checked next?",
                'options' => [
                    ['text' => 'A) Test fuel pressure at the rail with a gauge.', 'isCorrect' => true],
                    ['text' => 'B) Replace the fuel filter immediately.', 'isCorrect' => false],
                    ['text' => 'C) Check the air filter condition.', 'isCorrect' => false],
                    ['text' => 'D) Test the ignition system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Direct pressure testing confirms whether the pump is delivering fuel, even if it\'s not making the usual priming sound.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Test fuel pressure at the rail with a gauge.<br>Reason: Pressure testing verifies actual fuel delivery performance.'
            ],
            [
                'problem' => "Fuel pressure test shows 0 PSI. Electrical supply to pump connector shows proper 12V.",
                'question' => "What does this confirm about the fuel pump?",
                'options' => [
                    ['text' => 'A) Fuel pump motor has failed internally.', 'isCorrect' => true],
                    ['text' => 'B) Fuel filter is completely blocked.', 'isCorrect' => false],
                    ['text' => 'C) Fuel pressure regulator is faulty.', 'isCorrect' => false],
                    ['text' => 'D) Fuel injectors are clogged.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>With proper electrical supply but zero pressure, the pump motor has failed internally and cannot generate pressure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Fuel pump motor has failed internally.<br>Reason: Good electrical supply + zero pressure = internal pump failure.'
            ]
        ]
    ],
    'clogged_fuel_filter' => [
        'title' => 'Blocked Fuel Filter',
        'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Severely clogged fuel filter restricting fuel flow to the engine under load conditions.',
        'solution' => 'Replace the fuel filter and check fuel quality for contamination sources.',
        'learning' => 'Fuel filters should be replaced at regular intervals. Contaminated fuel accelerates filter clogging.',
        'steps' => [
            [
                'problem' => "Engine starts fine but stalls under acceleration or heavy load. Rough idle is also noticed.",
                'question' => "What fuel system component should be suspected first?",
                'options' => [
                    ['text' => 'A) Fuel injectors are completely failed.', 'isCorrect' => false],
                    ['text' => 'B) Fuel filter is partially blocked.', 'isCorrect' => true],
                    ['text' => 'C) Fuel pump is completely dead.', 'isCorrect' => false],
                    ['text' => 'D) Fuel tank is contaminated.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Partial blockage allows enough fuel for idle but restricts flow under higher demand, causing stalling under load.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Fuel filter is partially blocked.<br>Reason: Complete failures would prevent starting entirely. Partial blockage matches the symptoms.'
            ],
            [
                'problem' => "Fuel pressure testing shows adequate pressure at idle but drops significantly under load.",
                'question' => "What does this pressure pattern confirm?",
                'options' => [
                    ['text' => 'A) Fuel filter restriction preventing adequate flow under demand.', 'isCorrect' => true],
                    ['text' => 'B) Fuel pump operating normally.', 'isCorrect' => false],
                    ['text' => 'C) Fuel pressure regulator working correctly.', 'isCorrect' => false],
                    ['text' => 'D) No fuel system problems exist.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Pressure drop under load indicates flow restriction, typically from a clogged filter that cannot meet increased demand.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Fuel filter restriction preventing adequate flow under demand.<br>Reason: Pressure drop under load specifically indicates flow restriction.'
            ],
            [
                'problem' => "Fuel filter is confirmed blocked and needs replacement.",
                'question' => "What additional check should be performed during filter replacement?",
                'options' => [
                    ['text' => 'A) Check fuel quality and look for contamination.', 'isCorrect' => true],
                    ['text' => 'B) Only replace the filter.', 'isCorrect' => false],
                    ['text' => 'C) Replace the fuel pump simultaneously.', 'isCorrect' => false],
                    ['text' => 'D) Clean the fuel tank immediately.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Checking fuel quality helps identify contamination sources that caused premature filter clogging and may require additional action.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check fuel quality and look for contamination.<br>Reason: Understanding why the filter clogged prevents premature failure of the new filter.'
            ]
        ]
    ],
    'fuel_injector_problems' => [
        'title' => 'Dirty Fuel Injectors',
        'image' => 'https://images.unsplash.com/photo-1615906655593-ad0386982a0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Carbon deposits and fuel varnish blocking injector spray patterns causing poor combustion.',
        'solution' => 'Clean fuel injectors professionally or replace if severely damaged, and use quality fuel.',
        'learning' => 'Regular fuel system cleaning and quality fuel prevent injector deposits. Poor fuel quality accelerates injector fouling.',
        'steps' => [
            [
                'problem' => "Engine misfires, poor fuel economy, and black smoke from exhaust are observed.",
                'question' => "What fuel system problem do these symptoms indicate?",
                'options' => [
                    ['text' => 'A) Fuel pump pressure too high.', 'isCorrect' => false],
                    ['text' => 'B) Dirty or clogged fuel injectors.', 'isCorrect' => true],
                    ['text' => 'C) Fuel tank is empty.', 'isCorrect' => false],
                    ['text' => 'D) Fuel filter is too clean.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Dirty injectors cause poor spray patterns leading to incomplete combustion, resulting in misfires, poor economy, and black smoke.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Dirty or clogged fuel injectors.<br>Reason: These symptoms specifically indicate poor fuel atomization from dirty injectors.'
            ],
            [
                'problem' => "Fuel injector cleaning is recommended for the misfiring engine.",
                'question' => "What is the most effective injector cleaning method?",
                'options' => [
                    ['text' => 'A) Add fuel system cleaner to the gas tank only.', 'isCorrect' => false],
                    ['text' => 'B) Professional ultrasonic cleaning or on-car cleaning service.', 'isCorrect' => true],
                    ['text' => 'C) Replace all injectors immediately.', 'isCorrect' => false],
                    ['text' => 'D) Clean injectors with compressed air only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Professional cleaning removes deposits effectively without damage. Tank additives alone may not clean severely clogged injectors.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Professional ultrasonic cleaning or on-car cleaning service.<br>Reason: Professional cleaning is most effective for removing stubborn deposits safely.'
            ],
            [
                'problem' => "After injector cleaning, engine performance has improved but not completely.",
                'question' => "What should be checked if problems persist after cleaning?",
                'options' => [
                    ['text' => 'A) Individual injector spray patterns and flow rates.', 'isCorrect' => true],
                    ['text' => 'B) Engine oil level only.', 'isCorrect' => false],
                    ['text' => 'C) Transmission fluid condition.', 'isCorrect' => false],
                    ['text' => 'D) Tire pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Testing individual injector performance identifies which specific injectors may need replacement if cleaning was insufficient.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Individual injector spray patterns and flow rates.<br>Reason: Some injectors may be too damaged to clean effectively and require replacement.'
            ]
        ]
    ],
    'fuel_pressure_regulator' => [
        'title' => 'Faulty Pressure Regulator',
        'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Fuel pressure regulator not maintaining correct fuel pressure causing rich or lean running conditions.',
        'solution' => 'Replace the fuel pressure regulator and verify proper fuel pressure across all operating conditions.',
        'learning' => 'Proper fuel pressure is critical for optimal engine performance. Too high or low pressure affects fuel mixture.',
        'steps' => [
            [
                'problem' => "Engine runs rich with fuel smell and poor idle quality. Fuel pressure is consistently high.",
                'question' => "What component is likely causing excessive fuel pressure?",
                'options' => [
                    ['text' => 'A) Weak fuel pump.', 'isCorrect' => false],
                    ['text' => 'B) Stuck fuel pressure regulator.', 'isCorrect' => true],
                    ['text' => 'C) Clogged fuel filter.', 'isCorrect' => false],
                    ['text' => 'D) Dirty air filter.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>A stuck regulator cannot relieve excess pressure, causing high fuel pressure and rich running conditions.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Stuck fuel pressure regulator.<br>Reason: High pressure specifically indicates regulator failure to control pressure properly.'
            ],
            [
                'problem' => "Fuel pressure regulator is suspected of being stuck closed.",
                'question' => "How can you test the pressure regulator function?",
                'options' => [
                    ['text' => 'A) Apply vacuum to the regulator and observe pressure change.', 'isCorrect' => true],
                    ['text' => 'B) Disconnect the fuel pump.', 'isCorrect' => false],
                    ['text' => 'C) Remove all fuel injectors.', 'isCorrect' => false],
                    ['text' => 'D) Check engine oil pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Applying vacuum should cause pressure to drop as the regulator opens. No change indicates a stuck regulator.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Apply vacuum to the regulator and observe pressure change.<br>Reason: Vacuum testing directly verifies regulator operation.'
            ],
            [
                'problem' => "Pressure regulator does not respond to vacuum application.",
                'question' => "What repair action is required?",
                'options' => [
                    ['text' => 'A) Replace the faulty pressure regulator.', 'isCorrect' => true],
                    ['text' => 'B) Adjust the existing regulator.', 'isCorrect' => false],
                    ['text' => 'C) Clean the regulator with solvent.', 'isCorrect' => false],
                    ['text' => 'D) Install a bypass valve.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>A non-responsive regulator is internally damaged and must be replaced to restore proper pressure control.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace the faulty pressure regulator.<br>Reason: Internal damage cannot be repaired; replacement is the only solution.'
            ]
        ]
    ],
    'fuel_rail_leak' => [
        'title' => 'Fuel Rail Leak',
        'image' => 'https://images.unsplash.com/photo-1580813904443-5e525be5c11c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'O-ring or connection failure in fuel rail causing external fuel leaks and pressure loss.',
        'solution' => 'Replace damaged O-rings or connections and pressure test the entire fuel rail system.',
        'learning' => 'Fuel rail leaks are serious safety hazards. Any fuel leak near ignition sources requires immediate repair.',
        'steps' => [
            [
                'problem' => "Strong fuel odor is detected in the engine compartment and fuel stains are visible.",
                'question' => "What is the immediate safety concern with fuel leaks?",
                'options' => [
                    ['text' => 'A) Reduced fuel economy only.', 'isCorrect' => false],
                    ['text' => 'B) Fire hazard from fuel vapor ignition.', 'isCorrect' => true],
                    ['text' => 'C) Engine will run better.', 'isCorrect' => false],
                    ['text' => 'D) No safety concerns exist.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Fuel leaks create fire hazards, especially near hot engine components or electrical sources. Immediate repair is essential.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Fire hazard from fuel vapor ignition.<br>Reason: Fuel vapor is extremely flammable and poses serious fire risk.'
            ],
            [
                'problem' => "Visual inspection reveals fuel leaking from fuel rail connections.",
                'question' => "What should be checked at the fuel rail connections?",
                'options' => [
                    ['text' => 'A) O-ring condition and connection tightness.', 'isCorrect' => true],
                    ['text' => 'B) Fuel quality only.', 'isCorrect' => false],
                    ['text' => 'C) Engine timing.', 'isCorrect' => false],
                    ['text' => 'D) Coolant level.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Fuel rail leaks typically occur at O-ring seals or loose connections. Both should be inspected and repaired.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) O-ring condition and connection tightness.<br>Reason: These are the most common leak points in fuel rail systems.'
            ],
            [
                'problem' => "Damaged O-rings are found at multiple fuel rail connections.",
                'question' => "What is the proper repair procedure?",
                'options' => [
                    ['text' => 'A) Replace all damaged O-rings and pressure test the system.', 'isCorrect' => true],
                    ['text' => 'B) Apply sealant over the old O-rings.', 'isCorrect' => false],
                    ['text' => 'C) Tighten connections without replacing O-rings.', 'isCorrect' => false],
                    ['text' => 'D) Ignore minor leaks.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Replace all damaged O-rings with proper fuel-resistant ones and pressure test to verify no leaks remain.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace all damaged O-rings and pressure test the system.<br>Reason: Proper O-rings are the only reliable seal for high-pressure fuel systems.'
            ]
        ]
    ],
    'fuel_contamination' => [
        'title' => 'Contaminated Fuel',
        'image' => 'https://images.unsplash.com/photo-1566140804584-36b831df7c04?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Water or debris contamination in fuel system causing engine performance problems and component damage.',
        'solution' => 'Drain contaminated fuel, clean fuel system components, and refill with clean fuel.',
        'learning' => 'Fuel contamination can cause expensive damage. Always use quality fuel and avoid suspicious fuel sources.',
        'steps' => [
            [
                'problem' => "Engine runs rough, misfires, and hesitates. Problem started after filling up at an unfamiliar gas station.",
                'question' => "What should be suspected based on the timing of symptoms?",
                'options' => [
                    ['text' => 'A) Normal engine wear.', 'isCorrect' => false],
                    ['text' => 'B) Contaminated fuel from the recent fill-up.', 'isCorrect' => true],
                    ['text' => 'C) Transmission problems.', 'isCorrect' => false],
                    ['text' => 'D) Air conditioning failure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Symptoms appearing immediately after refueling strongly suggest fuel contamination from the fuel source.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Contaminated fuel from the recent fill-up.<br>Reason: Timing of symptoms directly correlates with fuel source.'
            ],
            [
                'problem' => "Fuel contamination is suspected.",
                'question' => "How can you verify fuel contamination?",
                'options' => [
                    ['text' => 'A) Take a fuel sample and inspect for water or debris.', 'isCorrect' => true],
                    ['text' => 'B) Check engine oil only.', 'isCorrect' => false],
                    ['text' => 'C) Test the battery voltage.', 'isCorrect' => false],
                    ['text' => 'D) Inspect the exhaust system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>A fuel sample can reveal water separation, debris, or off-color fuel indicating contamination.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Take a fuel sample and inspect for water or debris.<br>Reason: Direct fuel sampling is the most reliable contamination test.'
            ],
            [
                'problem' => "Fuel sample shows water separation and debris particles.",
                'question' => "What is the necessary repair procedure for contaminated fuel?",
                'options' => [
                    ['text' => 'A) Add fuel system cleaner and continue driving.', 'isCorrect' => false],
                    ['text' => 'B) Drain fuel tank, clean system, and refill with clean fuel.', 'isCorrect' => true],
                    ['text' => 'C) Replace only the fuel filter.', 'isCorrect' => false],
                    ['text' => 'D) Wait for contamination to settle.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Contaminated fuel must be completely removed and the system cleaned to prevent damage to fuel system components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Drain fuel tank, clean system, and refill with clean fuel.<br>Reason: Contaminated fuel will continue causing problems until completely removed.'
            ]
        ]
    ],
    'fuel_pump_relay' => [
        'title' => 'Fuel Pump Relay Failure',
        'image' => 'https://images.unsplash.com/photo-1614729939124-032bb9ac2b45?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Faulty fuel pump relay preventing electrical power from reaching the fuel pump motor.',
        'solution' => 'Replace the faulty fuel pump relay and verify proper electrical connections.',
        'learning' => 'Relays are inexpensive but critical components. Always test relays before replacing expensive fuel pumps.',
        'steps' => [
            [
                'problem' => "Engine cranks but won't start. No fuel pump priming sound, but all fuses appear good.",
                'question' => "What electrical component should be tested next?",
                'options' => [
                    ['text' => 'A) Fuel pump motor windings.', 'isCorrect' => false],
                    ['text' => 'B) Fuel pump relay operation.', 'isCorrect' => true],
                    ['text' => 'C) Alternator output.', 'isCorrect' => false],
                    ['text' => 'D) Starter motor current.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The relay controls power to the fuel pump. A faulty relay prevents pump operation even with good fuses.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Fuel pump relay operation.<br>Reason: Relays fail more often than pump motors and are much less expensive to replace.'
            ],
            [
                'problem' => "Fuel pump relay is suspected of being faulty.",
                'question' => "What is the quickest field test for relay operation?",
                'options' => [
                    ['text' => 'A) Swap with an identical relay from another circuit.', 'isCorrect' => true],
                    ['text' => 'B) Disassemble the relay for inspection.', 'isCorrect' => false],
                    ['text' => 'C) Test with complex electrical equipment only.', 'isCorrect' => false],
                    ['text' => 'D) Replace the relay without testing.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Swapping with another identical relay (like A/C clutch or horn relay) quickly determines if the relay is faulty.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Swap with an identical relay from another circuit.<br>Reason: Relay swapping is the fastest and most practical field test method.'
            ],
            [
                'problem' => "Engine starts and runs normally with the swapped relay.",
                'question' => "What does this test result confirm?",
                'options' => [
                    ['text' => 'A) The original relay was faulty and needs replacement.', 'isCorrect' => true],
                    ['text' => 'B) The fuel pump is completely failed.', 'isCorrect' => false],
                    ['text' => 'C) The wiring harness is damaged.', 'isCorrect' => false],
                    ['text' => 'D) The fuel filter is blocked.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Normal operation with a different relay proves the original relay was faulty while all other components work properly.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) The original relay was faulty and needs replacement.<br>Reason: Successful operation with different relay isolates the problem to the original relay.'
            ]
        ]
    ],
    'fuel_tank_venting' => [
        'title' => 'Fuel Tank Venting Problems',
        'image' => 'https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Blocked fuel tank vent or EVAP system preventing proper tank pressure equalization.',
        'solution' => 'Clear blocked vents or repair EVAP system components to restore proper tank venting.',
        'learning' => 'Fuel tanks must breathe properly. Venting problems can cause fuel delivery issues and tank damage.',
        'steps' => [
            [
                'problem' => "Engine starts fine but stalls after driving for 10-15 minutes. Removing fuel cap makes a loud hissing sound.",
                'question' => "What does the hissing sound when removing the fuel cap indicate?",
                'options' => [
                    ['text' => 'A) Normal fuel tank operation.', 'isCorrect' => false],
                    ['text' => 'B) Vacuum buildup from blocked tank venting.', 'isCorrect' => true],
                    ['text' => 'C) Overfilled fuel tank.', 'isCorrect' => false],
                    ['text' => 'D) Fuel pump running too fast.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Hissing indicates vacuum buildup because the tank cannot breathe properly due to blocked venting systems.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Vacuum buildup from blocked tank venting.<br>Reason: Vacuum creates the hissing sound when pressure equalizes by removing the cap.'
            ],
            [
                'problem' => "Fuel tank venting problem is confirmed by vacuum buildup.",
                'question' => "Which system should be inspected for blockages?",
                'options' => [
                    ['text' => 'A) EVAP (Evaporative Emission) system and vent lines.', 'isCorrect' => true],
                    ['text' => 'B) Cooling system hoses.', 'isCorrect' => false],
                    ['text' => 'C) Brake fluid lines.', 'isCorrect' => false],
                    ['text' => 'D) Power steering system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The EVAP system manages fuel tank venting. Blocked vent lines or faulty EVAP components cause vacuum buildup.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) EVAP (Evaporative Emission) system and vent lines.<br>Reason: EVAP system specifically controls fuel tank pressure and venting.'
            ],
            [
                'problem' => "EVAP system inspection reveals a blocked vent line.",
                'question' => "What is the proper repair for blocked fuel tank venting?",
                'options' => [
                    ['text' => 'A) Clear the blockage and test system operation.', 'isCorrect' => true],
                    ['text' => 'B) Permanently remove the fuel cap.', 'isCorrect' => false],
                    ['text' => 'C) Drill holes in the fuel tank.', 'isCorrect' => false],
                    ['text' => 'D) Disconnect all vent lines.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Clear the blockage and verify proper venting operation. The system must function as designed for safety and emissions compliance.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Clear the blockage and test system operation.<br>Reason: Proper venting is required for safe fuel system operation and emissions control.'
            ]
        ]
    ]
];
?>
