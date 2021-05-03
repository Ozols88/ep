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
                $_SESSION['new-member']['fields']['reg_time'] = date("Y-m-d H-i-s");

                Database::insert('account', $_SESSION['new-member']['fields'], true, false);
                header("Location: member.php?l1=members");
                unset($_SESSION['new-member']);
            }
        }
        if (isset($_POST['stage1'])) $_SESSION['new-member']['stage'] = '1';
        if (isset($_POST['stage2'])) $_SESSION['new-member']['stage'] = '2';
        if (isset($_POST['stage3'])) $_SESSION['new-member']['stage'] = '3';

        if (isset($_POST['cancel']))
            unset($_SESSION['new-member']); ?>

        <div class="menu"> <?php

        if ($_SESSION['new-member']['stage'] == '1') { ?>
            <div class="head-up-display-bar">
                <span>Enter the name of the new member</span>
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
                    <input form="username" name="username" id="username" class="field admin" placeholder="Enter Member Name Here" maxlength="30">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '2') { ?>
            <div class="head-up-display-bar">
                <span>Enter a description of the new member</span>
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
                    <input form="description" name="description" id="description" class="field admin" placeholder="Enter Member Description Here" maxlength="255">
                </div>
            </div> <?php
        }
        elseif ($_SESSION['new-member']['stage'] == '3') { ?>
            <div class="head-up-display-bar">
                <span>Enter the password of the new member</span>
            </div>
            <div class="navbar level-1 unselected">
                <form class="container-button disabled">
                    <a class="button admin-menu disabled"></a>
                </form>
                <form id="password" name="password" method="post" class="container-button">
                    <input type="submit" name="submit" value="Create Member" class="button admin-menu">
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

        require_once "includes/footer.php";

    }
    else
        header('Location: error.php');
}
else require_once "login.php";