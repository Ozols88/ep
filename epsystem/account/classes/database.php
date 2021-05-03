<?php

class Database
{
    protected function connect()
    {
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
    protected static function connectStatic()
    {
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

    public function select($params, $sql)
    {
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute($params);
        if ($stmt->rowCount() > 0) {
            $data = $stmt->fetchAll();
            return $data;
        }
        else
            return null;
    }
    public static function selectStatic($params, $sql)
    {
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

    public static function insert($table, $fields, $lastID, $redirect)
    {
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

    public static function update($table, $id, $fields, $redirect)
    {
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

    public static function remove($table, $id, $redirect)
    {
        $sql = "DELETE FROM `$table` WHERE `id` = :id";
        $stmt = self::connectStatic()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmtExec = $stmt->execute();

        if ($stmtExec && $redirect) {
            header('Location: ' . $redirect);
        }
    }

    public static function datetimeToDateWithoutSeconds($value)
    {
        if ($value)
            return date('d.m.Y', strtotime($value));
        else
            return "-";
    }
    public static function datetimeToDate($value)
    {
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
    public static function timeToSeconds($value) {
        sscanf($value, "%d:%d:%d", $hours, $minutes, $seconds);
        $time = isset($hours) ? $hours * 3600 + $minutes * 60 + $seconds : $minutes * 60 + $seconds;
        return $time;
    }

    public static function selectMembers() {
        $rows = self::selectStatic(null, "SELECT `account`.`id`, `account`.`username`, `account`.`description`, `account`.`online`, `account`.`last_activity`, `account`.`reg_time`, `account`.`status`, COUNT(`payment`.`id`) AS `payment_count`, ( SELECT COUNT(*) FROM `account_division` WHERE `account_division`.`accountid` = `account`.`id` ) AS `division_count`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`assigned_to` = `account`.`id` AND `assignment_status`.`statusid` = '4' ) AS `asg_active`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`assigned_to` = `account`.`id` AND (`assignment_status`.`statusid` = '3' OR `assignment_status`.`statusid` = '5' OR `assignment_status`.`statusid` = '6') ) AS `asg_pending`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`assigned_to` = `account`.`id` AND (`assignment_status`.`statusid` = '7' OR `assignment_status`.`statusid` = '9') ) AS `asg_completed`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`assigned_to` = `account`.`id` AND `assignment_status`.`statusid` = '7' ) AS `asg_unpaid`, ( SELECT COUNT(*) FROM `assignment` INNER JOIN `assignment_status` ON `assignment_status`.`id` = `assignment`.`statusid` WHERE `assignment_status`.`assigned_to` = `account`.`id` AND `assignment_status`.`statusid` = '9' ) AS `asg_paid` FROM `account` LEFT JOIN `payment` ON `account`.`id` = `payment`.`accountid` GROUP BY `account`.`id`");
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
        $rows = self::selectStatic(array($id), "SELECT `account`.`id`, `account`.`username`, `account`.`password`, `account`.`manager`, `account`.`description`, `account`.`online`, `account`.`last_activity`, `account`.`reg_time`, `account`.`status`, ( SELECT COUNT(*) FROM `account_division` WHERE `account_division`.`accountid` = `account`.`id` ) AS `divisions` FROM `account` WHERE `account`.`id` = ?");
        if ($rows[0]) return $rows[0];
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
        $rows = self::selectStatic(array($groupID), "SELECT * FROM `infopage_group` WHERE `infopage_group`.`id` = ?");
        if ($rows[0]) return $rows[0];
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
        $rows = self::selectStatic(array($id), "SELECT `preset-infopage`.`id`, `preset-infopage`.`title`, `preset-infopage`.`description`, `infopage_group`.`title` AS `group` FROM `preset-infopage` LEFT JOIN `infopage_group` ON `infopage_group`.`id` = `preset-infopage`.`groupid` WHERE `preset-infopage`.`id` = ?");
        if (isset($rows[0])) {
            if (!$rows[0]['group'])
                $rows[0]['group'] = "None";
            return $rows[0];
        }
        else return null;
    }
}