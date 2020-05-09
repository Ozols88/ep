<?php

$assignment = Assignment::selectAssignmentByID($_GET['a']);

$menu = [
    "hud" => "",
    "level-1" => [
        "+ New" => [
            "admin" => false,
            "link" => "",
            "default-link" => "",
            "page" => "new-task",
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
        "ASSIGNMENT" => [
            "admin" => false,
            "link" => "assignment",
            "default-link" => "assignment",
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
        "TASKS" => [
            "admin" => false,
            "link" => "tasks",
            "default-link" => "tasks",
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
        "OPTIONS" => [
            "admin" => false,
            "link" => "options",
            "default-link" => "options",
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
    ]
];

if (isset($_GET['l1']) && $_GET['l1'] == "tasks") {
    $tasks = Task::selectAssignmentTasks($_GET['a']);
    if ($tasks) {
        foreach ($tasks as $task) {
            $menu['level-1']['TASKS']['level-2']["#" . $task['id']] = [
                "admin" => false,
                "link" => $task['id'],
                "default-link" => $task['id'],
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
            ];
        }
    }
}