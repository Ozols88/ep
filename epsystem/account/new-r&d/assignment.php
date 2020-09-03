<?php
$page = "r&d";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-assignment']))
            $_SESSION['new-assignment']['stage'] = '1';
        if (!isset($_SESSION['new-assignment']['info']['title']))
            $_SESSION['new-assignment']['info']['title'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-assignment']['stage'] == '1') {
                $_SESSION['new-assignment']['fields']['title'] = $_POST['title'];
                $_SESSION['new-assignment']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-assignment']['info']['title']) > 10)
                    $_SESSION['new-assignment']['info']['title'] = substr($_SESSION['new-assignment']['info']['title'], 0, 10) . "...";

                $_SESSION['new-assignment']['stage'] = '2';
                if (!isset($_SESSION['new-assignment']['info']['division']))
                    $_SESSION['new-assignment']['info']['division'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-assignment']['stage'] == '2') {
                $_SESSION['new-assignment']['fields']['divisionid'] = $_POST['division'];
                $_SESSION['new-assignment']['info']['division'] = Assignment::selectDivisionByID($_POST['division'])['title'];
                if (strlen($_SESSION['new-assignment']['info']['division']) > 10)
                    $_SESSION['new-assignment']['info']['division'] = substr($_SESSION['new-assignment']['info']['division'], 0, 10) . "...";

                $_SESSION['new-assignment']['stage'] = '3';
                if (!isset($_SESSION['new-assignment']['info']['objective']))
                    $_SESSION['new-assignment']['info']['objective'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-assignment']['stage'] == '3') {
                $_SESSION['new-assignment']['fields']['objective'] = $_POST['objective'];
                $_SESSION['new-assignment']['info']['objective'] = $_POST['objective'];
                if (strlen($_SESSION['new-assignment']['info']['objective']) > 10)
                    $_SESSION['new-assignment']['info']['objective'] = substr($_SESSION['new-assignment']['info']['objective'], 0, 10) . "...";
                $_SESSION['new-assignment']['stage'] = '3';

                if (!isset($_SESSION['new-assignment']['tasks']))
                    $_SESSION['new-assignment']['tasks'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-assignment']['stage'] == '4') {
                if (isset($_POST['new-task'])) {
                    $_SESSION['new-assignment']['new-task'] = true;
                    header('Location: task?f=' . $_GET['f']);
                }

                if ($_POST['submit'] == "SAVE") {
                    //task set

                    $_SESSION['new-assignment']['fields']['floorid'] = $_GET['f'];
                    $presetID = Database::insert('preset-assignment', $_SESSION['new-assignment']['fields'], true, null);

                    //task insert

                    unset($_SESSION['new-assignment']);
                    header('Location: ../r&d.php?a=' . $presetID);
                }
            }

            if (empty($_SESSION['new-assignment']['info']['title'])) $_SESSION['new-assignment']['stage'] = '1';
            elseif (empty($_SESSION['new-assignment']['info']['division'])) $_SESSION['new-assignment']['stage'] = '2';
            elseif (empty($_SESSION['new-assignment']['info']['objective'])) $_SESSION['new-assignment']['stage'] = '3';
            else $_SESSION['new-assignment']['stage'] = '4';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-assignment']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-assignment']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-assignment']['stage'] = '3';
        if (isset($_POST['stage4'])) $_SESSION['new-assignment']['stage'] = '4';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-assignment']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-assignment']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Enter Preset Name</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Preset Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="test" name="title" id="title" class="field admin" placeholder="Enter Preset Name Here" value="<?php if (isset($_SESSION['new-assignment']['fields']['title'])) echo $_SESSION['new-assignment']['fields']['title']; ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-assignment']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Select Division</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            $divisions = Assignment::selectDivisionsByFloor($_GET['f']);
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 35%">Name</div>
                    <div class="head admin" style="width: 50%">Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (isset($divisions)) { ?>
                <div class="table admin"> <?php
                    foreach ($divisions as $division) {
                        if ($division['division_id'] == "1")
                            continue;
                        else { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $division['division_id']); ?>" class="content"></div>
                                <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $division['division_title']; ?>" class="content"></div>
                                <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $division['division_desc']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                                <input type="hidden" name="division" value="<?php echo $division['division_id']; ?>">
                            </form> <?php
                        }
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO DIVISIONS</div> <?php
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Enter Objective</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension medium admin"></div>
                <div class="header medium">
                    <div class="head admin">Assignment Objective</div>
                </div>
                <div class="header-extension medium admin"></div>
            </div>
            </div>
            <div class="table medium">
                <div class="row">
                    <input form="test" name="objective" id="objective" class="field admin" placeholder="Enter Assignment Objective Here" value="<?php if (isset($_SESSION['new-assignment']['fields']['objective'])) echo $_SESSION['new-assignment']['fields']['objective']; ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Tasks</span>
            </div>
            <div class="navbar level-1 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="new-task">
                    <input type="submit" name="submit" value="+ New Task" class="button admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">Number</div>
                    <div class="head admin" style="width: 60%">Task Objective</div>
                    <div class="head admin" style="width: 25%">Action</div>
                    <div class="head admin" style="width: 7.5%">Remove</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (is_array($_SESSION['new-assignment']['tasks']) && count($_SESSION['new-assignment']['tasks']) > 0) { ?>
                <div class="table admin"> <?php
                    foreach ($_SESSION['new-assignment']['tasks'] as $num => $task) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $num; ?>" class="content"></div>
                            <div class="cell" style="width: 60%"><input type="submit" name="submit" value="<?php echo $task['fields']['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo $task['action']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                            <input type="hidden" name="del-task" value="<?php echo $num; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO TASKS</div> <?php
            }

        }

        require_once "../includes/footer.php";

    }
    else {
        header('Location: ../error.php');
    }
}
else require_once "../login.php";