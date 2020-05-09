<?php
$page = "assignments";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if (isset($_SESSION['new-assignment']['new-task']) && !isset($_SESSION['new-task']['stage'])) {
        $_SESSION['new-task']['stage'] = 1;
    }
    if (!isset($_SESSION['num']['new-task']))
        $_SESSION['num']['new-task'] = 1;
    if (!isset($_SESSION['new-task']['objective']))
        $_SESSION['new-task']['objective'] = ""; // Info bar fix

    require_once "includes/header.php";

    if (isset($_POST['submit'])) {
        if ($_SESSION['new-task']['stage'] == '1') {
            $_SESSION['new-task']['fields']['objective'] = $_POST['objective'];
            $_SESSION['new-task']['objective'] = $_POST['objective'];
            if (strlen($_SESSION['new-task']['fields']['objective']) > 10)
                $_SESSION['new-task']['objective'] = substr($_POST['objective'], 0, 10) . "...";

            $_SESSION['new-task']['stage'] = '2';
            if (!isset($_SESSION['new-task']['description']))
                $_SESSION['new-task']['description'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-task']['stage'] == '2') {
            $_SESSION['new-task']['fields']['description'] = $_POST['description'];
            $_SESSION['new-task']['description'] = $_POST['description'];
            if (strlen($_SESSION['new-task']['fields']['description']) > 10)
                $_SESSION['new-task']['description'] = substr($_POST['description'], 0, 10) . "...";

            $_SESSION['new-task']['stage'] = '3';
            if (!isset($_SESSION['new-task']['action']))
                $_SESSION['new-task']['action'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-task']['stage'] == '3') {
            $_SESSION['new-task']['fields']['actionid'] = $_POST['action'];
            $_SESSION['new-task']['action'] = Task::selectAction($_POST['action'])['title'];
            if (strlen($_SESSION['new-task']['action']) > 10)
                $_SESSION['new-task']['action'] = substr($_SESSION['new-task']['action'], 0, 10) . "...";

            $_SESSION['new-task']['stage'] = '4';
            if (!isset($_SESSION['new-task']['links']))
                $_SESSION['new-task']['links'] = ""; // Info bar fix
        }
        elseif ($_SESSION['new-task']['stage'] == '4') {
            if (isset($_POST['new-link']))
                $_SESSION['new-task']['new-link']['stage'] = 1;

            if (isset($_POST['del-link']))
                unset($_SESSION['new-task']['links'][$_POST['del-link']]);

            if ($_POST['submit'] == "SAVE") {
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
        }

        if (empty($_SESSION['new-task']['objective'])) $_SESSION['new-task']['stage'] = '1';
        elseif (empty($_SESSION['new-task']['description'])) $_SESSION['new-task']['stage'] = '2';
        elseif (empty($_SESSION['new-task']['action'])) $_SESSION['new-task']['stage'] = '3';
        else $_SESSION['new-task']['stage'] = '4';
    }
    if (isset($_POST['stage1'])) $_SESSION['new-task']['stage'] = '1';
    if (isset($_POST['stage2'])) $_SESSION['new-task']['stage'] = '2';
    if (isset($_POST['stage3'])) $_SESSION['new-task']['stage'] = '3';
    if (isset($_POST['stage4'])) $_SESSION['new-task']['stage'] = '4';

    if ($account->type == 1) { ?>
        <div class="menu"> <?php
        if ($_SESSION['new-task']['stage'] == '1') { ?>
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
        elseif ($_SESSION['new-task']['stage'] == '2') { ?>
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
        elseif ($_SESSION['new-task']['stage'] == '3') { ?>
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
        elseif ($_SESSION['new-task']['stage'] == '4') {
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
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content add-button"></div>
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
    }

    require_once "includes/footer.php";
}
else require_once "login.php";