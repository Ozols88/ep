<?php
require_once "database.php";

class Project extends Database
{
    /*public $columns = [
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
];*/

    public function selectAdminProject()
    {
        $rows = $this->select(array($_GET['p']), "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `preset-project`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price`, `statusid`, `assigned_to` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            $rows[0]['date'] = date('d M Y', strtotime($rows[0]['deadline']));
            return $rows[0];
        }
        else {
            $rows[0]['project_id'] = null;
            return $rows[0];
        }
    }
    public static function selectAdminProjectStatic($projectID)
    {
        $rows = self::selectStatic(array($projectID), "SELECT `project`.`id` AS `project_id`, `username` AS `client_username`, `preset-project`.`title` AS `project_type`, `project`.`title` AS `project_title`, `deadline`, `price`, `project_status`.`statusid`, `assigned_by`, `assigned_to`, `note` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` WHERE `project`.`id` = ?");
        if (isset($rows[0])) {
            $rows[0]['date'] = date('d M Y', strtotime($rows[0]['deadline']));
            return $rows[0];
        }
        else {
            $rows[0]['project_id'] = null;
            return $rows[0];
        }
    }

    public static function selectProjectListByStatus($statusID) {
        $rows = self::selectStatic(array($statusID), "SELECT `project`.`id` AS `project_id`, `status`.`title` AS `status`, `username` AS `client_username`, `preset-project`.`title` AS `project_preset`, `project`.`title` AS `project_title`, `price`, `time`, `note`, ( SELECT COUNT(*) FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`statusid` = '3' AND `assignment`.`projectid` = `project`.`id` ) AS `completed_assignments`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`projectid` = `project`.`id` ) AS `total_assignments` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `status` ON `status`.`id` = `project_status`.`statusid` WHERE `project_status`.`statusid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['project_preset'])
                    $rows[$key]['project_preset'] = "Custom";
                $rows[$key]['date'] = date('d M Y', strtotime($rows[$key]['time']));
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
                    $rows[$key]['project_preset'] = "Custom";
                $rows[$key]['date'] = date('d M Y', strtotime($rows[$key]['time']));
            }
            return $rows;
        }
        else return null;
    }

    public static function getProjectCountByStatus($statusID) {
        $rows = self::selectStatic(array($statusID), "SELECT count(*) AS `count` FROM `project` LEFT JOIN `account` ON `account`.`id` = `project`.`clientid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `project_status` `a` INNER JOIN ( SELECT `projectid`, MAX(`time`) `time`, `statusid` FROM `project_status` GROUP BY `projectid` ) `b` ON `a`.`projectid` = `b`.`projectid` AND `a`.`time` = `b`.`time` ON `project`.`id` = `a`.`projectid` INNER JOIN `status` ON `status`.`id` = `a`.`statusid` WHERE `status`.`id` = ?");
        if ($rows[0]['count']) return $rows[0]['count'];
        else return 0;
    }

    public function selectAdminRecentProjectList()
    {
        $rows = $this->select(null, "SELECT `*old*project`.id, `platform`, `title`, `deadline`, `price`, `username` AS `client`, a.status, a.time FROM `*old*project` INNER JOIN `account` ON account.id = `*old*project`.accountid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `projectid`, MAX(`time`) time FROM `*old*status` GROUP BY `projectid` ) b ON a.projectid = b.projectid AND a.time = b.time ON `*old*project`.id = a.projectid WHERE `status` = '7' OR `status` = '8' AND a.time >= DATE(NOW()) - INTERVAL 14 DAY");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['date'] = $this->datetimeToDateWithoutSeconds($value['time']);
                $rows[$key]['days_left'] = $this->datetimeToDays($value['deadline']);
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProjectDepartments($projectID, $type)
    {
        $rows = self::selectStatic(array($projectID, $type), "SELECT `department`.`id` AS `depart_id`, `department`.`title` AS `depart_title`, COUNT(*) AS `assignment_count` FROM `department` LEFT JOIN `assignment` ON `department`.`id` = `assignment`.`departmentid` WHERE `assignment`.`projectid` = ? AND `assignment`.`type` = ? GROUP BY `department`.`id` ORDER BY `department`.`id`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT * FROM `preset-project`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `preset-project` WHERE `id` = ?");
        if ($rows) return $rows;
        else return null;
    }
}