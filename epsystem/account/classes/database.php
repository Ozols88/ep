<?php

class Database
{
    protected function connect() {
        static $conn;

        $dsn = 'mysql:host=localhost;dbname=epsystem;charset=utf8';
        $username = 'epsystemdbuser';
        $password = 'php159A';

        if (!$conn) {
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $conn;
    }
    protected static function connectStatic() {
        static $conn;

        $dsn = 'mysql:host=localhost;dbname=epsystem;charset=utf8';
        $username = 'epsystemdbuser';
        $password = 'php159A';

        if (!$conn) {
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $conn;
    }

    public function select($params, $sql) {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();
            return $data;
        }
        else
            return null;
    }
    public static function selectStatic($params, $sql) {
        $stmt = self::connectStatic()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();
            return $data;
        }
        else
            return null;
    }
    public static function selectNextNewID($table) {
        $rows = self::selectStatic(array($table), "SELECT T.AUTO_INCREMENT AS `id` FROM information_schema.TABLES T WHERE T.TABLE_SCHEMA = 'epsystem' AND T.TABLE_NAME = ?");
        return $rows[0][0];
    }

    public static function insert($table, $fields, $lastID, $redirect) {
        $implodeColumns = implode(', ', array_keys($fields));
        $implodePlaceholder = implode(", :", array_keys($fields));
        $sql = "INSERT INTO `$table` ($implodeColumns) VALUES (:" . $implodePlaceholder . ")";
        $stmt = self::connectStatic()->prepare($sql);
        foreach ($fields as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmtExec = $stmt->execute();

        if ($lastID) $id = self::connectStatic()->lastInsertId();

        if ($stmtExec && $redirect) {
            header('Location: ' . $redirect);
        }

        if (isset($id)) return $id;
        else return null;
    }

    public static function update($table, $id, $fields, $redirect) {
        foreach ($fields as $key => $value) {
            $value = addslashes($value); // For quotes inside strings
            if ($value != null)
                $valueSets[] = $key . " = '" . $value . "'";
            else
                $valueSets[] = $key . " = null";
        }
        $sql = "UPDATE `$table` SET " . join(", ", $valueSets) . " WHERE `id` = :id";
        $stmt = self::connectStatic()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmtExec = $stmt->execute();

        if ($stmtExec && $redirect) {
            header('Location: ' . $redirect);
        }
    }

    public static function remove($table, $id, $redirect) {
        $sql = "DELETE FROM `$table` WHERE `id` = :id";
        $stmt = self::connectStatic()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmtExec = $stmt->execute();

        if ($stmtExec && $redirect) {
            header('Location: ' . $redirect);
        }
    }

    public static function datetimeToDateWithoutSeconds($value) {
        if ($value)
            return date('d.m.Y', strtotime($value));
        else
            return "-";
    }
    public static function datetimeToDate($value) {
        if ($value)
            return date('d M Y', strtotime($value));
        else
            return "-";
    }
    public static function datetimeToTimeAgo($value) {
        $value = strtotime($value);
        $time = time() - $value;
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text. (($numberOfUnits>1)?'s':'') . ' ago';
        }
    }
    public static function datetimeToTime($value) {
        $value = strtotime($value);
        $time = time() - $value;
        $time = ($time<1)? 1 : $time;
        $tokens = array (
            31536000 => 'year',
            2592000 => 'month',
            604800 => 'week',
            86400 => 'day',
            3600 => 'hour',
            60 => 'minute',
            1 => 'second'
        );

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);
            return $numberOfUnits . ' ' . $text. (($numberOfUnits>1)?'s':'');
        }
    }
    public static function timeToSeconds($value) {
        sscanf($value, "%d:%d:%d", $hours, $minutes, $seconds);
        $time = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
        return $time;
    }

    public static function selectMembers() {
        $rows = self::selectStatic(null, "SELECT `account`.`id`, `account`.`username`, `account`.`description`, `account`.`online`, `account`.`last_activity`, `account`.`reg_time`, `account`.`status`, COUNT(`payment`.`id`) AS `payment_count`, ( SELECT COUNT(*) FROM `account_division` WHERE `account_division`.`accountid` = `account`.`id` ) AS `division_count`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '2' ) AS `asg_active`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '1' ) AS `asg_pending`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '3' ) AS `asg_completed`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '3' AND `status_assignment`.`status2` = '1' ) AS `asg_unpaid`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '3' AND `status_assignment`.`status2` = '2' ) AS `asg_paid` FROM `account` LEFT JOIN `payment` ON `account`.`id` = `payment`.`accountid` GROUP BY `account`.`id`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['reg_time_date'] = self::datetimeToDate($rows[$key]['reg_time']);

                if ($rows[$key]['status'] == 0)
                    $rows[$key]['status_txt'] = "Paused";
                elseif ($rows[$key]['status'] == 1)
                    $rows[$key]['status_txt'] = "Active";
                else
                    $rows[$key]['status_txt'] = "?";

                if (isset($value['last_activity'])) {
                    $activity = strtotime($value['last_activity']);
                    $rows[$key]['last_activity_timestamp'] = $activity;
                    if ($value['online'] == 1) {
                        $rows[$key]['last_online'] = "Currently";
                    }
                    else {
                        if ($activity < strtotime('-7 days'))
                            $rows[$key]['last_online'] = date('d M Y', strtotime($rows[$key]['last_activity']));
                        else
                            $rows[$key]['last_online'] = Database::datetimeToTimeAgo($rows[$key]['last_activity']);
                    }
                }
                else {
                    $rows[$key]['last_activity'] = "Never";
                    $rows[$key]['last_online'] = "Never";
                    $rows[$key]['last_activity_timestamp'] = 0;
                }

            }
            return $rows;
        }
        else return null;
    }
    public static function selectAccountByID($id) {
        $rows = self::selectStatic(array($id), "SELECT `account`.`id`, `account`.`username`, `account`.`password`, `account`.`manager`, `account`.`description`, `account`.`online`, `account`.`last_activity`, `account`.`reg_time`, `account`.`status`, ( SELECT COUNT(*) FROM `payment` WHERE `payment`.`accountid` = `account`.`id` ) AS `payment_count`, ( SELECT COUNT(*) FROM `account_division` WHERE `account_division`.`accountid` = `account`.`id` ) AS `divisions`, ( SELECT COUNT(DISTINCT `division`.`departid`) FROM `account_division` INNER JOIN `division` ON `division`.`id` = `account_division`.`divisionid` WHERE `account_division`.`accountid` = `account`.`id` ) AS `departments` FROM `account` WHERE `account`.`id` = ?");
        if ($rows[0]) {
            if ($rows[0]['status'] == 0)
                $rows[0]['status_txt'] = "Paused";
            else
                $rows[0]['status_txt'] = "Active";

            if ($rows[0]['manager'] == 0)
                $rows[0]['manager_txt'] = "MEMBER";
            else
                $rows[0]['manager_txt'] = "MANAGER";

            $rows[0]['reg_time2'] = date('d M Y', strtotime($rows[0]['reg_time']));
            $rows[0]['reg_time3'] = Database::datetimeToTime($rows[0]['reg_time']);
            return $rows[0];
        }
        else return null;
    }
    public static function selectMemberProgress($id) {
        $rows = self::selectStatic(array($id), "SELECT ( SELECT COUNT(DISTINCT `project`.`id`) FROM `project` INNER JOIN `assignment` ON `assignment`.`projectid` = `project`.`id` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` ) AS `projects`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `status_assignment`.`assigned_to` = `account`.`id` ) AS `assignments`, ( SELECT COUNT(*) FROM `task` INNER JOIN `status_task` ON `status_task`.`id` = `task`.`statusid` WHERE `status_task`.`assigned_to` = `account`.`id` ) AS `tasks`, ( SELECT COUNT(*) FROM `status_assignment` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '2' AND (`status_assignment`.`status2` = '1' OR `status_assignment`.`status2` = '2') ) AS `asg_accepted`, ( SELECT COUNT(*) FROM `status_assignment` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '3' ) AS `asg_completed`, ( SELECT COUNT(*) FROM `status_assignment` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '1' AND `status_assignment`.`status2` = '5' ) AS `asg_undone_accept`, ( SELECT COUNT(*) FROM `status_assignment` WHERE `status_assignment`.`assigned_to` = `account`.`id` AND `status_assignment`.`status1` = '1' AND `status_assignment`.`status2` = '3' ) AS `asg_canceled`, ( SELECT COUNT(*) FROM `status_task` WHERE `status_task`.`assigned_to` = `account`.`id` AND `status_task`.`status1` = '1' AND `status_task`.`status2` = '5' ) AS `task_submitted`, ( SELECT COUNT(*) FROM `status_task` WHERE `status_task`.`assigned_to` = `account`.`id` AND `status_task`.`status1` = '3' ) AS `task_completed`, ( SELECT COUNT(*) FROM `status_task` WHERE `status_task`.`assigned_to` = `account`.`id` AND `status_task`.`status1` = '1' AND `status_task`.`status2` = '4' ) AS `task_problem`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `status_assignment` ON `assignment`.`statusid` = `status_assignment`.`id` WHERE `assignment`.`assigned` = '1' AND `status_assignment`.`assigned_to` = `account`.`id` ) AS `assigned` FROM `account` WHERE `account`.`id` = ?");
        if ($rows[0]) {
            return $rows[0];
        }
        else return null;
    }
    public static function selectMemberTimeMoney($id) {
        $rows = self::selectStatic(array($id, $id, $id, $id, $id, $id, $id, $id, $id), "SELECT ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`estimated`))) FROM `task` INNER JOIN `status_task` ON `task`.`statusid` = `status_task`.`id` WHERE `status_task`.`assigned_to` = ? AND `status_task`.`status1` = '3' ) AS `time_invested`, ( SELECT COUNT(*) FROM `payment` WHERE `payment`.`accountid` = ? ) AS `payments`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND (`a`.`status1` = '1' AND `a`.`status2` BETWEEN '4' AND '5' OR (`a`.`status1` = '2' OR `a`.`status1` = '3')) ) AS `time_accepted`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND `a`.`status1` = '3' ) AS `time_completed`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND `a`.`status1` = '1' AND (`a`.`status2` = '2' OR `a`.`status2` = '3') ) AS `time_lost`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND (`a`.`status1` = '2' OR (`a`.`status1` = '1' AND (`a`.`status2` = '4' OR `a`.`status2` = '5'))) ) AS `money_possible_t`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND `a`.`status1` = '3' AND `status_assignment`.`status1` = '3' AND `status_assignment`.`status2` = '1' ) AS `money_pending_t`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` LEFT JOIN `assignment` ON `assignment`.`id` = `task`.`assignmentid` LEFT JOIN `status_assignment` ON `status_assignment`.`id` = `assignment`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND `a`.`status1` = '3' AND `status_assignment`.`status1` = '3' AND `status_assignment`.`status2` = '2' ) AS `money_paid_t`, ( SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(`task`.`estimated`))) FROM `status_task` `a` LEFT JOIN `status_task` `b` ON `a`.`taskid` = `b`.`taskid` AND `a`.`time` < `b`.`time` LEFT JOIN `task` ON `a`.`id` = `task`.`statusid` WHERE `b`.`id` IS NULL AND `a`.`assigned_to` = ? AND `a`.`status1` = '1' AND (`a`.`status2` = '2' OR `a`.`status2` = '3') ) AS `money_lost_t`");
        if ($rows[0]) {
            if (!$rows[0]['time_invested'])
                $rows[0]['time_invested'] = "00:00:00";
            if (!$rows[0]['time_accepted'])
                $rows[0]['time_accepted'] = "00:00:00";
            if (!$rows[0]['time_completed'])
                $rows[0]['time_completed'] = "00:00:00";
            if (!$rows[0]['time_lost'])
                $rows[0]['time_lost'] = "00:00:00";

            $rows[0]['time_invested-sec'] = Database::timeToSeconds($rows[0]['time_invested']);
            $rows[0]['earned'] = "€" . $rows[0]['time_invested-sec'] * 0.005;

            $rows[0]['money_possible_t'] = Database::timeToSeconds($rows[0]['money_possible_t']);
            $rows[0]['money_possible'] = "€" . $rows[0]['money_possible_t'] * 0.005;
            $rows[0]['money_pending_t'] = Database::timeToSeconds($rows[0]['money_pending_t']);
            $rows[0]['money_pending'] = "€" . $rows[0]['money_pending_t'] * 0.005;
            $rows[0]['money_paid_t'] = Database::timeToSeconds($rows[0]['money_paid_t']);
            $rows[0]['money_paid'] = "€" . $rows[0]['money_paid_t'] * 0.005;
            $rows[0]['money_lost_t'] = Database::timeToSeconds($rows[0]['money_lost_t']);
            $rows[0]['money_lost'] = "€" . $rows[0]['money_lost_t'] * 0.005;
            return $rows[0];
        }
        else return null;
    }
    public static function selectAccountsByDivision($id) {
        $rows = self::selectStatic(array($id), "SELECT `account`.`id`, `account`.`username`, `account`.`description`, `account`.`reg_time`, `account`.`status` FROM `account` INNER JOIN `account_division` ON `account`.`id` = `account_division`.`accountid` WHERE `account_division`.`divisionid` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['reg_time_date'] = self::datetimeToDate($rows[$key]['reg_time']);
            }
            return $rows;
        }
        else return null;
    }
    public static function selectAccountDivisions($id) {
        $rows = self::selectStatic(array($id), "SELECT `account_division`.`id`, `account_division`.`divisionid`, `division`.`departid`, `division`.`title`, `division`.`description`, `department`.`title` AS `department` FROM `account_division` INNER JOIN `division` ON `division`.`id` = `account_division`.`divisionid` INNER JOIN `department` ON `department`.`id` = `division`.`departid` WHERE `accountid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public static function selectInfoPageGroups() {
        $rows = self::selectStatic(null, "SELECT * FROM `infopage_group`");
        if ($rows) return $rows;
        else return null;
    }
    public static function selectInfoPageGroup($groupID) {
        $rows = self::selectStatic(array($groupID), "SELECT `infopage_group`.`id`, `infopage_group`.`title`, `infopage_group`.`description`, `infopage_group`.`date_created`, `infopage_group`.`date_updated`, `infopage_group`.`times_updated`, ( SELECT COUNT(*) FROM `project_infopage` WHERE `project_infopage`.`groupid` = `infopage_group`.`id` ) AS `links`, ( SELECT COUNT(*) FROM `preset-infopage` WHERE `preset-infopage`.`groupid` = `infopage_group`.`id` ) AS `presets` FROM `infopage_group` WHERE `infopage_group`.`id` = ?");
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
    public static function selectInfoPagePresets() {
        $rows = self::selectStatic(null, "SELECT `preset-infopage`.`id`, `preset-infopage`.`title`, `preset-infopage`.`description`, `infopage_group`.`title` AS `group` FROM `preset-infopage` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `preset-infopage`.`groupid`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rowsIDs[$value['id']] = $value;

                if (!$rowsIDs[$value['id']]['group'])
                    $rowsIDs[$value['id']]['group'] = "None";
            }
            return $rowsIDs;
        }
        else return null;
    }
    public static function selectInfoPagePreset($id) {
        $rows = self::selectStatic(array($id), "SELECT `preset-infopage`.`id`, `preset-infopage`.`title`, `preset-infopage`.`description`, `infopage_group`.`title` AS `group`, `preset-infopage`.`date_created`, `preset-infopage`.`date_updated`, `preset-infopage`.`times_updated`, ( SELECT COUNT(*) FROM `project_infopage` WHERE `project_infopage`.`presetid` = `preset-infopage`.`id` ) AS `projects`, ( SELECT COUNT(*) FROM `preset-task` WHERE `preset-task`.`infoid` = `preset-infopage`.`id` ) AS `task_presets` FROM `preset-infopage` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `preset-infopage`.`groupid` WHERE `preset-infopage`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['group'])
                $rows[0]['group'] = "None";
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
    public static function selectInfoPagePresetsByGroup($groupID) {
        $rows = self::selectStatic(array($groupID), "SELECT * FROM `preset-infopage` WHERE `preset-infopage`.`groupid` = ?");
        if ($rows) return $rows;
        else return null;
    }
}