<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-task-link']['stage'] == '1') {
                if (isset($_POST['type'])) {
                    $_SESSION['new-task-link']['fields']['typeid'] = $_POST['type'];
                    $_SESSION['new-task-link']['info']['type'] = $_POST['type-title'];
                    $_SESSION['new-task-link']['type'] = $_POST['type-title'];
                    if (strlen($_SESSION['new-task-link']['info']['type']) > InfobarCharLimit)
                        $_SESSION['new-task-link']['info']['type'] = substr($_SESSION['new-taskpr']['info']['type'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-task-link']['fields']['typeid'] = null;
                    $_SESSION['new-task-link']['info']['type'] = "None";
                }

                $_SESSION['new-task-link']['stage'] = '2';
                if (!isset($_SESSION['new-task-link']['info']['link']))
                    $_SESSION['new-task-link']['info']['link'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-task-link']['stage'] == '2') {
                if (isset($_POST['link'])) {
                    $_SESSION['new-task-link']['fields']['link'] = $_POST['link'];
                    $_SESSION['new-task-link']['info']['link'] = $_POST['link'];
                    if (strlen($_SESSION['new-task-link']['info']['link']) > InfobarCharLimit)
                        $_SESSION['new-task-link']['info']['link'] = substr($_SESSION['new-task-link']['info']['link'], 0, InfobarCharLimit) . "...";
                }
                else {
                    $_SESSION['new-task-link']['fields']['link'] = null;
                    $_SESSION['new-task-link']['info']['link'] = "None";
                }
                $_SESSION['new-task-link']['stage'] = '3';
                if (!isset($_SESSION['new-task-link']['info']['title']))
                    $_SESSION['new-task-link']['info']['title'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-task-link']['stage'] == '3') {
                $_SESSION['new-task-link']['fields']['title'] = $_POST['title'];
                $_SESSION['new-task-link']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-task-link']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-task-link']['info']['title'] = substr($_SESSION['new-task-link']['info']['title'], 0, InfobarCharLimit) . "...";
                // From existing task preset
                if (isset($_SESSION['new-task-link']['fields']['taskid'])) {
                    Database::insert('preset-task_links', $_SESSION['new-task-link']['fields'], false, false);
                    $preset = Task::selectTaskPreset($_SESSION['new-task-link']['fields']['taskid']);
                    Database::update('preset-task', $_SESSION['new-task-link']['fields']['taskid'], ['date_updated' => date("Y-m-d H-i-s"), 'times_updated' => ++$preset['times_updated']], false);
                    if ($_SESSION['new-task-link']['redirect'] == 1)
                        header('Location: ../r&d.php?t=' . $_SESSION['new-task-link']['fields']['taskid'] . "&l1=links");
                    else
                        header('Location: ../r&d.php?t=' . $_SESSION['new-task-link']['fields']['taskid'] . "&options&l1=edit&l2=links");
                    unset($_SESSION['new-task-link']);
                    exit();
                }
                // From new task preset
                else {
                    if ($_SESSION['new-taskpr']['links'] == "")
                        $_SESSION['new-taskpr']['links'] = null;
                    $_SESSION['new-taskpr']['links'][$_SESSION['new-taskpr']['linkNum']] = $_SESSION['new-task-link'];
                    unset($_SESSION['new-task-link']);
                    header('Location: task.php');
                    exit();
                }
            }

            if (empty($_SESSION['new-task-link']['info']['type'])) $_SESSION['new-task-link']['stage'] = '1';
            elseif (empty($_SESSION['new-task-link']['info']['link'])) $_SESSION['new-task-link']['stage'] = '2';
            else $_SESSION['new-task-link']['stage'] = '3';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-task-link']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-task-link']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-task-link']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-task-link']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-task-link']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Task Link Preset</span>
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
            include_once "../includes/info-bar.php";
            $types = Task::selectLinkTypes(); ?>
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
            if ($types) { ?>
                <div class="table admin"> <?php
                    foreach ($types as $type) { ?>
                        <form method="post" class="row">
                            <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%02d', $type['id']); ?>" class="content"></div>
                            <div class="cell name" style="width: 35%"><input type="submit" name="submit" value="<?php echo $type['title']; ?>" class="content"></div>
                            <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $type['description']; ?>" class="content"></div>
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
        elseif ($_SESSION['new-task-link']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Task Link Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form id="none" name="none" method="post" class="container-button">
                    <input type="submit" name="submit" value="NONE" class="button admin-menu">
                </form>
                <form id="submit" name="submit" method="post" class="container-button">
                    <input type="submit" name="submit" value="NEXT" class="button admin-menu">
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
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
                    <input form="submit" name="link" id="link" class="field admin" placeholder="Paste Link URL Here" value="<?php if (isset($_SESSION['new-task-link']['fields']['link'])) echo htmlspecialchars($_SESSION['new-task-link']['fields']['link']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }
        elseif ($_SESSION['new-task-link']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>New Task Link Preset</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="submit" name="submit" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
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
                    <input form="submit" name="title" id="title" class="field admin" placeholder="Enter Link Name Here" value="<?php if (isset($_SESSION['new-task-link']['fields']['title'])) echo htmlspecialchars($_SESSION['new-task-link']['fields']['title']); ?>">
                </div>
            </div> <?php
            if (isset($errorMsg))
                echo $errorMsg;
        }

        require_once "../includes/footer.php";

    }
    else {
        header('Location: ../error.php');
    }
}
else require_once "../login.php";