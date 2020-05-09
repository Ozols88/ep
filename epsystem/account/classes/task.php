<?php
require_once "database.php";

class Task extends Database
{
    public static function selectAssignmentPresetTasks($presetID) {
        $array = self::selectStatic(array($presetID), "SELECT * FROM `preset-task` WHERE `preset-task`.`preset-assignmentid` = ?");
        $rows = [];
        foreach ($array as $row) {
            $rows[$row['id']] = $row;
        }
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
        $rows = self::selectStatic(array($taskID), "SELECT *, `action`.`title` AS `action`, `status`.`title` AS `status` FROM `task` INNER JOIN `action` ON `action`.`id` = `task`.`actionid` INNER JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` INNER JOIN `status` ON `status`.`id` = `task_status`.`statusid` WHERE `task`.`id` = ?");
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
}