<?php
$scenarios = [
    'transmission_slipping' => [
        'title' => 'Transmission Slipping',
        'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Low transmission fluid and worn clutch packs causing insufficient hydraulic pressure under load.',
        'solution' => 'Replace transmission fluid and filter, test line pressure, and rebuild transmission if pressure remains low.',
        'learning' => 'Regular transmission fluid maintenance prevents most slipping problems. Early detection saves expensive repairs.',
        'steps' => [
            [
                'problem' => "Vehicle loses power during acceleration, engine RPM increases but vehicle speed doesn't increase proportionally.",
                'question' => "What should be the first diagnostic step for transmission slipping?",
                'options' => [
                    ['text' => 'A) Rebuild the transmission immediately.', 'isCorrect' => false],
                    ['text' => 'B) Check transmission fluid level and condition.', 'isCorrect' => true],
                    ['text' => 'C) Replace the torque converter.', 'isCorrect' => false],
                    ['text' => 'D) Adjust the throttle cable.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Low or contaminated transmission fluid is the most common cause of slipping. Always check fluid first as it\'s the easiest and least expensive diagnostic step.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Check transmission fluid level and condition.<br>Reason: Start with basic fluid checks before considering expensive repairs.'
            ],
            [
                'problem' => "Transmission fluid level is low and the fluid appears dark brown with a burnt smell.",
                'question' => "What does burnt-smelling dark fluid indicate?",
                'options' => [
                    ['text' => 'A) Normal fluid aging that needs replacement.', 'isCorrect' => false],
                    ['text' => 'B) Overheating and internal transmission damage.', 'isCorrect' => true],
                    ['text' => 'C) Recently serviced transmission.', 'isCorrect' => false],
                    ['text' => 'D) Contamination from engine oil.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Dark, burnt-smelling fluid indicates overheating and internal component wear. This requires immediate attention and likely major repair.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Overheating and internal transmission damage.<br>Reason: Burnt smell specifically indicates overheating damage, not normal wear.'
            ],
            [
                'problem' => "After fluid replacement, slipping has improved but still occurs under heavy acceleration.",
                'question' => "What should be tested next to diagnose remaining slipping?",
                'options' => [
                    ['text' => 'A) Transmission line pressure with a gauge.', 'isCorrect' => true],
                    ['text' => 'B) Engine compression only.', 'isCorrect' => false],
                    ['text' => 'C) Radiator cap pressure.', 'isCorrect' => false],
                    ['text' => 'D) Fuel system pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Line pressure testing determines if the hydraulic system generates sufficient pressure to hold clutch packs engaged under load.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Transmission line pressure with a gauge.<br>Reason: Pressure testing identifies hydraulic system problems causing intermittent slipping.'
            ]
        ]
    ],
    'delayed_engagement' => [
        'title' => 'Delayed Gear Engagement',
        'image' => 'https://images.unsplash.com/photo-1615906655593-ad0386982a0f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn seals and internal leakage causing slow pressure buildup when engaging gears.',
        'solution' => 'Rebuild transmission focusing on seal replacement and pressure circuit restoration.',
        'learning' => 'Delayed engagement often indicates internal wear that worsens over time. Early repair prevents complete failure.',
        'steps' => [
            [
                'problem' => "Transmission takes 3-5 seconds to engage when shifting from Park to Drive or Reverse.",
                'question' => "What internal condition typically causes delayed engagement?",
                'options' => [
                    ['text' => 'A) External fluid leaks only.', 'isCorrect' => false],
                    ['text' => 'B) Internal seal wear allowing pressure loss.', 'isCorrect' => true],
                    ['text' => 'C) Overfilled transmission fluid.', 'isCorrect' => false],
                    ['text' => 'D) Cold weather operation.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Worn internal seals allow hydraulic pressure to leak internally, requiring more time to build sufficient pressure for gear engagement.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Internal seal wear allowing pressure loss.<br>Reason: Delayed engagement specifically indicates slow pressure buildup from internal leakage.'
            ],
            [
                'problem' => "Delayed engagement occurs in both forward and reverse gears.",
                'question' => "What does engagement delay in all gears indicate?",
                'options' => [
                    ['text' => 'A) Problem affects main hydraulic circuits.', 'isCorrect' => true],
                    ['text' => 'B) Only forward clutches are worn.', 'isCorrect' => false],
                    ['text' => 'C) Only reverse band is damaged.', 'isCorrect' => false],
                    ['text' => 'D) Torque converter failure only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Delay in all gears indicates problems with main pressure circuits that supply all gear ranges, not individual gear-specific components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Problem affects main hydraulic circuits.<br>Reason: Universal delay points to main system problems, not specific gear components.'
            ],
            [
                'problem' => "Main hydraulic system problems are confirmed.",
                'question' => "What repair approach is typically required for widespread internal wear?",
                'options' => [
                    ['text' => 'A) Add transmission stop-leak product.', 'isCorrect' => false],
                    ['text' => 'B) Complete transmission rebuild or replacement.', 'isCorrect' => true],
                    ['text' => 'C) External adjustment only.', 'isCorrect' => false],
                    ['text' => 'D) Change fluid type only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Widespread internal seal wear requires complete disassembly and rebuild to replace all worn seals and damaged components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Complete transmission rebuild or replacement.<br>Reason: Internal seal wear cannot be repaired with external treatments or adjustments.'
            ]
        ]
    ],
    'rough_shifting' => [
        'title' => 'Rough or Hard Shifting',
        'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Faulty valve body or electronic control problems causing abrupt pressure changes during shifts.',
        'solution' => 'Rebuild or replace valve body and update transmission control software if applicable.',
        'learning' => 'Modern transmissions rely on precise pressure control. Valve body problems affect shift quality significantly.',
        'steps' => [
            [
                'problem' => "Transmission shifts harshly between gears, causing jerking motion and uncomfortable operation.",
                'question' => "What component controls smooth pressure transitions during shifting?",
                'options' => [
                    ['text' => 'A) Transmission cooler.', 'isCorrect' => false],
                    ['text' => 'B) Valve body and pressure control solenoids.', 'isCorrect' => true],
                    ['text' => 'C) Transmission mount.', 'isCorrect' => false],
                    ['text' => 'D) Exhaust system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The valve body contains pressure control valves and solenoids that regulate smooth pressure transitions during gear changes.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Valve body and pressure control solenoids.<br>Reason: Valve body specifically controls hydraulic pressure timing and intensity during shifts.'
            ],
            [
                'problem' => "Valve body problems are suspected for harsh shifting.",
                'question' => "How can valve body function be diagnosed?",
                'options' => [
                    ['text' => 'A) Computer scan for transmission fault codes.', 'isCorrect' => true],
                    ['text' => 'B) Visual inspection of exterior only.', 'isCorrect' => false],
                    ['text' => 'C) Check engine oil pressure.', 'isCorrect' => false],
                    ['text' => 'D) Test radiator cap pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Modern transmissions store fault codes for solenoid and valve body problems. Scanning provides specific diagnostic information.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Computer scan for transmission fault codes.<br>Reason: Electronic controls monitor valve body operation and store diagnostic codes.'
            ],
            [
                'problem' => "Diagnostic codes indicate multiple pressure control solenoid faults.",
                'question' => "What repair is typically required for multiple solenoid faults?",
                'options' => [
                    ['text' => 'A) Valve body rebuild or replacement.', 'isCorrect' => true],
                    ['text' => 'B) Add more transmission fluid.', 'isCorrect' => false],
                    ['text' => 'C) Adjust external linkage only.', 'isCorrect' => false],
                    ['text' => 'D) Replace transmission cooler.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Multiple solenoid faults indicate valve body problems requiring rebuild or replacement to restore proper pressure control.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Valve body rebuild or replacement.<br>Reason: Multiple solenoid problems require valve body service, not external adjustments.'
            ]
        ]
    ],
    'transmission_fluid_leak' => [
        'title' => 'Transmission Fluid Leak',
        'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn seals and gaskets allowing transmission fluid to leak externally.',
        'solution' => 'Replace leaking seals and gaskets, then refill with proper transmission fluid.',
        'learning' => 'External leaks are often easier and less expensive to repair than internal transmission problems.',
        'steps' => [
            [
                'problem' => "Red fluid puddles are found under the vehicle and low transmission fluid warning appears.",
                'question' => "How can you confirm the red fluid is transmission fluid?",
                'options' => [
                    ['text' => 'A) Check transmission fluid level and color.', 'isCorrect' => true],
                    ['text' => 'B) Assume it\'s engine oil.', 'isCorrect' => false],
                    ['text' => 'C) Test brake fluid level.', 'isCorrect' => false],
                    ['text' => 'D) Check windshield washer fluid.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Transmission fluid is typically red in color and has a distinct smell. Checking fluid level confirms the source of the leak.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Check transmission fluid level and color.<br>Reason: Red color is characteristic of transmission fluid, and level check confirms the leak source.'
            ],
            [
                'problem' => "Transmission fluid leak is confirmed.",
                'question' => "Where should you look to locate the source of external transmission leaks?",
                'options' => [
                    ['text' => 'A) Pan gasket, cooler lines, and seal areas.', 'isCorrect' => true],
                    ['text' => 'B) Engine oil pan only.', 'isCorrect' => false],
                    ['text' => 'C) Fuel tank area.', 'isCorrect' => false],
                    ['text' => 'D) Exhaust system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Common external leak points include the pan gasket, cooler lines, output shaft seals, and input shaft seals.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Pan gasket, cooler lines, and seal areas.<br>Reason: These are the most common external leak points in transmission systems.'
            ],
            [
                'problem' => "Pan gasket is identified as the leak source.",
                'question' => "What is the proper procedure for pan gasket replacement?",
                'options' => [
                    ['text' => 'A) Replace gasket, clean surfaces, and refill with proper fluid.', 'isCorrect' => true],
                    ['text' => 'B) Add sealant over the old gasket.', 'isCorrect' => false],
                    ['text' => 'C) Tighten pan bolts without replacing gasket.', 'isCorrect' => false],
                    ['text' => 'D) Ignore small leaks.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Proper gasket replacement requires clean surfaces, new gasket, proper torque, and refilling with correct fluid type.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace gasket, clean surfaces, and refill with proper fluid.<br>Reason: Proper gasket installation is the only reliable repair for pan leaks.'
            ]
        ]
    ],
    'torque_converter_problems' => [
        'title' => 'Torque Converter Issues',
        'image' => 'https://images.unsplash.com/photo-1580813904443-5e525be5c11c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Torque converter lockup clutch failure causing shuddering and poor fuel economy.',
        'solution' => 'Replace or rebuild torque converter and verify proper lockup operation.',
        'learning' => 'Torque converter problems often feel like engine issues but occur only when transmission is engaged.',
        'steps' => [
            [
                'problem' => "Vehicle shudders at highway speeds, especially during light acceleration around 45-55 mph.",
                'question' => "What transmission component typically causes shuddering at highway speeds?",
                'options' => [
                    ['text' => 'A) Transmission fluid pump.', 'isCorrect' => false],
                    ['text' => 'B) Torque converter lockup clutch.', 'isCorrect' => true],
                    ['text' => 'C) Park/Neutral safety switch.', 'isCorrect' => false],
                    ['text' => 'D) Transmission cooler.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Torque converter lockup clutch engages at highway speeds to improve fuel economy. When worn, it causes characteristic shuddering.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Torque converter lockup clutch.<br>Reason: Lockup clutch specifically operates at highway speeds and causes shuddering when failing.'
            ],
            [
                'problem' => "Torque converter lockup problems are suspected.",
                'question' => "How can you test torque converter lockup operation?",
                'options' => [
                    ['text' => 'A) Monitor engine RPM during steady highway driving.', 'isCorrect' => true],
                    ['text' => 'B) Check transmission fluid color only.', 'isCorrect' => false],
                    ['text' => 'C) Test brake pedal feel.', 'isCorrect' => false],
                    ['text' => 'D) Check tire pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>When lockup engages properly, engine RPM should drop slightly. No RPM drop indicates lockup failure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Monitor engine RPM during steady highway driving.<br>Reason: RPM monitoring directly shows lockup clutch engagement or failure.'
            ],
            [
                'problem' => "RPM monitoring shows no lockup engagement at highway speeds.",
                'question' => "What repair is required for failed torque converter lockup?",
                'options' => [
                    ['text' => 'A) Torque converter replacement or rebuild.', 'isCorrect' => true],
                    ['text' => 'B) Add transmission stop-leak product.', 'isCorrect' => false],
                    ['text' => 'C) Adjust external linkage.', 'isCorrect' => false],
                    ['text' => 'D) Change transmission fluid only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Failed lockup clutch is internal to the torque converter and requires converter replacement or rebuild.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Torque converter replacement or rebuild.<br>Reason: Internal lockup clutch failure cannot be repaired externally.'
            ]
        ]
    ],
    'transmission_overheating' => [
        'title' => 'Transmission Overheating',
        'image' => 'https://images.unsplash.com/photo-1566140804584-36b831df7c04?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Blocked transmission cooler or insufficient cooling capacity causing fluid overheating.',
        'solution' => 'Clean or replace transmission cooler and verify proper cooling system operation.',
        'learning' => 'Transmission overheating causes rapid fluid breakdown and internal damage. Cooling system maintenance is critical.',
        'steps' => [
            [
                'problem' => "Transmission fluid appears very dark and smells burnt. Vehicle experiences harsh shifting after extended driving.",
                'question' => "What condition causes rapid transmission fluid deterioration?",
                'options' => [
                    ['text' => 'A) Cold weather operation.', 'isCorrect' => false],
                    ['text' => 'B) Transmission overheating.', 'isCorrect' => true],
                    ['text' => 'C) Low fuel pressure.', 'isCorrect' => false],
                    ['text' => 'D) High tire pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Overheating breaks down transmission fluid rapidly, causing dark color, burnt smell, and poor shift quality.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Transmission overheating.<br>Reason: Heat specifically causes fluid breakdown and burnt smell.'
            ],
            [
                'problem' => "Transmission overheating is suspected.",
                'question' => "What should be checked to diagnose cooling system problems?",
                'options' => [
                    ['text' => 'A) Transmission cooler condition and airflow.', 'isCorrect' => true],
                    ['text' => 'B) Engine oil temperature only.', 'isCorrect' => false],
                    ['text' => 'C) Fuel system pressure.', 'isCorrect' => false],
                    ['text' => 'D) Battery voltage.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Blocked transmission cooler or poor airflow prevents heat dissipation, causing overheating.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Transmission cooler condition and airflow.<br>Reason: Cooling system problems directly cause transmission overheating.'
            ],
            [
                'problem' => "Transmission cooler is found to be severely blocked with debris.",
                'question' => "What repair is required for blocked transmission cooling?",
                'options' => [
                    ['text' => 'A) Clean or replace cooler and flush cooling lines.', 'isCorrect' => true],
                    ['text' => 'B) Add more transmission fluid only.', 'isCorrect' => false],
                    ['text' => 'C) Install a manual transmission.', 'isCorrect' => false],
                    ['text' => 'D) Remove the cooler completely.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Blocked cooler must be cleaned or replaced to restore heat dissipation. Flushing removes debris from cooling lines.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Clean or replace cooler and flush cooling lines.<br>Reason: Cooling capacity must be restored to prevent continued overheating.'
            ]
        ]
    ],
    'shift_solenoid_failure' => [
        'title' => 'Shift Solenoid Problems',
        'image' => 'https://images.unsplash.com/photo-1614729939124-032bb9ac2b45?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Electronic shift solenoid failure preventing proper gear engagement and shift timing.',
        'solution' => 'Replace faulty shift solenoids and update transmission control software if required.',
        'learning' => 'Modern transmissions use electronic solenoids for precise shift control. Electrical problems affect shift quality.',
        'steps' => [
            [
                'problem' => "Transmission stays in one gear and will not shift up or down. Check engine light is illuminated.",
                'question' => "What should be the first diagnostic step for electronic shift problems?",
                'options' => [
                    ['text' => 'A) Replace all solenoids immediately.', 'isCorrect' => false],
                    ['text' => 'B) Scan for diagnostic trouble codes.', 'isCorrect' => true],
                    ['text' => 'C) Drain and refill transmission fluid.', 'isCorrect' => false],
                    ['text' => 'D) Check tire pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Electronic transmission problems trigger diagnostic codes that identify specific solenoid or circuit faults.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Scan for diagnostic trouble codes.<br>Reason: Electronic systems provide specific diagnostic information through trouble codes.'
            ],
            [
                'problem' => "Diagnostic scan reveals codes for shift solenoid A and B electrical faults.",
                'question' => "What should be tested before replacing solenoids?",
                'options' => [
                    ['text' => 'A) Solenoid electrical connections and wiring.', 'isCorrect' => true],
                    ['text' => 'B) Engine compression.', 'isCorrect' => false],
                    ['text' => 'C) Fuel system pressure.', 'isCorrect' => false],
                    ['text' => 'D) Cooling system pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Electrical faults may be caused by poor connections or damaged wiring rather than failed solenoids.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Solenoid electrical connections and wiring.<br>Reason: Check electrical circuits before replacing expensive solenoids.'
            ],
            [
                'problem' => "Electrical testing confirms solenoid internal failure.",
                'question' => "What is the proper repair for failed shift solenoids?",
                'options' => [
                    ['text' => 'A) Replace faulty solenoids and clear codes.', 'isCorrect' => true],
                    ['text' => 'B) Disconnect solenoids permanently.', 'isCorrect' => false],
                    ['text' => 'C) Add electrical system cleaner.', 'isCorrect' => false],
                    ['text' => 'D) Bypass solenoid operation.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Failed solenoids must be replaced to restore proper electronic shift control. Clear codes after repair.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace faulty solenoids and clear codes.<br>Reason: Electronic transmission requires proper solenoid operation for correct shifting.'
            ]
        ]
    ],
    'transmission_mount_failure' => [
        'title' => 'Transmission Mount Problems',
        'image' => 'https://images.unsplash.com/photo-1584464491033-06628f3a6b7b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn or broken transmission mount allowing excessive transmission movement and vibration.',
        'solution' => 'Replace worn transmission mount and inspect related mounts for damage.',
        'learning' => 'Transmission mounts control vibration and prevent damage to connected components. Failed mounts affect drivability.',
        'steps' => [
            [
                'problem' => "Excessive vibration is felt during acceleration and gear changes. Clunking sounds occur when shifting.",
                'question' => "What component helps control transmission movement and vibration?",
                'options' => [
                    ['text' => 'A) Transmission fluid pump.', 'isCorrect' => false],
                    ['text' => 'B) Transmission mount.', 'isCorrect' => true],
                    ['text' => 'C) Torque converter.', 'isCorrect' => false],
                    ['text' => 'D) Valve body.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Transmission mounts secure the transmission to the vehicle frame and control movement and vibration during operation.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Transmission mount.<br>Reason: Mounts specifically control transmission movement and reduce vibration transfer.'
            ],
            [
                'problem' => "Transmission mount problems are suspected.",
                'question' => "How can you inspect transmission mount condition?",
                'options' => [
                    ['text' => 'A) Visual inspection for cracks, separation, or excessive movement.', 'isCorrect' => true],
                    ['text' => 'B) Check transmission fluid level only.', 'isCorrect' => false],
                    ['text' => 'C) Test electrical connections.', 'isCorrect' => false],
                    ['text' => 'D) Monitor fuel pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Visual inspection can reveal cracked rubber, separated components, or excessive movement indicating mount failure.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Visual inspection for cracks, separation, or excessive movement.<br>Reason: Mount condition is best assessed through visual inspection of physical components.'
            ],
            [
                'problem' => "Transmission mount shows severe cracking and separation.",
                'question' => "What repair is required for a failed transmission mount?",
                'options' => [
                    ['text' => 'A) Replace the damaged mount with a new one.', 'isCorrect' => true],
                    ['text' => 'B) Add rubber cement to cracks.', 'isCorrect' => false],
                    ['text' => 'C) Tighten mounting bolts only.', 'isCorrect' => false],
                    ['text' => 'D) Continue driving with damaged mount.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Failed mounts must be replaced to restore proper support and prevent damage to transmission and connected components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace the damaged mount with a new one.<br>Reason: Structural failure of mounts cannot be repaired, only replaced.'
            ]
        ]
    ]
];
?>
