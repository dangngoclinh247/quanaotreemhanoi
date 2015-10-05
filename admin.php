<?php
session_start();
define ('SITE_ROOT', realpath(dirname(__FILE__)));
define('SITE_URL', $_SERVER['REQUEST_URI']);

require_once "base/config.php";
require_once "base/init.php";

new base\Root();