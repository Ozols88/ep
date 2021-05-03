<?php
require_once "database.php";

class Assignment extends Database
{
    public static function selectAssignmentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `assignment`.`id`, `assignment`.`title`, `assignment`.`projectid`, `project`.`title` AS `project`, `assignment`.`divisionid`, `assignment`.`presetid`, `preset-assignment`.`title` AS `preset`, `assignment`.`objective`, `status`.`id` AS `status_id`, `status`.`title` AS `status`, `assignment_status`.`assigned_to`, `assignment_status`.`assigned_by`, `project`.`productid`, `product`.`title` AS `product`, `division`.`title` AS `division`, `assignment_status`.`time` AS `status_time`, `department`.`title` AS `department`, `account`.`username`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id`) AS `task_time`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks` FROM `assignment` LEFT JOIN `project` ON `project`.`id` = `assignment`.`projectid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `department` ON `department`.`id` = `division`.`departid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `status` ON `status`.`id` = `assignment_status`.`statusid` LEFT JOIN `account` ON `account`.`id` = `assignment_status`.`assigned_to` WHERE `assignment`.`id` = ?");
        if ($rows[0]) {
            if (!$rows[0]['divisionid'])
                $rows[0]['division'] = "Custom";
            if (!$rows[0]['preset'])
                $rows[0]['preset'] = "None";
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
        $rows = self::selectStatic(null, "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, `preset-assignment`.`objective`, `preset-assignment`.`divisionid`, `division`.`title` AS `div_title`, `department`.`title` AS `depart_title`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-assignment` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` LEFT JOIN `department` ON `department`.`id` = `division`.departid");
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
        $rows = self::selectStatic(array($id), "SELECT `preset-assignment`.`id`, `preset-assignment`.`title`, `preset-assignment`.`objective`, `preset-assignment`.`divisionid`, `division`.`title` AS `div_title`, `division`.departid, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`assignmentid` = `preset-assignment`.`id` ) AS `task_count` FROM `preset-assignment` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` WHERE `preset-assignment`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['div_title'])
                $rows[0]['div_title'] = "None";
            return $rows[0];
        }
        else return null;
    }

