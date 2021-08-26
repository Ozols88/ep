<?php
require_once "database.php";

class Assignment extends Database
{
    public static function selectAssignmentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `assignment`.`id`, `assignment`.`title`, `assignment`.`projectid`, `project`.`title` AS `project`, `assignment`.`divisionid`, `assignment`.`presetid`, `preset-assignment`.`title` AS `preset`, `assignment`.`objective`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`assigned_to`, `status_assignment`.`assigned_by`, `project`.`productid`, `product`.`title` AS `product`, `division`.`title` AS `division`, `status_assignment`.`time` AS `status_time`, `division`.`departid`, `department`.`title` AS `department`, `account`.`username`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id`) AS `task_time`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks` FROM `assignment` LEFT JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `department` ON `department`.`id` = `division`.`departid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `status_assignment`.`assigned_to` WHERE `assignment`.`id` = ?");
        if ($rows[0]) {
            if ($rows[0]['divisionid'] == null)
                $rows[0]['division'] = "No Division";
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "No Assignment Preset";
            if ($rows[0]['departid'] == null)
                $rows[0]['department'] = "No Department";
            if (isset($rows[0]['status_time']))
                $rows[0]['time'] = date('d M Y', strtotime($rows[0]['status_time']));
            if ($rows[0]['task_time']) {
                $rows[0]['task_time-sec'] = Database::timeToSeconds($rows[0]['task_time']);
                $rows[0]['task_sum'] = $rows[0]['task_time-sec'] * 0.005;
            }
            else {
                $rows[0]['task_time'] = "00:00:00";
                $rows[0]['task_sum'] = 0;
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

    public static function selectAssignmentHistory($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `status_assignment` WHERE `status_assignment`.`assignmentid` = ? ORDER BY `status_assignment`.`time`");
        if (isset($rows)) {
            foreach ($rows as $key => $value) {
                if (isset($value['time'])) {
                    $rows[$key]['time_ago'] = Database::datetimeToTimeAgo($value['time']);
//                    if (strtotime($value['time']) < strtotime('-7 days'))
//                        $rows[$key]['time2'] = date('d M Y', strtotime($rows[$key]['time']));
//                    else
//                        $rows[$key]['time2'] = $rows[$key]['time_ago'];
                    $rows[$key]['time2'] = date('d M Y', strtotime($rows[$key]['time']));
                    $rows[$key]['time'] = date('d M Y', strtotime($rows[$key]['time']));
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectAssignmentPresetsByProjectPreset($prPresetID) {
        $rows = self::selectStatic(array($prPresetID), "SELECT `preset-project_assignment`.`id`, `preset-project_assignment`.`projectid`, `preset-project_assignment`.`assignmentid`, `preset-assignment`.`title`, `preset-assignment`.`objective`, `division`.`id` AS `div_id`, `division`.`title` AS `div_title`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-project_assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `preset-project_assignment`.`assignmentid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` WHERE `preset-project_assignment`.`projectid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['div_title'])
                    $rows[$key]['div_title'] = "None";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPresets() {
        $rows = self::selectStatic(null, "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, `preset-assignment`.`objective`, `preset-assignment`.`divisionid`, `division`.`title` AS `div_title`, `department`.`title` AS `depart_title`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-assignment` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` LEFT JOIN `department` ON `department`.`id` = `division`.`departid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['div_title'])
                    $rows[$key]['div_title'] = "None";
                if (!$rows[$key]['depart_title'])
                    $rows[$key]['depart_title'] = "None";
            }
            return $rows;
        }
        else return null;
    }
    public static function selectPresetByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, `preset-assignment`.`objective`, `preset-assignment`.`divisionid`, `division`.`title` AS `div_title`, `division`.departid, `preset-assignment`.`date_created`, `preset-assignment`.`date_updated`, `preset-assignment`.`times_updated`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`assignmentid` = `preset-assignment`.`id` ) AS `task_count`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`presetid` = `preset-assignment`.`id` ) AS `assignments`, ( SELECT COUNT(DISTINCT(`assignment`.`projectid`)) FROM `assignment` WHERE `assignment`.`presetid` = `preset-assignment`.`id` ) AS `projects`, ( SELECT COUNT(*) FROM `preset-project_assignment` WHERE `preset-project_assignment`.`assignmentid` = `preset-assignment`.`id` ) AS `prj_presets` FROM `preset-assignment` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` WHERE `preset-assignment`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['div_title'])
                $rows[0]['div_title'] = "None";
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
    public static function selectAssignmentPresetsByDivision($divID) {
        $rows = self::selectStatic(array($divID), "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`assignmentid` = `preset-assignment`.`id` ) AS `tasks` FROM `preset-assignment` WHERE `preset-assignment`.`divisionid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectDepartments() {
        $rows = self::selectStatic(null, "SELECT * FROM `department`");
        if ($rows) return $rows;
        else return null;
    }
    public static function selectDepartmentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `department`.`id`, `department`.`title`, `department`.`description`, `department`.`date_created`, `department`.`date_updated`, `department`.`times_updated`, ( SELECT COUNT(*) FROM `division` WHERE `division`.`departid` = `department`.`id` ) AS `divisions` FROM `department` WHERE `id` = ?");
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

    public static function selectDivisions() {
        $rows = self::selectStatic(null, "SELECT `division`.`id`, `division`.`departid`, `division`.`title`, `division`.`description`, `department`.`title` AS `department` FROM `division` LEFT JOIN `department` ON `department`.`id` = `division`.`departid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rowsIDs[$value['id']] = $value;

                if (!$rowsIDs[$value['id']]['department'])
                    $rowsIDs[$value['id']]['department'] = "None";
            }
            unset($rowsIDs[0]); // Remove custom division
            return $rowsIDs;
        }
        else return null;
    }
    public static function selectDivisionByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `division`.`id`, `division`.`title`, `division`.`description`, `division`.`departid`, `department`.`title` AS `department`, `division`.`date_created`, `division`.`date_updated`, `division`.`times_updated`, ( SELECT COUNT(*) FROM `account_division` WHERE `account_division`.`divisionid` = `division`.`id` ) AS `members`, ( SELECT COUNT(*) FROM `assignment` WHERE `assignment`.`divisionid` = `division`.`id` ) AS `assignments`, ( SELECT COUNT(*) FROM `preset-assignment` WHERE `preset-assignment`.`divisionid` = `division`.`id` ) AS `asg_presets` FROM `division` LEFT JOIN `department` ON `department`.`id` = `division`.`departid` WHERE `division`.`id` = ?");
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
    public static function selectDivisionsByDepart($departID) {
        $rows = self::selectStatic(array($departID), "SELECT * FROM `division` WHERE `division`.`departid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectProjectAssignments($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT `assignment`.`id`, `assignment`.`title`, `assignment`.`projectid`, `assignment`.`presetid`, `assignment`.`objective`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`time`, `status_assignment`.`assigned_by`, `status_assignment`.`assigned_to` FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectAvailableAssignments($account) {
        if ($account->status == 0)
            return null;
        $rows = self::selectStatic(null, "SELECT `assignment`.`id`, `assignment`.`title`, `assignment`.`objective`, `assignment`.`divisionid`, `division`.`title` AS `division`, `status_assignment`.`assigned_to`, `project`.`productid`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) AS `task_time` FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_time` FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `status_assignment`.`status1` = '1' AND `status_assignment`.`status2` BETWEEN '8' AND '9'");
        $rowsCopy = $rows;
        if ($rows) {
            $showOnlyAssigned = false;
            foreach ($rows as $num => $assignment) {
                if ($assignment['assigned_to'] == $account->id) {
                    $show = true;
                    $showOnlyAssigned = true;
                }
                else $show = false;
                if (!$show) unset($rows[$num]);
            }

            if (!$showOnlyAssigned) {
                $rows = $rowsCopy;
                foreach ($rows as $num => $assignment) {
                    if ($assignment['assigned_to'] == null) {
                        if ($assignment['divisionid'] == null || $assignment['divisionid'] == 0)
                            $show = true;
                        elseif ($account->divisions != null)
                            foreach ($account->divisions as $division) {
                                if ($division['divisionid'] == $assignment['divisionid']) {
                                    $show = true;
                                    break;
                                }
                            }
                        else $show = false;
                    }
                    else $show = false;
                    if (!$show) unset($rows[$num]);
                }
            }

            if (!$rows)
                return null;

            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";

                if (!$rows[$key]['task_time']) {
                    $rows[$key]['task_time'] = "00:00:00";
                    $rows[$key]['task_min'] = 0;
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectAssignmentListByStatusAndAccount($status, $account) {
        if ($status == "pending")
            $rows = self::selectStatic(array($account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `status_assignment`.`status1` = '1' AND `status_assignment`.`assigned_to` = ?");
        if ($status == "active")
            $rows = self::selectStatic(array($account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `status_assignment`.`status1` = '2' AND `status_assignment`.`assigned_to` = ?");
        if ($status == "completed")
            $rows = self::selectStatic(array($account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `status_assignment`.`status1` = '3' AND `status_assignment`.`assigned_to` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($rows[$key]['status1'] == '3' && $rows[$key]['status2'] == '2')
                    $rows[$key]['paid_txt'] = "Yes";
                else
                    $rows[$key]['paid_txt'] = "No";

                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";

                if (!$rows[$key]['time']) {
                    $rows[$key]['time'] = "-";
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectUnpaidCompletedAssignmentsByAccount($account) {
        $rows = self::selectStatic(array($account), "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `product`.`title` AS `product`, `division`.`title` AS `division`, `status_assignment`.`note` AS `status_note`, `status_assignment`.`time` AS `status_time`, ( SELECT `account`.`username` FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `status_assignment`.`assigned_to` WHERE `status_assignment`.`assignmentid` = `a`.`id` ) AS `member`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id` ) AS `tasks`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`task`.`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `a`.`id` ) AS `task_time` FROM `assignment` `a` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `status_assignment`.`status1` = '3' AND `status_assignment`.`status2` = '1' AND `status_assignment`.`assigned_to` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rowsIDs[$value['assignment_id']] = $value;

                if (!$rowsIDs[$value['assignment_id']]['division'])
                    $rowsIDs[$value['assignment_id']]['division'] = "None";

                $rowsIDs[$value['assignment_id']]['status_time-ago'] = Database::datetimeToTimeAgo($rowsIDs[$value['assignment_id']]['status_time']);

                if (strtotime($rowsIDs[$value['assignment_id']]['status_time']) < strtotime('-7 days'))
                    $rowsIDs[$value['assignment_id']]['status_time2'] = Database::datetimeToDate($rowsIDs[$value['assignment_id']]['status_time']);
                else
                    $rowsIDs[$value['assignment_id']]['status_time2'] = $rowsIDs[$value['assignment_id']]['status_time-ago'];


                $rowsIDs[$value['assignment_id']]['status_time'] = Database::datetimeToDate($rowsIDs[$value['assignment_id']]['status_time']);

                if (!$rowsIDs[$value['assignment_id']]['member'])
                    $rowsIDs[$value['assignment_id']]['member'] = "-";

                $rowsIDs[$value['assignment_id']]['seconds'] = Database::timeToSeconds($rowsIDs[$value['assignment_id']]['task_time']);
                $rowsIDs[$value['assignment_id']]['earned'] = $rowsIDs[$value['assignment_id']]['seconds'] * 0.005;
            }
            return $rowsIDs;
        }
        else return null;
    }

    public static function selectProjectAssignmentsByStatus($projectID, $status, $account) {
        if ($status == "pending") // Includes pending, new, available
            $rows = self::selectStatic(array($projectID), "SELECT `assignment`.`id` AS `assignment_id`, `assignment`.`title`, `assignment`.`objective`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`assigned_to`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = ? AND `status_assignment`.`status1` = '1'");
        elseif ($status == "active")
            $rows = self::selectStatic(array($projectID), "SELECT `assignment`.`id` AS `assignment_id`, `assignment`.`title`, `assignment`.`objective`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`assigned_to`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = ? AND `status_assignment`.`status1` = '2'");
        elseif ($status == "completed")
            $rows = self::selectStatic(array($projectID), "SELECT `assignment`.`id` AS `assignment_id`, `assignment`.`title`, `assignment`.`objective`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`time` AS `status_time`, `status_assignment`.`assigned_to`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = ? AND `status_assignment`.`status1` = '3'");
        else
            $rows = null;

        if ($rows) {
            if ($account->manager != 1) {
                foreach ($rows as $num => $assignment) {
                    if ($assignment['assigned_to'] != $account->id)
                        unset($rows[$num]);
                }
            }

            foreach ($rows as $key => $value) {
                if (!isset($rows[$key]['time']))
                    $rows[$key]['time'] = "-";

                if (isset($value['earn']))
                    $rows[$key]['earn'] .= "€";
                else
                    $rows[$key]['earn'] = "0€";

                if (isset($value['status_time'])) {
                    $rows[$key]['status_time_ago'] = Database::datetimeToTimeAgo($value['status_time']);
                    if (strtotime($value['status_time']) < strtotime('-7 days'))
                        $rows[$key]['status_time2'] = date('d M Y', strtotime($rows[$key]['status_time']));
                    else
                        $rows[$key]['status_time2'] = $rows[$key]['status_time_ago'];
                    $rows[$key]['status_time'] = date('d M Y', strtotime($rows[$key]['status_time']));
                }

                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";

                if (!$rows[$key]['note'] && $rows[$key]['status1'] == 1) {
                    if ($rows[$key]['status2'] == 1)
                        $rows[$key]['note'] = "New assignment";
                    if ($rows[$key]['status2'] == 2)
                        $rows[$key]['note'] = "All tasks removed";
                    if ($rows[$key]['status2'] == 3)
                        $rows[$key]['note'] = "Canceled by manager";
                    if ($rows[$key]['status2'] == 4)
                        $rows[$key]['note'] = "Undone available";
                    if ($rows[$key]['status2'] == 5)
                        $rows[$key]['note'] = "Undone accept";
                    if ($rows[$key]['status2'] == 6)
                        $rows[$key]['note'] = "Assignment shown";
                    if ($rows[$key]['status2'] == 7)
                        $rows[$key]['note'] = "Assignment hidden";
                    if ($rows[$key]['status2'] == 8)
                        $rows[$key]['note'] = "Made available";
                    if ($rows[$key]['status2'] == 9)
                        $rows[$key]['note'] = "Assigned to member";
                    if ($rows[$key]['status2'] == 10)
                        $rows[$key]['note'] = "Task problem";
                    if ($rows[$key]['status2'] == 11)
                        $rows[$key]['note'] = "All tasks ready";
                }
            }
            return $rows;
        }
        else return null;
    }

    public static function selectCurrentProjectAssignmentsByStatus($status) {
        if ($status == "pending")
            $rows = self::selectStatic(null, "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `preset-assignment`.`title` AS `asg_preset`, `product`.`title` AS `product`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`time` AS `status_time`, (SELECT `account`.`username` FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `status_assignment`.`assigned_to` WHERE `status_assignment`.`assignmentid` = `a`.`id`) AS `member`, (SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `tasks`, (SELECT SUM(`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `time`, (SELECT SUM(`task`.`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_time` FROM `assignment` `a` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `a`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `status_assignment`.`status1` = '1' AND (`status_assignment`.`status2` != '8' AND `status_assignment`.`status2` != '9')");
        if ($status == "available")
            $rows = self::selectStatic(null, "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `preset-assignment`.`title` AS `asg_preset`, `product`.`title` AS `product`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`time` AS `status_time`, (SELECT `account`.`username` FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `status_assignment`.`assigned_to` WHERE `status_assignment`.`assignmentid` = `a`.`id`) AS `member`, (SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `tasks`, (SELECT SUM(`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `time`, (SELECT SUM(`task`.`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_time` FROM `assignment` `a` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `a`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `status_assignment`.`status1` = '1' AND (`status_assignment`.`status2` = '8' OR `status_assignment`.`status2` = '9')");
        if ($status == "active")
            $rows = self::selectStatic(null, "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `preset-assignment`.`title` AS `asg_preset`, `product`.`title` AS `product`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`time` AS `status_time`, (SELECT `account`.`username` FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `status_assignment`.`assigned_to` WHERE `status_assignment`.`assignmentid` = `a`.`id`) AS `member`, (SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `tasks`, (SELECT SUM(`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `time`, (SELECT SUM(`task`.`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_time` FROM `assignment` `a` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `a`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `status_assignment`.`status1` = '2'");
        if ($status == "completed")
            $rows = self::selectStatic(null, "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `preset-assignment`.`title` AS `asg_preset`, `product`.`title` AS `product`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, `status_assignment`.`note`, `status_assignment`.`time` AS `status_time`, (SELECT `account`.`username` FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `status_assignment`.`assigned_to` WHERE `status_assignment`.`assignmentid` = `a`.`id`) AS `member`, (SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `tasks`, (SELECT SUM(`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `time`, (SELECT SUM(`task`.`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_time` FROM `assignment` `a` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `a`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `status_project` ON `status_project`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `status_assignment`.`status1` = '3'");

        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($rows[$key]['status1'] == '3' && $rows[$key]['status2'] == '2')
                    $rows[$key]['paid_txt'] = "Yes";
                else
                    $rows[$key]['paid_txt'] = "No";

                if (!$rows[$key]['product'])
                    $rows[$key]['product'] = "None";
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";

                if (isset($value['status_time'])) {
                    $rows[$key]['status_time_ago'] = Database::datetimeToTimeAgo($value['status_time']);
                    if (strtotime($value['status_time']) < strtotime('-7 days'))
                        $rows[$key]['status_time2'] = date('d M Y', strtotime($rows[$key]['status_time']));
                    else
                        $rows[$key]['status_time2'] = $rows[$key]['status_time_ago'];
                    $rows[$key]['status_time'] = date('d M Y', strtotime($rows[$key]['status_time']));
                }

                if (!$rows[$key]['member'])
                    $rows[$key]['member'] = "-";

                $rows[$key]['time'] = date('i', strtotime($rows[$key]['time'])) . " min";

                if (!$rows[$key]['note'] && $rows[$key]['status1'] == 1) {
                    if ($rows[$key]['status2'] == 1)
                        $rows[$key]['note'] = "New assignment";
                    if ($rows[$key]['status2'] == 2)
                        $rows[$key]['note'] = "All tasks removed";
                    if ($rows[$key]['status2'] == 3)
                        $rows[$key]['note'] = "Canceled by manager";
                    if ($rows[$key]['status2'] == 4)
                        $rows[$key]['note'] = "Undone available";
                    if ($rows[$key]['status2'] == 5)
                        $rows[$key]['note'] = "Undone accept";
                    if ($rows[$key]['status2'] == 6)
                        $rows[$key]['note'] = "Assignment shown";
                    if ($rows[$key]['status2'] == 7)
                        $rows[$key]['note'] = "Assignment hidden";
                    if ($rows[$key]['status2'] == 8)
                        $rows[$key]['note'] = "Made available";
                    if ($rows[$key]['status2'] == 9)
                        $rows[$key]['note'] = "Assigned to member";
                    if ($rows[$key]['status2'] == 10)
                        $rows[$key]['note'] = "Task problem";
                    if ($rows[$key]['status2'] == 11)
                        $rows[$key]['note'] = "All tasks ready";
                }

                if ($rows[$key]['task_time']) {
                    $rows[$key]['task_sum'] = $rows[$key]['task_time'] * 0.15 . "€";
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

    public static function assignmentStatusChanger($assignment, $accountID) {
        // Function changes assignment status to pending(problem)/pending(submitted)/in progress according to task statuses
        $tasks = Task::selectAssignmentTasks($assignment['id']);
        if ($tasks) {
            $problem = false;
            $allSubmitted = true;
            foreach ($tasks as $task) {
                if ($task['status1'] == 1 && $task['status2'] == 4)
                    $problem = true;
                if ($task['status2'] != 5 && $task['status1'] != 3)
                    $allSubmitted = false;
            }
            if ($problem) {
                // Pending - task problem
                if ($assignment['status1'] == 1 && $assignment['status2'] == 10)
                    return;
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'status1' => 1,
                    'status2' => 10,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to']
                ];

                $statusID = Assignment::insert('status_assignment', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
            }
            elseif ($allSubmitted) {
                // Pending - all tasks submitted
                if ($assignment['status1'] == 1 && $assignment['status2'] == 11)
                    return;
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'status1' => 1,
                    'status2' => 11,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to']
                ];

                $statusID = Assignment::insert('status_assignment', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
            }
            elseif ($assignment['status1'] == 1 && $assignment['status2'] == 10) {
                // In progress - after resolving task problem
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'status1' => 2,
                    'status2' => 3,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to']
                ];

                $statusID = Assignment::insert('status_assignment', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
            }
            elseif ($assignment['status1'] == 1 && $assignment['status2'] == 11) {
                // In progress - added new task
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'status1' => 2,
                    'status2' => 4,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to']
                ];

                $statusID = Assignment::insert('status_assignment', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
            }
        }
        else {
            // Pending - all tasks removed
            if ($assignment['status1'] == 1 && $assignment['status2'] == 2)
                return;
            $fields = [
                'assignmentid' => $assignment['id'],
                'status1' => 1,
                'status2' => 2,
                'time' => date("Y-m-d H-i-s"),
                'assigned_by' => $accountID,
                'assigned_to' => $assignment['assigned_to']
            ];

            $statusID = Assignment::insert('status_assignment', $fields, true, false);
            self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
        }
    }

    public static function selectPayments() {
        $rows = self::selectStatic(null, "SELECT `payment`.`id`, `payment`.`accountid`, `payment`.`description`, `payment`.`value`, `payment`.`time`, `account`.`username`, ( SELECT COUNT(*) FROM `payment_assignment` WHERE `payment_assignment`.`paymentid` = `payment`.`id` ) AS `assignment_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` INNER JOIN `payment_assignment` ON `assignment`.`id` = `payment_assignment`.`assignmentid` WHERE `assignment`.`presetid` IS NOT NULL AND `payment_assignment`.`paymentid` = `payment`.`id` ) AS `asg_time` FROM `payment` INNER JOIN `account` ON `account`.`id` = `payment`.`accountid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['date'] = Database::datetimeToDate($rows[$key]['time']);
                $rows[$key]['total'] = $rows[$key]['value'];
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPaymentsByAccount($id) {
        $rows = self::selectStatic(array($id), "SELECT `payment`.`id`, `payment`.`accountid`, `payment`.`description`, `payment`.`value`, `payment`.`time`, `account`.`username`, ( SELECT COUNT(*) FROM `payment_assignment` WHERE `payment_assignment`.`paymentid` = `payment`.`id` ) AS `assignment_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `task` INNER JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` INNER JOIN `payment_assignment` ON `assignment`.`id` = `payment_assignment`.`assignmentid` WHERE `assignment`.`presetid` IS NOT NULL AND `payment_assignment`.`paymentid` = `payment`.`id` ) AS `asg_time` FROM `payment` INNER JOIN `account` ON `account`.`id` = `payment`.`accountid` WHERE `account`.`id` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['date'] = Database::datetimeToDate($rows[$key]['time']);
                $rows[$key]['total'] = $rows[$key]['value'];
            }
            return $rows;
        }
        else return null;
    }

    public static function selectPaymentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `payment`.`id`, `payment`.`accountid`, `payment`.`description`, `payment`.`value`, `payment`.`time`, `account`.`username` FROM `payment` LEFT JOIN `account` ON `account`.`id` = `payment`.`accountid` WHERE `payment`.`id` = ?");
        if ($rows[0]) {
            $rows[0]['time2'] = date('d M Y', strtotime($rows[0]['time']));
            return $rows[0];
        }
        else return null;
    }

    public static function selectPaymentAssignments($id) {
        $rows = self::selectStatic(array($id), "SELECT `payment_assignment`.`id`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `preset-assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `project`.`title` AS `project_name`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `payment_assignment` INNER JOIN `payment` ON `payment`.`id` = `payment_assignment`.`paymentid` INNER JOIN `assignment` ON `assignment`.`id` = `payment_assignment`.`assignmentid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` WHERE `payment`.`id` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";
                if (!$rows[$key]['time'])
                    $rows[$key]['time'] = "00:00:00";
            }
            return $rows;
        }
        else return null;
    }

    public static function selectAssignmentListByAccount($account) {
        $rows = self::selectStatic(array($account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `preset-assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `status_assignment`.`status1`, `status_assignment`.`status2`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `status_assignment`.`assigned_to` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";

                if (!$rows[$key]['time']) {
                    $rows[$key]['time'] = "00:00:00";
                }

                if ($rows[$key]['status1'] == 1)
                    $rows[$key]['status'] = "Pending";
                elseif ($rows[$key]['status1'] == 2)
                    $rows[$key]['status'] = "Active";
                elseif ($rows[$key]['status1'] == 3 && $rows[$key]['status2'] == 1)
                    $rows[$key]['status'] = "Completed";
                elseif ($rows[$key]['status1'] == 3 && $rows[$key]['status2'] == 2)
                    $rows[$key]['status'] = "Paid";
                else
                    $rows[$key]['status'] = "?";
            }
            return $rows;
        }
        else return null;
    }

    public static function assignmentDivisionCheck($asgDiv, $accountDivs) {
        if ($asgDiv == null || $asgDiv == 0)
            return true;
        else {
            if ($accountDivs)
                foreach ($accountDivs as $div)
                    if ($asgDiv == $div['divisionid'])
                        return true;
            return false;
        }
    }
}