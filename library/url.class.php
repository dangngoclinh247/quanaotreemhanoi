<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/14/2015
 * Time: 1:16 PM
 */

namespace library;


class Url
{
    private $_template_page;
    private $_template_blog_view;
    private $_template_shop;
    private $_template_shop_view;
    private $_template_shop_type;

    public function __construct()
    {
        $this->_template_page = DOMAIN_NAME . "/{slug}.html";
        $this->_template_blog_view = DOMAIN_NAME . "/tin-tuc/{news_id}-{news_slug}.html";
        $this->_template_shop_view = DOMAIN_NAME . "/san-pham/{pro_id}-{pro_slug}.html";
        $this->_template_shop_type = DOMAIN_NAME . "/san-pham/{prot_id}-{prot_slug}";
    }

    public function getUrlPage($slug)
    {
        $result = $this->_template_page;
        $result = str_replace("{slug}", $slug, $result);
        return $result;
    }

    public function getUrlBlogView($news_id, $news_slug)
    {
        $result = $this->_template_blog_view;
        $result = str_replace("{news_id}", $news_id, $result);
        $result = str_replace("{news_slug}", $news_slug, $result);
        return $result;
    }

    public function getUrlShopView($pro_id, $pro_slug)
    {
        $result = $this->_template_shop_view;
        $result = str_replace("{pro_id}", $pro_id, $result);
        $result = str_replace("{pro_slug}", $pro_slug, $result);
        return $result;
    }

    public function getUrlShopType($prot_id, $prot_slug)
    {
        $result = $this->_template_shop_type;
        $result = str_replace("{prot_id}", $prot_id, $result);
        $result = str_replace("{prot_slug}", $prot_slug, $result);
        return $result;
    }
}