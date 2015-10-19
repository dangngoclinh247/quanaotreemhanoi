<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/2/2015
 * Time: 8:51 PM
 */

namespace controllers\admin;

use library\Func;
use models;

class brand extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    /**
     * BRAND INDEX PAGE: /admin.php?c=brand
     */
    public function index()
    {
        if (isset($_POST['btn-update-brand']) && isset($_POST['brand_id']) && $_POST['brand_id'] > 0) {
            $brand_id = $_POST['brand_id'];
            $this->views->update = $this->ajax_update($brand_id);
        }

        $this->views->setPageTitle("Quản lý thương hiệu");
        $this->views->render("admin/products_brand/index");
    }

    /**
     * EDIT PAGE: /admin.php?c=brand&m=edit&p=$brand_id
     *
     * @param $brand_id
     * @throws \Exception
     */
    public function edit($brand_id)
    {
        $this->views->setPageTitle("Update Thông tin Thương Hiệu");

        $brand_model = new models\Brand();
        $brand = $brand_model->select($brand_id);

        if ($brand != null) {
            $this->views->brand = $brand;
            $this->views->render("admin/products_brand/edit");
        } else {
            throw new \Exception("404 Page");
        }
    }

    /**
     * DELETE PAGE /admin.php?c=brand&m=delete&id=$brand_id
     *
     * @param $brand_id
     */
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
        $this->views->render("admin/products_brand/list");
    }

    /**
     * Insert new Brand
     */
    public function ajax_add()
    {
        $result = -1;
        if (isset($_POST['brand_name']) && $_POST['brand_name'] != "") {

            $brand = new models\Brand();
            $brand->setBrandName($_POST['brand_name']);
            $brand->setBrandSlug($_POST['brand_slug'], true);
            $brand->setBrandContent($_POST['brand_content']);
            $brand->setBrandSeoTitle($_POST['brand_seo_title']);
            $brand->setBrandSeoDescription($_POST['brand_seo_description']);


            if ($brand->insert()) {
                $result = $brand->insert_id;
            }
        }
        echo $result;
    }

    /**
     * Update Brand
     *
     * @param $brand_id
     * @return int 0 = error | 1 = update success
     */
    public function ajax_update($brand_id)
    {
        $result = 0;
        if (isset($_POST['brand_name']) && $_POST['brand_name'] != "") {

            $brand = new models\Brand();
            $brand->setBrandId($brand_id);
            $brand->setBrandName($_POST['brand_name']);
            $brand->setBrandSlug($_POST['brand_slug'], true);
            $brand->setBrandContent($_POST['brand_content']);
            $brand->setBrandSeoTitle($_POST['brand_seo_title']);
            $brand->setBrandSeoDescription($_POST['brand_seo_description']);

            if ($brand->update()) {
                $result = 1; // Update ok
            }
        }
        return $result;
    }

    /**
     * Check brand_name when update
     */
    public function ajax_check_brand_name()
    {
        $result = "false"; // can't use that brand name
        if (isset($_POST['brand_name'])) {
            $brand = new models\Brand();
            $brand->setBrandName($_POST['brand_name']);
            if (isset($_POST['brand_id'])) {
                $brand->setBrandId($_POST['brand_id']);
                $brand = $brand->selectByNameDiffID();
            } else {
                $brand = $brand->selectByName();
            }

            if (count($brand) < 1) {
                $result = "true"; // Brand name exist in database
            }
        }
        echo $result;
    }
}