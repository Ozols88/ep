<?php
require_once "database.php";

class Menu
{
    public static function getHud($className) {
        $object = new $className();
        if (method_exists($object, 'getHeadUp'))
            return $object::getHeadUp();
        else
            return null;
    }

    public static function getNavbar($className, $menuVariableName) {
        $object = new $className();
        if (method_exists($className, $menuVariableName))
            return $object::$menuVariableName();
        else
            return null;
    }
}