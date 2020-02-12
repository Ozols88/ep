<?php
require_once "database.php";

class Audio extends Database
{
    public function __construct($table = "audio")
    {
        parent::__construct($table);
    }

    public function selectAdminAudioList()
    {
        if (!isset($_GET['t'])) $_GET['t'] = 1;
        $rows = $this->select(array($_GET['t']), "SELECT * FROM `audio` WHERE `type` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getAudioTypeName($value['type']);
                $rows[$key]['reusable_name'] = $this->getAudioReusableName($value['reusable']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminAudio()
    {
        $row = $this->select(array($_GET['a']),"SELECT * FROM `audio` WHERE `id` = ?");
        return $row;
    }
}