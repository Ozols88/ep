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
    <!--realfavicongenerator.net-->
    <link rel="stylesheet" href="/ep/css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script src="/ep/epsystem/account/js/js.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154665436-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-154665436-1');
    </script>
</head>
<body> <?php
if ($_SESSION['account']->type == 1) { ?>
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
                if (isset($_GET['preview']))
                    $exitLink = "/ep/epsystem/account/assignments.php?l1=available&l2=production";
                else
                    $exitLink = "/ep/epsystem/account/projects.php?l1=active";
            }
        }
        elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
            $showLinks = false;
            if (isset($_POST['new-client']) || isset($_SESSION['new-project']['new-client'])) {
                $exitTitle = "Cancel New Client";
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
            elseif (isset($_GET['p']) && isset($_GET['t'])) {
                $exitTitle = "Cancel New Assignment";
                $exitLink = "/ep/epsystem/account/projects.php?p=" . $_GET['p'] . "&l1=" . $_GET['t'];
            }
            elseif (isset($_SESSION['new-project']['new-assignment'])) {
                $exitTitle = "Cancel New Assignment";
                $exitLink = "/ep/epsystem/account/new-project.php";
            }
            else {
                $exitTitle = "Cancel New Assignment";
                $exitLink = "/ep/epsystem/account/assignments.php";
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
            else {
                $exitTitle = "Cancel New Task";
                $exitLink = "/ep/epsystem/account/assignments.php";
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
                    <a href="/ep/epsystem/account/assignments.php"<?php if ($page == "assignments") echo ' class="active"'; ?>>Assignments</a>
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
        } ?>
        <form method="post" class="exit-form">
            <input type="submit" name="exit" value="<?php echo $exitTitle; ?>" class="exit-button">
        </form>
    </div> <?php
}
elseif ($_SESSION['account']->type == 2) { ?>
    <div class="container-header system">
        <img class="logo-header" src="/ep/epsystem/account/img/logo-client.svg" alt="ep"> <?php
        if (isset($_GET['p'])) {
            $showLinks = false;
            $exitTitle = "Exit Project #" . sprintf('%04d', $_GET['p']);
            $exitLink = "/ep/epsystem/account/projects.php?l1=active";
        }
        else {
            $showLinks = true;
            $exitTitle = "Log out of the ep system";
            $exitLink = "/ep/epsystem/account/logout.php";
        }
        if ($showLinks) { ?>
            <nav class="menu-header">
                <div class="link-container">
                    <a href="/ep/epsystem/account/"<?php if ($page == "hub") echo ' class="active"'; ?>>Hub</a>
                </div>
                <div class="link-container">
                    <a href="/ep/epsystem/account/projects.php?l1=active"<?php if ($page == "projects") echo ' class="active"'; ?>>Projects</a>
                </div>
                <div class="link-container">
                    <a href="/ep/epsystem/account/approvals.php?l1=active"<?php if ($page == "approvals") echo ' class="active"'; ?>>Approvals</a>
                </div>
                <span></span>
                <div class="link-container">
                    <a href="/ep/epsystem/account/files.php"<?php if ($page == "files") echo ' class="active"'; ?>>Files</a>
                </div>
                <div class="link-container">
                    <a href="/ep/epsystem/account/r&d.php"<?php if ($page == "r&d") echo ' class="active"'; ?>>R&D</a>
                </div>
                <span></span>
                <div class="link-container">
                    <a href="/ep/epsystem/account/numbers.php"<?php if ($page == "numbers") echo ' class="active"'; ?>>Numbers</a>
                </div>
                <div class="link-container">
                    <a href="/ep/epsystem/account/client.php"<?php if ($page == "client") echo ' class="active"'; ?>>Client</a>
                </div>
            </nav> <?php
        } ?>
        <form method="post" class="exit-form">
            <input type="submit" name="exit" value="<?php echo $exitTitle; ?>" class="exit-button">
        </form>
    </div> <?php
}

if (isset($_POST['exit'])) {
    if (isset($_GET['preview2'])) {
        echo "<script>window.close();</script>";
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'projects.php') {
        if (isset($_SESSION['add-client']['new-client']))
            unset($_SESSION['add-client']['new-client']);
        unset($_SESSION['new-manager']);
    }
    elseif (basename($_SERVER['PHP_SELF']) == 'new-project.php') {
        if (isset($_SESSION['new-project']['new-client']))
            unset($_SESSION['new-project']['new-client']);
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
        else {
            unset($_SESSION['new-assignment']['new-task']);
            unset($_SESSION['new-task']);
        }
    }

    header("Location: " . $exitLink);
}
