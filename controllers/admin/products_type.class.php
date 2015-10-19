<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/12/2015
 * Time: 4:02 PM
 */

namespace controllers\admin;


use library\Alert;
use library\Func;
use models\Prot;

class products_type extends Admin_Controllers
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
        // Get all ptag
        $products_type = new \models\Products_Type();
        if(isset($_POST['btn_products_type_add']))
        {
            $prot_slug = Func::getSlug($_POST['prot_name']);
            if ($_POST['prot_slug'] != "") {
                $prot_slug = Func::getSlug($_POST['prot_slug']);
            }

            $products_type->setProtName($_POST['prot_name']);
            $products_type->setProtSlug($prot_slug);
            $products_type->setProtContent($_POST['prot_content']);
            $products_type->setProtSeoTitle($_POST['prot_seo_title']);
            $products_type->setProtSeoDescription($_POST['prot_seo_description']);
            $products_type->setProtParentId($_POST['prot_parent_id']);
            $message = new Alert();
            if($products_type->insert())
            {
                $message = new Alert();
                $message->setType(Alert::TYPE_SUCCESS);
                $message->setMessage("<strong>Thành công! </strong> Đã thêm Products Category Thành Công");
            }
            else
            {
                $message->setType(Alert::TYPE_WARNING);
                $message->setMessage("<strong>Lỗi! </strong> Không thể insert. " . $products_type->error);
            }
            $this->views->message = $message;
        }
        else if(isset($_POST['btn_products_type_edit']))
        {
            $products_type_slug = Func::getSlug($_POST['prot_name']);
            if ($_POST['prot_slug'] != "") {
                $products_type_slug = Func::getSlug($_POST['prot_slug']);
            }

            $products_type->setProtId($_POST['prot_id']);
            $products_type->setProtName($_POST['prot_name']);
            $products_type->setProtSlug($products_type_slug);
            $products_type->setProtContent($_POST['prot_content']);
            $products_type->setProtSeoTitle($_POST['prot_seo_title']);
            $products_type->setProtSeoDescription($_POST['prot_seo_description']);
            $products_type->setProtParentId($_POST['prot_parent_id']);
            $message = new Alert();
            if($products_type->update())
            {
                $message = new Alert();
                $message->setType(Alert::TYPE_SUCCESS);
                $message->setMessage("<strong>Thành công! </strong> Đã thêm Products Category Thành Công");
            }
            else
            {
                $message->setType(Alert::TYPE_WARNING);
                $message->setMessage("<strong>Lỗi! </strong> Không thể insert. " . $products_type->error);
            }
            $this->views->message = $message;
        }
        $this->views->prots = self::sort($products_type->selectAll());

        $this->views->setPageTitle("Quản lý Products Category");
        $this->views->render("admin/products_type/index");
    }

    public function edit($prot_id)
    {
        $products_type = new \models\Products_Type();
        $products_type->setProtId($prot_id);
        $prot = $products_type->select();
        if (count($prot) > 0) {
            $this->views->prot = $prot;
            $this->views->prots = $this->sort($products_type->selectAll());
            $this->views->setPageTitle("Update Products Category");
            $this->views->render("admin/products_type/edit");
        }
    }

    /**
     * DELETE ROW WHERE $prot_id
     *
     * @param $prot_id
     */
    public function delete($prot_id)
    {
        $result = 0;
        $products_type = new \models\Products_Type();
        $products_type->setProtId($prot_id);
        if($products_type->delete())
        {
            $result = 1;
        }
        echo $result;
    }

    /**
     * @param $prots
     * @param null $prot_parent_id
     * @return array
     */
    public static function sort($prots, $prot_parent_id = null)
    {
        $result = array();
        foreach ($prots as $key => $prot) {
            if ($prot['prot_parent_id'] == $prot_parent_id) {
                unset($prots[$key]);
                $prot['submenu'] = self::sort($prots, $prot['prot_id']);
                $result[] = $prot;
            }
        }
        return $result;
    }
}