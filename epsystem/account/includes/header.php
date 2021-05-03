<html lang="en">
<head>
    <title>ep system</title>
    <!--realfavicongenerator.net-->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo RootPath; ?>icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo RootPath; ?>icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo RootPath; ?>icons/favicon-16x16.png">
    <link rel="manifest" href="<?php echo RootPath; ?>icons/site.webmanifest">
    <link rel="mask-icon" href="<?php echo RootPath; ?>icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="<?php echo RootPath; ?>icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#705d34">
    <meta name="msapplication-config" content="<?php echo RootPath; ?>icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!--CSS, FONT, JS-->
    <link rel="stylesheet" href="<?php echo RootPath; ?>css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="<?php echo RootPath; ?>epsystem/account/js/js.js"></script>
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
<div class="container-header system"> <?php
    if (isset($account->manager) && $account->manager == 1) { ?>
        <div class="logo-container"><img class="logo-header" src="<?php echo RootPath; ?>epsystem/account/img/logo-manager.svg" alt="ep"></div> <?php
    }
    else { ?>
        <div class="logo-container"><img class="logo-header" src="<?php echo RootPath; ?>epsystem/account/img/logo-member.svg" alt="ep"></div <?php
    }
    if (isset($_GET['preview2'])) {
        $showLinks = false;
        $exitTitle = "Close";
        $exitLink = null;
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'projects.php' && isset($_GET['p'])) {
        $showLinks = false;
        if (isset($_GET['options'])) {
            $exitTitle = "Exit Project Options";
            $exitLink = "projects.php?p=" . $_GET['p'] . "&l1=project&l2=overview";
        }
        elseif (isset($_GET['ioptions'])) {
            $exitTitle = "Exit Info Link Options";
            $exitLink = "projects.php?p=" . $_GET['p'] . "&l1=info";
        }
        else {
            $exitTitle = "Exit Project #" . sprintf('%04d', $_GET['p']);
            $exitLink = "projects.php?l1=active";
            if (isset($_SESSION['backPage']['1']))
                $exitLink = $_SESSION['backPage']['1'];
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'assignments.php' && (isset($_GET['a']) || isset($_GET['t']))) {
        $showLinks = false;
        if (isset($_GET['options']) && isset($_GET['a'])) {
            $exitTitle = "Exit Assignment Options";
            $exitLink = "assignments.php?a=" . $_GET['a'] . "&l1=assignment";
        }
        elseif (isset($_GET['options']) && isset($_GET['t'])) {
            $assignmentID = Task::selectTask($_GET['t'])['assignmentid'];
            $exitTitle = "Exit Task Options";
            $exitLink = "assignments.php?a=" . $assignmentID . "&l1=tasks&l2=" . $_GET['t'];
        }
        elseif (isset($_SESSION['paymentPage'])) {
            $exitTitle = "Exit Assignment #" . sprintf('%05d', $_GET['a']);
            $exitLink = "numbers.php?py=" . $_SESSION['paymentPage'] . "&l1=assignments";
        }
        elseif (isset($_SESSION['memberPage'])) {
            $exitTitle = "Exit Assignment #" . sprintf('%05d', $_GET['a']);
            $exitLink = "member.php?m=" . $_SESSION['memberPage'] . "&l1=assignments";
        }
        else {
            $exitTitle = "Exit Assignment #" . sprintf('%05d', $_GET['a']);
            $exitLink = "assignments.php?l1=my&l2=active";
            if (isset($_SESSION['backPage']['2']))
                $exitLink = $_SESSION['backPage']['2'];
            elseif (isset($_SESSION['backPage']['1']))
                $exitLink = $_SESSION['backPage']['1'];
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'r&d.php' && (isset($_GET['p']) || isset($_GET['a']) || isset($_GET['t']) || isset($_GET['i'])) || isset($_GET['f']) || isset($_GET['d']) || isset($_GET['dp']) || isset($_GET['ig']) || isset($_GET['lt'])) {
        $showLinks = false;
        if (isset($_GET['p'])) {
            $exitTitle = "Exit Project Preset";
            $exitLink = "r&d?l1=project&l2=projects";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Project Preset Options";
                $exitLink = "r&d.php?p=" . $_GET['p'] . "&l1=overview";
                if (isset($_SESSION['edit-projectpr']['add-assignment'])) {
                    $exitTitle = "Exit Preset Options";
                    $exitLink = 'r&d.php?p=' . $_GET['p'] . '&l1=assignments';
                }
            }
        }
        elseif (isset($_GET['a'])) {
            $exitTitle = "Exit Assignment Preset";
            $exitLink = "r&d?l1=assignment&l2=assignments";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Assignment Preset Options";
                $exitLink = "r&d.php?a=" . $_GET['a'] . "&l1=overview";
            }
        }
        elseif (isset($_GET['t'])) {
            $exitTitle = "Exit Task Preset";
            $exitLink = "r&d?l1=task&l2=tasks";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Task Preset Options";
                $exitLink = "r&d.php?t=" . $_GET['t'] . "&l1=overview";
                if (isset($_SESSION['edit-taskpr']['add-infopage'])) {
                    $exitTitle = "Cancel Add Info Page";
                    $exitLink = $_SERVER['REQUEST_URI'];
                }
            }
        }
        elseif (isset($_GET['i'])) {
            $exitTitle = "Exit Info Preset Page";
            $exitLink = "r&d?l1=task&l2=info";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Info Preset Options";
                $exitLink = "r&d.php?i=" . $_GET['i'] . "&l1=overview";
            }
        }
        elseif (isset($_GET['f'])) {
            $exitTitle = "Exit Product";
            $exitLink = "r&d?l1=products";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Product Options";
                $exitLink = "r&d.php?f=" . $_GET['f'] . "&l1=overview";
                if (isset($_SESSION['edit-product']['add-division'])) {
                    $exitTitle = "Cancel Add Division";
                    $exitLink = $_SERVER['REQUEST_URI'];
                }
            }
        }
        elseif (isset($_GET['d'])) {
            $exitTitle = "Exit Division";
            $exitLink = "r&d?l1=assignment&l2=divisions";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Division Options";
                $exitLink = "r&d.php?d=" . $_GET['d'] . "&l1=overview";
            }
        }
        elseif (isset($_GET['dp'])) {
            $exitTitle = "Exit Department";
            $exitLink = "r&d?l1=assignment&l2=departments";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Department Options";
                $exitLink = "r&d.php?dp=" . $_GET['dp'] . "&l1=overview";
            }
        }
        elseif (isset($_GET['ig'])) {
            $exitTitle = "Exit Info Group";
            $exitLink = "r&d?l1=task&l2=infogr";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Info Group Options";
                $exitLink = "r&d.php?ig=" . $_GET['ig'] . "&l1=overview";
            }
        }
        elseif (isset($_GET['lt'])) {
            $exitTitle = "Exit Link Type";
            $exitLink = "r&d?l1=task&l2=linktypes";
            if (isset($_GET['options'])) {
                $exitTitle = "Exit Link Type Options";
                $exitLink = "r&d.php?lt=" . $_GET['lt'] . "&l1=overview";
            }
        }

        if (!isset($_GET['options'])) {
            if (isset($_GET['p']) && isset($_SESSION['backPageR&D']['home']))
                $exitLink = $_SESSION['backPageR&D']['home'];
            elseif (isset($_GET['a']) && !isset($_SESSION['backPageR&D']['prj']))
                $exitLink = $_SESSION['backPageR&D']['home'];
            elseif (isset($_GET['a']) && isset($_SESSION['backPageR&D']['prj']))
                $exitLink = $_SESSION['backPageR&D']['prj'];
            elseif (isset($_GET['t']) && isset($_SESSION['backPageR&D']['asg']))
                $exitLink = $_SESSION['backPageR&D']['asg'];
            elseif (isset($_GET['i']) && isset($_SESSION['backPageR&D']['home']))
                $exitLink = $_SESSION['backPageR&D']['home'];
            elseif (isset($_GET['f']) && isset($_SESSION['backPageR&D']['home']))
                $exitLink = $_SESSION['backPageR&D']['home'];
            elseif (isset($_GET['d']) && isset($_SESSION['backPageR&D']['home']))
                $exitLink = $_SESSION['backPageR&D']['home'];
            elseif (isset($_GET['ig']) && isset($_SESSION['backPageR&D']['home']))
                $exitLink = $_SESSION['backPageR&D']['home'];
            elseif (isset($_GET['lt']) && isset($_SESSION['backPageR&D']['home']))
                $exitLink = $_SESSION['backPageR&D']['home'];
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'member.php' && isset($_GET['m'])) {
        $showLinks = false;
        if (isset($_GET['options'])) {
            if (isset($_SESSION['memberDivisionList'])) {
                $exitTitle = "Exit Member Options";
                $exitLink = "member.php?m=" . $_GET['m'] . "&l1=divisions";
            }
            else {
                $exitTitle = "Exit Member Options";
                $exitLink = "member.php?m=" . $_GET['m'] . "&l1=overview";
            }
        }
        else {
            $exitTitle = "Exit Member Page";
            $exitLink = "member.php?l1=members";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'numbers.php' && isset($_GET['py'])) {
        $showLinks = false;
        if (isset($_GET['options'])) {
            $exitTitle = "Exit Payment Options";
            $exitLink = "numbers.php?py=" . $_GET['py'] . "&l1=overview";
        }
        elseif (isset($_SESSION['memberPage'])) {
            $exitTitle = "Exit Payment";
            $exitLink = "member.php?m=" . $_SESSION['memberPage'] . "&l1=payments";
        }
        elseif (isset($_SESSION['backPageNumbers']['home'])) {
            $exitTitle = "Exit Payment";
            $exitLink = $_SESSION['backPageNumbers']['home'];
        }
        else {
            $exitTitle = "Exit Payment";
            $exitLink = "numbers.php?l1=overview";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Project";
        $exitLink = "projects.php?l1=active";
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') {
        $showLinks = false;
        $exitTitle = "Cancel Custom Assignment";
        if (isset($_GET['p']))
            $exitLink = "projects.php?p=" . $_GET['p'] . "&options&l1=add";
        else
            $exitLink = "assignments.php";
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-task.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Custom Task";
        if (isset($_SESSION['new-task']['fields']['assignmentid']))
            $exitLink = "assignments.php?a=" . $_SESSION['new-task']['fields']['assignmentid'] . "&l1=assignment";
        else
            $exitLink = "assignments.php?l1=my&l2=active";
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-link.php') {
        $showLinks = false;
        if (isset($_SESSION['new-task']['new-link'])) {
            $exitTitle = "Cancel New Link";
            $exitLink = "new-task.php";
        }
        elseif (isset($_SESSION['new-link']['fields']['taskid'])) {
            $exitTitle = "Cancel New Link";
            $exitLink = "assignments.php?t=" . $_SESSION['new-link']['fields']['taskid'] . "&options&l1=edit&l2=links";
        }
        else {
            $exitTitle = "Cancel New Link";
            $exitLink = "assignments.php";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-member.php') {
        $showLinks = false;
        if (isset($_SESSION['new-member']['add-division-page'])) {
            $exitTitle = "Cancel Add Division";
            $exitLink = "new-member.php";
        }
        else {
            $exitTitle = "Cancel New Member";
            $exitLink = "member.php?l1=membership";
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-payment.php') {
        $showLinks = false;
        if (isset($_SESSION['new-payment']['add-asg-page'])) {
            $exitTitle = "Cancel Add Assignment";
            $exitLink = "new-payment.php";
        }
        else {
            $exitTitle = "Cancel New Payment";
            if (isset($_SESSION['new-payment']['exitLink']))
                $exitLink = $_SESSION['new-payment']['exitLink'];
            else
                $exitLink = "numbers.php?l1=everyone&l2=payments";
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/project.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Project Preset";
        $exitLink = "../r&d.php?l1=project&l2=projects";
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/assignment.php') {
        $showLinks = false;
        if (isset($_POST['add-task-page']) || isset($_SESSION['new-assignmentpr']['add-task-page'])) {
            $exitTitle = "Cancel Add Task";
            $exitLink = "assignment.php";
        }
        elseif (isset($_SESSION['new-projectpr']['new-assignmentpr'])) {
            $exitTitle = "Cancel New Assignment Preset";
            $exitLink = "project.php";
        }
        elseif (isset($_SESSION['edit-projectpr']['add-assignment'])) {
            $exitTitle = "Cancel New Assignment Preset";
            $exitLink = "../r&d.php?p=" . $_SESSION['edit-projectpr']['presetid'] . "&options&l1=edit&l2=assignments";
        }
        else {
            $exitTitle = "Cancel New Assignment Preset";
            $exitLink = "../r&d.php?l1=assignment&l2=assignments";
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/task.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Task Preset";
        if (isset($_SESSION['new-taskpr']['add-info-page'])) {
            $exitTitle = "Cancel Add Info Page";
            $exitLink = $_SERVER['REQUEST_URI'];
        }
        elseif (isset($_SESSION['edit-assignmentpr']['redirect'])) {
            if ($_SESSION['edit-assignmentpr']['redirect'] == 1)
                $exitLink = "../r&d.php?a=" . $_SESSION['new-taskpr']['fields']['assignmentid'] . "&l1=tasks";
            else
                $exitLink = "../r&d.php?a=" . $_SESSION['new-taskpr']['fields']['assignmentid'] . "&options&l1=edit&l2=tasks";
        }
        else
            $exitLink = "../r&d.php?l1=task&l2=tasks";
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/task-link.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Link";
        if (isset($_SESSION['new-task-link']['redirect'])) {
            if ($_SESSION['new-task-link']['redirect'] == 1)
                $exitLink = "../r&d.php?t=" . $_SESSION['new-task-link']['fields']['taskid'] . "&l1=links";
            else
                $exitLink = "../r&d.php?t=" . $_SESSION['new-task-link']['fields']['taskid'] . "&options&l1=edit&l2=links";
        }
        else
            $exitLink = "index.php";
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/info.php') {
        $showLinks = false;
        if (isset($_SESSION['new-taskpr']['new-infopage'])) {
            $exitTitle = "Cancel New Info Preset";
            $exitLink = "task.php";
        }
        else {
            $exitTitle = "Cancel New Info Preset";
            $exitLink = "../r&d.php?l1=task&l2=info";
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/product.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Product";
        $exitLink = "../r&d.php?l1=project&l2=products";
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/division.php') {
        $showLinks = false;
        if (isset($_SESSION['new-assignmentpr']['new-division'])) {
            $exitTitle = "Cancel New Division";
            $exitLink = "assignment.php";
        }
        elseif (isset($_SESSION['new-product']['new-division'])) {
            $exitTitle = "Cancel New Division";
            $exitLink = "product.php";
        }
        else {
            $exitTitle = "Cancel New Division";
            $exitLink = "../r&d.php?l1=assignment&l2=divisions";
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/department.php') {
        $showLinks = false;
        $exitTitle = "Cancel New Department";
        $exitLink = "../r&d.php?l1=assignment&l2=departments";
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/infogroup.php') {
        $showLinks = false;
        if (isset($_SESSION['new-infopage']['new-infogroup'])) {
            $exitTitle = "Cancel New Info Group";
            $exitLink = "info.php";
        }
        else {
            $exitTitle = "Cancel New Info Group";
            $exitLink = "../r&d.php?l1=task&l2=infogr";
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/linktype.php') {
        $showLinks = false;
        if (isset($_SESSION['new-task-link']['new-linktype'])) {
            $exitTitle = "Cancel New Link Type";
            $exitLink = "task-link.php";
        }
        else {
            $exitTitle = "Cancel New Link Type";
            $exitLink = "../r&d.php?l1=task&l2=linktypes";
        }
    }
    else {
        $showLinks = true;
        $exitTitle = "Log out of ep system";
        $exitLink = RootPath . "epsystem/account/logout.php";
    }

    if ($showLinks) { ?>
        <nav class="menu-header">
            <div class="link-container">
                <a href="<?php echo RootPath; ?>epsystem/account/projects.php?l1=active"<?php if ($page == "projects") echo ' class="active"'; ?>>Projects</a>
            </div>
            <div class="link-container">
                <a href="<?php echo RootPath; ?>epsystem/account/assignments.php?l1=my&l2=active"<?php if ($page == "assignments") echo ' class="active"'; ?>>Assignments</a>
            </div> <?php
            if (isset($account) && ($account->manager == 1)) { ?>
                <div class="link-container">
                    <a href="<?php echo RootPath; ?>epsystem/account/r&d.php"<?php if ($page == "r&d") echo ' class="active"'; ?>>R&D</a>
                </div>
                <div class="link-container">
                    <a href="<?php echo RootPath; ?>epsystem/account"<?php if ($page == "hub") echo ' class="active"'; ?>>Hub</a>
                </div>
                <div class="link-container">
                    <a href="<?php echo RootPath; ?>epsystem/account/resources.php"<?php if ($page == "resources") echo ' class="active"'; ?>>Resources</a>
                </div> <?php
            }
            else { ?>
                <div class="link-container">
                    <a href="<?php echo RootPath; ?>epsystem/account"<?php if ($page == "hub") echo ' class="active"'; ?>>Hub</a>
                </div> <?php
            } ?>
            <div class="link-container">
                <a href="<?php echo RootPath; ?>epsystem/account/numbers.php?l1=progress"<?php if ($page == "numbers") echo ' class="active"'; ?>>Numbers</a>
            </div>
            <div class="link-container">
                <a href="<?php echo RootPath; ?>epsystem/account/member.php?l1=membership"<?php if ($page == "member") echo ' class="active"'; ?>>Member</a>
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
        unset($_SESSION['new-assignment']);
        unset($_SESSION['backPage']['2']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'assignments.php') {
        if (!isset($_GET['options'])) {
            unset($_SESSION['paymentPage']);
        }
        unset($_SESSION['memberPage']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'r&d.php') {
        if (isset($_SESSION['edit-projectpr']['add-assignment']))
            unset($_SESSION['edit-projectpr']);
        if (isset($_SESSION['edit-taskpr']['add-infopage']))
            unset($_SESSION['edit-taskpr']);
        if (isset($_SESSION['edit-product']['add-division']))
            unset($_SESSION['edit-product']['add-division']);
        if (isset($_GET['p']))
            unset($_SESSION['backPageR&D']);
        if (isset($_GET['a'])) {
            unset($_SESSION['backPageR&D']['asg']);
            unset($_SESSION['backPageR&D']['tsk']);
        }
        if (isset($_GET['t']))
            unset($_SESSION['backPageR&D']['tsk']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'member.php') {
        if (isset($_GET['options']))
            unset($_SESSION['memberDivisionList']);
        unset($_SESSION['edit-member']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'numbers.php') {
        if (!isset($_GET['options']))
            unset($_SESSION['memberPage']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        unset($_SESSION['new-project']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-assignment.php') {
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
            unset($_SESSION['num']);
        }
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-link.php') {
        unset($_SESSION['new-link']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-member.php') {
        if (isset($_SESSION['new-member']['add-division-page']))
            unset($_SESSION['new-member']['add-division-page']);
        else
            unset($_SESSION['new-member']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-payment.php') {
        if (isset($_SESSION['new-payment']['add-asg-page']))
            unset($_SESSION['new-payment']['add-asg-page']);
        else
            unset($_SESSION['new-payment']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/project.php') {
        if (isset($_SESSION['new-projectpr']['add-assignment-page']))
            unset($_SESSION['new-projectpr']['add-assignment-page']);
        else
            unset($_SESSION['new-projectpr']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/assignment.php') {
        if (isset($_SESSION['new-assignmentpr']['add-task-page']))
            unset($_SESSION['new-assignmentpr']['add-task-page']);
        elseif (isset($_SESSION['new-projectpr']['new-assignmentpr'])) {
            unset($_SESSION['new-projectpr']['new-assignmentpr']);
            unset($_SESSION['new-assignmentpr']);
        }
        else
            unset($_SESSION['new-assignmentpr']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/task.php') {
        if (isset($_SESSION['new-taskpr']['add-info-page']))
            unset($_SESSION['new-taskpr']['add-info-page']);
        else {
            unset($_SESSION['new-taskpr']);
            unset($_SESSION['edit-assignmentpr']);
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/task-link.php') {
        unset($_SESSION['new-task-link']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/info.php') {
        unset($_SESSION['new-infopage']);
        unset($_SESSION['new-taskpr']['new-infopage']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/product.php') {
        if (isset($_SESSION['new-product']['add-division'])) {
            unset($_SESSION['new-product']['add-division']);
        }
        else {
            unset($_SESSION['new-product']);
        }
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/division.php') {
        if (isset($_SESSION['new-assignmentpr']['new-division'])) {
            unset($_SESSION['new-assignmentpr']['new-division']);
            unset($_SESSION['new-division']);
        }
        elseif (isset($_SESSION['new-product']['new-division'])) {
            unset($_SESSION['new-product']['new-division']);
            unset($_SESSION['new-division']);
        }
        else
            unset($_SESSION['new-division']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/department.php') {
        unset($_SESSION['new-department']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/infogroup.php') {
        if (isset($_SESSION['new-infopage']['new-infogroup'])) {
            unset($_SESSION['new-infopage']['new-infogroup']);
            unset($_SESSION['new-infogroup']);
        }
        else
            unset($_SESSION['new-infogroup']);
    }
    elseif ($_SERVER['REQUEST_URI'] == RootPath . 'epsystem/account/new-r&d/linktype.php') {
        if (isset($_SESSION['new-task-link']['new-linktype'])) {
            unset($_SESSION['new-task-link']['new-linktype']);
            unset($_SESSION['new-linktype']);
        }
        else
            unset($_SESSION['new-linktype']);
    }

    header("Location: " . $exitLink);
    exit();
}

//if (isset($_SESSION['backPageNumbers']))
//    var_dump($_SESSION['backPageNumbers']);
//if (isset($_SESSION['memberPage']))
//    var_dump($_SESSION['memberPage']);
//if (isset($_SESSION['paymentPage']))
//    var_dump($_SESSION['paymentPage']);
//var_dump($_SERVER['SCRIPT_FILENAME']);
//var_dump(basename($_SERVER['SCRIPT_FILENAME']));
//var_dump($_SERVER['REQUEST_URI']);
//var_dump(basename($_SERVER['REQUEST_URI']));
//var_dump($_SERVER['DOCUMENT_ROOT']);