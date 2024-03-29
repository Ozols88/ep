<?php

// Project list
if (isset($account)) {
    $pending = Project::selectProjectsByStatus(1, $account);
    $active = Project::selectProjectsByStatus(2, $account);
    $completed = Project::selectProjectsByStatus(3, $account);
    $canceled = Project::selectProjectsByStatus(4, $account);
}
// Project count
if (is_countable($pending)) $countPending = count($pending);
else $countPending = 0;
if (is_countable($active)) $countActive = count($active);
else $countActive = 0;

$menu = [
    "hud" => "Projects",
    "level-1" => [
        "+ Project" => [
            "admin" => false,
            "manager" => true,
            "link" => "new",
            "default-link" => "new",
            "page" => "new-project",
            "hud" => "New Project"
        ],
        "PENDING" => [
            "admin" => false,
            "count" => $countPending,
            "link" => "pending",
            "default-link" => "pending",
            "hud" => "Pending Projects",
            "home" => [
                "title" => "All Pending Projects",
                "description" => "Here you can access and view projects that have been paused for reasons such us awaiting approval",
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
                "link" => "Project List",
                "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
            ]
        ],
        "ACTIVE" => [
            "admin" => false,
            "count" => $countActive,
            "link" => "active",
            "default-link" => "active",
            "hud" => "Active Projects",
            "home" => [
                "title" => "All Active Projects",
                "description" => "Here you can access and view projects that are currently in production",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 100
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "New projects",
                            "count" => "+15"
                        ],
                        [
                            "name" => "Reactivated",
                            "count" => "+15"
                        ]
                    ]
                ],
                "link" => "Project List",
                "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
            ]
        ],
        "COMPLETED" => [
            "admin" => false,
            "link" => "completed",
            "default-link" => "completed",
            "hud" => "Completed Projects",
            "home" => [
                "title" => "All Completed Projects",
                "description" => "Here you can access and view projects that have been completed",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 9999
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "Completed",
                            "count" => "+20"
                        ]
                    ]
                ],
                "link" => "Project List",
                "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
            ]
        ],
        "CANCELED" => [
            "admin" => false,
            "link" => "canceled",
            "default-link" => "canceled",
            "hud" => "Canceled Projects",
            "home" => [
                "title" => "All Canceled Projects",
                "description" => "Here you can access and view projects that have been canceled",
                "total" => [
                    "name" => "Total Projects",
                    "count" => 49
                ],
                "last-hours" => [
                    "title" => "In the last 24h",
                    "details" => [
                        [
                            "name" => "Canceled",
                            "count" => "0"
                        ]
                    ]
                ],
                "link" => "Project List",
                "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
            ]
        ]
    ]
];