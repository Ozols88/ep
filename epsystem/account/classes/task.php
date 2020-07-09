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
        $rows = self::selectStatic(array($presetID), "SELECT * FROM `preset-task` WHERE `preset-task`.`preset-assignmentid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectAssignmentTasks($assignmentID) {
        $rows = self::selectStatic(array($assignmentID), "SELECT * FROM `task` WHERE `task`.`assignmentid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectTaskPreset($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT * FROM `preset-task` WHERE `preset-task`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectTask($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT *, `action`.`title` AS `action`, `status`.`title` AS `status` FROM `task` INNER JOIN `action` ON `action`.`id` = `task`.`actionid` LEFT JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` LEFT JOIN `status` ON `status`.`id` = `task_status`.`statusid` WHERE `task`.`id` = ?");
        if ($rows[0]) {
            $rows[0]['estimated-min'] = self::datetimeToMinutes($rows[0]['estimated']) . " min";
            return $rows[0];
        }
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

    public static function RenumberTasksInProject($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT `task`.`id`, `task`.`number` FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = ? ORDER BY `task`.`id`");
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