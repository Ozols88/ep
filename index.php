<?php
include "epsystem/account/includes/autoloader.php"; ?>
<html lang="en">
<head>
    <title>ep home</title>
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
    <div class="logo-container"><a class="logo-link"><img class="logo-header" src="<?php echo RootPath; ?>img/logo.svg" alt="ep"></a></div>
</div>
<div class="menu"> <?php
    require "epsystem/account/includes/menu.php"; ?>
</div>
<div class="container-footer">
    <span class="copyright">© enokspriede.com 2020</span>
</div>
</body>
</html>