<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/2/2015
 * Time: 8:51 PM
 */

namespace controllers\admin;

use base;
use library\Func;
use models;

class brand extends base\Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    public function index()
    {
        $this->views->setPageTitle("Quản lý thương hiệu");
        $this->views->render("admin/products/brand");
    }

    public function edit($brand_id)
    {

    }

    public function delete($brand_id)
    {
        $result = 0;
        $brand_model = new models\Brand();
        if ($brand_model->delete($brand_id)) {
            $result = 1;
        }
        echo $result;
    }

    public function ajax_list($brand_id_highlight = -1)
    {
        $brand_model = new models\Brand();
        $this->views->brands = $brand_model->selectAll();
        $this->views->brand_id_highlight = $brand_id_highlight;
        $this->views->render("admin/products/brand_list");
    }

    public function ajax_add()
    {
        $result = "-1";
        if (isset($_POST['brand_name']) && $_POST['brand_name'] != "") {

            $data = array(
                "brand_name" => $_POST['brand_name'],
                "brand_slug" => null,
                "brand_content" => null,
                "brand_seo_title" => null,
                "brand_seo_description" => null
            );

            if (isset($_POST['brand_slug']) && $_POST['brand_slug'] != "") {
                $data['brand_slug'] = Func::getSlug($_POST['brand_slug']);
            } else {
                $data['brand_slug'] = Func::getSlug($data['brand_name']);
            }

            if (isset($_POST['brand_seo_title']) && $_POST['brand_seo_title'] != "") {
                $data['brand_seo_title'] = $_POST['brand_seo_title'];
            }

            if (isset($_POST['brand_seo_description']) && $_POST['brand_seo_description'] != "") {
                $data['brand_seo_description'] = $_POST['brand_seo_description'];
            }

            if (isset($_POST['brand_content']) && strip_tags($_POST['brand_content']) != "") {
                $data['brand_content'] = $_POST['brand_content'];
            }

            $brand_model = new models\Brand();
            if ($brand_model->insert($data)) {
                $result = $brand_model->insert_id;
            }
        }
        //print_r($data);
        echo $result;
    }

    public function ajax_update($brand_id)
    {
        $result = "0";
        if (isset($_POST['brand_name']) && $_POST['brand_name'] != "") {

            $data = array(
                "brand_name" => $_POST['brand_name'],
                "brand_slug" => null,
                "brand_content" => null,
                "brand_seo_title" => null,
                "brand_seo_description" => null
            );

            if (isset($_POST['brand_slug']) && $_POST['brand_slug'] != "") {
                $data['brand_slug'] = Func::getSlug($_POST['brand_slug']);
            } else {
                $data['brand_slug'] = Func::getSlug($data['brand_name']);
            }

            if (isset($_POST['brand_seo_title']) && $_POST['brand_seo_title'] != "") {
                $data['brand_seo_title'] = $_POST['brand_seo_title'];
            }

            if (isset($_POST['brand_seo_description']) && $_POST['brand_seo_description'] != "") {
                $data['brand_seo_description'] = $_POST['brand_seo_description'];
            }

            if (isset($_POST['brand_content']) && $_POST['brand_content'] != "") {
                $data['brand_content'] = $_POST['brand_content'];
            }

            $brand_model = new models\Brand();
            if ($brand_model->update($data, $brand_id)) {
                $result = "1";
            }
        }
        print_r($data);
        echo $result;
    }
}