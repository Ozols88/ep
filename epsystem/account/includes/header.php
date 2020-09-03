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
        elseif (isset($_GET['options'])) {
            $exitTitle = "Exit Project Options";
            $exitLink = "/ep/epsystem/account/projects.php?p=" . $_GET['p'] . "&l1=project";
        }
        else {
            $exitTitle = "Exit Project #" . sprintf('%04d', $_GET['p']);
            $exitLink = "/ep/epsystem/account/projects.php?l1=active";
            if (isset($_SESSION['backPage']['1']))
                $exitLink = $_SESSION['backPage']['1'];
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'assignments.php' && (isset($_GET['a']) || isset($_GET['t']))) {
        $showLinks = false;
        if (isset($_GET['options']) && isset($_GET['a'])) {
            $exitTitle = "Exit Assignment Options";
            $exitLink = "/ep/epsystem/account/assignments.php?a=" . $_GET['a'] . "&l1=assignment";
        }
        elseif (isset($_GET['options']) && isset($_GET['t'])) {
            $assignmentID = Task::selectTask($_GET['t'])['assignmentid'];
            $exitTitle = "Exit Task Options";
            $exitLink = "/ep/epsystem/account/assignments.php?a=" . $assignmentID . "&l1=tasks&l2=" . $_GET['t'];
        }
        else {
            $exitTitle = "Exit Assignment #" . sprintf('%05d', $_GET['a']);
            $exitLink = "/ep/epsystem/account/assignments.php?l1=my&l2=active";
            if (isset($_SESSION['backPage']['2']))
                $exitLink = $_SESSION['backPage']['2'];
            elseif (isset($_SESSION['backPage']['1']))
                $exitLink = $_SESSION['backPage']['1'];
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'r&d.php' && (isset($_GET['f']) || isset($_GET['p']) || isset($_GET['a']) || isset($_GET['t']))) {
        $showLinks = false;
        if (isset($_GET['f'])) {
            $exitTitle = "Exit R&D";
            $exitLink = "r&d";
        }
        if (isset($_GET['p'])) {
            $exitTitle = "Exit Preset #" . sprintf('%03d', Project::selectPresetByID($_GET['p'])['id']);
            $exitLink = "r&d";
        }
        if (isset($_GET['a'])) {
            $exitTitle = "Exit Preset #" . sprintf('%03d', Assignment::selectPresetByID($_GET['a'])['id']);
            $exitLink = "r&d";
        }
        if (isset($_GET['t'])) {
            $exitTitle = "Exit Preset #" . sprintf('%05d', Task::selectTaskPreset($_GET['t'])['id']);
            $exitLink = "r&d";
        }

        if (isset($_GET['p']))
            $exitLink = $_SESSION['backPageR&D']['1'];
        elseif (isset($_GET['a']) && !isset($_SESSION['backPageR&D']['2a']) && isset($_SESSION['backPageR&D']['1']))
            $exitLink = $_SESSION['backPageR&D']['1'];
        elseif (isset($_GET['a']) && isset($_SESSION['backPageR&D']['2a']))
            $exitLink = $_SESSION['backPageR&D']['2a'];
        elseif (isset($_GET['t']) && isset($_SESSION['backPageR&D']['3a']))
            $exitLink = $_SESSION['backPageR&D']['3a'];
        elseif (isset($_GET['t']) && isset($_SESSION['backPageR&D']['2b']))
            $exitLink = $_SESSION['backPageR&D']['2b'];
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        $showLinks = false;
        if (isset($_POST['add-assignment-page']) || isset($_SESSION['new-project']['add-assignment-page'])) {
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
        elseif (isset($_SESSION['new-assignment']['stage'])) {
            $exitTitle = "Cancel New Task";
            $exitLink = "/ep/epsystem/account/new-assignment.php";
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
    elseif ($_SERVER['PHP_SELF'] == '/ep/epsystem/account/new-r&d/index.php') {
        $showLinks = false;
        $exitTitle = "Cancel New R&D";
        $exitLink = "../r&d?f=" . $_GET['f'];
    }
    elseif ($_SERVER['PHP_SELF'] == '/ep/epsystem/account/new-r&d/project.php') {
        $showLinks = false;
        if (isset($_POST['add-assignment-page']) || isset($_SESSION['new-project']['add-assignment-page'])) {
            $exitTitle = "Cancel Add Assignment";
            $exitLink = "project?f=" . $_GET['f'];
        }
        else {
            $exitTitle = "Cancel New Project Preset";
            $exitLink = "../r&d?f=" . $_GET['f'];
        }
    }
    elseif ($_SERVER['PHP_SELF'] == '/ep/epsystem/account/new-r&d/assignment.php') {
        $showLinks = false;
        if (isset($_POST['add-task-page']) || isset($_SESSION['new-assignment']['add-task-page'])) {
            $exitTitle = "Cancel Add Task";
            $exitLink = "assignment?f=" . $_GET['f'];
        }
        else {
            $exitTitle = "Cancel New Assignment Preset";
            $exitLink = "../r&d?f=" . $_GET['f'];
        }
    }
    elseif ($_SERVER['PHP_SELF'] == '/ep/epsystem/account/new-r&d/task.php') {
        $showLinks = false;
        if (isset($_SESSION['new-assignment']['stage'])) {
            $exitTitle = "Cancel New Task";
            $exitLink = "assignment.php?f=" . $_GET['f'];
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
    elseif (basename($_SERVER['PHP_SELF']) == 'r&d.php') {
        if (isset($_GET['f']))
            unset($_SESSION['backPageR&D']['1']);
        if (isset($_GET['p']))
            unset($_SESSION['backPageR&D']['2a']);
        if (isset($_GET['a'])) {
            unset($_SESSION['backPageR&D']['2b']);
            unset($_SESSION['backPageR&D']['3a']);
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        if (isset($_SESSION['new-project']['add-assignment-page']))
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
    elseif ($_SERVER['PHP_SELF'] == '/ep/epsystem/account/new-r&d/project.php') {
        if (isset($_SESSION['new-project']['add-assignment-page']))
            unset($_SESSION['new-project']['add-assignment-page']);
        else
            unset($_SESSION['new-project']);
    }
    elseif ($_SERVER['PHP_SELF'] == '/ep/epsystem/account/new-r&d/assignment.php') {
        if (isset($_SESSION['new-assignment']['add-task-page']))
            unset($_SESSION['new-assignment']['add-task-page']);
        else
            unset($_SESSION['new-assignment']);
    }

    unset($_SESSION['backPage']['2']);
    header("Location: " . $exitLink);
}