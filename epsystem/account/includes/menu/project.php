<?php

$project = Project::selectProject($_GET['p']);
if ($project) {
    $hudInitial = $project['title'];
}
else {
    header("Location: projects.php");
    exit();
}

if (!isset($_GET['options'])) {
    $menu = [
        "hud" => $hudInitial,
        "level-1" => [
            "PROJECT" => [
                "admin" => false,
                "link" => "project",
                "default-link" => "project&l2=overview",
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
                    "Edit" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "",
                        "default-link" => "",
                        "page" => "",
                        "hud" => $hudInitial,
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
                        "manager" => true,
                        "link" => "client",
                        "default-link" => "client&l3=about",
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
                        ],
                        "level-3" => [
                            "Edit" => [
                                "admin" => false,
                                "manager" => true,
                                "page" => "",
                                "link" => "",
                                "default-link" => "",
                                "hud" => $hudInitial,
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
                            "ABOUT" => [
                                "admin" => false,
                                "link" => "about",
                                "default-link" => "about",
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
                            "OTHER PROJECTS" => [
                                "admin" => false,
                                "link" => "other-projects",
                                "default-link" => "other-projects",
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
                            ]
                        ]
                    ],
                    "Options" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "options",
                        "default-link" => "options",
                        "page" => "?p=" . $_GET['p'] . "&options",
                        "hud" => $hudInitial . ": Options",
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
                        "manager" => true,
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
                    ],
                    "PENDING" => [
                        "admin" => false,
                        "link" => "pending",
                        "default-link" => "pending",
                        "hud" => $hudInitial . ": Pending Assignments",
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
                        "link" => "active",
                        "default-link" => "active",
                        "hud" => $hudInitial . ": Active Assignments",
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
                        "hud" => $hudInitial . ": Completed Assignments",
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
    // Open only available option for member
    if (isset($account->manager) && $account->manager == 0)
        if (isset($_GET['l1']) && $_GET['l1'] == "project" && !isset($_GET['l2']))
            header('Location: ?p=' . $_GET['p'] . '&l1=project&l2=overview');
}
else {
    $hudInitial .= ": Options";
    $menu = [
        "hud" => $hudInitial,
        "level-1" => [
            // Cancel button goes here
            // Complete button goes here
            "DELETE" => [
                "admin" => true,
                "link" => "delete",
                "default-link" => "delete",
                "hud" => $hudInitial . ": Delete",
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
    // Check if cancel button is needed
    if ($project['statusid'] != 7 && $project['statusid'] != 8)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 0), array("CANCEL" => [
            "admin" => true,
            "link" => "cancel",
            "default-link" => "cancel",
            "hud" => $hudInitial . ": Cancel",
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
        ]), array_slice($menu['level-1'], 0));
    // Check if cancel lvl2 menu is needed
    $canCancel = Project::isProjectCancelable($project);
    if ($canCancel) {
        $menu['level-1']['CANCEL']['level-2'] = [
            "CLIENT CANCEL" => [
                "admin" => true,
                "link" => "1",
                "default-link" => "1",
                "hud" => $hudInitial . ": Cancel",
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
            "CAN'T FINISH" => [
                "admin" => true,
                "link" => "2",
                "default-link" => "2",
                "hud" => $hudInitial . ": Cancel",
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
            "DON'T NEED" => [
                "admin" => true,
                "link" => "3",
                "default-link" => "3",
                "hud" => $hudInitial . ": Cancel",
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
        ];
    }

    // Check if complete button is needed
    if ($project['statusid'] != 7 && $project['statusid'] != 8)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("COMPLETE" => [
            "admin" => true,
            "link" => "complete",
            "default-link" => "complete",
            "hud" => $hudInitial . ": Complete",
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
        ]), array_slice($menu['level-1'], 1));
    // Check if project is completable
    $canComplete = Project::isProjectCompletable($project);

    // Check if project is deletable
    $canDelete = Project::isProjectDeletable($project);
}