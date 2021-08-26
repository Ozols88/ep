<?php

// Assignment list
if (isset($account)) {
    $todo = Assignment::selectAvailableAssignments($account);
    $myPending = Assignment::selectAssignmentListByStatusAndAccount("pending", $account->id);
    $myActive = Assignment::selectAssignmentListByStatusAndAccount("active", $account->id);
    $myCompleted = Assignment::selectAssignmentListByStatusAndAccount("completed", $account->id);
    if ($account->manager == 1) {
        $allPending = Assignment::selectCurrentProjectAssignmentsByStatus("pending");
        $allAvailable = Assignment::selectCurrentProjectAssignmentsByStatus("available");
        $allActive = Assignment::selectCurrentProjectAssignmentsByStatus("active");
        $allCompleted = Assignment::selectCurrentProjectAssignmentsByStatus("completed");
    }
}
// Assignment count
if (is_countable($todo)) $countToDo = count($todo);
else $countToDo = 0;
if (is_countable($myPending)) $countMyPending = count($myPending);
else $countMyPending = 0;
if (is_countable($myActive)) $countMyActive = count($myActive);
else $countMyActive = 0;
if (is_countable($myCompleted)) $countMyCompleted = count($myCompleted);
else $countMyCompleted = 0;
if (isset($allPending) && is_countable($allPending)) $countAllPending = count($allPending);
else $countAllPending = 0;
if (isset($allAvailable) && is_countable($allAvailable)) $countAllAvailable = count($allAvailable);
else $countAllAvailable = 0;
if (isset($allActive) && is_countable($allActive)) $countAllActive = count($allActive);
else $countAllActive = 0;
if (isset($allCompleted) && is_countable($allCompleted)) $countAllCompleted = count($allCompleted);
else $countAllCompleted = 0;

$menu = [
    "hud" => "Assignments",
    "level-1" => [
        "TO DO" => [
            "admin" => false,
            "count" => $countToDo,
            "link" => "to-do",
            "default-link" => "to-do",
            "hud" => "To do assignments",
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
                    "count" => $countMyPending,
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
                    "count" => $countMyActive,
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
                    "count" => $countMyCompleted,
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
        "EP ASSIGNMENTS" => [
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllPending,
                    "link" => "pending",
                    "default-link" => "pending",
                    "hud" => "Pending Assignments",
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllAvailable,
                    "link" => "available",
                    "default-link" => "available",
                    "hud" => "Available Assignments",
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllActive,
                    "link" => "active",
                    "default-link" => "active",
                    "hud" => "In Progress Assignments",
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllCompleted,
                    "link" => "completed",
                    "default-link" => "completed",
                    "hud" => "Completed Assignments",
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