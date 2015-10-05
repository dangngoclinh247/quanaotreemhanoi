<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/26/2015
 * Time: 1:44 PM
 */

namespace controllers\admin;

use library;
use models;

class products extends Admin_Controllers
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

    public function products_add()
    {
        $this->views->setPageTitle("Thêm sản phẩm");

        // Get list products_type
        $prot_model = new models\Prot();
        $this->views->prots = $this->type_sort($prot_model->selectAll());

        // show form products_add
        $this->views->render("admin/products/products_add");
    }

    public function ajax_products_add()
    {
        $result = -1;
        if(isset($_POST['pro_add']) && $_POST['pro_add'] == "ok") {
            $data = array(
                "id" => null,
                "pro_name" => null,
                "pro_slug" => null,
                "pro_content" => null,
                "pro_size" => null,
                "pro_size_info" => null,
                "pro_price" => null,
                "pro_quantity" => null,
                "pro_seo_title" => null,
                "pro_seo_description" => null,
                "pro_status" => 0,
                "user_id" => null,
            );

            if (isset($_POST['pro_id']) && $_POST['pro_id'] != "") {
                $data['id'] = $_POST['pro_id'];
            }

            if (isset($_POST['pro_name']) && $_POST['pro_name'] != "") {
                $data['pro_name'] = $_POST['pro_name'];
            }

            if (isset($_POST['pro_slug']) && $_POST['pro_slug'] != "") {
                $data['pro_slug'] = $_POST['pro_slug'];
            }

            if (isset($_POST['pro_content']) && $_POST['pro_content'] != "") {
                $data['pro_content'] = $_POST['pro_content'];
            }

            if (isset($_POST['pro_size']) && $_POST['pro_size'] != "") {
                $data['pro_size'] = $_POST['pro_size'];
            }

            if (isset($_POST['pro_size_info']) && $_POST['pro_size_info'] != "") {
                $data['pro_size_info'] = $_POST['pro_size_info'];
            }

            if (isset($_POST['pro_quantity']) && $_POST['pro_quantity'] != "") {
                $data['pro_quantity'] = $_POST['pro_quantity'];
            }

            if (isset($_POST['pro_seo_title']) && $_POST['pro_seo_title'] != "") {
                $data['pro_seo_title'] = $_POST['pro_seo_title'];
            }

            if (isset($_POST['pro_seo_description']) && $_POST['pro_seo_description'] != "") {
                $data['pro_seo_description'] = $_POST['pro_seo_description'];
            }

            if (isset($_POST['pro_status']) && $_POST['pro_status'] != "") {
                $data['pro_status'] = $_POST['pro_status'];
            }

            if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") {
                $data['user_id'] = $_SESSION['user_id'];
            }

            //print_r($data);

            $products_model = new models\Products();
            if($products_model->insert($data))
            {
                $result = $products_model->insert_id;
            }
        }
        echo $result;
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
        // Get all ptag
        $prot_model = new models\Prot();
        $this->views->prots = $this->type_sort($prot_model->selectAll());
        $this->views->prot_id_highlight = $prot_id;

        $this->views->render("admin/products/type_list");
    }

    public function type_edit($prot_id)
    {
        // Get all ptag
        $prot_model = new models\Prot();
        $this->views->prots = $this->type_sort($prot_model->selectAll());
        $this->views->prot = $prot_model->select($prot_id);
        if ($this->views->prot == false) {
            echo "0";
        } else {
            $this->views->render("admin/products/type_edit");
        }
    }

    public function type_update($prot_id)
    {
        $prot_model = new models\Prot();
        $this->views->prot = $prot_model->select($prot_id);

        $result = array(
            "status" => 0,
            "message" => "Loi"
        );
        if ($this->views->prot == false) {
            $result['message'] = "Product Tag Nay Da Bi Xoa";

        } else {
            $data = array(
                "prot_name" => $_POST['prot_name'],
                "prot_slug" => $_POST['prot_slug'],
                "prot_seo_title" => $_POST['prot_seo_title'],
                "prot_seo_description" => $_POST['prot_seo_description'],
                "prot_parent_id" => $_POST['prot_parent_id'],
                "prot_content" => $_POST['prot_content']
            );

            $data['prot_slug'] = library\Func::getSlug(trim($data['prot_slug']));

            if ($data['prot_slug'] == "") {
                $data['prot_slug'] = library\Func::getSlug(trim($data['prot_name']));
            }
            if ($data['prot_seo_title'] == "") {
                $data['prot_seo_title'] = null;
            }
            if ($data['prot_seo_description'] == "") {
                $data['prot_seo_description'] = null;
            }
            if ($data['prot_parent_id'] == "") {
                $data['prot_parent_id'] = null;
            }
            if (strip_tags($data['prot_content']) == "") {
                $data['prot_content'] = null;
            }

            $prot_model = new models\Prot();
            $result_del = $prot_model->update($data, $prot_id);
            if ($result_del == true) {
                $result['status'] = "1";
                $result['message'] = library\Func::getAlert("Update Thanh Cong");
            }
        }
        echo json_encode($result);
    }


    public function type_del($prot_id)
    {
        $result = "0";
        $prot_model = new models\Prot();
        if ($prot_model->select($prot_id) != false) // tồn tại
        {
            if ($prot_model->delete($prot_id) == true) {
                $result = "1";
            }
        }
        echo $result;
    }

    public function type_add()
    {
        // Get all prot
        $prot_modal = new models\Prot();
        $this->views->prots = $this->type_sort($prot_modal->selectAll());
        $this->views->render("admin/products/type_add");
    }

    public function type_insert()
    {

        $data = array(
            "prot_name" => $_POST['prot_name'],
            "prot_slug" => $_POST['prot_slug'],
            "prot_seo_title" => $_POST['prot_seo_title'],
            "prot_seo_description" => $_POST['prot_seo_description'],
            "prot_add_date" => date("Y-m-d H:i:s"),
            "prot_parent_id" => $_POST['prot_parent_id'],
            "prot_content" => $_POST['prot_content']
        );

        $data['prot_slug'] = library\Func::getSlug(trim($data['prot_slug']));

        if ($data['prot_slug'] == "") {
            $data['prot_slug'] = library\Func::getSlug(trim($data['prot_name']));
        }
        if ($data['prot_seo_title'] == "") {
            $data['prot_seo_title'] = null;
        }
        if ($data['prot_seo_description'] == "") {
            $data['prot_seo_description'] = null;
        }
        if ($data['prot_parent_id'] == "") {
            $data['prot_parent_id'] = null;
        }
        if (strip_tags($data['prot_content']) == "") {
            $data['prot_content'] = null;
        }

        $prot_model = new models\Prot();
        $result = $prot_model->insert($data);
        if ($result == true) {
            exit(json_encode(array(
                "status" => "1",
                "message" => library\Func::getAlert("Da Them Category Thanh Cong"),
                "prot_id" => $prot_model->insert_id
            )));
        } else {
            exit(json_encode(array(
                "status" => "0",
                "message" => "Error:" . $result
            )));
        }
    }

    /**
     *  Sort products all type to list
     */
    public function type_sort($prots, $prot_parent_id = null)
    {
        $result = array();
        foreach ($prots as $key => $prot) {
            if ($prot['prot_parent_id'] == $prot_parent_id) {
                unset($prots[$key]);
                $prot['submenu'] = $this->type_sort($prots, $prot['prot_id']);
                $result[] = $prot;
            }
        }
        return $result;
    }
}