<?php

$menu = [
    "hud" => "Assignments",
    "level-1" => [
        "+ New Assignment" => [
            "admin" => false,
            "manager" => true,
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
        "TO DO" => [
            "admin" => false,
            "count" => Assignment::selectAssignmentCountByStatus(3),
            "link" => "to-do",
            "default-link" => "to-do",
            "hud" => "To Do Assignments",
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
        "MY ASSIGNMENTS" => [
            "admin" => false,
            "link" => "my",
            "default-link" => "my&l2=active",
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
                    "count" => Assignment::selectAssignmentCountByStatusAndAccount(1, $account->id) + Assignment::selectAssignmentCountByStatusAndAccount(2, $account->id)  + Assignment::selectAssignmentCountByStatusAndAccount(5, $account->id) + Assignment::selectAssignmentCountByStatusAndAccount(6, $account->id),
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
                    "count" => Assignment::selectAssignmentCountByStatusAndAccount(4, $account->id),
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
                    "count" => Assignment::selectAssignmentCountByStatusAndAccount(7, $account->id),
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
        "ALL ASSIGNMENTS" => [
            "admin" => false,
            "manager" => true,
            "link" => "all",
            "default-link" => "all&l2=pending",
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
            ],
            "level-2" => [
                "PENDING" => [
                    "admin" => false,
                    "manager" => true,
                    "count" => Assignment::selectCurrentProjectAssignmentCountByStatus(1) + Assignment::selectCurrentProjectAssignmentCountByStatus(2) + Assignment::selectCurrentProjectAssignmentCountByStatus(5) + Assignment::selectCurrentProjectAssignmentCountByStatus(6),
                    "link" => "pending",
                    "default-link" => "pending",
                    "hud" => "All Pending Assignments",
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
                "AVAILABLE" => [
                    "admin" => false,
                    "manager" => true,
                    "count" => Assignment::selectCurrentProjectAssignmentCountByStatus(3),
                    "link" => "available",
                    "default-link" => "available",
                    "hud" => "All Available Assignments",
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
                "IN PROGRESS" => [
                    "admin" => false,
                    "manager" => true,
                    "count" => Assignment::selectCurrentProjectAssignmentCountByStatus(4),
                    "link" => "active",
                    "default-link" => "active",
                    "hud" => "All Active Assignments",
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
                    "manager" => true,
                    "count" => Assignment::selectCurrentProjectAssignmentCountByStatus(7),
                    "link" => "completed",
                    "default-link" => "completed",
                    "hud" => "All Completed Assignments",
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
        ]
    ]
];