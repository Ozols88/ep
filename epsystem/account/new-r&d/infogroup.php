<?php
ob_start();
$page = "r&d";
include "../includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "../includes/header.php";

        if (!isset($_SESSION['new-infogroup']))
            $_SESSION['new-infogroup']['stage'] = '1';
        if (!isset($_SESSION['new-infogroup']['info']['title']))
            $_SESSION['new-infogroup']['info']['title'] = ""; // Info bar fix

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-infogroup']['stage'] == '1') {
                $_SESSION['new-infogroup']['fields']['title'] = $_POST['title'];
                $_SESSION['new-infogroup']['info']['title'] = $_POST['title'];
                if (strlen($_SESSION['new-infogroup']['info']['title']) > InfobarCharLimit)
                    $_SESSION['new-infogroup']['info']['title'] = substr($_SESSION['new-infogroup']['info']['title'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-infogroup']['stage'] = '2';
                if (!isset($_SESSION['new-infogroup']['info']['description']))
                    $_SESSION['new-infogroup']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-infogroup']['stage'] == '2') {
                $_SESSION['new-infogroup']['fields']['description'] = $_POST['description'];
                $_SESSION['new-infogroup']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-infogroup']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-infogroup']['info']['description'] = substr($_SESSION['new-infogroup']['info']['description'], 0, InfobarCharLimit) . "...";

                $groupID = Database::insert('infopage_group', $_SESSION['new-infogroup']['fields'], true, false);

                // From new info page
                if (isset($_SESSION['new-infopage']['new-infogroup'])) {
                    $_SESSION['new-infopage']['fields']['groupid'] = $groupID;
                    $_SESSION['new-infopage']['info']['group'] = $_SESSION['new-infogroup']['fields']['title'];
                    header('Location: info.php');
                    unset($_SESSION['new-infopage']['new-infogroup']);
                    unset($_SESSION['new-infogroup']);
                    exit();
                }
                // From new info page group
                else {
                    header('Location: ../r&d.php?ig=' . $groupID . '&l1=overview');
                    unset($_SESSION['new-infogroup']);
                    exit();
                }
            }

            if (empty($_SESSION['new-infogroup']['info']['title'])) $_SESSION['new-infogroup']['stage'] = '1';
            else $_SESSION['new-infogroup']['stage'] = '2';
        }
        if (isset($_POST['stage1'])) $_SESSION['new-infogroup']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-infogroup']['stage'] = '2';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-infogroup']); ?>

        <div class="menu"> <?php
        if ($_SESSION['new-infogroup']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>+ New Info Group: Enter Name</span>
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
                    <div class="head admin">Info Group Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="title" name="title" id="title" class="field admin" placeholder="Enter Info Group Name Here" maxlength="50" value="<?php if (isset($_SESSION['new-infogroup']['fields']['title'])) echo $_SESSION['new-infogroup']['fields']['title']; ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-infogroup']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>+ New Info Group: Enter Description</span>
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
                    <div class="head admin">Info Group Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Info Group Description Here" maxlength="200" value="<?php if (isset($_SESSION['new-infogroup']['fields']['description'])) echo $_SESSION['new-infogroup']['fields']['description']; ?>">
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