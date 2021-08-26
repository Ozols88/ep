<?php

$project = Project::selectProject($_GET['p']);
// Check member participation in project
if (isset($account) && $account->manager == 0) {
    $assignments = Assignment::selectProjectAssignments($project['id']);
    $participate = false;
    foreach ($assignments as $assignment) {
        if ($assignment['assigned_to'] == $account->id) {
            $participate = true;
            break;
        }
    }
}
if ($project && isset($account) && ($account->manager == 1 || $participate == true))
    $projectID = "#" . sprintf('%04d', $project['id']);
else {
    header("Location: projects.php?l1=active");
    exit();
}

// Possible actions
$canDelete = Project::isProjectDeletable($project);
$canCancel = Project::isProjectCancelable($project);
$canComplete = Project::isProjectCompletable($project);
// Project page
if (!isset($_GET['options']) && !isset($_GET['ioptions'])) {
    // Project list
    $pending = Assignment::selectProjectAssignmentsByStatus($project['id'], "pending", $account);
    $active = Assignment::selectProjectAssignmentsByStatus($project['id'], "active", $account);
    $completed = Assignment::selectProjectAssignmentsByStatus($project['id'], "completed", $account);
    // Project count
    if (is_countable($pending)) $countPending = count($pending);
    else $countPending = 0;
    if (is_countable($active)) $countActive = count($active);
    else $countActive = 0;
    if (is_countable($completed)) $countCompleted = count($completed);
    else $countCompleted = 0;
    $menu = [
        "hud" => "Project " . $projectID . " Page",
        "level-1" => [
            "PROJECT OVERVIEW" => [
                "admin" => false,
                "link" => "project",
                "default-link" => "project&l2=overview",
                "hud" => "Project " . $projectID . " Page",
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
                    "Edit Project" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "",
                        "page" => "?p=" . $_GET['p'] . "&options&l1=edit",
                        "hud" => ""
                    ]
                ]
            ],
            "PROJECT ASSIGNMENTS" => [
                "admin" => false,
                "link" => "assignments",
                "default-link" => "assignments&l2=active",
                "hud" => "Project " . $projectID . " Page",
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
                    "+ Assignment Preset" => [
                        "admin" => false,
                        "manager" => true,
                        "link" => "new",
                        "default-link" => "new",
                        "page" => "projects.php?p=" . $_GET['p'] . "&options&l1=add",
                        "hud" => "",
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
                        "count" => $countPending,
                        "link" => "pending",
                        "default-link" => "pending",
                        "hud" => "Project " . $projectID . " Page",
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
                        "count" => $countActive,
                        "link" => "active",
                        "default-link" => "active",
                        "hud" => "Project " . $projectID . " Page",
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
                        "count" => $countCompleted,
                        "link" => "completed",
                        "default-link" => "completed",
                        "hud" => "Project " . $projectID . " Page",
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
            "PROJECT LINKS" => [
                "admin" => false,
                "link" => "info",
                "default-link" => "info",
                "hud" => "Project " . $projectID . " Page",
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
    if ($canComplete)
        $menu['level-1']['PROJECT OVERVIEW']['level-2']['Complete Project'] = [
            "admin" => false,
            "page" => "projects.php?p=" . $_GET['p'] . "&options&l1=actions&l2=complete",
            "hud" => ""
        ];
    if ($canCancel)
        $menu['level-1']['PROJECT OVERVIEW']['level-2']['Cancel Project'] = [
            "admin" => false,
            "page" => "projects.php?p=" . $_GET['p'] . "&options&l1=actions&l2=cancel",
            "hud" => ""
        ];
    if ($canDelete)
        $menu['level-1']['PROJECT OVERVIEW']['level-2']['Delete Project'] = [
            "admin" => false,
            "page" => "projects.php?p=" . $_GET['p'] . "&options&l1=actions&l2=delete",
            "hud" => ""
        ];

    if ($project['status1'] != 1 && $project['status1'] != 2)
        unset($menu['level-1']['PROJECT ASSIGNMENTS']['level-2']['+ Assignment Preset']);

    // Info pages
    $infoPages = Project::selectProjectInfoPages($project['id']);
    if ($infoPages) {
        $prevGroup = null;
        if (count($infoPages) > 5) {
            if (isset($_GET['l2']) && $_GET['l2'] == "") // Fix for group "none"
                $menu['level-1']['PROJECT LINKS']['hud'] = "Project " . $projectID . " Page";
            foreach ($infoPages as $page) {
                // Lvl2 (info page group)
                if ($prevGroup != $page['group']) {
                    $menu['level-1']['PROJECT LINKS']['level-2'][$page['group']] = [
                        "admin" => false,
                        "link" => $page['groupid'],
                        "default-link" => $page['groupid'],
                        "hud" => "Project " . $projectID . " Page",
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
                    $prevGroup = $page['group'];
                }

                if (isset($page['link'])) $hasLink = "Link to the darkness!";
                else $hasLink = "No link to darkness!";

                // Lvl3 (info page)
                $menu['level-1']['PROJECT LINKS']['level-2'][$page['group']]['level-3'][$page['title']] = [
                    "admin" => false,
                    "page" => $page['link'],
                    "new-tab" => true,
                    "hud" => "",
                    "home" => [
                        "title" => $page['title'],
                        "description" => $page['description'],
                        "total" => [
                            "name" => "",
                            "count" => ""
                        ],
                        "last-hours" => [
                            "title" => "",
                            "details" => []
                        ],
                        "link" => "Open",
                        "note" => $hasLink
                    ]
                ];
            }
        }
        else {
            $menu['level-1']['PROJECT LINKS']['hud'] = "Project " . $projectID . " Page"; // Different hud when no info groups in menu
            foreach ($infoPages as $page) {
                if (isset($page['link'])) $hasLink = "Link to the darkness!";
                else $hasLink = "No link to darkness!";

                // Lvl2 (info page)
                $menu['level-1']['PROJECT LINKS']['level-2'][$page['title']] = [
                    "admin" => false,
                    "page" => $page['link'],
                    "new-tab" => true,
                    "hud" => "",
                    "home" => [
                        "title" => $page['title'],
                        "description" => $page['description'],
                        "total" => [
                            "name" => "",
                            "count" => ""
                        ],
                        "last-hours" => [
                            "title" => "",
                            "details" => []
                        ],
                        "link" => "Open",
                        "note" => $hasLink
                    ]
                ];
            }
        }

    }
    $menu['level-1']['PROJECT LINKS']['level-2']['Project Link Options'] = [
        "admin" => false,
        "manager" => true,
        "page" => "?p=" . $_GET['p'] . "&ioptions&l1=edit",
        "hud" => $projectID . ": Options",
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
    // Open only available option for member
    if (isset($account->manager) && $account->manager == 0)
        if (isset($_GET['l1']) && $_GET['l1'] == "project" && !isset($_GET['l2']))
            header('Location: ?p=' . $_GET['p'] . '&l1=project&l2=overview');
}

// Project options
elseif (isset($_GET['options'])) {
    $menu = [
        "hud" => "Project " . $projectID . " Options",
        "level-1" => [
            "+ ASSIGNMENT PRESET" => [
                "admin" => true,
                "link" => "add",
                "default-link" => "add",
                "hud" => "Project " . $projectID . " Options",
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
            "EDIT PROJECT" => [
                "admin" => true,
                "manager" => true,
                "link" => "edit",
                "default-link" => "edit",
                "hud" => "Project " . $projectID . " Options",
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
                    "PROJECT PRESET" => [
                        "admin" => true,
                        "link" => "preset",
                        "default-link" => "preset",
                        "hud" => "Project " . $projectID . " Options",
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
                    "PROJECT NAME" => [
                        "admin" => true,
                        "link" => "name",
                        "default-link" => "name",
                        "hud" => "Project " . $projectID . " Options",
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
                    "PROJECT DESCRIPTION" => [
                        "admin" => true,
                        "link" => "description",
                        "default-link" => "description",
                        "hud" => "Project " . $projectID . " Options",
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
            "PROJECT ACTIONS" => [
                "admin" => true,
                "manager" => true,
                "link" => "actions",
                "default-link" => "actions",
                "hud" => "Project " . $projectID . " Options",
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
                    "COMPLETE PROJECT" => [
                        "admin" => true,
                        "link" => "complete",
                        "default-link" => "complete",
                        "hud" => "Project " . $projectID . " Options",
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
                    ],
                    "CANCEL PROJECT" => [
                        "admin" => true,
                        "link" => "cancel",
                        "default-link" => "cancel",
                        "hud" => "Project " . $projectID . " Options",
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
                    "DELETE PROJECT" => [
                        "admin" => true,
                        "link" => "delete",
                        "default-link" => "delete",
                        "hud" => "Project " . $projectID . " Options",
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
    if ($project['status1'] != 1 && $project['status1'] != 2)
        unset($menu['level-1']['+ ASSIGNMENT PRESET']);

    // Check if project is completable
    if (!$canComplete)
        unset($menu['level-1']['PROJECT ACTIONS']['level-2']['COMPLETE PROJECT']);
    // Check if project is cancelable
    if (!$canCancel)
        unset($menu['level-1']['PROJECT ACTIONS']['level-2']['CANCEL PROJECT']);
    // Check if project is deletable
    if (!$canDelete)
        unset($menu['level-1']['PROJECT ACTIONS']['level-2']['DELETE PROJECT']);
    // Remove actions button if no action possible
    if (empty($menu['level-1']['PROJECT ACTIONS']['level-2']))
        unset($menu['level-1']['PROJECT ACTIONS']);
}

// Info page options
elseif (isset($_GET['ioptions'])) {
    $hud = "Project Link Options";
    $menu = [
        "hud" => "Info link options",
        "level-1" => [
            "+ Project Link" => [
                "admin" => true,
                "link" => "add",
                "default-link" => "add",
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
            ],
            "EDIT PROJECT LINK" => [
                "admin" => true,
                "link" => "edit",
                "default-link" => "edit",
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
            ],
            "- PROJECT LINK" => [
                "admin" => true,
                "link" => "remove",
                "default-link" => "remove",
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
    if (isset($_GET['l1']) && $_GET['l1'] == "edit" && isset($_GET['i'])) {
        $infopage = Project::selectProjectInfoPage($_GET['i']);
        $menu['level-1']['EDIT PROJECT LINK']['hud'] = $hud;
        $menu['level-1']['EDIT PROJECT LINK']['level-2'] = [
            "PROJECT LINK GROUP" => [
                "admin" => true,
                "link" => "group",
                "default-link" => "group",
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
            ],
            "PROJECT LINK NAME" => [
                "admin" => true,
                "link" => "name",
                "default-link" => "name",
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
            ],
            "PROJECT LINK URL" => [
                "admin" => true,
                "link" => "link",
                "default-link" => "link",
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
            ],
            "PROJECT LINK DESCRIPTION" => [
                "admin" => true,
                "link" => "description",
                "default-link" => "description",
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
        ];
    }
}