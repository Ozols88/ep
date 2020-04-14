<?php
include "includes/autoloader.php";
session_start();
$page = "hub";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php"; ?>
    <div class="menu"> <?php
        require "includes/menu.php"; ?>
    </div> <?php
    require_once "includes/footer.php";
} else require_once "login.php";