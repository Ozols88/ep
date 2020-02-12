<?php

class Database
{
    public function __construct($table)
    {
        $this->table = $table;
    }

    public $loginStatuses = [
        1 => "Logged in!",
        2 => "Wrong data!",
        3 => "Fill in both fields!"
    ];
    public function getLoginStatusName()
    {
        return $this->loginStatuses[$this->loginStatus];
    }

    public $objectives = [
        0 => "Single",
        1 => "Multiple"
    ];
    public static $objectivesStatic = [
        0 => "Single",
        1 => "Multiple"
    ];
    public function getProjectObjectiveName($num)
    {
        if (isset($this->objectives[$num]))
            return $this->objectives[$num];
        else
            return "-";
    }
    public static function getProjectObjectiveNameStatic($num)
    {
        if (isset(self::$objectivesStatic[$num]))
            return self::$objectivesStatic[$num];
        else
            return "-";
    }

    public $drawingTypes = [
        1 => "Backgrounds",
        2 => "Characters",
        3 => "Assets",
        4 => "Special"
    ];
    public function getDrawingTypeName($num)
    {
        if (isset($this->drawingTypes[$num]))
            return $this->drawingTypes[$num];
        else
            return "Unknown";
    }

    public function dateToDays($date)
    {
        $date = strtotime($date);
        $diff = $date - time();
        $days = floor($diff / (60 * 60 * 24));
        return $days;
    }

    public function dateToDateWithoutSeconds($value)
    {
        if ($value)
            return date('d M Y', strtotime($value));
        else
            return "-";
    }

    protected function connect()
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=epa;charset=utf8", 'root', 'php159A');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
    protected static function connectStatic()
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=epa;charset=utf8", 'root', 'php159A');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
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

    public function insert($fields)
    {
        $implodeColumns = implode(', ', array_keys($fields));
        $implodePlaceholder = implode(", :", array_keys($fields));
        $sql = "INSERT INTO `$this->table` ($implodeColumns) VALUES (:" . $implodePlaceholder . ")";
        $stmt = $this->connect()->prepare($sql);
        foreach ($fields as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmtExec = $stmt->execute();
        if ($stmtExec) {
            header('Location: ' . $_SERVER['PHP_SELF']);
        } else {
            echo "Kļūda pievienojot datus!";
        }
    }

    public function update($id, $fields)
    {
        foreach ($fields as $key => $value) {
            $valueSets[] = $key . " = '" . $value . "'";
        }
        $sql = "UPDATE `$this->table` SET " . join(", ", $valueSets) . " WHERE `id` = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmtExec = $stmt->execute();
        if ($stmtExec) {
            header('Location: ' . $_SERVER['PHP_SELF']);
        } else {
            echo "Kļūda mainot datus!";
        }
    }

    public function remove($id)
    {
        $sql = "DELETE FROM `$this->table` WHERE `id` = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->bindValue(":id", $id);
        $stmtExec = $stmt->execute();
        if ($stmtExec) {
            header('Location: ' . $_SERVER['PHP_SELF']);
        } else {
            echo "Kļūda dzēšot datus!";
        }
    }
}