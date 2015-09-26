<?php
function __autoload($className)
{
    $className = strtolower($className);

    // Remove \ left string
    $className = ltrim($className, "\\");

    if(file_exists($className . ".class.php"))
    {
        require $className . ".class.php";
    }
    else
    {
        die("class not found " . $className);
    }
}