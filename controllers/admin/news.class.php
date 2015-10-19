<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/25/2015
 * Time: 12:33 PM
 */

namespace controllers\admin;

use library\Func;
use library\Pagination;
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
     * @param $page = 1
     */
    public function index($page = 1)
    {
        $news_model = new models\News();

        $totalItem = $news_model->select_admin_index_count();
        echo $totalItem;
        $stop = 10; // item per page
        $start = ($page - 1) * $stop;
        $totalPage = ceil($totalItem / $stop);

        $pagination = new Pagination();
        $pagination->setCurrentPage($page);
        $pagination->setTotalPage($totalPage);
        $pagination->setUrl("/admin.php?c=news&m=index&p={page}");
        $this->views->pagination = $pagination;
        $news = $news_model->select_admin_index($start, $stop);
        /*        echo "<pre>";
                print_r($news);
                var_dump($pagination);
                echo "</pre>";
                exit;*/

        $news = $news_model->select_admin_index($start, $stop);

        $this->views->news = $this->sort_news_index($news);
        $this->views->setPageTitle("Danh sách tin tức");
        $this->views->render("admin/news/index");
    }

    /**
     * Page: News->Add
     */
    public function add()
    {
        if (isset($_POST['btn_news_add'])) {
            echo "<pre>";
            var_dump($_POST);
            echo "</pre>";
            exit;
        }

        // set page
        $this->views->setPageTitle("Thêm tin mới");

        // add select 2 for tagging
        $this->views->addHeader('<link href="/templates/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />');

        $ntype_model = new models\Ntype();
        $this->views->ntypes = $this->ntype_sort($ntype_model->selectAll());


        $this->views->render("admin/news/add");
    }

    /**
     *
     * Page news->news_edit->$news_id
     *
     * @param $news_id
     */
    public function edit($news_id)
    {
        $news_model = new models\News();
        $news_model->setNewsId($news_id);
        $news = $news_model->select();
        //print_r($news);
        if ($news != false) {

            $this->views->news = $news;
            // set page
            $this->views->setPageTitle("Update tin tức");

            // add select 2 for tagging
            $this->views->addHeader('<link href="/templates/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />');

            $ntype_model = new models\Ntype();
            $this->views->ntypes = $this->ntype_sort($ntype_model->selectAll());

            $news_type_details = new models\News_Type_Details();
            $news_type_details->setNewsId($news_id);
            $ntype_id_list = $news_type_details->select_news_type();

            //print_r($ntype_id_list);
            //exit;

            $this->views->ntypes_of_news = array();
            foreach ($ntype_id_list as $ntype) {
                $this->views->ntypes_of_news[] = $ntype['ntype_id'];
            }

            $images = new models\Images();
            $images->setNewsId($news_id);
            $this->views->image = $images->selectNewsFeatured();

            //print_r($this->views->image);
            //exit;
            $this->views->render("admin/news/edit");
        }
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
        return $news;
    }


    /**
     *
     * Upload file for news
     *
     * @param $news_id
     *
     */
    public function upload($news_id = -1)
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
            $news = new models\News();
            $news->setUserId($_SESSION['user_id']);

            if ($news->insert()) {
                $news_id = $news->insert_id;
                $result['id'] = $news_id;
            }
        }

        $image = new models\Images();
        $image->setNewsId($news_id);
        $image->setImgUrl($upload_image->getResult());
        $image->setImgAlt(pathinfo($upload_image->getResult(), PATHINFO_FILENAME));
        $image->insert();

        if (isset($_POST['featured'])) {
            $image->setImgId($image->insert_id);
            $image->resetNewsFeatured();
            $image->featured();
        }

        echo json_encode($result);
    }

    /**
     * ajax update news row
     *
     * @param $news_id
     */
    public function update($news_id)
    {
        $result = -1;

        $news = new models\News();
        $news->setNewsId($news_id);
        $news->setNewsName($_POST['news_name']);

        if (isset($_POST['news_slug']) && $_POST['news_slug'] != "") {
            $news_slug = Func::getSlug($_POST['news_slug']);
        } else {
            $news_slug = Func::getSlug($news->getNewsName());
        }

        $news->setNewsSlug($news_slug);
        $news->setNewsContent($_POST['news_content']);
        $news->setNewsSeoTitle($_POST['news_seo_title']);
        $news->setNewsSeoDescription($_POST['news_seo_description']);
        if (isset($_POST['news_publish_date']) && $_POST['news_publish_date'] != "") {
            $news->setNewsPublishDate($_POST['news_publish_date']);
        }
        $news->setStatus($_POST['status']);
        $news->setUserId($_SESSION['user_id']);

        // insert
        if ($news->update()) { //insert success

            $news_type_details = new models\News_Type_Details();
            $news_type_details->setNewsId($news->getNewsId());

            if (isset($_POST['ntype_id']) && count($_POST['ntype_id']) > 0) { // have checkbox ntype_id

                $type_detail = $_POST['ntype_id']; // arrray

                $news_type_details->deleteAllType();
                $news_type_details->insert_multi_type($type_detail);

            } else { // dont have checkbox
                //echo "lamdang";
                $news_type_details->deleteAllType();
            }
            $result = 1;
        }
        echo $result;

    }

    /**
     * @param $news_id
     */
    public function images_panel($news_id)
    {
        $images_model = new models\Images();
        $images_model->setNewsId($news_id);
        $image = $images_model->selectAllNews();
        if (count($image) > 0) {
            $this->views->images = $image;
            $this->views->render("admin/news/images_panel");
        }
    }

    /**
     * Show panel image featured
     *
     * @param $news_id
     */
    public function image_featured_panel($news_id)
    {
        $images_model = new models\Images();
        $images_model->setNewsId($news_id);
        $image = $images_model->selectAllNews(true);
        $this->views->image = $image;
        $this->views->render("admin/news/image_featured");
    }

    /**
     * ajax process set Images news featured = 1
     */
    public function image_set_featured($img_id)
    {
        $result = 0;
        $images_model = new models\Images();
        $images_model->setImgId($img_id);
        $image = $images_model->select();

        $images_model->setNewsId($image['news_id']);

        if ($images_model->resetNewsFeatured()) {
            if ($images_model->featured()) {
                $result = 1;
            }
        }
        echo $result;
    }


    /**
     * Ajax precess insert news row for Page news->news_add
     */
    public function insert()
    {
        $result = -1;

        $news = new models\News();
        $news->setNewsName($_POST['news_name']);

        if (isset($_POST['news_slug']) && $_POST['news_slug'] != "") {
            $news_slug = Func::getSlug($_POST['news_slug']);
        } else {
            $news_slug = Func::getSlug($news->getNewsName());
        }

        $news->setNewsSlug($news_slug);
        $news->setNewsContent($_POST['news_content']);
        $news->setNewsSeoTitle($_POST['news_seo_title']);
        $news->setNewsSeoDescription($_POST['news_seo_description']);
        if (isset($_POST['news_publish_date']) && $_POST['news_publish_date'] != "") {
            $news->setNewsPublishDate($_POST['news_publish_date']);
        }
        $news->setStatus($_POST['status']);
        $news->setUserId($_SESSION['user_id']);

        // insert
        if ($news->insert()) { //insert success

            $news->setNewsId($news->insert_id);
            $news_type_details = new models\News_Type_Details();
            $news_type_details->setNewsId($news->getNewsId());

            if (isset($_POST['ntype_id']) && count($_POST['ntype_id']) > 0) { // have checkbox ntype_id

                $type_detail = $_POST['ntype_id']; // arrray
                if (count($type_detail) > 0) {
                    $news_type_details->insert_multi_type($type_detail);
                }
            }
            $result = $news->getNewsId();
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