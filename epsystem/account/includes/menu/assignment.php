<?php

$assignment = Assignment::selectAssignmentByID($_GET['a']);
if ($assignment) {
    $hudInitial = "Assignment #" . sprintf('%05d', $assignment['id']);
}
else {
    header("Location: assignments.php");
    exit();
}

$menu = [
    "hud" => $hudInitial,
    "level-1" => [
        "+ New Task" => [
            "admin" => false,
            "link" => "",
            "default-link" => "",
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
        ],
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
        "OPTIONS" => [
            "admin" => false,
            "link" => "options",
            "default-link" => "options",
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
        ],
    ]
];

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