<?php
$page = "member";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {

        require_once "includes/header.php";

        if (!isset($_SESSION['new-member'])) {
            $_SESSION['new-member']['stage'] = '1';
            $_SESSION['new-member']['info']['username'] = ""; // Info bar fix
        }

        if (isset($_POST['submit'])) {
            if ($_SESSION['new-member']['stage'] == '1') {
                $_SESSION['new-member']['fields']['username'] = $_POST['username'];
                $_SESSION['new-member']['info']['username'] = $_POST['username'];
                if (strlen($_SESSION['new-member']['info']['username']) > InfobarCharLimit)
                    $_SESSION['new-member']['info']['username'] = substr($_SESSION['new-member']['info']['username'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-member']['stage'] = '2';
                if (!isset($_SESSION['new-member']['info']['description']))
                    $_SESSION['new-member']['info']['description'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-member']['stage'] == '2') {
                $_SESSION['new-member']['fields']['description'] = $_POST['description'];
                $_SESSION['new-member']['info']['description'] = $_POST['description'];
                if (strlen($_SESSION['new-member']['info']['description']) > InfobarCharLimit)
                    $_SESSION['new-member']['info']['description'] = substr($_SESSION['new-member']['info']['description'], 0, InfobarCharLimit) . "...";

                $_SESSION['new-member']['stage'] = '3';
                if (!isset($_SESSION['new-member']['info']['password']))
                    $_SESSION['new-member']['info']['password'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-member']['stage'] == '3') {
                $_SESSION['new-member']['fields']['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $_SESSION['new-member']['info']['password'] = $_POST['password'];

                $_SESSION['new-member']['stage'] = '4';
                if (!isset($_SESSION['new-member']['divisions']))
                    $_SESSION['new-member']['divisions'] = ""; // Info bar fix
            }
            elseif ($_SESSION['new-member']['stage'] == '4') {
                if (isset($_POST['addDivPage'])) {
                    $_SESSION['new-member']['add-division-page'] = true;
                    header('Location: new-member.php');
                }
                if (isset($_POST['cancelAddDiv'])) {
                    unset($_SESSION['new-member']['add-division-page']);
                    header('Location: new-member.php');
                }
                if (isset($_POST['div'])) {
                    if ($_SESSION['new-member']['divisions'] == "")
                        $_SESSION['new-member']['divisions'] = null;
                    $_SESSION['new-member']['divisions'][$_POST['div']] = Assignment::selectDivisionByID($_POST['div']);
                    unset($_SESSION['new-member']['add-division-page']);
                }
                if (isset($_POST['del-div'])) {
                    unset($_SESSION['new-member']['divisions'][$_POST['del-div']]);
                }
                if (isset($_POST['create'])) {
                    $_SESSION['new-member']['fields']['reg_time'] = date("Y-m-d H-i-s");
                    $accountID = Database::insert('account', $_SESSION['new-member']['fields'], true, false);

                    if (isset($_SESSION['new-member']['divisions']))
                        foreach ($_SESSION['new-member']['divisions'] as $div)
                            Database::insert('account_division', ['accountid' => $accountID, 'divisionid' => $div['id']], true, false);

                    header("Location: member.php?l1=members");
                    unset($_SESSION['new-member']);
                }
            }
        }
        if (isset($_POST['stage1'])) $_SESSION['new-member']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-member']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-member']['stage'] = '3';
        if (isset($_POST['stage4'])) $_SESSION['new-member']['stage'] = '4';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-member']); ?>

        <div class="menu"> <?php

        if ($_SESSION['new-member']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>New Member</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="username" name="username" method="post" class="container-button">
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
                    <div class="head admin">Member Name</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="username" name="username" id="username" class="field admin" placeholder="Enter Member Name Here" maxlength="30" value="<?php if (isset($_SESSION['new-member']['fields']['username'])) echo htmlspecialchars($_SESSION['new-member']['fields']['username']); ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>New Member</span>
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
                <div class="header-extension large admin"></div>
                <div class="header large">
                    <div class="head admin">Member Description</div>
                </div>
                <div class="header-extension large admin"></div>
            </div>
            </div>
            <div class="table large">
                <div class="row">
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Member Description Here" maxlength="255" value="<?php if (isset($_SESSION['new-member']['fields']['description'])) echo htmlspecialchars($_SESSION['new-member']['fields']['description']); ?>">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>New Member</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="password" name="password" method="post" class="container-button">
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
                    <div class="head admin">Member Password</div>
                </div>
                <div class="header-extension small admin"></div>
            </div>
            </div>
            <div class="table small">
                <div class="row">
                    <input form="password" name="password" id="password" class="field admin" placeholder="Enter Member Password Here" type="password" maxlength="50">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '4') {
            if (!isset($_SESSION['new-member']['add-division-page'])) { ?>
                <div class="head-up-display-bar">
                    <span>New Member</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form method="post" class="container-button">
                        <input type="hidden" name="addDivPage">
                        <input type="submit" name="submit" value="+ Division" class="button admin-menu">
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="create">
                        <input type="submit" name="submit" value="Create Member" class="button admin-menu">
                    </form>
                </div> <?php
                include_once "includes/info-bar.php";
                $departments = Assignment::selectDepartments(); ?>
                <form class="search-bar">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                    <div class="custom-select input-depart" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'}, this)"
                                name="depart" class="input-depart" required>
                            <option value="">All Departments</option> <?php
                            foreach ($departments as $depart) { ?>
                                <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Division Name</div>
                        <div class="head admin" style="width: 50%">Description</div>
                        <div class="head admin" style="width: 15%">Department</div>
                        <div class="head admin" style="width: 7.5%">Remove</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div>
                <div class="table admin"> <?php
                    if (is_array($_SESSION['new-member']['divisions']) && count($_SESSION['new-member']['divisions']) > 0) {
                        foreach ($_SESSION['new-member']['divisions'] as $div) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $div['id']); ?>" class="content"></div>
                                <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $div['title']; ?>" class="content"></div>
                                <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $div['description']; ?>" class="content"></div>
                                <div class="cell depart" style="width: 15%"><input type="submit" name="submit" value="<?php echo $div['department']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Remove" class="content del-button"></div>
                                <input type="hidden" name="del-div" value="<?php echo $div['id']; ?>">
                            </form> <?php
                        }
                    }
                    else { ?>
                        <div class="empty-table">NO DIVISIONS</div> <?php
                    } ?>
                </div> <?php
            }
            else { ?>
                <div class="head-up-display-bar">
                    <span>Add Division</span>
                </div>
                <div class="navbar level-1 unselected">
                    <form class="container-button disabled">
                        <a class="button admin-menu disabled"></a>
                    </form>
                    <form method="post" class="container-button">
                        <input type="hidden" name="cancelAddDiv">
                        <input type="submit" name="submit" value="Cancel" class="button admin-menu">
                    </form>
                    <form class="container-button disabled">
                        <a class="button admin-menu disabled"></a>
                    </form>
                </div> <?php
                include_once "includes/info-bar.php";
                $departments = Assignment::selectDepartments(); ?>
                <form class="search-bar">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="id" class="input-id" placeholder="Enter №" required style="width: calc(7.5% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="name" class="input-name" placeholder="Enter Division Name" required style="width: calc(20% - 8px);">
                    <input oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'})"
                           type="text" name="description" class="input-description" placeholder="Enter Description" required style="width: calc(50% - 8px);">
                    <div class="custom-select input-depart" style="width: calc(15% - 8px);">
                        <select oninput="searchTable(fields = {'.search-bar .input-id':'.cell.id', '.search-bar .input-name':'.cell.name', '.search-bar .input-description':'.cell.description', '.search-bar .custom-select.input-depart .input-depart':'.cell.depart'}, this)"
                                name="depart" class="input-depart" required>
                            <option value="">All Departments</option> <?php
                            foreach ($departments as $depart) { ?>
                                <option value="<?php echo $depart['title']; ?>"><?php echo $depart['title']; ?></option> <?php
                            } ?>
                        </select>
                    </div>
                </form>
                <div class="table-header-container">
                    <div class="header-extension admin"></div>
                    <div class="header">
                        <div class="head admin" style="width: 7.5%">№</div>
                        <div class="head admin" style="width: 20%">Division Name</div>
                        <div class="head admin" style="width: 50%">Description</div>
                        <div class="head admin" style="width: 15%">Department</div>
                        <div class="head admin" style="width: 7.5%">Add</div>
                    </div>
                    <div class="header-extension admin"></div>
                </div>
                </div> <?php
                $divisions = Assignment::selectDivisions();
                if ($_SESSION['new-member']['divisions']) {
                    foreach ($_SESSION['new-member']['divisions'] as $selectedDiv) {
                        foreach ($divisions as $allDiv) {
                            if ($selectedDiv['id'] == $allDiv['id'])
                                unset($divisions[$allDiv['id']]);
                        }
                    }
                }

                if ($divisions) { ?>
                    <div class="table admin"> <?php
                        foreach ($divisions as $div) { ?>
                            <form method="post" class="row">
                                <div class="cell id" style="width: 7.5%"><input type="submit" name="submit" value="<?php echo "#" . sprintf('%03d', $div['id']); ?>" class="content"></div>
                                <div class="cell name" style="width: 20%"><input type="submit" name="submit" value="<?php echo $div['title']; ?>" class="content"></div>
                                <div class="cell description" style="width: 50%"><input type="submit" name="submit" value="<?php echo $div['description']; ?>" class="content"></div>
                                <div class="cell depart" style="width: 15%"><input type="submit" name="submit" value="<?php echo $div['department']; ?>" class="content"></div>
                                <div class="cell" style="width: 7.5%"><input type="submit" name="submit" value="Add" class="content add-button"></div>
                                <input type="hidden" name="div" value="<?php echo $div['id']; ?>">
                            </form> <?php
                        } ?>
                    </div> <?php
                }
                else { ?>
                    <div class="empty-table">NO DIVISIONS</div> <?php
                }
            }
        }

        require_once "includes/footer.php";

    }
    else
        header('Location: error.php');
}
else require_once "login.php";