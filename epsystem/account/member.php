<?php
$page = "member";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    if ($account->type == 1) { ?>
        <div class="menu">
            <div class="head-up-display-bar">
                <span>Member</span>
            </div>
            <div class="navbar level-1<?php if (!isset($_GET['t'])) echo " unselected" ?>">
            <div class="container-button">
                <a href="?t=new-account" class="button admin-menu<?php if (isset($_GET['t']) && $_GET['t'] == "new-account") echo " active-menu"; ?>">
                    <span>+ New Account</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=permissions" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "permissions") echo " active-menu"; ?>">
                    <span>PERMISSIONS</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=details" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "details") echo " active-menu"; ?>">
                    <span>DETAILS</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=skills" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "skills") echo " active-menu"; ?>">
                    <span>SKILLS</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=all-members" class="button admin-menu<?php if (isset($_GET['t']) && $_GET['t'] == "all-members") echo " active-menu"; ?>">
                    <span>ALL MEMBERS</span>
                </a>
            </div>
            </div>
        </div> <?php
    }
    require_once "includes/footer.php";
}
else require_once "login.php";