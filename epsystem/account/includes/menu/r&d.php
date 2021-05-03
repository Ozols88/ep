<?php

if (!isset($_GET['p']) && !isset($_GET['a']) && !isset($_GET['t']) && !isset($_GET['l']) && !isset($_GET['i']) && !isset($_GET['f']) && !isset($_GET['d']) && !isset($_GET['dp']) && !isset($_GET['ig']) && !isset($_GET['lt']) && $_SERVER['REQUEST_URI'] != RootPath . "epsystem/account/new-r&d/index.php") {
    $menu = [
        "hud" => "Research & Development",
        "level-1" => [
            "PROJECT R&D" => [
                "admin" => false,
                "link" => "project",
                "default-link" => "project",
                "hud" => "ep project setup",
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
                    "PROJECT PRESETS" => [
                        "admin" => false,
                        "link" => "projects",
                        "default-link" => "projects",
                        "hud" => "ep system project presets",
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
                    "PRODUCTS" => [
                        "admin" => false,
                        "link" => "products",
                        "default-link" => "products",
                        "hud" => "ep products",
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
            "ASSIGNMENT R&D" => [
                "admin" => false,
                "link" => "assignment",
                "default-link" => "assignment",
                "hud" => "ep assignment setup",
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
                    "ASSIGNMENT PRESETS" => [
                        "admin" => false,
                        "link" => "assignments",
                        "default-link" => "assignments",
                        "hud" => "ep system assignment presets",
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
                    "DEPARTMENTS" => [
                        "admin" => false,
                        "link" => "departments",
                        "default-link" => "departments",
                        "hud" => "ep system departments",
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
                    "DIVISIONS" => [
                        "admin" => false,
                        "link" => "divisions",
                        "default-link" => "divisions",
                        "hud" => "ep system department divisions",
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
            "TASK R&D" => [
                "admin" => false,
                "link" => "task",
                "default-link" => "task",
                "hud" => "ep task setup",
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
                    "TASK PRESETS" => [
                        "admin" => false,
                        "link" => "tasks",
                        "default-link" => "tasks",
                        "hud" => "ep system task presets",
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
                    "INFO PRESETS" => [
                        "admin" => false,
                        "link" => "info",
                        "default-link" => "info",
                        "hud" => "ep system info presets",
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
                    "INFO GROUPS" => [
                        "admin" => false,
                        "link" => "infogr",
                        "default-link" => "infogr",
                        "hud" => "ep system info groups",
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
                    "LINK TYPES" => [
                        "admin" => false,
                        "link" => "linktypes",
                        "default-link" => "linktypes",
                        "hud" => "ep system link types",
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
        ]
    ];
}

// Project Preset
elseif (isset($_GET['p'])) {
    $preset = Project::selectPresetByID($_GET['p']);
    $hudInitial = "\"" . $preset['title'] . "\"";
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $hudInitial,
            "level-1" => [
                "PROJECT PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $hudInitial . " project preset",
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
                        "Edit Project Preset" => [
                            "admin" => false,
                            "page" => "?p=" . $_GET['p'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Project Preset" => [
                            "admin" => false,
                            "page" => "?p=" . $_GET['p'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ],
                "PROJECT PRESET ASSIGNMENTS" => [
                    "admin" => false,
                    "link" => "assignments",
                    "default-link" => "assignments",
                    "hud" => $preset['title'] . ": Assignment Presets",
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
            ]
        ];
    else
        $menu = [
            "hud" => $preset['title'] . ": Options",
            "level-1" => [
                "EDIT PROJECT PRESET" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $preset['title'] . ": Options",
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
                        "PROJECT PRESET PRODUCT" => [
                            "admin" => true,
                            "link" => "product",
                            "default-link" => "product",
                            "hud" => $preset['title'] . ": Options",
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
                        "PROJECT PRESET NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $preset['title'] . ": Options",
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
                        "PROJECT PRESET DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $preset['title'] . ": Options",
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
                        "PROJECT PRESET ASSIGNMENTS" => [
                            "admin" => true,
                            "link" => "assignments",
                            "default-link" => "assignments&l3=remove",
                            "hud" => $preset['title'] . ": Options",
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
                                "- ASSIGNMENT PRESET" => [
                                    "admin" => true,
                                    "link" => "remove",
                                    "default-link" => "remove",
                                    "hud" => $preset['title'] . ": Options",
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
                                "+ ASSIGNMENT PRESET" => [
                                    "admin" => true,
                                    "link" => "add",
                                    "default-link" => "add",
                                    "hud" => $preset['title'] . ": Options",
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
                            ]
                        ]
                    ]
                ],
                "DELETE PROJECT PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => "Delete project preset?",
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
}

// Assignment Preset
elseif (isset($_GET['a'])) {
    $preset = Assignment::selectPresetByID($_GET['a']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $preset['title'],
            "level-1" => [
                "ASSIGNMENT PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $preset['title'] . ": Overview",
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
                        "Edit Assignment Preset" => [
                            "admin" => false,
                            "page" => "?a=" . $_GET['a'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Assignment Preset" => [
                            "admin" => false,
                            "page" => "?a=" . $_GET['a'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ],
                "ASSIGNMENT PRESET TASKS" => [
                    "admin" => false,
                    "link" => "tasks",
                    "default-link" => "tasks",
                    "hud" => $preset['title'] . ": Task Presets",
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
    else
        $menu = [
            "hud" => $preset['title'] . ": Options",
            "level-1" => [
                "EDIT ASSIGNMENT PRESET" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $preset['title'] . ": Options",
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
                        "ASSIGNMENT PRESET DIVISION" => [
                            "admin" => true,
                            "link" => "division",
                            "default-link" => "division",
                            "hud" => $preset['title'] . ": Options",
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
                        "ASSIGNMENT PRESET NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $preset['title'] . ": Options",
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
                        "ASSIGNMENT PRESET OBJECTIVE" => [
                            "admin" => true,
                            "link" => "objective",
                            "default-link" => "objective",
                            "hud" => $preset['title'] . ": Options",
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
                        "ASSIGNMENT PRESET TASKS" => [
                            "admin" => true,
                            "link" => "tasks",
                            "default-link" => "tasks",
                            "hud" => $preset['title'] . ": Options",
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
                "DELETE ASSIGNMENT PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $preset['title'] . ": Options",
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
}

// Task Preset
elseif (isset($_GET['t'])) {
    $preset = Task::selectTaskPreset($_GET['t']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']),
            "level-1" => [
                "TASK PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Overview",
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
                        "Edit Task Preset" => [
                            "admin" => false,
                            "page" => "?t=" . $_GET['t'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Task Preset" => [
                            "admin" => false,
                            "page" => "?t=" . $_GET['t'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ],
                "TASK PRESET LINKS" => [
                    "admin" => false,
                    "link" => "links",
                    "default-link" => "links",
                    "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Overview",
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
            ]
        ];
    else
        $menu = [
            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
            "level-1" => [
                "EDIT TASK PRESET" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
                        "TASK PRESET NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
                        "TASK PRESET DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
                        "TASK PRESET TIME" => [
                            "admin" => true,
                            "link" => "time",
                            "default-link" => "time",
                            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
                        "TASK INFO PRESET" => [
                            "admin" => true,
                            "link" => "info",
                            "default-link" => "info",
                            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
                        "TASK PRESET LINKS" => [
                            "admin" => true,
                            "link" => "links",
                            "default-link" => "links",
                            "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
                "DELETE TASK PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => "Task Preset #" . sprintf('%05d', $preset['id']) . ": Options",
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
}

// Info page preset
elseif (isset($_GET['i'])) {
    $preset = Database::selectInfoPagePreset($_GET['i']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $preset['title'],
            "level-1" => [
                "INFO PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $preset['title'] . ": Overview",
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
                        "Edit Info Preset" => [
                            "admin" => false,
                            "page" => "?i=" . $_GET['i'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Info Preset" => [
                            "admin" => false,
                            "page" => "?i=" . $_GET['i'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ]
            ]
        ];
    else
        $menu = [
            "hud" => $preset['title'] . ": Options",
            "level-1" => [
                "EDIT INFO PRESET" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $preset['title'] . ": Options",
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
                        "INFO PRESET GROUP" => [
                            "admin" => true,
                            "link" => "group",
                            "default-link" => "group",
                            "hud" => $preset['title'] . ": Options",
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
                        "INFO PRESET NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $preset['title'] . ": Options",
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
                        "INFO PRESET DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $preset['title'] . ": Options",
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
                "DELETE INFO PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $preset['title'] . ": Options",
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
}

// Product
elseif (isset($_GET['f'])) {
    $product = Project::selectProductByID($_GET['f']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $product['title'],
            "level-1" => [
                "PRODUCT OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $product['title'] . ": Overview",
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
                        "Edit Product" => [
                            "admin" => false,
                            "page" => "?f=" . $_GET['f'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Product" => [
                            "admin" => false,
                            "page" => "?f=" . $_GET['f'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ]
            ]
        ];
    else
        $menu = [
            "hud" => $product['title'] . ": Options",
            "level-1" => [
                "EDIT PRODUCT" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $product['title'] . ": Options",
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
                        "PRODUCT NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $product['title'] . ": Options",
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
                        "PRODUCT DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $product['title'] . ": Options",
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
                "DELETE PRODUCT" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $product['title'] . ": Options",
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
}

// Department
elseif (isset($_GET['dp'])) {
    $depart = Assignment::selectDepartmentByID($_GET['dp']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $depart['title'],
            "level-1" => [
                "DEPARTMENT OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $depart['title'] . ": Overview",
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
                        "Edit Department" => [
                            "admin" => false,
                            "page" => "?dp=" . $_GET['dp'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Department" => [
                            "admin" => false,
                            "page" => "?dp=" . $_GET['dp'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ]
            ]
        ];
    else
        $menu = [
            "hud" => $depart['title'] . ": Options",
            "level-1" => [
                "EDIT DEPARTMENT" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $depart['title'] . ": Options",
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
                        "DEPARTMENT NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $depart['title'] . ": Options",
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
                        "DEPARTMENT DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $depart['title'] . ": Options",
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
                "DELETE DEPARTMENT" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $depart['title'] . ": Options",
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
}

// Division
elseif (isset($_GET['d'])) {
    $division = Assignment::selectDivisionByID($_GET['d']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $division['title'],
            "level-1" => [
                "DIVISION OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $division['title'] . ": Overview",
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
                        "Edit Division" => [
                            "admin" => false,
                            "page" => "?d=" . $_GET['d'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Division" => [
                            "admin" => false,
                            "page" => "?d=" . $_GET['d'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ]
            ]
        ];
    else
        $menu = [
            "hud" => $division['title'] . ": Options",
            "level-1" => [
                "EDIT DIVISION" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $division['title'] . ": Options",
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
                        "DIVISION NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $division['title'] . ": Options",
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
                        "DIVISION DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $division['title'] . ": Options",
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
                        "DIVISION DEPARTMENT" => [
                            "admin" => true,
                            "link" => "department",
                            "default-link" => "department",
                            "hud" => $division['title'] . ": Options",
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
                "DELETE DIVISION" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $division['title'] . ": Options",
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
            ]
        ];
}

// Info Page Group
elseif (isset($_GET['ig'])) {
    $group = Database::selectInfoPageGroup($_GET['ig']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $group['title'],
            "level-1" => [
                "INFO GROUP OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $group['title'] . ": Overview",
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
                        "Edit Info Group" => [
                            "admin" => false,
                            "page" => "?ig=" . $_GET['ig'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Info Group" => [
                            "admin" => false,
                            "page" => "?ig=" . $_GET['ig'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ]
            ]
        ];
    else
        $menu = [
            "hud" => $group['title'] . ": Options",
            "level-1" => [
                "EDIT INFO GROUP" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $group['title'] . ": Options",
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
                        "INFO GROUP NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $group['title'] . ": Options",
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
                        "INFO GROUP DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $group['title'] . ": Options",
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
                "DELETE INFO GROUP" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $group['title'] . ": Options",
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
}

// Link Type
elseif (isset($_GET['lt'])) {
    $type = Task::selectLinkType($_GET['lt']);
    if (!isset($_GET['options']))
        $menu = [
            "hud" => $type['title'],
            "level-1" => [
                "LINK TYPE OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
                    "hud" => $type['title'] . ": Overview",
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
                        "Edit Link Type" => [
                            "admin" => false,
                            "page" => "?lt=" . $_GET['lt'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Link Type" => [
                            "admin" => false,
                            "page" => "?lt=" . $_GET['lt'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ]
            ]
        ];
    else
        $menu = [
            "hud" => $type['title'] . ": Options",
            "level-1" => [
                "EDIT LINK TYPE" => [
                    "admin" => true,
                    "link" => "edit",
                    "default-link" => "edit",
                    "hud" => $type['title'] . ": Options",
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
                        "LINK TYPE NAME" => [
                            "admin" => true,
                            "link" => "name",
                            "default-link" => "name",
                            "hud" => $type['title'] . ": Options",
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
                        "LINK TYPE DESCRIPTION" => [
                            "admin" => true,
                            "link" => "description",
                            "default-link" => "description",
                            "hud" => $type['title'] . ": Options",
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
                "DELETE LINK TYPE" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
                    "hud" => $type['title'] . ": Options",
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
}

// R&D
else
    $menu = [
        "hud" => "New R&D",
        "level-1" => [
            "Project" => [
                "admin" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "project",
                "hud" => "New R&D",
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
            "Assignment" => [
                "admin" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "assignment",
                "hud" => "New R&D",
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
            "Info Page" => [
                "admin" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "info",
                "hud" => "New R&D",
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