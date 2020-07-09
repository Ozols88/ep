<?php
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    // If redirected from assignment creation page
    if (isset($_SESSION['new-assignment']['new-task']) && !isset($_SESSION['new-task']['stage'])) {
        $_SESSION['new-task']['stage'] = '1c';
    }
    // if redirected from existing assignment
    elseif (isset($_GET['a']) && !isset($_SESSION['new-task']['stage'])) {
        $_SESSION['assignment'] = Assignment::selectAssignmentByID($_GET['a']);
        if ($_SESSION['assignment']['presetid'] != null)
            $_SESSION['new-task']['stage'] = '1';
        else
            $_SESSION['new-task']['stage'] = '1c';
    }
    // Start task numbering
    if (!isset($_SESSION['num']['new-task']))
        $_SESSION['num']['new-task'] = 1;
    // Info bar fix
    if (!isset($_SESSION['new-task']['objective']))
        $_SESSION['new-task']['objective'] = "";

    require_once "includes/header.php";

    if (isset($_POST['submit'])) {
        if ($_SESSION['new-task']['stage'] == '1') {
            if (isset($_POST['task'])) {
                $_SESSION['new-task']['fieldsPreset'] = Task::selectTaskPreset($_POST['task']);
                $_SESSION['new-task']['fields'] = [
                    'assignmentid' => $_GET['a'],
                    'presetid' => $_SESSION['new-task']['fieldsPreset']['id'],
                    'objective' => $_SESSION['new-task']['fieldsPreset']['objective'],
                    'description' => $_SESSION['new-task']['fieldsPreset']['description'],
                    'actionid' => $_SESSION['new-task']['fieldsPreset']['actionid'],
                    'estimated' => $_SESSION['new-task']['fieldsPreset']['estimated']
                ];

                $projectID = Assignment::selectAssignmentByID($_GET['a'])['projectid'];
                $number = Task::RenumberTasksInProject($projectID);
                $_SESSION['new-task']['fields']['number'] = $number;
                $taskID = Task::insert('task', $_SESSION['new-task']['fields'], true, null);

                $fieldsStatus = [
                    'taskid' => $taskID,
                    'statusid' => 1,
                    'time' => date("Y-m-d H-i-s"),
                    'assigned_by' => $account->id,
                    'note' => "New Task"
                ];
                $statusID = Task::insert('task_status', $fieldsStatus, true, null);
                Task::update('task', $taskID, ["statusid" => $statusID], null);

                $redirect = "assignments.php?a=" . $_GET['a'] . "&l1=tasks&l2=" . $taskID;
                header("Location: " . $redirect);
                unset($_SESSION['new-task']);
            }
        }
        // c = custom
        if ($_SESSION['new-task']['stage'] == '1c') {
            $_SESSION['new-task']['fields']['objective'] = $_POST['objective'];
            $_SESSION['new-task']['objective'] = $_POST['objective'];
            if (strlen($_SESSION['new-task']['fields']['objective']) > 10)
                $_SESSION['new-task']['objective'] = substr($_POST['objective'], 0, 10) . "...";

            $_SESSION['new-task']['stage'] = '2c';
            if (!isset($_SESSION['new-task']['description']))
                $_SESSION['new-task']['description'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-task']['stage'] == '2c') {
            $_SESSION['new-task']['fields']['description'] = $_POST['description'];
            $_SESSION['new-task']['description'] = $_POST['description'];
            if (strlen($_SESSION['new-task']['fields']['description']) > 10)
                $_SESSION['new-task']['description'] = substr($_POST['description'], 0, 10) . "...";

            $_SESSION['new-task']['stage'] = '3c';
            if (!isset($_SESSION['new-task']['action']))
                $_SESSION['new-task']['action'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-task']['stage'] == '3c') {
            $_SESSION['new-task']['fields']['actionid'] = $_POST['action'];
            $_SESSION['new-task']['action'] = Task::selectAction($_POST['action'])['title'];
            if (strlen($_SESSION['new-task']['action']) > 10)
                $_SESSION['new-task']['action'] = substr($_SESSION['new-task']['action'], 0, 10) . "...";

            $_SESSION['new-task']['stage'] = '4c';
            if (!isset($_SESSION['new-task']['value']))
                $_SESSION['new-task']['value'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-task']['stage'] == '4c') {
            if (isset($_POST['type-page'])) {
                unset($_SESSION['new-task']['valueType']);
                $_SESSION['new-task']['value'] = "";
                unset($_SESSION['new-task']['fields']['value']);
                unset($_SESSION['new-task']['fields']['estimated']);
            }

            if (isset($_POST['value'])) {
                $_SESSION['new-task']['value'] = "";
                if ($_POST['value'] == 'price') $_SESSION['new-task']['valueType'] = 'price';
                elseif ($_POST['value'] == 'time') $_SESSION['new-task']['valueType'] = 'time';
                elseif ($_POST['value'] == 'none') {
                    $_SESSION['new-task']['value'] = "None";

                    $_SESSION['new-task']['stage'] = '7c';
                    if (!isset($_SESSION['new-task']['links']))
                        $_SESSION['new-task']['links'] = ""; // Info bar fix
                }
            }

            if (isset($_POST['price'])) {
                unset($_SESSION['new-task']['fields']['estimated']); // Unset time
                $_SESSION['new-task']['fields']['value'] = $_POST['price'];
                $_SESSION['new-task']['value'] = $_POST['price'];
                if (strlen($_SESSION['new-task']['value']) > 10)
                    $_SESSION['new-task']['value'] = substr($_SESSION['new-task']['value'], 0, 10) . "...";

                $_SESSION['new-task']['stage'] = '7c';
                if (!isset($_SESSION['new-task']['links']))
                    $_SESSION['new-task']['links'] = ""; // Info bar fix
            }

            elseif (isset($_POST['time'])) {
                unset($_SESSION['new-task']['fields']['value']); // Unset price
                $_SESSION['new-task']['fields']['estimated'] = $_POST['time'];
                $_SESSION['new-task']['value'] = $_POST['time'];
                if (strlen($_SESSION['new-task']['value']) > 10)
                    $_SESSION['new-task']['value'] = substr($_SESSION['new-task']['value'], 0, 10) . "...";

                $_SESSION['new-task']['stage'] = '7c';
                if (!isset($_SESSION['new-task']['links']))
                    $_SESSION['new-task']['links'] = ""; // Info bar fix
            }
        }
        elseif ($_SESSION['new-task']['stage'] == '7c') {
            if (isset($_POST['new-link']))
                $_SESSION['new-task']['new-link']['stage'] = 1;

            if (isset($_POST['del-link']))
                unset($_SESSION['new-task']['links'][$_POST['del-link']]);

            if ($_POST['submit'] == "SAVE") {
                // From new-assignment
                if (isset($_SESSION['new-assignment']['new-task'])) {
                    if ($_SESSION['new-assignment']['tasks'] == "")
                        $_SESSION['new-assignment']['tasks'] = null;
                    $_SESSION['new-assignment']['tasks'][$_SESSION['num']['new-task']]['fields'] = [
                        'objective' => $_SESSION['new-task']['fields']['objective'],
                        'description' => $_SESSION['new-task']['fields']['description'],
                        'actionid' => $_SESSION['new-task']['fields']['actionid'],
                        'presetid' => null
                    ];
                    $_SESSION['new-assignment']['tasks'][$_SESSION['num']['new-task']++]['action'] = Task::selectAction($_SESSION['new-task']['fields']['actionid'])['title'];
                    unset($_SESSION['new-assignment']['new-task']);
                    unset($_SESSION['new-task']);
                    header('Location: new-assignment.php');
                }
                // From assignment
                elseif (isset($_GET['a'])) {
                    $_SESSION['new-task']['fields']['assignmentid'] = $_GET['a'];
                    $taskID = Task::insert('task', $_SESSION['new-task']['fields'], true, null);

                    $fieldsStatus = [
                        'taskid' => $taskID,
                        'statusid' => 1,
                        'time' => date("Y-m-d H-i-s"),
                        'assigned_by' => $account->id,
                        'note' => "New Task"
                    ];
                    $statusID = Task::insert('task_status', $fieldsStatus, true, null);
                    Task::update('task', $taskID, ["statusid" => $statusID], null);

                    unset($_SESSION['new-task']);
                    header('Location: assignments.php?a=' . $_GET['a'] . '&l1=tasks&l2=' . $taskID);
                }
            }
        }

        if ($_SESSION['new-task']['stage'] != 1) {
            if (empty($_SESSION['new-task']['objective'])) $_SESSION['new-task']['stage'] = '1c';
            elseif (empty($_SESSION['new-task']['description'])) $_SESSION['new-task']['stage'] = '2c';
            elseif (empty($_SESSION['new-task']['action'])) $_SESSION['new-task']['stage'] = '3c';
            elseif (empty($_SESSION['new-task']['value'])) $_SESSION['new-task']['stage'] = '4c';
            else $_SESSION['new-task']['stage'] = '7c';
        }
    }
    if (isset($_POST['stage1c'])) $_SESSION['new-task']['stage'] = '1c';
    if (isset($_POST['stage2c'])) $_SESSION['new-task']['stage'] = '2c';
    if (isset($_POST['stage3c'])) $_SESSION['new-task']['stage'] = '3c';
    if (isset($_POST['stage4c'])) $_SESSION['new-task']['stage'] = '4c';
    if (isset($_POST['stage5c'])) $_SESSION['new-task']['stage'] = '5c';
    if (isset($_POST['stage6c'])) $_SESSION['new-task']['stage'] = '6c';
    if (isset($_POST['stage7c'])) $_SESSION['new-task']['stage'] = '7c'; ?>

    <div class="menu"> <?php
    if ($_SESSION['new-task']['stage'] == '1') { ?>
        <div class="head-up-display-bar">
            <span>+ New Task: Add Task</span>
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
        $_SESSION['new-task']['presetTasks'] = Task::selectAssignmentPresetTasks($_SESSION['assignment']['presetid']);
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
            if (isset($_SESSION['new-task']['presetTasks'])) {
                foreach ($_SESSION['new-task']['presetTasks'] as $task) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $task['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $task['objective']; ?>" class="content"></div>
                        <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                        <div class="cell" style="width: 10%"><input type="submit" name="submit" value="<?php echo $task['estimated']; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                        <input type="hidden" name="task" value="<?php echo $task['id']; ?>">
                    </form> <?php
                }
            }
            else { ?>
                <div class="empty-table">NO TASK PRESETS</div> <?php
            } ?>
        </div> <?php
    }

    elseif ($_SESSION['new-task']['stage'] == '1c') { ?>
        <div class="head-up-display-bar">
            <span>+ New Task: Enter Objective</span>
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
                <div class="head admin">Task Objective</div>
            </div>
            <div class="header-extension medium admin"></div>
        </div>
        </div>
        <div class="table medium">
            <div class="row">
                <input form="objective" name="objective" id="objective" class="field admin" placeholder="Enter Task Objective Here">
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
                <div class="head admin">Task Description</div>
            </div>
            <div class="header-extension medium admin"></div>
        </div>
        </div>
        <div class="table medium">
            <div class="row">
                <textarea form="description" name="description" id="description" class="field admin" placeholder="Enter Task Description Here"></textarea>
            </div>
        </div> <?php
    }
    elseif ($_SESSION['new-task']['stage'] == '3c') { ?>
        <div class="head-up-display-bar">
            <span>+ New Task: Select Task Action</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
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
                <div class="head admin" style="width: 35%">Task Action</div>
                <div class="head admin" style="width: 50%">Description</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div> <?php
        $actions = Task::selectActions();
        if (isset($actions)) { ?>
            <div class="table admin"> <?php
                foreach ($actions as $action) { ?>
                    <form method="post" class="row">
                        <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $action['id']); ?>" class="content"></div>
                        <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $action['title']; ?>" class="content"></div>
                        <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $action['description']; ?>" class="content"></div>
                        <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                        <input type="hidden" name="action" value="<?php echo $action['id']; ?>">
                    </form> <?php
                } ?>
            </div> <?php
        }
        else { ?>
            <div class="empty-table">NO ACTIONS</div> <?php
        }
    }
    elseif ($_SESSION['new-task']['stage'] == '4c') {
        if (!isset($_SESSION['new-task']['valueType'])) { ?>
            <div class="head-up-display-bar">
                <span>+ New Task: Value</span>
            </div>
            <div class="navbar level-1 current unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="value" value="price">
                    <input type="submit" name="submit" value="PRICE" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="value" value="none">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
                <form method="post" class="container-button">
                    <input type="hidden" name="value" value="time">
                    <input type="submit" name="submit" value="TIME" class="button admin-menu">
                    <div class="home-menu"></div>
                </form>
            </div>
            </div> <?php
        }
        else {
            if ($_SESSION['new-task']['valueType'] == 'price') { ?>
                <div class="head-up-display-bar">
                    <span>+ New Task: Enter Price</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="type-page">
                        <input type="submit" name="submit" value="CHOOSE DIFFERENT VALUE TYPE" class="button admin-menu">
                    </form>
                    <form id="price" name="price" method="post" class="container-button">
                        <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                    </form>
                </div> <?php
                include_once "includes/info-bar.php"; ?>
                <div class="table-header-container">
                    <div class="header-extension medium admin"></div>
                    <div class="header medium">
                        <div class="head admin">Task Price</div>
                    </div>
                    <div class="header-extension medium admin"></div>
                </div>
                </div>
                <div class="table medium">
                    <div class="row">
                        <input type="number" min="0" step="1" form="price" name="price" id="price" class="field admin" placeholder="Enter Task Price Here">
                    </div>
                </div> <?php
            }
            elseif ($_SESSION['new-task']['valueType'] == 'time') { ?>
                <div class="head-up-display-bar">
                    <span>+ New Task: Enter Time</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="type-page">
                        <input type="submit" name="submit" value="CHOOSE DIFFERENT VALUE TYPE" class="button admin-menu">
                    </form>
                    <form id="time" name="time" method="post" class="container-button">
                        <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                    </form>
                </div> <?php
                include_once "includes/info-bar.php"; ?>
                <div class="table-header-container">
                    <div class="header-extension medium admin"></div>
                    <div class="header medium">
                        <div class="head admin">Task Time</div>
                    </div>
                    <div class="header-extension medium admin"></div>
                </div>
                </div>
                <div class="table medium">
                    <form class="row">
                        <select form="time" name="time" id="time" class="field admin">
                            <option value="00:05:00">5 min</option>
                            <option value="00:10:00">10 min</option>
                            <option value="00:15:00">15 min</option>
                            <option value="00:20:00">20 min</option>
                            <option value="00:25:00">25 min</option>
                            <option value="00:30:00">30 min</option>
                        </select>
                    </form>
                </div> <?php
            }
        }
    }
    elseif ($_SESSION['new-task']['stage'] == '5c') { ?>
        <div class="head-up-display-bar">
            <span>+ New Task:</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
        </div> <?php
        include_once "includes/info-bar.php"; ?>
        <div class="table-header-container">
            <div class="header-extension admin"></div>
            <div class="header">
                <div class="head admin" style="width: 7.5%">№</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div> <?php
    }
    elseif ($_SESSION['new-task']['stage'] == '6c') { ?>
        <div class="head-up-display-bar">
            <span>+ New Task:</span>
        </div>
        <div class="navbar level-1 unselected">
            <form class="container-button disabled">
                <a class="button admin-menu disabled"></a>
            </form>
        </div> <?php
        include_once "includes/info-bar.php"; ?>
        <div class="table-header-container">
            <div class="header-extension admin"></div>
            <div class="header">
                <div class="head admin" style="width: 7.5%">№</div>
                <div class="head admin" style="width: 7.5%">Select</div>
            </div>
            <div class="header-extension admin"></div>
        </div>
        </div> <?php
    }
    elseif ($_SESSION['new-task']['stage'] == '7c') {
        if (!isset($_SESSION['new-task']['new-link'])) { ?>
            <div class="head-up-display-bar">
                <span>+ New Task: Links</span>
            </div>
            <div class="navbar level-1 unselected">
                <form method="post" class="container-button">
                    <input type="hidden" name="new-link">
                    <input type="submit" name="submit" value="+ NEW LINK" class="button admin-menu">
                </form>
                <form method="post" class="container-button">
                    <input type="submit" name="submit" value="SAVE" class="button admin-menu">
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension admin"></div>
                <div class="header">
                    <div class="head admin" style="width: 7.5%"></div>
                    <div class="head admin" style="width: 35%">Link Type</div>
                    <div class="head admin" style="width: 25%">Section</div>
                    <div class="head admin" style="width: 25%">Page / Folder</div>
                    <div class="head admin" style="width: 7.5%">Remove</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            if (is_countable($_SESSION['new-task']['links'])) { ?>
                <div class="table admin"> <?php
                    foreach ($_SESSION['new-task']['links'] as $num => $link) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="" class="content"></div>
                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $link['objective']; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                            <div class="cell" style="width: 25%"><input type="submit" name="submit" value="<?php echo "?"; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                            <input type="hidden" name="del-link" value="<?php echo $num; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO LINKS</div> <?php
            }
        }
        else { ?>
            <div class="head-up-display-bar">
                <span>+ New Task: Select Link Type</span>
            </div>
            <div class="navbar level-1 unselected<?php if (!isset($_GET['l1'])) echo " current"; ?>">
                <div class="container-button">
                    <a href="?l1=info" class="button admin-menu">INFO</a>
                    <?php if (!isset($_GET['l1'])) { ?><div class="home-menu"></div> <?php } ?>
                </div>
                <div class="container-button">
                    <a href="?l1=resources" class="button admin-menu">RESOURCES</a>
                    <?php if (!isset($_GET['l1'])) { ?><div class="home-menu"></div> <?php } ?>
                </div>
                <div class="container-button">
                    <a href="?l1=r&d" class="button admin-menu">R&D</a>
                    <?php if (!isset($_GET['l1'])) { ?><div class="home-menu"></div> <?php } ?>
                </div>
            </div> <?php
            if (isset($_GET['l1'])) {
                if ($_GET['l1'] == "info") { ?>
                    <div class="navbar level-2 unselected">
                        <form method="post" class="container-button disabled">
                            <input class="button admin-menu disabled">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="new-custom-link">
                            <input type="submit" name="submit" value="+ CUSTOM LINK" class="button admin-menu">
                        </form>
                        <form method="post" class="container-button disabled">
                            <input class="button admin-menu disabled">
                        </form>
                    </div> <?php
                }
                elseif ($_GET['l1'] == "resources") { ?>
                    <div class="navbar level-2 unselected">
                        <form method="post" class="container-button disabled">
                            <input class="button admin-menu disabled">
                        </form>
                        <form method="post" class="container-button">
                            <input type="hidden" name="new-custom-link">
                            <input type="submit" name="submit" value="SAVE " class="button admin-menu">
                        </form>
                        <form method="post" class="container-button disabled">
                            <input class="button admin-menu disabled">
                        </form>
                    </div> <?php
                }
            } ?>
            </div> <?php
        }
    }

    require_once "includes/footer.php";
}
else require_once "login.php";