<?php
include "includes/autoloader.php";
session_start();
$page = "hub";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php"; ?>
    <div class="menu">
        <div class="head-up-display-bar">
            <span>Welcome to the ep system!</span>
        </div>
        <div class="navbar level-1">
            <div class="container-button">
                <a href="?t=news" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "news") echo " active-menu"; ?>">
                    <span>NEWS</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=notifications" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "notifications") echo " active-menu"; ?>">
                    <span>NOTIFICATIONS</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=overview" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "overview") echo " active-menu"; ?>">
                    <span>OVERVIEW</span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=empty1" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "empty1") echo " active-menu"; ?>">
                    <span></span>
                </a>
            </div>
            <div class="container-button">
                <a href="?t=empty2" class="button<?php if (isset($_GET['t']) && $_GET['t'] == "empty2") echo " active-menu"; ?>">
                    <span></span>
                </a>
            </div>
        </div>
    </div>
    <div class="container" style="text-align: center">
        <br><br><br>
        <a href="https://docs.google.com/spreadsheets/d/1IYqpjW6zcxKsXFxJyiD7tOHjZe2nkK_ABfi_LAMK9y8" target="_blank">Animation Stuff</a>
        <br><br><br>
        <a href="https://drive.google.com/drive/folders/1Jrt2RxaeGCHvHL4JAvNtC5pRWKr8yluc" target="_blank">Files to share</a>
        <br><br><br>
        <a href="https://codepen.io/lakshmiR/pen/YGWXoo" target="_blank">Pixels to VW</a>
        <br><br><br>
        <a href="http://ozols88.id.lv/phpmyadmin/db_structure.php?server=1&db=epa" target="_blank">Database</a>
        <br><br><br>
    </div> <?php
    require_once "includes/footer.php";
} else require_once "login.php";