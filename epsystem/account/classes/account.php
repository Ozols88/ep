<?php
require_once "database.php";

class Account extends Database
{
    public $loginStatus;
    public $id;
    public $username;
    private $password;
    public $type;

    public function __construct($fields, $table = "account")
    {
        parent::__construct($table);
        if (empty($fields['user']) || empty($fields['pass'])) {
            $this->loginStatus = 3;
        }
        else {
            $stmt = $this->connect()->prepare("SELECT `id`, `username`, `password`, `type` FROM `account` WHERE `username` = :username");
            $stmt->bindParam(':username', $fields['user']);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $userData = $stmt->fetch();
                if (password_verify($fields['pass'], $userData['password'])) {
                    header("Location: " . $_SERVER['REQUEST_URI']);
                    $this->id = $userData['id'];
                    $this->username = $userData['username'];
                    $this->password = $userData['password'];
                    $this->type = $userData['type'];
                    $this->loginStatus = 1;
                }
                else $this->loginStatus = 2;
            }
            else $this->loginStatus = 2;
        }
    }

    public function selectAdminAccountList()
    {
        $rows = $this->select(null, "SELECT `id`, `username` FROM `account`");
        return $rows;
    }

    public function selectAdminAccount()
    {
        $rows = $this->select(array($_GET['a']), "SELECT * FROM `account` WHERE account.id = ?");
        if ($rows) {
            $rows[0]['reg_date'] = $this->dateToDateWithoutSeconds($rows[0]['reg_time']);
            return $rows;
        }
        else return null;
    }

    public function selectArtistAccount()
    {
        $rows = $this->select(array($this->id), "SELECT * FROM `account` WHERE account.id = ?");
        if ($rows) {
            $rows[0]['reg_date'] = $this->dateToDateWithoutSeconds($rows[0]['reg_time']);
            return $rows;
        }
        else return null;
    }
}