<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/14/2015
 * Time: 8:23 AM
 */
namespace controllers\home;

use library\Alert;
use library\Breadcrumb;
use models\Cart;
use models\Cart_Details;
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
        if(!isset($_SESSION['cart']))
        {
            header("Location: /");
        }
        if (isset($_POST['order'])) {
            $message = new Alert();
            $cart_model = new Cart();
            $cart = unserialize($_SESSION['cart']);
            if(isset($_SESSION['user_id']))
            {
                $cart_model->setUserId($_SESSION['user_id']);
                $cart_model->setCartNotes($_POST['cart_notes']);
                $cart_model->setCartPrice($cart->getTotalPrice());
                if($cart_model->insert())
                {
                    $cart_id = $cart_model->insert_id;
                    foreach($cart->getProducts() as $product)
                    {
                        $cart_details = new Cart_Details();
                        $cart_details->setCartId($cart_id);
                        $cart_details->setProId($product['pro_id']);
                        $cart_details->setCdetailQuantity($product['quantity']);
                        $cart_details->setCdetailSize($product['info']['pro_size']);
                        $cart_details->setCdetailPrice($product['info']['pro_price']);
                        $cart_details->insert();
                    }
                    //remove cart
                    unset($_SESSION['cart']);
                }
            }
            else
            {
                $message->setType(Alert::TYPE_DANGER);
            }
            $this->views->message = $message;
        }
        if (isset($_SESSION['user_id'])) {
            $users_model = new Users();
            $users_model->setUserId($_SESSION['user_id']);

            $user = $users_model->select();
            $this->views->user = $user;
        }
        $breadcrumb = new Breadcrumb();
        $breadcrumb->setH2("Giỏ Hàng");
        $breadcrumb->addLink("/", "Trang Chủ");
        $breadcrumb->addLink("", "Giỏ hàng", true);
        $this->views->breadcrumb = $breadcrumb;

        $this->views->setPageTitle("Giỏ hàng");
        $this->views->render("home/cart/index");
    }

    public function cart_btn()
    {
        $this->views->render("home/cart");
    }
}