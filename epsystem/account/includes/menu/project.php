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
        "MY TASKS" => [
            "admin" => false,
            "link" => "my_tasks",
            "default-link" => "my_tasks",
            "hud" => $hudInitial . ": My Tasks",
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
                "SUMMARY" => [
                    "admin" => false,
                    "link" => "summary",
                    "default-link" => "summary",
                    "hud" => $hudInitial . ": Summary Info"
                ],
                "PRODUCTION" => [
                    "admin" => false,
                    "link" => "production",
                    "default-link" => "production",
                    "hud" => $hudInitial . ": Production Info"
                ],
                "PRODUCT" => [
                    "admin" => false,
                    "link" => "product",
                    "default-link" => "product",
                    "hud" => $hudInitial . ": Product Info"
                ],
                "CLIENT" => [
                    "admin" => false,
                    "link" => "client",
                    "default-link" => "client",
                    "hud" => $hudInitial . ": Client Info"
                ],
                "OPTIONS" => [
                    "admin" => false,
                    "link" => "options",
                    "default-link" => "options",
                    "hud" => $hudInitial . ": Options"
                ],
            ]
        ],
        "PRODUCTION" => [
            "admin" => false,
            "link" => "1",
            "default-link" => "1",
            "hud" => $hudInitial . ": Production",
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
            /*"level-2" => [
                "OPERATIONS" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "operations",
                    "default-link" => "operations&l3=colors&l4=assignment",
                    "hud" => $hudInitial . ": Operations",
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
                        "COLORS" => [
                            "admin" => false,
                            "locked" => false,
                            "link" => "colors",
                            "default-link" => "colors&l4=assignment",
                            "hud" => $hudInitial . ": Colors Assignment",
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
                            "level-4" => [
                                "SUMMARY" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "assignment",
                                    "default-link" => "assignment"
                                ],
                                "TASK #1" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-1",
                                    "default-link" => "task-1"
                                ],
                                "TASK #2" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-2",
                                    "default-link" => "task-2"
                                ],
                                "TASK #3" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-3",
                                    "default-link" => "task-3"
                                ],
                                "TASK #4" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-4",
                                    "default-link" => "task-4"
                                ],
                                "TASK #5" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-5",
                                    "default-link" => "task-5"
                                ],
                            ]
                        ]
                    ]
                ],
                "RESEARCH" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "research",
                    "default-link" => "research",
                    "hud" => $hudInitial . ": Research",
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
                "VISUALIZATION" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "visualization",
                    "default-link" => "visualization",
                    "hud" => $hudInitial . ": Visualization",
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
                "CREATION" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "creation",
                    "default-link" => "creation",
                    "hud" => $hudInitial . ": Creation",
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
                "DESIGN" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "design",
                    "default-link" => "design",
                    "hud" => $hudInitial . ": Design",
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
                "ANIMATION" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "animation",
                    "default-link" => "animation",
                    "hud" => $hudInitial . ": Animation",
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
                "AUDIO" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "audio",
                    "default-link" => "audio",
                    "hud" => $hudInitial . ": Audio",
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
                "CUSTOM" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "custom",
                    "default-link" => "custom",
                    "hud" => $hudInitial . ": Custom",
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
                "ENHANCEMENT" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "enhancement",
                    "default-link" => "enhancement",
                    "hud" => $hudInitial . ": Enhancement",
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
            ]*/
        ],
        "CUSTOM" => [
            "admin" => false,
            "link" => "0",
            "default-link" => "0",
            "hud" => $hudInitial . ": Custom",
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
            /*"level-2" => [
                "OPERATIONS" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "operations",
                    "default-link" => "operations&l3=colors&l4=assignment",
                    "hud" => $hudInitial . ": Operations",
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
                        "COLORS" => [
                            "admin" => false,
                            "locked" => false,
                            "link" => "colors",
                            "default-link" => "colors&l4=assignment",
                            "hud" => $hudInitial . ": Colors Assignment",
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
                            "level-4" => [
                                "SUMMARY" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "assignment",
                                    "default-link" => "assignment"
                                ],
                                "TASK #1" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-1",
                                    "default-link" => "task-1"
                                ],
                                "TASK #2" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-2",
                                    "default-link" => "task-2"
                                ],
                                "TASK #3" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-3",
                                    "default-link" => "task-3"
                                ],
                                "TASK #4" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-4",
                                    "default-link" => "task-4"
                                ],
                                "TASK #5" => [
                                    "admin" => false,
                                    "locked" => false,
                                    "link" => "task-5",
                                    "default-link" => "task-5"
                                ],
                            ]
                        ]
                    ]
                ],
                "RESEARCH" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "research",
                    "default-link" => "research",
                    "hud" => $hudInitial . ": Research",
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
                "VISUALIZATION" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "visualization",
                    "default-link" => "visualization",
                    "hud" => $hudInitial . ": Visualization",
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
                "CREATION" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "creation",
                    "default-link" => "creation",
                    "hud" => $hudInitial . ": Creation",
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
                "DESIGN" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "design",
                    "default-link" => "design",
                    "hud" => $hudInitial . ": Design",
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
                "ANIMATION" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "animation",
                    "default-link" => "animation",
                    "hud" => $hudInitial . ": Animation",
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
                "AUDIO" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "audio",
                    "default-link" => "audio",
                    "hud" => $hudInitial . ": Audio",
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
                "CUSTOM" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "custom",
                    "default-link" => "custom",
                    "hud" => $hudInitial . ": Custom",
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
                "ENHANCEMENT" => [
                    "admin" => false,
                    "locked" => false,
                    "link" => "enhancement",
                    "default-link" => "enhancement",
                    "hud" => $hudInitial . ": Enhancement",
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
            ]*/
        ],
        "APPROVAL" => [
            "admin" => false,
            "link" => "3",
            "default-link" => "3",
            "hud" => $hudInitial . ": Approval",
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
        "MANAGEMENT" => [
            "admin" => false,
            "link" => "2",
            "default-link" => "2",
            "hud" => $hudInitial . ": Management",
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
    0 => "CUSTOM",
    1 => "PRODUCTION",
    3 => "APPROVAL",
    2 => "MANAGEMENT"
];
if (isset($_GET['l1'])) {
    foreach ($types as $typeNum => $typeName) {
        $assignments = Project::selectProjectAssignmentsTasks($_GET['p'], $typeNum);
        if ($assignments) {
            $currentDepart = null;
            $currentAssignment = null;
            foreach ($assignments as $assignment) {
                if ($assignment['depart_id'] != $currentDepart) {
                    $currentDepart = $assignment['depart_id'];
                    $menu['level-1'][$typeName]['level-2'][strtoupper($assignment['depart_title'])] = [
                        "admin" => false,
                        "link" => $assignment['depart_id'],
                        "default-link" => $assignment['depart_id'],
                        "hud" => $hudInitial . ": " . $assignment['depart_title'],
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
                if ($assignment['assignment_id'] != $currentAssignment) {
                    $currentAssignment = $assignment['assignment_id'];
                    $menu['level-1'][$typeName]['level-2'][strtoupper($assignment['depart_title'])]['level-3'][$assignment['assignment_title']] = [
                        "admin" => false,
                        "link" => $assignment['assignment_id'],
                        "default-link" => $assignment['assignment_id'] . "&l4=summary",
                        "hud" => $hudInitial . ": " . $assignment['assignment_title'] . " Assignment",
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
                    $menu['level-1'][$typeName]['level-2'][strtoupper($assignment['depart_title'])]['level-3'][$assignment['assignment_title']]['level-4']['SUMMARY'] = [
                        "admin" => false,
                        "link" => "summary",
                        "default-link" => "summary"
                    ];
                }
                if (!is_null($assignment['task_id'])) {
                    $menu['level-1'][$typeName]['level-2'][strtoupper($assignment['depart_title'])]['level-3'][$assignment['assignment_title']]['level-4']['TASK #' . $assignment['task_number']] = [
                        "admin" => false,
                        "link" => $assignment['task_id'],
                        "default-link" => $assignment['task_id']
                    ];
                }
            }
        } else {
            $menu['level-1'][$typeName]['level-2']['New Assignment'] = [
                "admin" => true,
                "page" => "new-assignment?p=" . $_GET['p'] . "&t=" . $_GET['l1']
            ];
        }
    }
}