<?php
require_once "database.php";

class Account extends Database
{
    public $loginStatus;
    public $id;
    public $username;
    private $password;
    public $manager;
    public $divisions;
    public $status;
    public $lastRefresh;

    public function __construct($fields) {
        if (empty($fields['user']) || empty($fields['pass'])) {
            $this->loginStatus = 3;
        }
        else {
            $stmt = $this->connect()->prepare("SELECT * FROM `account` WHERE `username` = :username");
            $stmt->bindParam(':username', $fields['user']);
            $stmt->execute();
            if ($stmt->rowCount() == 1) {
                $userData = $stmt->fetch();
                if (password_verify($fields['pass'], $userData['password'])) {
                    $this->id = $userData['id'];
                    $this->username = $userData['username'];
                    $this->password = $userData['password'];
                    $this->manager = $userData['manager'];
                    $this->status = $userData['status'];
                    $this->divisions = self::selectStatic(array($userData['id']), "SELECT * FROM `account_division` WHERE `accountid` = ?");
                    $this->loginStatus = 1;
                    $this->lastRefresh = time();
                    Database::update('account', $userData['id'], ['online' => 1, 'last_activity' => date("Y-m-d H-i-s")], false);
                    header("Location: " . $_SERVER['REQUEST_URI']);
                }
                else $this->loginStatus = 2;
            }
            else $this->loginStatus = 2;
        }
    }

    public $loginStatuses = [
        1 => "LOGGED IN",
        2 => "WRONG NAME OR PASSWORD",
        3 => "FILL IN BOTH FIELDS",
    ];
    public function getLoginStatusName() {
        return $this->loginStatuses[$this->loginStatus];
    }
}