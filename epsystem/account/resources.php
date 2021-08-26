<?php
$page = "resources";
include "includes/autoloader.php";
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    if ($account->manager == 1) {
        require_once "includes/header.php"; ?>

        <div class="menu"> <?php
        require "includes/menu.php";
        if (isset($_GET['l1']) && $_GET['l1'] == "library") { ?>
            </div> <?php
        }

        require_once "includes/footer.php";
    }
    else {
        header('Location: error.php');
    }
}
else require_once "login.php";