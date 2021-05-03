<?php
$page = "assignments";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-task']['fields']['assignmentid']))
            header('Location: assignments.php');

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-task']['stage'] == '1c') {
                if (isset($_POST['time'])) {
                    $time = gmdate("H:i:s", $_POST['time']);
                    $_SESSION['new-task']['fields']['estimated'] = $time;
                    $_SESSION['new-task']['time'] = $time;
                    $_SESSION['new-task']['time-sec'] = $_POST['time'];
                }
                else {
                    $_SESSION['new-task']['fields']['estimated'] = null;
                    $_SESSION['new-task']['time'] = "None";
                    $_SESSION['new-task']['time-sec'] = 10;
                }

                $_SESSION['new-task']['stage'] = '2c';
                if (!isset($_SESSION['new-task']['description']))
                    $_SESSION['new-task']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-task']['stage'] == '2c') {
                $_SESSION['new-task']['fields']['description'] = $_POST['description'];
                $_SESSION['new-task']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-task']['fields']['description']) > InfobarCharLimit)
                    $_SESSION['new-task']['description'] = substr($_POST['description'], 0, InfobarCharLimit) . "...";

                $number = Task::RenumberTasksInAssignment($_SESSION['new-task']['fields']['assignmentid']);
                $_SESSION['new-task']['fields']['number'] = $number;
                $_SESSION['new-task']['fields']['name'] = "Custom Task";
                $taskID = Task::insert('task', $_SESSION['new-task']['fields'], true, false);

                if ($_SESSION['new-task']['assignment']['status_id'] == 5 || $_SESSION['new-task']['assignment']['status_id'] == 6)
                    $fieldsStatus = [
                        'taskid' => $taskID,
                        'statusid' => 4,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'note' => "New Task"
                    ];
                else
                    $fieldsStatus = [
                        'taskid' => $taskID,
                        'statusid' => 1,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'note' => "New Task"
                    ];
                $statusID = Task::insert('task_status', $fieldsStatus, true, false);
                Task::update('task', $taskID, ["statusid" => $statusID], false);
                Assignment::assignmentStatusChanger($_SESSION['new-task']['assignment'], $account->id);

                header('Location: assignments.php?a=' . $_SESSION['new-task']['fields']['assignmentid'] . '&l1=tasks&l2=' . $taskID);
                unset($_SESSION['new-task']);
                exit();
            }

            if (empty($_SESSION['new-task']['time'])) $_SESSION['new-task']['stage'] = '1c';
            else $_SESSION['new-task']['stage'] = '2c';
        }
        if (isset($_POST['stage1c'])) $_SESSION['new-task']['stage'] = '1c';
        if (isset($_POST['stage2c'])) $_SESSION['new-task']['stage'] = '2c'; ?>

        <div class="menu"> <?php
        if ($_SESSION['new-task']['stage'] == '1c') { ?>
            <div class="head-up-display-bar">
                <span>+ New Task: Enter Time</span>
            </div>
            <div class="navbar level-1 unselected">
                <form id="none" name="none" method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form id="time" name="time" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Task Time</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="time" name="time" id="time" type="number" min="10" max="7200" class="field admin" placeholder="Enter Task Time (seconds) Here" value="<?php if (isset($_SESSION['new-task']['time-sec'])) echo $_SESSION['new-task']['time-sec']; else echo "10"; ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-task']['stage'] == '2c') { ?>
            <div class="head-up-display-bar">
                <span>+ New Task: Enter Description</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="description" name="description" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Task Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Task Description Here" value="<?php if (isset($_SESSION['new-task']['fields']['description'])) echo $_SESSION['new-task']['fields']['description']; ?>">
                </div>
            </div> <?php
        }

        require_once "includes/footer.php";

    }
    else {
        header('Location: error.php');
    }
}
else require_once "login.php";