<?php

/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/14/2015
 * Time: 11:47 AM
 */
namespace controllers\home;

use library\Breadcrumb;
use library\Pagination;
use models\Images;
use models\Users;

class news extends Home_Controllers
{
    public function __construct()
    {
        parent::__construct();

        //SELECT products featured $limit = 10
        $this->loadProductsFeatured(5);
    }

    public function index($page = 1)
    {
        $breadcrumb = new Breadcrumb();
        $breadcrumb->setH2("Tin Tức");
        $breadcrumb->addLink("/", "Trang chủ");
        $breadcrumb->addLink("/tin-tuc.html", "Tin Tức", true);
        $this->views->breadcrumb = $breadcrumb;

        $news_per_page = $this->views->options['products_per_page'];
        $news_model = new \models\News();
        $start = ($page - 1) * $news_per_page;
        $stop = $news_per_page;
        $total_products = $news_model->select_limit_count();

        $total_page = ceil($total_products / $news_per_page);
        $pagination = new Pagination();
        $pagination->setTotalPage($total_page);
        $pagination->setCurrentPage($page);
        $pagination->setUrl(DOMAIN_NAME . "/tin-tuc/{page}.html");
        $this->views->pagination = $pagination;


        echo $page;
        $news = $news_model->select_limit($start, $stop);
        $this->views->news = $news;

        $this->views->setPageTitle("Tin Tức");
        $this->views->render("home/news/index");
    }

    public function cat($news_type_id)
    {

    }

    public function view($news_id)
    {
        //SELECT news
        $news_model = new \models\News();
        $news_model->setNewsId($news_id);
        $news = $news_model->select();

        //SELECT images featured
        $images_model = new Images();
        $images_model->setNewsId($news_id);
        $image = $images_model->selectNewsFeatured();

        //SELECT User
        $users_model = new Users();
        $user = $users_model->select($news['user_id']);


        $this->views->news = $news;
        $this->views->image = $image;
        $this->views->user = $user;

        $breadcrumb = new Breadcrumb();
        $breadcrumb->setH2("Tin Tức");
        $breadcrumb->addLink("/", "Trang chủ");
        $breadcrumb->addLink("/tin-tuc.html", "Tin Tức", true);
        $this->views->breadcrumb = $breadcrumb;

        $this->views->setPageTitle("Tin Tức");
        $this->views->render("home/news/view");
    }

    public function comments($com_id)
    {

    }
}