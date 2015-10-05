<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/23/2015
 * Time: 2:13 PM
 */

namespace controllers\admin;

use base;
use library\Func;
use models;

class users extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Page admin.php?c=users&m=index
     */
    public function index()
    {
        $this->views->setPageTitle("Quản lý Người Dùng");
        // Delete
        $this->delete_ajax();

        $users = new models\Users();
        $this->views->users = $users->selectAll();
        $this->views->render("admin/users/index");
    }

    /**
     * Page admin.php?c=users&m=add
     */
    public function add()
    {
        $this->views->setPageTitle("Thêm người dùng");
        $users_roles = new models\users_roles();
        $this->views->roles = $users_roles->selectAll();
        $this->views->render("admin/users/add");
    }

    /**
     * Page admin.php?c=users&m=edit
     *
     * @param $user_id
     */
    public function edit($user_id = -1)
    {
        $this->views->setPageTitle("Update thông tin người dùng");
        if ($user_id != -1) {
            $users_roles = new models\users_roles();
            $this->views->roles = $users_roles->selectAll();

            $user_model = new models\Users();
            $this->views->user = $user_model->select($user_id);
            $this->views->render("admin/users/edit");
        }
    }

    /**
     * Ajax check email validate for page: admin.php?c=users&m=add
     */
    public function ajax_check_email()
    {
        $result = "false";
        if (isset($_POST['user_email']) && $_POST['user_email'] != "") {

            $user_email = $_POST['user_email'];
            $user_model = new models\Users();
            if (isset($_POST['user_id']) && $_POST['user_id'] > 0) {
                $user_id = $_POST['user_id'];
                $user = $user_model->selectByEmailNotID($user_email, $user_id);
                if (count($user) < 1) {
                    $result = "true";
                }
            } else {
                $user = $user_model->selectByEmail($user_email);
                if (count($user) < 1) {
                    $result = "true";
                }
            }
        }
        echo $result;
    }

    /**
     * Process for page: admin.php?c=users&m=add
     */
    public function ajax_add()
    {
        $result = 0;
        if (isset($_POST['add']) && $_POST['add'] = "ok") {
            $data = array(
                "user_name" => $_POST['user_name'],
                "user_email" => $_POST['user_email'],
                "user_pass" => $_POST['user_pass'],
                "roles_id" => $_POST['roles_id']
            );
            $data['salt'] = Func::genPasswordSalt();
            $data['user_pass'] = Func::genPassword($data['user_pass'], $data['salt']);
            $user_model = new models\Users();
            if ($user_model->insert($data) == true) {
                $result = 1;
            }
        }
        echo $result;
    }

    /**
     * process for Page: /admin.php?c=users&m=edit
     *
     * @param $user_id
     */
    public function ajax_edit($user_id)
    {
        $result = 0;
        if (isset($_POST['user_name']) && $_POST['user_name'] != "") {
            $data = array(
                "user_name" => $_POST['user_name'],
                "user_email" => $_POST['user_email'],
                "user_pass" => $_POST['user_pass'],
                "roles_id" => $_POST['roles_id']
            );

            // hash password and create salt for password
            if (strlen($data['user_pass']) >= 4) {
                $data['salt'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
                $data['user_pass'] = hash('sha256', $data['user_pass'] . $data['salt']);
            } else {
                unset($data['user_pass']);
            }

            $user_model = new models\Users();
            if ($user_model->update($data, $user_id) == true) {
                $result = 1;
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