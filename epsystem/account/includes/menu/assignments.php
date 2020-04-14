<?php

$menu = [
    "hud" => "Assignments",
    "level-1" => [
        "+ New" => [
            "admin" => false,
            "link" => "new",
            "default-link" => "new",
            "page" => "new-assignment",
            "hud" => "New Assignment",
            "home" => [
                "title" => "Title",
                "description" => "Description",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 62
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "Moved to pending",
                            "count" => "+5"
                        ]
                    ],
                ],
                "link" => "List",
                "note" => "Note"
            ]
        ],
        "AVAILABLE" => [
            "admin" => false,
            "link" => "available",
            "default-link" => "available&l2=production",
            "hud" => "Available Assignments",
            "home" => [
                "title" => "Title",
                "description" => "Description",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 62
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "Moved to pending",
                            "count" => "+5"
                        ]
                    ],
                ],
                "link" => "List",
                "note" => "Note"
            ],
            "level-2" => [
                "PRODUCTION" => [
                    "admin" => false,
                    "count" => Assignment::selectAvailableAssignmentCount(true),
                    "link" => "production",
                    "default-link" => "production",
                    "hud" => "Available Production Assignments",
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
                "CUSTOM" => [
                    "admin" => false,
                    "count" => Assignment::selectAvailableAssignmentCount(false),
                    "link" => "custom",
                    "default-link" => "custom",
                    "hud" => "Available Custom Assignments",
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
                "APPROVAL" => [
                    "admin" => false,
                    "link" => "approval",
                    "default-link" => "approval",
                    "hud" => "Available Approval Assignments",
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
                "MANAGEMENT" => [
                    "admin" => false,
                    "link" => "management",
                    "default-link" => "management",
                    "hud" => "Available Management Assignments",
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
        ],
        "MINE" => [
            "admin" => false,
            "link" => "mine",
            "default-link" => "mine&l2=active",
            "hud" => "My Assignments",
            "home" => [
                "title" => "Title",
                "description" => "Description",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 62
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "Moved to pending",
                            "count" => "+5"
                        ]
                    ],
                ],
                "link" => "List",
                "note" => "Note"
            ],
            "level-2" => [
                "PENDING" => [
                    "admin" => false,
                    "link" => "pending",
                    "default-link" => "pending",
                    "hud" => "My Pending Assignments",
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
                "ACTIVE" => [
                    "admin" => false,
                    "count" => 1,
                    "link" => "active",
                    "default-link" => "active",
                    "hud" => "My Active Assignments",
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
                "COMPLETED" => [
                    "admin" => false,
                    "link" => "completed",
                    "default-link" => "completed",
                    "hud" => "My Completed Assignments",
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
        ],
        "ALL" => [
            "admin" => false,
            "link" => "all",
            "default-link" => "all",
            "hud" => "All Assignments",
            "home" => [
                "title" => "Title",
                "description" => "Description",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 62
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "Moved to pending",
                            "count" => "+5"
                        ]
                    ],
                ],
                "link" => "List",
                "note" => "Note"
            ]
        ]
    ]
];