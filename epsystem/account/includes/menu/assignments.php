<?php

// Assignment list
if (isset($account)) {
    $todo = Assignment::selectAvailableAssignments($account);
        $pending1 = Assignment::selectAssignmentListByStatusAndAccount(1, $account->id);
        $pending2 = Assignment::selectAssignmentListByStatusAndAccount(2, $account->id);
        $pending5 = Assignment::selectAssignmentListByStatusAndAccount(5, $account->id);
        $pending6 = Assignment::selectAssignmentListByStatusAndAccount(6, $account->id);
    $myPending = array_merge((array)$pending1, (array)$pending2, (array)$pending5, (array)$pending6);
    $myActive = Assignment::selectAssignmentListByStatusAndAccount(4, $account->id);
        $completed7 = Assignment::selectAssignmentListByStatusAndAccount(7, $account->id);
        $completed9 = Assignment::selectAssignmentListByStatusAndAccount(9, $account->id);
    $myCompleted = array_merge((array)$completed7, (array)$completed9);
    if ($account->manager == 1) {
            $pending1 = Assignment::selectCurrentProjectAssignmentsByStatus(1);
            $pending2 = Assignment::selectCurrentProjectAssignmentsByStatus(2);
            $pending5 = Assignment::selectCurrentProjectAssignmentsByStatus(5);
            $pending6 = Assignment::selectCurrentProjectAssignmentsByStatus(6);
        $allPending = array_merge((array)$pending1, (array)$pending2, (array)$pending5, (array)$pending6);
        $allAvailable = Assignment::selectCurrentProjectAssignmentsByStatus(3);
        $allActive = Assignment::selectCurrentProjectAssignmentsByStatus(4);
            $completed7 = Assignment::selectCurrentProjectAssignmentsByStatus(7);
            $completed9 = Assignment::selectCurrentProjectAssignmentsByStatus(9);
        $allCompleted = array_merge((array)$completed7, (array)$completed9);
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
            "hud" => "Available assignments",
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllAvailable,
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllActive,
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
                    "admin" => true,
                    "manager" => true,
                    "count" => $countAllCompleted,
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