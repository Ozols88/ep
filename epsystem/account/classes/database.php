<?php

class Database
{
    protected function connect()
    {
        static $conn;

        $dsn = 'mysql:host=localhost;dbname=epa;charset=utf8';
        $username = 'root';
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

        $dsn = 'mysql:host=localhost;dbname=epa;charset=utf8';
        $username = 'root';
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
    public static function selectNextNewID($table)
    {
        $rows = self::selectStatic(array($table), "SELECT T.AUTO_INCREMENT AS `id` FROM information_schema.TABLES T WHERE T.TABLE_SCHEMA = 'epa' AND T.TABLE_NAME = '$table'");
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
            $valueSets[] = $key . " = '" . $value . "'";
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

    public static function datetimeToDays($date)
    {
        $date = strtotime($date);
        $diff = $date - time();
        $days = floor($diff / (60 * 60 * 24));
        return $days;
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
    public static function datetimeToMinutes($value)
    {
        if ($value)
            return date('i', strtotime($value));
        else
            return "-";
    }

    public static function selectMembers() {
        $rows = self::selectStatic(null, "SELECT `account`.`id`, `account`.`username`, `account`.`reg_time` FROM `account`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['reg_time_date'] = self::datetimeToDate($rows[$key]['reg_time']);
            }
            return $rows;
        }
        else return null;
    }
    public static function selectManagers() {
        $rows = self::selectStatic(null, "SELECT `account`.`id`, `account`.`username`, `account`.`reg_time` FROM `account` WHERE `account`.`manager` = '1'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['reg_time_date'] = self::datetimeToDate($rows[$key]['reg_time']);
            }
            return $rows;
        }
        else return null;
    }
    public static function selectClients() {
        $rows = self::selectStatic(null, "SELECT `account`.`id`, `account`.`username`, `account`.`reg_time`, COUNT(`project`.`id`) AS `project_count` FROM `account` LEFT JOIN `project` ON `account`.`id` = `project`.`clientid` WHERE `account`.`client` = '1' GROUP BY `account`.`id`");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['reg_time_date'] = self::datetimeToDateWithoutSeconds($rows[$key]['reg_time']);
            }
            return $rows;
        }
        else return null;
    }

    public static function selectAccountByID($id) {
        $rows = self::selectStatic(array($id), "SELECT * FROM `account` WHERE `id` = ?");
        if ($rows[0]) return $rows[0];
        else return null;
    }
}