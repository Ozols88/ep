<html lang="en">
<head>
    <title>ep home</title>
    <!--realfavicongenerator.net-->
    <link rel="apple-touch-icon" sizes="180x180" href="icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="icons/favicon-16x16.png">
    <link rel="manifest" href="icons/site.webmanifest">
    <link rel="mask-icon" href="icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#705d34">
    <meta name="msapplication-config" content="icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!--realfavicongenerator.net-->
    <link rel="stylesheet" href="/ep/css/styles.css" type="text/css">
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
<div class="container-header">
    <img class="logo-header" src="/ep/img/logo.svg" alt="ep">
    <!--<nav class="menu-header">
        <div class="link-container">
            <a href="epvideos">ep videos</a>
        </div>
        <div class="link-container">
            <a href="epexplainers">ep explainers</a>
        </div>
        <div class="link-container">
            <a href="epsystem">ep system</a>
        </div>
    </nav>-->
    <img class="logo-header" src="/ep/img/logo.svg" alt="ep" style="visibility: hidden">
</div>
<div class="menu">
    <div class="head-up-display-bar">
        <span>Welcome</span>
    </div>
    <div class="navbar level-1">
        <div class="container-button">
            <a href="epexplainers" class="button">
                <span>ep explainers</span>
            </a>
        </div>
        <div class="container-button">
            <a href="?l1=enokspriede" class="button">
                <span>enokspriede</span>
            </a>
        </div>
        <div class="container-button">
            <a href="epsystem" class="button">
                <span>ep system</span>
            </a>
        </div>
    </div>
    <?php if (isset($_GET['l1']) && $_GET['l1'] == "enokspriede") { ?>
        <div class="navbar level-2">
            <div class="container-button disabled">
                <a class="button disabled"></a>
            </div>
            <div class="container-button">
                <a class="button">
                    <span>Button 1</span>
                </a>
            </div>
            <div class="container-button disabled">
                <a class="button disabled"></a>
            </div>
        </div>
        <?php
    } ?>
</body>
</html>