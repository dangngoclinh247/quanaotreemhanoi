<?php

// controller, method default
define("CONTROLLER_DEFAULT", "welcome");
define("METHOD_DEFAULT", "index");
define("PARAMETER_DEFAULT", -1);

// info connect database
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "quanaotreemhanoi");


// table name format: qhn_(name)
define("DB_TABLE_PREFIX", "qhn_");

// define namespace app
define("NSP_BASE", "base\\");
define("NSP_CONTROLLER", "controllers\\");
define("NSP_CONTROLLER_ADMIN", NSP_CONTROLLER . "admin\\");
define("NSP_MODEL", "models\\");


define("BASENAME", __DIR__);