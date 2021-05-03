<?php
require_once "database.php";

class Project extends Database
{
    public static function selectProject($projectID)
    {
        $rows = self::selectStatic(array($projectID), "SELECT `project`.`id` AS `id`, `project`.`productid` AS `productid`, `preset-project`.`title` AS `preset`, `product`.`title` AS `product`, `project`.`title` AS `title`, `project`.`description` AS `description`, `project_status`.`statusid`, `assigned_by`, `note`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`projectid` = `project`.`id` ) AS `asgCount` FROM `project` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['product'])
                $rows[0]['product'] = "None";
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectProjectDetails($projectID)
    {
        $rows = self::selectStatic(array($projectID), "SELECT `project`.`id` AS `id`, `project`.`productid`, `product`.`title` AS `product`, `project`.`presetid`, `preset-project`.`title` AS `preset`, `project`.`title` AS `title`, `project`.`description` AS `description`, `project_status`.`statusid`, `status`.`title` AS `status`, `project_status`.`time` AS `status_time`, `assigned_by`, `note`, ( SELECT COUNT(*) FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = `project`.`id` AND (`assignment_status`.`statusid` = '1' OR `assignment_status`.`statusid` = '2' OR `assignment_status`.`statusid` = '5' OR `assignment_status`.`statusid` = '6') ) AS `asgPending`, ( SELECT COUNT(*) FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = `project`.`id` AND `assignment_status`.`statusid` = '3' ) AS `asgAvailable`, ( SELECT COUNT(*) FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = `project`.`id` AND `assignment_status`.`statusid` = '4' ) AS `asgActive`, ( SELECT COUNT(*) FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = `project`.`id` AND `assignment_status`.`statusid` = '7' ) AS `asgCompleted`, ( SELECT COUNT(*) FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = `project`.`id` ) AS `asgTotal`, ( SELECT COUNT(*) FROM task LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` LEFT JOIN assignment ON assignment.id = task.`assignmentid` WHERE assignment.`projectid` = `project`.`id` AND (`task_status`.`statusid` = '1' OR `task_status`.`statusid` = '5' OR `task_status`.`statusid` = '6') ) AS `tasksPending`, ( SELECT COUNT(*) FROM task LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` LEFT JOIN assignment ON assignment.id = task.`assignmentid` WHERE assignment.`projectid` = `project`.`id` AND `task_status`.`statusid` = '4' ) AS `tasksActive`, ( SELECT COUNT(*) FROM task LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` LEFT JOIN assignment ON assignment.id = task.`assignmentid` WHERE assignment.`projectid` = `project`.`id` AND `task_status`.`statusid` = '7' ) AS `tasksCompleted`, ( SELECT COUNT(*) FROM task LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` LEFT JOIN assignment ON assignment.id = task.`assignmentid` WHERE assignment.`projectid` = `project`.`id` ) AS `tasksTotal`, ( SELECT COUNT(*) FROM `project_infopage` WHERE `project_infopage`.`projectid` = `project`.`id` ) AS `links`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id`) AS `task_time` FROM `project` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN product ON product.`id` = `project`.productid LEFT JOIN `status` ON `status`.id = `project_status`.`statusid` WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['product'])
                $rows[0]['product'] = "None";
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "None";
            if (!$rows[0]['task_time'])
                $rows[0]['task_time'] = "00:00:00";
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

    public static function selectProjectHistory($projectID)
    {
        $rows = self::selectStatic(array($projectID), "SELECT * FROM `project_status` WHERE `project_status`.`projectid` = ? ORDER BY `project_status`.`time`");
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                if (isset($value['time'])) {
                    $rows[$key]['time_ago'] = Database::datetimeToTimeAgo($value['time']);
                    if (strtotime($value['time']) < strtotime('-7 days'))
                        $rows[$key]['time2'] = date('d M Y', strtotime($rows[$key]['time']));
                    else
                        $rows[$key]['time2'] = $rows[$key]['time_ago'];
                    $rows[$key]['time'] = date('d M Y', strtotime($rows[$key]['time']));
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProjectsByStatus($statusID, $account) {
        $rows = self::selectStatic(array($statusID), "SELECT `project`.`id` AS `project_id`, `status`.`title` AS `status`, product.`title` AS `project_product`, `preset-project`.`title` AS `project_preset`, `project`.`title` AS `project_title`, `time` AS `status_time`, `note`, ( SELECT COUNT(*) FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE `assignment_status`.`statusid` = '7' AND assignment.`projectid` = `project`.`id` ) AS `completed_assignments`, ( SELECT COUNT(*) FROM assignment WHERE assignment.`projectid` = `project`.`id` ) AS `total_assignments`, ( SELECT COUNT(*) FROM task INNER JOIN assignment ON assignment.`id` = task.`assignmentid` LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` WHERE assignment.`projectid` = `project`.`id` AND (`task_status`.`statusid` = '1' OR `task_status`.`statusid` = '5' OR `task_status`.`statusid` = '6')) AS `pending_tasks`, ( SELECT COUNT(*) FROM task INNER JOIN assignment ON assignment.`id` = task.`assignmentid` LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` WHERE `task_status`.`statusid` = '7' AND assignment.`projectid` = `project`.`id` ) AS `completed_tasks`, ( SELECT COUNT(*) FROM task INNER JOIN assignment ON assignment.`id` = task.`assignmentid` WHERE assignment.`projectid` = `project`.`id` ) AS `total_tasks`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(task.`estimated`))) FROM task LEFT JOIN assignment ON assignment.`id` = task.`assignmentid` LEFT JOIN `task_status` ON `task_status`.`id` = task.`statusid` WHERE assignment.`projectid` = `project`.`id` AND `task_status`.`statusid` = '7') AS `task_time` FROM `project` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN product ON product.`id` = `project`.productid LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `status` ON `status`.`id` = `project_status`.`statusid` WHERE `project_status`.`statusid` = ?");
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
        $rows = self::selectStatic(null, "SELECT product.`id`, product.`title`, product.`description` FROM product");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectProductByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM product WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT `preset-project`.`id`, `preset-project`.`title`, `preset-project`.`productid`, `preset-project`.`description`, `product`.`title` AS `product`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments` FROM `preset-project` LEFT JOIN `product` ON `product`.`id` = `preset-project`.`productid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['product'])
                    $rows[$key]['product'] = "none";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-project`.`id`, `preset-project`.`productid`, `product`.`title` AS `product`, `preset-project`.`title`, `preset-project`.`description`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments` FROM `preset-project` LEFT JOIN `product` ON `product`.`id` = `preset-project`.`productid` WHERE `preset-project`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['product'])
                $rows[0]['product'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectPresetsByProductID($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-project`.`id`, `preset-project`.productid, `preset-project`.`title`, `preset-project`.`description`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`projectid` = `preset-project`.`id` ) AS `assignments` FROM `preset-project` INNER JOIN product ON product.`id` = `preset-project`.productid WHERE product.`id` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function isProjectDeletable($project) {
        // Function checks if there are any non-1,2 status assignments (can't delete project with those)
        if ($project['statusid'] == 4 || $project['statusid'] == 6) {
            $assignments = Assignment::selectProjectAssignments($project['id']);
            if ($assignments)
                foreach ($assignments as $assignment)
                    if ($assignment['statusid'] != 1 && $assignment['statusid'] != 2)
                        return false;
            return true;
        }
        else return false;
    }

    public static function isProjectCancelable($project) {
        // Function checks if there are any pending(4,5,6) assignments (can't cancel project with those)
        if ($project['statusid'] == 4 || $project['statusid'] == 6) {
            $assignments = Assignment::selectProjectAssignments($project['id']);
            if ($assignments) {
                foreach ($assignments as $assignment)
                    if ($assignment['statusid'] == 4 || $assignment['statusid'] == 5 || $assignment['statusid'] == 6)
                        return false;
            }
            else return false;
            return true;
        }
        else return false;
    }

    public static function isProjectCompletable($project) {
        // Function checks if all assignments are completed
        if ($project['statusid'] == 6) {
            $assignments = Assignment::selectProjectAssignments($project['id']);
            if ($assignments) {
                foreach ($assignments as $assignment)
                    if ($assignment['statusid'] != 7 && $assignment['statusid'] != 9)
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

        $statusID = 6;
        if ($assignments)
            foreach ($assignments as $assignment)
                if ($assignment['statusid'] == 4) {
                    $statusID = 4;
                    break;
                }

        if ($statusID == 4 && $project['statusid'] == 6) $change = 4;
        elseif ($statusID == 6 && $project['statusid'] == 4) $change = 6;
        else $change = null;

        if (!is_null($change)) {
            $fields = [
                'projectid' => $projectID,
                'time' => date("Y-m-d H-i-s"),
                'assigned_by' => $accountID,
                'note' => "Assignment status changed"
            ];
            if ($change == 4) $fields['statusid'] = 4;
            elseif ($change == 6) $fields['statusid'] = 6;

            $statusID = Assignment::insert('project_status', $fields, true, false);
            self::update('project', $projectID, ["statusid" => $statusID], false);
        }
    }

    public static function selectProjectInfoPages($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT `project_infopage`.`id`, `project_infopage`.`projectid`, `project_infopage`.`presetid`, `preset-infopage`.`groupid`, `infopage_group`.`title` AS `group`, `project_infopage`.`title`, `project_infopage`.`description`, `project_infopage`.`link` FROM `project_infopage` LEFT JOIN `preset-infopage` ON `preset-infopage`.`id` = `project_infopage`.`presetid` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `preset-infopage`.`groupid` WHERE `project_infopage`.`projectid` = ? ORDER BY `preset-infopage`.`groupid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['group'])
                    $rows[$key]['group'] = "None";
                if ($rows[$key]['link'])
                    $rows[$key]['hasLink'] = "Yes";
                else
                    $rows[$key]['hasLink'] = "No";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProjectInfoPage($infoID) {
        $rows = self::selectStatic(array($infoID), "SELECT `project_infopage`.`id`, `project_infopage`.`projectid`, `project_infopage`.`presetid`, `preset-infopage`.`groupid`, `infopage_group`.`title` AS `group`, `project_infopage`.`title`, `project_infopage`.`description`, `project_infopage`.`link` FROM `project_infopage` LEFT JOIN `preset-infopage` ON `preset-infopage`.`id` = `project_infopage`.`presetid` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `preset-infopage`.`groupid` WHERE `project_infopage`.`id` = ? ORDER BY `preset-infopage`.`groupid`");
        if ($rows[0]) return $rows[0];
        else return null;
    }
}