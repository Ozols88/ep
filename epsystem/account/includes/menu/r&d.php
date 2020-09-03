<?php

if (empty($_GET) && $_SERVER['PHP_SELF'] != '/ep/epsystem/account/new-r&d/index.php') {
    $menu = [
        "hud" => "Research & Development",
        "level-1" => []
    ];
    $floors = Project::selectFloors();
    foreach ($floors as $floor) {
        $menu['level-1'][strtoupper($floor['title'])] = [
            "admin" => false,
            "link" => $floor['id'],
            "default-link" => $floor['id'],
            "page" => "?f=" . $floor['id'],
            "hud" => "Research & Development",
            "home" => [
                "title" => "",
                "description" => "",
                "total" => [
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
}

elseif (isset($_GET['f']) && $_SERVER['PHP_SELF'] != '/ep/epsystem/account/new-r&d/index.php')
    $menu = [
        "hud" => "R&D " . Project::selectFloorByID($_GET['f'])['title'],
        "level-1" => [
            "+ New" => [
                "admin" => false,
                "manager" => true,
                "link" => "new",
                "default-link" => "new",
                "page" => "new-r&d/?f=" . $_GET['f'],
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
            "PRESETS" => [
                "admin" => false,
                "manager" => true,
                "link" => "presets",
                "default-link" => "presets",
                "hud" => Project::selectFloorByID($_GET['f'])['title'] . " Presets",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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
                    "EDITABLE" => [
                        "admin" => false,
                        "link" => "edit",
                        "default-link" => "edit",
                        "hud" => Project::selectFloorByID($_GET['f'])['title'] . " Editable Presets",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
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
                            "PROJECT" => [
                                "admin" => false,
                                "link" => "project",
                                "default-link" => "project",
                                "hud" => Project::selectFloorByID($_GET['f'])['title'] . " Project Presets",
                                "home" => [
                                    "title" => "",
                                    "description" => "",
                                    "total" => [
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
                            "ASSIGNMENT" => [
                                "admin" => false,
                                "link" => "assignment",
                                "default-link" => "assignment",
                                "hud" => Project::selectFloorByID($_GET['f'])['title'] . " Assignment Presets",
                                "home" => [
                                    "title" => "",
                                    "description" => "",
                                    "total" => [
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
                            "INFO PAGE" => [
                                "admin" => false,
                                "link" => "info-page",
                                "default-link" => "info-page",
                                "hud" => Project::selectFloorByID($_GET['f'])['title'] . " Info Page Presets",
                                "home" => [
                                    "title" => "",
                                    "description" => "",
                                    "total" => [
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
                    "VIEW ONLY" => [
                        "admin" => false,
                        "link" => "view",
                        "default-link" => "view",
                        "hud" => Project::selectFloorByID($_GET['f'])['title'] . " View Only Presets",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
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
                ]
            ],
            "TUTORIALS" => [
                "admin" => false,
                "link" => "tutorials",
                "default-link" => "tutorials",
                "hud" => Project::selectFloorByID($_GET['f'])['title'] . " Tutorials",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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

// Project Preset
elseif (isset($_GET['p']))
    $menu = [
        "hud" => "Project Preset #" . sprintf('%03d', Project::selectPresetByID($_GET['p'])['id']),
        "level-1" => [
            "ASSIGNMENTS" => [
                "admin" => false,
                "link" => "assignments",
                "default-link" => "assignments",
                "hud" => "Project Preset #" . sprintf('%03d', Project::selectPresetByID($_GET['p'])['id']) . ": Assignments",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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
                "hud" => "Project Preset #" . sprintf('%03d', Project::selectPresetByID($_GET['p'])['id']) . ": Options",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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

// Assignment Preset
elseif (isset($_GET['a']))
    $menu = [
        "hud" => "Assignment Preset #" . sprintf('%03d', Assignment::selectPresetByID($_GET['a'])['id']),
        "level-1" => [
            "TASKS" => [
                "admin" => false,
                "link" => "tasks",
                "default-link" => "tasks",
                "hud" => "Assignment Preset #" . sprintf('%03d', Assignment::selectPresetByID($_GET['a'])['id']) . ": Tasks",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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
                "hud" => "Assignment Preset #" . sprintf('%03d', Assignment::selectPresetByID($_GET['a'])['id']) . ": Options",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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

// Task Preset
elseif (isset($_GET['t']))
    $menu = [
        "hud" => "Task Preset #" . sprintf('%05d', Task::selectTaskPreset($_GET['t'])['id']),
        "level-1" => [
            "OPTIONS" => [
                "admin" => false,
                "link" => "options",
                "default-link" => "options",
                "hud" => "Task Preset #" . sprintf('%05d', Task::selectTaskPreset($_GET['t'])['id']) . ": Options",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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

// R&D
else
    $menu = [
        "hud" => "New R&D",
        "level-1" => [
            "Project" => [
                "admin" => false,
                "link" => "new",
                "default-link" => "new",
                "page" => "project?f=" . $_GET['f'],
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
                "admin" => false,
                "link" => "new",
                "default-link" => "new",
                "page" => "assignment?f=" . $_GET['f'],
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

// Open only available option for member
if ($account->manager == 0)
    if (isset($_GET['f']) && !isset($_GET['l1']))
        header('Location: ?f=' . $_GET['f'] . '&l1=tutorials');