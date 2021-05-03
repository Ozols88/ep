<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-department']))
            $_SESSION['new-department']['stage'] = '1';
        if (!isset($_SESSION['new-department']['info']['title']))
            $_SESSION['new-department']['info']['title'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-department']['stage'] == '1') {
                $_SESSION['new-department']['fields']['title'] = $_POST['title'];
                $_SESSION['new-department']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-department']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-department']['info']['title'] = substr($_SESSION['new-department']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-department']['stage'] = '2';
                if (!isset($_SESSION['new-department']['info']['description']))
                    $_SESSION['new-department']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-department']['stage'] == '2') {
                $_SESSION['new-department']['fields']['description'] = $_POST['description'];
                $_SESSION['new-department']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-department']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-department']['info']['description'] = substr($_SESSION['new-department']['info']['description'], 0, InfobarCharLimit) . "...";

                $departID = Database::insert('department', $_SESSION['new-department']['fields'], true, false);
                header('Location: ../r&d.php?dp=' . $departID . '&l1=overview');
                unset($_SESSION['new-department']);
                exit();
            }

            if (empty($_SESSION['new-department']['info']['title'])) $_SESSION['new-department']['stage'] = '1';
            else $_SESSION['new-department']['stage'] = '2';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-department']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-department']['stage'] = '2';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-department']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-department']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Department: Enter Name</span>
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
                    <div class="head admin">Department Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="title" name="title" id="title" class="field admin" placeholder="Enter Department Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-department']['fields']['title'])) echo $_SESSION['new-department']['fields']['title']; ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-department']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Department: Enter Description</span>
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
                    <div class="head admin">Department Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Department Description Here" maxlength="200" value="<?php if (isset($_SESSION['new-department']['fields']['description'])) echo $_SESSION['new-department']['fields']['description']; ?>">
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