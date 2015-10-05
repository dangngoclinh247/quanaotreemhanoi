<?php
namespace base;

use models\Users;

class Root
{

    public function __construct()
    {
        // Create session if user have login
        if(isset($_COOKIE['email']) && isset($_COOKIE['password']))
        {
            if(!isset($_SESSION['user_id']) ||
                !isset($_SESSION['user_name']) ||
                !isset($_SESSION['user_roles']))
            {
                $user_email = $_COOKIE['email'];
                $user_pass = $_COOKIE['password'];

                $user_model = new Users();
                $user = $user_model->login($user_email, $user_pass);
                if(count($user) > 0)
                {
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_roles'] = $user['roles_id'];
                }
            }
        }

        if(!isset($_SESSION['user_id']) ||
            !isset($_SESSION['user_name']) ||
            !isset($_SESSION['user_roles']) ||
            $_SESSION['user_roles'] != 6)
        {
            $page_login = "/admin/login.html";
            $page_login_process = "/admin/login/process.html";

            if(SITE_URL != $page_login && SITE_URL != $page_login_process)
            {
                $_SESSION['page_back'] = SITE_URL;
                header("Location: $page_login");
            }
        }


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