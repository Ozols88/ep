<?php
require_once "database.php";

class Project extends Database
{
    public static function selectProject($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT `project`.`id` AS `id`, `project`.`productid` AS `productid`, `preset-project`.`title` AS `preset`, `product`.`title` AS `product`, `project`.`title` AS `title`, `project`.`description` AS `description`, `status_project`.`status1`, `status_project`.`status2`, `assigned_by`, `note`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`projectid` = `project`.`id` ) AS `asgCount` FROM `project` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['product'])
                $rows[0]['product'] = "None";
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectProjectDetails($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT `project`.`id` AS `id`, `project`.`productid`, `product`.`title` AS `product`, `project`.`presetid`, `preset-project`.`title` AS `preset`, `project`.`title` AS `title`, `project`.`description` AS `description`, `status_project`.`status1`, `status_project`.`time` AS `status_time`, `assigned_by`, `note`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_assignment`.`status1` = '1' ) AS `asgPending`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_assignment`.`status1` = '1' AND (`status_assignment`.`status2` = '8' OR `status_assignment`.`status2` = '9') ) AS `asgAvailable`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_assignment`.`status1` = '2' ) AS `asgActive`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_assignment`.`status1` = '3' ) AS `asgCompleted`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` ) AS `asgTotal`, ( SELECT COUNT(*) FROM `task` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.id = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '1') AS `tasksPending`, ( SELECT COUNT(*) FROM `task` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.id = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '2' ) AS `tasksActive`, ( SELECT COUNT(*) FROM `task` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.id = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '3' ) AS `tasksCompleted`, ( SELECT COUNT(*) FROM `task` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.id = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` ) AS `tasksTotal`, ( SELECT COUNT(*) FROM `project_infopage` WHERE `project_infopage`.`projectid` = `project`.`id` ) AS `links`, ( SELECT COUNT(`project_infopage`.`groupid`) FROM `project_infopage` WHERE `project_infopage`.`projectid` = `project`.`id` ) AS `link_groups`, ( SELECT COUNT(*) FROM `project_infopage` WHERE `project_infopage`.`projectid` = `project`.`id` AND `project_infopage`.`link` IS NULL ) AS `links_nourl`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id`) AS `task_time`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` LEFT JOIN `status_task` ON `task`.`statusid` = `status_task`.`id` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '3') AS `task_time_spent`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` LEFT JOIN `status_task` ON `task`.`statusid` = `status_task`.`id` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` != '3') AS `task_time_rem` FROM `project` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `product` ON `product`.`id` = `project`.productid WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['product'])
                $rows[0]['product'] = "No Product";
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "No Project Preset";
            if (!$rows[0]['task_time'])
                $rows[0]['task_time'] = "00:00:00";
            if (!$rows[0]['task_time_spent'])
                $rows[0]['task_time_spent'] = "00:00:00";
            if (!$rows[0]['task_time_rem'])
                $rows[0]['task_time_rem'] = "00:00:00";

            if ($rows[0]['status1'] == 1)
                $rows[0]['status'] = "Pending";
            elseif ($rows[0]['status1'] == 2)
                $rows[0]['status'] = "In Progress";
            elseif ($rows[0]['status1'] == 3)
                $rows[0]['status'] = "Completed";
            elseif ($rows[0]['status1'] == 4)
                $rows[0]['status'] = "Canceled";
            else
                $rows[0]['status'] = "?";

            if (isset($rows[0]['status_time'])) {
                $rows[0]['time_ago'] = Database::datetimeToTimeAgo($rows[0]['status_time']);
                if (strtotime($rows[0]['status_time']) < strtotime('-7 days'))
                    $rows[0]['time2'] = date('d M Y', strtotime($rows[0]['status_time']));
                else
                    $rows[0]['time2'] = $rows[0]['time_ago'];
                $rows[0]['time'] = date('d M Y', strtotime($rows[0]['status_time']));
            }
            return $rows[0];
        }
        else return null;
    }

    public static function selectProjectHistory($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT * FROM `status_project` WHERE `status_project`.`projectid` = ? ORDER BY `status_project`.`time`");
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                if (isset($value['time'])) {
                    $rows[$key]['time_ago'] = Database::datetimeToTimeAgo($value['time']);
//                    if (strtotime($value['time']) < strtotime('-7 days'))
//                        $rows[$key]['time2'] = date('d M Y', strtotime($rows[$key]['time']));
//                    else
//                        $rows[$key]['time2'] = $rows[$key]['time_ago'];
                    $rows[$key]['time2'] = date('d M Y', strtotime($rows[$key]['time']));
                    $rows[$key]['time'] = date('d M Y', strtotime($rows[$key]['time']));
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProjectsByStatus($statusID, $account) {
        $rows = self::selectStatic(array($statusID), "SELECT `project`.`id` AS `project_id`, `product`.`title` AS `project_product`, `preset-project`.`title` AS `project_preset`, `project`.`title` AS `project_title`, `time` AS `status_time`, `status_project`.`note`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`status1` = '3' ) AS `completed_assignments`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`projectid` = `project`.`id` ) AS `total_assignments`, ( SELECT COUNT(*) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '1' ) AS `pending_tasks`, ( SELECT COUNT(*) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` WHERE `status_task`.`status1` = '3' AND `assignment`.`projectid` = `project`.`id` ) AS `completed_tasks`, ( SELECT COUNT(*) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` ) AS `total_tasks`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`task`.`estimated`))) FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '3') AS `task_time` FROM `project` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` WHERE `status_project`.`status1` = ?");
        if ($rows) {
            // Remove projects where member doesn't participate
            if ($account->manager != 1) {
                foreach ($rows as $num => $project) {
                    $assignments = Assignment::selectProjectAssignments($project['project_id']);
                    if ($assignments) {
                        foreach ($assignments as $assignment) {
                            if ($assignment['assigned_to'] == $account->id) {
                                $participate = true;
                                break;
                            }
                        }
                    }
                    if (!isset($participate))
                        unset($rows[$num]);
                }
                if (!$rows)
                    return null;
            }

            foreach ($rows as $key => $value) {
                if (!$rows[$key]['project_product'])
                    $rows[$key]['project_product'] = "None";

                if (!$rows[$key]['project_preset'])
                    $rows[$key]['project_preset'] = "None";

                if (isset($value['status_time'])) {
                    $rows[$key]['status_time_ago'] = Database::datetimeToTimeAgo($value['status_time']);
                    if (strtotime($value['status_time']) < strtotime('-7 days'))
                        $rows[$key]['status_time2'] = date('d M Y', strtotime($rows[$key]['status_time']));
                    else
                        $rows[$key]['status_time2'] = $rows[$key]['status_time_ago'];
                    $rows[$key]['status_time'] = date('d M Y', strtotime($rows[$key]['status_time']));
                }

                if (!$rows[$key]['task_time']) {
                    $rows[$key]['task_time'] = "00:00:00";
                    $rows[$key]['task_min'] = 0;
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProducts() {
        $rows = self::selectStatic(null, "SELECT `product`.`id`, `product`.`title`, `product`.`description` FROM `product`");
        if ($rows) return $rows;
        else return null;
    }
    public static function selectProductByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `product`.`id`, `product`.`title`, `product`.`description`, `product`.`date_created`, `product`.`date_updated`, `product`.`times_updated`, ( SELECT COUNT(*) FROM `project` WHERE `project`.`productid` = `product`.`id` ) AS `projects`, ( SELECT COUNT(*) FROM `preset-project` WHERE `preset-project`.`productid` = `product`.`id` ) AS `presets` FROM `product` WHERE `id` = ?");
        if ($rows[0]) {
            if ($rows[0]['date_created']) {
                $rows[0]['date_created_ago'] = Database::datetimeToTimeAgo($rows[0]['date_created']);
                if (strtotime($rows[0]['date_created']) < strtotime('-7 days'))
                    $rows[0]['date_created_time2'] = date('d M Y', strtotime($rows[0]['date_created']));
                else
                    $rows[0]['date_created_time2'] = $rows[0]['date_created_ago'];
                $rows[0]['date_created_time'] = date('d M Y', strtotime($rows[0]['date_created']));
            }
            if ($rows[0]['date_updated']) {
                $rows[0]['date_updated_ago'] = Database::datetimeToTimeAgo($rows[0]['date_updated']);
                if (strtotime($rows[0]['date_updated']) < strtotime('-7 days'))
                    $rows[0]['date_updated_time2'] = date('d M Y', strtotime($rows[0]['date_updated']));
                else
                    $rows[0]['date_updated_time2'] = $rows[0]['date_updated_ago'];
                $rows[0]['date_updated_time'] = date('d M Y', strtotime($rows[0]['date_updated']));
            }
            return $rows[0];
        }
        else return null;
    }
    public static function selectProductProjectPresets($productID) {
        $rows = self::selectStatic(array($productID), "SELECT `preset-project`.`id`, `preset-project`.`title`, `preset-project`.`description`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments` FROM `preset-project` WHERE `preset-project`.`productid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT `preset-project`.`id`, `preset-project`.`title`, `preset-project`.`productid`, `preset-project`.`description`, `product`.`title` AS `product`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments` FROM `preset-project` LEFT JOIN `product` ON `product`.`id` = `preset-project`.`productid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['product'])
                    $rows[$key]['product'] = "None";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-project`.`id`, `preset-project`.`productid`, `product`.`title` AS `product`, `preset-project`.`title`, `preset-project`.`description`, `preset-project`.`date_created`, `preset-project`.`date_updated`, `preset-project`.`times_updated`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments`, ( SELECT COUNT(*) FROM `project` WHERE `project`.`presetid` = `preset-project`.`id` ) AS `projects` FROM `preset-project` LEFT JOIN `product` ON `product`.`id` = `preset-project`.`productid` WHERE `preset-project`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['product'])
                $rows[0]['product'] = "None";
            if ($rows[0]['date_created']) {
                $rows[0]['date_created_ago'] = Database::datetimeToTimeAgo($rows[0]['date_created']);
                if (strtotime($rows[0]['date_created']) < strtotime('-7 days'))
                    $rows[0]['date_created_time2'] = date('d M Y', strtotime($rows[0]['date_created']));
                else
                    $rows[0]['date_created_time2'] = $rows[0]['date_created_ago'];
                $rows[0]['date_created_time'] = date('d M Y', strtotime($rows[0]['date_created']));
            }
            if ($rows[0]['date_updated']) {
                $rows[0]['date_updated_ago'] = Database::datetimeToTimeAgo($rows[0]['date_updated']);
                if (strtotime($rows[0]['date_updated']) < strtotime('-7 days'))
                    $rows[0]['date_updated_time2'] = date('d M Y', strtotime($rows[0]['date_updated']));
                else
                    $rows[0]['date_updated_time2'] = $rows[0]['date_updated_ago'];
                $rows[0]['date_updated_time'] = date('d M Y', strtotime($rows[0]['date_updated']));
            }
            return $rows[0];
        }
        else return null;
    }

    public static function selectPresetsByProductID($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-project`.`id`, `preset-project`.`productid`, `preset-project`.`title`, `preset-project`.`description`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments` FROM `preset-project` INNER JOIN `product` ON `product`.`id` = `preset-project`.`productid` WHERE `product`.`id` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function isProjectDeletable($project) {
        // Function checks if there are any non-1,2 status assignments (can't delete project with those)
        if ($project['status1'] == 1 || $project['status1'] == 2) {
            $assignments = Assignment::selectProjectAssignments($project['id']);
            if ($assignments)
                foreach ($assignments as $assignment)
                    if ($assignment['status1'] != 1)
                        return false;
                    elseif ($assignment['status2'] > 7)
                        return false;
            return true;
        }
        else return false;
    }

    public static function isProjectCancelable($project) {
        // Function checks if there are any pending(4,5,6) assignments (can't cancel project with those)
        if ($project['status1'] == 1 || $project['status1'] == 2) {
            $assignments = Assignment::selectProjectAssignments($project['id']);
            if ($assignments) {
                foreach ($assignments as $assignment)
                    if ($assignment['status1'] == 2)
                        return false;
                    elseif ($assignment['status1'] == 1 && ($assignment['status2'] == 10 || $assignment['status2'] == 11))
                        return false;
            }
            else return false;
            return true;
        }
        else return false;
    }

    public static function isProjectCompletable($project) {
        // Function checks if all assignments are completed
        if ($project['status1'] == 1) {
            $assignments = Assignment::selectProjectAssignments($project['id']);
            if ($assignments) {
                foreach ($assignments as $assignment)
                    if ($assignment['status1'] != 3)
                        return false;
            }
            else return false;
            return true;
        }
        else return false;
    }

    public static function projectStatusChanger($projectID, $accountID) {
        // Function changes project status to active/pending according to assignment statuses
        $project = self::selectProject($projectID);
        $assignments = Assignment::selectProjectAssignments($projectID);

        // Pending - no assignments
        if (!$assignments) {
            if ($project['status1'] == 1 && $project['status2'] == 3)
                return;
            $fields = [
                'projectid' => $projectID,
                'status1' => 1,
                'status2' => 3,
                'time' => date("Y-m-d H-i-s"),
                'assigned_by' => $accountID,
            ];

            $statusID = self::insert('status_project', $fields, true, false);
            self::update('project', $projectID, ["statusid" => $statusID], false);
        }
        elseif ($assignments) {
            // Check if any active assignments
            $active = false;
            foreach ($assignments as $assignment) {
                if ($assignment['status1'] == 2) {
                    $active = true;
                    break;
                }
            }
            // Project active
            if ($active) {
                if ($project['status1'] == 2 && $project['status2'] == 1)
                    return;
                $fields = [
                    'projectid' => $projectID,
                    'status1' => 2,
                    'status2' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                ];

                $statusID = self::insert('status_project', $fields, true, false);
                self::update('project', $projectID, ["statusid" => $statusID], false);
            }
            // Pending - no active assignments
            else {
                if ($project['status1'] == 1 && ($project['status2'] == 1 || $project['status2'] == 2))
                    return;
                $fields = [
                    'projectid' => $projectID,
                    'status1' => 1,
                    'status2' => 2,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                ];

                $statusID = self::insert('status_project', $fields, true, false);
                self::update('project', $projectID, ["statusid" => $statusID], false);
            }
        }
    }

    public static function selectProjectInfoPages($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT `project_infopage`.`id`, `project_infopage`.`projectid`, `project_infopage`.`presetid`, `project_infopage`.`groupid`, `infopage_group`.`title` AS `group`, `project_infopage`.`title`, `project_infopage`.`description`, `project_infopage`.`link` FROM `project_infopage` LEFT JOIN `preset-infopage` ON `preset-infopage`.`id` = `project_infopage`.`presetid` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `project_infopage`.`groupid` WHERE `project_infopage`.`projectid` = ? ORDER BY `project_infopage`.`groupid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rowsIDs[$value['id']] = $value;

                if (!$rowsIDs[$value['id']]['group'])
                    $rowsIDs[$value['id']]['group'] = "None";
                if ($rowsIDs[$value['id']]['link'])
                    $rowsIDs[$value['id']]['hasLink'] = "Yes";
                else
                    $rowsIDs[$value['id']]['hasLink'] = "No";
            }
            return $rowsIDs;
        }
        else return null;
    }

    public static function selectProjectInfoPage($infoID) {
        $rows = self::selectStatic(array($infoID), "SELECT `project_infopage`.`id`, `project_infopage`.`projectid`, `project_infopage`.`presetid`, `project_infopage`.`groupid`, `infopage_group`.`title` AS `group`, `project_infopage`.`title`, `project_infopage`.`description`, `project_infopage`.`link` FROM `project_infopage` LEFT JOIN `preset-infopage` ON `preset-infopage`.`id` = `project_infopage`.`presetid` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `project_infopage`.`groupid` WHERE `project_infopage`.`id` = ? ORDER BY `project_infopage`.`groupid`");
        if ($rows[0]) {
            if (!$rows[0]['group'])
                $rows[0]['group'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectProjectsByPreset($id) {
        $rows = self::selectStatic(array($id), "SELECT `project`.`id`, `project`.`productid`, `project`.`presetid`, `project`.`title`, `project`.`description`, `project`.`statusid`, `status_project`.`status1`, `product`.`title` AS `product`, `preset-project`.`title` AS `preset`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`task`.`estimated`))) FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` WHERE `assignment`.`projectid` = `project`.`id` AND `status_task`.`status1` = '3') AS `task_time` FROM `project` LEFT JOIN `product` ON `project`.`productid` = `product`.`id` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `status_project` ON `project`.`statusid` = `status_project`.`id` WHERE `project`.`presetid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['product'])
                    $rows[$key]['product'] = "None";
                if (!$rows[$key]['preset'])
                    $rows[$key]['preset'] = "None";
                if (!$rows[$key]['task_time']) {
                    $rows[$key]['task_time'] = "00:00:00";
                    $rows[$key]['task_min'] = 0;
                }

                if ($rows[$key]['status1'] == 1)
                    $rows[$key]['status'] = "Pending";
                elseif ($rows[$key]['status1'] == 2)
                    $rows[$key]['status'] = "In Progress";
                elseif ($rows[$key]['status1'] == 3)
                    $rows[$key]['status'] = "Completed";
                elseif ($rows[$key]['status1'] == 4)
                    $rows[$key]['status'] = "Canceled";
                else
                    $rows[$key]['status'] = "?";
            }
            return $rows;
        }
        else return null;
    }
}