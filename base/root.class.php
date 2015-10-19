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
                $user_model = new Users();
                $user_model->setUserEmail($_COOKIE['email']);
                $user_model->setUserPass($_COOKIE['password']);
                $user = $user_model->select_by_email_and_pass();
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
            $page_login = "/admin.php?c=login";
            $page_login_process = "/admin.php?c=login&m=process";

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

        $page = 1;
        if(isset($_GET['page']) && $_GET['page'] > $page)
        {
            $page = $_GET['page'];
        }

        if(isset($_GET['p']))
        {
            if($page > 1) {
                $controller->$m($_GET['p'], $page);
            } else
            {
                $controller->$m($_GET['p']);
            }
        }
        else
        {
            $controller->$m();
        }
    }
}