<?php

/** AutoLoader spl=standard php library
 * @param $className
 * @return string
 */

function myAutoLoader($className)
{
    $className = str_replace("\\", "/", $className);
    //die($className);
    $rootPath = dirname(__DIR__);
    $fullPath = "$rootPath/$className.php";
    //die($fullPath);
    return require $fullPath;
}
