<?php

if (!isset($_GET['py']))
    $menu = [
        "hud" => "Numbers",
        "level-1" => [
            "MY PROGRESS" => [
                "admin" => false,
                "link" => "progress",
                "default-link" => "progress",
                "hud" => "My Progress Overview",
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
            "MY TIME & MONEY" => [
                "admin" => false,
                "link" => "overview",
                "default-link" => "overview",
                "hud" => "My Time & Money Overview",
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
            "MY MONEY PAYMENTS" => [
                "admin" => false,
                "link" => "payments",
                "default-link" => "payments",
                "hud" => "My Money Payments",
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
            "EP NUMBERS" => [
                "admin" => false,
                "manager" => true,
                "link" => "everyone",
                "default-link" => "everyone",
                "hud" => "ep system Numbers",
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
                    "PROJECT & ASSIGNMENT" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "overview",
                        "default-link" => "overview",
                        "hud" => "Project & Assignment Numbers",
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
                        "hud" => "Time & Money Numbers",
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
                        "hud" => "Research & Development Numbers",
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
                        "hud" => "Member Numbers",
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
                        "hud" => "Payments To Members",
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
    if (!isset($_GET['options'])) {
        $hud = "Payment Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "PAYMENT OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $hud,
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
                    "hud" => $hud,
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
}