<?php

if (isset($_GET['a']))
    $assignment = Assignment::selectAssignmentByID($_GET['a']);
elseif (isset($_GET['t'])) {
    $assignmentID = Task::selectTask($_GET['t'])['assignmentid'];
    $assignment = Assignment::selectAssignmentByID($assignmentID);
}
if ($assignment && isset($account) && ($account->manager == 1 || $account->id == $assignment['assigned_to'] || $assignment['status_id'] == 3))
    $hudInitial = "Assignment #" . sprintf('%05d', $assignment['id']);
else {
    header("Location: assignments.php");
    exit();
}

if (!isset($_GET['options'])) {
    $menu = [
        "hud" => $hudInitial,
        "level-1" => [
            // Edit button goes here
            // Options button goes here
            "ASSIGNMENT" => [
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
                ]
            ],
            "TASKS" => [
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
            ],
            "+ Add Task" => [
                "admin" => false,
                "manager" => true,
                "link" => "new-task",
                "default-link" => "new-task",
                "page" => "new-task.php?a=" . $assignment['id'],
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
            ]
        ]
    ];
    if ($assignment['status_id'] != 7) {
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 0), array("Edit" => [
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
        ]), array_slice($menu['level-1'], 0));
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("Options" => [
            "admin" => false,
            "manager" => true,
            "link" => "options",
            "default-link" => "options",
            "page" => "?a=" . $_GET['a'] . "&options",
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
        ]), array_slice($menu['level-1'], 1));
    }

    // Task list
    if (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
        $tasks = Task::selectAssignmentTasks($_GET['a']);
        if ($tasks) {
            foreach ($tasks as $task) {
                $menu['level-1']['TASKS']['level-2']["#" . $task['number']] = [
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
                    ]
                ];
            }
            // If only one task present - open it
            if (count($tasks) == 1 && !isset($_GET['l2'])) header("Location: assignments.php?a=" . $assignment['id'] . "&l1=tasks&l2=" . $task['id']);
        }
    }
}

// Assignment options
elseif (isset($_GET['a'])) {
    $hudInitial .= " Options";
    $menu = [
        "hud" => $hudInitial,
        "level-1" => []
    ];

    // Check if cancel(admin) button is needed (if any task is completed can't force cancel assignment)
    $tasks = Task::selectAssignmentTasks($assignment['id']);
    $enable = true;
    if ($tasks)
        foreach ($tasks as $task)
            if ($task['statusid'] == 7) $enable = false;
    if ($enable && ($assignment['status_id'] == 4 || $assignment['status_id'] == 5 || $assignment['status_id'] == 6))
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 0), array("FORCE CANCEL" => [
            "admin" => true,
            "manager" => true,
            "link" => "force-cancel",
            "default-link" => "force-cancel",
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
            ],
        ]), array_slice($menu['level-1'], 0));

    // Check if assign button is needed
    if ($assignment['status_id'] == 1 || $assignment['status_id'] == 3)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("ASSIGN" => [
            "admin" => true,
            "manager" => true,
            "link" => "assign",
            "default-link" => "assign",
            "hud" => $hudInitial . ": Assign",
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

    // Check if lock/unlock button is needed
    if ($assignment['status_id'] == 1)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 2), array("LOCK" => [
            "admin" => true,
            "manager" => true,
            "link" => "lock",
            "default-link" => "lock",
            "hud" => $hudInitial . ": Lock",
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
        ]), array_slice($menu['level-1'], 2));
    elseif ($assignment['status_id'] == 2)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 2), array("UNLOCK" => [
            "admin" => true,
            "manager" => true,
            "link" => "unlock",
            "default-link" => "unlock",
            "hud" => $hudInitial . ": Unlock",
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
        ]), array_slice($menu['level-1'], 2));

    // Check if publish/unpublish button is needed
    if ($assignment['status_id'] == 1)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 3), array("MAKE AVAILABLE" => [
            "admin" => true,
            "manager" => true,
            "link" => "publish",
            "default-link" => "publish",
            "hud" => $hudInitial . ": Make Available",
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
        ]), array_slice($menu['level-1'], 3));
    elseif ($assignment['status_id'] == 3)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 3), array("UNDO AVAILABLE" => [
            "admin" => true,
            "manager" => true,
            "link" => "unpublish",
            "default-link" => "unpublish",
            "hud" => $hudInitial . ": Undo Available",
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
        ]), array_slice($menu['level-1'], 3));

    // Check if complete button is needed
    if ($assignment['status_id'] == 6)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 4), array("COMPLETE" => [
            "admin" => true,
            "manager" => true,
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
        ]), array_slice($menu['level-1'], 4));

    // Check if remove button is needed
    if ($assignment['status_id'] == 1 || $assignment['status_id'] == 2)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 5), array("REMOVE" => [
            "admin" => true,
            "manager" => true,
            "link" => "delete",
            "default-link" => "delete",
            "hud" => $hudInitial . ": Remove",
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
        ]), array_slice($menu['level-1'], 5));

    // Check if accept/cancel button is needed
    if ($assignment['status_id'] == 3)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 6), array("ACCEPT" => [
            "admin" => false,
            "link" => "accept",
            "default-link" => "accept",
            "hud" => $hudInitial . ": Accept",
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
        ]), array_slice($menu['level-1'], 6));
    elseif ($assignment['status_id'] == 4 && $assignment['assigned_to'] == $account->id)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 6), array("CANCEL" => [
            "admin" => false,
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
            ],
        ]), array_slice($menu['level-1'], 6));
}

// Task options
elseif (isset($_GET['t'])) {
    $task = Task::selectTask($_GET['t']);
    $hudInitial = "Task #" . $task['number'] . " Options";
    $menu = [
        "hud" => $hudInitial,
        "level-1" => []
    ];

    // Check if submit, problem button is needed
    if ($task['statusid'] == 4) {
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 0), array("SUBMIT" => [
            "admin" => false,
            "link" => "submit",
            "default-link" => "submit",
            "hud" => $hudInitial . ": Submit",
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
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("PROBLEM" => [
            "admin" => false,
            "link" => "problem",
            "default-link" => "problem",
            "hud" => $hudInitial . ": Problem",
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
                    "hud" => $hudInitial . ": File Problem",
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
                    "hud" => $hudInitial . ": Link Problem",
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
                    "hud" => $hudInitial . ": Completion Problem",
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
        ]), array_slice($menu['level-1'], 1));
    }

    // Check if complete button is needed
    if ($task['statusid'] == 4 || $task['statusid'] == 5 || $task['statusid'] == 6)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 2), array("COMPLETE" => [
            "admin" => true,
            "manager" => true,
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
        ]), array_slice($menu['level-1'], 2));

    // Check if activate button is needed
    if ($task['statusid'] == 5 || $task['statusid'] == 6)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 4), array("ACTIVATE" => [
            "admin" => true,
            "manager" => true,
            "link" => "activate",
            "default-link" => "activate",
            "hud" => $hudInitial . ": Activate",
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
        ]), array_slice($menu['level-1'], 4));

    // Check if remove button is needed
    if ($task['statusid'] != 7)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 5), array("REMOVE" => [
            "admin" => true,
            "manager" => true,
            "link" => "delete",
            "default-link" => "delete",
            "hud" => $hudInitial . ": Remove",
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
        ]), array_slice($menu['level-1'], 5));
}