<?php

if (!isset($_GET['p']) && !isset($_GET['a']) && !isset($_GET['t']) && !isset($_GET['l']) && !isset($_GET['i']) && !isset($_GET['f']) && !isset($_GET['d']) && !isset($_GET['dp']) && !isset($_GET['ig']) && !isset($_GET['lt']) && $_SERVER['REQUEST_URI'] != RootPath . "epsystem/account/new-r&d/index.php") {
    $menu = [
        "hud" => "Research & Development",
        "level-1" => [
            "PROJECT R&D" => [
                "admin" => false,
                "link" => "project",
                "default-link" => "project",
                "hud" => "Project Research & Development",
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
                        "hud" => "ep system products",
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
                    "PROJECT LINK GROUPS" => [
                        "admin" => false,
                        "link" => "infogr",
                        "default-link" => "infogr",
                        "hud" => "ep system link groups",
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
                    "PROJECT LINK PRESETS" => [
                        "admin" => false,
                        "link" => "info",
                        "default-link" => "info",
                        "hud" => "ep system link presets",
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
                "hud" => "Assignment Research & Development",
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
                        "hud" => "ep system divisions",
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
                    "TASK LINK TYPES" => [
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
            ]
        ]
    ];
}

// Project Preset
elseif (isset($_GET['p'])) {
    $preset = Project::selectPresetByID($_GET['p']);
    if (!isset($_GET['options'])) {
        $hud = "Project Preset Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "PROJECT PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
            ]
        ];
    }
    else {
        $hud = "Project Preset Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT PROJECT PRESET" => [
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
                    ],
                    "level-2" => [
                        "PROJECT PRESET PRODUCT" => [
                            "admin" => true,
                            "link" => "product",
                            "default-link" => "product",
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
                        "PROJECT PRESET NAME" => [
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
                        "PROJECT PRESET DESCRIPTION" => [
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
                        ],
                        "PROJECT PRESET ASSIGNMENTS" => [
                            "admin" => true,
                            "link" => "assignments",
                            "default-link" => "assignments&l3=remove",
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
    }

}

// Assignment Preset
elseif (isset($_GET['a'])) {
    $preset = Assignment::selectPresetByID($_GET['a']);
    if (!isset($_GET['options'])) {
        $hud = "Assignment Preset Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "ASSIGNMENT PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
    }
    else {
        $hud = "Assignment Preset Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT ASSIGNMENT PRESET" => [
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
                    ],
                    "level-2" => [
                        "ASSIGNMENT PRESET DIVISION" => [
                            "admin" => true,
                            "link" => "division",
                            "default-link" => "division",
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
                        "ASSIGNMENT PRESET NAME" => [
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
                        "ASSIGNMENT PRESET OBJECTIVE" => [
                            "admin" => true,
                            "link" => "objective",
                            "default-link" => "objective",
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
                        "ASSIGNMENT PRESET TASKS" => [
                            "admin" => true,
                            "link" => "tasks",
                            "default-link" => "tasks",
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
                ],
                "DELETE ASSIGNMENT PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// Task Preset
elseif (isset($_GET['t'])) {
    $preset = Task::selectTaskPreset($_GET['t']);
    if (!isset($_GET['options'])) {
        $hud = "Task Preset Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "TASK PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
            ]
        ];
    }
    else {
        $hud = "Task Preset Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT TASK PRESET" => [
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
                    ],
                    "level-2" => [
                        "TASK PRESET ASSIGNMENT" => [
                            "admin" => true,
                            "link" => "assignment",
                            "default-link" => "assignment",
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
                        "TASK PRESET NAME" => [
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
                        "TASK PRESET DESCRIPTION" => [
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
                        ],
                        "TASK PRESET TIME" => [
                            "admin" => true,
                            "link" => "time",
                            "default-link" => "time",
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
                        "TASK PRESET PROJECT LINK" => [
                            "admin" => true,
                            "link" => "info",
                            "default-link" => "info",
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
                        "TASK PRESET LINKS" => [
                            "admin" => true,
                            "link" => "links",
                            "default-link" => "links",
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
                ],
                "DELETE TASK PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// Info page preset
elseif (isset($_GET['i'])) {
    $preset = Database::selectInfoPagePreset($_GET['i']);
    if (!isset($_GET['options'])) {
        $hud = "Project Link Preset Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "PROJECT LINK PRESET OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
                    ],
                    "level-2" => [
                        "Edit Project Link Preset" => [
                            "admin" => false,
                            "page" => "?i=" . $_GET['i'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Project Link Preset" => [
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
    }
    else {
        $hud = "Project Link Preset Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT PROJECT LINK PRESET" => [
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
                    ],
                    "level-2" => [
                        "PROJECT LINK PRESET GROUP" => [
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
                        "PROJECT LINK PRESET NAME" => [
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
                        "PROJECT LINK PRESET DESCRIPTION" => [
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
                    ]
                ],
                "DELETE PROJECT LINK PRESET" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// Product
elseif (isset($_GET['f'])) {
    $product = Project::selectProductByID($_GET['f']);
    $hud = "Product Page";
    if (!isset($_GET['options'])) {
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "PRODUCT OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
                ],
                "PRODUCT PROJECT PRESETS" => [
                    "admin" => false,
                    "link" => "projects",
                    "default-link" => "projects",
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
    }
    else {
        $hud = "Product Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT PRODUCT" => [
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
                    ],
                    "level-2" => [
                        "PRODUCT NAME" => [
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
                        "PRODUCT DESCRIPTION" => [
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
                    ]
                ],
                "DELETE PRODUCT" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// Department
elseif (isset($_GET['dp'])) {
    $depart = Assignment::selectDepartmentByID($_GET['dp']);
    if (!isset($_GET['options'])) {
        $hud = "Department Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "DEPARTMENT OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
                ],
                "DEPARTMENT DIVISIONS" => [
                    "admin" => false,
                    "link" => "divisions",
                    "default-link" => "divisions",
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
    }
    else {
        $hud = "Department Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT DEPARTMENT" => [
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
                    ],
                    "level-2" => [
                        "DEPARTMENT NAME" => [
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
                        "DEPARTMENT DESCRIPTION" => [
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
                    ]
                ],
                "DELETE DEPARTMENT" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// Division
elseif (isset($_GET['d'])) {
    $division = Assignment::selectDivisionByID($_GET['d']);
    if (!isset($_GET['options'])) {
        $hud = "Division Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "DIVISION OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
                ],
                "DIVISION ASSIGNMENT PRESETS" => [
                    "admin" => false,
                    "link" => "assignments",
                    "default-link" => "assignments",
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
    }
    else {
        $hud = "Division Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT DIVISION" => [
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
                    ],
                    "level-2" => [
                        "DIVISION DEPARTMENT" => [
                            "admin" => true,
                            "link" => "department",
                            "default-link" => "department",
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
                        "DIVISION NAME" => [
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
                        "DIVISION DESCRIPTION" => [
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
                    ]
                ],
                "DELETE DIVISION" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
            ]
        ];
    }
}

// Info Page Group
elseif (isset($_GET['ig'])) {
    $group = Database::selectInfoPageGroup($_GET['ig']);
    if (!isset($_GET['options'])) {
        $hud = "Project Link Group Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "PROJECT LINK GROUP OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
                    ],
                    "level-2" => [
                        "Edit Project Link Group" => [
                            "admin" => false,
                            "page" => "?ig=" . $_GET['ig'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Project Link Group" => [
                            "admin" => false,
                            "page" => "?ig=" . $_GET['ig'] . "&options&l1=delete",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ]
                    ]
                ],
                "PROJECT LINK PRESETS" => [
                    "admin" => false,
                    "link" => "links",
                    "default-link" => "links",
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
    }
    else {
        $hud = "Project Link Group Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT PROJECT LINK GROUP" => [
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
                    ],
                    "level-2" => [
                        "PROJECT LINK GROUP NAME" => [
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
                        "PROJECT LINK GROUP DESCRIPTION" => [
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
                    ]
                ],
                "DELETE PROJECT LINK GROUP" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// Link Type
elseif (isset($_GET['lt'])) {
    $type = Task::selectLinkType($_GET['lt']);
    if (!isset($_GET['options'])) {
        $hud = "Task Link Type Page";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "TASK LINK TYPE OVERVIEW" => [
                    "admin" => false,
                    "link" => "overview",
                    "default-link" => "overview",
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
                    ],
                    "level-2" => [
                        "Edit Task Link Type" => [
                            "admin" => false,
                            "page" => "?lt=" . $_GET['lt'] . "&options&l1=edit",
                            "link" => "",
                            "default-link" => "",
                            "hud" => ""
                        ],
                        "Delete Task Link Type" => [
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
    }
    else {
        $hud = "Task Link Type Options";
        $menu = [
            "hud" => $hud,
            "level-1" => [
                "EDIT TASK LINK TYPE" => [
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
                    ],
                    "level-2" => [
                        "TASK LINK TYPE NAME" => [
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
                        "TASK LINK TYPE DESCRIPTION" => [
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
                    ]
                ],
                "DELETE TASK LINK TYPE" => [
                    "admin" => true,
                    "link" => "delete",
                    "default-link" => "delete",
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
    }
}

// R&D
else {
    $hud = "New R&D";
    $menu = [
        "hud" => $hud,
        "level-1" => [
            "Project" => [
                "admin" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "project",
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
            "Assignment" => [
                "admin" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "assignment",
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
            "Project Link" => [
                "admin" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "info",
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
}
