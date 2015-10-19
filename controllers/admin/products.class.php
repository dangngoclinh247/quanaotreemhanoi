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
    const ITEM_PER_PAGE = 25;

    public function __construct()
    {
        parent::__construct();
        $this->views->addHeader('<link href="/templates/admin/css/awesome-bootstrap-checkbox.css" rel="stylesheet">');
    }

    /**
     * PAGE: /admin.php?c=products
     *
     * @param int $currentPage
     */
    public function index($currentPage = 1)
    {
        // get products list
        $start = ($currentPage - 1) * self::ITEM_PER_PAGE;
        $stop = self::ITEM_PER_PAGE;
        $products_model = new models\Products();
        $this->views->products = $products_model->selectLimit($start, $stop);
        $totalItem = $products_model->selectLimitCount();
        $totalPage = ceil($totalItem / self::ITEM_PER_PAGE);

        $this->views->totalItemShow = $products_model->selectLimitCount(models\Products::STATUS_SHOW);
        $this->views->totalItemTrash = $products_model->selectLimitCount(models\Products::STATUS_TRASH);
        $this->views->totalItemHide = $products_model->selectLimitCount(models\Products::STATUS_HIDE);

        // setting pagination
        $pagination = new library\Pagination();
        $pagination->setTotalPage($totalPage);
        $pagination->setCurrentPage($currentPage);
        $pagination->setUrl("/admin.php?c=products&m=index&p={page}");
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý sản phẩm");
        $this->views->render("admin/products/index");
    }

    /**
     * PAGE: /admin.php?c=products&m=hide
     *
     * @param int $currentPage
     */
    public function hide($currentPage = 1)
    {
        // get products list
        $start = ($currentPage - 1) * self::ITEM_PER_PAGE;
        $stop = self::ITEM_PER_PAGE;
        $products_model = new models\Products();
        $this->views->products = $products_model->selectLimit($start, $stop, models\Products::STATUS_HIDE);
        $totalItem = $products_model->selectLimitCount(models\Products::STATUS_HIDE);
        $totalPage = ceil($totalItem / self::ITEM_PER_PAGE);

        $this->views->totalItemShow = $products_model->selectLimitCount(models\Products::STATUS_SHOW);
        $this->views->totalItemTrash = $products_model->selectLimitCount(models\Products::STATUS_TRASH);
        $this->views->totalItemHide = $products_model->selectLimitCount(models\Products::STATUS_HIDE);

        // setting pagination
        $pagination = new library\Pagination();
        $pagination->setTotalPage($totalPage);
        $pagination->setCurrentPage($currentPage);
        $pagination->setUrl("/admin.php?c=products&m=hide&p={page}");
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý sản phẩm");
        $this->views->render("admin/products/hide");
    }

    public function trash($currentPage = 1)
    {
        // get products list
        $start = ($currentPage - 1) * self::ITEM_PER_PAGE;
        $stop = self::ITEM_PER_PAGE;
        $products_model = new models\Products();
        $this->views->products = $products_model->selectLimit($start, $stop, models\Products::STATUS_TRASH);
        $totalItem = $products_model->selectLimitCount(models\Products::STATUS_TRASH);
        $totalPage = ceil($totalItem / self::ITEM_PER_PAGE);

        $this->views->totalItemShow = $products_model->selectLimitCount(models\Products::STATUS_SHOW);
        $this->views->totalItemTrash = $products_model->selectLimitCount(models\Products::STATUS_TRASH);
        $this->views->totalItemHide = $products_model->selectLimitCount(models\Products::STATUS_HIDE);

        // setting pagination
        $pagination = new library\Pagination();
        $pagination->setTotalPage($totalPage);
        $pagination->setCurrentPage($currentPage);
        $pagination->setUrl("/admin.php?c=products&m=trash&p={page}");
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý sản phẩm");
        $this->views->render("admin/products/trash");
    }

    /**
     * PAGE: admin.php?c=products&m=add
     */
    public function add()
    {
        $this->views->addHeader('<link href="/templates/css/select2.min.css" rel="stylesheet">');
        $this->views->addHeader('<link href="/templates/css/select2-bootstrap.css" rel="stylesheet">');
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');

        $this->views->setPageTitle("Thêm sản phẩm");

        // Get list brand
        $brand_model = new models\Brand();
        $this->views->brands = $brand_model->selectAll();

        // Get list products_type
        $products_type = new models\Products_Type();
        $this->views->prots = products_type::sort($products_type->selectAll());

        // show form products_add
        $this->views->render("admin/products/add");
    }

    /**
     * PAGE: admin.php?c=products&m=edit
     *
     * @param $pro_id
     */
    public function edit($pro_id)
    {
        if (isset($_POST['btn-products-edit'])) {

            $product = new models\Products();

            $product->setProId($_POST['prot_id']);
            $product->setProSlug($_POST['pro_name']);
            $product->setProSlug($_POST['pro_slug']);
            $product->setProContent($_POST['pro_content']);
            $product->setProSize($_POST['pro_size']);
            $product->setProSizeInfo($_POST['pro_size_info']);
            $product->setProPrice($_POST['pro_price']);
            $product->setProQuantity($_POST['pro_quantity']);
            $product->setProSeoTitle($_POST['pro_seo_title']);
            $product->setProSeoDescription($_POST['pro_seo_description']);
            $product->setProStatus($_POST['pro_status']);
            $product->setUserId($_SESSION['user_id']);
            $product->setBrandId($_POST['brand_id']);

            if ($product->update()) {
                // Update products type
                if (isset($_POST['prot_id']) && count($_POST['prot_id']) > 0) {

                    // update products type
                    $type_detail = $_POST['prot_id']; // array

                    $products_type_details_model = new models\Products_Type_Details();
                    $type_detail_old = $products_type_details_model->selectByProducts($pro_id);

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
                        $products_type_details_model->insert($type_detail_insert, $pro_id);
                    }

                    if (count($type_detail_delete) > 0) {
                        $products_type_details_model->delete($type_detail_delete, $pro_id);
                    }
                }
            }

        }

        $this->views->addHeader('<link href="/templates/css/select2.min.css" rel="stylesheet">');
        $this->views->addHeader('<link href="/templates/css/select2-bootstrap.css" rel="stylesheet">');
        $this->views->addHeader('<link href="/templates/css/summernote.css" rel="stylesheet">');

        $this->views->setPageTitle("Thêm sản phẩm");

        // Get list brand
        $brand_model = new models\Brand();
        $this->views->brands = $brand_model->selectAll();

        // Get list products_type
        $prot_model = new models\Products_Type();
        $this->views->prots = products_type::sort($prot_model->selectAll());

        // GET info of this product
        $products_model = new models\Products();
        $products_model->setProId($pro_id);
        $this->views->product = $products_model->select();

        // GET list prot array
        $products_type_details = new models\Products_Type_Details();
        $this->views->prot_id = $products_type_details->selectByProducts($this->views->product['pro_id']);

        // show form products_add
        $this->views->render("admin/products/edit");
    }

    public function delete($pro_id)
    {
        $result = 0;
        $products = new models\Products();
        $products->setProId($pro_id);
        if ($products->delete()) {
            $result = 1;
        }
        echo $result;
    }

    public function deleteTrash($pro_id)
    {
        $result = 0;
        $products = new models\Products();
        $products->setProId($pro_id);
        if ($products->delete(true)) {
            $result = 1;
        }
        echo $result;
    }

    public function select($pro_id)
    {
        $result = array(
            "pro_id" => -1
        );
        $products = new models\Products();
        $products->setProId($pro_id);
        $products = $products->select();
        if (count($products) > 0) {
            $result = $products;
        }
        echo json_encode($result);
    }

    /**
     * UPLOAD IMAGE
     *
     * @param int $pro_id
     */
    public function upload($pro_id = -1)
    {
        // Upload ảnh
        $upload_image = new library\Upload($_FILES['file']);
        $upload_image->setPath("/upload/2015/09");
        $upload_image->send();
        $result = array(
            "url" => "http://quanaotreemhanoi.dev" . $upload_image->getResult(),
            "id" => $pro_id
        );

        if ($pro_id == -1) {
            $product = new models\Products();
            $product->setUserId($_SESSION['user_id']);

            if ($product->insert()) {
                $pro_id = $product->insert_id;
                $result['id'] = $pro_id;
            }
        }

        $image = new models\Images();
        $image->setProId($pro_id);
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

    public function images_featured_panel($pro_id)
    {
        $image = new models\Images();
        $image->setProId($pro_id);
        $this->views->images_featured = $image->selectAllProducts(true); // featured = true
        $this->views->render("admin/products/images_featured");
    }

    public function images_panel($pro_id)
    {
        $image = new models\Images();
        $image->setProId($pro_id);
        $this->views->images = $image->selectAllProducts();
        $this->views->render("admin/products/images_panel");
    }

    /**
     * SEARCH products in id or pro_name
     *
     * @param $keyword
     * @param $currentPage
     */
    public function search($keyword, $currentPage = 1)
    {
        // get products list
        $itemPerPage = self::ITEM_PER_PAGE;
        $start = ($currentPage - 1) * $itemPerPage;
        $stop = $itemPerPage;
        $products_model = new models\Products();
        $this->views->products = $products_model->search($keyword, $start, $stop);
        $totalItem = $products_model->searchCount($keyword);
        $totalPage = ceil($totalItem / $itemPerPage);

        // setting pagination
        $pagination = new library\Pagination();
        $pagination->setTotalPage($totalPage);
        $pagination->setCurrentPage($currentPage);
        $pagination->setUrl("/admin.php?c=products&m=search&p={$keyword}&page={page}");
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý sản phẩm");
        $this->views->keyword = $keyword;
        $this->views->render("admin/products/search");
    }

    public function ajax_products_add_upload($pro_id = -1)
    {
        // Upload ảnh
        $upload_image = new library\Upload($_FILES['file']);
        $upload_image->setPath("/upload/" . date("Y/m"));
        $upload_image->send();

        $result = array(
            "url" => "http://quanaotreemhanoi.dev" . $upload_image->getResult(),
            "id" => $pro_id
        );

        if ($pro_id == -1) {

            $product = new models\Products();
            $product->setUserId($_SESSION['user_id']);

            if ($product->insert()) {
                $result['id'] = $product->insert_id;
            }
        }

        $images = new models\Images();
        $images->setImgUrl($upload_image->getResult());
        $images->setImgUrl(pathinfo($upload_image->getResult(), PATHINFO_FILENAME));


        if (isset($_POST['featured']) && $_POST['featured'] == "true") {
            $images->setFeatured(models\Images::FEATURED_YES);
        } else {
            $images->setFeatured(models\Images::FEATURED_NO);
        }
        $images->insert_products();

        echo json_encode($result);
    }

    /**
     * Process for PAGE: products/add
     */
    public function insert()
    {
        $result = array(
            "status" => 0
        );
        if (isset($_POST)) {
            $product = new models\Products();
            $product->setId($_POST['pro_id']);
            $product->setProName($_POST['pro_name']);


            if (isset($_POST['pro_slug']) && $_POST['pro_slug'] != "") {
                $products_slug = library\Func::getSlug($_POST['pro_slug']);
            } else {
                $products_slug = library\Func::getSlug($product->getProName());
            }

            $product->setProSlug($products_slug);
            $product->setProContent($_POST['pro_content']);
            $product->setProSize($_POST['pro_size']);
            $product->setProSizeInfo($_POST['pro_size_info']);
            $product->setProPrice($_POST['pro_price']);
            $product->setProQuantity($_POST['pro_quantity']);
            $product->setProSeoTitle($_POST['pro_seo_title']);
            $product->setProSeoDescription($_POST['pro_seo_description']);
            $product->setProStatus($_POST['pro_status']);
            $product->setUserId($_SESSION['user_id']);
            $product->setBrandId($_POST['brand_id']);

            if ($product->insert()) {
                $result = array(
                    "status" => 1,
                    "pro_id" => $product->insert_id
                );

                //Insert products type
                if (isset($_POST['prot_id']) && count($_POST['prot_id']) > 0) {
                    $products_type = $_POST['prot_id'];
                    $products_type_details_model = new models\Products_Type_Details();
                    $products_type_details_model->setProId($result['pro_id']);
                    $products_type_details_model->insert_multi_type($products_type);
                }
            }
        }
        echo json_encode($result);
    }

    /**
     * Process for PAGE: products/edit
     *
     * @param $pro_id
     */
    public function update($pro_id)
    {
        $result = 0;
        $product = new models\Products();
        $product->setProId($pro_id);
        $product->setId($_POST['pro_id']);
        $product->setProName($_POST['pro_name']);

        if (isset($_POST['news_slug']) && $_POST['news_slug'] != "") {
            $products_slug = library\Func::getSlug($_POST['news_slug']);
        } else {
            $products_slug = library\Func::getSlug($product->getProName());
        }

        $product->setProSlug($products_slug);
        $product->setProContent($_POST['pro_content']);
        $product->setProSize($_POST['pro_size']);
        $product->setProSizeInfo($_POST['pro_size_info']);
        $product->setProPrice($_POST['pro_price']);
        $product->setProQuantity($_POST['pro_quantity']);
        $product->setProSeoTitle($_POST['pro_seo_title']);
        $product->setProSeoDescription($_POST['pro_seo_description']);
        $product->setProStatus($_POST['pro_status']);
        $product->setUserId($_SESSION['user_id']);
        $product->setBrandId($_POST['brand_id']);

        if ($product->update()) {
            $products_type_details = new models\Products_Type_Details();
            $products_type_details->setProId($pro_id);

            if (isset($_POST['prot_id']) && count($_POST['prot_id']) > 0) { // have checkbox ntype_id

                $type_detail = $_POST['prot_id']; // arrray

                $products_type_details->deleteAllType();
                $products_type_details->setProId($pro_id);
                $products_type_details->insert_multi_type($type_detail);

            } else { // dont have checkbox
                //echo "lamdang";
                $products_type_details->deleteAllType();
            }
            $result = 1;
        }
        echo $result;
    }

    /**
     * Load panel for products image - Modal
     *
     * @param $pro_id
     */
    public
    function products_image($pro_id)
    {
        if (isset($_POST['img_id'])) {
            $images_model = new models\Images();
            $img_id = $_POST['img_id'];
            $image = $images_model->selectProducts($pro_id, $img_id);
            if ($image != false) {
                $this->views->image = $image;
                $this->views->render("admin/products/products_image");
            } else {
                exit("What the hell?");
            }
        } else {
            exit("What the hell?");
        }
    }

    public
    function products_image_set_featured($pro_id)
    {
        $result = 0;
        if (isset($_POST['img_id'])) {
            $images_model = new models\Images();
            $img_id = $_POST['img_id'];
            $image = $images_model->setProductsFeatured($pro_id, $img_id);
            if ($image != false) {
                $result = 1;
            }
        }
        echo $result;
    }

    /**
     * Process when click unset featured
     *
     * @param $pro_id
     */
    public function products_image_unset_featured($pro_id)
    {
        $result = 0;
        if (isset($_POST['img_id'])) {
            $images_model = new models\Images();
            $img_id = $_POST['img_id'];
            $image = $images_model->unsetProductsFeatured($pro_id, $img_id);
            if ($image != false) {
                $result = 1;
            }
        }
        echo $result;
    }

    /**
     * Load products images panel
     *
     * @param $pro_id
     */
    public function products_images($pro_id)
    {
        $images_model = new models\Images();
        $this->views->images = $images_model->selectAllProducts($pro_id);
        $this->views->render("admin/products/products_images_panel");
    }

    /**
     * Load products images featured panel
     *
     * @param $pro_id
     */
    public function products_images_featured($pro_id)
    {
        $images_model = new models\Images();
        $this->views->images = $images_model->selectAllProducts($pro_id, true); //true => featured = 1
        $this->views->render("admin/products/products_images_featured_panel");
    }

    public function featured($pro_id)
    {
        $result = 0;
        if(isset($_POST['featured'])) {
            $products_model = new models\Products();
            $products_model->setProId($pro_id);
            $product = $products_model->select();
            if (count($product) > 0) {
                $pro_featured = $_POST['featured'];
                $products_model->setProFeatured($pro_featured);
                if($products_model->update_featured())
                {
                    $result = 1;
                }
            }
        }
        echo $result;
    }

    public function insert_example()
    {
        $products = new models\Products();
        $products->setProName("Đầm Nớ Bé Gái Cát Thái Xanh Ngọc");
        $products->setProSlug(library\Func::getSlug($products->getProName()));
        $products->setProSize(8);
        $products->setProSizeInfo("1 - 8");
        $products->setProStatus(models\Products::STATUS_SHOW);
        $i = 50;
        do
        {
            $i++;
            $products->setId("0000" . $i);
            $products->insert();
        }while($i < 100);
    }
}