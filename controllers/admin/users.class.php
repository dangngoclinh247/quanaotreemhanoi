<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/23/2015
 * Time: 2:13 PM
 */

namespace controllers\admin;

use base;
use library\Alert;
use library\Func;
use library\Pagination;
use library\Upload;
use models;

class users extends Admin_Controllers
{
    const ITEM_PER_PAGE = 25;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Page admin.php?c=users&m=index
     *
     * @param $currentPage = 1
     */
    public function index($currentPage = 1)
    {
        // get products list
        $start = ($currentPage - 1) * self::ITEM_PER_PAGE;
        $stop = self::ITEM_PER_PAGE;
        $users_model = new models\Users();
        $this->views->users = $users_model->select_limit($start, $stop);
        $totalItem = $users_model->select_limit_count();
        $totalPage = ceil($totalItem / self::ITEM_PER_PAGE);


        // setting pagination
        $pagination = new Pagination();
        $pagination->setTotalPage($totalPage);
        $pagination->setCurrentPage($currentPage);
        $pagination->setUrl("/admin.php?c=products&m=index&p={page}");
        $this->views->pagination = $pagination;

        $this->views->setPageTitle("Quản lý Người Dùng");

        $this->views->render("admin/users/index");
    }

    /**
     * Page admin.php?c=users&m=add
     */
    public function add()
    {
        if (isset($_POST['btn_user_add'])) {
            $user_model = new models\Users();
            $user_model->setUserName($_POST['user_name']);
            $user_model->setUserEmail($_POST['user_email']);
            $user_model->setUserPass($_POST['user_pass']);
            $user_model->setRolesId($_POST['roles_id']);

            $salt = Func::genPasswordSalt();
            $user_model->setSalt($salt);

            $pass = Func::genPassword($_POST['user_pass'], $salt);
            $user_model->setUserPass($pass);

            $message = new Alert();
            if ($user_model->insert()) {
                $message->setMessage("<strong>Thành công!</strong> Đã thêm người dùng thành công");
            } else {
                $message->setType(Alert::TYPE_WARNING);
                $message->setMessage("<strong>Lỗi !</strong> Không thể thêm người dùng " . $user_model->error . " - " . $user_model->connect_errno);
            }
            $this->views->message = $message;
        }

        $users_roles = new models\users_roles();
        $this->views->roles = $users_roles->select_all();
        $this->views->setPageTitle("Thêm người dùng");
        $this->views->render("admin/users/add");
    }

    /**
     * Page admin.php?c=users&m=edit
     *
     * @param $user_id
     */
    public function edit($user_id)
    {
        $user_model = new models\Users();
        if (isset($_POST['user_id'])) {

            if ($_FILES["user_image"]['name'] != "") {
                $upload = new Upload($_FILES['user_image']);
                $upload->setAccept(array("jpg", "png"));
                $upload->send();

                $img_url = $upload->getResult();
                $images_modal = new models\Images();
                $images_modal->setImgUrl($img_url);

                //print_r($images_modal);
                if($images_modal->insert())
                {
                    $user_model->setImgId($images_modal->insert_id);
                }
            }

            $user_model->setUserId($user_id);
            $user_model->setUserName($_POST['user_name']);
            $user_model->setUserEmail($_POST['user_email']);
            $user_model->setRolesId($_POST['roles_id']);
            $user_model->setUserPhone1($_POST['user_phone1']);
            $user_model->setUserPhone2($_POST['user_phone2']);
            $user_model->setUserAddress($_POST['user_address']);

            // hash password and create salt for password
            if (strlen($_POST['user_pass']) >= 4) {
                $salt = Func::genPasswordSalt();
                $user_pass = Func::genPassword($_POST['user_pass'], $salt);
                $user_model->setSalt($salt);
                $user_model->setUserPass($user_pass);
            }

            $message = new Alert();
            if ($user_model->update()) {
                $message->setMessage("<strong>Thành công!</strong> Update người dùng thành công");
            } else {
                $message->setType(Alert::TYPE_WARNING);
                $message->setMessage("<strong>Lỗi! </strong>Không thể update người dùng");
            }
            $this->views->message = $message;
        }
        $users_roles = new models\users_roles();
        $this->views->roles = $users_roles->select_all();

        $user_model->setUserId($user_id);
        $this->views->user = $user_model->select();

        $this->views->setPageTitle("Update thông tin người dùng");
        $this->views->render("admin/users/edit");
    }

    /**
     * Ajax check email validate for page: admin.php?c=users&m=add
     */
    public function ajax_check_email()
    {
        $result = "false";
        if (isset($_POST['user_email'])) {

            $user_email = $_POST['user_email'];
            $user_model = new models\Users();
            $user_model->setUserEmail($user_email);
            if (isset($_POST['user_id'])) {
                $user_id = $_POST['user_id'];
                $user_model->setUserId($user_id);
                $user = $user_model->select_by_email_not_id();
                if (count($user) < 1) {
                    $result = "true";
                }
            } else {
                $user = $user_model->select_by_email();
                if (count($user) < 1) {
                    $result = "true";
                }
            }
        }
        echo $result;
    }

    public function delete_ajax()
    {
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $user_model = new models\Users();
            if (isset($_POST['del']) && $_POST['del'] == "ok") {
                $user = $user_model->select($user_id);
                $result = $user_model->delete($user_id);
                $result = array(array("status" => $result), $user);
            } else {
                // return select user
                $result = $user_model->select($user_id);
            }
            exit(json_encode($result));
        }
    }
}