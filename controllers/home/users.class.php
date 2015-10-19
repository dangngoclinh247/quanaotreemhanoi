<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/15/2015
 * Time: 3:30 PM
 */

namespace controllers\home;

use library\Func;

class users extends Home_Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function account()
    {
        $this->views->render("home/page/404");
    }

    public function login()
    {

    }

    /**
     * Ajax check email validate for page: admin.php?c=users&m=add
     */
    public function ajax_check_email()
    {
        $result = "false";
        if (isset($_POST['user_email'])) {

            $user_email = $_POST['user_email'];
            $user_model = new \models\Users();
            $user_model->setUserEmail($user_email);
            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
                $user_model->setUserId($user_id);
                $user = $user_model->select_by_email_not_id();
                if (count($user) < 1) {
                    $result = "true";
                }
            } else {
                $user = $user_model->select_by_email();
                if (count($user) < 1) {
                    $result = "true";
                }
            }
        }
        echo $result;
    }

    public function insert()
    {
        $result = 0;
        $error = 0;
        if(!isset($_POST['user_email']) && $_POST['user_email'])
        {
            $error = 1;
        }
        if(!isset($_POST['user_pass']) && $_POST['user_pass'])
        {
            $error = 1;
        }
        if(!isset($_POST['user_phone1']) && $_POST['user_phone1'])
        {
            $error = 1;
        }
        if(!isset($_POST['user_name']) && $_POST['user_name'])
        {
            $error = 1;
        }
        if(!isset($_POST['user_address']) && $_POST['user_address'])
        {
            $error = 1;
        }

        if($error == 0)
        {
            //insert
            $user_model = new \models\Users();
            $user_model->setUserName($_POST['user_name']);
            $user_model->setUserEmail($_POST['user_email']);
            $user_model->setUserPass($_POST['user_pass']);
            $user_model->setUserPhone1($_POST['user_phone1']);
            $user_model->setUserAddress($_POST['user_address']);

            $salt = Func::genPasswordSalt();
            $user_model->setSalt($salt);

            $pass = Func::genPassword($_POST['user_pass'], $salt);
            $user_model->setUserPass($pass);

            if ($user_model->insert()) {
                $result = 1;
            }
        }
        echo $result;
    }
}