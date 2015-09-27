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

    public function tag_edit($ptag_id)
    {
        // Get all ptag
        $ptag_model = new models\Ptag();
        $this->views->ptag = $ptag_model->select($ptag_id);
        if ($this->views->ptag == false) {
            echo "0";
        } else {
            $this->views->render("admin/products/tag_edit");
        }
    }

    public function tag_update($ptag_id)
    {
        $ptag_model = new models\Ptag();
        $this->views->ptag = $ptag_model->select($ptag_id);

        $result = array(
            "status" => 0,
            "message" => "Loi"
        );
        if ($this->views->ptag == false) {
            $result['message'] = "Products Tag Nay Da Bi Xoa";
        } else {
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

            if ($ptag_model->update($data, $ptag_id) == true) {
                $result['status'] = "1";
                $result['message'] = library\Func::getAlert("Update Thanh Cong");
            }
        }
        echo json_encode($result);
    }


    public function tag_del()
    {
        $result = "0";
        if (isset($_POST['ptag_id'])) {
            $ptag_id = $_POST['ptag_id'];
            $ptag_model = new models\Ptag();
            if ($ptag_model->select($ptag_id) != false) // tồn tại
            {
                if ($ptag_model->delete($ptag_id) == true) {
                    $result = "1";
                }
            }
        }
        echo $result;
    }

    public function type()
    {
        $this->views->render("admin/products/type");
    }

    public function type_list($prot_id = -1)
    {

    }

    public function type_edit($prot_id)
    {

    }

    public function type_update($prot_id)
    {

    }

    public function type_del($prot_id)
    {

    }

    public function type_add()
    {
        // Get all ntype
        $prot_modal = new models\Ptag();
        $this->views->prots = $prot_modal->selectAll();
        $this->views->render("admin/products/type_add");
    }

    public function type_insert()
    {

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