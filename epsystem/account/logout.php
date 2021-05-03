<?php
include "includes/autoloader.php";
if (isset($_SESSION['account']))
    Database::update('account', $_SESSION['account']->id, ['online' => 0, 'last_activity' => date("Y-m-d H-i-s")], false);
session_destroy();
header("location: ../../");