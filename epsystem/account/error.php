<?php
$page = "";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    echo "Error!";
    require_once "includes/footer.php";
}
else require_once "login.php";