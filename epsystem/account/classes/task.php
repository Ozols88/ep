<?php
require_once "database.php";

class Task extends Database
{
    public static function selectAssignmentPresetTaskCount($presetID) {
        $rows = self::selectStatic(array($presetID), "SELECT COUNT(*) AS `count` FROM `preset-assignment` LEFT JOIN `preset-task` ON `preset-assignment`.id = `preset-task`.`preset-assignmentid` WHERE `preset-assignment`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectAssignmentPresetTasks($presetID) {
        $rows = self::selectStatic(array($presetID), "SELECT `preset-task`.`id`, `preset-task`.`preset-assignmentid`, `preset-task`.`objective`, `preset-task`.`description`, `preset-task`.`estimated`, `action`.`title` AS `action` FROM `preset-task` INNER JOIN `action` ON `action`.`id` = `preset-task`.`actionid` WHERE `preset-task`.`preset-assignmentid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectAssignmentTasks($assignmentID) {
        $rows = self::selectStatic(array($assignmentID), "SELECT `task`.`id`, `task`.`assignmentid`, `task`.`presetid`, `task`.`objective`, `task`.`description`, `task`.`actionid`, `task`.`number`, `task`.`estimated`, `task`.`value`, `task_status`.`statusid`, `task_status`.`time`, `task_status`.`assigned_by`, `task_status`.`note` FROM `task` INNER JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` WHERE `task`.`assignmentid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectTaskPreset($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT * FROM `preset-task` WHERE `preset-task`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectTask($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task`.`id`, `task`.`assignmentid`, `task`.`presetid`, `task`.`objective`, `task`.`description`, `task`.`number`, `task`.`estimated`, `task`.`value`, `task_status`.`statusid`, `task_status`.`time`, `task_status`.`assigned_by`, `task_status`.`note`, `action`.id AS `actionid`, `action`.`title` AS `action`, `status`.`title` AS `status`, `status`.`title2` AS `status2` FROM `task` INNER JOIN `action` ON `action`.`id` = `task`.`actionid` LEFT JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` LEFT JOIN `status` ON `status`.`id` = `task_status`.`statusid` WHERE `task`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectTaskLinks($taskID, $linkType) {
        $rows = self::selectStatic(array($taskID, $linkType), "SELECT * FROM `task_link` WHERE `taskid` = ? AND `type` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectActions() {
        $rows = self::selectStatic(null, "SELECT * FROM `action`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectAction($actionID) {
        $rows = self::selectStatic(array($actionID), "SELECT * FROM `action` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function RenumberTasksInAssignment($assignmentID) {
        $rows = self::selectStatic(array($assignmentID), "SELECT `task`.`id`, `task`.`number` FROM `task` WHERE `task`.`assignmentid` = ? ORDER BY `task`.`id`");
        if ($rows) {
            $nextTaskNum = count($rows) + 1;
            foreach ($rows as $num => $task) {
                if ($task['number'] != $num + 1)
                    Task::update('task', $task['id'], ['number' => $num + 1], null);
            }
            return $nextTaskNum;
        }
        else return null;
    }
}