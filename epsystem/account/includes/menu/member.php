<?php

if (isset($_GET['m']))
    $member = Account::selectAccountByID($_GET['m']);

if (!isset($_GET['options'])) {
    $hud = "Member Page";
    $menu = [
        "hud" => $hud,
        "level-1" => [
            "MEMBER OVERVIEW" => [
                "admin" => true,
                "manager" => true,
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
                    "Edit Member" => [
                        "admin" => true,
                        "manager" => true,
                        "page" => "?m=" . $_GET['m'] . "&options&l1=edit",
                        "link" => "",
                        "default-link" => "",
                    ],
                    // Pause/Activate
                    "Delete Member" => [
                        "admin" => true,
                        "manager" => true,
                        "page" => "?m=" . $_GET['m'] . "&options&l1=delete",
                        "link" => "",
                        "default-link" => "",
                    ]
                ]
            ],
            "MEMBER DIVISIONS" => [
                "admin" => true,
                "manager" => true,
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
            ],
            "PAYMENTS TO MEMBER" => [
                "admin" => true,
                "manager" => true,
                "link" => "payments",
                "default-link" => "payments",
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
            "MEMBER ASSIGNMENTS" => [
                "admin" => true,
                "manager" => true,
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

    // Show Pause/Activate member button
    if ($member['status'] == 0)
        $menu['level-1']['MEMBER OVERVIEW']['level-2'] = array_merge(array_slice($menu['level-1']['MEMBER OVERVIEW']['level-2'], 0, 1), array("Activate Member" => [
            "admin" => true,
            "manager" => true,
            "page" => "?m=" . $_GET['m'] . "&options&l1=activate",
            "link" => "",
            "default-link" => "",
        ]), array_slice($menu['level-1']['MEMBER OVERVIEW']['level-2'], 1));
    elseif ($member['status'] == 1)
        $menu['level-1']['MEMBER OVERVIEW']['level-2'] = array_merge(array_slice($menu['level-1']['MEMBER OVERVIEW']['level-2'], 0, 1), array("Pause Member" => [
            "admin" => true,
            "manager" => true,
            "page" => "?m=" . $_GET['m'] . "&options&l1=pause",
            "link" => "",
            "default-link" => "",
        ]), array_slice($menu['level-1']['MEMBER OVERVIEW']['level-2'], 1));
}

else {
    $hud = "Member Options";
    $menu = [
        "hud" => $hud,
        "level-1" => [
            "EDIT MEMBER" => [
                "admin" => true,
                "manager" => true,
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
                    "MEMBER NAME" => [
                        "admin" => true,
                        "manager" => true,
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
                    "MEMBER DESCRIPTION" => [
                        "admin" => true,
                        "manager" => true,
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
                    "MEMBER PASSWORD" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "password",
                        "default-link" => "password",
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
                    "MEMBER DIVISIONS" => [
                        "admin" => true,
                        "manager" => true,
                        "link" => "divisions",
                        "default-link" => "divisions&l3=delete",
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
                            "- DIVISION" => [
                                "admin" => true,
                                "manager" => true,
                                "link" => "delete",
                                "default-link" => "delete",
                                "hud" => $hud,
                            ],
                            "+ DIVISION" => [
                                "admin" => true,
                                "manager" => true,
                                "link" => "add",
                                "default-link" => "add",
                                "hud" => $hud,
                            ],
                        ]
                    ]
                ]
            ],
            "DELETE MEMBER" => [
                "admin" => true,
                "manager" => true,
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

    // Show Pause/Activate member button
    if ($member['status'] == 0)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("ACTIVATE MEMBER" => [
            "admin" => true,
            "manager" => true,
            "link" => "activate",
            "default-link" => "activate",
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
        ]), array_slice($menu['level-1'], 1));
    elseif ($member['status'] == 1)
        $menu['level-1'] = array_merge(array_slice($menu['level-1'], 0, 1), array("PAUSE MEMBER" => [
            "admin" => true,
            "manager" => true,
            "link" => "pause",
            "default-link" => "pause",
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
        ]), array_slice($menu['level-1'], 1));
}