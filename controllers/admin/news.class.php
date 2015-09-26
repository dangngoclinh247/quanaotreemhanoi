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

        // add summernote to page
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    public function ntype()
    {
        $this->views->setPageTitle("Quản lý Category Tin Tức");
        // add category
        $this->ntype_insert();

        $this->views->render("admin/news/ntype");
    }

    public function ntype_list($id = -1)
    {
        // Get all ntype
        $ntype_model = new models\Ntype();
        $this->views->ntypes = $ntype_model->selectAll();
        $this->views->ntype_id_highlight = $id;

        $this->views->render("admin/news/ntype_list");
    }

    public function ntype_del()
    {
        if (isset($_POST['ntype_id']) && $_POST['ntype_id'] > 0) {

            $ntype_id = $_POST['ntype_id'];

            // check ntype id exist
            $ntype_model = new models\Ntype();
            $result = $ntype_model->select($ntype_id);
            if ($result != false) {
                if ($ntype_model->delete($ntype_id) == true) {
                    $data['status'] = "1";
                } else {
                    $data = array(
                        "status" => 0,
                        "news_type" => "Khong The Xoa?"
                    );
                }
            } else {
                $data['status'] = "0";
                $data['news_type'] = "Ton Tai News Category Nay";
            }
        } else {
            $data = array(
                "status" => 0,
                "news_type" => "What do you want!?"
            );
        }

        echo json_encode($data);
    }

    public function ntype_insert()
    {
        if (isset($_POST['ntype_add']) && $_POST['ntype_add'] == "ok") {
            $data = array(
                "ntype_name" => $_POST['ntype_name'],
                "ntype_slug" => $_POST['ntype_slug'],
                "ntype_seo_title" => $_POST['ntype_seo_title'],
                "ntype_seo_description" => $_POST['ntype_seo_description'],
                "ntype_add_date" => date("Y-m-d H:i:s"),
                "ntype_parent_id" => $_POST['ntype_parent_id'],
                "ntype_content" => $_POST['ntype_content']
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
            if (strip_tags($data['ntype_content']) == "") {
                $data['ntype_content'] = null;
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

    public function ntype_add()
    {
        // Get all ntype
        $ntype_model = new models\Ntype();
        $this->views->ntypes = $ntype_model->selectAll();
        $this->views->render("admin/news/ntype_add");
    }

    public function ntype_edit($id)
    {
        $ntype_model = new models\Ntype();
        $this->views->ntype = $ntype_model->select($id);

        if ($this->views->ntype == false) {
            exit("0");

        } else {
            $this->views->ntypes = $ntype_model->selectAll();
            $this->views->render("admin/news/ntype_edit");
        }
    }

    public function ntype_update($id)
    {
        $ntype_model = new models\Ntype();
        $this->views->ntype = $ntype_model->select($id);

        $result = array(
            "status" => 0,
            "message" => "Loi"
        );
        if ($this->views->ntype == false) {
            $result['message'] = "Category Tin Tuc Nay Da Bi Xoa";

        } else {
            $data = array(
                "ntype_name" => $_POST['ntype_name'],
                "ntype_slug" => $_POST['ntype_slug'],
                "ntype_seo_title" => $_POST['ntype_seo_title'],
                "ntype_seo_description" => $_POST['ntype_seo_description'],
                "ntype_parent_id" => $_POST['ntype_parent_id'],
                "ntype_content" => $_POST['ntype_content']
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
            if (strip_tags($data['ntype_content']) == "") {
                $data['ntype_content'] = null;
            }

            $ntype_model = new models\Ntype();
            $result_del = $ntype_model->update($data, $id);
            if ($result_del == true) {
                $result['status'] = "1";
                $result['message'] = Func::getAlert("Update Thanh Cong");
            }
        }
        echo json_encode($result);
    }
}