<?php

$project = Project::selectAdminProjectStatic($_GET['p']);
if ($project) {
    $hudInitial = "Project #" . sprintf('%04d', $project['project_id']);
}
else {
    header("Location: projects.php");
    exit();
}

$menu = [
    "hud" => $hudInitial,
    "level-1" => [
        "PROJECT" => [
            "admin" => false,
            "link" => "project",
            "default-link" => "project",
            "hud" => $hudInitial . ": Project",
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
            ],
            "level-2" => [
                "OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $hudInitial . ": Project Overview",
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
                "CLIENT" => [
                    "admin" => false,
                    "link" => "client",
                    "default-link" => "client",
                    "hud" => $hudInitial . ": Project Client",
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
                "OPTIONS" => [
                    "admin" => false,
                    "link" => "options",
                    "default-link" => "options",
                    "hud" => $hudInitial . ": Project Options",
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
        "ASSIGNMENTS" => [
            "admin" => false,
            "link" => "assignments",
            "default-link" => "assignments",
            "hud" => $hudInitial . ": Assignments",
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
        "INFO" => [
            "admin" => false,
            "link" => "info",
            "default-link" => "info",
            "hud" => $hudInitial . ": Info",
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
            ],
            "level-2" => [
                "PRODUCT" => [
                    "admin" => false,
                    "link" => "product",
                    "default-link" => "product",
                    "hud" => $hudInitial . ": Info Product",
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
                "STYLE" => [
                    "admin" => false,
                    "link" => "style",
                    "default-link" => "style",
                    "hud" => $hudInitial . ": Info Style",
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
/*// Project manager check
if ($project['assigned_to']) {
    $menu['level-1']['INFO']['level-2']['OPTIONS']['level-3'] = [
        "RE-ASSIGN" => [
            "admin" => false,
            "locked" => false,
            "link" => "",
            "default-link" => "",
            "hud" => $hudInitial . ": Options"
        ],
        "EDIT" => [
            "admin" => false,
            "locked" => false,
            "link" => "",
            "default-link" => "",
            "hud" => $hudInitial . ": Options"
        ],
        "PAUSE" => [
            "admin" => false,
            "locked" => false,
            "link" => "",
            "default-link" => "",
            "hud" => $hudInitial . ": Options"
        ],
        "CANCEL" => [
            "admin" => false,
            "locked" => false,
            "link" => "",
            "default-link" => "",
            "hud" => $hudInitial . ": Options"
        ],
        "DELETE" => [
            "admin" => false,
            "locked" => false,
            "link" => "",
            "default-link" => "",
            "hud" => $hudInitial . ": Options"
        ]
    ];
}*/
// Client check
if (isset($_POST['submit']) && $_POST['submit'] == "Add Client" || isset($_SESSION['add-client']['stage']) && $_SESSION['add-client']['stage'] == 2)
    $menu['level-1']['INFO']['level-2']['CLIENT']['hud'] = $hudInitial . ": Add Client";
// Manager check
if (isset($_POST['submit']) && $_POST['submit'] == "Assign Manager" || isset($_SESSION['new-manager']['stage']) && $_SESSION['new-manager']['stage'] == 2) {
    $menu['level-1']['INFO']['level-2']['OPTIONS']['hud'] = $hudInitial . ": Assign Manager";
}
// Assignments and tasks check
$types = [
    1 => "PRODUCTION",
    0 => "CUSTOM",
    3 => "REVIEW",
    2 => "MANAGEMENT"
];
if (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
    foreach ($types as $typeNum => $typeName) {
        $menu['level-1']['ASSIGNMENTS']['level-2'][strtoupper($typeName)] = [
            "admin" => false,
            "link" => $typeNum,
            "default-link" => $typeNum,
            "hud" => $hudInitial . ": " . $typeName . " Assignments",
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
        ];
        $departments = Project::selectProjectDepartments($_GET['p'], $typeNum);
        if ($departments) {
            foreach ($departments as $department)
            $menu['level-1']['ASSIGNMENTS']['level-2'][strtoupper($typeName)]['level-3'][strtoupper($department['depart_title'])] = [
                "admin" => false,
                "count" => $department['assignment_count'],
                "link" => $department['depart_id'],
                "default-link" => $department['depart_id'],
                "hud" => $hudInitial . ": " . $department['depart_title'] . " Assignments",
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
            ];
        }
    }
}