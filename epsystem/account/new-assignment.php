<?php
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // If redirected from existing project
    if (isset($_GET['p']) && !isset($_SESSION['new-assignment']['stage'])) {
        $_SESSION['new-assignment']['fields']['projectid'] = $_GET['p'];
        $_SESSION['new-assignment']['info']['project'] = Project::selectProject($_GET['p'])['title'];
        if (strlen($_SESSION['new-assignment']['info']['project']) > 10)
            $_SESSION['new-assignment']['info']['project'] = substr($_SESSION['new-assignment']['info']['project'], 0, 10) . "...";
        $_SESSION['new-assignment']['stage'] = '2';
    }
    // Add assignment from scratch
    elseif (!isset($_SESSION['new-assignment']))
        $_SESSION['new-assignment']['stage'] = '1';

    if (!isset($_SESSION['new-assignment']['info']['project']))
        $_SESSION['new-assignment']['info']['project'] = ""; // Info bar fix

    require_once "includes/header.php";

    if (isset($_POST['submit'])) {
        if ($_SESSION['new-assignment']['stage'] == '1') {
            if (isset($_POST['new-project'])) {
                $_SESSION['new-assignment']['new-project'] = true;
                header("Location: new-project");
            }
            else {
                if (isset($_POST['project'])) {
                    $_SESSION['new-assignment']['fields']['projectid'] = $_POST['project'];
                    $_SESSION['new-assignment']['info']['project'] = Project::selectProject($_POST['project'])['title'];
                    if (strlen($_SESSION['new-assignment']['info']['project']) > 10)
                        $_SESSION['new-assignment']['info']['project'] = substr($_SESSION['new-assignment']['info']['project'], 0, 10) . "...";
                }

                // reset everything after this stage
                foreach ($_SESSION['new-assignment']['fields'] as $key => $value) {
                    if ($key == "projectid") continue;
                    unset($_SESSION['new-assignment']['fields'][$key]);
                }
                foreach ($_SESSION['new-assignment']['info'] as $key => $value) {
                    if ($key == "project") continue;
                    unset($_SESSION['new-assignment']['info'][$key]);
                }
                unset($_SESSION['new-assignment']['tasks']);
                unset($_SESSION['new-assignment']['presetTasks']);

                $_SESSION['new-assignment']['stage'] = '2';
                if (!isset($_SESSION['new-assignment']['info']['division']))
                    $_SESSION['new-assignment']['info']['division'] = ""; // Info bar fix
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '2') {
            // reset everything after this stage
            foreach ($_SESSION['new-assignment']['fields'] as $key => $value) {
                if ($key == "projectid" || $key == "divisionid") continue;
                unset($_SESSION['new-assignment']['fields'][$key]);
            }
            foreach ($_SESSION['new-assignment']['info'] as $key => $value) {
                if ($key == "project" || $key == "division") continue;
                unset($_SESSION['new-assignment']['info'][$key]);
            }
            unset($_SESSION['new-assignment']['tasks']);
            unset($_SESSION['new-assignment']['presetTasks']);

            if (isset($_POST['division'])) {
                if ($_POST['division'] == "") {
                    $_SESSION['new-assignment']['divisionid'] = null;
                    $_SESSION['new-assignment']['info']['division'] = "Custom";

                    $_SESSION['new-assignment']['stage'] = '3c';
                    if (!isset($_SESSION['new-assignment']['info']['title']))
                        $_SESSION['new-assignment']['info']['title'] = ""; // Info bar fix
                }
                else {
                    $_SESSION['new-assignment']['divisionid'] = $_POST['division'];
                    $_SESSION['new-assignment']['info']['division'] = Assignment::selectDivisionByID($_POST['division'])['title'];
                    if (strlen($_SESSION['new-assignment']['info']['division']) > 10)
                        $_SESSION['new-assignment']['info']['division'] = substr($_SESSION['new-assignment']['info']['division'], 0, 10) . "...";

                    $_SESSION['new-assignment']['stage'] = '3';
                    if (!isset($_SESSION['new-assignment']['info']['preset']))
                        $_SESSION['new-assignment']['info']['preset'] = ""; // Info bar fix
                }
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '3') {
            if (isset($_POST['new-preset']))
                $_SESSION['new-assignment']['new-preset'] = true;
            if (isset($_POST['preset'])) {
                unset($_SESSION['new-assignment']['tasks']);
                $_SESSION['num']['new-assignment'] = 1;

                $presetData = Assignment::selectPresetByID($_POST['preset']);
                $_SESSION['new-assignment']['info']['preset'] = $presetData['title'];
                if (strlen($_SESSION['new-assignment']['info']['preset']) > 10)
                    $_SESSION['new-assignment']['info']['preset'] = substr($_SESSION['new-assignment']['info']['preset'], 0, 10) . "...";

                $_SESSION['new-assignment']['fields']['presetid'] = $_POST['preset'];
                $_SESSION['new-assignment']['fields']['title'] = $presetData['title'];
                $_SESSION['new-assignment']['fields']['objective'] = $presetData['objective'];
                $_SESSION['new-assignment']['stage'] = '4';
                if (!isset($_SESSION['new-assignment']['tasks']))
                    $_SESSION['new-assignment']['tasks'] = ""; // Info bar fix
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4') {
            if (isset($_POST['add-task-page']))
                $_SESSION['new-assignment']['add-task-page'] = true;

            if (isset($_POST['add-task'])) {
                if ($_SESSION['new-assignment']['tasks'] == "")
                    $_SESSION['new-assignment']['tasks'] = null;
                $_SESSION['new-assignment']['tasks'][$_SESSION['num']['new-assignment']++]['fields'] = Task::selectTaskPreset($_POST['add-task']);
                unset($_SESSION['new-assignment']['add-task-page']);
                header("Refresh:0");
            }
            if (isset($_POST['del-task'])) {
                unset($_SESSION['new-assignment']['tasks'][$_POST['del-task']]);
            }

            if ($_POST['submit'] == "SAVE") {
                // From new-project
                if (isset($_SESSION['new-project']['new-assignment'])) {
                    if ($_SESSION['new-project']['assignments'] == "")
                        $_SESSION['new-project']['assignments'] = null;
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-assignment']]['fields'] = [
                        'title' => $_SESSION['new-assignment']['fields']['title'],
                        'presetid' => $_SESSION['new-assignment']['fields']['presetid'],
                        'objective' => $_SESSION['new-assignment']['fields']['objective']
                    ];
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-assignment']++]['tasks'] = $_SESSION['new-assignment']['tasks'];
                    unset($_SESSION['new-project']['new-assignment']);
                    unset($_SESSION['new-assignment']);
                    header('Location: new-project.php');
                    exit();
                }
                // From new-assignment
                else {
                    // Insert to `assignment` table and save ID of the new record
                    $_SESSION['new-assignment']['fields']['assignmentid'] = Assignment::insert('assignment', $_SESSION['new-assignment']['fields'], true, null);

                    $fieldsStatus = [
                        'assignmentid' => $_SESSION['new-assignment']['fields']['assignmentid'],
                        'statusid' => 1,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'note' => "New Assignment"
                    ];
                    // Insert to `assignment_status` table and save ID of the new record
                    $statusID = Assignment::insert('assignment_status', $fieldsStatus, true, null);
                    // Update `assignment` table record with saved ID status
                    Assignment::update('assignment', $_SESSION['new-assignment']['fields']['assignmentid'], ["statusid" => $statusID], null);

                    $taskNumber = 1;
                    foreach ($_SESSION['new-assignment']['tasks'] as $task) {
                        $fieldsTask = [
                            'assignmentid' => $_SESSION['new-assignment']['fields']['assignmentid'],
                            'presetid' => $task['fields']['id'],
                            'objective' => $task['fields']['objective'],
                            'description' => $task['fields']['description'],
                            'actionid' => $task['fields']['actionid'],
                            'number' => $taskNumber,
                            'estimated' => $task['fields']['estimated']
                        ];
                        $taskID = Task::insert('task', $fieldsTask, true, null);
                        $taskNumber++;

                        $fieldsStatus = [
                            'taskid' => $taskID,
                            'statusid' => 1,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Task"
                        ];
                        $statusID = Task::insert('task_status', $fieldsStatus, true, null);
                        Task::update('task', $taskID, ["statusid" => $statusID], null);
                    }
                    $redirect = "assignments?a=" . $_SESSION['new-assignment']['fields']['assignmentid'];
                    header("Location: " . $redirect);
                    unset($_SESSION['new-assignment']);
                }
            }
        }
        // c = custom (if stage 2 selected preset is none)
        elseif ($_SESSION['new-assignment']['stage'] == '3c') {
            $_SESSION['new-assignment']['fields']['title'] = $_POST['title'];
            $_SESSION['new-assignment']['info']['title'] = $_POST['title'];
            if (strlen($_SESSION['new-assignment']['info']['title']) > 10)
                $_SESSION['new-assignment']['info']['title'] = substr($_SESSION['new-assignment']['info']['title'], 0, 10) . "...";

            $_SESSION['new-assignment']['stage'] = '4c';
            if (!isset($_SESSION['new-assignment']['info']['objective']))
                $_SESSION['new-assignment']['info']['objective'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4c') {
            $_SESSION['new-assignment']['fields']['objective'] = $_POST['objective'];
            $_SESSION['new-assignment']['info']['objective'] = $_POST['objective'];
            if (strlen($_SESSION['new-assignment']['info']['objective']) > 10)
                $_SESSION['new-assignment']['info']['objective'] = substr($_SESSION['new-assignment']['info']['objective'], 0, 10) . "...";

            $_SESSION['new-assignment']['stage'] = '5c';
            if (!isset($_SESSION['new-assignment']['tasks']))
                $_SESSION['new-assignment']['tasks'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-assignment']['stage'] == '5c') {
            if (isset($_POST['new-task'])) {
                $_SESSION['new-assignment']['new-task'] = true;
                header("Location: new-task");
            }

            if (isset($_POST['del-task'])) {
                unset($_SESSION['new-assignment']['tasks'][$_POST['del-task']]);
            }

            if ($_POST['submit'] == "SAVE") {
                // Insert to `assignment` table and save ID of the new record
                $_SESSION['new-assignment']['fields']['assignmentid'] = Assignment::insert('assignment', $_SESSION['new-assignment']['fields'], true, null);

                $fieldsStatus = [
                    'assignmentid' => $_SESSION['new-assignment']['fields']['assignmentid'],
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "New Assignment"
                ];

                // Insert to `assignment_status` table and save ID of the new record
                $statusID = Assignment::insert('assignment_status', $fieldsStatus, true, null);
                // Update `assignment` table record with saved ID status
                Assignment::update('assignment', $_SESSION['new-assignment']['fields']['assignmentid'], ["statusid" => $statusID], null);

                if (isset($_SESSION['new-assignment']['tasks'])) {
                    $num = 1;
                    foreach ($_SESSION['new-assignment']['tasks'] as $task) {
                        $task['fields']['assignmentid'] = $_SESSION['new-assignment']['fields']['assignmentid'];
                        $task['fields']['number'] = $num++;
                        $task['fields']['taskid'] = Task::insert('task', $task['fields'], true, null);

                        $fieldsStatus = [
                            'taskid' => $task['fields']['taskid'],
                            'statusid' => 1,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Task"
                        ];
                        $statusID = Task::insert('task_status', $fieldsStatus, true, null);
                        Task::update('task', $task['fields']['taskid'], ["statusid" => $statusID], null);
                    }
                }

                header('Location: ' . "assignments?a=" . $_SESSION['new-assignment']['fields']['assignmentid']);
                unset($_SESSION['new-assignment']);
            }
        }

        if (empty($_SESSION['new-assignment']['info']['project'])) $_SESSION['new-assignment']['stage'] = '1';
        elseif (empty($_SESSION['new-assignment']['info']['division'])) $_SESSION['new-assignment']['stage'] = '2';
        elseif ($_SESSION['new-assignment']['divisionid'] != null) {
            if (empty($_SESSION['new-assignment']['info']['preset'])) $_SESSION['new-assignment']['stage'] = '3';
            elseif (empty($_SESSION['new-assignment']['tasks'])) $_SESSION['new-assignment']['stage'] = '4';
        }
        else {
            if (empty($_SESSION['new-assignment']['info']['title'])) $_SESSION['new-assignment']['stage'] = '3c';
            elseif (empty($_SESSION['new-assignment']['info']['objective'])) $_SESSION['new-assignment']['stage'] = '4c';
            else $_SESSION['new-assignment']['stage'] = '5c';
        }
    }
    if (isset($_POST['stage1'])) $_SESSION['new-assignment']['stage'] = '1';
    if (isset($_POST['stage2'])) $_SESSION['new-assignment']['stage'] = '2';
    if (isset($_POST['stage3'])) $_SESSION['new-assignment']['stage'] = '3';
    if (isset($_POST['stage4'])) $_SESSION['new-assignment']['stage'] = '4';
    if (isset($_POST['stage3c'])) $_SESSION['new-assignment']['stage'] = '3c';
    if (isset($_POST['stage4c'])) $_SESSION['new-assignment']['stage'] = '4c';
    if (isset($_POST['stage5c'])) $_SESSION['new-assignment']['stage'] = '5c';

    if (isset($_POST['cancel']))
        unset($_SESSION['new-assignment']); ?>

    <div class="menu"> <?php
    if ($_SESSION['new-assignment']['stage'] == '1') { ?>
        <div class="head-up-display-bar">
            <span>+ New Assignment: Select Project</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <input class="button admin-menu disabled">
            </form>
            <form method="post" class="container-button">
                <input type="hidden" name="new-project">
                <input type="submit" name="submit" value="+ New Project" class="button admin-menu">
            </form>
            <form class="container-button disabled">
                <input class="button admin-menu disabled">
            </form>
        </div> <?php
        $projects = Project::selectProjectList();
        include_once "includes/info-bar.php"; ?>
        <div class="table-header-container">
            <div class="header-extension admin"></div>
            <div class="header">
                <div class="head admin" style="width: 7.5%">№</div>
                <div class="head admin" style="width: 20%">Project Name</div>
                <div class="head admin" style="width: 15%">Preset</div>
                <div class="head admin" style="width: 15%">Client</div>
                <div class="head admin" style="width: 15%">Status</div>
                <div class="head admin" style="width: 10%">Assignments</div>
                <div class="head admin" style="width: 10%" onclick="sortTable('.head.time', '.cell.time a')">Time Spent</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div>
        <div class="table admin"> <?php
            foreach ($projects as $project) { ?>
                <form method="post" class="row">
                    <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%04d', $project['project_id']); ?>" class="content"></div>
                    <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $project['project_title']; ?>" class="content"></div>
                    <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $project['project_preset']; ?>" class="content"></div>
                    <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $project['client_username']; ?>" class="content"></div>
                    <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $project['status']; ?>" class="content"></div>
                    <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $project['total_assignments']; ?>" class="content"></div>
                    <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo "" . " Hours"; ?>" class="content"></div>
                    <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                    <input type="hidden" name="project" value="<?php echo $project['project_id']; ?>">
                </form> <?php
            } ?>
        </div> <?php
    }
    elseif ($_SESSION['new-assignment']['stage'] == '2') { ?>
        <div class="head-up-display-bar">
            <span>+ New Assignment: Select Division</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <input class="button admin-menu disabled">
            </form>
            <form method="post" class="container-button">
                <input type="hidden" name="new-preset">
                <input type="submit" name="submit" value="+ New Assignment Preset" class="button admin-menu">
            </form>
            <form class="container-button disabled">
                <input class="button admin-menu disabled">
            </form>
        </div> <?php
        $divisions = Assignment::selectDivisionsByFloor(Project::selectProject($_SESSION['new-assignment']['fields']['projectid'])['floorid']);
        include_once "includes/info-bar.php"; ?>
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
                foreach ($divisions as $division) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $division['division_id']); ?>" class="content"></div>
                        <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $division['division_title']; ?>" class="content"></div>
                        <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $division['division_desc']; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                        <input type="hidden" name="division" value="<?php echo $division['division_id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            <div class="empty-table">NO DIVISIONS</div> <?php
        }
    }
    elseif ($_SESSION['new-assignment']['stage'] == '3') { ?>
        <div class="head-up-display-bar">
            <span>+ New Assignment: Select Preset</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <input class="button admin-menu disabled">
            </form>
            <form method="post" class="container-button">
                <input type="hidden" name="new-preset">
                <input type="submit" name="submit" value="+ New Assignment Preset" class="button admin-menu">
            </form>
            <form class="container-button disabled">
                <input class="button admin-menu disabled">
            </form>
        </div> <?php
        $assignmentPresets = Assignment::selectPresetsByDivision($_SESSION['new-assignment']['divisionid']);
        include_once "includes/info-bar.php"; ?>
        <div class="table-header-container">
            <div class="header-extension admin"></div>
            <div class="header">
                <div class="head admin" style="width: 7.5%">№</div>
                <div class="head admin" style="width: 25%">Assignment Name</div>
                <div class="head admin" style="width: 35%">Objective</div>
                <div class="head admin" style="width: 15%">Division</div>
                <div class="head admin" style="width: 10%">Task Presets</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div> <?php
        if (isset($assignmentPresets)) { ?>
            <div class="table admin"> <?php
                foreach ($assignmentPresets as $preset) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                        <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $preset['objective']; ?>" class="content"></div>
                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['division']; ?>" class="content"></div>
                        <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $preset['task_count']; ?>" class="content"></div>
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
    elseif ($_SESSION['new-assignment']['stage'] == '4') {
        if (!isset($_SESSION['new-assignment']['add-task-page'])) { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Tasks</span>
            </div>
            <div class="navbar level-1 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="add-task-page">
                    <input type="submit" name="submit" value="+ ADD TASK" class="button admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 50%">Task Objective</div>
                    <div class="head admin" style="width: 25%">Action</div>
                    <div class="head admin" style="width: 10%">Time</div>
                    <div class="head admin" style="width: 7.5%">Remove</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                if (is_array($_SESSION['new-assignment']['tasks']) && count($_SESSION['new-assignment']['tasks']) > 0) {
                    foreach ($_SESSION['new-assignment']['tasks'] as $num => $task) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $num; ?>" class="content"></div>
                            <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $task['fields']['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                            <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['fields']['estimated']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                            <input type="hidden" name="del-task" value="<?php echo $num; ?>">
                        </form> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO TASKS</div> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Add Task</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="new-preset">
                    <input type="submit" name="submit" value="+ New Task Preset" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            if (!isset($_SESSION['new-assignment']['presetTasks']))
                $_SESSION['new-assignment']['presetTasks'] = Task::selectAssignmentPresetTasks($_SESSION['new-assignment']['fields']['presetid']);
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 50%">Task Objective</div>
                    <div class="head admin" style="width: 25%">Action</div>
                    <div class="head admin" style="width: 10%">Time</div>
                    <div class="head admin" style="width: 7.5%">Add</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                if (isset($_SESSION['new-assignment']['presetTasks']) && count($_SESSION['new-assignment']['presetTasks']) > 0) {
                    foreach ($_SESSION['new-assignment']['presetTasks'] as $task) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $task['id']); ?>" class="content"></div>
                            <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $task['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                            <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['estimated']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                            <input type="hidden" name="add-task" value="<?php echo $task['id']; ?>">
                        </form> <?php
                    }
                }
                else { ?>
                    <div class="empty-table">NO TASK PRESETS</div> <?php
                } ?>
            </div> <?php
        }
    }

    elseif ($_SESSION['new-assignment']['stage'] == '3c') { ?>
        <div class="head-up-display-bar">
            <span>+ New Assignment: Enter Name</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
            <form id="title" name="title" method="post" class="container-button">
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
                <div class="head admin">Assignment Name</div>
            </div>
            <div class="header-extension small admin"></div>
        </div>
        </div>
        <div class="table small">
            <div class="row">
                <input form="title" name="title" id="title" class="field admin" placeholder="Enter Assignment Name Here">
            </div>
        </div> <?php
    }
    elseif ($_SESSION['new-assignment']['stage'] == '4c') { ?>
        <div class="head-up-display-bar">
            <span>+ New Assignment: Enter Objective</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
            <form id="objective" name="objective" method="post" class="container-button">
                <input type="submit" name="submit" value="NEXT" class="button admin-menu">
            </form>
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
        </div> <?php
        include_once "includes/info-bar.php"; ?>
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
                <input form="objective" name="objective" id="objective" class="field admin" placeholder="Enter Assignment Objective Here">
            </div>
        </div> <?php
    }
    elseif ($_SESSION['new-assignment']['stage'] == '5c') { ?>
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
        include_once "includes/info-bar.php"; ?>
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

    require_once "includes/footer.php";

}
else require_once "login.php";