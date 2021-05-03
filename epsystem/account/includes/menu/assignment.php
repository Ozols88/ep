<?php

if (isset($_GET['a']))
    $assignment = Assignment::selectAssignmentByID($_GET['a']);
elseif (isset($_GET['t'])) {
    $assignmentID = Task::selectTask($_GET['t'])['assignmentid'];
    $assignment = Assignment::selectAssignmentByID($assignmentID);
}

// Check member ability to open assignment
if ($assignment && isset($account) && $account->manager == 1) $allow = true;
elseif ($assignment && isset($account) && $account->manager == 0) {
    $allow = false;
    // If assignment already assigned to specific member
    if ($assignment['assigned_to'] == $account->id)
        $allow = true;
    // If assignment is available
    elseif ($assignment['status_id'] == 3) {
        foreach ($account->divisions as $division) {
            if ($division['divisionid'] == $assignment['divisionid']) {
                $allow = true;
                break;
            }
            elseif ($assignment['divisionid'] == null || $assignment['divisionid'] == 0)
                $allow = true;
        }
    }
}
else $allow = false;

if ($allow == true)
    $hudInitial = "\"" . $assignment['title'] . "\"";
else {
    header("Location: assignments.php?l1=my&l2=active");
    exit();
}

// Possible actions (for assignment page and options)
$tasks = Task::selectAssignmentTasks($assignment['id']);
$enable = true;
if ($tasks)
    foreach ($tasks as $task)
        if ($task['statusid'] == 7) $enable = false;
if ($enable && $account->manager == 1 && ($assignment['status_id'] == 4 || $assignment['status_id'] == 5 || $assignment['status_id'] == 6))
    $cancel = true;

if ($tasks && $account->manager == 1 && $assignment['status_id'] == 1)
    $assign = true;

if ($account->manager == 1 && $assignment['status_id'] == 1)
    $hide = true;
elseif ($account->manager == 1 && $assignment['status_id'] == 2)
    $show = true;

if ($account->manager == 1 && $assignment['status_id'] == 1 && $tasks)
    $publish = true;
elseif ($account->manager == 1 && $assignment['status_id'] == 3)
    $unpublish = true;

$enable = true;
if ($tasks)
    foreach ($tasks as $task)
        if ($task['statusid'] != 7) $enable = false;
if ($enable && $account->manager == 1 && $assignment['status_id'] == 6)
    $complete = true;

if ($account->manager == 1 && $assignment['status_id'] == 1 || $assignment['status_id'] == 2)
    if ($assignment['presetid'] != null)
        $remove = true;
    else
        $delete = true;

if ($assignment['status_id'] == 3 && (!$assignment['assigned_to'] || $assignment['assigned_to'] == $account->id))
    $accept = true;

$enable = true;
if ($tasks)
    foreach ($tasks as $task)
        if ($task['statusid'] == 6 || $task['statusid'] == 7) $enable = false;
if ($enable && $assignment['status_id'] == 4 && $assignment['assigned_to'] == $account->id)
    $undoAccept = true;

