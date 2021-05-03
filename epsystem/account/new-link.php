<?php
$page = "assignments";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-link']))
            header('Location: assignments.php');

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-link']['stage'] == '1') {
                if (isset($_POST['type'])) {
                    $_SESSION['new-link']['fields']['typeid'] = $_POST['type'];
                    $_SESSION['new-link']['type'] = $_POST['type-title'];
                    if (strlen($_SESSION['new-link']['type']) > InfobarCharLimit)
                        $_SESSION['new-link']['type'] = substr($_POST['type-title'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-link']['fields']['typeid'] = null;
                    $_SESSION['new-link']['type'] = "None";
                }

                $_SESSION['new-link']['stage'] = '2c';
                if (!isset($_SESSION['new-link']['link']))
                    $_SESSION['new-link']['link'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-link']['stage'] == '2') {
                $_SESSION['new-link']['fields']['link'] = $_POST['link'];
                $_SESSION['new-link']['link'] = $_POST['link'];
                if (strlen($_SESSION['new-link']['link']) > InfobarCharLimit)
                    $_SESSION['new-link']['link'] = substr($_POST['link'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-link']['stage'] = '2c';
                if (!isset($_SESSION['new-link']['title']))
                    $_SESSION['new-link']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-link']['stage'] == '3') {
                $_SESSION['new-link']['fields']['title'] = $_POST['title'];
                $_SESSION['new-link']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-link']['title']) > InfobarCharLimit)
                    $_SESSION['new-link']['title'] = substr($_POST['title'], 0, InfobarCharLimit) . "...";

                // From new-task
                if (isset($_SESSION['new-task']['new-link'])) {
                    if ($_SESSION['new-task']['links'] == "")
                        $_SESSION['new-task']['links'] = null;
                    $_SESSION['new-task']['links'][$_SESSION['new-task']['linkNum']] = $_SESSION['new-link'];
                    header('Location: new-task.php');
                    unset($_SESSION['new-task']['new-link']);
                    unset($_SESSION['new-link']);
                    exit();
                }
                // From task edit, links
                elseif (isset($_SESSION['new-link']['fields']['taskid'])) {
                    Database::insert('task_link', $_SESSION['new-link']['fields'], false, "assignments.php?t=" . $_SESSION['new-link']['fields']['taskid'] . "&options&l1=edit&l2=links");
                    unset($_SESSION['new-link']);
                    exit();
                }
            }

            if (empty($_SESSION['new-link']['type'])) $_SESSION['new-link']['stage'] = '1';
            elseif (empty($_SESSION['new-link']['link'])) $_SESSION['new-link']['stage'] = '2';
            else $_SESSION['new-link']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-link']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-link']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-link']['stage'] = '3'; ?>

        <div class="menu"> <?php
        if ($_SESSION['new-link']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>Select type of new link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="none" name="none" method="post" class="container-button">
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
                    <div class="head admin" style="width: 35%">Link Type Name</div>
                    <div class="head admin" style="width: 50%">Description</div>
                    <div class="head admin" style="width: 7.5%">Select</div>
                </div>
                <div class="header-extension admin"></div>
            </div>
            </div> <?php
            $types = Task::selectLinkTypes();
            if (isset($types)) { ?>
                <div class="table admin"> <?php
                    foreach ($types as $type) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $type['id']); ?>" class="content"></div>
                            <div class="cell" style="width: 35%"><input type="submit" name="submit" value="<?php echo $type['title']; ?>" class="content"></div>
                            <div class="cell" style="width: 50%"><input type="submit" name="submit" value="<?php echo $type['description']; ?>" class="content"></div>
                            <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Select" class="content select-button"></div>
                            <input type="hidden" name="type" value="<?php echo $type['id']; ?>">
                            <input type="hidden" name="type-title" value="<?php echo $type['title']; ?>">
                        </form> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="empty-table">NO LINK TYPES</div> <?php
            }
        }
        elseif ($_SESSION['new-link']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>Enter URL of new link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="link" name="link" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Link URL</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="link" name="link" id="link" class="field admin" placeholder="Paste Link URL Here" maxlength="255">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-link']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>Enter name of new link</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="title" name="title" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Link Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="title" name="title" id="title" class="field admin" placeholder="Enter Link Name Here" maxlength="50">
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