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

    public static function selectTask($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT * FROM `preset-task` WHERE `preset-task`.`id` = ?");
        if ($rows[0]) return $rows[0];
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