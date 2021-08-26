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
        $rows = self::selectStatic(array($assignmentID), "SELECT `task`.`id`, `task`.`assignmentid`, `task`.`presetid`, `task`.`name`, `task`.`description`, `task`.`number`, `task`.`estimated`, `status_task`.`status1`, `status_task`.`status2`, `status_task`.`time`, `status_task`.`assigned_by`, `status_task`.`note`, ( SELECT COUNT(*) FROM `task_link` WHERE `task_link`.`taskid` = `task`.`id` ) AS `links`, ( SELECT COUNT(*) FROM `task_comment` WHERE `task_comment`.`taskid` = `task`.`id` ) AS `comments` FROM `task` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` WHERE `task`.`assignmentid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['estimated'])
                    $rows[$key]['estimated'] = "-";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectProjectTasks($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT * FROM `task` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `assignment`.`projectid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT `preset-task`.`id`, `preset-task`.`assignmentid`, `preset-task`.`name`, `preset-task`.`description`, `preset-task`.`estimated`, `preset-task`.`infoid`, `preset-assignment`.`title` AS `asg-title`, `preset-assignment`.`divisionid`, `division`.`title` AS `division`, ( SELECT COUNT(*) FROM `preset-task_links` WHERE `preset-task_links`.`taskid` = `preset-task`.`id` ) AS `links` FROM `preset-task` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `preset-task`.`assignmentid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";
                if (!$rows[$key]['assignmentid'])
                    $rows[$key]['asg-title'] = "None";
            }
            return $rows;
        }
        else return null;
    }
    public static function selectTaskPreset($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `preset-task`.`id`, `preset-task`.`assignmentid`, `preset-task`.`name`, `preset-task`.`description`, `preset-task`.`estimated`, `preset-task`.`infoid`, `preset-infopage`.`title` AS `info-title`, `preset-infopage`.`description` AS `info-desc`, `preset-task`.`date_created`, `preset-task`.`date_updated`, `preset-task`.`times_updated`, ( SELECT COUNT(*) FROM `preset-task_links` WHERE `preset-task_links`.`taskid` = `preset-task`.`id` ) AS `links`, `preset-assignment`.`title` AS `assignment`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`presetid` = `preset-task`.`id` ) AS `task_count` FROM `preset-task` LEFT JOIN `preset-infopage` ON `preset-infopage`.`id` = `preset-task`.`infoid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `preset-task`.`assignmentid` WHERE `preset-task`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['assignmentid'])
                $rows[0]['assignment'] = "None";
            if (!$rows[0]['info-title'])
                $rows[0]['info-title'] = "None";
            if ($rows[0]['infoid'])
                $rows[0]['project_link_preset'] = "Yes";
            else
                $rows[0]['project_link_preset'] = "No";

            if ($rows[0]['date_created']) {
                $rows[0]['date_created_ago'] = Database::datetimeToTimeAgo($rows[0]['date_created']);
                if (strtotime($rows[0]['date_created']) < strtotime('-7 days'))
                    $rows[0]['date_created_time2'] = date('d M Y', strtotime($rows[0]['date_created']));
                else
                    $rows[0]['date_created_time2'] = $rows[0]['date_created_ago'];
                $rows[0]['date_created_time'] = date('d M Y', strtotime($rows[0]['date_created']));
            }
            if ($rows[0]['date_updated']) {
                $rows[0]['date_updated_ago'] = Database::datetimeToTimeAgo($rows[0]['date_updated']);
                if (strtotime($rows[0]['date_updated']) < strtotime('-7 days'))
                    $rows[0]['date_updated_time2'] = date('d M Y', strtotime($rows[0]['date_updated']));
                else
                    $rows[0]['date_updated_time2'] = $rows[0]['date_updated_ago'];
                $rows[0]['date_updated_time'] = date('d M Y', strtotime($rows[0]['date_updated']));
            }
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
                $rows[$key]['linkWithNone'] = $rows[$key]['link'];
                if (!$rows[$key]['link'])
                    $rows[$key]['linkWithNone'] = "None";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectTask($taskID) {
        $rows = self::selectStatic(array($taskID), "SELECT `task`.`id`, `task`.`name`, `task`.`assignmentid`, `assignment`.`presetid` AS `asg-presetid`, `task`.`presetid`, `preset-task`.`name` AS `preset`, `task`.`description`, `task`.`number`, `task`.`infoid`, `task`.`estimated`, `status_task`.`status1`, `status_task`.`status2`, `status_task`.`time` AS `status_time`, `status_task`.`assigned_by`, `status_task`.`note`, `project_infopage`.`title`, `project_infopage`.`link`, `project_infopage`.`description` AS `info_description`, ( SELECT COUNT(*) FROM `task_link` WHERE `task_link`.`taskid` = `task`.`id` ) AS `links`, ( SELECT COUNT(*) FROM `task_comment` WHERE `task_comment`.`taskid` = `task`.`id` ) AS `comments`, ( SELECT COUNT(*) FROM `task_comment` LEFT JOIN `account` ON `account`.`id` = `task_comment`.`accountid` WHERE `task_comment`.`taskid` = `task`.`id` AND `account`.`manager` = '1' ) AS `manager_comments`, ( SELECT COUNT(*) FROM `task_comment` LEFT JOIN `account` ON `account`.`id` = `task_comment`.`accountid` WHERE `task_comment`.`taskid` = `task`.`id` AND `account`.`manager` != '1' ) AS `member_comments` FROM `task` LEFT JOIN `preset-task` ON `preset-task`.`id` = `task`.`presetid` LEFT JOIN `project_infopage` ON `project_infopage`.`id` = `task`.`infoid` LEFT JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` WHERE `task`.`id` = ?");
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

            if ($rows[0]['status1'] == 1)
                $rows[0]['status'] = "Pending";
            elseif ($rows[0]['status1'] == 2)
                $rows[0]['status'] = "In Progress";
            elseif ($rows[0]['status1'] == 3)
                $rows[0]['status'] = "Completed";
            else
                $rows[0]['status'] = "?";

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
        $rows = self::selectStatic(array($typeID), "SELECT `link_type`.`id`, `link_type`.`title`, `link_type`.`description`, `link_type`.`date_created`, `link_type`.`date_updated`, `link_type`.`times_updated`, ( SELECT COUNT(*) FROM `task_link` WHERE `task_link`.`typeid` = `link_type`.`id` ) AS `tasks`, ( SELECT COUNT(*) FROM `preset-task_links` WHERE `preset-task_links`.`typeid` = `link_type`.`id` ) AS `presets` FROM `link_type` WHERE `link_type`.`id` = ?");
        if ($rows[0]) {
            if ($rows[0]['date_created']) {
                $rows[0]['date_created_ago'] = Database::datetimeToTimeAgo($rows[0]['date_created']);
                if (strtotime($rows[0]['date_created']) < strtotime('-7 days'))
                    $rows[0]['date_created_time2'] = date('d M Y', strtotime($rows[0]['date_created']));
                else
                    $rows[0]['date_created_time2'] = $rows[0]['date_created_ago'];
                $rows[0]['date_created_time'] = date('d M Y', strtotime($rows[0]['date_created']));
            }
            if ($rows[0]['date_updated']) {
                $rows[0]['date_updated_ago'] = Database::datetimeToTimeAgo($rows[0]['date_updated']);
                if (strtotime($rows[0]['date_updated']) < strtotime('-7 days'))
                    $rows[0]['date_updated_time2'] = date('d M Y', strtotime($rows[0]['date_updated']));
                else
                    $rows[0]['date_updated_time2'] = $rows[0]['date_updated_ago'];
                $rows[0]['date_updated_time'] = date('d M Y', strtotime($rows[0]['date_updated']));
            }
            return $rows[0];
        }
        else return null;
    }
}