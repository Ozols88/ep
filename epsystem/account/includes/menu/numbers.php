<?php

if (!isset($_GET['py']))
    $menu = [
        "hud" => "Numbers",
        "level-1" => [
            "MY PROGRESS" => [
                "admin" => false,
                "link" => "progress",
                "default-link" => "progress",
                "hud" => "My Progress",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
                        "name" => "",
                        "count" => ""
                    ],
                    "last-hours" => [
                        "title" => "",
                        "details" => []
                    ],
                    "link" => "",
                    "note" => ""
                ]
            ],
            "MY MONEY" => [
                "admin" => false,
                "link" => "money",
                "default-link" => "money&l2=overview",
                "hud" => "My money",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
                        "name" => "",
                        "count" => ""
                    ],
                    "last-hours" => [
                        "title" => "",
                        "details" => []
                    ],
                    "link" => "",
                    "note" => ""
                ],
                "level-2" => [
                    "MONEY OVERVIEW" => [
                        "admin" => false,
                        "link" => "overview",
                        "default-link" => "overview",
                        "hud" => "Money overview",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                    "MONEY PAYMENTS" => [
                        "admin" => false,
                        "link" => "payments",
                        "default-link" => "payments",
                        "hud" => "Money payments",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                ]
            ],
            "EP NUMBERS" => [
                "admin" => false,
                "manager" => true,
                "link" => "everyone",
                "default-link" => "everyone",
                "hud" => "Everyone",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
                        "name" => "",
                        "count" => ""
                    ],
                    "last-hours" => [
                        "title" => "",
                        "details" => []
                    ],
                    "link" => "",
                    "note" => ""
                ],
                "level-2" => [
                    "PROJECTS, ASSIGNMENTS & TASKS" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "overview",
                        "default-link" => "overview",
                        "hud" => "Overview",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                    "TIME & MONEY" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "123",
                        "default-link" => "123",
                        "hud" => "Payments",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                    "RESEARCH & DEVELOPMENT" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "789",
                        "default-link" => "789",
                        "hud" => "Payments",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                    "MEMBER NUMBERS" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "456",
                        "default-link" => "456",
                        "hud" => "Payments",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                    "PAYMENTS TO MEMBERS" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "payments",
                        "default-link" => "payments",
                        "hud" => "Payments",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
                                "name" => "",
                                "count" => ""
                            ],
                            "last-hours" => [
                                "title" => "",
                                "details" => []
                            ],
                            "link" => "",
                            "note" => ""
                        ]
                    ],
                ]
            ]
        ]
    ];
else {
    $payment = Assignment::selectPaymentByID($_GET['py']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => "Payment",
            "level-1" => [
                "PAYMENT OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => "Payment #" . sprintf('%05d', $payment['id']) . " info",
                    "home" => [
                        "title" => "",
                        "description" => "",
                        "total" => [
                            "name" => "",
                            "count" => ""
                        ],
                        "last-hours" => [
                            "title" => "",
                            "details" => []
                        ],
                        "link" => "",
                        "note" => ""
                    ],
                    "level-2" => [
                        "Edit Payment Description" => [
                            "admin" => false,
                            "page" => "numbers.php?py=" . $_GET['py'] . "&options&l1=edit&l2=description",
                            "hud" => ""
                        ]
                    ]
                ],
                "PAYMENT ASSIGNMENTS" => [
                    "admin" => false,
                    "link" => "assignments",
                    "default-link" => "assignments",
                    "hud" => "Payment #" . sprintf('%05d', $payment['id']) . " assignments",
                    "home" => [
                        "title" => "",
                        "description" => "",
                        "total" => [
                            "name" => "",
                            "count" => ""
                        ],
                        "last-hours" => [
                            "title" => "",
                            "details" => []
                        ],
                        "link" => "",
                        "note" => ""
                    ]
                ]
            ]
        ];
}