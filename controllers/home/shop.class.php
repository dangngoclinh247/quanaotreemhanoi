<?php
/**
 * Created by PhpStorm.
 * User: TruongHung
 * Date: 10/14/2015
 * Time: 4:59 PM
 */

namespace controllers\home;


use library\Breadcrumb;
use library\Cart;
use library\Pagination;
use models\Brand;
use models\Images;
use models\Products;
use models\Products_Type;
use models\Products_Type_Details;

class shop extends Home_Controllers
{
    public function __construct()
    {
        parent::__construct();

        //SELECT products featured $limit = 10
        $this->loadProductsFeatured(5);
    }

    public function index($page = 1)
    {
        //Create breadcrumb
        $breadcrumb = new Breadcrumb();
        $breadcrumb->setH2("Quần áo trẻ em");
        $breadcrumb->addLink("/", "Quần áo trẻ em", true);
        $this->views->breadcrumb = $breadcrumb;

        //Pagination
        //SELECT products
        $products_model = new Products();

        $products_per_page = $this->views->options['products_per_page'];
        $start = ($page - 1) * $products_per_page;
        $stop = $products_per_page;
        $total_products = $products_model->selectLimitCount();
        $total_page = ceil($total_products / $products_per_page);
        $pagination = new Pagination();
        $pagination->setTotalPage($total_page);
        $pagination->setCurrentPage($page);
        $pagination->setUrl(DOMAIN_NAME . "/{page}.html");
        $this->views->pagination = $pagination;

        $products = $products_model->select_home_limit($start, $stop);
        $products = $this->initProducts($products);


        $this->views->products = $products;
        $this->views->setPageTitle($this->views->options['website_seo_title']);
        $this->views->render("home/shop/index");
    }

    public function view($pro_id)
    {
        //SELECT products
        $products_model = new Products();
        $products_model->setProId($pro_id);
        $product = $products_model->select();

        //SELECT products type
        $products_type_details_model = new Products_Type_Details();
        $products_type_details_model->setProId($pro_id);
        $products_type = $products_type_details_model->selectInfoByProducts();
        $this->views->products_type = $products_type;

        //SELECT all images
        $images_model = new Images();
        $images_model->setProId($pro_id);
        $images = $images_model->selectAllProducts(true);
        $this->views->images = $images;

        //SELECT brand
        $brand_model = new Brand();
        $brand_model->setBrandId($product['brand_id']);
        $brand = $brand_model->select();
        $this->views->brand = $brand;

        //SELECT products related
        $prot_id = array();
        foreach ($products_type as $type) {
            $prot_id[] = $type['prot_id'];
        }
        $prot_id = join(",", $prot_id);
        $products_related = $products_model->selectRelated($prot_id, $product['pro_id']);
        $this->views->products_related = $this->initProducts($products_related);

        $this->views->product = $product;
        $this->views->setPageTitle($this->views->options['website_seo_title']);
        $this->views->render("home/shop/view");
    }

    public function type($prot_id)
    {
        echo "product_type";
    }

    public function vote($pro_id)
    {
        $result = 0;
        if (isset($_POST['pro_rate']) && $_POST['pro_rate'] >= 0 && $_POST['pro_rate'] <= 5) {
            $pro_rate = floatval($_POST['pro_rate']);
            $product_model = new Products();
            $product_model->setProId($pro_id);
            $product = $product_model->select();
            if (count($product) > 0) {
                if ($product['pro_rate'] == null) {
                    $product_model->setProRate($pro_rate);
                } else {
                    $pro_rate = ($pro_rate + $product['pro_rate']) / 2;
                    $product_model->setProRate($pro_rate);
                }
                if ($product_model->update_rate()) {
                    $result = 1;
                }
            }
        }
        echo $result;
    }

    public function add_to_cart($pro_id)
    {
        $result = 0;
        //SELECT products
        $products_model = new Products();
        $products_model->setProId($pro_id);
        $product = $products_model->select();

        if (count($product) > 0) {
            // SELECT IMAGE
            $images = new Images();
            $images->setProId($pro_id);
            $images = $images->selectProductsFeatured();
            if (count($images) > 0) {
                $image = $images[0];
                $product['img_url'] = $image['img_url'];
            }
            if (isset($_SESSION['cart'])) {
                $cart = unserialize($_SESSION['cart']);
                $cart->add_product($product['pro_id'], $product);
            } else {
                $cart = new Cart();
                $cart->add_product($product['pro_id'], $product);
            }
            $_SESSION['cart'] = serialize($cart);
            $result = 1;
        }
        echo $result;
    }

    public function remove_from_cart($pro_id)
    {
        $result = 0;
        //SELECT products
        $products_model = new Products();
        $products_model->setProId($pro_id);
        $product = $products_model->select();

        if (count($product) > 0) {
            $cart = unserialize($_SESSION['cart']);
            if ($cart->remove_product($product['pro_id'])) {
                $result = 1;
            }
            $_SESSION['cart'] = serialize($cart);
        }
        echo $result;
    }

    public function update_quantity($pro_id)
    {
        $result = 0;
        if(isset($_POST['pro_quantity']) && intval($_POST['pro_quantity']) >=1) {
            $quantity = intval($_POST['pro_quantity']);
            $cart = unserialize($_SESSION['cart']);
            if ($cart->update_quantity($pro_id, $quantity)) {
                $result = 1;
            }
            $_SESSION['cart'] = serialize($cart);
        }
        echo $result;
    }

    private function initProducts(&$products, $pro_id = null)
    {
        $result = array();
        if ($pro_id == null) {
            foreach ($products as $key => $product) {
                unset($products[$key]);
                $product["images"] = $this->initProducts($products, $product['pro_id']);
                $result[] = $product;
            }
        } else {
            foreach ($products as $key => $product) {
                if ($product['pro_id'] == $pro_id) {
                    unset($products[$key]);
                    $result[] = $product;
                } else {
                    break;
                }
            }
        }
        return $result;
    }
}