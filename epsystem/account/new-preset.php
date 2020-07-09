<?php
$page = "r&d";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php";

    if (!isset($_SESSION['new-preset']))
        $_SESSION['new-preset']['stage'] = '1';
    if (!isset($_SESSION['new-preset']['info']['type']))
        $_SESSION['new-preset']['info']['type'] = ""; // Info bar fix

    if (isset($_POST['submit'])) {
        if ($_SESSION['new-preset']['stage'] == '1') {

            $_SESSION['new-project']['fields']['floorid'] = $_POST['floor'];
            $_SESSION['new-project']['info']['floor'] = Project::selectFloorByID($_POST['floor'])['title'];
            if (strlen($_SESSION['new-project']['info']['floor']) > 10)
                $_SESSION['new-project']['info']['floor'] = substr($_SESSION['new-project']['info']['floor'], 0, 10) . "...";

            // reset everything after this stage
            foreach ($_SESSION['new-project']['fields'] as $key => $value) {
                if ($key == "floorid") continue;
                unset($_SESSION['new-project']['fields'][$key]);
            }
            foreach ($_SESSION['new-project']['info'] as $key => $value) {
                if ($key == "floor") continue;
                unset($_SESSION['new-project']['info'][$key]);
            }
            unset($_SESSION['new-project']['assignments']);
            unset($_SESSION['new-project']['assignmentPresets']);

            $_SESSION['new-project']['stage'] = 2;
            if (!isset($_SESSION['new-project']['info']['preset']))
                $_SESSION['new-project']['info']['preset'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-preset']['stage'] == '2') {
            if (isset($_POST['new-preset']))
                $_SESSION['new-project']['new-preset'] = true;
            else {
                // reset assignment list after this stage
                unset($_SESSION['new-project']['assignments']);
                unset($_SESSION['new-project']['assignmentPresets']);
                $_SESSION['num']['new-project'] = 1;

                if (isset($_POST['preset'])) {
                    $_SESSION['new-project']['fields']['presetid'] = $_POST['preset'];
                    $_SESSION['new-project']['info']['preset'] = Project::selectPresetByID($_POST['preset'])['title'];
                    if (strlen($_SESSION['new-project']['info']['preset']) > 10)
                        $_SESSION['new-project']['info']['preset'] = substr($_SESSION['new-project']['info']['preset'], 0, 10) . "...";

                    // Select assignment presets for last stage
                    // :all selectable assignments
                    $_SESSION['new-project']['assignmentPresets'] = Assignment::selectAssignmentPresetsByFloor($_SESSION['new-project']['fields']['floorid']);
                    foreach ($_SESSION['new-project']['assignmentPresets'] as $num => $preset) {
                        $_SESSION['new-project']['assignmentPresets'][$num]['fields']['title'] = $preset['title'];
                        $_SESSION['new-project']['assignmentPresets'][$num]['fields']['presetid'] = $preset['preset-projectid'];
                        $_SESSION['new-project']['assignmentPresets'][$num]['fields']['objective'] = $preset['objective'];
                    }
                    // :pre-selected assignments
                    if (isset($_SESSION['new-project']['assignmentPresets']))
                        foreach ($_SESSION['new-project']['assignmentPresets'] as $preset) {
                            if ($preset['preset-projectid'] == $_SESSION['new-project']['fields']['presetid']) {
                                $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']] = $preset;
                                $_SESSION['num']['new-project']++;
                            }
                        }
                }
                else
                    $_SESSION['new-project']['info']['preset'] = "None";

                $_SESSION['new-project']['stage'] = 2;
                if (!isset($_SESSION['new-project']['info']['client']))
                    $_SESSION['new-project']['info']['client'] = ""; // Info bar fix
            }
        }
        elseif ($_SESSION['new-preset']['stage'] == '3') {
            if (isset($_POST['new-client']))
                $_SESSION['new-project']['new-client'] = true;
            else {
                if (isset($_SESSION['new-project']['new-client'])) {
                    if (isset($_POST['username']) && (strlen($_POST['username']) > 3)) {
                        $fieldsClient = [
                            'username' => $_POST['username'],
                            'type' => 2,
                            'reg_time' => date("Y-m-d H-i-s")
                        ];
                        $clientID = Project::insert('account', $fieldsClient, true, null);
                        $_SESSION['new-project']['fields']['clientid'] = $clientID;
                        $_SESSION['new-project']['info']['client'] = Database::selectAccountByID($clientID)['username'];
                        unset($_SESSION['new-project']['new-client']);
                    }
                    else
                        $errorMsg = "Username too short!";
                }
                else {
                    if (isset($_POST['client'])) {
                        $_SESSION['new-project']['fields']['clientid'] = $_POST['client'];
                        $_SESSION['new-project']['info']['client'] = Database::selectAccountByID($_POST['client'])['username'];
                        if (strlen($_SESSION['new-project']['info']['client']) > 10)
                            $_SESSION['new-project']['info']['client'] = substr($_SESSION['new-project']['info']['client'], 0, 10) . "...";
                    }
                    else {
                        $_SESSION['new-project']['info']['client'] = "Later";

                    }
                }
                $_SESSION['new-project']['stage'] = 3;
                if (!isset($_SESSION['new-project']['info']['title']))
                    $_SESSION['new-project']['info']['title'] = ""; // Info bar fix
            }
        }
        elseif ($_SESSION['new-preset']['stage'] == '4') {
            $_SESSION['new-project']['fields']['title'] = $_POST['title'];
            $_SESSION['new-project']['info']['title'] = $_POST['title'];
            if (strlen($_SESSION['new-project']['info']['title']) > 10)
                $_SESSION['new-project']['info']['title'] = substr($_SESSION['new-project']['info']['title'], 0, 10) . "...";

            $_SESSION['new-project']['stage'] = 4;
            if (!isset($_SESSION['new-project']['info']['manager-name']))
                $_SESSION['new-project']['info']['manager-name'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-preset']['stage'] == '5') {
            if (isset($_POST['manager'])) {
                $_SESSION['new-project']['manager'] = $_POST['manager'];
                $_SESSION['new-project']['info']['manager-name'] = Database::selectAccountByID($_POST['manager'])['username'];
            }
            else
                $_SESSION['new-project']['info']['manager-name'] = "Later";
            if (strlen($_SESSION['new-project']['info']['manager-name']) > 10)
                $_SESSION['new-project']['info']['manager-name'] = substr($_SESSION['new-project']['info']['manager-name'], 0, 10) . "...";

            // If project added through new-assignment page complete project adding
            if (isset($_SESSION['new-assignment']['new-project'])) {
                // Insert to `project` table and save ID of the new record
                $_SESSION['new-project']['fields']['projectid'] = Project::insert('project', $_SESSION['new-project']['fields'], true, null);

                $fieldsStatus = [
                    'projectid' => $_SESSION['new-project']['fields']['projectid'],
                    'statusid' => 2,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "New Project"
                ];
                if (isset($_SESSION['new-project']['manager']))
                    $fieldsStatus['assigned_to'] = $_SESSION['new-project']['manager'];

                $_SESSION['new-assignment']['fields']['projectid'] = $_SESSION['new-project']['fields']['projectid'];
                // Insert to `project_status` table and save ID of the new record
                $statusID = Project::insert('project_status', $fieldsStatus, true, null);
                // Update `project` table record with saved ID status
                Project::update('project', $_SESSION['new-project']['fields']['projectid'], ["statusid" => $statusID], null);

                unset($_SESSION['new-assignment']['new-project']);
                unset($_SESSION['new-project']);
                $_SESSION['new-assignment']['project'] = Project::selectProject($_SESSION['new-assignment']['fields']['projectid'])['title'];
                $_SESSION['new-assignment']['stage'] = '2';
                $redirect = "new-assignment";
                header('Location: ' . $redirect);
            }
            else {
                $_SESSION['new-project']['stage'] = 5;
                if (!isset($_SESSION['new-project']['info']['assignments']))
                    $_SESSION['new-project']['info']['assignments'] = ""; // Info bar fix
            }
        }
        elseif ($_SESSION['new-preset']['stage'] == '6') {
            // Open preset list
            if (isset($_POST['add-assignment-page']))
                $_SESSION['new-project']['add-assignment-page'] = true;

            // Select assignment
            if (isset($_POST['add-assignment'])) {
                $_SESSION['new-project']['assignments'][$_SESSION['num']['new-project']++] = $_SESSION['new-project']['assignmentPresets'][$_POST['add-assignment']];
                unset($_SESSION['new-project']['add-assignment-page']);
            }
            // Remove assignment
            if (isset($_POST['del-assignment'])) {
                unset($_SESSION['new-project']['assignments'][$_POST['del-assignment']]);
            }

            if ($_POST['submit'] == "SAVE") {
                // Insert to `project` table and save ID of the new record
                $_SESSION['new-project']['fields']['projectid'] = Project::insert('project', $_SESSION['new-project']['fields'], true, null);

                $fieldsStatus = [
                    'projectid' => $_SESSION['new-project']['fields']['projectid'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "New Project"
                ];
                if (isset($_SESSION['new-project']['manager']))
                    $fieldsStatus['assigned_to'] = $_SESSION['new-project']['manager'];

                $redirect = "projects?p=" . $_SESSION['new-project']['fields']['projectid'];

                // Insert to `project_status` table and save ID of the new record
                $statusID = Project::insert('project_status', $fieldsStatus, true, null);
                // Update `project` table record with saved ID status
                Project::update('project', $_SESSION['new-project']['fields']['projectid'], ["statusid" => $statusID], null);





                if (isset($_SESSION['new-project']['assignments'])) {
                    foreach ($_SESSION['new-project']['assignments'] as $assignment) {
                        $assignment['fields']['projectid'] = $_SESSION['new-project']['fields']['projectid'];

                        // Insert to `assignment` table and save ID of the new record
                        $assignment['fields']['assignmentid'] = Assignment::insert('assignment', $assignment['fields'], true, null);

                        $fieldsStatus = [
                            'assignmentid' => $assignment['fields']['assignmentid'],
                            'statusid' => 1,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Assignment"
                        ];
                        // Insert to `assignment_status` table and save ID of the new record
                        $statusID = Assignment::insert('assignment_status', $fieldsStatus, true, null);
                        // Update `assignment` table record with saved ID status
                        Assignment::update('assignment', $assignment['fields']['assignmentid'], ["statusid" => $statusID], null);

                        if (isset($assignment['tasks'])) {
                            $taskNumber = 1;
                            foreach ($assignment['tasks'] as $task) {
                                $fieldsTask = [
                                    'assignmentid' => $assignment['fields']['assignmentid'],
                                    'presetid' => $task['fields']['id'],
                                    'objective' => $task['fields']['objective'],
                                    'description' => $task['fields']['description'],
                                    'actionid' => $task['fields']['actionid'],
                                    'number' => $taskNumber
                                ];
                                $taskID = Task::insert('task', $fieldsTask, true, null);
                                $taskNumber++;

                                $fieldsStatus = [
                                    'taskid' => $taskID,
                                    'statusid' => 6,
                                    'time' => date("Y-m-d H-i-s"),
                                    'assigned_by' => $account->id,
                                    'note' => null
                                ];
                                $statusID = Task::insert('task_status', $fieldsStatus, true, null);
                                Task::update('task', $taskID, ["statusid" => $statusID], null);
                            }
                        }
                    }
                }
                unset($_SESSION['new-project']);
                header('Location: ' . $redirect);
            }
        }

        if (empty($_SESSION['new-preset']['info']['type'])) $_SESSION['new-preset']['stage'] = '1';
        elseif (empty($_SESSION['new-preset']['info'][''])) $_SESSION['new-preset']['stage'] = '2';
        elseif (empty($_SESSION['new-preset']['info'][''])) $_SESSION['new-preset']['stage'] = '3';
        elseif (empty($_SESSION['new-preset']['info'][''])) $_SESSION['new-preset']['stage'] = '4';
        elseif (empty($_SESSION['new-preset']['info'][''])) $_SESSION['new-preset']['stage'] = '5';
        else $_SESSION['new-preset']['stage'] = '6';
    }
    if (isset($_POST['stage1'])) $_SESSION['new-preset']['stage'] = '1';
    if (isset($_POST['stage2'])) $_SESSION['new-preset']['stage'] = '2';
    if (isset($_POST['stage3'])) $_SESSION['new-preset']['stage'] = '3';
    if (isset($_POST['stage4'])) $_SESSION['new-preset']['stage'] = '4';
    if (isset($_POST['stage5'])) $_SESSION['new-preset']['stage'] = '5';
    if (isset($_POST['stage6'])) $_SESSION['new-preset']['stage'] = '6';

    if (isset($_POST['cancel']))
        unset($_SESSION['new-preset']); ?>

    <div class="menu"> <?php
    if ($_SESSION['new-preset']['stage'] == '1') { ?>
        <div class="head-up-display-bar">
            <span>+ New Project: Select Floor</span>
        </div>
        <div class="navbar level-1 unselected current"> <?php
            $floors = Project::selectFloors();
            foreach ($floors as $floor) { ?>
                <form method="post" class="container-button">
                    <input type="hidden" name="floor" value="<?php echo $floor['id']; ?>">
                    <input type="submit" name="submit" value="<?php echo $floor['title']; ?>" class="button admin-menu">
                    <div class="home-menu"></div>
                </form> <?php
            } ?>
        </div>
        </div> <?php
    }
    elseif ($_SESSION['new-preset']['stage'] == '2') { ?>
        <div class="head-up-display-bar">
            <span>+ New Project: Select Preset</span>
        </div>
        <div class="navbar level-1 unselected">
            <form method="post" class="container-button">
                <input type="hidden" name="new-preset">
                <input type="submit" name="submit" value="+ New Project Preset" class="button admin-menu">
            </form>
            <form method="post" class="container-button">
                <input type="submit" name="submit" value="NONE" class="button admin-menu">
            </form>
        </div> <?php
        include_once "includes/info-bar.php"; ?>
        <div class="table-header-container">
            <div class="header-extension admin"></div>
            <div class="header">
                <div class="head admin" style="width: 7.5%">№</div>
                <div class="head admin" style="width: 20%">Name</div>
                <div class="head admin" style="width: 50%">Description</div>
                <div class="head admin" style="width: 15%">Assignments</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div> <?php
        $projectPresets = Project::selectPresetsByFloorID($_SESSION['new-project']['fields']['floorid']);
        if (is_array($projectPresets)) { ?>
            <div class="table admin"> <?php
                foreach ($projectPresets as $preset) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                        <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                        <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            <div class="empty-table">NO PRESETS</div> <?php
        }
    }
    elseif ($_SESSION['new-preset']['stage'] == '3') {
        if (!isset($_SESSION['new-project']['new-client'])) { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Select Client</span>
            </div>
            <div class="navbar level-1 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="new-client">
                    <input type="submit" name="submit" value="+ New Client" class="button admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="LATER" class="button admin-menu">
                </form>
            </div> <?php
            $clients = Project::selectClients();
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 60%">Client Name</div>
                    <div class="head admin" style="width: 10%">Projects</div>
                    <div class="head admin" style="width: 15%">Client Since</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                foreach ($clients as $client) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $client['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 60%"><input type="submit" name="submit" value="<?php echo $client['username']; ?>" class="content"></div>
                        <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $client['project_count']; ?>" class="content"></div>
                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $client['reg_time_date']; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                        <input type="hidden" name="client" value="<?php echo $client['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            <div class="head-up-display-bar">
                <span>+ New Client</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test2" name="test2" method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('account')); ?></div>
                </div>
                <div class="section">
                    <div class="stage active">NAME:</div>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Client Username</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="test2" name="username" id="username" class="field admin" placeholder="Enter Client Username">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
    }
    elseif ($_SESSION['new-preset']['stage'] == '4') { ?>
        <div class="head-up-display-bar">
            <span>+ New Project: Enter Name</span>
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
        include_once "includes/info-bar.php"; ?>
        <div class="table-header-container">
            <div class="header-extension small admin"></div>
            <div class="header small">
                <div class="head admin">Project Name</div>
            </div>
            <div class="header-extension small admin"></div>
        </div>
        </div>
        <div class="table small">
            <div class="row">
                <input form="test" name="title" id="title" class="field admin" placeholder="Enter Project Name Here" value="<?php if (isset($_SESSION['new-project']['fields']['title'])) echo $_SESSION['new-project']['fields']['title']; ?>">
            </div>
        </div> <?php
        if (isset($errorMsg))
            echo $errorMsg;
    }
    elseif ($_SESSION['new-preset']['stage'] == '5') { ?>
        <div class="head-up-display-bar">
            <span>+ New Project: Select Manager</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
            <form method="post" class="container-button">
                <input type="submit" name="submit" value="LATER" class="button admin-menu">
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
                <div class="head admin" style="width: 40%">Member Name</div>
                <div class="head admin" style="width: 30%">Membership</div>
                <div class="head admin" style="width: 15%">Managing Projects</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div>
        <div class="table admin"> <?php
            $members = Project::selectManagers();
            foreach ($members as $member) { ?>
                <form method="post" class="row">
                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $member['id']); ?>" class="content"></div>
                    <div class="cell" style="width: 40%"><input type="submit" name="submit" value="<?php echo $member['username']; ?>" class="content"></div>
                    <div class="cell" style="width: 30%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                    <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo "? Projects"; ?>" class="content"></div>
                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                    <input type="hidden" name="manager" value="<?php echo $member['id']; ?>">
                </form> <?php
            } ?>
        </div> <?php
    }
    elseif ($_SESSION['new-preset']['stage'] == '6') {
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
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">Number</div>
                    <div class="head admin" style="width: 20%">Name</div>
                    <div class="head admin" style="width: 15%">Division</div>
                    <div class="head admin" style="width: 35%">Objective</div>
                    <div class="head admin" style="width: 7.5%">Remove</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (isset($_SESSION['new-project']['assignments'])) { ?>
                <div class="table admin"> <?php
                    foreach ($_SESSION['new-project']['assignments'] as $num => $assignment) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $num; ?>" class="content"></div>
                            <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo Assignment::selectDivisionByID($assignment['divisionid'])['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $assignment['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                            <input type="hidden" name="del-assignment" value="<?php echo $num; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO ASSIGNMENTS</div> <?php
            }
        }
        else { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Select Assignments</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="">
                    <input type="submit" name="submit" value="+ New Assignment Preset" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Name</div>
                    <div class="head admin" style="width: 15%">Division</div>
                    <div class="head admin" style="width: 35%">Objective</div>
                    <div class="head admin" style="width: 15%">Tasks</div>
                    <div class="head admin" style="width: 7.5%">Add</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (isset($_SESSION['new-project']['assignmentPresets'])) { ?>
                <div class="table admin"> <?php
                    foreach ($_SESSION['new-project']['assignmentPresets'] as $num => $assignment) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $assignment['id']); ?>" class="content"></div>
                            <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo Assignment::selectDivisionByID($assignment['divisionid'])['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $assignment['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $assignment['task_count']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content add-button"></div>
                            <input type="hidden" name="add-assignment" value="<?php echo $num; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO ASSIGNMENTS</div> <?php
            }
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";