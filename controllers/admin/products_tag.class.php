<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/12/2015
 * Time: 1:00 PM
 */

namespace controllers\admin;

use library\Alert;
use library\Func;
use library\Pagination;

class products_tag extends Admin_Controllers
{
    const ITEM_PER_PAGE = 25;

    public function __construct()
    {
        parent::__construct();

        // add summernote css for app
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');
    }

    /**
     * PAGE: admin.php?c=products_tag&m=index
     *
     * @param $currentPage | default 1
     */
    public function index($currentPage = 1)
    {
        $ptag_model = new \models\Products_Tag();
        if (isset($_POST['btn_ptag_add'])) {

            $ptag_slug = Func::getSlug($_POST['ptag_name']);
            if ($_POST['ptag_slug'] != "") {
                $ptag_slug = Func::getSlug($_POST['ptag_slug']);
            }

            $ptag_model->setPtagName($_POST['ptag_name']);
            $ptag_model->setPtagSlug($ptag_slug);
            $ptag_model->setPtagContent($_POST['ptag_content']);
            $ptag_model->setPtagSeoTitle($_POST['ptag_seo_title']);
            $ptag_model->setPtagSeoDescription($_POST['ptag_seo_description']);

            $message = new Alert();
            if ($ptag_model->insert()) {
                $message->setType(Alert::TYPE_SUCCESS);
                $message->setMessage("<strong>Thành công!</strong> Đã thêm Products tag thành công");
            } else {
                $message->setType(Alert::TYPE_WARNING);
                $message->setMessage("<strong>Thất bại!</strong> Không thể thêm tag này");
            }
            $this->views->message = $message;
        } else if (isset($_POST['btn_ptag_edit'])) {
            $ptag_slug = Func::getSlug($_POST['ptag_name']);
            if ($_POST['ptag_slug'] != "") {
                $ptag_slug = Func::getSlug($_POST['ptag_slug']);
            }

            $ptag_model->setPtagId($_POST['ptag_id']);
            $ptag_model->setPtagName($_POST['ptag_name']);
            $ptag_model->setPtagSlug($ptag_slug);
            $ptag_model->setPtagContent($_POST['ptag_content']);
            $ptag_model->setPtagSeoTitle($_POST['ptag_seo_title']);
            $ptag_model->setPtagSeoDescription($_POST['ptag_seo_description']);

            $message = new Alert();
            if ($ptag_model->update()) {
                $message->setType(Alert::TYPE_SUCCESS);
                $message->setMessage("<strong>Thành công!</strong> Đã UPDATE Products tag thành công");
            } else {
                $message->setType(Alert::TYPE_WARNING);
                $message->setMessage("<strong>Thất bại!</strong> Không thể UPDATE Products Tag này");
            }
            $this->views->message = $message;
        }

        // Show item
        $totalItem = $ptag_model->selectAllCount();
        $totalPage = ceil($totalItem / self::ITEM_PER_PAGE);
        $start = ($currentPage - 1) * self::ITEM_PER_PAGE;
        $stop = self::ITEM_PER_PAGE;
        $this->views->ptags = $ptag_model->selectAllLimit($start, $stop);

        // Pagination
        $pagination = new Pagination();
        $pagination->setUrl("/admin.php?c=products_tag&m=index&p={page}");
        $pagination->setCurrentPage($currentPage);
        $pagination->setTotalPage($totalPage);
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý Products TAG");
        $this->views->render("admin/products_tag/index");
    }

    /**
     * PAGE: admin.php?c=products_tag&m=edit&p=$ptag_id
     *
     * @param $ptag_id
     */
    public function edit($ptag_id)
    {
        $ptag_model = new \models\Products_Tag();
        $ptag_model->setPtagId($ptag_id);
        $ptag = $ptag_model->select();
        if (count($ptag) > 0) {

            $this->views->ptag = $ptag;

            // Show item
            $currentPage = 1;
            $totalItem = $ptag_model->selectAllCount();
            $totalPage = ceil($totalItem / self::ITEM_PER_PAGE);
            $start = ($currentPage - 1) * self::ITEM_PER_PAGE;
            $stop = self::ITEM_PER_PAGE;
            $this->views->ptags = $ptag_model->selectAllLimit($start, $stop);

            // Pagination
            $pagination = new Pagination();
            $pagination->setUrl("/admin.php?c=products_tag&m=index&p={page}");
            $pagination->setCurrentPage($currentPage);
            $pagination->setTotalPage($totalPage);
            $this->views->pagination = $pagination;

            $this->views->setPageTitle("Update Products TAG");
            $this->views->render("admin/products_tag/edit");
        }
    }

    /**
     * Delete products_tag WHERE $ptag_id
     *
     * @param $ptag_id
     */
    public function delete($ptag_id)
    {
        $result = 0;
        $ptag_model = new \models\Products_Tag();
        $ptag_model->setPtagId($ptag_id);
        if($ptag_model->delete())
        {
            $result = 1;
        }
        echo $result;
    }

    /**
     * SEARCH products_tag in ptag_name
     *
     * @param $keyword
     * @param $currentPage
     */
    public function search($keyword, $currentPage = 1)
    {
        $ptag_model = new \models\Products_Tag();

        // get products list
        $itemPerPage = 10;
        $start = ($currentPage - 1) * $itemPerPage;
        $stop = $itemPerPage;
        $this->views->ptags = $ptag_model->search($keyword, $start, $stop);
        $totalItem = $ptag_model->searchCount($keyword);
        $totalPage = ceil($totalItem / $itemPerPage);

        // setting pagination
        $pagination = new Pagination();
        $pagination->setTotalPage($totalPage);
        $pagination->setCurrentPage($currentPage);
        $pagination->setUrl("/admin.php?c=products_tag&m=search&p={$keyword}&page={page}");
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý sản phẩm");
        $this->views->render("admin/products_tag/index");
    }

    public function import_data($limit)
    {
        $ptag_name = array("Mua xuan", "Mua ha", "Mua thu", "Mua he");
        $ptag_model = new \models\Products_Tag();
        $n = 0;
        while ($n < $limit) {
            $name = $ptag_name[array_rand($ptag_name, 1)] . " " . rand(100, 1000);
            $ptag_model->setPtagName($name);
            $ptag_model->setPtagSlug(Func::getSlug($name));
            if ($ptag_model->insert()) {
                echo $n . "Thanh Cong<br />";
            } else {
                echo $n . "That Bai<br />";
            }
            if ($limit < 0) {
                $n--;
            } else {
                $n++;
            }
        }
        echo "Lam Dang";
    }
}