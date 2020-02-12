<?php
spl_autoload_register('myAutoLoader');

function myAutoLoader($className) {
    $path = $_SERVER['DOCUMENT_ROOT'] . "ep/epsystem/account/classes/";
    $extension = ".php";
    $fullPath = $path . $className . $extension;

    if (!file_exists($fullPath))
        return false;
    else
        include_once $fullPath;
}