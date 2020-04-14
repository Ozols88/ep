<?php
$page = "projects";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php";

    if (!isset($_SESSION['new-project']))
        $_SESSION['new-project']['stage'] = 1;

    if (isset($_POST['submit'])) {
        if ($_SESSION['new-project']['stage'] == 1) {
            if (isset($_POST['new-preset']))
                $_SESSION['new-project']['new-preset'] = true;
            else {
                if (isset($_POST['preset'])) {
                    $_SESSION['new-project']['fields']['presetid'] = $_POST['preset'];
                    $_SESSION['new-project']['preset'] = Project::selectPresetByID($_POST['preset'])[0]['title'];
                    if (strlen($_SESSION['new-project']['preset']) > 10)
                        $_SESSION['new-project']['preset'] = substr($_SESSION['new-project']['preset'], 0, 10) . "...";
                }
                else
                    $_SESSION['new-project']['preset'] = "None";
                $_SESSION['new-project']['stage'] = 2;
            }
        }
        elseif ($_SESSION['new-project']['stage'] == 2) {
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
                        $_SESSION['new-project']['client'] = Database::selectAccountByID($clientID)['username'];
                        unset($_SESSION['new-project']['new-client']);
                        $_SESSION['new-project']['stage'] = 3;
                    }
                    else
                        $errorMsg = "Username too short!";
                }
                else {
                    if (isset($_POST['client'])) {
                        $_SESSION['new-project']['fields']['clientid'] = $_POST['client'];
                        $_SESSION['new-project']['client'] = Database::selectAccountByID($_POST['client'])['username'];
                        if (strlen($_SESSION['new-project']['client']) > 10)
                            $_SESSION['new-project']['client'] = substr($_SESSION['new-project']['client'], 0, 10) . "...";

                        $_SESSION['new-project']['stage'] = 3;
                    }
                    else {
                        $_SESSION['new-project']['client'] = "None";
                        $_SESSION['new-project']['stage'] = 3;
                    }
                }
            }
        }
        elseif ($_SESSION['new-project']['stage'] == 3) {
            $_SESSION['new-project']['fields']['title'] = $_POST['title'];
            $_SESSION['new-project']['title'] = $_POST['title'];
            if (strlen($_SESSION['new-project']['title']) > 10)
                $_SESSION['new-project']['title'] = substr($_SESSION['new-project']['title'], 0, 10) . "...";

            $_SESSION['new-project']['stage'] = 4;
        }
        elseif ($_SESSION['new-project']['stage'] == 4) {
            if (isset($_POST['manager'])) {
                $_SESSION['new-project']['manager'] = $_POST['manager'];
                $_SESSION['new-project']['manager-name'] = Database::selectAccountByID($_POST['manager'])['username'];
            }
            else
                $_SESSION['new-project']['manager-name'] = "None";
            if (strlen($_SESSION['new-project']['manager-name']) > 10)
                $_SESSION['new-project']['manager-name'] = substr($_SESSION['new-project']['manager-name'], 0, 10) . "...";

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
                $_SESSION['new-assignment']['project'] = Project::selectAdminProjectStatic($_SESSION['new-assignment']['fields']['projectid'])['project_title'];
                $_SESSION['new-assignment']['stage'] = '2';
                $redirect = "new-assignment";
                header('Location: ' . $redirect);
            }
            else
                $_SESSION['new-project']['stage'] = 5;
        }
        elseif ($_SESSION['new-project']['stage'] == 5) {
            if (isset($_POST['new-assignment'])) {
                $_SESSION['new-project']['new-assignment'] = true;
                header("Location: new-assignment");
            }

            if (isset($_POST['del-assignment'])) {
                unset($_SESSION['new-project']['assignments'][$_POST['del-assignment']]);
            }

            if ($_POST['submit'] == "SAVE") {
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
                            'statusid' => 2,
                            'time' => date("Y-m-d H-i-s"),
                            'assigned_by' => $account->id,
                            'note' => "New Assignment"
                        ];
                        // Insert to `assignment_status` table and save ID of the new record
                        $statusID = Assignment::insert('assignment_status', $fieldsStatus, true, null);
                        // Update `assignment` table record with saved ID status
                        Assignment::update('assignment', $assignment['fields']['assignmentid'], ["statusid" => $statusID], null);

                        if ($assignment['tasks']) {
                            $taskNumber = 1;
                            foreach ($assignment['tasks'] as $task) {
                                $fieldsTask = [
                                    'assignmentid' => $assignment['fields']['assignmentid'],
                                    'presetid' => $task['id'],
                                    'objective' => $task['objective'],
                                    'description' => $task['description'],
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
    }
    if (isset($_POST['stage'])) {
        $_SESSION['new-project']['stage'] = 2;
    }
    if (isset($_POST['cancel']))
        unset($_SESSION['new-project']);

    if ($account->type == 1) { ?>
        <div class="menu"> <?php
        if ($_SESSION['new-project']['stage'] == 1) { ?>
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
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
                </div>
                <div class="section">
                    <div class="stage active">PRESET:</div>
                </div>
                <div class="section">
                    <div class="stage admin">CLIENT:</div>
                </div>
                <div class="section">
                    <div class="stage admin">NAME:</div>
                </div>
                <div class="section">
                    <div class="stage admin">MANAGER:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">ASSIGNMENTS:</div>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 20%">Name</div>
                    <div class="head admin" style="width: 50%">Description</div>
                    <div class="head admin" style="width: 15%">Assignments</div>
                    <div class="head admin" style="width: 7.5%">Add</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                $projectPresets = Project::selectPresets();
                foreach ($projectPresets as $preset) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $preset['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $preset['title']; ?>" class="content"></div>
                        <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                        <input type="hidden" name="preset" value="<?php echo $preset['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        elseif ($_SESSION['new-project']['stage'] == 2) {
            if (!isset($_SESSION['new-project']['new-client'])) { ?>
                <div class="head-up-display-bar">
                    <span>+ New Project: Add Client</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="new-client">
                        <input type="submit" name="submit" value="+ New Client" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="submit" name="submit" value="NO CLIENT" class="button admin-menu">
                    </form>
                </div> <?php
                $clients = Project::selectClients(); ?>
                <div class="info-bar extended">
                    <div class="section line-right">
                        <div class="stage admin">№:</div>
                        <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
                    </div>
                    <div class="section">
                        <div class="stage admin">PRESET:</div>
                        <div class="content"><?php echo $_SESSION['new-project']['preset']; ?></div>
                    </div>
                    <div class="section">
                        <div class="stage active">CLIENT:</div>
                    </div>
                    <div class="section">
                        <div class="stage admin">NAME:</div>
                    </div>
                    <div class="section">
                        <div class="stage admin">MANAGER:</div>
                    </div>
                    <div class="section line-left">
                        <div class="stage admin">ASSIGNMENTS:</div>
                    </div>
                </div>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 60%">Client Name</div>
                        <div class="head admin" style="width: 10%">Projects</div>
                        <div class="head admin" style="width: 15%">Client Since</div>
                        <div class="head admin" style="width: 7.5%">Add</div>
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
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
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
                        <input type="submit" name="submit" value="Save" class="button admin-menu">
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
        elseif ($_SESSION['new-project']['stage'] == 3) { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Enter Name</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="test" name="test" method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PRESET:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['preset']; ?></div>
                </div>
                <form method="post" class="section">
                    <input type="submit" name="stage" class="stage admin" value="CLIENT:">
                    <div class="content"><?php echo $_SESSION['new-project']['client']; ?></div>
                </form>
                <div class="section">
                    <div class="stage active">NAME:</div>
                </div>
                <div class="section">
                    <div class="stage admin">MANAGER:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">ASSIGNMENTS:</div>
                </div>
            </div>
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
                    <input form="test" name="title" id="title" class="field admin" placeholder="Enter Project Name Here">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-project']['stage'] == 4) { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Add Manager</span>
            </div>
            <div class="navbar level-1 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="manager" value="<?php echo $account->id; ?>">
                    <input type="submit" name="submit" value="I WILL DO IT" class="button admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="NO ONE" class="button admin-menu">
                </form>
            </div> <?php
            $presets = Project::selectMemberCount(); ?>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PRESET:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['preset']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">CLIENT:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['client']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">NAME:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['title']; ?></div>
                </div>
                <div class="section">
                    <div class="stage active">MANAGER:</div>
                </div>
                <div class="section line-left">
                    <div class="stage admin">ASSIGNMENTS:</div>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">№</div>
                    <div class="head admin" style="width: 40%">Member Name</div>
                    <div class="head admin" style="width: 30%">Membership</div>
                    <div class="head admin" style="width: 15%">Managing Projects</div>
                    <div class="head admin" style="width: 7.5%">Add</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div>
            <div class="table admin"> <?php
                $members = Project::selectMembers();
                foreach ($members as $member) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $member['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 40%"><input type="submit" name="submit" value="<?php echo $member['username']; ?>" class="content"></div>
                        <div class="cell" style="width: 30%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo "? Projects"; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                        <input type="hidden" name="manager" value="<?php echo $member['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        elseif ($_SESSION['new-project']['stage'] == 5) { ?>
            <div class="head-up-display-bar">
                <span>+ New Project: Assignments</span>
            </div>
            <div class="navbar level-1 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="new-assignment">
                    <input type="submit" name="submit" value="+ New Assignment" class="button admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
            </div>
            <div class="info-bar extended">
                <div class="section line-right">
                    <div class="stage admin">№:</div>
                    <div class="content"><?php echo "#" . sprintf('%04d', Project::selectNextNewID('project')); ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">PRESET:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['preset']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">CLIENT:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['client']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">NAME:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['title']; ?></div>
                </div>
                <div class="section">
                    <div class="stage admin">MANAGER:</div>
                    <div class="content"><?php echo $_SESSION['new-project']['manager-name']; ?></div>
                </div>
                <div class="section line-left">
                    <div class="stage active">ASSIGNMENTS:</div>
                    <div class="content"><?php if (isset($_SESSION['new-project']['assignments'])) echo count($_SESSION['new-project']['assignments']); else echo "0"; ?></div>
                </div>
            </div>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%">Number</div>
                    <div class="head admin" style="width: 20%">Name</div>
                    <div class="head admin" style="width: 15%">Type</div>
                    <div class="head admin" style="width: 15%">Department</div>
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
                            <div class="cell" style="width: 20%"><input type="submit" name="submit" value="<?php echo $assignment['fields']['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $assignment['fields']['type']; ?>" class="content"></div>
                            <div class="cell" style="width: 15%"><input type="submit" name="submit" value="<?php echo $assignment['fields']['departmentid']; ?>" class="content"></div>
                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $assignment['fields']['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content add-button"></div>
                            <input type="hidden" name="del-assignment" value="<?php echo $num; ?>">
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