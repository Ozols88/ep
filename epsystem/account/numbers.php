<?php
$page = "numbers";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php"; ?>
    <div class="menu">
        <div class="head-up-display-bar">
            <span>Numbers</span>
        </div>
        <div class="navbar level-1<?php if (!isset($_GET['t'])) echo " unselected" ?>">
            <div class="container-button">
                <a href="?t=money" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "money") echo " active-menu"; ?>">
                    <span>MONEY</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=performance" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "performance") echo " active-menu"; ?>">
                    <span>PERFORMANCE</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=all-members" class="button admin-menu<?php if (isset($_GET['t']) && $_GET['t'] == "all-members") echo " active-menu"; ?>">
                    <span>ALL MEMBERS</span>
                </a>
            </div>
        </div>
    </div>
    <?php
} else require_once "login.php";
require_once "includes/footer.php";