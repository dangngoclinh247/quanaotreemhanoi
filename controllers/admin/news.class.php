<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/25/2015
 * Time: 12:33 PM
 */

namespace controllers\admin;

use base\Controllers;
use library\Func;
use models;

class news extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // add category
        $this->add();

        // Get all ntype
        $ntype_model = new models\Ntype();
        $this->views->ntypes = $ntype_model->selectAll();

        $this->views->render("admin/news/index");
    }

    public function add()
    {
        if (isset($_POST['ntype_add']) && $_POST['ntype_add'] == "ok") {
            $data = array(
                "ntype_name" => $_POST['ntype_name'],
                "ntype_slug" => $_POST['ntype_slug'],
                "ntype_seo_title" => $_POST['ntype_seo_title'],
                "ntype_seo_description" => $_POST['ntype_seo_description'],
                "ntype_add_date" => date("Y-m-d H:i:s"),
                "ntype_parent_id" => $_POST['ntype_parent_id']
            );
            $data['ntype_slug'] = Func::getSlug(trim($data['ntype_slug']));
            if ($data['ntype_slug'] == "") {
                $data['ntype_slug'] = Func::getSlug(trim($data['ntype_name']));
            }
            if ($data['ntype_seo_title'] == "") {
                $data['ntype_seo_title'] = null;
            }
            if ($data['ntype_seo_description'] == "") {
                $data['ntype_seo_description'] = null;
            }
            if ($data['ntype_parent_id'] == "") {
                $data['ntype_parent_id'] = null;
            }

            $ntype_model = new models\Ntype();
            $result = $ntype_model->insert($data);
            if ($result == true) {
                exit(json_encode(array(
                    "status" => "1",
                    "message" => Func::getAlert("Da Them Category Thanh Cong")
                )));
            } else {
                exit(json_encode(array(
                    "status" => "0",
                    "message" => "Error:" . $result
                )));
            }
        }
    }
}