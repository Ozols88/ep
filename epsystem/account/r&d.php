<?php
$page = "r&d";
include "includes/autoloader.php";
session_start();
if (isset($_SESSION['account'])) {
    $account = $_SESSION['account'];
    require_once "includes/header.php"; ?>
    <div class="menu">
        <div class="head-up-display-bar">
            <span><?php echo "R&D"; ?></span>
        </div>
        <div class="navbar level-1<?php if (!isset($_GET['t'])) echo " unselected" ?>">
            <div class="container-button">
                <a class="button">IMPROVEMENTS</a> <?php
                if (!isset($_GET['t'])) { ?>
                    <div class="home-menu">
                        <span class="title">ALL ACTIVE PROJECTS</span>
                        <span class="description">Here you can access and view projects that are currently in production</span>
                        <div class="total-count">
                            <div class="count">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                        <div class="last-hours">
                            <span class="title">IN THE LAST 24H</span>
                            <div class="details-count">
                                <span>NEW PROJECTS</span>
                                <div class="count">+15</div>
                            </div>
                            <div class="details-count">
                                <span>REACTIVATED</span>
                                <div class="count">+8</div>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="projects.php?t=active" class="enter-button">PROJECT LIST</a>
                            <span class="note">Keep in mind these are only the projects you have accepted or completed a task for</span>
                        </div>
                    </div> <?php
                } ?>
            </div>
            <div class="container-button">
                <a class="button">TUTORIALS</a> <?php
                if (!isset($_GET['t'])) { ?>
                    <div class="home-menu">
                        <span class="title">ALL ACTIVE PROJECTS</span>
                        <span class="description">Here you can access and view projects that are currently in production</span>
                        <div class="total-count">
                            <div class="count">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                        <div class="last-hours">
                            <span class="title">IN THE LAST 24H</span>
                            <div class="details-count">
                                <span>NEW PROJECTS</span>
                                <div class="count">+15</div>
                            </div>
                            <div class="details-count">
                                <span>REACTIVATED</span>
                                <div class="count">+8</div>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="projects.php?t=active" class="enter-button">PROJECT LIST</a>
                            <span class="note">Keep in mind these are only the projects you have accepted or completed a task for</span>
                        </div>
                    </div> <?php
                } ?>
            </div>
            <div class="container-button">
                <a class="button">TECHNIQUES</a> <?php
                if (!isset($_GET['t'])) { ?>
                    <div class="home-menu">
                        <span class="title">ALL ACTIVE PROJECTS</span>
                        <span class="description">Here you can access and view projects that are currently in production</span>
                        <div class="total-count">
                            <div class="count">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                        <div class="last-hours">
                            <span class="title">IN THE LAST 24H</span>
                            <div class="details-count">
                                <span>NEW PROJECTS</span>
                                <div class="count">+15</div>
                            </div>
                            <div class="details-count">
                                <span>REACTIVATED</span>
                                <div class="count">+8</div>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="projects.php?t=active" class="enter-button">PROJECT LIST</a>
                            <span class="note">Keep in mind these are only the projects you have accepted or completed a task for</span>
                        </div>
                    </div> <?php
                } ?>
            </div>
            <div class="container-button">
                <a class="button">SIMULATIONS</a> <?php
                if (!isset($_GET['t'])) { ?>
                    <div class="home-menu">
                        <span class="title">ALL ACTIVE PROJECTS</span>
                        <span class="description">Here you can access and view projects that are currently in production</span>
                        <div class="total-count">
                            <div class="count">100</div>
                            <span>TOTAL PROJECTS</span>
                        </div>
                        <div class="last-hours">
                            <span class="title">IN THE LAST 24H</span>
                            <div class="details-count">
                                <span>NEW PROJECTS</span>
                                <div class="count">+15</div>
                            </div>
                            <div class="details-count">
                                <span>REACTIVATED</span>
                                <div class="count">+8</div>
                            </div>
                        </div>
                        <div class="bottom">
                            <a href="projects.php?t=active" class="enter-button">PROJECT LIST</a>
                            <span class="note">Keep in mind these are only the projects you have accepted or completed a task for</span>
                        </div>
                    </div> <?php
                } ?>
            </div>
        </div>
    </div>
    <?php
} else require_once "login.php";
require_once "includes/footer.php";