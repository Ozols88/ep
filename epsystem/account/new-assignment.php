<?php
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // If redirected from an project
    if (isset($_GET['p']) && isset($_GET['t']) && !isset($_SESSION['new-assignment']['stage'])) {
        $types = [
            0 => "CUSTOM",
            1 => "PRODUCTION",
            3 => "APPROVAL",
            2 => "MANAGEMENT"
        ];

        $_SESSION['new-assignment']['fields']['type'] = $_GET['t'];
        $_SESSION['new-assignment']['type'] = ucfirst(strtolower($types[$_GET['t']]));
        $_SESSION['new-assignment']['fields']['projectid'] = $_GET['p'];
        $_SESSION['new-assignment']['project'] = Project::selectAdminProjectStatic($_GET['p'])['project_title'];
        if ($_SESSION['new-assignment']['fields']['type'] == 0)
            $_SESSION['new-assignment']['stage'] = '3c';
        else
            $_SESSION['new-assignment']['stage'] = '3';
    }
    // If redirected from project creation page
    elseif (isset($_SESSION['new-project']['new-assignment']) && !isset($_SESSION['new-assignment']['stage'])) {
        $_SESSION['new-assignment']['project'] =  "#" . sprintf('%04d', Project::selectNextNewID('project'));
        $_SESSION['new-assignment']['stage'] = '2';
    }
    // Add assignment from scratch
    elseif (!isset($_SESSION['new-assignment']))
        $_SESSION['new-assignment']['stage'] = '1';

    if (!isset($_SESSION['num']['new-assignment']))
        $_SESSION['num']['new-assignment'] = 1;

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
                    $_SESSION['new-assignment']['project'] = Project::selectAdminProjectStatic($_POST['project'])['project_title'];
                    if (strlen($_SESSION['new-assignment']['project']) > 10)
                        $_SESSION['new-assignment']['project'] = substr($_SESSION['new-assignment']['project'], 0, 10) . "...";
                }
                $_SESSION['new-assignment']['stage'] = '2';
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '2') {
            if (isset($_POST['type'])) {
                $_SESSION['new-assignment']['fields']['type'] = $_POST['type'];
                $_SESSION['new-assignment']['type'] = ucfirst(strtolower($_POST['submit']));
                if (strlen($_SESSION['new-assignment']['type']) > 10)
                    $_SESSION['new-assignment']['type'] = substr($_SESSION['new-assignment']['type'], 0, 10) . "...";

                if ($_POST['type'] == 0)
                    $_SESSION['new-assignment']['stage'] = '3c';
                else
                    $_SESSION['new-assignment']['stage'] = '3';
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '3') {
            if (isset($_POST['new-preset']))
                $_SESSION['new-assignment']['new-preset'] = true;
            elseif (isset($_POST['preset'])) {
                $presetData = Assignment::selectPresetByID($_POST['preset']);
                $_SESSION['new-assignment']['preset'] = $presetData['title'];
                if (strlen($_SESSION['new-assignment']['preset']) > 10)
                    $_SESSION['new-assignment']['preset'] = substr($_SESSION['new-assignment']['preset'], 0, 10) . "...";

                $_SESSION['new-assignment']['fields']['presetid'] = $_POST['preset'];
                $_SESSION['new-assignment']['fields']['title'] = $presetData['title'];
                $_SESSION['new-assignment']['fields']['departmentid'] = $presetData['departmentid'];
                $_SESSION['new-assignment']['fields']['objective'] = $presetData['objective'];
                $_SESSION['new-assignment']['stage'] = '4';
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4') {
            if (isset($_POST['add-task-page']))
                $_SESSION['new-assignment']['add-task-page'] = true;

            if (isset($_POST['add-task'])) {
                $_SESSION['new-assignment']['tasks'][$_POST['add-task']] = Task::selectTask($_POST['add-task']);
                unset($_SESSION['new-assignment']['presetTasks'][$_POST['add-task']]);
                unset($_SESSION['new-assignment']['add-task-page']);
            }
            if (isset($_POST['del-task'])) {
                unset($_SESSION['new-assignment']['tasks'][$_POST['del-task']]);
                $_SESSION['new-assignment']['presetTasks'][$_POST['del-task']] = Task::selectTask($_POST['del-task']);
            }

            if ($_POST['submit'] == "SAVE") {
                // From new-project
                if (isset($_SESSION['new-project']['new-assignment'])) {
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-assignment']]['fields'] = [
                        'title' => $_SESSION['new-assignment']['fields']['title'],
                        'departmentid' => $_SESSION['new-assignment']['fields']['departmentid'],
                        'type' => $_SESSION['new-assignment']['fields']['type'],
                        'presetid' => $_SESSION['new-assignment']['fields']['presetid'],
                        'objective' => $_SESSION['new-assignment']['fields']['objective']
                    ];
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-assignment']++]['tasks'] = $_SESSION['new-assignment']['tasks'];
                    unset($_SESSION['new-project']['new-assignment']);
                    unset($_SESSION['new-assignment']);
                    header('Location: new-project.php');
                }
                // From new-assignment
                else {
                    // Insert to `assignment` table and save ID of the new record
                    $_SESSION['new-assignment']['fields']['assignmentid'] = Assignment::insert('assignment', $_SESSION['new-assignment']['fields'], true, null);

                    $fieldsStatus = [
                        'assignmentid' => $_SESSION['new-assignment']['fields']['assignmentid'],
                        'statusid' => 2,
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
                            'presetid' => $task['id'],
                            'objective' => $task['objective'],
                            'description' => $task['description'],
                            'number' => $taskNumber,
                            'estimated' => $task['estimated']
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
                    $redirect = "projects?p=" . $_SESSION['new-assignment']['fields']['projectid'] . "&l1=" . $_SESSION['new-assignment']['fields']['type'] . "&l2=" . $_SESSION['new-assignment']['fields']['departmentid'] . "&l3=" . $_SESSION['new-assignment']['fields']['assignmentid'] . "&l4=summary";
                    header("Location: " . $redirect);
                    unset($_SESSION['new-assignment']);
                }
            }
        }
        // c = custom (if stage 2 selected type is custom)
        elseif ($_SESSION['new-assignment']['stage'] == '3c') {
            if (isset($_POST['new-department']))
                $_SESSION['new-assignment']['new-department'] = true;
            else {
                if (isset($_POST['department']))
                    $_SESSION['new-assignment']['fields']['departmentid'] = $_POST['department'];
                $_SESSION['new-assignment']['department'] = Assignment::selectDepartmentByID($_POST['department'])['title'];
                if (strlen($_SESSION['new-assignment']['department']) > 10)
                    $_SESSION['new-assignment']['department'] = substr($_SESSION['new-assignment']['department'], 0, 10) . "...";

                $_SESSION['new-assignment']['stage'] = '4c';
            }
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4c') {
            $_SESSION['new-assignment']['fields']['title'] = $_POST['title'];
            $_SESSION['new-assignment']['title'] = $_POST['title'];
            if (strlen($_SESSION['new-assignment']['title']) > 10)
                $_SESSION['new-assignment']['title'] = substr($_SESSION['new-assignment']['title'], 0, 10) . "...";

            $_SESSION['new-assignment']['stage'] = '5c';
        }
        elseif ($_SESSION['new-assignment']['stage'] == '5c') {
            $_SESSION['new-assignment']['fields']['objective'] = $_POST['objective'];
            $_SESSION['new-assignment']['objective'] = $_POST['objective'];
            if (strlen($_SESSION['new-assignment']['objective']) > 10)
                $_SESSION['new-assignment']['objective'] = substr($_SESSION['new-assignment']['objective'], 0, 10) . "...";

            $_SESSION['new-assignment']['stage'] = '6c';
        }
        elseif ($_SESSION['new-assignment']['stage'] == '6c') {
            if (isset($_POST['new-task'])) {
                $_SESSION['new-assignment']['new-task'] = true;
                header("Location: new-task");
            }

            if (isset($_POST['del-task'])) {
                unset($_SESSION['new-assignment']['tasks'][$_POST['del-task']]);
            }

            if ($_POST['submit'] == "SAVE") {
                // From new-project
                if (isset($_SESSION['new-project']['new-assignment'])) {
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-assignment']]['fields'] = [
                        'title' => $_SESSION['new-assignment']['fields']['title'],
                        'departmentid' => $_SESSION['new-assignment']['fields']['departmentid'],
                        'type' => $_SESSION['new-assignment']['fields']['type'],
                        'presetid' => $_SESSION['new-assignment']['fields']['presetid'],
                        'objective' => $_SESSION['new-assignment']['fields']['objective']
                    ];
                    $_SESSION['new-project']['assignments'][$_SESSION['num']['new-assignment']++]['tasks'] = $_SESSION['new-assignment']['tasks'];
                    unset($_SESSION['new-project']['new-assignment']);
                    unset($_SESSION['new-assignment']);
                    header('Location: new-project.php');
                }
                // From new-assignment
                else {
                    // Insert to `assignment` table and save ID of the new record
                    $_SESSION['new-assignment']['fields']['assignmentid'] = Assignment::insert('assignment', $_SESSION['new-assignment']['fields'], true, null);

                    $fieldsStatus = [
                        'assignmentid' => $_SESSION['new-assignment']['fields']['assignmentid'],
                        'statusid' => 2,
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
                                'statusid' => 6,
                                'time' => date("Y-m-d H-i-s"),
                                'assigned_by' => $account->id,
                                'note' => "New Task"
                            ];
                            $statusID = Task::insert('task_status', $fieldsStatus, true, null);
                            Task::update('task', $task['fields']['taskid'], ["statusid" => $statusID], null);
                        }
                    }

                    header('Location: ' . "projects?p=" . $_SESSION['new-assignment']['fields']['projectid'] . "&l1=0&l2=" . $_SESSION['new-assignment']['fields']['departmentid'] . "&l3=" . $_SESSION['new-assignment']['fields']['assignmentid'] . "&l4=summary");
                    unset($_SESSION['new-assignment']);
                }
            }
        }
    }

    if (isset($_POST['cancel']))
        unset($_SESSION['new-assignment']);

    if ($account->type == 1) { ?>
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
            $projects = Project::selectProjectList(); ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div>
                <div class="section">
                    <div class="stage active">PROJECT:</div>
                </div>
                <div class="section">
                    <div class="stage admin">TYPE:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">TASKS:</div>
                </div>
            </div>
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
                    <div class="head admin" style="width: 7.5%">Add</div>
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
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                        <input type="hidden" name="project" value="<?php echo $project['project_id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        elseif ($_SESSION['new-assignment']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Select Type</span>
            </div>
            <div class="navbar level-1 unselected current">
                <form method="post" class="container-button">
                    <input type="hidden" name="type" value="1">
                    <input type="submit" name="submit" value="PRODUCTION" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="type" value="0">
                    <input type="submit" name="submit" value="CUSTOM" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="type" value="3">
                    <input type="submit" name="submit" value="APPROVAL" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="type" value="2">
                    <input type="submit" name="submit" value="MANAGEMENT" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
            </div>
            </div> <?php
        }
        elseif ($_SESSION['new-assignment']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Select Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button disabled admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="new-preset">
                    <input type="submit" name="submit" value="+ New Assignment Preset" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button disabled admin-menu">
                </form>
            </div> <?php
            $assignmentPresets = Assignment::selectPresets(); ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PROJECT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">TYPE:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                </div>
                <div class="section">
                    <div class="stage active">PRESET:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">TASKS:</div>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 25%">Assignment Name</div>
                    <div class="head admin" style="width: 35%">Objective</div>
                    <div class="head admin" style="width: 15%">Department</div>
                    <div class="head admin" style="width: 10%">Task Presets</div>
                    <div class="head admin" style="width: 7.5%">Add</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                foreach ($assignmentPresets as $preset) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                        <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $preset['objective']; ?>" class="content"></div>
                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $preset['department']; ?>" class="content"></div>
                        <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $preset['task_count']; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                        <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4') {
            if (!isset($_SESSION['new-assignment']['add-task-page'])) { ?>
                <div class="head-up-display-bar">
                    <span>+ New Assignment: Tasks</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="add-task-page">
                        <input type="submit" name="submit" value="ADD TASK" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                    </form>
                </div>
                <div class="info-bar extended">
                    <div class="section line-right">
                        <div class="stage admin">№:</div>
                        <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">PROJECT:</div>
                        <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">TYPE:</div>
                        <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">PRESET:</div>
                        <div class="content"><?php echo $_SESSION['new-assignment']['preset']; ?></div>
                    </div>
                    <div class="section line-left">
                        <div class="stage active">TASKS:</div>
                        <div class="content"><?php if (isset($_SESSION['new-assignment']['tasks'])) echo count($_SESSION['new-assignment']['tasks']); else echo "0"; ?></div>
                    </div>
                </div>
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
                    if (isset($_SESSION['new-assignment']['tasks'])) {
                        foreach ($_SESSION['new-assignment']['tasks'] as $task) {
                            $nextID = Database::selectNextNewID('task') - 1; ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('task') + 1); ?>" class="content"></div>
                                <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $task['objective']; ?>" class="content"></div>
                                <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                                <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['estimated']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                <input type="hidden" name="del-task" value="<?php echo $task['id']; ?>">
                            </form> <?php
                        }
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
                </div>
                <div class="info-bar extended">
                    <div class="section line-right">
                        <div class="stage admin">№:</div>
                        <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">PROJECT:</div>
                        <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">TYPE:</div>
                        <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">PRESET:</div>
                        <div class="content"><?php echo $_SESSION['new-assignment']['preset']; ?></div>
                    </div>
                    <div class="section line-left">
                        <div class="stage active">TASKS:</div>
                        <div class="content"><?php if (isset($_SESSION['new-assignment']['tasks'])) echo count($_SESSION['new-assignment']['tasks']); else echo "0"; ?></div>
                    </div>
                </div>
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
                    if (!isset($_SESSION['new-assignment']['presetTasks']))
                        $_SESSION['new-assignment']['presetTasks'] = Task::selectAssignmentPresetTasks($_SESSION['new-assignment']['fields']['presetid']);
                    foreach ($_SESSION['new-assignment']['presetTasks'] as $task) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $task['id']); ?>" class="content"></div>
                            <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $task['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                            <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['estimated']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                            <input type="hidden" name="add-task" value="<?php echo $task['id']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
        }

        elseif ($_SESSION['new-assignment']['stage'] == '3c') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Select Department</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="new-department">
                    <input type="submit" name="submit" value="+ New Department" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <input class="button admin-menu disabled">
                </form>
            </div> <?php
            $departments = Assignment::selectDepartments(); ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PROJECT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">TYPE:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                </div>
                <div class="section">
                    <div class="stage active">DEPARTMENT:</div>
                </div>
                <div class="section">
                    <div class="stage admin">NAME:</div>
                </div>
                <div class="section">
                    <div class="stage admin">OBJECTIVE:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">TASKS:</div>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Department Name</div>
                    <div class="head admin" style="width: 55%">Description</div>
                    <div class="head admin" style="width: 10%">Assignments</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                foreach ($departments as $department) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%01d', $department['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $department['title']; ?>" class="content"></div>
                        <div class="cell" style="width: 55%"><input type="submit" name="submit" value="<?php echo $department['description']; ?>" class="content"></div>
                        <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                        <input type="hidden" name="department" value="<?php echo $department['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        elseif ($_SESSION['new-assignment']['stage'] == '4c') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Enter Name</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="title" name="title" method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PROJECT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">TYPE:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">DEPARTMENT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['department']; ?></div>
                </div>
                <div class="section">
                    <div class="stage active">NAME:</div>
                </div>
                <div class="section">
                    <div class="stage admin">OBJECTIVE:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">TASKS:</div>
                </div>
            </div>
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
        elseif ($_SESSION['new-assignment']['stage'] == '5c') { ?>
            <div class="head-up-display-bar">
                <span>+ New Assignment: Enter Objective</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="objective" name="objective" method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PROJECT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">TYPE:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">DEPARTMENT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['department']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">NAME:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['title']; ?></div>
                </div>
                <div class="section">
                    <div class="stage active">OBJECTIVE:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">TASKS:</div>
                </div>
            </div>
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
        elseif ($_SESSION['new-assignment']['stage'] == '6c') { ?>
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
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Assignment::selectNextNewID('assignment')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PROJECT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['project']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">TYPE:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['type']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">DEPARTMENT:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['department']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">NAME:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['title']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">OBJECTIVE:</div>
                    <div class="content"><?php echo $_SESSION['new-assignment']['objective']; ?></div>
                </div>
                <div class="section line-left">
                    <div class="stage active">TASKS:</div>
                    <div class="content"><?php if (isset($_SESSION['new-assignment']['tasks'])) echo count($_SESSION['new-assignment']['tasks']); else echo "0"; ?></div>
                </div>
            </div>
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
            if (isset($_SESSION['new-assignment']['tasks'])) { ?>
                <div class="table admin"> <?php
                    foreach ($_SESSION['new-assignment']['tasks'] as $num => $task) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo $num; ?>" class="content"></div>
                            <div class="cell" style="width: 60%"><input type="submit" name="submit" value="<?php echo $task['fields']['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo $task['action']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content add-button"></div>
                            <input type="hidden" name="del-task" value="<?php echo $num; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO TASKS</div> <?php
            }
        }
    }

    require_once "includes/footer.php";

}
else require_once "login.php";