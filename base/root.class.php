<?php
namespace base;
class Root
{

    public function __construct()
    {
        $c = CONTROLLER_DEFAULT;
        if (isset($_GET['c'])) {
            $c = NSP_CONTROLLER_ADMIN . trim($_GET['c']);
        }

        // New Controller
        $controller = new $c;

        $m = METHOD_DEFAULT;
        if (isset($_GET['m'])) {
            $m = trim($_GET['m']);
        }

        if(isset($_GET['p']))
        {
            $controller->$m($_GET['p']);
        }
        else
        {
            $controller->$m();
        }
    }
}