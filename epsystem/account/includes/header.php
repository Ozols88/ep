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
        if (isset($_GET['p'])) {
            $showLinks = false;
            $exitTitle = "Exit Project #" . sprintf('%04d', $_GET['p']);
            $exitLink = "/ep/epsystem/account/projects.php?t=active";
            if (isset($_GET['preview']))
                $exitLink = "/ep/epsystem/account/assignments.php?t=available&m=for-me&b=production";
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
                    <a href="/ep/epsystem/account/projects.php?t=active"<?php if ($page == "projects") echo ' class="active"'; ?>>Projects</a>
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
        <button class="exit-button" onclick="location.href='<?php echo $exitLink; ?>'"><?php echo $exitTitle; ?></button>
    </div> <?php
}
elseif ($_SESSION['account']->type == 2) { ?>
    <div class="container-header system">
        <img class="logo-header" src="/ep/epsystem/account/img/logo-client.svg" alt="ep"> <?php
        if (isset($_GET['p'])) {
            $showLinks = false;
            $exitTitle = "Exit Project #" . sprintf('%04d', $_GET['p']);
            $exitLink = "/ep/epsystem/account/projects.php?t=active";
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
                    <a href="/ep/epsystem/account/projects.php?t=active"<?php if ($page == "projects") echo ' class="active"'; ?>>Projects</a>
                </div>
                <div class="link-container">
                    <a href="/ep/epsystem/account/approvals.php?t=active"<?php if ($page == "approvals") echo ' class="active"'; ?>>Approvals</a>
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
        <button class="exit-button" onclick="location.href='<?php echo $exitLink; ?>'"><?php echo $exitTitle; ?></button>
    </div> <?php
}