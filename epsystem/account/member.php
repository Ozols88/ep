<?php
$page = "member";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];

    require_once "includes/header.php"; ?>

    <div class="menu"> <?php
    require "includes/menu.php";
    if (isset($_GET['l1']) && $_GET['l1'] == "clients") {
        $clients = $account->selectClients(); ?>
        <div class="search-bar">
        </div>
        <div class="table-header-container">
            <div class="header-extension"></div>
            <div class="header">
                <div class="head" style="width: 7.5%">№</div>
                <div class="head" style="width: 60%">Client Name</div>
                <div class="head" style="width: 10%">Projects</div>
                <div class="head" style="width: 15%">Reg. Date</div>
                <div class="head" style="width: 7.5%">Open</div>
            </div>
            <div class="header-extension"></div>
        </div>
        </div>
        <div class="table"> <?php
            if ($clients) {
                foreach ($clients as $row) { ?>
                    <div class="row">
                        <div class="cell id" style="width: 7.5%"><a class="content"><?php echo "#" . sprintf('%03d', $row['id']); ?></a></div>
                        <div class="cell" style="width: 60%"><a class="content"><?php echo $row['username']; ?></a></div>
                        <div class="cell" style="width: 10%"><a class="content"><?php echo $row['project_count']; ?></a></div>
                        <div class="cell" style="width: 15%"><a class="content"><?php echo $row['reg_time_date']; ?></a></div>
                        <div class="cell" style="width: 7.5%"><a class="content open-button">Open</a></div>
                    </div> <?php
                }
            } ?>
        </div> <?php
    }
    else { ?>
        </div> <?php
    }

    require_once "includes/footer.php";

}
else require_once "login.php";