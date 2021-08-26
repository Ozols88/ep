<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
    if ($_SERVER['DOCUMENT_ROOT'] == "C:/wamp64/www/sites/") // http
        $path = $_SERVER['DOCUMENT_ROOT'] . "ep/epsystem/account/classes/";
    elseif ($_SERVER['DOCUMENT_ROOT'] == "C:/wamp64/www/sites") // https
        $path = $_SERVER['DOCUMENT_ROOT'] . "/ep/epsystem/account/classes/";
    else // godaddy
        $path = $_SERVER['DOCUMENT_ROOT'] . "/epsystem/account/classes/";
    $extension = ".php";
    $fullPath = $path . strtolower($className) . $extension;

    if (!file_exists($fullPath))
        return false;
    else
        include_once $fullPath;
}

if (!defined('InfobarCharLimit'))
    define('InfobarCharLimit', 19);
if (!defined('RootPath') && ($_SERVER['DOCUMENT_ROOT'] == "C:/wamp64/www/sites" || $_SERVER['DOCUMENT_ROOT'] == "C:/wamp64/www/sites/"))
    define('RootPath', '/ep/');
else
    define('RootPath', '/');

session_start();
if (isset($_SESSION['account']->lastRefresh)) {
    if (time() - $_SESSION['account']->lastRefresh > 3600) {
        Database::update('account', $_SESSION['account']->id, ['online' => 0, 'last_activity' => date("Y-m-d H-i-s")], false);
        session_destroy();
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
    elseif (time() - $_SESSION['account']->lastRefresh > 600) {
        Database::update('account', $_SESSION['account']->id, ['online' => 1, 'last_activity' => date("Y-m-d H-i-s")], false);
        $_SESSION['account']->lastRefresh = time();
    }
}
else
    session_destroy();