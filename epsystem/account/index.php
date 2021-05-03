<?php
ob_start();
$page = "hub";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php"; ?>
    <div class="menu"> <?php
        require "includes/menu.php"; ?>
    </div> <?php
    require_once "includes/footer.php";
}
else require_once "login.php";