<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-linktype']))
            $_SESSION['new-linktype']['stage'] = '1';
        if (!isset($_SESSION['new-linktype']['info']['title']))
            $_SESSION['new-linktype']['info']['title'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-linktype']['stage'] == '1') {
                $_SESSION['new-linktype']['fields']['title'] = $_POST['title'];
                $_SESSION['new-linktype']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-linktype']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-linktype']['info']['title'] = substr($_SESSION['new-linktype']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-linktype']['stage'] = '2';
                if (!isset($_SESSION['new-linktype']['info']['description']))
                    $_SESSION['new-linktype']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-linktype']['stage'] == '2') {
                $_SESSION['new-linktype']['fields']['description'] = $_POST['description'];
                $_SESSION['new-linktype']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-linktype']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-linktype']['info']['description'] = substr($_SESSION['new-linktype']['info']['description'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-linktype']['fields']['date_created'] = date("Y-m-d H-i-s");
                $typeID = Database::insert('link_type', $_SESSION['new-linktype']['fields'], true, false);

                // From new task link
                if (isset($_SESSION['new-task-link']['new-linktype'])) {
                    $_SESSION['new-task-link']['fields']['typeid'] = $typeID;
                    $_SESSION['new-task-link']['info']['type'] = $_SESSION['new-linktype']['fields']['title'];
                    header('Location: task-link.php');
                    unset($_SESSION['new-task-link']['new-linktype']);
                    unset($_SESSION['new-linktype']);
                    exit();
                }
                // From new link type
                else {
                    header('Location: ../r&d.php?lt=' . $typeID . '&l1=overview');
                    unset($_SESSION['new-linktype']);
                    exit();
                }
            }

            if (empty($_SESSION['new-linktype']['info']['title'])) $_SESSION['new-linktype']['stage'] = '1';
            else $_SESSION['new-linktype']['stage'] = '2';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-linktype']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-linktype']['stage'] = '2';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-linktype']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-linktype']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Task Link Type</span>
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
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension small admin"></div>
                <div class="header small">
                    <div class="head admin">Link Type Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="title" name="title" id="title" class="field admin" placeholder="Enter Link Type Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-linktype']['fields']['title'])) echo htmlspecialchars($_SESSION['new-linktype']['fields']['title']); ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-linktype']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Task Link Type</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="description" name="description" method="post" class="container-button">
                    <input type="submit" name="submit" value="Save" class="button admin-menu">
                </form>
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
            </div> <?php
            include_once "../includes/info-bar.php"; ?>
            <div class="table-header-container">
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Link Type Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Link Type Description Here" maxlength="200" value="<?php if (isset($_SESSION['new-linktype']['fields']['description'])) echo htmlspecialchars($_SESSION['new-linktype']['fields']['description']); ?>">
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