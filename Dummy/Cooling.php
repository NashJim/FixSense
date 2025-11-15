'overheating_engine' => [
            'title' => 'Engine Overheating',
            'image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Failed cooling fan motor preventing adequate heat dissipation at low speeds and idle conditions.',
            'solution' => 'Replace the faulty cooling fan motor and verify proper electrical connections and relay operation.',
            'learning' => 'Cooling fans are critical for heat removal when natural airflow is insufficient. Regular testing prevents overheating damage.',
            'steps' => [
                [
                    'problem' => "The engine temperature gauge shows overheating during normal driving conditions, especially in traffic or at idle.",
                    'question' => "What should be the first diagnostic step for engine overheating?",
                    'options' => [
                        ['text' => 'A) Replace the thermostat immediately.', 'isCorrect' => false],
                        ['text' => 'B) Check the coolant level and condition.', 'isCorrect' => true],
                        ['text' => 'C) Replace the water pump.', 'isCorrect' => false],
                        ['text' => 'D) Flush the entire cooling system.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Always start with basic checks. Low coolant is the most common cause of overheating. Check both the radiator and overflow tank levels, and inspect coolant condition for contamination.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check the coolant level and condition.<br>Reason: Basic checks first - low or contaminated coolant is the primary cause of overheating before considering component replacement.'
                ],
                [
                    'problem' => "Coolant level is adequate and appears clean, but overheating continues.",
                    'question' => "What is the next logical diagnostic step?",
                    'options' => [
                        ['text' => 'A) Test the cooling fan operation.', 'isCorrect' => true],
                        ['text' => 'B) Replace the radiator cap.', 'isCorrect' => false],
                        ['text' => 'C) Check the air conditioning system.', 'isCorrect' => false],
                        ['text' => 'D) Inspect the exhaust system.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>The cooling fan should activate when the engine reaches operating temperature. A non-functional fan causes overheating especially at idle or low speeds when natural airflow is insufficient.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Test the cooling fan operation.<br>Reason: After confirming adequate coolant, fan operation is critical for heat removal during low-speed driving and idle conditions.'
                ],
                [
                    'problem' => "The cooling fan does not operate even when the engine reaches high temperature.",
                    'question' => "What should be checked to diagnose the fan problem?",
                    'options' => [
                        ['text' => 'A) Replace the fan motor immediately.', 'isCorrect' => false],
                        ['text' => 'B) Check the fan fuse and relay first.', 'isCorrect' => true],
                        ['text' => 'C) Test the temperature sensor only.', 'isCorrect' => false],
                        ['text' => 'D) Check the radiator for blockages.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Always check electrical components (fuse and relay) before replacing expensive parts. A blown fuse or faulty relay are common and inexpensive causes of fan failure.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check the fan fuse and relay first.<br>Reason: Start with simple, inexpensive electrical checks before replacing costly components like the fan motor.'
                ],
                [
                    'problem' => "The fan fuse is blown and replacing it doesn't solve the problem - it blows again immediately.",
                    'question' => "What does this indicate and what should be done?",
                    'options' => [
                        ['text' => 'A) The fan motor has an internal short circuit and needs replacement.', 'isCorrect' => true],
                        ['text' => 'B) Use a higher amperage fuse.', 'isCorrect' => false],
                        ['text' => 'C) Disconnect the fan permanently.', 'isCorrect' => false],
                        ['text' => 'D) Check the coolant temperature sensor.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>A repeatedly blown fuse indicates excessive current draw, typically from a shorted fan motor. Never use a higher amperage fuse as this can cause electrical fires.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) The fan motor has an internal short circuit and needs replacement.<br>Reason: Repeatedly blown fuses indicate motor failure drawing excessive current. Never bypass safety devices with higher amperage fuses.'
                ]
            ]
        ],
        'coolant_leak' => [
            'title' => 'Coolant System Leak',
            'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Deteriorated radiator hose allowing coolant to leak under pressure, causing system pressure loss.',
            'solution' => 'Replace the damaged hose and pressure test the cooling system to verify proper seal.',
            'learning' => 'Regular hose inspection prevents sudden failures. Rubber hoses deteriorate over time and should be replaced preventively.',
            'steps' => [
                [
                    'problem' => "There are visible coolant puddles under the vehicle and the low coolant warning light is illuminated.",
                    'question' => "What is the first step to locate a coolant leak?",
                    'options' => [
                        ['text' => 'A) Add more coolant and continue driving.', 'isCorrect' => false],
                        ['text' => 'B) Perform a visual inspection of the cooling system components.', 'isCorrect' => true],
                        ['text' => 'C) Replace all hoses immediately.', 'isCorrect' => false],
                        ['text' => 'D) Check the oil level.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Visual inspection helps locate the source of the leak. Look for wet spots, stains, or active dripping from hoses, radiator, water pump, and connections.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Perform a visual inspection of the cooling system components.<br>Reason: Locate the leak source before adding coolant or replacing parts. Adding coolant without fixing the leak is temporary and wasteful.'
                ],
                [
                    'problem' => "Visual inspection reveals coolant dripping from the lower radiator hose connection.",
                    'question' => "What should be checked next to confirm the diagnosis?",
                    'options' => [
                        ['text' => 'A) Inspect the hose clamp and hose condition at the connection point.', 'isCorrect' => true],
                        ['text' => 'B) Replace the entire radiator.', 'isCorrect' => false],
                        ['text' => 'C) Check the transmission fluid.', 'isCorrect' => false],
                        ['text' => 'D) Test the air conditioning system.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>A loose clamp or deteriorated hose at the connection is a common leak point. Check if the clamp needs tightening or if the hose end is cracked or swollen.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Inspect the hose clamp and hose condition at the connection point.<br>Reason: Connection points are common leak sources. Check simple fixes like clamp tightening before replacing major components.'
                ],
                [
                    'problem' => "The hose shows signs of deterioration with cracks and swelling near the clamp area.",
                    'question' => "What is the proper repair procedure?",
                    'options' => [
                        ['text' => 'A) Tighten the clamp more to stop the leak.', 'isCorrect' => false],
                        ['text' => 'B) Replace the damaged hose with a new one.', 'isCorrect' => true],
                        ['text' => 'C) Apply sealant to the cracked area.', 'isCorrect' => false],
                        ['text' => 'D) Move the clamp to a different position.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Deteriorated hoses must be replaced. Temporary fixes like over-tightening clamps or using sealants can fail and cause sudden coolant loss while driving.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace the damaged hose with a new one.<br>Reason: Cracked or swollen hoses will continue to deteriorate. Temporary fixes are unreliable and can lead to sudden failure.'
                ]
            ]
        ],
        'thermostat_stuck' => [
            'title' => 'Thermostat Malfunction',
            'image' => 'https://images.unsplash.com/photo-1615906655593-ad0386982a0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Thermostat stuck in closed position preventing coolant circulation to the radiator.',
            'solution' => 'Replace the faulty thermostat and verify proper coolant circulation throughout the system.',
            'learning' => 'The thermostat regulates engine temperature by controlling coolant flow. A stuck thermostat can cause rapid overheating.',
            'steps' => [
                [
                    'problem' => "The engine quickly overheats and the upper radiator hose remains cold while the lower hose gets hot.",
                    'question' => "What does this symptom pattern indicate?",
                    'options' => [
                        ['text' => 'A) The radiator is completely blocked.', 'isCorrect' => false],
                        ['text' => 'B) The thermostat is stuck closed.', 'isCorrect' => true],
                        ['text' => 'C) The water pump has failed.', 'isCorrect' => false],
                        ['text' => 'D) The cooling fan is not working.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>When the thermostat is stuck closed, coolant cannot circulate to the radiator. The upper hose stays cold because no hot coolant reaches it from the engine.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) The thermostat is stuck closed.<br>Reason: Cold upper radiator hose indicates no coolant flow through the radiator, which points to a closed thermostat blocking circulation.'
                ],
                [
                    'problem' => "The thermostat is suspected to be stuck closed based on the hose temperature difference.",
                    'question' => "How can you confirm the thermostat diagnosis?",
                    'options' => [
                        ['text' => 'A) Remove and test the thermostat in hot water.', 'isCorrect' => true],
                        ['text' => 'B) Check the radiator cap pressure.', 'isCorrect' => false],
                        ['text' => 'C) Test the coolant pH level.', 'isCorrect' => false],
                        ['text' => 'D) Check the heater core operation.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Testing the thermostat in hot water (around 180-195°F) will show if it opens properly. A stuck thermostat will remain closed even in hot water.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Remove and test the thermostat in hot water.<br>Reason: Direct testing in hot water confirms if the thermostat opens at the correct temperature or remains stuck closed.'
                ],
                [
                    'problem' => "The thermostat test confirms it remains closed even in boiling water.",
                    'question' => "What is the correct repair procedure?",
                    'options' => [
                        ['text' => 'A) Try to force the thermostat open manually.', 'isCorrect' => false],
                        ['text' => 'B) Replace the thermostat with a new one of the same temperature rating.', 'isCorrect' => true],
                        ['text' => 'C) Remove the thermostat and run without one.', 'isCorrect' => false],
                        ['text' => 'D) Clean the thermostat with solvent.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Replace with the correct temperature rating thermostat. Running without a thermostat prevents proper engine warm-up and can affect fuel economy and emissions.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace the thermostat with a new one of the same temperature rating.<br>Reason: A stuck thermostat cannot be repaired. The engine needs proper temperature regulation for optimal performance and emissions control.'
                ]
            ]
        ]
                        ['text' => 'D) Disconnect the brake lines.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Master cylinder pushrod adjustment affects pedal travel and engagement. Proper adjustment ensures the pedal has correct free play and full hydraulic actuation. Other actions do not influence pedal stiffness after booster repair.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Ensure the master cylinder pushrod is correctly adjusted.<br>Reason: Pads or handbrake do not affect booster-assisted pedal feel; disconnecting lines is unsafe and irrelevant.'
                ],
                [
                    'problem' => "Pushrod adjusted, pedal feels normal during static tests.",
                    'question' => "Next step before finishing the repair?",
                    'options' => [
                        ['text' => 'A) Perform a careful test drive to confirm pedal feel under real braking.', 'isCorrect' => true],
                        ['text' => 'B) Immediately sell the vehicle.', 'isCorrect' => false],
                        ['text' => 'C) Check the windshield wipers.', 'isCorrect' => false],
                        ['text' => 'D) Adjust the steering wheel.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Dynamic testing ensures the braking system works correctly under load and actual driving conditions. Static checks cannot reveal subtle issues such as slight pedal vibration or uneven braking.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Perform a careful test drive to confirm pedal feel under real braking.<br>Reason: Selling, wipers, or steering adjustments do not test braking performance.'
                ],
                [
                    'problem' => "During test drive, minor vibration is noticed during hard braking.",
                    'question' => "Likely cause?",
                    'options' => [
                        ['text' => 'A) Slightly warped brake discs.', 'isCorrect' => true],
                        ['text' => 'B) Air in the tires.', 'isCorrect' => false],
                        ['text' => 'C) Engine misfire.', 'isCorrect' => false],
                        ['text' => 'D) Low washer fluid.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Warped brake discs cause pedal vibration during braking due to uneven contact surfaces. Other causes listed would not produce pedal vibration.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Slightly warped brake discs.<br>Reason: Tires, engine, or washer fluid do not affect brake pedal vibration.'
                ],
                [
                    'problem' => "Brake discs measured and confirm slight warping.",
                    'question' => "Recommended repair?",
                    'options' => [
                        ['text' => 'A) Resurface or replace the warped discs.', 'isCorrect' => true],
                        ['text' => 'B) Ignore the vibration.', 'isCorrect' => false],
                        ['text' => 'C) Replace brake fluid again.', 'isCorrect' => false],
                        ['text' => 'D) Adjust the handbrake.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Resurfacing or replacing the discs restores smooth braking and removes vibration. Ignoring the problem may cause unsafe braking or uneven wear.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Resurface or replace the warped discs.<br>Reason: Other options do not address the mechanical cause of vibration.'
                ]
            ]
        ],
        'water_pump_failure' => [
            'title' => 'Water Pump Failure',
            'image' => 'https://images.unsplash.com/photo-1622787563186-2bb0a02b9d80?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Water pump bearing failure causing coolant circulation loss and potential engine damage.',
            'solution' => 'Replace the water pump, gasket, and inspect timing belt if driven by the pump.',
            'learning' => 'Water pump failure can cause catastrophic engine damage. Early detection through unusual noises and leaks is critical.',
            'steps' => [
                [
                    'problem' => "Engine overheats and there is a grinding or squealing noise from the front of the engine.",
                    'question' => "What component should be suspected based on these symptoms?",
                    'options' => [
                        ['text' => 'A) Alternator bearing failure.', 'isCorrect' => false],
                        ['text' => 'B) Water pump bearing failure.', 'isCorrect' => true],
                        ['text' => 'C) Power steering pump failure.', 'isCorrect' => false],
                        ['text' => 'D) Air conditioning compressor failure.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Grinding noise combined with overheating strongly indicates water pump bearing failure. The pump cannot circulate coolant effectively when bearings are worn.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Water pump bearing failure.<br>Reason: Other components would not directly cause engine overheating combined with front-end grinding noise.'
                ],
                [
                    'problem' => "Visual inspection reveals coolant leaking from the water pump weep hole.",
                    'question' => "What does coolant from the weep hole indicate?",
                    'options' => [
                        ['text' => 'A) Normal operation - weep holes are meant to drain coolant.', 'isCorrect' => false],
                        ['text' => 'B) Internal seal failure requiring pump replacement.', 'isCorrect' => true],
                        ['text' => 'C) Overfilled cooling system.', 'isCorrect' => false],
                        ['text' => 'D) Loose pump mounting bolts.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>The weep hole only leaks when internal seals fail. This is designed to prevent coolant from entering the bearing area, indicating pump replacement is needed.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Internal seal failure requiring pump replacement.<br>Reason: Weep holes should remain dry during normal operation. Coolant indicates internal seal failure.'
                ],
                [
                    'problem' => "Water pump replacement is confirmed necessary.",
                    'question' => "What else should be inspected during water pump replacement?",
                    'options' => [
                        ['text' => 'A) Only the pump and gasket.', 'isCorrect' => false],
                        ['text' => 'B) Timing belt or chain condition if pump is driven by timing system.', 'isCorrect' => true],
                        ['text' => 'C) Engine oil level only.', 'isCorrect' => false],
                        ['text' => 'D) Transmission fluid condition.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Many water pumps are driven by the timing belt. This provides an opportunity to inspect or replace the timing belt while accessing the pump.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Timing belt or chain condition if pump is driven by timing system.<br>Reason: Timing belt replacement is often recommended during water pump service due to shared access and failure risk.'
                ]
            ]
        ],
        'radiator_blockage' => [
            'title' => 'Radiator Internal Blockage',
            'image' => 'https://images.unsplash.com/photo-1580746351062-dac2a5611602?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Internal radiator blockage from corrosion and sediment preventing proper heat transfer.',
            'solution' => 'Flush cooling system thoroughly or replace radiator if blockage cannot be cleared.',
            'learning' => 'Regular cooling system maintenance prevents internal corrosion that leads to blockages and overheating.',
            'steps' => [
                [
                    'problem' => "Engine overheats despite adequate coolant level and functioning cooling fan.",
                    'question' => "What additional diagnostic test should be performed?",
                    'options' => [
                        ['text' => 'A) Check radiator temperature difference between inlet and outlet.', 'isCorrect' => true],
                        ['text' => 'B) Replace the thermostat immediately.', 'isCorrect' => false],
                        ['text' => 'C) Check tire pressure.', 'isCorrect' => false],
                        ['text' => 'D) Test the heater operation.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Temperature difference between radiator inlet and outlet indicates heat transfer efficiency. Little difference suggests poor flow or blockage.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check radiator temperature difference between inlet and outlet.<br>Reason: Temperature testing reveals heat transfer problems that other checks would miss.'
                ],
                [
                    'problem' => "Radiator inlet is hot but outlet remains relatively cool, indicating poor internal flow.",
                    'question' => "What is the most likely cause of this condition?",
                    'options' => [
                        ['text' => 'A) External radiator blockage from debris.', 'isCorrect' => false],
                        ['text' => 'B) Internal radiator blockage from corrosion or sediment.', 'isCorrect' => true],
                        ['text' => 'C) Cooling fan running too slowly.', 'isCorrect' => false],
                        ['text' => 'D) Low coolant concentration.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Hot inlet with cool outlet indicates coolant is not flowing through the radiator core effectively due to internal blockage.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Internal radiator blockage from corrosion or sediment.<br>Reason: External blockage would affect both inlet and outlet temperatures similarly.'
                ],
                [
                    'problem' => "Internal radiator blockage is confirmed.",
                    'question' => "What is the first repair attempt that should be tried?",
                    'options' => [
                        ['text' => 'A) Replace the radiator immediately.', 'isCorrect' => false],
                        ['text' => 'B) Perform a professional cooling system flush.', 'isCorrect' => true],
                        ['text' => 'C) Add radiator stop-leak product.', 'isCorrect' => false],
                        ['text' => 'D) Increase cooling fan speed.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Professional flushing with proper chemicals can often clear internal blockages. This is less expensive than radiator replacement and should be attempted first.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Perform a professional cooling system flush.<br>Reason: Flushing is the appropriate first step before considering expensive radiator replacement.'
                ]
            ]
        ],
        'heater_core_problem' => [
            'title' => 'Heater Core Issues',
            'image' => 'https://images.unsplash.com/photo-1594736797933-d0401ba2fe65?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Heater core blockage or leak affecting cabin heating and potentially causing overheating.',
            'solution' => 'Flush heater core or replace if severely damaged, and repair any coolant leaks.',
            'learning' => 'The heater core is part of the cooling system and problems can affect both heating and engine temperature.',
            'steps' => [
                [
                    'problem' => "No heat from cabin heater despite engine reaching normal operating temperature.",
                    'question' => "What should be checked first for heater problems?",
                    'options' => [
                        ['text' => 'A) Heater core coolant flow by checking hose temperatures.', 'isCorrect' => true],
                        ['text' => 'B) Air conditioning refrigerant level.', 'isCorrect' => false],
                        ['text' => 'C) Engine oil temperature.', 'isCorrect' => false],
                        ['text' => 'D) Transmission fluid level.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Both heater hoses should be hot when the engine is warm. Cool hoses indicate poor coolant flow through the heater core.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Heater core coolant flow by checking hose temperatures.<br>Reason: The heater relies on hot coolant circulation, not refrigerant, oil, or transmission fluid.'
                ],
                [
                    'problem' => "One heater hose is hot while the other remains cool.",
                    'question' => "What does this temperature difference indicate?",
                    'options' => [
                        ['text' => 'A) Normal heater operation.', 'isCorrect' => false],
                        ['text' => 'B) Heater core blockage preventing coolant circulation.', 'isCorrect' => true],
                        ['text' => 'C) Thermostat failure.', 'isCorrect' => false],
                        ['text' => 'D) Low engine oil level.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Hot coolant should enter and exit the heater core. When only one hose is hot, coolant is not circulating through the core properly.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Heater core blockage preventing coolant circulation.<br>Reason: Both hoses should be hot during normal operation. Temperature difference indicates flow restriction.'
                ],
                [
                    'problem' => "Sweet coolant odor is noticed inside the vehicle cabin.",
                    'question' => "What does this symptom suggest?",
                    'options' => [
                        ['text' => 'A) External coolant leak under the vehicle.', 'isCorrect' => false],
                        ['text' => 'B) Heater core internal leak allowing coolant into cabin air.', 'isCorrect' => true],
                        ['text' => 'C) Fuel system problem.', 'isCorrect' => false],
                        ['text' => 'D) Engine oil leak.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Sweet coolant odor in the cabin indicates the heater core is leaking coolant into the ventilation system. This requires immediate attention.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Heater core internal leak allowing coolant into cabin air.<br>Reason: External leaks or other fluids would not cause sweet odor specifically inside the cabin.'
                ]
            ]
        ],
        'coolant_contamination' => [
            'title' => 'Coolant Contamination',
            'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Oil contamination in cooling system due to head gasket failure or cracked engine block.',
            'solution' => 'Diagnose and repair head gasket or block crack, then completely flush contaminated coolant.',
            'learning' => 'Coolant contamination indicates serious engine problems that require immediate attention to prevent catastrophic damage.',
            'steps' => [
                [
                    'problem' => "Coolant appears milky or has oil floating on the surface when checking the radiator.",
                    'question' => "What does milky coolant typically indicate?",
                    'options' => [
                        ['text' => 'A) Normal coolant aging that needs replacement.', 'isCorrect' => false],
                        ['text' => 'B) Oil contamination from head gasket or internal engine leak.', 'isCorrect' => true],
                        ['text' => 'C) Dirty radiator that needs cleaning.', 'isCorrect' => false],
                        ['text' => 'D) Wrong type of coolant was added.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Milky coolant indicates oil and coolant are mixing, typically from head gasket failure or cracked cylinder head allowing oil into the cooling system.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Oil contamination from head gasket or internal engine leak.<br>Reason: Milky appearance specifically indicates oil mixing with coolant, not normal aging or wrong coolant type.'
                ],
                [
                    'problem' => "Engine oil dipstick shows foam or milky appearance in the oil.",
                    'question' => "What does contaminated engine oil confirm about the cooling system problem?",
                    'options' => [
                        ['text' => 'A) The problem is only in the cooling system.', 'isCorrect' => false],
                        ['text' => 'B) Coolant is leaking into the engine oil system (internal leak).', 'isCorrect' => true],
                        ['text' => 'C) External coolant leak onto hot engine.', 'isCorrect' => false],
                        ['text' => 'D) Normal oil condition requiring only oil change.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Foamy or milky oil confirms coolant is entering the oil system, indicating internal engine failure like head gasket or cracked block.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Coolant is leaking into the engine oil system (internal leak).<br>Reason: Contaminated oil proves internal mixing between cooling and lubrication systems.'
                ],
                [
                    'problem' => "Both coolant and oil contamination are confirmed.",
                    'question' => "What is the most critical immediate action?",
                    'options' => [
                        ['text' => 'A) Continue driving carefully to the repair shop.', 'isCorrect' => false],
                        ['text' => 'B) Stop driving immediately to prevent catastrophic engine damage.', 'isCorrect' => true],
                        ['text' => 'C) Change the oil and add more coolant.', 'isCorrect' => false],
                        ['text' => 'D) Check other fluid levels.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Internal coolant/oil mixing indicates serious engine damage. Continued operation will cause catastrophic failure requiring complete engine replacement.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Stop driving immediately to prevent catastrophic engine damage.<br>Reason: Driving with mixed fluids will destroy engine bearings and require complete engine replacement.'
                ]
            ]
        ],
        'cooling_fan_relay' => [
            'title' => 'Cooling Fan Relay Failure',
            'image' => 'https://images.unsplash.com/photo-1621199001528-970a2ce91d48?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Faulty cooling fan relay preventing fan operation during high temperature conditions.',
            'solution' => 'Replace the faulty relay and test fan operation under various temperature conditions.',
            'learning' => 'Relays are inexpensive but critical components. Always test electrical components before replacing expensive motors.',
            'steps' => [
                [
                    'problem' => "Engine overheats in traffic but runs normal on highway. Cooling fan never operates.",
                    'question' => "What electrical component should be tested first?",
                    'options' => [
                        ['text' => 'A) Cooling fan motor.', 'isCorrect' => false],
                        ['text' => 'B) Cooling fan relay.', 'isCorrect' => true],
                        ['text' => 'C) Temperature sensor.', 'isCorrect' => false],
                        ['text' => 'D) Alternator output.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>The relay controls power to the fan motor. A faulty relay is more common than motor failure and much less expensive to replace.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Cooling fan relay.<br>Reason: Test the least expensive electrical components first before assuming motor failure.'
                ],
                [
                    'problem' => "Cooling fan relay is removed for testing.",
                    'question' => "How can you quickly test if the relay is the problem?",
                    'options' => [
                        ['text' => 'A) Swap with another identical relay in the fuse box.', 'isCorrect' => true],
                        ['text' => 'B) Clean the relay contacts with sandpaper.', 'isCorrect' => false],
                        ['text' => 'C) Tap the relay with a hammer.', 'isCorrect' => false],
                        ['text' => 'D) Check relay with an ohmmeter only.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Swapping with an identical relay (like horn or A/C clutch relay) quickly determines if the relay is faulty without special equipment.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Swap with another identical relay in the fuse box.<br>Reason: Relay swapping is the fastest field test. Cleaning or tapping may provide temporary fixes but not reliable testing.'
                ],
                [
                    'problem' => "Fan operates normally with the swapped relay.",
                    'question' => "What does this confirm about the diagnosis?",
                    'options' => [
                        ['text' => 'A) The fan motor was the problem.', 'isCorrect' => false],
                        ['text' => 'B) The original relay was faulty and needs replacement.', 'isCorrect' => true],
                        ['text' => 'C) The temperature sensor needs adjustment.', 'isCorrect' => false],
                        ['text' => 'D) The wiring harness is damaged.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>When the fan works with a different relay, it proves the original relay was faulty. The motor, wiring, and sensor are functioning properly.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) The original relay was faulty and needs replacement.<br>Reason: Successful operation with different relay isolates the fault to the original relay.'
                ]
            ]
        ],
        'radiator_cap_failure' => [
            'title' => 'Faulty Radiator Cap',
            'image' => 'https://images.unsplash.com/photo-1632507003542-0c22ae7ce637?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Radiator cap not maintaining proper system pressure leading to lowered coolant boiling point.',
            'solution' => 'Replace radiator cap and pressure test the cooling system for proper operation.',
            'learning' => 'The radiator cap is critical for maintaining cooling system pressure. Low pressure allows coolant to boil at lower temperatures.',
            'steps' => [
                [
                    'problem' => "Engine overheats but coolant level is adequate and all components appear functional.",
                    'question' => "What often-overlooked component should be tested?",
                    'options' => [
                        ['text' => 'A) Radiator cap pressure rating.', 'isCorrect' => true],
                        ['text' => 'B) Engine oil viscosity.', 'isCorrect' => false],
                        ['text' => 'C) Fuel pump pressure.', 'isCorrect' => false],
                        ['text' => 'D) Tire pressure.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>The radiator cap maintains system pressure which raises coolant boiling point. A faulty cap allows coolant to boil at lower temperatures causing overheating.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Radiator cap pressure rating.<br>Reason: System pressure directly affects coolant boiling point. Other options do not relate to overheating problems.'
                ],
                [
                    'problem' => "Radiator cap shows signs of corrosion and the rubber seal appears hardened.",
                    'question' => "How should the radiator cap be properly tested?",
                    'options' => [
                        ['text' => 'A) Visual inspection only.', 'isCorrect' => false],
                        ['text' => 'B) Pressure test the cap using a cooling system pressure tester.', 'isCorrect' => true],
                        ['text' => 'C) Soak in water to clean.', 'isCorrect' => false],
                        ['text' => 'D) Test with compressed air.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>A pressure tester determines if the cap maintains proper pressure and releases at the correct point. Visual inspection cannot verify pressure holding ability.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Pressure test the cap using a cooling system pressure tester.<br>Reason: Only pressure testing can verify the cap maintains proper system pressure specifications.'
                ],
                [
                    'problem' => "Pressure testing shows the cap releases pressure at 8 PSI instead of the specified 16 PSI.",
                    'question' => "What effect does low pressure release have on cooling system operation?",
                    'options' => [
                        ['text' => 'A) No effect on cooling performance.', 'isCorrect' => false],
                        ['text' => 'B) Coolant boils at lower temperature causing overheating.', 'isCorrect' => true],
                        ['text' => 'C) Improved cooling system efficiency.', 'isCorrect' => false],
                        ['text' => 'D) Reduced coolant circulation speed.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Lower system pressure reduces coolant boiling point. At 8 PSI instead of 16 PSI, coolant may boil before reaching optimal engine operating temperature.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Coolant boils at lower temperature causing overheating.<br>Reason: Pressure and boiling point are directly related. Lower pressure = lower boiling point = overheating.'
                ]
            ]
        ],
        'air_pocket_cooling' => [
            'title' => 'Air Pockets in Cooling System',
            'image' => 'https://images.unsplash.com/photo-1558470598-a5dda9640ff8?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
            'root_cause' => 'Trapped air preventing proper coolant circulation and causing localized overheating.',
            'solution' => 'Properly bleed air from cooling system using correct procedures and check for leak sources.',
            'learning' => 'Air pockets can cause overheating even with adequate coolant. Proper bleeding procedure is essential after any cooling system work.',
            'steps' => [
                [
                    'problem' => "Engine overheats intermittently and heater blows cold air occasionally despite adequate coolant level.",
                    'question' => "What condition could cause these intermittent symptoms?",
                    'options' => [
                        ['text' => 'A) Permanent cooling system damage.', 'isCorrect' => false],
                        ['text' => 'B) Air pockets in the cooling system.', 'isCorrect' => true],
                        ['text' => 'C) Wrong type of coolant.', 'isCorrect' => false],
                        ['text' => 'D) Excessive coolant level.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Air pockets can move around the system causing intermittent blockages that prevent proper coolant circulation to different areas.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Air pockets in the cooling system.<br>Reason: Air pockets cause intermittent symptoms as they move and block circulation temporarily.'
                ],
                [
                    'problem' => "Air pockets are suspected in the cooling system.",
                    'question' => "What is the proper procedure to remove air from the system?",
                    'options' => [
                        ['text' => 'A) Add more coolant and drive the vehicle.', 'isCorrect' => false],
                        ['text' => 'B) Follow proper bleeding procedure with engine running and heater on.', 'isCorrect' => true],
                        ['text' => 'C) Shake the vehicle to move air bubbles.', 'isCorrect' => false],
                        ['text' => 'D) Remove radiator cap while engine is hot.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Proper bleeding involves running the engine with heater on maximum while slowly adding coolant and working air out through the radiator cap or bleeder valves.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Follow proper bleeding procedure with engine running and heater on.<br>Reason: Systematic bleeding ensures all air is removed. Other methods are ineffective or dangerous.'
                ],
                [
                    'problem' => "After bleeding procedure, how can you verify all air has been removed?",
                    'question' => "What indicates successful air removal from the cooling system?",
                    'options' => [
                        ['text' => 'A) Coolant level remains stable and heater produces consistent hot air.', 'isCorrect' => true],
                        ['text' => 'B) Engine makes less noise.', 'isCorrect' => false],
                        ['text' => 'C) Fuel economy improves immediately.', 'isCorrect' => false],
                        ['text' => 'D) Engine starts faster.', 'isCorrect' => false]
                    ],
                    'feedbackCorrect' => '✅ Correct!<br>Stable coolant level and consistent heater operation indicate proper circulation without air pockets blocking flow to various system components.',
                    'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Coolant level remains stable and heater produces consistent hot air.<br>Reason: These symptoms directly indicate proper coolant circulation without air interference.'
                ]
            ]
        ]