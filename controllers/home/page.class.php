<?php

/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/14/2015
 * Time: 8:23 AM
 */
namespace controllers\home;

use library\Breadcrumb;
use models\News;
use models\Users;

class page extends Home_Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    public function contact()
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->setH2("Liên hệ");
        $breadcrumb->addLink("/", "Trang chủ");
        $breadcrumb->addLink("/contact.html", "Liên hệ", true);
        $this->views->breadcrumb = $breadcrumb;

        //get news
        $news_model = new News();


        $this->views->setPageTitle("Liên hệ");
        $this->views->render("home/page/contact");
    }

    public function logout()
    {
        session_destroy();
        setcookie("email", null, time() - 60 * 60 * 24 * 30);
        setcookie("password", null, time() - 60 * 60 * 24 * 30);
        header("Location: /");
    }

    public function cart()
    {
        if(isset($_POST['user_name']))
        {
            echo "<pre>";
            print_r($_POST);
            echo "</pre>";
            exit;
        }
        if(isset($_SESSION['user_id']))
        {
            $users_model = new Users();
            $users_model->setUserId($_SESSION['user_id']);

            $user = $users_model->select();
            /*print_r($user);
            exit;*/

            $this->views->user = $user;
        }
        $this->views->setPageTitle("Giỏ hàng");
        $this->views->render("home/cart/index");
    }
}