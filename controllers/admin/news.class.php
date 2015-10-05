<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/25/2015
 * Time: 12:33 PM
 */

namespace controllers\admin;

use library\Func;
use library\Upload;
use models;

class news extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();

        // add summernote to page
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    /**
     * Page: news->index
     */
    public function index()
    {
        $news_model = new models\News();
        $news = $news_model->selectall_admin_index();

        $this->views->news = $this->sort_news_index($news);
        /*echo "<pre>";
        var_dump($this->views->news);
        echo "</pre>";
        exit;*/

        $this->views->render("admin/news/news");
    }

    /**
     * function sort news for page index
     *
     * @param $news
     * @return mixed
     */
    public function sort_news_index($news)
    {
        $count_news = count($news);
        for ($i = 0; $i < $count_news; $i++) {
            if (isset($news[$i]['ntype_id']) && $news[$i]['ntype_id'] != null) {
                $type = array();
                $type[] = array(
                    "ntype_id" => $news[$i]['ntype_id'],
                    "ntype_name" => $news[$i]['ntype_name'],
                    "ntype_slug" => $news[$i]['ntype_slug'],
                    "ntype_content" => $news[$i]['ntype_content'],
                    "ntype_seo_title" => $news[$i]['ntype_seo_title'],
                    "ntype_seo_description" => $news[$i]['ntype_seo_description'],
                );
                for ($j = $i + 1; $j < $count_news; $j++) {
                    if ($news[$j]['news_id'] != $news[$i]['news_id']) {
                        break 1;
                    } else {
                        $type[] = array(
                            "ntype_id" => $news[$j]['ntype_id'],
                            "ntype_name" => $news[$j]['ntype_name'],
                            "ntype_slug" => $news[$j]['ntype_slug'],
                            "ntype_content" => $news[$j]['ntype_content'],
                            "ntype_seo_title" => $news[$j]['ntype_seo_title'],
                            "ntype_seo_description" => $news[$j]['ntype_seo_description'],
                        );
                        unset($news[$j]);
                    }
                }
                $news[$i]['type'] = $type;
            }
        }
        /*echo "<pre>";
        print_r($news);
        echo "</pre>";
        exit;*/
        return $news;
    }

    /**
     *
     * Page news->news_edit->$news_id
     *
     * @param $news_id
     */
    public function news_edit($news_id)
    {
        $news_model = new models\News();
        $this->views->new = $news_model->select($news_id);
        if ($this->views->new != false) {
            // set page
            $this->views->setPageTitle("Update tin tức");

            // add select 2 for tagging
            $this->views->addHeader('<link href="/templates/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />');

            $ntype_model = new models\Ntype();
            $this->views->ntypes = $this->ntype_sort($ntype_model->selectAll());

            $ntype_id_list = $ntype_model->selectNTypeIdByNewsId($news_id);
            $this->views->ntypes_of_news = array();
            foreach ($ntype_id_list as $ntype) {
                $this->views->ntypes_of_news[] = $ntype['ntype_id'];
            }
            /*            echo "<pre>";
                        print_r($this->views->ntypes_of_news);
                        echo "</pre>";*/

            $this->views->render("admin/news/news_edit");
        }
    }

    /**
     * Page: News->News_Add
     */
    public function news_add()
    {
        // set page
        $this->views->setPageTitle("Thêm tin mới");

        // add select 2 for tagging
        $this->views->addHeader('<link href="/templates/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />');

        $ntype_model = new models\Ntype();
        $this->views->ntypes = $this->ntype_sort($ntype_model->selectAll());


        $this->views->render("admin/news/news_add");
    }

    /**
     *
     * Upload file for news
     *
     * @param $news_id
     *
     */
    public function news_add_upload($news_id = -1)
    {
        // Upload ảnh
        $upload_image = new Upload($_FILES['file']);
        $upload_image->setPath("/upload/2015/09");
        $upload_image->send();
        $result = array(
            "url" => "http://quanaotreemhanoi.dev" . $upload_image->getResult(),
            "id" => $news_id
        );

        if ($news_id == -1) {
            $data["user_id"] = 11;
            $data['nstatus_id'] = 3;
            $news_model = new models\News();
            $news_id = $news_model->insert_null($data);

            $result['id'] = $news_id;
        }

        $images_model = new models\Images();
        $images = array(
            "img_url" => $upload_image->getResult(),
            "img_alt" => pathinfo($upload_image->getResult(), PATHINFO_FILENAME),
            "img_description" => null
        );
        $images_model->insert_news($images, $news_id);

        echo json_encode($result);
    }

    /**
     * ajax update news row
     *
     * @param $news_id
     */
    public function news_update($news_id)
    {
        $result = -1;
        $data = array();

        if (isset($_POST['news_name']) && $_POST['news_name'] != "") {
            $data['news_name'] = $_POST['news_name'];
        } else {
            $data['news_name'] = null;
        }

        if (isset($_POST['news_slug']) && $_POST['news_slug'] != "") {
            $data['news_slug'] = Func::getSlug($_POST['news_slug']);
        } else if ($data['news_name'] != null) {
            $data['news_slug'] = Func::getSlug($_POST['news_snews_namelug']);
        } else {
            $data['news_slug'] = null;
        }

        if (isset($_POST['news_content']) && $_POST['news_content'] != "") {
            $data['news_content'] = $_POST['news_content'];
        } else {
            $data['news_content'] = null;
        }
        if (isset($_POST['news_seo_title']) && $_POST['news_seo_title'] != "") {
            $data['news_seo_title'] = $_POST['news_seo_title'];
        } else {
            $data['news_seo_title'] = null;
        }

        if (isset($_POST['news_seo_description']) && $_POST['news_seo_description'] != "") {
            $data['news_seo_description'] = $_POST['news_seo_description'];
        } else {
            $data['news_seo_description'] = null;
        }

        if (isset($_POST['nstatus_id']) && $_POST['nstatus_id'] != "") {
            $data['nstatus_id'] = $_POST['nstatus_id'];
        } else {
            $data['nstatus_id'] = 3;
        }

        if (isset($_POST['news_publish_date']) && $_POST['news_publish_date'] != "") {
            $datetime = \DateTime::createFromFormat("m/d/Y H:i A", $_POST['news_publish_date']);
            $data['news_publish_date'] = $datetime->format("Y-m-d H:i:s");
        } else {
            $data['news_publish_date'] = null;
        }

        $data['user_id'] = 11;

        $news_model = new models\News();
        if ($news_model->update($data, $news_id)) {

            if (isset($_POST['ntype_id']) && count($_POST['ntype_id']) > 0) {

                // update news_type_details
                $type_detail = $_POST['ntype_id']; // arrray
                $type_detail_old = $news_model->select_news_type($news_id);
                $type_detail_insert = array();
                $type_detail_delete = array();

                foreach ($type_detail_old as $value) {
                    if (!in_array($value, $type_detail)) {
                        $type_detail_delete[] = $value;
                    }
                }

                foreach ($type_detail as $value) {
                    if (!in_array($value, $type_detail_old)) {
                        $type_detail_insert[] = $value;
                    }
                }

                if (count($type_detail_insert) > 0) {
                    $news_model->insert_news_type_detail($type_detail_insert, $news_id);
                }

                if (count($type_detail_delete) > 0) {
                    $news_model->delete_news_type_detail($type_detail_delete, $news_id);
                }
            } else {
                $news_model->delete_news_type_detail_all($news_id);
            }
            $result = 1;
        }
        echo $result;

    }

    /**
     * panel for info images
     */
    public function news_image_panel()
    {
        if (isset($_POST['news_id']) && isset($_POST['img_id'])) {

            $news_id = $_POST['news_id'];
            $img_id = $_POST['img_id'];

            $images_model = new models\Images();
            $this->views->image = $images_model->selectNews($news_id, $img_id);
            $this->views->render("admin/news/news_image_panel");
        }
    }

    /**
     * ajax process set Images news featured = 1
     */
    public function news_image_set_featured()
    {
        $result = "0";
        if (isset($_POST['news_id']) && isset($_POST['img_id'])) {

            $news_id = $_POST['news_id'];
            $img_id = $_POST['img_id'];

            $images_model = new models\Images();
            $result = $images_model->setImageNewsFeatured($news_id, $img_id);
        }
        //echo $news_id . "-" . $img_id;
        echo $result;
    }

    public function load_image_featured($news_id)
    {
        $images_model = new models\News();
        $image = $images_model->getImageFeatured($news_id);
        if (count($image) > 0) {
            $this->views->image = $image;
            $this->views->render("admin/news/news_image_featured");
        }
    }

    /**
     * Ajax precess insert news row for Page news->news_add
     */
    public function news_insert()
    {
        $result = -1;
        $data = array();

        if (isset($_POST['news_name']) && $_POST['news_name'] != "") {
            $data['news_name'] = $_POST['news_name'];
        } else {
            $data['news_name'] = null;
        }

        if (isset($_POST['news_slug']) && $_POST['news_slug'] != "") {
            $data['news_slug'] = Func::getSlug($_POST['news_slug']);
        } else if ($data['news_name'] != null) {
            $data['news_slug'] = Func::getSlug($_POST['news_snews_namelug']);
        } else {
            $data['news_slug'] = null;
        }

        if (isset($_POST['news_content']) && $_POST['news_content'] != "") {
            $data['news_content'] = $_POST['news_content'];
        } else {
            $data['news_content'] = null;
        }
        if (isset($_POST['news_seo_title']) && $_POST['news_seo_title'] != "") {
            $data['news_seo_title'] = $_POST['news_seo_title'];
        } else {
            $data['news_seo_title'] = null;
        }

        if (isset($_POST['news_seo_description']) && $_POST['news_seo_description'] != "") {
            $data['news_seo_description'] = $_POST['news_seo_description'];
        } else {
            $data['news_seo_description'] = null;
        }

        if (isset($_POST['nstatus_id']) && ($_POST['nstatus_id'] != "" && in_array($_POST['nstatus_id'], array(1, 2, 3)))) {
            $data['nstatus_id'] = $_POST['nstatus_id'];
        } else {
            $data['nstatus_id'] = 3;
        }

        if (isset($_POST['news_publish_date']) && $_POST['news_publish_date'] != "") {
            $data['news_publish_date'] = date("Y-m-d H:i:s", strtotime($_POST['news_publish_date']));
        } else {
            $data['news_publish_date'] = null;
        }

        $data['user_id'] = 11;

        $news_model = new models\News();
        if ($news_model->insert($data)) {
            $news_id = $news_model->insert_id;

            if (isset($_POST['ntype_id']) && count($_POST['ntype_id']) > 0) {
                $type_detail = $_POST['ntype_id'];

                if (count($type_detail) > 0) {
                    $news_model->insert_news_type_detail($type_detail, $news_id);
                }
            }
            $result = $news_id;
        }
        echo $result;
    }

    public function news_panel_images($news_id)
    {
        $images_model = new models\Images();
        $this->views->images = $images_model->selectAllNews($news_id);
        $this->views->render("admin/news/news_panel_images");
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

    public function ntype_sort($ntypes, $ntype_parent_id = null)
    {
        $result = array();
        foreach ($ntypes as $key => $ntype) {
            if ($ntype['ntype_parent_id'] == $ntype_parent_id) {
                unset($ntypes[$key]);
                $ntype['submenu'] = $this->ntype_sort($ntypes, $ntype['ntype_id']);
                $result[] = $ntype;
            }
        }
        return $result;
    }
}