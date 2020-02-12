<?php
require_once "database.php";

class Drawing extends Database
{
    public function __construct($table = "drawing")
    {
        parent::__construct($table);
    }

    public function selectAdminSubmittedDrawingList()
    {
        $rows = $this->select(null, "SELECT drawing.id, drawing.title, drawing.price, account.username, '*old*status.time', '*old*status.status', `*old*project`.id AS `id_project`, IFNULL(`*old*project`.title, '-') AS `project` FROM `*old*status` INNER JOIN `drawing` ON drawing.id = '*old*status.drawingid' INNER JOIN `account` ON account.id = drawing.accountid LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid WHERE `status` = '4'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $time2 = date('d M Y H:i', strtotime($value['time']));
                $rows[$key]['time2'] = $time2;
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminSubmittedDrawing()
    {
        $row = $this->select(array($_GET['d']), "SELECT drawing.title, drawing.type, drawing.complexity, drawing.tags, drawing.price, drawing.revision, drawing.comment, drawing.path_file, account.username, project.title AS `project`, project.deadline FROM `*old*status` INNER JOIN `drawing` ON drawing.id = '*old*status.drawingid' INNER JOIN `account` ON account.id = drawing.accountid LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid WHERE '*old*status.drawingid' = ?");
        $row[0]['type_name'] = $this->getDrawingTypeName($row[0]['type']);
        $row[0]['days_left'] = $this->dateToDays($row[0]['deadline']);
        $row[0]['deadline2'] = $this->dateToDateWithoutSeconds($row[0]['deadline']);
        return $row;
    }

    public function selectAdminActiveDrawingList()
    {
        $rows = $this->select(null, "SELECT drawing.id, project_drawing.projectid AS `id_project`, project.title AS `project`, drawing.title, drawing.price, IF(account.username IS NULL, '-', account.username) AS `username`, a.status, a.time FROM `drawing` LEFT JOIN `account` ON account.id = drawing.accountid LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE `status` = '2' OR `status` = '3' OR `status` = '6'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $time2 = date('d M Y H:i', strtotime($value['time']));
                $rows[$key]['time2'] = $time2;
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminActiveDrawing()
    {
        $row = $this->select(array($_GET['s']), "SELECT drawing.title, drawing.type, drawing.complexity, drawing.tags, drawing.price, drawing.revision, drawing.comment, drawing.path_file, account.username, project.title AS `project`, project.deadline FROM `*old*status` INNER JOIN `drawing` ON drawing.id = '*old*status.drawingid' INNER JOIN `account` ON account.id = drawing.accountid LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid WHERE '*old*status.drawingid' = ?");
        $row[0]['type_name'] = $this->getDrawingTypeName($row[0]['type']);
        $row[0]['days_left'] = $this->dateToDays($row[0]['deadline']);
        return $row;
    }

    public function selectAdminPastDrawingList()
    {
        $rows = $this->select(null, "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.price, drawing.revision, project.title AS `project`, '*old*status.time' FROM `drawing` INNER JOIN `account` ON account.id = drawing.accountid INNER JOIN `project_drawing` ON drawing.id = project_drawing.drawingid INNER JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid INNER JOIN `*old*status` ON drawing.id = '*old*status.drawingid' WHERE '*old*status.status' = '8'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
                if ($rows[$key]['revision'])
                    $rows[$key]['title_rev'] = $rows[$key]['title'] . " (rev " . $rows[$key]['revision'] . ")";
                else
                    $rows[$key]['title_rev'] = $rows[$key]['title'];
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminPastDrawing()
    {

    }

    public function selectAdminDrawingList()
    {
        if (!isset($_GET['t'])) $_GET['t'] = 1;
        $rows = $this->select(array($_GET['t']), "SELECT * FROM `drawing` WHERE `type` = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectAdminDrawing()
    {
        $rows = $this->select(array($_GET['d']), "SELECT drawing.id AS `drwid`, `title`, `type`, `complexity`, `tags`, `price`, `revision`, `comment`, `path_file`, account.id AS `artid`, IF(account.username IS NULL, 'Unassigned', account.username) AS `username` FROM `drawing` LEFT JOIN `account` ON account.id = drawing.accountid WHERE drawing.title = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
            }
        }
        return $rows;
    }

    public function selectAdminDrawingProjectUsages($id)
    {
        $rows = $this->select(array($id), "SELECT `*old*project`.title FROM `drawing` INNER JOIN `project_drawing` ON drawing.id = project_drawing.drawingid INNER JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid WHERE drawing.id = ?");
        return $rows;
    }

    public function selectArtistActiveDrawingList($artist)
    {
        $rows = $this->select(array($artist), "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.tags, drawing.price, drawing.revision, drawing.comment, IF(project.title IS NULL, '-', project.title) AS `project`, a.time, a.status FROM `drawing` LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE a.status = '3' OR a.status = '6'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDays($value['time']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectArtistSubmittedDrawingList($artist)
    {
        $rows = $this->select(array($artist), "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.tags, drawing.price, drawing.revision, drawing.comment, IF(project.title IS NULL, '-', project.title) AS `project`, a.time, a.status FROM `drawing` LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE a.status = '4'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectArtistRecentDrawingList($artist)
    {
        $rows = $this->select(array($artist), "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.tags, drawing.price, drawing.revision, drawing.comment, IF(project.title IS NULL, '-', project.title) AS `project`, a.time, a.status FROM `drawing` LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE a.status = '8' AND a.time >= DATE(NOW()) - INTERVAL 5 DAY");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['status_name'] = $this->getStatusName($value['status']);
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectArtistDrawing()
    {
        $rows = $this->select(array($_GET['d']), "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.price, drawing.revision, drawing.comment, drawing.description, IF(project.title IS NULL, '-', project.title) AS `project`, a.time FROM `drawing` LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE drawing.id = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectArtistDrawingExamples()
    {
        $rows = $this->select(array($_GET['d']), "SELECT * FROM `drawing_example` WHERE `drawingid` = ?");
        if ($rows) return $rows;
        else return null;
    }

    public function selectArtistAvailableDrawingList()
    {
        $rows = $this->select(null, "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.tags, drawing.price, drawing.revision, drawing.comment, IF(project.title IS NULL, '-', project.title) AS `project`, a.time, a.status FROM `drawing` LEFT JOIN `project_drawing` ON drawing.id = project_drawing.drawingid LEFT JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid LEFT JOIN `*old*status` a INNER JOIN ( SELECT `drawingid`, MAX(`time`) time FROM `*old*status` GROUP BY `drawingid` ) b ON a.drawingid = b.drawingid AND a.time = b.time ON drawing.id = a.drawingid WHERE a.status = '2'");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
            }
            return $rows;
        }
        else return null;
    }

    public function selectArtistCompletedDrawingList($artist)
    {
        $rows = $this->select(array($artist), "SELECT drawing.id, drawing.title, drawing.type, drawing.complexity, drawing.price, drawing.revision, project.title AS `project`, '*old*status.time' FROM `drawing` INNER JOIN `account` ON account.id = drawing.accountid INNER JOIN `project_drawing` ON drawing.id = project_drawing.drawingid INNER JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid INNER JOIN `*old*status` ON drawing.id = '*old*status.drawingid' WHERE '*old*status.status' = '8' AND account.id = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
                if ($rows[$key]['revision'])
                    $rows[$key]['title_rev'] = $rows[$key]['title'] . " (rev " . $rows[$key]['revision'] . ")";
                else
                    $rows[$key]['title_rev'] = $rows[$key]['title'];
            }
            return $rows;
        }
        else return null;
    }

    public function selectArtistCompletedDrawing()
    {
        $rows = $this->select(array($_GET['d']), "SELECT *, `*old*project`.title AS `project` FROM `drawing` INNER JOIN `account` ON account.id = drawing.accountid INNER JOIN `project_drawing` ON drawing.id = project_drawing.drawingid INNER JOIN `*old*project` ON `*old*project`.id = project_drawing.projectid INNER JOIN `*old*status` ON drawing.id = '*old*status.drawingid' WHERE status = '8' AND drawing.id = ?");
        if ($rows) {
            foreach ($rows as $key => $value) {
                $rows[$key]['deadline2'] = $this->dateToDateWithoutSeconds($value['deadline']);
                $rows[$key]['type_name'] = $this->getDrawingTypeName($value['type']);
                $rows[$key]['date'] = $this->dateToDateWithoutSeconds($value['time']);
            }
            return $rows;
        }
        else return null;
    }
}