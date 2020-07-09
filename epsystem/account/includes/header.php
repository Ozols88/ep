<html lang="en">
<head>
    <title>ep system</title>
    <!--realfavicongenerator.net-->
    <link rel="apple-touch-icon" sizes="180x180" href="../../icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../icons/favicon-16x16.png">
    <link rel="manifest" href="../../icons/site.webmanifest">
    <link rel="mask-icon" href="../../icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../../icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#705d34">
    <meta name="msapplication-config" content="icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!--CSS, FONT, JS-->
    <link rel="stylesheet" href="/ep/css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script src="/ep/epsystem/account/js/js.js"></script>
    <!--GOOGLE-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154665436-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-154665436-1');
    </script>
    <!--SIMPLEBAR-->
    <link rel="stylesheet" href="https://unpkg.com/simplebar@latest/dist/simplebar.css"/>
    <script src="https://unpkg.com/simplebar@latest/dist/simplebar.min.js"></script>
</head>
<body>
<div class="container-header system">
    <img class="logo-header" src="/ep/epsystem/account/img/logo-member.svg" alt="ep"> <?php
    if (isset($_GET['preview2'])) {
        $showLinks = false;
        $exitTitle = "Close";
        $exitLink = null;
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'projects.php' && isset($_GET['p'])) {
        $showLinks = false;
        if (isset($_POST['new-client']) || isset($_SESSION['add-client']['new-client'])) {
            $exitTitle = "Cancel Client";
            $exitLink = "/ep/epsystem/account/projects.php?p=" . $_GET['p'] . "&l1=info&l2=client";
        }
        else {
            $exitTitle = "Exit Project #" . sprintf('%04d', $_GET['p']);
            $exitLink = "/ep/epsystem/account/projects.php?l1=active";
            if (isset($_SESSION['backPage']))
                $exitLink = $_SESSION['backPage'];
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'assignments.php' && isset($_GET['a'])) {
        $showLinks = false;
        $exitTitle = "Exit Assignment #" . sprintf('%05d', $_GET['a']);
        $exitLink = "/ep/epsystem/account/assignments.php?l1=my&l2=active";
        if (isset($_SESSION['backPage2']))
            $exitLink = $_SESSION['backPage2'];
        elseif (isset($_SESSION['backPage']))
            $exitLink = $_SESSION['backPage'];
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        $showLinks = false;
        if (isset($_POST['new-client']) || isset($_SESSION['new-project']['new-client'])) {
            $exitTitle = "Cancel New Client";
            $exitLink = "/ep/epsystem/account/new-project.php";
        }
        elseif (isset($_POST['add-assignment-page']) || isset($_SESSION['new-project']['add-assignment-page'])) {
            $exitTitle = "Cancel Add Assignment";
            $exitLink = "/ep/epsystem/account/new-project.php";
        }
        elseif (isset($_SESSION['new-assignment']['new-project'])) {
            $exitTitle = "Cancel New Project";
            $exitLink = "/ep/epsystem/account/new-assignment.php";
        }
        else {
            $exitTitle = "Cancel New Project";
            $exitLink = "/ep/epsystem/account/projects.php?l1=active";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') {
        $showLinks = false;
        if (isset($_POST['add-task-page']) || isset($_SESSION['new-assignment']['add-task-page'])) {
            $exitTitle = "Cancel Add Task";
            $exitLink = "/ep/epsystem/account/new-assignment.php";
        }
        elseif (isset($_GET['p'])) {
            $exitTitle = "Cancel New Assignment";
            $exitLink = "/ep/epsystem/account/projects.php?p=" . $_GET['p'] . "&l1=assignments";
        }
        else {
            $exitTitle = "Cancel New Assignment";
            $exitLink = "/ep/epsystem/account/assignments.php?l1=my&l2=active";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-task.php') {
        $showLinks = false;
        if (isset($_POST['new-link']) || isset($_SESSION['new-task']['new-link'])) {
            $exitTitle = "Cancel New Link";
            $exitLink = "/ep/epsystem/account/new-task.php";
        }
        elseif (isset($_SESSION['new-assignment']['stage'])) {
            $exitTitle = "Cancel New Task";
            $exitLink = "/ep/epsystem/account/new-assignment.php";
        }
        elseif (isset($_GET['a'])) {
            if (isset($_POST['add-task-page']) || isset($_SESSION['new-task']['add-task-page'])) {
                $exitTitle = "Cancel Add Task";
                $exitLink = "/ep/epsystem/account/new-task.php?a=" . $_GET['a'];
            }
            else {
                $exitTitle = "Cancel New Task";
                $exitLink = "/ep/epsystem/account/assignments.php?a=" . $_GET['a'];
            }
        }
        else {
            $exitTitle = "Cancel New Task";
            $exitLink = "/ep/epsystem/account/assignments.php";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-member.php') {
        $showLinks = false;
        if (isset($_POST['add-division-page']) || isset($_SESSION['new-member']['add-division-page'])) {
            $exitTitle = "Cancel Add Division";
            $exitLink = "new-member.php";
        }
        else {
            $exitTitle = "Cancel New Member";
            $exitLink = "member.php";
        }
    }
    else {
        $showLinks = true;
        $exitTitle = "Log out of ep system";
        $exitLink = "/ep/epsystem/account/logout.php";
    }

    if ($showLinks) { ?>
        <nav class="menu-header">
            <div class="link-container">
                <a href="/ep/epsystem/account"<?php if ($page == "hub") echo ' class="active"'; ?>>Hub</a>
            </div>
            <div class="link-container">
                <a href="/ep/epsystem/account/projects.php?l1=active"<?php if ($page == "projects") echo ' class="active"'; ?>>Projects</a>
            </div>
            <div class="link-container">
                <a href="/ep/epsystem/account/assignments.php?l1=my&l2=active"<?php if ($page == "assignments") echo ' class="active"'; ?>>Assignments</a>
            </div>
            <span></span>
            <div class="link-container">
                <a href="/ep/epsystem/account/resources.php"<?php if ($page == "resources") echo ' class="active"'; ?>>Resources</a>
            </div>
            <div class="link-container">
                <a href="/ep/epsystem/account/r&d.php"<?php if ($page == "r&d") echo ' class="active"'; ?>>R&D</a>
            </div>
            <span></span>
            <div class="link-container">
                <a href="/ep/epsystem/account/numbers.php"<?php if ($page == "numbers") echo ' class="active"'; ?>>Numbers</a>
            </div>
            <div class="link-container">
                <a href="/ep/epsystem/account/member.php"<?php if ($page == "member") echo ' class="active"'; ?>>Member</a>
            </div>
        </nav> <?php
    }
    if (!isset($_GET['preview2'])) { ?>
        <form method="post" class="exit-form">
            <input type="submit" name="exit" value="<?php echo $exitTitle; ?>" class="exit-button">
        </form> <?php
    }
    else { ?>
        <div class="exit-form">
            <a onclick="window.close()" class="exit-button"><?php echo $exitTitle; ?></a>
        </div> <?php
    } ?>
</div> <?php

if (isset($_POST['exit'])) {
    if (isset($_GET['preview2'])) { ?>
        <script>window.close()</script> <?php
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'projects.php') {
        if (isset($_SESSION['add-client']['new-client']))
            unset($_SESSION['add-client']['new-client']);
        unset($_SESSION['new-manager']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        if (isset($_SESSION['new-project']['new-client']))
            unset($_SESSION['new-project']['new-client']);
        elseif (isset($_SESSION['new-project']['add-assignment-page']))
            unset($_SESSION['new-project']['add-assignment-page']);
        else {
            unset($_SESSION['new-assignment']['new-project']);
            unset($_SESSION['new-project']);
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') {
        if (isset($_SESSION['new-assignment']['add-task-page']))
            unset($_SESSION['new-assignment']['add-task-page']);
        else
            unset($_SESSION['new-assignment']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-task.php') {
        if (isset($_SESSION['new-task']['new-link']))
            unset($_SESSION['new-task']['new-link']);
        elseif (isset($_SESSION['new-task']['add-task-page'])) {
            unset($_SESSION['new-task']['add-task-page']);
        }
        else {
            unset($_SESSION['new-assignment']['new-task']);
            unset($_SESSION['new-task']);
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-member.php') {
        if (isset($_SESSION['new-member']['add-division-page']))
            unset($_SESSION['new-member']['add-division-page']);
        else
            unset($_SESSION['new-member']);
    }

    unset($_SESSION['backPage2']);
    header("Location: " . $exitLink);
}