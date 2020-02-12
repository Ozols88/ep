<?php
require_once "database.php";

class Project extends Database
{
    public function __construct($table = "project")
    {
        parent::__construct($table);
    }

    public static $id;

    public $columns = [
        "pending" => [
            "id" => ["№"],
            "project" => ["Project"],
            "type" => ["Type"],
            "client" => ["Client"],
            "pending-for" => ["Pending For"],
            "pending-reason" => ["Pending Reason"],
            "deadline" => ["Deadline In"],
            "price" => ["Price"],
            "open" => ["Open"]
        ],
        "active" => [
            "id" => ["№"],
            "project" => ["Project"],
            "type" => ["Type"],
            "client" => ["Client"],
            "progress" => ["Progress"],
            "deadline" => ["Deadline In", "onclick=\"sortTable('.head.deadline', '.cell.deadline a b')\""],
            "price" => ["Price", "onclick=\"sortTable('.head.price', '.cell.price a strong')\""],
            "open" => ["Open"]
        ],
    ];

    public static function getHeadUp() {
        if (!isset($_GET['p'])) {
            $headup = "Projects";
            if (isset($_GET['t'])) {
                foreach (self::$menu['level-1'] as $menu) {
                    if ($menu['link'] == $_GET['t'])
                        if (isset($menu['hud'])) $headup = $menu['hud'];
                }
                return $headup;
            }
            else return $headup;
        }
        else {
            $projectid = self::selectAdminProjectStatic()[0]['project_id'];
            $headupInitial = "Project #" . sprintf('%04d', $projectid);
            if (isset($_GET['t']) && isset(self::$projectMenu['level-1'])) {
                foreach (self::$projectMenu['level-1'] as $menuLvl1) {
                    if ($menuLvl1['link'] == $_GET['t']) {
                        if (isset($menuLvl1['hud']))
                            $headup = $headupInitial . $menuLvl1['hud'];
                        if (isset($_GET['m']) && isset($menuLvl1['level-2'])) {
                            foreach ($menuLvl1['level-2'] as $menuLvl2) {
                                if ($menuLvl2['link'] == $_GET['m']) {
                                    if (isset($menuLvl2['hud']))
                                        $headup = $headupInitial . $menuLvl2['hud'];
                                    if (isset($_GET['b']) && isset($menuLvl2['level-3'])) {
                                        foreach ($menuLvl2['level-3'] as $menuLvl3) {
                                            if ($menuLvl3['link'] == $_GET['b']) {
                                                if (isset($menuLvl3['hud']))
                                                    $headup = $headupInitial . $menuLvl3['hud'];
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

    public static $menu = [
        "level-1" => [
            "+ New Project" => [
                "admin" => true,
                "locked" => false,
                "link" => "new",
                "hud" => "New Project"
            ],
            "PENDING" => [
                "admin" => false,
                "locked" => false,
                "link" => "pending",
                "hud" => "Pending Projects",
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
            "ACTIVE" => [
                "admin" => false,
                "locked" => false,
                "link" => "active",
                "hud" => "Active Projects",
                "home" => [
                    "title" => "All Active Projects",
                    "description" => "Here you can access and view projects that are currently in production",
                    "total" => [
                        "name" => "Total Projects",
                        "count" => 100
                    ],
                    "last-hours" => [
                        "title" => "In the last 24h",
                        "details" => [
                            [
                                "name" => "New projects",
                                "count" => "+15"
                            ],
                            [
                                "name" => "Reactivated",
                                "count" => "+15"
                            ]
                        ]
                    ],
                    "link" => "Project List",
                    "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
                ]
            ],
            "COMPLETED" => [
                "admin" => false,
                "locked" => false,
                "link" => "completed",
                "hud" => "Completed Projects",
                "home" => [
                    "title" => "All Completed Projects",
                    "description" => "Here you can access and view projects that have been completed",
                    "total" => [
                        "name" => "Total Projects",
                        "count" => 9999
                    ],
                    "last-hours" => [
                        "title" => "In the last 24h",
                        "details" => [
                            [
                                "name" => "Completed",
                                "count" => "+20"
                            ]
                        ]
                    ],
                    "link" => "Project List",
                    "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
                ]
            ],
            "CANCELED" => [
                "admin" => false,
                "locked" => false,
                "link" => "canceled",
                "hud" => "Canceled Projects",
                "home" => [
                    "title" => "All Canceled Projects",
                    "description" => "Here you can access and view projects that have been canceled",
                    "total" => [
                        "name" => "Total Projects",
                        "count" => 49
                    ],
                    "last-hours" => [
                        "title" => "In the last 24h",
                        "details" => [
                            [
                                "name" => "Canceled",
                                "count" => "0"
                            ]
                        ]
                    ],
                    "link" => "Project List",
                    "note" => "Keep in mind these are only the projects you have accepted or completed a task for"
                ]
            ],
            "ADMIN" => [
                "admin" => true,
                "locked" => false,
                "link" => "admin",
                "hud" => "Admin"
            ]
        ]
    ];

    public static $projectMenu = [
        "level-1" => [
            "MY TASKS" => [
                "admin" => false,
                "locked" => false,
                "link" => "my_tasks",
                "default-link" => "my_tasks",
                "hud" => ": My Tasks",
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
                "locked" => false,
                "link" => "info",
                "default-link" => "info",
                "hud" => ": Info",
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
                    "SOMETHING1" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "something1",
                        "default-link" => "something1",
                        "hud" => ": Something"
                    ],
                    "SOMETHING2" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "something2",
                        "default-link" => "something2",
                        "hud" => ": Something"
                    ],
                    "PRODUCTION" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "production",
                        "default-link" => "production",
                        "hud" => ": PRODUCTION",
                        "level-3" => [
                            "SOMETHING1" => [
                                "admin" => false,
                                "locked" => false,
                                "link" => "something1",
                                "default-link" => "something1",
                                "hud" => ": Something",
                            ],
                            "COLORS" => [
                                "admin" => false,
                                "locked" => false,
                                "link" => "colors",
                                "default-link" => "colors",
                                "hud" => ": Colors",
                            ],
                            "SOMETHING2" => [
                                "admin" => false,
                                "locked" => false,
                                "link" => "something2",
                                "default-link" => "something2",
                                "hud" => ": Something",
                            ]
                        ]
                    ],
                    "SOMETHING3" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "something3",
                        "default-link" => "something3",
                        "hud" => ": Something"
                    ]
                ]
            ],
            "PRODUCTION" => [
                "admin" => false,
                "locked" => false,
                "link" => "production",
                "default-link" => "production&m=operations&b=colors&x=assignment",
                "hud" => ": Production",
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
                    "OPERATIONS" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "operations",
                        "default-link" => "operations&b=colors&x=assignment",
                        "hud" => ": Operations",
                        "level-3" => [
                            "SET UP" => [
                                "admin" => false,
                                "locked" => false,
                                "link" => "set-up",
                                "default-link" => "set-up",
                                "hud" => ": Set Up"
                            ],
                            "COLORS" => [
                                "admin" => false,
                                "locked" => false,
                                "link" => "colors",
                                "default-link" => "colors&x=assignment",
                                "hud" => ": Colors Assignment",
                                "level-4" => [
                                    "ASSIGNMENT" => [
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
                        "hud" => ": Research"
                    ],
                    "VISUALIZATION" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "visualization",
                        "default-link" => "visualization",
                        "hud" => ": Visualization"
                    ],
                    "CREATION" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "creation",
                        "default-link" => "creation",
                        "hud" => ": Creation"
                    ],
                    "DESIGN" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "design",
                        "default-link" => "design",
                        "hud" => ": Design"
                    ],
                    "ANIMATION" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "animation",
                        "default-link" => "animation",
                        "hud" => ": Animation"
                    ],
                    "AUDIO" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "audio",
                        "default-link" => "audio",
                        "hud" => ": Audio"
                    ],
                    "EXTRA" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "extra",
                        "default-link" => "extra",
                        "hud" => ": Extra"
                    ],
                    "ENHANCEMENT" => [
                        "admin" => false,
                        "locked" => false,
                        "link" => "enhancement",
                        "default-link" => "enhancement",
                        "hud" => ": Enhancement"
                    ]
                ]
            ],
            "APPROVALS" => [
                "admin" => false,
                "locked" => false,
                "link" => "approvals",
                "default-link" => "approvals",
                "hud" => ": Approvals",
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
            "MANAGER" => [
                "admin" => true,
                "locked" => false,
                "link" => "manager",
                "default-link" => "manager",
                "hud" => ": Manager",
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
                    "SOMETHING1" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "something1",
                        "default-link" => "something1",
                        "hud" => ": Something"
                    ],
                    "SOMETHING2" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "something2",
                        "default-link" => "something2",
                        "hud" => ": Something"
                    ],
                    "SOMETHING3" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "something3",
                        "default-link" => "something3",
                        "hud" => ": Something"
                    ],
                    "ALL ASSIGNMENTS" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "all assignments",
                        "default-link" => "all assignments",
                        "hud" => ": ALL ASSIGNMENTS",
                        "level-3" => [
                            "SOMETHING1" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something1",
                                "default-link" => "something1",
                                "hud" => ": Something",
                            ],
                            "ACTIVE " => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "active",
                                "default-link" => "active",
                                "hud" => ": Active",
                            ],
                            "SOMETHING2" => [
                                "admin" => true,
                                "locked" => false,
                                "link" => "something2",
                                "default-link" => "something2",
                                "hud" => ": Something",
                            ]
                        ]
                    ],
                    "SOMETHING4" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "something4",
                        "default-link" => "something4",
                        "hud" => ": Something"
                    ],
                    "SOMETHING5" => [
                        "admin" => true,
                        "locked" => false,
                        "link" => "something5",
                        "default-link" => "something5",
                        "hud" => ": Something"
                    ],
                ]
            ],
        ]
    ];

    public static function selectAdminProjectStatic()
    {
        $rows = self::selectStatic(array($_GET['p']), "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `project_type`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price` FROM `project` INNER JOIN `account` ON `account`.`id` = `project`.`clientid` INNER JOIN `project_type` ON `project_type`.`id` = `project`.`typeid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` WHERE `project`.`id` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $date = date('d M Y', strtotime($value['deadline']));
                $rows[$key]['date'] = $date;
            }
            return $rows;
        }
        else return null;
    }

    public function selectActiveProjectList()
    {
        $rows = $this->select(null, "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `project_type`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price` FROM `project` INNER JOIN `account` ON `account`.`id` = `project`.`clientid` INNER JOIN `project_type` ON `project_type`.`id` = `project`.`typeid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time`, `statusid` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` INNER JOIN `status` ON `status`.`id` = `a`.`statusid` WHERE `status`.`id` = '1'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['days_left'] = $this->dateToDays($value['deadline']);
            }
            return $rows;
        }
        else return null;
    } // only to get count

    public function selectPendingProjectList()
    {
        $rows = $this->select(null, "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `project_type`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price` FROM `project` INNER JOIN `account` ON `account`.`id` = `project`.`clientid` INNER JOIN `project_type` ON `project_type`.`id` = `project`.`typeid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time`, `statusid` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` INNER JOIN `status` ON `status`.`id` = `a`.`statusid` WHERE `status`.`id` = '2'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['days_left'] = $this->dateToDays($value['deadline']);
            }
            return $rows;
        }
        else return null;
    }// only to get count

    public function selectCompletedProjectList()
    {
        $rows = $this->select(null, "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `project_type`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price` FROM `project` INNER JOIN `account` ON `account`.`id` = `project`.`clientid` INNER JOIN `project_type` ON `project_type`.`id` = `project`.`typeid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time`, `statusid` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` INNER JOIN `status` ON `status`.`id` = `a`.`statusid` WHERE `status`.`id` = '3'");
        if ($rows) {
            return $rows;
        }
        else return null;
    } // only to get count

    public function selectCanceledProjectList()
    {
        $rows = $this->select(null, "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `project_type`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price` FROM `project` INNER JOIN `account` ON `account`.`id` = `project`.`clientid` INNER JOIN `project_type` ON `project_type`.`id` = `project`.`typeid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time`, `statusid` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` INNER JOIN `status` ON `status`.`id` = `a`.`statusid` WHERE `status`.`id` = '4'");
        if ($rows) {
            return $rows;
        }
        else return null;
    } // only to get count

    public function selectAdminRecentProjectList()
    {
        $rows = $this->select(null, "SELECT `*old*project`.id, `platform`, `title`, `deadline`, `price`, `username` AS `client`, a.status, a.time FROM `*old*project` INNER JOIN `account` ON account.id = `*old*project`.accountid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `projectid`, MAX(`time`) time FROM `*old*status` GROUP BY `projectid` ) b ON a.projectid = b.projectid AND a.time = b.time ON `*old*project`.id = a.projectid WHERE `status` = '7' OR `status` = '8' AND a.time >= DATE(NOW()) - INTERVAL 14 DAY");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
                $rows[$key]['days_left'] = $this->dateToDays($value['deadline']);
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
                $rows[$key]['platform_name'] = $this->getProjectPlatformName($value['platform']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminProject()
    {
        $rows = $this->select(array($_GET['p']), "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `project_type`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price` FROM `project` INNER JOIN `account` ON `account`.`id` = `project`.`clientid` INNER JOIN `project_type` ON `project_type`.`id` = `project`.`typeid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` WHERE `project`.`id` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $date = date('d M Y', strtotime($value['deadline']));
                $rows[$key]['date'] = $date;
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminProjectDrawingList()
    {
        $rows = $this->select(array($_GET['p']), "SELECT * FROM `drawing` INNER JOIN `project_drawing` ON drawing.id = project_drawing.drawingid INNER JOIN `account` ON account.id = drawing.accountid LEFT JOIN `drawing_status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE project_drawing.projectid = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($value['time']) {
                    $date = date('d M Y', strtotime($value['time']));
                    $rows[$key]['date'] = $date;
                }
                else
                    $rows[$key]['date'] = "-";
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminProjectAudioList()
    {
        $rows = $this->select(array($_GET['p']), "SELECT * FROM `audio` INNER JOIN `project_audio` ON audio.id = project_audio.audioid WHERE `projectid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getAudioTypeName($value['type']);
                $rows[$key]['reusable_name'] = $this->getAudioReusableName($value['reusable']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminProjectVoiceoverScript()
    {
        $rows = $this->select(array($_GET['p']), "SELECT voiceover_script.price, voiceover_script.path, account.username, a.status, a.time FROM `voiceover_script` INNER JOIN `account` ON account.id = voiceover_script.accountid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `script_voiceoverid`, MAX(`time`) time FROM `*old*status` GROUP BY `script_voiceoverid` ) b ON a.script_voiceoverid = b.script_voiceoverid AND a.time = b.time ON voiceover_script.id = a.script_voiceoverid WHERE voiceover_script.id = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $date = date('d M Y', strtotime($value['time']));
                $rows[$key]['date'] = $date;
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminProjectVoiceover()
    {
        $rows = $this->select(array($_GET['p']), "SELECT voiceover.price, voiceover.path, account.username, a.status, a.time FROM `voiceover` INNER JOIN `account` ON account.id = voiceover.accountid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `voiceoverid`, MAX(`time`) time FROM `*old*status` GROUP BY `voiceoverid` ) b ON a.voiceoverid = b.voiceoverid AND a.time = b.time ON voiceover.id = a.voiceoverid WHERE voiceover.id = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $date = date('d M Y', strtotime($value['time']));
                $rows[$key]['date'] = $date;
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminProjectVisualScript()
    {
        $rows = $this->select(array($_GET['p']), "SELECT visual_script.price, visual_script.path, account.username, a.status, a.time FROM `visual_script` INNER JOIN `account` ON account.id = visual_script.accountid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `script_visualid`, MAX(`time`) time FROM `*old*status` GROUP BY `script_visualid` ) b ON a.script_visualid = b.script_visualid AND a.time = b.time ON visual_script.id = a.script_visualid WHERE visual_script.id = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $date = date('d M Y', strtotime($value['time']));
                $rows[$key]['date'] = $date;
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
            }
            return $rows;
        }
        else return null;
    }
}