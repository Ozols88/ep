<?php
$page = "r&d";
include "../includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-project']))
            $_SESSION['new-project']['stage'] = '1';
        if (!isset($_SESSION['new-project']['info']['title']))
            $_SESSION['new-project']['info']['title'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-project']['stage'] == '1') {
                $_SESSION['new-project']['fields']['title'] = $_POST['title'];
                $_SESSION['new-project']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-project']['info']['title']) > 10)
                    $_SESSION['new-project']['info']['title'] = substr($_SESSION['new-project']['info']['title'], 0, 10) . "...";

                $_SESSION['new-project']['stage'] = '2';
                if (!isset($_SESSION['new-project']['info']['description']))
                    $_SESSION['new-project']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-project']['stage'] == '2') {
                $_SESSION['new-project']['fields']['description'] = $_POST['description'];
                $_SESSION['new-project']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-project']['info']['description']) > 10)
                    $_SESSION['new-project']['info']['description'] = substr($_SESSION['new-project']['info']['description'], 0, 10) . "...";

                $_SESSION['new-project']['stage'] = '3';
                if (!isset($_SESSION['new-project']['assignments']))
                    $_SESSION['new-project']['assignments'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-project']['stage'] == '3') {
                if (isset($_POST['add-assignment-page']))
                    $_SESSION['new-project']['add-assignment-page'] = true;

                if (isset($_POST['add-asg'])) {
                    if ($_SESSION['new-project']['assignments'] == "")
                        $_SESSION['new-project']['assignments'] = null;
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']] = Assignment::selectPresetByID($_POST['add-asg']);
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']++]['fields']['assignmentid'] = Assignment::selectPresetByID($_POST['add-asg'])['id'];
                    unset($_SESSION['new-project']['add-assignment-page']);
                    header("Refresh:0");
                }
                if (isset($_POST['del-asg'])) {
                    unset($_SESSION['new-project']['assignments'][$_POST['del-asg']]);
                }

                if ($_POST['submit'] == "SAVE") {
                    $_SESSION['new-project']['fields']['floorid'] = $_GET['f'];
                    $presetID = Database::insert('preset-project', $_SESSION['new-project']['fields'], true, null);

                    $asgNumber = 1;
                    foreach ($_SESSION['new-project']['assignments'] as $asg) {
                        $fieldsAsg = [
                            'projectid' => $presetID,
                            'assignmentid' => $asg['fields']['assignmentid']
                        ];
                        Project::insert('preset-project_assignment', $fieldsAsg, false, null);
                        $asgNumber++;
                    }

                    unset($_SESSION['new-project']);
                    header('Location: ../r&d.php?p=' . $presetID);
                }
            }

            if (empty($_SESSION['new-project']['info']['title'])) $_SESSION['new-project']['stage'] = '1';
            elseif (empty($_SESSION['new-project']['info']['description'])) $_SESSION['new-project']['stage'] = '2';
            else $_SESSION['new-project']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-project']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-project']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-project']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-project']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-project']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Enter Preset Name</span>
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
                    <input form="test" name="title" id="title" class="field admin" placeholder="Enter Preset Name Here" value="<?php if (isset($_SESSION['new-project']['fields']['title'])) echo $_SESSION['new-project']['fields']['title']; ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-project']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Enter Description</span>
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
                    <div class="head admin">Project Description</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="test" name="description" id="description" class="field admin" placeholder="Enter Project Description Here" value="<?php if (isset($_SESSION['new-project']['fields']['description'])) echo $_SESSION['new-project']['fields']['description']; ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-project']['stage'] == '3') {
            if (!isset($_SESSION['new-project']['add-assignment-page'])) { ?>
                <div class="head-up-display-bar">
                    <span>+ New Project: Assignments</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="add-assignment-page">
                        <input type="submit" name="submit" value="+ ADD ASSIGNMENT" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                    </form>
                </div> <?php
                include_once "../includes/info-bar.php"; ?>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Preset Name</div>
                        <div class="head admin" style="width: 35%">Objective</div>
                        <div class="head admin" style="width: 20%">Division</div>
                        <div class="head admin" style="width: 10%">Tasks</div>
                        <div class="head admin" style="width: 7.5%">Remove</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if (is_array($_SESSION['new-project']['assignments']) && count($_SESSION['new-project']['assignments']) > 0) {
                        foreach ($_SESSION['new-project']['assignments'] as $num => $assignment) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $num; ?>" class="content"></div>
                                <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['title']; ?>" class="content"></div>
                                <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $assignment['objective']; ?>" class="content"></div>
                                <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['div_title']; ?>" class="content"></div>
                                <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $assignment['task_count']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                <input type="hidden" name="del-asg" value="<?php echo $num; ?>">
                            </form> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="head-up-display-bar">
                    <span>+ New Project: Add Assignment</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form class="container-button disabled">
                        <input class="button admin-menu disabled">
                    </form>
                </div> <?php
                include_once "../includes/info-bar.php"; ?>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Preset Name</div>
                        <div class="head admin" style="width: 35%">Objective</div>
                        <div class="head admin" style="width: 20%">Division</div>
                        <div class="head admin" style="width: 10%">Tasks</div>
                        <div class="head admin" style="width: 7.5%">Add</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    $presets = Assignment::selectAssignmentPresetsByFloor($_GET['f']);
                    if (isset($presets) && count($presets) > 0) {
                        foreach ($presets as $preset) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                                <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                                <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $preset['objective']; ?>" class="content"></div>
                                <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['div_title']; ?>" class="content"></div>
                                <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $preset['task_count']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                <input type="hidden" name="add-asg" value="<?php echo $preset['id']; ?>">
                            </form> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO ASSIGNMENT PRESETS</div> <?php
                    } ?>
                </div> <?php
            }
        }

        require_once "../includes/footer.php";

    }
    else {
        header('Location: ../error.php');
    }
}
else require_once "../login.php";