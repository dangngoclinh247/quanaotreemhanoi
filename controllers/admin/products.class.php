<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/26/2015
 * Time: 1:44 PM
 */

namespace controllers\admin;

use base;
use library;
use models;

class products extends base\Controllers
{
    public function __construct()
    {
        parent::__construct();

        // add summernote css for app
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    public function index()
    {
        echo "products -> index";
    }

    public function tag()
    {
        $this->views->render("admin/products/tag");
    }

    public function tag_add()
    {
        $this->views->render("admin/products/tag_add");
    }

    public function tag_insert()
    {
        $result = array(
            "status" => 0,
            "message" => "What do you want?"
        );

        if (isset($_POST['ptag_add']) && $_POST['ptag_add'] == "ok") {
            $data = array(
                "ptag_name" => $_POST['ptag_name'],
                "ptag_slug" => trim($_POST['ptag_slug']),
                "ptag_seo_title" => $_POST['ptag_seo_title'],
                "ptag_seo_description" => $_POST['ptag_seo_description'],
                "ptag_add_date" => date("Y-m-d H:i:s"),
                "ptag_content" => $_POST['ptag_content']
            );

            if ($data['ptag_slug'] == "") {
                $data['ptag_slug'] = library\Func::getSlug(trim($data['ptag_name']));
            } else {
                $data['ptag_slug'] = library\Func::getSlug(trim($data['ptag_slug']));
            }
            if ($data['ptag_seo_title'] == "") {
                $data['ptag_seo_title'] = null;
            }
            if ($data['ptag_seo_description'] == "") {
                $data['ptag_seo_description'] = null;
            }
            if (strip_tags($data['ptag_content']) == "") {
                $data['ptag_content'] = null;
            }

            $ptag_model = new models\Ptag();
            $result_insert = $ptag_model->insert($data);
            if ($result_insert == true) {
                $result = array(
                    "status" => "1",
                    "message" => library\Func::getAlert("Da Them Category Thanh Cong")
                );
            } else {
                $result['message'] = $result_insert;
            }
        }
        echo json_encode($result);
    }

    public function tag_list($ptag_id = -1)
    {
        // Get all ptag
        $ptag_model = new models\Ptag();
        $this->views->ptags = $ptag_model->selectAll();
        $this->views->ptag_id_highlight = $ptag_id;

        $this->views->render("admin/products/tag_list");
    }

    public function type()
    {
        echo "product -> type";
    }
}