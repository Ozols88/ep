<?php
$page = "approvals";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php";
    if ($account->type == 2) { ?>
        <div class="menu"> <?php
        if (!isset($_GET['p'])) {
            $head_up = "Approvals";
            if (!isset($_GET['l1'])) $head_up = "Active Approved Assignments";
            elseif ($_GET['l1'] == "active") {
                $head_up = "Active Approvals";
            }
            elseif ($_GET['l1'] == "completed") {
                $head_up = "Recently Completed Approvals";
            } ?>

            <div class="head-up-display-bar">
                <span><?php echo $head_up; ?></span>
            </div>
            <div class="navbar level-1">
                <div class="container-button">
                    <a href="?t=active" class="button<?php if (isset($_GET['l1']) && $_GET['l1'] == "active") echo " active-menu"; ?>">
                        <span>ACTIVE</span>
                        <div class="count"><?php echo "0"; ?></div>
                    </a>
                </div>
                <div class="container-button">
                    <a href="?t=completed" class="button<?php if (isset($_GET['l1']) && $_GET['l1'] == "completed") echo " active-menu"; ?>">
                        <span>COMPLETED</span>
                    </a>
                </div>
            </div> <?php
        }
    }
    require_once "includes/footer.php";
}
else require_once "login.php";