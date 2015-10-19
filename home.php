<?php
session_start();
define('SITE_ROOT', realpath(dirname(__FILE__)));
define('SITE_URL', $_SERVER['REQUEST_URI']);
define('DOMAIN_NAME', "http://quanaotreemhanoi.dev");

require_once "base/config.php";
require_once "base/init.php";


$c = CONTROLLER_DEFAULT;
if (isset($_GET['c'])) {
    $c = NSP_CONTROLLER_HOME . trim($_GET['c']);
}

// New Controller
$controller = new $c;

$m = METHOD_DEFAULT;
if (isset($_GET['m'])) {
    $m = trim($_GET['m']);
}

$page = 1;
if (isset($_GET['page']) && $_GET['page'] > $page) {
    $page = $_GET['page'];
}

if(isset($_GET['slug']))
{
    $controller->slug = $_GET['slug'];
}

if (isset($_GET['p'])) {
    if ($page > 1) {
        $controller->$m($_GET['p'], $page);
    } else {
        $controller->$m($_GET['p']);
    }
} else {
    $controller->$m();
}