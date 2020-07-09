<?php
require_once "database.php";

class Assignment extends Database
{
    public static function selectAssignmentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `assignment`.`id`, `assignment`.`title`, `assignment`.`projectid`, `preset-assignment`.`divisionid`, `assignment`.`presetid`, `assignment`.`objective`, `status`.`id` AS `status_id` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `status` ON `status`.`id` = `assignment_status`.`statusid` WHERE `assignment`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectAssignmentPresetsByFloor($floorID) {
        $rows = self::selectStatic(array($floorID), "SELECT `preset-assignment`.`id`, `preset-assignment`.`preset-projectid`, `preset-assignment`.`title`, `preset-assignment`.`objective`, `preset-assignment`.`divisionid`, `preset-project`.`floorid`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-assignment` INNER JOIN `preset-project` ON `preset-project`.id = `preset-assignment`.`preset-projectid` WHERE `preset-project`.`floorid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresetsByDivision($divisionID) {
        $rows = self::selectStatic(array($divisionID), "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, `division`.`title` AS `division`, `preset-assignment`.`objective`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-assignment` INNER JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` WHERE `preset-assignment`.`divisionid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `preset-assignment` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectDivisionsByFloor($floorID) {
        $rows = self::selectStatic(array($floorID), "SELECT `division_group`.`id` AS `group_id`, `division_group`.`title` AS `group_title`, `division`.`id` AS `division_id`, `division`.`title` AS `division_title`, `division`.`description` AS `division_desc` FROM `division` INNER JOIN `division_group` ON `division_group`.`id` = `division`.`groupid` WHERE `division`.`floorid` = ? UNION SELECT '1' AS `group_id`, 'when' AS `group_title`, '' AS `division_id`, 'Custom' AS `division_title`, '' AS `division_desc` ORDER BY `group_id`, `division_id`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectAllDivisions() {
        $rows = self::selectStatic(null, "SELECT * FROM `division`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectDivisionByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `division` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectAssignmentCountByStatus($status)
    {
        $rows = self::selectStatic(array($status), "SELECT count(*) AS `count` FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`statusid` = ?");
        if ($rows[0]['count']) return $rows[0]['count'];
        else return 0;
    }

    public static function selectAssignmentListByStatus($status)
    {
        $rows = self::selectStatic(array($status), "SELECT `assignment`.`projectid` AS `project_id`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `preset-assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `preset-project`.`title` AS `project_preset`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time`, ( SELECT SUM(`value`) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `earn` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `assignment_status`.`statusid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['project_preset'])
                    $rows[$key]['project_preset'] = "Custom";
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "Custom";
                $rows[$key]['time'] = date('i', strtotime($rows[$key]['time'])) . " min";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectAssignmentCountByStatusAndAccount($status, $account) {
        $rows = self::selectStatic(array($status, $account), "SELECT COUNT(*) AS `count` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`statusid` = ? AND `assignment_status`.`assigned_to` = ?");
        if ($rows[0]['count']) return $rows[0]['count'];
        else return 0;
    }

    public static function selectAssignmentListByStatusAndAccount($status, $account) {
        $rows = self::selectStatic(array($status, $account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `preset-assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time`, ( SELECT SUM(`value`) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `earn` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` INNER JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `assignment_status`.`statusid` = ? AND `assignment_status`.`assigned_to` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "Custom";
                $rows[$key]['time'] = date('i', strtotime($rows[$key]['time'])) . " min";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProjectAssignmentsByDivision($projectID, $divisionid) {
        if ($divisionid == '') // Custom Divison
            $rows = self::selectStatic(array($projectID), "SELECT `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_title`, `status`.`title` AS `status` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `status` ON `status`.`id` = `assignment_status`.`statusid` WHERE `assignment`.`projectid` = ? AND `assignment`.`presetid` IS NULL");
        else // All except custom division
            $rows = self::selectStatic(array($projectID, $divisionid), "SELECT `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_title`, `status`.`title` AS `status` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `status` ON `status`.`id` = `assignment_status`.`statusid` WHERE `assignment`.`projectid` = ? AND `preset-assignment`.`divisionid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectCurrentProjectAssignmentCountByStatus($status)
    {
        $rows = self::selectStatic(array($status), "SELECT COUNT(*) AS `count` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` WHERE `assignment_status`.`statusid` = ? AND (`project_status`.`statusid` = '1' OR `project_status`.`statusid` = '2' OR `project_status`.`statusid` = '3' OR `project_status`.`statusid` = '4')");
        if ($rows[0]['count']) return $rows[0]['count'];
        else return 0;
    }

    public static function selectCurrentProjectAssignmentsByStatus($status)
    {
        $rows = self::selectStatic(array($status), "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `floor`.`title` AS `floor`, `division`.`title` AS `division`, (SELECT `account`.`username` FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `assignment_status`.`assigned_to` WHERE `assignment_status`.`assignmentid` = `a`.`id`) AS `member`, (SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `tasks`, (SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `time`, (SELECT SUM(`value`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `earn`, (SELECT SUM(`task`.`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_time`, (SELECT SUM(`task`.`value`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_value` FROM `assignment` `a` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` LEFT JOIN `floor` ON `floor`.`id` = `division`.`floorid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `assignment_status`.`statusid` = ? AND (`project_status`.`statusid` = '1' OR `project_status`.`statusid` = '2' OR `project_status`.`statusid` = '3' OR `project_status`.`statusid` = '4')");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "Custom";

                if (!$rows[$key]['member'])
                    $rows[$key]['member'] = "-";

                $rows[$key]['time'] = date('i', strtotime($rows[$key]['time'])) . " min";

                if (!$rows[$key]['task_value'])
                    $rows[$key]['task_value'] = 0;

                if ($rows[$key]['task_time']) {
                    $rows[$key]['task_sum'] = $rows[$key]['task_value'] + ($rows[$key]['task_time'] * 0.15) . "€";
                    if ($rows[$key]['task_time'] > 59) {
                        $rows[$key]['task_time'] = floor($rows[$key]['task_time'] / 60) . "h " . $rows[$key]['task_time'] % 60 . "min";
                    }
                    else {
                        $rows[$key]['task_time'] .= "min";
                    }
                }
                else {
                    $rows[$key]['task_time'] = "0min";
                    $rows[$key]['task_sum'] = "0€";
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function insertAssignmentStatus($assignmentID, $status, $assigned_by, $assigned_to, $note) {
        $fields = [
            'assignmentid' => $assignmentID,
            'statusid' => $status,
            'time' => date("Y-m-d H-i-s"),
            'assigned_by' => $assigned_by,
            'assigned_to' => $assigned_to,
            'note' => $note
        ];
        $insertedID = self::insert('assignment_status', $fields, true, null);
        self::update('assignment', $assignmentID, ['statusid' => $insertedID], $_SERVER['REQUEST_URI']);
    }
}