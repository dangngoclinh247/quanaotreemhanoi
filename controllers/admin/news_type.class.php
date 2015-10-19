<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/9/2015
 * Time: 9:05 AM
 */

namespace controllers\admin;

use library\Alert;
use library\Func;
use models\News_Type_Details;
use models\Ntype;

class News_Type extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();

        // add summernote to page
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    /**
     * PAGE: /admin.php?c=news_type
     */
    public function index()
    {
        $ntype = new Ntype();
        // Process date when click button add news_type
        if (isset($_POST['btn_ntype_add'])) {
            $ntype_slug = Func::getSlug($_POST['ntype_name']);
            if ($_POST['ntype_slug'] != "") {
                $ntype_slug = Func::getSlug($_POST['ntype_slug']);
            }

            $ntype->setNtypeName($_POST['ntype_name']);
            $ntype->setNtypeSlug($ntype_slug);
            $ntype->setNtypeContent($_POST['ntype_content']);
            $ntype->setNtypeSeoTitle($_POST['ntype_seo_title']);
            $ntype->setNtypeSeoDescription($_POST['ntype_seo_description']);
            $ntype->setNtypeParentId($_POST['ntype_parent_id']);
            $message = new Alert();
            if ($ntype->insert()) {
                $message = new Alert();
                $message->setMessage("<strong>Thành công</strong> Thêm news category thành công");
            } else {
                $message->setType(Alert::TYPE_DANGER);
                $message->setMessage("<strong>Lỗi</strong> Không thêm được news category này");
            }
            $this->views->message = $message;
        }

        $this->views->setPageTitle("Quản lý Category Tin Tức");
        $this->views->ntypes = $this->sortNType($ntype->selectAll());
        $this->views->render("admin/news_type/index");
    }

    public function search($keyword)
    {
        $ntype = new Ntype();
        $this->views->setPageTitle("Quản lý Category Tin Tức");
        $this->views->ntypes = $this->sortNType($ntype->search($keyword, 0, 20));

        $this->views->render("admin/news_type/index");
    }

    public function edit($ntype_id)
    {
        $ntype = new Ntype();
        $this->views->setPageTitle("Update Tin tức Category");

        // Process date when click button add news_type
        if (isset($_POST['btn_ntype_update'])) {
            $ntype_slug = Func::getSlug($_POST['ntype_name']);
            if ($_POST['ntype_slug'] != "") {
                $ntype_slug = Func::getSlug($_POST['ntype_slug']);
            }

            $ntype->setNtypeId($ntype_id);
            $ntype->setNtypeName($_POST['ntype_name']);
            $ntype->setNtypeSlug($ntype_slug);
            $ntype->setNtypeContent($_POST['ntype_content']);
            $ntype->setNtypeSeoTitle($_POST['ntype_seo_title']);
            $ntype->setNtypeSeoDescription($_POST['ntype_seo_description']);
            $ntype->setNtypeParentId($_POST['ntype_parent_id']);
            $message = new Alert();
            if ($ntype->update()) {
                $message = new Alert();
                $message->setMessage("<strong>Thành công</strong> Update category thành công");
            } else {
                $message->setType(Alert::TYPE_DANGER);
                $message->setMessage("<strong>Lỗi</strong> Không thể update");
            }
            $this->views->message = $message;
        }

/*        $ntypes_list = $this->sortNType($ntype->selectAll());
        echo "<pre>";

        print_r($ntypes_list);
        echo "</pre>";
        exit;*/
        $this->views->ntypes = $this->sortNType($ntype->selectAll());

        $this->views->ntype = $ntype->select($ntype_id);
        $this->views->render("admin/news_type/edit");
    }

    public function delete($ntype_id)
    {
        $result = 0;

        $ntype_details = new News_Type_Details();
        $ntype_details->setNtypeId($ntype_id);
        if($ntype_details->delete_news_type())
        {
            $ntype = new Ntype();
            $ntype->setNtypeId($ntype_id);
            if($ntype->delete())
            {
                $result = 1;
            }
        }
        echo $result;
    }

    /**
     * Sort ntype_rows
     *
     * @param $ntypes
     * @param null $ntype_id
     * @return array
     */
    private function sortNType($ntypes, $ntype_id = null)
    {
        $result = array();
        foreach ($ntypes as $key => $ntype) {
            if ($ntype['ntype_parent_id'] == $ntype_id) {
                unset($ntypes[$key]);
                $ntype["submenu"] = $this->sortNType($ntypes, $ntype['ntype_id']);
                $result[] = $ntype;
            }
        }
        return $result;
    }
}