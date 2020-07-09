<?php
require_once "database.php";

class Project extends Database
{
    public static function selectProject($projectID)
    {
        $rows = self::selectStatic(array($projectID), "SELECT `project`.`id` AS `id`, `username` AS `client`, `project`.`floorid` AS `floorid`, `preset-project`.`title` AS `preset`, `project`.`title` AS `title`, `deadline`, `price`, `project_status`.`statusid`, `assigned_by`, `note` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            $rows[0]['date'] = date('d M Y', strtotime($rows[0]['deadline']));
            return $rows[0];
        }
        else return null;
    }

    public static function selectProjectListByStatus($statusID) {
        $rows = self::selectStatic(array($statusID), "SELECT `project`.`id` AS `project_id`, `status`.`title` AS `status`, `username` AS `client_username`, `floor`.`title` AS `project_floor`, `preset-project`.`title` AS `project_preset`, `project`.`title` AS `project_title`, `price`, `time`, `note`, ( SELECT COUNT(*) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` WHERE `task_status`.`statusid` = '3' AND `assignment`.`projectid` = `project`.`id` ) AS `completed_tasks`, ( SELECT COUNT(*) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id` ) AS `total_tasks`, (SELECT SUM(`task`.`estimated`) FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id`) AS `task_time`, ( SELECT SUM(`task`.`value`) FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = `project`.`id`) AS `task_value` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `floor` ON `floor`.`id` = `project`.`floorid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `status` ON `status`.`id` = `project_status`.`statusid` WHERE `project_status`.`statusid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['project_preset'])
                    $rows[$key]['project_preset'] = "custom";

                $rows[$key]['date'] = date('d M Y', strtotime($rows[$key]['time']));

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

    public static function selectProjectList() {
        $rows = self::selectStatic(null, "SELECT `project`.`id` AS `project_id`, `status`.`title` AS `status`, `username` AS `client_username`, `preset-project`.`title` AS `project_preset`, `project`.`title` AS `project_title`, `price`, `time`, `note`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`statusid` = '3' AND `assignment`.`projectid` = `project`.`id` ) AS `completed_assignments`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`projectid` = `project`.`id` ) AS `total_assignments` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `status` ON `status`.`id` = `project_status`.`statusid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['project_preset'])
                    $rows[$key]['project_preset'] = "custom";
                $rows[$key]['date'] = date('d M Y', strtotime($rows[$key]['time']));
            }
            return $rows;
        }
        else return null;
    }

    public static function getProjectCountByStatus($statusID) {
        $rows = self::selectStatic(array($statusID), "SELECT count(*) AS `count` FROM `project` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` INNER JOIN `status` ON `status`.`id` = `project_status`.`statusid` WHERE `status`.`id` = ?");
        if ($rows[0]['count']) return $rows[0]['count'];
        else return 0;
    }

    public static function selectProjectDivisions($projectID)
    {
        $rows = self::selectStatic(array($projectID, $projectID), "SELECT `division_id`, `division_title`, `group_id`, `group_title`, `assignment_count` FROM ( SELECT IF(COUNT(*)>0, `division`.`id`, '') AS `division_id`, IF(COUNT(*)>0, `division`.`title`, '') AS `division_title`, IF(COUNT(*)>0, `division_group`.`id`, '') AS `group_id`, IF(COUNT(*)>0, `division_group`.`title`, '') AS `group_title`, IF(COUNT(*)>0, COUNT(*), '') AS `assignment_count` FROM `division` LEFT JOIN `preset-assignment` ON `division`.id = `preset-assignment`.`divisionid` LEFT JOIN `assignment` ON `assignment`.`presetid` = `preset-assignment`.`id` LEFT JOIN `division_group` ON `division_group`.`id` = `division`.`groupid` WHERE `assignment`.`projectid` = ? GROUP BY `division`.`id` HAVING IF(COUNT(*)>0, COUNT(*), '') <> '' UNION SELECT '' AS `division_id`, IF(COUNT(*)>0, 'Custom', '') AS `division_title`, IF(COUNT(*)>0, '1', '') AS `group_id`, IF(COUNT(*)>0, 'when', '') AS `group_title`, IF(COUNT(*)>0, COUNT(*), '') AS `assignment_count` FROM `assignment` WHERE `assignment`.`projectid` = ? AND `assignment`.`presetid` IS NULL HAVING IF(COUNT(*)>0, 'Custom', '') <> '' ) `t` ORDER BY `group_id`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectFloors() {
        $rows = self::selectStatic(null, "SELECT * FROM `floor`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectFloorByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `floor` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT * FROM `preset-project`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `preset-project` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectPresetsByFloorID($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-project`.`id`, `preset-project`.`floorid`, `preset-project`.`title` FROM `preset-project` INNER JOIN `floor` ON `floor`.`id` = `preset-project`.`floorid` WHERE `floor`.`id` = ?");
        if ($rows) return $rows;
        else return null;
    }

    // Queries for search
    public static function selectProjectPresetsByFloorTitle($floorTitle) {
        $rows = self::selectStatic(array($floorTitle), "SELECT * FROM `project-preset` INNER JOIN `floor` ON `floor`.`id` WHERE `floor`.`title` = ?");
        if ($rows) return $rows;
        else return null;
    }
}