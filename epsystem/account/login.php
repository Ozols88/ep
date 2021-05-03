<?php if (isset($_POST['exit']))
    header("Location: ../../"); ?>
<html lang="en">
<head>
    <title>ep system login</title>
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
    <link rel="stylesheet" href="../../css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <!--GOOGLE-->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-154665436-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-154665436-1');
    </script>
</head>
<body>
<form method="post" class="exit-container">
    <input type="submit" name="exit" value="Go back" class="exit-button">
</form>
<div id="container-login">
    <div id="login-box">
        <form method="post">
            <img id="login-logo" src="img/logo-login.svg" alt="ep">
            <input class="login-field" id="login-username-field" name="user" type="text" aria-label="Name" placeholder="Name">
            <input class="login-field" id="login-password-field" name="pass" type="password" aria-label="Password" placeholder="Password">
            <button id="login-button" name="login" type="submit">Enter</button>
        </form>
    </div> <?php
    if (isset($_POST['login'])) {
        $fields = [
            'user' => $_POST['user'],
            'pass' => $_POST['pass']
        ];
        $account = new Account($fields); ?>
        <div class="login-message"><?php echo $account->getLoginStatusName(); ?></div> <?php
        if ($account->loginStatus == 1) {
            session_start();
            $_SESSION['account'] = $account;
        }
    } ?>
</div>
</body>
</html>