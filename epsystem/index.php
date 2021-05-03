<?php if (isset($_POST['exit']))
    header("Location: ../");
include "includes/autoloader.php"; ?>
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
    <!--realfavicongenerator.net-->
    <link rel="stylesheet" href="<?php echo RootPath; ?>css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154665436-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-154665436-1');
    </script>
</head>
<body>
<div class="container-header system">
    <img class="logo-header" src="account/img/logo-system.svg" alt="ep">
    <form method="post" class="exit-form">
        <input type="submit" name="exit" value="Go to ep home" class="exit-button">
    </form>
</div>
<div class="menu">
    <div class="head-up-display-bar">
        <span>Welcome to the ep system</span>
    </div>
    <div class="navbar level-1<?php if (!isset($_GET['l1'])) echo " current unselected"; ?>">
        <div class="container-button">
            <a href="?l1=about" class="button<?php if (isset($_GET['l1']) && $_GET['l1'] == "about") echo " active-menu"; ?>">
                <span>ABOUT</span> <?php
                if (!isset($_GET['l1'])) { ?>
                    <a href="?l1=about" class="home-menu">
                        <span class="title"></span>
                        <span class="description"></span>
                        <div class="total-count">
                            <div class="count"></div>
                            <span></span>
                        </div>
                        <div class="last-hours">
                            <span class="title"></span>
                        </div>
                        <div class="bottom">
                            <span class="note"></span>
                        </div>
                    </a> <?php
                } ?>
            </a>
        </div>
        <div class="container-button">
            <a href="account" class="button">
                <span>Login</span> <?php
                if (!isset($_GET['l1'])) { ?>
                    <a href="account" class="home-menu">
                        <span class="title"></span>
                        <span class="description"></span>
                        <div class="total-count">
                            <div class="count"></div>
                            <span></span>
                        </div>
                        <div class="last-hours">
                            <span class="title"></span>
                        </div>
                        <div class="bottom">
                            <span class="note"></span>
                        </div>
                    </a> <?php
                } ?>
            </a>
        </div>
    </div>
    <?php if (isset($_GET['l1']) && $_GET['l1'] == "about") { ?>
        <div class="navbar level-2 current unselected">
            <div class="container-button">
                <a class="button">
                    <span>What</span>
                    <a class="home-menu">
                        <span class="title"></span>
                        <span class="description"></span>
                        <div class="total-count">
                            <div class="count"></div>
                            <span></span>
                        </div>
                        <div class="last-hours">
                            <span class="title"></span>
                        </div>
                        <div class="bottom">
                            <span class="note"></span>
                        </div>
                    </a>
                </a>
            </div>
            <div class="container-button">
                <a class="button">
                    <span>How</span>
                    <a class="home-menu">
                        <span class="title"></span>
                        <span class="description"></span>
                        <div class="total-count">
                            <div class="count"></div>
                            <span></span>
                        </div>
                        <div class="last-hours">
                            <span class="title"></span>
                        </div>
                        <div class="bottom">
                            <span class="note"></span>
                        </div>
                    </a>
                </a>
            </div>
            <div class="container-button">
                <a class="button">
                    <span>Why</span>
                    <a class="home-menu">
                        <span class="title"></span>
                        <span class="description"></span>
                        <div class="total-count">
                            <div class="count"></div>
                            <span></span>
                        </div>
                        <div class="last-hours">
                            <span class="title"></span>
                        </div>
                        <div class="bottom">
                            <span class="note"></span>
                        </div>
                    </a>
                </a>
            </div>
        </div> <?php
    } ?>
</div>
<div class="container-footer system">
    <span class="copyright">© enokspriede.com 2020</span>
</div>
</body>
</html>