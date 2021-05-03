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
    $hudInitial = $project['title'];
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
        "hud" => "\"" . $hudInitial . "\" project page",
        "level-1" => [
            "PROJECT OVERVIEW" => [
                "admin" => false,
                "link" => "project",
                "default-link" => "project&l2=overview",
                "hud" => "\"" . $hudInitial . "\" project info and stats",
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
                "hud" => "\"" . $hudInitial . "\" project assignments",
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
                    "+ Assignment" => [
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
                        "hud" => "Pending \"" . $hudInitial . "\" project assignments",
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
                        "hud" => "Active \"" . $hudInitial . "\" project assignments",
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
                        "hud" => "Completed \"" . $hudInitial . "\" project assignments",
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
            "PROJECT INFO" => [
                "admin" => false,
                "link" => "info",
                "default-link" => "info",
                "hud" => "\"" . $hudInitial . "\" project info groups",
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

    if ($project['statusid'] != '4' && $project['statusid'] != '6')
        unset($menu['level-1']['PROJECT ASSIGNMENTS']['level-2']['+ Assignment']);

    // Info pages
    $infoPages = Project::selectProjectInfoPages($project['id']);
    if ($infoPages) {
        $prevGroup = null;
        if (count($infoPages) > 5) {
            if (isset($_GET['l2']) && $_GET['l2'] == "") // Fix for group "none"
                $menu['level-1']['PROJECT INFO']['hud'] = "\"" . $hudInitial . "\" project info links";
            foreach ($infoPages as $page) {
                // Lvl2 (info page group)
                if ($prevGroup != $page['group']) {
                    $menu['level-1']['PROJECT INFO']['level-2'][$page['group']] = [
                        "admin" => false,
                        "link" => $page['groupid'],
                        "default-link" => $page['groupid'],
                        "hud" => "\"" . $hudInitial . "\" project info links",
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
                $menu['level-1']['PROJECT INFO']['level-2'][$page['group']]['level-3'][$page['title']] = [
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
            $menu['level-1']['PROJECT INFO']['hud'] = "\"" . $hudInitial . "\" project info links"; // Different hud when no info groups in menu
            foreach ($infoPages as $page) {
                if (isset($page['link'])) $hasLink = "Link to the darkness!";
                else $hasLink = "No link to darkness!";

                // Lvl2 (info page)
                $menu['level-1']['PROJECT INFO']['level-2'][$page['title']] = [
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
    $menu['level-1']['PROJECT INFO']['level-2']['Edit Info Links'] = [
        "admin" => false,
        "manager" => true,
        "page" => "?p=" . $_GET['p'] . "&ioptions&l1=edit",
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
    ];
    // Open only available option for member
    if (isset($account->manager) && $account->manager == 0)
        if (isset($_GET['l1']) && $_GET['l1'] == "project" && !isset($_GET['l2']))
            header('Location: ?p=' . $_GET['p'] . '&l1=project&l2=overview');
}

// Project options
elseif (isset($_GET['options'])) {
    $menu = [
        "hud" => "\"" . $hudInitial . "\" options",
        "level-1" => [
            "+ ASSIGNMENT" => [
                "admin" => true,
                "link" => "add",
                "default-link" => "add",
                "hud" => "Select an assignment preset to add to the project",
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
                "hud" => "Edit project preset, name or description",
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
                        "hud" => "Select a project preset for the project",
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
                        "hud" => "Edit the name of the project",
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
                        "hud" => "Edit the description of the project",
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
                "hud" => "Complete, cancel or delete project",
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
                        "hud" => "Complete project?",
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
                        "hud" => "Select a reason for project cancellation",
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
                        "hud" => "Delete project?",
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
    if ($project['statusid'] != '4' && $project['statusid'] != '6')
        unset($menu['level-1']['+ ASSIGNMENT']);

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
    $menu = [
        "hud" => "Info link options",
        "level-1" => [
            "+ INFO LINK" => [
                "admin" => true,
                "link" => "add",
                "default-link" => "add",
                "hud" => "Select an info preset to add to the project",
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
            "EDIT INFO LINK" => [
                "admin" => true,
                "link" => "edit",
                "default-link" => "edit",
                "hud" => "Select an info link to edit",
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
            "- INFO LINK" => [
                "admin" => true,
                "link" => "remove",
                "default-link" => "remove",
                "hud" => /** @lang Text */ "Select an info link to remove from the project",
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
        $menu['level-1']['EDIT INFO LINK']['hud'] = "Edit the name, link and description of the info link";
        $menu['level-1']['EDIT INFO LINK']['level-2'] = [
            "INFO LINK NAME" => [
                "admin" => true,
                "link" => "name",
                "default-link" => "name",
                "hud" => "Edit the name of the info link",
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
            "INFO LINK URL" => [
                "admin" => true,
                "link" => "link",
                "default-link" => "link",
                "hud" => "Edit the URL of the info link",
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
            "INFO LINK DESCRIPTION" => [
                "admin" => true,
                "link" => "description",
                "default-link" => "description",
                "hud" => "Edit the description of the info link",
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