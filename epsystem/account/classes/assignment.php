<?php
require_once "database.php";

class Assignment extends Database
{
    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, `department`.`title` AS `department`, `preset-assignment`.`objective`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-assignment` INNER JOIN `department` ON `department`.`id` = `preset-assignment`.`departmentid`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `preset-assignment` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectDepartments() {
        $rows = self::selectStatic(null, "SELECT * FROM `department`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectDepartmentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `department` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectAvailableAssignmentCount($preset)
    {
        if ($preset == true)
            $rows = self::selectStatic(array(), "SELECT count(*) AS `count` FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`statusid` = '5' AND `assignment`.`presetid` IS NOT NULL");
        else
            $rows = self::selectStatic(array(), "SELECT count(*) AS `count` FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`statusid` = '5' AND `assignment`.`presetid` IS NULL");
        if ($rows[0]['count']) return $rows[0]['count'];
        else return 0;
    }

    public static function selectAssignmentListByStatus($statusID, $preset)
    {
        if (isset($preset)) {
            if ($preset == true)
                $rows = self::selectStatic(array($statusID), "SELECT `assignment`.`projectid` AS `project_id`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`departmentid` AS `department_id`, `department`.`title` AS `department`, `preset-project`.`title` AS `project_preset`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time`, ( SELECT SUM(`value`) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `earn` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` INNER JOIN `department` ON `department`.`id` = `assignment`.`departmentid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `assignment_status`.`statusid` = ? AND `assignment`.`presetid` IS NOT NULL");
            else
                $rows = self::selectStatic(array($statusID), "SELECT `assignment`.`projectid` AS `project_id`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`departmentid` AS `department_id`, `department`.`title` AS `department`, `preset-project`.`title` AS `project_preset`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time`, ( SELECT SUM(`value`) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `earn` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` INNER JOIN `department` ON `department`.`id` = `assignment`.`departmentid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `assignment_status`.`statusid` = ? AND `assignment`.`presetid` IS NULL");
        }
        else {
            $rows = self::selectStatic(array($statusID), "SELECT `assignment`.`projectid` AS `project_id`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`departmentid` AS `department_id`, `department`.`title` AS `department`, `preset-project`.`title` AS `project_preset`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time`, ( SELECT SUM(`value`) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `earn` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` INNER JOIN `department` ON `department`.`id` = `assignment`.`departmentid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `assignment_status`.`statusid` = ?");
        }
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['project_preset'])
                    $rows[$key]['project_preset'] = "Custom";
                $rows[$key]['time'] = date('i', strtotime($rows[$key]['time'])) . " min";
            }
            return $rows;
        }
        else return null;
    }
}