<?php

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
        ],
        "level-2" => [
            "PRESETS" => [
                "admin" => false,
                "link" => "presets",
                "default-link" => "presets",
                "hud" => "R&D Presets",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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
                    "+ New Preset" => [
                        "admin" => false,
                        "link" => "new-preset",
                        "default-link" => "new-preset",
                        "page" => "new-preset",
                        "hud" => "New Preset",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
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
                    "PROJECT" => [
                        "admin" => false,
                        "link" => "project",
                        "default-link" => "project",
                        "hud" => "Project",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
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
                        "hud" => "Assignment",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
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
                        "hud" => "Tasks",
                        "home" => [
                            "title" => "",
                            "description" => "",
                            "total" => [
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
            ],
            "TUTORIALS" => [
                "admin" => false,
                "link" => "tutorials",
                "default-link" => "tutorials",
                "hud" => "R&D Tutorials",
                "home" => [
                    "title" => "",
                    "description" => "",
                    "total" => [
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