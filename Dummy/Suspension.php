<?php
$scenarios = [
    'worn_shock_absorbers' => [
        'title' => 'Worn Shock Absorbers',
        'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Internal seal failure in shock absorbers causing loss of hydraulic damping fluid and poor ride control.',
        'solution' => 'Replace worn shock absorbers in pairs (front or rear) to maintain balanced suspension performance.',
        'learning' => 'Shock absorbers control suspension movement and tire contact. Worn shocks affect handling, braking, and tire wear.',
        'steps' => [
            [
                'problem' => "Vehicle bounces excessively after hitting bumps and takes multiple oscillations to settle.",
                'question' => "What component controls suspension oscillation and dampening?",
                'options' => [
                    ['text' => 'A) Springs only.', 'isCorrect' => false],
                    ['text' => 'B) Shock absorbers or struts.', 'isCorrect' => true],
                    ['text' => 'C) Tires only.', 'isCorrect' => false],
                    ['text' => 'D) Steering wheel.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Shock absorbers dampen spring oscillations and control suspension movement. Worn shocks allow excessive bouncing.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Shock absorbers or struts.<br>Reason: Shocks specifically control dampening and prevent excessive bouncing after impacts.'
            ],
            [
                'problem' => "Shock absorber problems are suspected.",
                'question' => "How can you test shock absorber condition?",
                'options' => [
                    ['text' => 'A) Push down on each corner and count bounces.', 'isCorrect' => true],
                    ['text' => 'B) Check tire pressure only.', 'isCorrect' => false],
                    ['text' => 'C) Test engine compression.', 'isCorrect' => false],
                    ['text' => 'D) Check transmission fluid.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>The bounce test involves pushing down on each corner. Good shocks should stop bouncing after one rebound.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Push down on each corner and count bounces.<br>Reason: This simple test directly checks shock absorber dampening capability.'
            ],
            [
                'problem' => "Bounce test shows more than one rebound at each corner.",
                'question' => "What is the proper replacement strategy for worn shock absorbers?",
                'options' => [
                    ['text' => 'A) Replace only the worst shock.', 'isCorrect' => false],
                    ['text' => 'B) Replace shocks in pairs (front or rear axle).', 'isCorrect' => true],
                    ['text' => 'C) Add heavier oil to existing shocks.', 'isCorrect' => false],
                    ['text' => 'D) Ignore minor bouncing.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Replacing shocks in pairs maintains balanced dampening characteristics and prevents uneven handling.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Replace shocks in pairs (front or rear axle).<br>Reason: Balanced dampening requires matching shock characteristics on each axle.'
            ]
        ]
    ],
    'worn_springs' => [
        'title' => 'Sagging Springs',
        'image' => 'https://images.unsplash.com/photo-1580813904443-5e525be5c11c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Spring metal fatigue causing loss of spring rate and vehicle height, affecting suspension geometry.',
        'solution' => 'Replace sagging springs and check alignment after spring replacement.',
        'learning' => 'Springs support vehicle weight and maintain proper suspension geometry. Sagging affects handling and alignment.',
        'steps' => [
            [
                'problem' => "Vehicle sits lower on one side and has a noticeable lean when parked on level ground.",
                'question' => "What suspension component primarily supports vehicle weight?",
                'options' => [
                    ['text' => 'A) Shock absorbers only.', 'isCorrect' => false],
                    ['text' => 'B) Springs (coil, leaf, or torsion bar).', 'isCorrect' => true],
                    ['text' => 'C) Control arms only.', 'isCorrect' => false],
                    ['text' => 'D) Steering linkage.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Springs bear the vehicle weight and maintain ride height. Sagging springs cause uneven vehicle height.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Springs (coil, leaf, or torsion bar).<br>Reason: Springs specifically support weight and determine ride height.'
            ],
            [
                'problem' => "Spring problems are suspected due to vehicle sagging.",
                'question' => "How can you measure spring condition and vehicle height?",
                'options' => [
                    ['text' => 'A) Measure ride height at specified points.', 'isCorrect' => true],
                    ['text' => 'B) Check engine oil level.', 'isCorrect' => false],
                    ['text' => 'C) Test brake pedal height.', 'isCorrect' => false],
                    ['text' => 'D) Monitor fuel level.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Measuring ride height at manufacturer-specified points determines if springs have sagged below specifications.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Measure ride height at specified points.<br>Reason: Precise measurements determine spring condition and vehicle stance.'
            ],
            [
                'problem' => "Measurements confirm springs have sagged below specifications.",
                'question' => "What additional service is recommended after spring replacement?",
                'options' => [
                    ['text' => 'A) Wheel alignment check and adjustment.', 'isCorrect' => true],
                    ['text' => 'B) Engine tune-up only.', 'isCorrect' => false],
                    ['text' => 'C) Transmission service only.', 'isCorrect' => false],
                    ['text' => 'D) Air filter replacement only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>New springs change suspension geometry and ride height, requiring alignment adjustment for proper tire wear and handling.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Wheel alignment check and adjustment.<br>Reason: Spring replacement changes suspension geometry requiring alignment correction.'
            ]
        ]
    ],
    'worn_control_arms' => [
        'title' => 'Control Arm Problems',
        'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn control arm bushings or ball joints allowing excessive suspension movement and poor wheel control.',
        'solution' => 'Replace worn control arm bushings or complete control arm assembly and perform alignment.',
        'learning' => 'Control arms locate wheels precisely and transfer forces. Worn components cause handling problems and tire wear.',
        'steps' => [
            [
                'problem' => "Vehicle pulls to one side during braking and steering feels loose with wandering at highway speeds.",
                'question' => "What suspension components control wheel positioning and movement?",
                'options' => [
                    ['text' => 'A) Tires and wheels only.', 'isCorrect' => false],
                    ['text' => 'B) Control arms and ball joints.', 'isCorrect' => true],
                    ['text' => 'C) Exhaust system.', 'isCorrect' => false],
                    ['text' => 'D) Fuel system.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Control arms and ball joints precisely locate wheels and transfer steering and braking forces.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Control arms and ball joints.<br>Reason: These components specifically control wheel position and movement.'
            ],
            [
                'problem' => "Control arm problems are suspected.",
                'question' => "How can you inspect control arm bushings and ball joints?",
                'options' => [
                    ['text' => 'A) Visual inspection for cracking and movement test.', 'isCorrect' => true],
                    ['text' => 'B) Check fluid levels only.', 'isCorrect' => false],
                    ['text' => 'C) Test radio reception.', 'isCorrect' => false],
                    ['text' => 'D) Check battery voltage.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Visual inspection reveals cracked bushings, and movement tests show excessive play in worn components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Visual inspection for cracking and movement test.<br>Reason: Physical inspection directly shows bushing and joint condition.'
            ],
            [
                'problem' => "Control arm bushings show severe cracking and movement tests reveal excessive play.",
                'question' => "What service is required after control arm repair?",
                'options' => [
                    ['text' => 'A) Wheel alignment to correct geometry changes.', 'isCorrect' => true],
                    ['text' => 'B) Oil change only.', 'isCorrect' => false],
                    ['text' => 'C) Coolant flush only.', 'isCorrect' => false],
                    ['text' => 'D) Spark plug replacement only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>New control arm components change wheel positioning, requiring alignment to restore proper geometry.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Wheel alignment to correct geometry changes.<br>Reason: Control arm replacement changes suspension geometry requiring alignment adjustment.'
            ]
        ]
    ],
    'sway_bar_problems' => [
        'title' => 'Sway Bar Issues',
        'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn sway bar links or bushings causing excessive body roll and poor cornering stability.',
        'solution' => 'Replace worn sway bar links and bushings to restore anti-roll stability.',
        'learning' => 'Sway bars reduce body roll during cornering by connecting left and right suspension components.',
        'steps' => [
            [
                'problem' => "Vehicle has excessive body lean during cornering and makes clunking noises over bumps.",
                'question' => "What component reduces body roll during cornering?",
                'options' => [
                    ['text' => 'A) Engine mounts.', 'isCorrect' => false],
                    ['text' => 'B) Sway bar (anti-roll bar).', 'isCorrect' => true],
                    ['text' => 'C) Exhaust system.', 'isCorrect' => false],
                    ['text' => 'D) Fuel tank.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Sway bars connect left and right suspension to reduce body roll by transferring forces between sides.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Sway bar (anti-roll bar).<br>Reason: Sway bars specifically control body roll during cornering maneuvers.'
            ],
            [
                'problem' => "Sway bar problems are suspected.",
                'question' => "What sway bar components commonly wear and cause noise?",
                'options' => [
                    ['text' => 'A) End links and bushings.', 'isCorrect' => true],
                    ['text' => 'B) Air filter housing.', 'isCorrect' => false],
                    ['text' => 'C) Fuel injectors.', 'isCorrect' => false],
                    ['text' => 'D) Radiator cap.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Sway bar end links and bushings wear from constant movement and cause clunking noises when loose.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) End links and bushings.<br>Reason: These are the moving components that wear and create noise in sway bar systems.'
            ],
            [
                'problem' => "Sway bar end links show excessive movement and worn bushings.",
                'question' => "What is the typical repair for worn sway bar components?",
                'options' => [
                    ['text' => 'A) Replace worn links and bushings.', 'isCorrect' => true],
                    ['text' => 'B) Remove sway bar completely.', 'isCorrect' => false],
                    ['text' => 'C) Weld links in fixed position.', 'isCorrect' => false],
                    ['text' => 'D) Add more grease only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Worn sway bar components must be replaced to restore proper anti-roll function and eliminate noise.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace worn links and bushings.<br>Reason: Worn components cannot be repaired and must be replaced for proper function.'
            ]
        ]
    ],
    'strut_mount_failure' => [
        'title' => 'Strut Mount Problems',
        'image' => 'https://images.unsplash.com/photo-1486262715619-67b85e0b08d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn strut mount bearing or rubber allowing excessive movement and noise during steering.',
        'solution' => 'Replace strut mount assembly and check alignment after repair.',
        'learning' => 'Strut mounts connect struts to vehicle body and allow rotation during steering. Failed mounts affect steering feel.',
        'steps' => [
            [
                'problem' => "Clunking or grinding noise occurs when turning steering wheel, especially from full lock positions.",
                'question' => "What component allows strut rotation during steering input?",
                'options' => [
                    ['text' => 'A) Brake pads.', 'isCorrect' => false],
                    ['text' => 'B) Strut mount and bearing.', 'isCorrect' => true],
                    ['text' => 'C) Fuel pump.', 'isCorrect' => false],
                    ['text' => 'D) Air filter.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Strut mounts contain bearings that allow strut assemblies to rotate as wheels turn during steering.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Strut mount and bearing.<br>Reason: Strut mounts specifically enable rotation during steering movements.'
            ],
            [
                'problem' => "Strut mount problems are suspected due to steering noise.",
                'question' => "How can you test strut mount condition?",
                'options' => [
                    ['text' => 'A) Turn steering while listening for noise from mount area.', 'isCorrect' => true],
                    ['text' => 'B) Check transmission fluid color.', 'isCorrect' => false],
                    ['text' => 'C) Test engine compression.', 'isCorrect' => false],
                    ['text' => 'D) Monitor fuel pressure.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Turning steering while listening pinpoints noise from worn strut mount bearings or damaged rubber components.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Turn steering while listening for noise from mount area.<br>Reason: This test directly isolates strut mount problems during operation.'
            ],
            [
                'problem' => "Strut mount shows worn bearing and damaged rubber isolation.",
                'question' => "What service should be performed after strut mount replacement?",
                'options' => [
                    ['text' => 'A) Wheel alignment check and adjustment.', 'isCorrect' => true],
                    ['text' => 'B) Engine oil change only.', 'isCorrect' => false],
                    ['text' => 'C) Tire pressure adjustment only.', 'isCorrect' => false],
                    ['text' => 'D) Windshield washer refill only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Strut mount replacement can change wheel positioning and camber, requiring alignment verification and adjustment.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Wheel alignment check and adjustment.<br>Reason: Mount replacement affects suspension geometry requiring alignment check.'
            ]
        ]
    ],
    'alignment_problems' => [
        'title' => 'Wheel Alignment Issues',
        'image' => 'https://images.unsplash.com/photo-1580813904443-5e525be5c11c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Suspension component wear or impact damage causing wheels to point in wrong directions.',
        'solution' => 'Perform complete wheel alignment after identifying and repairing worn suspension components.',
        'learning' => 'Proper wheel alignment ensures even tire wear, straight tracking, and optimal handling performance.',
        'steps' => [
            [
                'problem' => "Vehicle pulls to one side when driving straight and tires show uneven wear patterns on inside or outside edges.",
                'question' => "What causes vehicles to pull to one side during straight driving?",
                'options' => [
                    ['text' => 'A) Dirty air filter.', 'isCorrect' => false],
                    ['text' => 'B) Improper wheel alignment.', 'isCorrect' => true],
                    ['text' => 'C) Low fuel level.', 'isCorrect' => false],
                    ['text' => 'D) Weak battery.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Incorrect wheel alignment causes pulling and uneven tire wear due to wheels pointing in different directions.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Improper wheel alignment.<br>Reason: Alignment specifically controls wheel direction and tracking.'
            ],
            [
                'problem' => "Alignment problems are suspected due to pulling and tire wear.",
                'question' => "What should be checked before performing wheel alignment?",
                'options' => [
                    ['text' => 'A) Suspension component condition and tire pressure.', 'isCorrect' => true],
                    ['text' => 'B) Engine oil level only.', 'isCorrect' => false],
                    ['text' => 'C) Radio antenna position.', 'isCorrect' => false],
                    ['text' => 'D) Fuel cap tightness.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Worn suspension components and incorrect tire pressure affect alignment readings and must be corrected first.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Suspension component condition and tire pressure.<br>Reason: These factors must be correct for accurate alignment measurements.'
            ],
            [
                'problem' => "Suspension components are in good condition and tire pressures are correct.",
                'question' => "What alignment angles are typically adjusted during service?",
                'options' => [
                    ['text' => 'A) Caster, camber, and toe.', 'isCorrect' => true],
                    ['text' => 'B) Engine timing only.', 'isCorrect' => false],
                    ['text' => 'C) Transmission shift points only.', 'isCorrect' => false],
                    ['text' => 'D) Brake pedal height only.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Caster affects steering stability, camber controls tire contact, and toe determines straight tracking.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Caster, camber, and toe.<br>Reason: These three angles define proper wheel alignment specifications.'
            ]
        ]
    ],
    'cv_joint_failure' => [
        'title' => 'CV Joint Problems',
        'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Worn CV joint allowing excessive play or torn CV boot allowing contamination and lubrication loss.',
        'solution' => 'Replace worn CV joint or complete axle assembly and inspect opposite side for wear.',
        'learning' => 'CV joints allow wheels to turn while suspension moves. Boot damage leads to joint failure from contamination.',
        'steps' => [
            [
                'problem' => "Clicking or popping noise occurs when turning, especially from parking lots or tight turns.",
                'question' => "What component allows power transfer to wheels during turning and suspension movement?",
                'options' => [
                    ['text' => 'A) Alternator belt.', 'isCorrect' => false],
                    ['text' => 'B) CV joints (constant velocity joints).', 'isCorrect' => true],
                    ['text' => 'C) Spark plugs.', 'isCorrect' => false],
                    ['text' => 'D) Air conditioning compressor.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>CV joints maintain constant power transfer to wheels while allowing steering and suspension movement.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) CV joints (constant velocity joints).<br>Reason: CV joints specifically enable power transfer during turning and suspension movement.'
            ],
            [
                'problem' => "CV joint problems are suspected due to turning noise.",
                'question' => "How can you test CV joint condition?",
                'options' => [
                    ['text' => 'A) Turn steering full lock and accelerate slowly while listening.', 'isCorrect' => true],
                    ['text' => 'B) Check brake fluid level only.', 'isCorrect' => false],
                    ['text' => 'C) Test horn operation.', 'isCorrect' => false],
                    ['text' => 'D) Check windshield wiper fluid.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>This test loads worn CV joints maximally, making clicking noises most apparent.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Turn steering full lock and accelerate slowly while listening.<br>Reason: This test specifically loads CV joints to reveal wear-related noise.'
            ],
            [
                'problem' => "CV joint test produces loud clicking noises during full-lock turns.",
                'question' => "What is the typical repair for worn CV joints?",
                'options' => [
                    ['text' => 'A) Replace CV joint or complete drive axle.', 'isCorrect' => true],
                    ['text' => 'B) Add grease to existing joint.', 'isCorrect' => false],
                    ['text' => 'C) Tighten axle bolts only.', 'isCorrect' => false],
                    ['text' => 'D) Ignore clicking noises.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Worn CV joints cannot be repaired and must be replaced. Complete axle replacement is often more cost-effective.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Replace CV joint or complete drive axle.<br>Reason: Internal CV joint wear cannot be repaired, only replaced.'
            ]
        ]
    ],
    'tire_wear_patterns' => [
        'title' => 'Abnormal Tire Wear',
        'image' => 'https://images.unsplash.com/photo-1558618047-3c8c76ca7d13?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80',
        'root_cause' => 'Suspension problems, alignment issues, or improper tire pressure causing uneven tire contact patterns.',
        'solution' => 'Identify and repair suspension or alignment problems, then replace worn tires and perform alignment.',
        'learning' => 'Tire wear patterns indicate specific suspension or alignment problems. Early detection prevents tire replacement.',
        'steps' => [
            [
                'problem' => "Tires show uneven wear with some areas worn to the cords while other areas have normal tread depth.",
                'question' => "What conditions typically cause uneven tire wear patterns?",
                'options' => [
                    ['text' => 'A) Clean air filter.', 'isCorrect' => false],
                    ['text' => 'B) Alignment problems or suspension wear.', 'isCorrect' => true],
                    ['text' => 'C) Full fuel tank.', 'isCorrect' => false],
                    ['text' => 'D) New spark plugs.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Improper wheel alignment or worn suspension components cause uneven tire contact and wear patterns.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: B) Alignment problems or suspension wear.<br>Reason: These conditions directly affect tire contact patterns and wear.'
            ],
            [
                'problem' => "Tire wear analysis is needed to identify specific problems.",
                'question' => "What tire wear pattern indicates alignment problems?",
                'options' => [
                    ['text' => 'A) Wear on inside or outside edges only.', 'isCorrect' => true],
                    ['text' => 'B) Even wear across entire tread.', 'isCorrect' => false],
                    ['text' => 'C) No wear at all.', 'isCorrect' => false],
                    ['text' => 'D) Wear only in center of tread.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Edge wear indicates camber or toe problems causing one edge to carry more load than the other.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Wear on inside or outside edges only.<br>Reason: Edge wear specifically indicates alignment angle problems.'
            ],
            [
                'problem' => "Tire wear patterns indicate alignment and suspension problems.",
                'question' => "What is the correct repair sequence for tire wear problems?",
                'options' => [
                    ['text' => 'A) Fix suspension/alignment, then replace tires.', 'isCorrect' => true],
                    ['text' => 'B) Replace tires only and ignore alignment.', 'isCorrect' => false],
                    ['text' => 'C) Rotate tires to different positions.', 'isCorrect' => false],
                    ['text' => 'D) Reduce tire pressure significantly.', 'isCorrect' => false]
                ],
                'feedbackCorrect' => '✅ Correct!<br>Correcting underlying problems first prevents new tires from developing the same wear patterns.',
                'feedbackIncorrect' => '❌ Incorrect.<br>✅ Correct answer: A) Fix suspension/alignment, then replace tires.<br>Reason: Underlying problems must be corrected before tire replacement.'
            ]
        ]
    ]
];
?>
