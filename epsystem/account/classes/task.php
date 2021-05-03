<?php
require_once "database.php";

class Task extends Database
{
    public static function selectAssignmentPresetTasks($presetID) {
        $rows = self::selectStatic(array($presetID), "SELECT `preset-task`.`id`, `preset-task`.`assignmentid`, `preset-task`.`name`, `preset-task`.`description`, `preset-task`.`estimated`, `preset-task`.`infoid`, ( SELECT COUNT(*) FROM `preset-task_links` WHERE `preset-task_links`.`taskid` = `preset-task`.`id` ) AS `links` FROM `preset-task` WHERE `preset-task`.`assignmentid` = ?");
        if ($rows) {
            return $rows;
        }
        else return null;
    }

    public static function selectAssignmentTasks($assignmentID) {
        $rows = self::selectStatic(array($assignmentID), "SELECT `task`.`id`, `task`.`assignmentid`, `task`.`presetid`, `task`.`name`, `task`.`description`, `task`.`number`, `task`.`estimated`, `task_status`.`statusid`, `status`.`title` AS `status`, `status`.`title2` AS `status2`, `task_status`.`time`, `task_status`.`assigned_by`, `task_status`.`note`, ( SELECT COUNT(*) FROM `task_link` WHERE `task_link`.`taskid` = `task`.`id` ) AS `links`, ( SELECT COUNT(*) FROM `task_comment` WHERE `task_comment`.`taskid` = `task`.`id` ) AS `comments` FROM `task` LEFT JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` LEFT JOIN `status` ON `status`.`id` = `task_status`.`statusid` WHERE `task`.`assignmentid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['estimated'])
                    $rows[$key]['estimated'] = "-";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT `preset-task`.`id`, `preset-task`.`assignmentid`, `preset-task`.`name`, `preset-task`.`description`, `preset-task`.`estimated`, `preset-task`.`infoid`, `preset-assignment`.`title` AS `asg-title`, `preset-assignment`.`divisionid`, `division`.`title` AS `division`, ( SELECT COUNT(*) FROM `preset-task_links` WHERE `preset-task_links`.`taskid` = `preset-task`.`id` ) AS `links` FROM `preset-task` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `preset-task`.`assignmentid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid`");
        if (isset($rows)) {
            foreach ($rows as $row) {}
            return $rows;
        }
        else return null;
    }
    public static function selectTaskPreset($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `preset-task`.`id`, `preset-task`.`assignmentid`, `preset-task`.`name`, `preset-task`.`description`, `preset-task`.`estimated`, `preset-task`.`infoid`, `preset-infopage`.`title` AS `info-title`, `preset-infopage`.`description` AS `info-desc`, ( SELECT COUNT(*) FROM `preset-task_links` WHERE `preset-task_links`.`taskid` = `preset-task`.`id` ) AS `links` FROM `preset-task` LEFT JOIN `preset-infopage` ON `preset-infopage`.`id` = `preset-task`.`infoid` WHERE `preset-task`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['info-title'])
                $rows[0]['info-title'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectTaskPresetLinks($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `preset-task_links`.`id`, `preset-task_links`.`taskid`, `preset-task_links`.`typeid`, `preset-task_links`.`title`, `preset-task_links`.`link`, `link_type`.`title` AS `type` FROM `preset-task_links` LEFT JOIN `link_type` ON `link_type`.`id` = `preset-task_links`.`typeid` WHERE `preset-task_links`.`taskid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['type'])
                    $rows[$key]['type'] = "None";
            }
            return $rows;
        }
        else return null;
    }
    public static function selectTaskPresetLink($linkID) {
        $rows = self::selectStatic(array($linkID), "SELECT `preset-task_links`.`id`, `preset-task_links`.`taskid`, `preset-task_links`.`typeid`, `preset-task_links`.`title`, `preset-task_links`.`link`, `link_type`.`title` AS `type` FROM `preset-task_links` LEFT JOIN `link_type` ON `link_type`.`id` = `preset-task_links`.`typeid` WHERE `preset-task_links`.`id` = ?");
        if ($rows[0]) {
            if (!$rows[0]['type'])
                $rows[0]['type'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectTask($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task`.`id`, `task`.`name`, `task`.`assignmentid`, `assignment`.`presetid` AS `asg-presetid`, `task`.`presetid`, `preset-task`.`name` AS `preset`, `task`.`description`, `task`.`number`, `task`.`infoid`, `task`.`estimated`, `task_status`.`statusid`, `task_status`.`time` AS `status_time`, `task_status`.`assigned_by`, `task_status`.`note`, `project_infopage`.`title`, `project_infopage`.`link`, `status`.`title` AS `status`, `status`.`title2` AS `status2`, ( SELECT COUNT(*) FROM `task_link` WHERE `task_link`.`taskid` = `task`.`id` ) AS `links`, ( SELECT COUNT(*) FROM `task_comment` WHERE `task_comment`.`taskid` = `task`.`id` ) AS `comments`, ( SELECT COUNT(*) FROM `task_comment` LEFT JOIN `account` ON `account`.`id` = `task_comment`.`accountid` WHERE `task_comment`.`taskid` = `task`.`id` AND `account`.`manager` = '1' ) AS `manager_comments`, ( SELECT COUNT(*) FROM `task_comment` LEFT JOIN `account` ON `account`.`id` = `task_comment`.`accountid` WHERE `task_comment`.`taskid` = `task`.`id` AND `account`.`manager` != '1' ) AS `member_comments` FROM `task` LEFT JOIN `preset-task` ON `preset-task`.`id` = `task`.`presetid` LEFT JOIN `project_infopage` ON `project_infopage`.`id` = `task`.`infoid` LEFT JOIN `task_status` ON `task_status`.`id` = `task`.`statusid` LEFT JOIN `status` ON `status`.`id` = `task_status`.`statusid` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `task`.`id` = ?");
        if ($rows[0]) {
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "None";
            if ($rows[0]['estimated']) {
                // Adds hours to minutes
                $time = explode(':', $rows[0]['estimated']);
                $time[1] += ($time[0] * 60);
                unset($time[0]);
                $rows[0]['estimated2'] = implode(":", $time);
            }
            else {
                $rows[0]['estimated'] = "00:00:00";
            }
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

    public static function selectTaskLinks($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task_link`.`id`, `task_link`.`taskid`, `task_link`.`typeid`, `task_link`.`title`, `task_link`.`link`, `link_type`.`title` AS `type`, `link_type`.`description` AS `type_desc` FROM `task_link` LEFT JOIN `link_type` ON `link_type`.`id` = `task_link`.`typeid` WHERE `taskid` = ? ORDER BY `task_link`.`typeid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['type'])
                    $rows[$key]['type'] = "None";
            }
            return $rows;
        }
        else return null;
    }
    public static function selectTaskLinksWithoutInfo($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task_link`.`id`, `task_link`.`taskid`, `task_link`.`typeid`, `task_link`.`title`, `task_link`.`link`, `link_type`.`title` AS `type`, `link_type`.`description` AS `type_desc` FROM `task_link` LEFT JOIN `link_type` ON `link_type`.`id` = `task_link`.`typeid` WHERE `taskid` = ? AND `typeid` != '1' ORDER BY `task_link`.`typeid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['type'])
                    $rows[$key]['type'] = "None";
            }
            return $rows;
        }
        else return null;
    }
    public static function selectTaskCustomInfoLinks($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task_link`.`id`, `task_link`.`taskid`, `task_link`.`typeid`, `task_link`.`title`, `task_link`.`link`, `link_type`.`title` AS `type`, `link_type`.`description` AS `type_desc` FROM `task_link` LEFT JOIN `link_type` ON `link_type`.`id` = `task_link`.`typeid` WHERE `taskid` = ? AND `typeid` = '1' ORDER BY `task_link`.`typeid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['type'])
                    $rows[$key]['type'] = "None";
            }
            return $rows;
        }
        else return null;
    }
    public static function selectTaskInfoLinks($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task_link-infopage`.`id`, `task_link-infopage`.`taskid`, `task_link-infopage`.`infoid`, `project_infopage`.`projectid`, `project_infopage`.`presetid`, `project_infopage`.`title`, `project_infopage`.`description`, `project_infopage`.`link` FROM `task_link-infopage` INNER JOIN `project_infopage` ON `project_infopage`.`id` = `task_link-infopage`.`infoid` WHERE `task_link-infopage`.`taskid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function RenumberTasksInAssignment($assignmentID) {
        $rows = self::selectStatic(array($assignmentID), "SELECT task.`id`, task.`number` FROM task WHERE task.`assignmentid` = ? ORDER BY task.`id`");
        if ($rows) {
            $nextTaskNum = count($rows) + 1;
            foreach ($rows as $num => $task) {
                if ($task['number'] != $num + 1)
                    Task::update('task', $task['id'], ['number' => $num + 1], null);
            }
            return $nextTaskNum;
        }
        else return 1;
    }

    public static function selectTaskComments($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task_comment`.`id`, `task_comment`.`taskid`, `task_comment`.`accountid`, `task_comment`.`comment`, `task_comment`.`time`, `account`.`username`, `account`.`manager` FROM `task_comment` INNER JOIN `account` ON `account`.`id` = `task_comment`.`accountid` WHERE `task_comment`.`taskid` = ?");
        if ($rows) {
            foreach ($rows as $key => $row) {
                $rows[$key]['time-ago'] = Database::datetimeToTimeAgo($rows[$key]['time']);
            }
            return $rows;
        }
        else return null;
    }

    public static function selectLinkTypes() {
        $rows = self::selectStatic(null, "SELECT * FROM `link_type`");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectLinkType($typeID) {
        $rows = self::selectStatic(array($typeID), "SELECT * FROM `link_type` WHERE `link_type`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }
}