    public static function selectDivisions() {
        $rows = self::selectStatic(null, "SELECT `division`.`id`, `division`.departid, `division`.`title`, `division`.`description`, department.`title` AS `department` FROM `division` LEFT JOIN department ON department.`id` = `division`.departid");
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

    public static function selectDivisionsByDepartment($departID) {
        $rows = self::selectStatic(array($departID), "SELECT * FROM `division` WHERE `division`.departid = ?");
        if ($rows) {
            foreach ($rows as $row) {
                $rowsIDs[$row['id']] = $row;
            }
            return $rowsIDs;
        }
        else return null;
    }

    public static function selectDepartments() {
        $rows = self::selectStatic(null, "SELECT * FROM department");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectDivisionByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `division`.`id`, `division`.`title`, `division`.`description`, `division`.`departid`, `department`.`title` AS `department` FROM `division` LEFT JOIN `department` ON `department`.`id` = `division`.`departid` WHERE `division`.`id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectDepartmentByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM department WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectProjectAssignments($projectID) {
        $rows = self::selectStatic(array($projectID), "SELECT assignment.`id`, assignment.`title`, assignment.`projectid`, assignment.`presetid`, assignment.`objective`, `assignment_status`.`statusid`, `assignment_status`.`time`, `assignment_status`.`assigned_by`, `assignment_status`.`assigned_to`, `assignment_status`.`note` FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectAvailableAssignments($account) {
        if ($account->status == 0)
            return null;
        $rows = self::selectStatic(null, "SELECT assignment.`id`, assignment.`title`, `assignment`.`objective`, `assignment`.`divisionid`, `division`.`title` AS `division`, `assignment_status`.`assigned_to`, `project`.productid, ( SELECT COUNT(*) FROM task WHERE task.`assignmentid` = assignment.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) AS `task_time` FROM task WHERE task.`assignmentid` = assignment.`id` ) AS `task_time` FROM assignment LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = assignment.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = assignment.`projectid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` WHERE `assignment_status`.`statusid` = '3'");
        if ($rows) {
            // Remove assignments which member cannot open
            $show = false;
            foreach ($rows as $num => $assignment) {
                // If assigned to member
                if ($assignment['assigned_to'] == $account->id)
                    $show = true;
                // divisions check
                elseif ($assignment['assigned_to'] == null) {
                    if ($account->divisions != null)
                        foreach ($account->divisions as $division) {
                            if ($division['divisionid'] == $assignment['divisionid']) {
                                $show = true;
                                break;
                            }
                        }
                    elseif ($assignment['divisionid'] == null || $assignment['divisionid'] == 0)
                        $show = true;
                }

                // Remove assignment from list if member doesn't have required division or if assignment isn't directly assigned to him
                if (!$show)
                    unset($rows[$num]);
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
        $rows = self::selectStatic(array($status, $account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `assignment_status`.`statusid`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `assignment_status`.`statusid` = ? AND `assignment_status`.`assigned_to` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($rows[$key]['statusid'] == '9')
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

    public static function SelectUnpaidCompletedAssignmentsByAccount($account) {
        $rows = self::selectStatic(array($account), "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `product`.`title` AS `product`, `division`.`title` AS `division`, `assignment_status`.`note` AS `status_note`, `assignment_status`.`time` AS `status_time`, ( SELECT `account`.`username` FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `assignment_status`.`assigned_to` WHERE `assignment_status`.`assignmentid` = `a`.`id` ) AS `member`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id` ) AS `tasks`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`task`.`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `a`.`id` ) AS `task_time` FROM `assignment` `a` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `assignment_status`.`statusid` = '7' AND `assignment_status`.`assigned_to` = ?");
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
            $rows = self::selectStatic(array($projectID), "SELECT `assignment`.`id` AS `assignment_id`, `assignment`.`title`, `assignment`.`objective`, `division`.`title` AS `division`, `assignment_status`.`note`, `assignment_status`.`assigned_to`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment`.`projectid` = ? AND (`assignment_status`.`statusid` = '1' OR `assignment_status`.`statusid` = '2' OR `assignment_status`.`statusid` = '3' OR `assignment_status`.`statusid` = '5' OR `assignment_status`.`statusid` = '6')");
        elseif ($status == "active")
            $rows = self::selectStatic(array($projectID), "SELECT assignment.`id` AS `assignment_id`, assignment.`title`, assignment.`objective`, `division`.`title` AS `division`, `assignment_status`.`assigned_to`, ( SELECT COUNT(*) FROM task WHERE task.`assignmentid` = assignment.`id` ) AS `tasks`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = assignment.`id` ) AS `time` FROM assignment LEFT JOIN `preset-assignment` ON `preset-assignment`.id = assignment.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = ? AND `assignment_status`.`statusid` = '4'");
        elseif ($status == "completed")
            $rows = self::selectStatic(array($projectID), "SELECT assignment.`id` AS `assignment_id`, assignment.`title`, assignment.`objective`, `division`.`title` AS `division`, `assignment_status`.`time` AS `status_time`, `assignment_status`.`assigned_to`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `tasks` FROM `assignment` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = assignment.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = assignment.`statusid` WHERE assignment.`projectid` = ? AND (`assignment_status`.`statusid` = '7' OR `assignment_status`.`statusid` = '9')");
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
            }
            return $rows;
        }
        else return null;
    }

    public static function selectCurrentProjectAssignmentsByStatus($status)
    {
        $rows = self::selectStatic(array($status), "SELECT `a`.`id` AS `assignment_id`, `a`.`title` AS `assignment_name`, `project`.`title` AS `project`, `preset-assignment`.`title` AS `asg_preset`, `product`.`title` AS `product`, `division`.`title` AS `division`, `assignment_status`.`statusid`, `assignment_status`.`note` AS `status_note`, `assignment_status`.`time` AS `status_time`, (SELECT `account`.`username` FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `account` ON `account`.`id` = `assignment_status`.`assigned_to` WHERE `assignment_status`.`assignmentid` = `a`.`id`) AS `member`, (SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `tasks`, (SELECT SUM(`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `time`, (SELECT SUM(`task`.`estimated`) FROM `task` WHERE `task`.`assignmentid` = `a`.`id`) AS `task_time` FROM `assignment` `a` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `a`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.`id` = `a`.`presetid` LEFT JOIN `division` ON `division`.`id` = `a`.`divisionid` INNER JOIN `project` ON `project`.`id` = `a`.`projectid` LEFT JOIN `project_status` ON `project_status`.`id` = `project`.`statusid` LEFT JOIN `preset-project` ON `preset-project`.`id` = `project`.`presetid` LEFT JOIN `product` ON `product`.`id` = `project`.`productid` WHERE `assignment_status`.`statusid` = ? AND (`project_status`.`statusid` = '6' OR `project_status`.`statusid` = '4' OR `project_status`.`statusid` = '7' OR `project_status`.`statusid` = '8')");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if ($rows[$key]['statusid'] == '9')
                    $rows[$key]['paid_txt'] = "Yes";
                else
                    $rows[$key]['paid_txt'] = "No";

                if (!$rows[$key]['asg_preset'])
                    $rows[$key]['asg_preset'] = "Custom Assignment";
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

    public static function insertAssignmentStatus($assignmentID, $status, $assigned_by, $assigned_to, $note) {
        $fields = [
            'assignmentid' => $assignmentID,
            'statusid' => $status,
            'time' => date("Y-m-d H-i-s"),
            'assigned_by' => $assigned_by,
            'assigned_to' => $assigned_to,
            'note' => $note
        ];
        $insertedID = self::insert('assignment_status', $fields, true, null);
        self::update('assignment', $assignmentID, ['statusid' => $insertedID], $_SERVER['REQUEST_URI']);
    }

    public static function assignmentStatusChanger($assignment, $accountID) {
        // Function changes assignment status to pending(problem)/pending(submitted)/in progress according to task statuses
        if ($assignment['status_id'] == 1 || $assignment['status_id'] == 2)
            return;
        $tasks = Task::selectAssignmentTasks($assignment['id']);
        if ($tasks) {
            // Pending(problem) check
            $change = false;
            foreach ($tasks as $task)
                if ($task['statusid'] == 5) {
                    $change = true;
                    break;
                }
            if ($assignment['status_id'] == 5 && $change == true)
                return;

            if ($change) {
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'statusid' => 5,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to'],
                    'note' => "Task problem"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
                return;
            }

            // Pending(submitted) check
            $change = true;
            foreach ($tasks as $task)
                if ($task['statusid'] != 6 && $task['statusid'] != 7) {
                    $change = false;
                    break;
                }
            if ($assignment['status_id'] == 6 && $change == true)
                return;

            if ($change) {
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'statusid' => 6,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to'],
                    'note' => "All tasks ready"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
                return;
            }

            // In progress check
            $change = true;
            foreach ($tasks as $task)
                if ($task['statusid'] == 5) {
                    $change = false;
                    break;
                }
            if ($assignment['status_id'] == 4 && $change == true)
                return;

            if ($change) {
                $fields = [
                    'assignmentid' => $assignment['id'],
                    'statusid' => 4,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $accountID,
                    'assigned_to' => $assignment['assigned_to'],
                    'note' => "Assignment resumed"
                ];

                $statusID = Assignment::insert('assignment_status', $fields, true, false);
                self::update('assignment', $assignment['id'], ["statusid" => $statusID], false);
                return;
            }
        }
        else {
            $fields = [
                'assignmentid' => $assignment['id'],
                'statusid' => 5,
                'time' => date("Y-m-d H-i-s"),
                'assigned_by' => $accountID,
                'assigned_to' => $assignment['assigned_to'],
                'note' => "No tasks left"
            ];

            $statusID = Assignment::insert('assignment_status', $fields, true, false);
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
        $rows = self::selectStatic(array($id), "SELECT * FROM `payment` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }

    public static function selectPaymentAssignments($id) {
        $rows = self::selectStatic(array($id), "SELECT `payment_assignment`.`id`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `preset-assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `project`.`title` AS `project_name`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `payment_assignment` INNER JOIN `payment` ON `payment`.`id` = `payment_assignment`.`paymentid` INNER JOIN `assignment` ON `assignment`.`id` = `payment_assignment`.`assignmentid` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `preset-assignment`.`divisionid` INNER JOIN `project` ON `project`.`id` = `assignment`.`projectid` WHERE `payment`.`id` = ?");
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
        $rows = self::selectStatic(array($account), "SELECT `assignment`.`projectid` AS `project_id`, `preset-project`.`title` AS `project_preset`, `assignment`.`id` AS `assignment_id`, `assignment`.`title` AS `assignment_name`, `assignment`.`objective`, `preset-assignment`.`divisionid` AS `division_id`, `division`.`title` AS `division`, `assignment_status`.`statusid`, ( SELECT COUNT(*) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `task_count`, ( SELECT SEC_TO_TIME(SUM(time_to_sec(`estimated`))) FROM `task` WHERE `task`.`assignmentid` = `assignment`.`id` ) AS `time` FROM `assignment` LEFT JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` LEFT JOIN `preset-assignment` ON `preset-assignment`.id = `assignment`.`presetid` LEFT JOIN `division` ON `division`.`id` = `assignment`.`divisionid` INNER JOIN `project` ON `project`.id = `assignment`.`projectid` LEFT JOIN `preset-project` ON `preset-project`.id = `project`.`presetid` WHERE `assignment_status`.`assigned_to` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                if (!$rows[$key]['division'])
                    $rows[$key]['division'] = "None";

                if (!$rows[$key]['time']) {
                    $rows[$key]['time'] = "00:00:00";
                }

                if ($rows[$key]['statusid'] == 1 || $rows[$key]['statusid'] == 2 || $rows[$key]['statusid'] == 3 || $rows[$key]['statusid'] == 5 || $rows[$key]['statusid'] == 6)
                    $rows[$key]['status'] = "Pending";
                elseif ($rows[$key]['statusid'] == 4)
                    $rows[$key]['status'] = "Active";
                elseif ($rows[$key]['statusid'] == 7)
                    $rows[$key]['status'] = "Completed";
                elseif ($rows[$key]['statusid'] == 9)
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