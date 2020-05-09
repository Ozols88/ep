<html lang="en">
<head>
    <title>ep joinery</title>
    <!--realfavicongenerator.net-->
    <link rel="apple-touch-icon" sizes="180x180" href="../icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../icons/favicon-16x16.png">
    <link rel="manifest" href="../icons/site.webmanifest">
    <link rel="mask-icon" href="../icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="../icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#705d34">
    <meta name="msapplication-config" content="icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!--realfavicongenerator.net-->
    <link rel="stylesheet" href="/ep/css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
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
    <img class="logo-header" src="/ep/epjoinery/img/logo.svg" alt="ep">
    <form method="post" class="exit-form">
        <input type="submit" name="exit" value="Go to ep home" class="exit-button">
    </form></div>
<div class="menu">
    <div class="head-up-display-bar">
        <span>Welcome to ep joinery</span>
    </div>
    <div class="navbar level-1">
        <div class="container-button disabled">
            <a class="button"></a>
        </div>
        <div class="container-button">
            <a href="" class="button">
                <span>A BUTTON</span>
            </a>
        </div>
        <div class="container-button disabled">
            <a class="button"></a>
        </div>
    </div>
</body>
</html> <?php
if (isset($_POST['exit'])) {
    header("Location: /ep");
}