// Assignment page
if (isset($_GET['a']) && !isset($_GET['options'])) {
    if (!isset($_GET['comment'])) {
        $menu = [
            "hud" => $hudInitial,
            "level-1" => [
                "ASSIGNMENT OVERVIEW" => [
                    "admin" => false,
                    "link" => "assignment",
                    "default-link" => "assignment",
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
                    ],
                    "level-2"
                ]
                // ASSIGNMENT TASKS
            ]
        ];

        $tasks = Task::selectAssignmentTasks($_GET['a']);
        if ($tasks)
            $menu['level-1']["ASSIGNMENT TASKS"] = [
            "admin" => false,
            "link" => "tasks",
            "default-link" => "tasks",
            "hud" => $hudInitial . ": Tasks",
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

        // Check if undo accept button is needed
        if (isset($undoAccept))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Undo Accept'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=undo-accept",
                "hud" => ""
            ];

        // Check if add task button is needed
        if ($account->manager == 1 && ($assignment['status_id'] == '1' || $assignment['status_id'] == '2' || $assignment['status_id'] == '5' || $assignment['status_id'] == '6'))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['+ Task'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=add",
                "hud" => ""
            ];
        // Check if accept button is needed
        if ($assignment['status_id'] == '3' && Assignment::assignmentDivisionCheck($assignment['divisionid'], $account->divisions) && (!$assignment['assigned_to'] || $assignment['assigned_to'] == $account->id))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Accept Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=accept",
                "hud" => ""
            ];
        // Edit shortcut
        if ($account->manager == 1 && $assignment['status_id'] != '7') {
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Edit Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=edit",
                "hud" => ""
            ];
            if ($assignment['divisionid'] == '0')
                $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Edit Assignment']['page'] = "assignments.php?a=" . $_GET['a'] . "&options&l1=edit&l2=objective"; // Custom assignment has only one edit button - open it
        }
        // Action shortcuts
        if (isset($cancel))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Cancel Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=cancel",
                "hud" => ""
            ];
        if (isset($assign))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Assign'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=assign",
                "hud" => ""
            ];
        if (isset($hide))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Hide Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=hide",
                "hud" => ""
            ];
        if (isset($show))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Show Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=show",
                "hud" => ""
            ];
        if (isset($publish))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Make Available'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=publish",
                "hud" => ""
            ];
        if (isset($unpublish))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Undo Available'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=unpublish",
                "hud" => ""
            ];
        if (isset($complete))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Complete Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=complete",
                "hud" => ""
            ];
        if (isset($remove))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Remove Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=delete",
                "hud" => ""
            ];
        if (isset($delete))
            $menu['level-1']['ASSIGNMENT OVERVIEW']['level-2']['Delete Assignment'] = [
                "admin" => false,
                "page" => "assignments.php?a=" . $_GET['a'] . "&options&l1=actions&l2=delete",
                "hud" => ""
            ];

        // Task list
        if (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
            if ($tasks) {
                foreach ($tasks as $task) {
                    $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']] = [
                        "admin" => false,
                        "link" => $task['id'],
                        "default-link" => $task['id'],
                        "hud" => $hudInitial . ": Task #" . $task['number'],
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
                        "level-3" => []
                    ];
                    // Task buttons
                    if ($task['statusid'] != 7 && ($account->manager == 1 || $assignment['assigned_to'] == $account->id)) {
                        $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Comment On Task'] = [
                            "admin" => false,
                            "page" => "assignments.php?t=" . $task['id'] . "&options&l1=comment",
                            "hud" => ""
                        ];
                        if ($task['statusid'] == 4 && $assignment['assigned_to'] == $account->id) {
                            $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Submit Task'] = [
                                "admin" => false,
                                "page" => "assignments.php?t=" . $task['id'] . "&options&l1=submit",
                                "hud" => ""
                            ];
                            $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Task Problem'] = [
                                "admin" => false,
                                "page" => "assignments.php?t=" . $task['id'] . "&options&l1=problem",
                                "hud" => ""
                            ];
                        }
                        if ($account->manager == 1) {
                            $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Edit Task'] = [
                                "admin" => false,
                                "page" => "assignments.php?t=" . $task['id'] . "&options&l1=edit",
                                "hud" => ""
                            ];
                            if ($account->manager == 1 && $task['statusid'] == 4 || $task['statusid'] == 5 || $task['statusid'] == 6)
                                $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Complete Task'] = [
                                    "admin" => false,
                                    "page" => "assignments.php?t=" . $task['id'] . "&options&l1=actions&l2=complete",
                                    "hud" => ""
                                ];
                            if ($account->manager == 1 && $task['statusid'] == 5 || $task['statusid'] == 6 || ($task['statusid'] == 1 && $assignment['status_id'] == 5))
                                $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Activate Task'] = [
                                    "admin" => false,
                                    "page" => "assignments.php?t=" . $task['id'] . "&options&l1=actions&l2=activate",
                                    "hud" => ""
                                ];
                            if ($account->manager == 1 && $task['statusid'] != 7)
                                $menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']['Remove Task'] = [
                                    "admin" => false,
                                    "page" => "assignments.php?t=" . $task['id'] . "&options&l1=actions&l2=delete",
                                    "hud" => ""
                                ];
                        }
                    }
                    // Remove level 3 if empty
                    if (empty($menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']))
                        unset($menu['level-1']['ASSIGNMENT TASKS']['level-2']["TASK #" . $task['number']]['level-3']);
                }
                // If only one task present - open it
                if (count($tasks) == 1 && !isset($_GET['l2'])) header("Location: assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $task['id']);
            }
        }
    }
    else
        $menu = [
            "hud" => "Add Comment"
        ];
}

