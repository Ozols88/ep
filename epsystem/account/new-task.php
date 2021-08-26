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
                if (!isset($_SESSION['new-task']['link']))
                    $_SESSION['new-task']['link'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-task']['stage'] == '2c') {
                if (isset($_POST['link'])) {
                    $_SESSION['new-task']['fields']['infoid'] = $_POST['link'];
                    $_SESSION['new-task']['link'] = $_POST['linkName'];
                }
                else {
                    $_SESSION['new-task']['fields']['infoid'] = null;
                    $_SESSION['new-task']['link'] = "None";
                }

                $_SESSION['new-task']['stage'] = '3c';
                if (!isset($_SESSION['new-task']['description']))
                    $_SESSION['new-task']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-task']['stage'] == '3c') {
                $_SESSION['new-task']['fields']['description'] = $_POST['description'];
                $_SESSION['new-task']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-task']['fields']['description']) > InfobarCharLimit)
                    $_SESSION['new-task']['description'] = substr($_POST['description'], 0, InfobarCharLimit) . "...";

                $number = Task::RenumberTasksInAssignment($_SESSION['new-task']['fields']['assignmentid']);
                $_SESSION['new-task']['fields']['number'] = $number;
                $_SESSION['new-task']['fields']['name'] = "Custom Task";
                $taskID = Task::insert('task', $_SESSION['new-task']['fields'], true, false);

                if ($_SESSION['new-task']['assignment']['status1'] == 1 && ($_SESSION['new-task']['assignment']['status2'] == 10 || $_SESSION['new-task']['assignment']['status2'] == 11))
                    $fieldsStatus = [
                        'taskid' => $taskID,
                        'status1' => 2,
                        'status2' => 4,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id
                    ];
                else
                    $fieldsStatus = [
                        'taskid' => $taskID,
                        'status1' => 1,
                        'status2' => 1,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id
                    ];
                $statusID = Task::insert('status_task', $fieldsStatus, true, false);
                Task::update('task', $taskID, ["statusid" => $statusID], false);
                Assignment::assignmentStatusChanger($_SESSION['new-task']['assignment'], $account->id);

                header('Location: assignments.php?a=' . $_SESSION['new-task']['fields']['assignmentid'] . '&l1=tasks&l2=' . $taskID);
                unset($_SESSION['new-task']);
                exit();
            }

            if (empty($_SESSION['new-task']['time'])) $_SESSION['new-task']['stage'] = '1c';
            if (empty($_SESSION['new-task']['link'])) $_SESSION['new-task']['stage'] = '2c';
            else $_SESSION['new-task']['stage'] = '3c';
        }
        if (isset($_POST['stage1c'])) $_SESSION['new-task']['stage'] = '1c';
        if (isset($_POST['stage2c'])) $_SESSION['new-task']['stage'] = '2c';
        if (isset($_POST['stage3c'])) $_SESSION['new-task']['stage'] = '3c'; ?>

        <div class="menu"> <?php
        if ($_SESSION['new-task']['stage'] == '1c') { ?>
            <div class="head-up-display-bar">
                <span>New Custom Task</span>
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
                <span>New Custom Task</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Project Link Name</div>
                    <div class="head admin" style="width: 40%">Description</div>
                    <div class="head admin" style="width: 15%">Group</div>
                    <div class="head admin" style="width: 10%">Link</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            $projectID = Assignment::selectAssignmentByID($_SESSION['new-task']['fields']['assignmentid'])['projectid'];
            $infopages = Project::selectProjectInfoPages($projectID);
            if ($infopages) { ?>
                <div class="table admin"> <?php
                    foreach ($infopages as $info) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $info['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $info['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 40%"><input type="submit" name="submit" value="<?php echo $info['description']; ?>" class="content"></div>
                            <div class="cell group" style="width: 15%"><input type="submit" name="submit" value="<?php echo $info['group']; ?>" class="content"></div>
                            <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $info['hasLink']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="link" value="<?php echo $info['id']; ?>">
                            <input type="hidden" name="linkName" value="<?php echo $info['title']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO PROJECT LINKS</div> <?php
            }
        }
        elseif ($_SESSION['new-task']['stage'] == '3c') { ?>
            <div class="head-up-display-bar">
                <span>New Custom Task</span>
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
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Task Description Here" value="<?php if (isset($_SESSION['new-task']['fields']['description'])) echo htmlspecialchars($_SESSION['new-task']['fields']['description']); ?>">
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