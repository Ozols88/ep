<?php
$page = "numbers";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php"; ?>
    <div class="menu"> <?php
        require "includes/menu.php"; ?>
    </div>
    <?php
} else require_once "login.php";
require_once "includes/footer.php";