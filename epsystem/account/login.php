<html lang="en">
<head>
    <title>ep system login</title>
    <link rel="stylesheet" href="/ep/css/styles.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Nunito&display=swap" rel="stylesheet">
</head>
<body>
<div class="exit-container">
    <button class="exit-button" onclick="location.href='/ep/epsystem'">Go Back</button>
</div>
<div id="container-login">
    <div id="login-box">
        <form method="post">
            <img id="login-logo" src="/ep/epsystem/account/img/logo-login.svg" alt="ep">
            <input class="login-field" id="login-username-field" name="user" type="text" aria-label="Type Username" placeholder="Username">
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
            $_SESSION['account'] = $account;
        }
    } ?>
</div>
</body>
</html>