// Assignment options
elseif (isset($_GET['a']) && isset($_GET['options'])) {
    $hudInitial = $assignment['title'];
    $menu = [
        "hud" => $hudInitial . ": Options",
        "level-1" => [
            // + TASK
            "EDIT ASSIGNMENT" => [
                "admin" => true,
                "manager" => true,
                "link" => "edit",
                "default-link" => "edit",
                "hud" => "Edit assignment preset & objective",
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
                    "ASSIGNMENT PRESET" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "preset",
                        "default-link" => "preset",
                        "hud" => "Select a preset for the assignment",
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
                    "ASSIGNMENT OBJECTIVE" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "objective",
                        "default-link" => "objective",
                        "hud" => "Edit the objective of the assignment",
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
            "ASSIGNMENT ACTIONS" => [
                "admin" => true,
                "manager" => true,
                "link" => "actions",
                "default-link" => "actions",
                "hud" => "Assignment actions",
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
                "level-2" => []
            ]
        ]
    ];
    // + TASK
    if ($assignment['status_id'] == '1' || $assignment['status_id'] == '2' || $assignment['status_id'] == '5' || $assignment['status_id'] == '6' && $account->manager == 1)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 0), array("+ TASK" => [
            "admin" => true,
            "manager" => true,
            "link" => "add",
            "default-link" => "add",
            "hud" => "Select a task preset to add to the assignment",
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

    // Custom assignment can't edit preset, division
    if ($assignment['divisionid'] == '0') {
        unset($menu['level-1']['EDIT ASSIGNMENT']['level-2']['ASSIGNMENT PRESET']);
        $menu['level-1']['EDIT ASSIGNMENT']['default-link'] = "edit&l2=objective"; // Custom assignment has only one edit button - open it
    }

    if (isset($cancel))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 0), array("CANCEL ASSIGNMENT" => [
            "admin" => true,
            "manager" => true,
            "link" => "cancel",
            "default-link" => "cancel",
            "hud" => "Cancel assignment?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0));

    if (isset($assign))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 1), array("ASSIGN" => [
            "admin" => true,
            "manager" => true,
            "link" => "assign",
            "default-link" => "assign",
            "hud" => "Select a member to assign the assignment",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 1));

    if (isset($hide))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 2), array("HIDE ASSIGNMENT" => [
            "admin" => true,
            "manager" => true,
            "link" => "hide",
            "default-link" => "hide",
            "hud" => "Hide the assignment?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 2));
    elseif (isset($show))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 2), array("SHOW ASSIGNMENT" => [
            "admin" => true,
            "manager" => true,
            "link" => "show",
            "default-link" => "show",
            "hud" => "Show the assignment?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 2));

    if (isset($publish))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 3), array("MAKE AVAILABLE" => [
            "admin" => true,
            "manager" => true,
            "link" => "publish",
            "default-link" => "publish",
            "hud" => "Make the assignment available?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 3));
    elseif (isset($unpublish))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 3), array("UNDO AVAILABLE" => [
            "admin" => true,
            "manager" => true,
            "link" => "unpublish",
            "default-link" => "unpublish",
            "hud" => "Undo available?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 3));

    if (isset($complete))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 4), array("COMPLETE ASSIGNMENT" => [
            "admin" => true,
            "manager" => true,
            "link" => "complete",
            "default-link" => "complete",
            "hud" => "Complete assignment?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 4));

    if (isset($remove))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 5), array("REMOVE ASSIGNMENT" => [
            "admin" => true,
            "manager" => true,
            "link" => "delete",
            "default-link" => "delete",
            "hud" => "Remove the assignment?",
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
    ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 5));
    elseif (isset($delete))
        $menu['level-1']['ASSIGNMENT ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 0, 5), array("DELETE ASSIGNMENT" => [
            "admin" => true,
            "manager" => true,
            "link" => "delete",
            "default-link" => "delete",
            "hud" => "Delete the assignment?",
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
        ]), array_slice($menu['level-1']['ASSIGNMENT ACTIONS']['level-2'], 5));

    // Check if accept/undo-accept button is needed
    if ($assignment['status_id'] == 3 && (!$assignment['assigned_to'] || $assignment['assigned_to'] == $account->id)) {
        if ($account->manager == 0) {
            unset($menu['level-1']);
            $menu['level-1']['ACCEPT ASSIGNMENT'] = [
                "admin" => false,
                "link" => "accept",
                "default-link" => "accept",
                "hud" => "Accept the assignment?",
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
            ];
        }
        else
            $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("ACCEPT ASSIGNMENT" => [
                "admin" => true,
                "link" => "accept",
                "default-link" => "accept",
                "hud" => "Accept assignment?",
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
    }
    elseif (isset($undoAccept))
        $menu['level-1']['UNDO ACCEPT'] = [
            "admin" => false,
            "link" => "undo-accept",
            "default-link" => "undo-accept",
            "hud" => "Undo accept?",
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

    if (empty($menu['level-1']['ASSIGNMENT ACTIONS']['level-2']))
        unset($menu['level-1']['ASSIGNMENT ACTIONS']);
}

// Task options
elseif (isset($_GET['t']) && isset($_GET['options'])) {
    $task = Task::selectTask($_GET['t']);
    $hudInitial = "#" . $task['number'];
    $menu = [
        "hud" => $hudInitial,
        "level-1" => [
            "EDIT TASK" => [
                "admin" => true,
                "manager" => true,
                "link" => "edit",
                "default-link" => "edit",
                "hud" => "Edit task " . $hudInitial,
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
                    "TASK PRESET" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "preset",
                        "default-link" => "preset",
                        "hud" => "Edit task " . $hudInitial . " preset",
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
                    "TASK DESCRIPTION" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "description",
                        "default-link" => "description",
                        "hud" => "Edit task " . $hudInitial . " description",
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
                    "TASK TIME" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "time",
                        "default-link" => "time",
                        "hud" => "Edit task " . $hudInitial . " time",
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
                    "TASK LINKS" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "links",
                        "default-link" => "links",
                        "hud" => "Edit task " . $hudInitial . " links",
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
                    "TASK COMMENTS" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "comments",
                        "default-link" => "comments",
                        "hud" => "Edit task " . $hudInitial . " comments",
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
            "TASK ACTIONS" => [
                "admin" => true,
                "manager" => true,
                "link" => "actions",
                "default-link" => "actions",
                "hud" => "Task " . $hudInitial . " actions",
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
                "level-2" => []
            ]
        ]
    ];
    // Can't change preset if assignment is custom/no preset or task is custom
    if ($task['asg-presetid'] == null || $task['asg-presetid'] == 0 || $task['presetid'] == null)
        unset($menu['level-1']['EDIT TASK']['level-2']['TASK PRESET']);
    // Can't change time for preset tasks
    if ($task['presetid'] != null)
        unset($menu['level-1']['EDIT TASK']['level-2']['TASK TIME']);

    // Check if comment, submit, problem button is needed
    $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 0), array("COMMENT ON TASK" => [
        "admin" => false,
        "link" => "comment",
        "default-link" => "comment",
        "hud" => "Write a comment for task " . $hudInitial,
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
    ]), array_slice($menu['level-1'], 0));
    $menu['level-1']['COMMENT ON TASK']['admin'] = true;
    if ($task['statusid'] == 4 && $assignment['assigned_to'] == $account->id) {
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("SUBMIT" => [
            "admin" => false,
            "link" => "submit",
            "default-link" => "submit",
            "hud" => "Submit task " . $hudInitial . "?",
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
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 2), array("TASK PROBLEM" => [
            "admin" => false,
            "link" => "problem",
            "default-link" => "problem",
            "hud" => "Task " . $hudInitial . " problem",
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
                "FILE PROBLEM" => [
                    "admin" => false,
                    "link" => "file",
                    "default-link" => "file",
                    "hud" => "Task " . $hudInitial . " file problem",
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
                "LINK PROBLEM" => [
                    "admin" => false,
                    "link" => "link",
                    "default-link" => "link",
                    "hud" => "Task " . $hudInitial . " link problem",
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
                "COMPLETION PROBLEM" => [
                    "admin" => false,
                    "link" => "completion",
                    "default-link" => "completion",
                    "hud" => "Task " . $hudInitial . " completion problem",
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
        ]), array_slice($menu['level-1'], 2));
        $menu['level-1']['SUBMIT']['admin'] = true;
        $menu['level-1']['TASK PROBLEM']['admin'] = true;
    }

    // Check if complete button is needed
    if ($account->manager == 1 && $task['statusid'] == 4 || $task['statusid'] == 5 || $task['statusid'] == 6)
        $menu['level-1']['TASK ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['TASK ACTIONS']['level-2'], 0, 2), array("COMPLETE TASK" => [
            "admin" => true,
            "manager" => true,
            "link" => "complete",
            "default-link" => "complete",
            "hud" => "Complete task " . $hudInitial,
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
        ]), array_slice($menu['level-1']['TASK ACTIONS']['level-2'], 2));

    // Check if activate button is needed
    if ($account->manager == 1 && $task['statusid'] == 5 || $task['statusid'] == 6 || ($task['statusid'] == 1 && $assignment['status_id'] == 5))
        $menu['level-1']['TASK ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['TASK ACTIONS']['level-2'], 0, 4), array("ACTIVATE TASK" => [
            "admin" => true,
            "manager" => true,
            "link" => "activate",
            "default-link" => "activate",
            "hud" => "Activate task " . $hudInitial,
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
        ]), array_slice($menu['level-1']['TASK ACTIONS']['level-2'], 4));

    // Check if remove button is needed
    if ($account->manager == 1 && $task['statusid'] != 7)
        $menu['level-1']['TASK ACTIONS']['level-2'] = array_merge(array_slice($menu['level-1']['TASK ACTIONS']['level-2'], 0, 5), array("REMOVE TASK" => [
            "admin" => true,
            "manager" => true,
            "link" => "delete",
            "default-link" => "delete",
            "hud" => "Remove task " . $hudInitial,
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
        ]), array_slice($menu['level-1']['TASK ACTIONS']['level-2'], 5));

    if ($account->manager != 1) {
        unset($menu['level-1']['EDIT TASK']);
        unset($menu['level-1']['TASK ACTIONS']);
    }
}