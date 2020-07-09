<?php

$project = Project::selectProject($_GET['p']);
if ($project) {
    $hudInitial = "Project #" . sprintf('%04d', $project['id']);
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
            ],
            "level-2" => [
                "+ New Assignment" => [
                    "admin" => false,
                    "link" => "new",
                    "default-link" => "new",
                    "page" => "new-assignment.php?p=" . $_GET['p'],
                    "hud" => "New Assignment",
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
    $menu['level-1']['PROJECT']['level-2']['CLIENT']['hud'] = $hudInitial . ": Add Client";
// Manager check
if (isset($_POST['submit']) && $_POST['submit'] == "Assign Manager" || isset($_SESSION['new-manager']['stage']) && $_SESSION['new-manager']['stage'] == 2) {
    $menu['level-1']['PROJECT']['level-2']['OPTIONS']['hud'] = $hudInitial . ": Assign Manager";
}
// Assignments and tasks check
if (isset($_GET['l1']) && $_GET['l1'] == "assignments") {
    $divisions = Project::selectProjectDivisions($_GET['p']);
    if ($divisions) {
        if (count($divisions) < 6) {
            foreach ($divisions as $division) {
                $menu['level-1']['ASSIGNMENTS']['level-2'][strtoupper($division['division_title'])] = [
                    "admin" => false,
                    "count" => $division['assignment_count'],
                    "link" => $division['division_id'],
                    "default-link" => $division['division_id'],
                    "hud" => $hudInitial . ": " . $division['division_title'] . " Assignments",
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
                ];
                if (count($divisions) == 1 && !isset($_GET['l2'])) header("Location: projects.php?p=" . $project['id'] . "&l1=assignments&l2=" . $division['division_id']);
            }
        }
        else {
            $groupView = true;
            $currentGroup = null;
            foreach ($divisions as $division) {
                if ($currentGroup != $division['group_id']) {
                    $currentGroup = $division['group_id'];
                    $menu['level-1']['ASSIGNMENTS']['level-2'][strtoupper($division['group_title'])] = [
                        "admin" => false,
                        "link" => $division['group_id'],
                        "default-link" => $division['group_id'],
                        "hud" => $hudInitial . ": " . $division['group_title'] . " Divisions",
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
                    ];
                }
                $menu['level-1']['ASSIGNMENTS']['level-2'][strtoupper($division['group_title'])]['level-3'][strtoupper($division['division_title'])] = [
                    "admin" => false,
                    "count" => $division['assignment_count'],
                    "link" => $division['division_id'],
                    "default-link" => $division['division_id'],
                    "hud" => $hudInitial . ": " . $division['division_title'] . " Assignments",
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
                ];
            }
            // If current group has only one division, open it
            if (isset($_GET['l2']) && !isset($_GET['l3']))
                foreach ($menu['level-1']['ASSIGNMENTS']['level-2'] as $title => $group) {
                    if ($title == "+ New Assignment") continue;

                    if (count($group['level-3']) == 1 && $_GET['l2'] == $group['link'])
                        foreach ($group['level-3'] as $division)
                            header("Location: projects.php?p=" . $_GET['p'] . "&l1=assignments&l2=" . $_GET['l2'] . "&l3=" . $division['link']);
                }
        }
    }
}