<?php
require_once "database.php";

class Assignment extends Database
{
    public function __construct($table = "assignment")
    {
        parent::__construct($table);
    }

    public static $menu = [
        "level-1" => [
            "+ New Assignment" => [
                "admin" => true,
                "locked" => false,
                "link" => "new",
                "default-link" => "new",
                "hud" => "New Assignment",
                "home" => [
                    "title" => "Title",
                    "description" => "Description",
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
                    "link" => "List",
                    "note" => "Note"
                ]
            ],
            "AVAILABLE ASSIGNMENTS" => [
                "admin" => false,
                "locked" => false,
                "link" => "available",
                "default-link" => "available&m=production",
                "hud" => "Available Assignments",
                "home" => [
                    "title" => "Title",
                    "description" => "Description",
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
                    "link" => "List",
                    "note" => "Note"
                ],
                "level-2" => [
                    "PRODUCTION" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "production",
                        "default-link" => "production",
                        "hud" => "Production"
                    ],
                    "APPROVALS" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "approvals",
                        "default-link" => "approvals",
                        "hud" => "Approvals"
                    ],
                    "EP OPERATIONS" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "ep-operations",
                        "default-link" => "ep-operations",
                        "hud" => "EP Operations"
                    ],
                    "MANAGEMENT" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "management",
                        "default-link" => "management",
                        "hud" => "Management",
                        "level-3" => [
                            "SOMETHING1" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something1",
                                "default-link" => "something1",
                                "hud" => "Something"
                            ],
                            "SOMETHING2" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something2",
                                "default-link" => "something2",
                                "hud" => "Something"
                            ],
                            "SOMETHING3" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something3",
                                "default-link" => "something3",
                                "hud" => "Something"
                            ],
                            "SOMETHING4" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something4",
                                "default-link" => "something4",
                                "hud" => "Something"
                            ],
                            "SOMETHING5" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something5",
                                "default-link" => "something5",
                                "hud" => "Something"
                            ],
                        ]
                    ],
                    "ADMIN" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "admin",
                        "default-link" => "admin",
                        "hud" => "ADMIN"
                    ]
                ]
            ],
            "MY ASSIGNMENTS" => [
                "admin" => false,
                "locked" => false,
                "link" => "my",
                "default-link" => "my&m=active",
                "hud" => "My Assignments",
                "home" => [
                    "title" => "Title",
                    "description" => "Description",
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
                    "link" => "List",
                    "note" => "Note"
                ],
                "level-2" => [
                    "PENDING" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "pending",
                        "default-link" => "pending",
                        "hud" => "My Pending Assignments"
                    ],
                    "ACTIVE" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "active",
                        "default-link" => "active",
                        "hud" => "My Active Assignments"
                    ],
                    "COMPLETED" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "completed",
                        "default-link" => "completed",
                        "hud" => "My Completed Assignments"
                    ],
                    "CANCELED" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "canceled",
                        "default-link" => "canceled",
                        "hud" => "My Canceled Assignments"
                    ]
                ]
            ],
            "ADMIN" => [
                "admin" => true,
                "locked" => false,
                "link" => "admin",
                "default-link" => "admin",
                "hud" => "Admin",
                "home" => [
                    "title" => "Title",
                    "description" => "Description",
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
                    "link" => "List",
                    "note" => "Note"
                ]
            ]
        ]
    ];

    public static function getHeadUp() {
        $headupInitial = "Assignments";
        if (isset($_GET['t']) && isset(self::$menu['level-1'])) {
            foreach (self::$menu['level-1'] as $menuLvl1) {
                if ($menuLvl1['link'] == $_GET['t']) {
                    if (isset($menuLvl1['hud']))
                        $headup = $menuLvl1['hud'];
                    if (isset($_GET['m']) && isset($menuLvl1['level-2'])) {
                        foreach ($menuLvl1['level-2'] as $menuLvl2) {
                            if ($menuLvl2['link'] == $_GET['m']) {
                                if (isset($menuLvl2['hud']))
                                    $headup = $menuLvl2['hud'];
                                if (isset($_GET['b']) && isset($menuLvl2['level-3'])) {
                                    foreach ($menuLvl2['level-3'] as $menuLvl3) {
                                        if ($menuLvl3['link'] == $_GET['b']) {
                                            if (isset($menuLvl3['hud']))
                                                $headup = $menuLvl3['hud'];
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if (isset($headup)) return $headup;
        else return $headupInitial;
    }
}