<?php

/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/14/2015
 * Time: 8:17 AM
 */
namespace controllers\home;

use base\Controllers;
use library\Url;
use models\Options;
use models\Products;

class Home_Controllers extends Controllers
{
    public $slug;
    public $page;

    public function __construct()
    {
        parent::__construct();

        $this->slug = null;
        $this->page = null;

        //check exists card
        if(isset($_SESSION['cart']))
        {
            $cart = unserialize($_SESSION['cart']);
            $this->views->cart = $cart;
        }

        // auto load
        $this->loadOptions();
        $this->loadUrl();
    }

    private function loadOptions()
    {
        $options = new Options();
        $options = $options->select_all();
        $this->views->options = $options;
    }

    private function loadUrl()
    {
        $url = new Url();
        $this->views->url = $url;
    }

    protected function loadProductsFeatured($limit = 10)
    {
        $products_model = new Products();
        $products_model->setProFeatured(1);
        $this->views->products_featured = $products_model->select_featured($limit);
    }
}