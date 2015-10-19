<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/4/2015
 * Time: 10:52 PM
 */

namespace controllers\admin;

use base;
use library\Func;
use models;

class login extends base\Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->views->addHeader('<link rel="stylesheet" href="/templates/admin/css/bootstrap.min.css">');
        $this->views->addHeader('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">');
        $this->views->addHeader('<link rel="stylesheet" href="/templates/admin/css/login.css">');
    }

    /**
     * Show form login: /admin/login.html
     */
    public function index()
    {
        $this->views->setPageTitle("Đăng nhập");
        $this->views->render("admin/login/index");
    }

    /**
     * process login when click submit: /admin/login.html
     */
    public function process()
    {
        $result = 0;
        if(isset($_POST['email']) && isset($_POST['pass']))
        {
            $user_email = $_POST['email'];
            $user_pass = $_POST['pass'];
            $remember = $_POST['remember'];

            $user_model = new models\Users();
            $user_model->setUserEmail($user_email);
            $user = $user_model->select_by_email();
            if(count($user) > 0)
            {

                $user_pass = Func::genPassword($user_pass, $user['salt']);
                $user_model->setUserPass($user_pass);
                $user = $user_model->select_by_email_and_pass();
                if(count($user) > 0)
                {
                    $_SESSION['user_name'] = $user['user_name'];
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['user_roles'] = $user['roles_id'];
                    if($remember == "true") {
                        setcookie("email", $user['user_email'], time() + 60 * 60 * 24 * 30);
                        setcookie("password", $user['user_pass'], time() + 60 * 60 * 24 * 30);
                    }

                    $result = 1;
                }
            }
        }
        echo $result;
    }

    /**
     * Page Logout
     */
    public function logout()
    {
        session_unset();
        session_destroy();

        setcookie("email", "", time() - 3600);
        setcookie("password", "", time() - 3600);

        header("Location: /admin/login.html");
    }

    /**
     * Check login, if(have login)
     */
    public function checkLogin()
    {
        if(isset($_SESSION['user_name']) &&
            isset($_SESSION['user_id']) &&
            isset($_SESSION['user_roles']))
        {
            exit("Da dang nhap");
        }
    }
}