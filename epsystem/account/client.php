<?php
$page = "client";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    if ($account->type == 2) { ?>
        <div class="head-up-display-bar">
            <span>Client</span>
        </div> <?php
    }
    require_once "includes/footer.php";
}
else require_once "login.php";