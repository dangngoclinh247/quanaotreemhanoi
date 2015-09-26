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

class users extends base\Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // Delete
        $this->delete_ajax();

        $users = new models\Users();
        $this->views->users = $users->selectAll();
        $this->views->render("admin/users/index");
    }

    public function add()
    {
        $this->add_ajax();

        $this->views->setPageTitle("Thêm người dùng");
        $users_roles = new models\users_roles();
        $this->views->roles = $users_roles->selectAll();
        $this->views->render("admin/users/add");
    }

    public function edit($id = -1)
    {
        if ($id != -1) {
            $this->edit_ajax($id);

            $users_roles = new models\users_roles();
            $this->views->roles = $users_roles->selectAll();

            $user_model = new models\Users();
            $this->views->user = $user_model->select($id);
            $this->views->render("admin/users/edit");
        }
    }

    public function add_ajax()
    {
        if (isset($_POST['add']) && $_POST['add'] = "ok") {
            $data = array(
                "user_name" => $_POST['user_name'],
                "user_email" => $_POST['user_email'],
                "user_pass" => $_POST['user_pass'],
                "roles_id" => $_POST['roles_id']
            );
            $user_model = new models\Users();
            if ($user_model->insert($data) == true) {
                exit(json_encode(array(
                    "status" => 1,
                    "message" => Func::getAlert("Da Them Nguoi Dung Thanh Cong")
                )));
            } else {
                exit(json_encode(array(
                    "status" => 0,
                    "message" => "Error:" . $user_model->error
                )));
            }
        }
    }

    public function edit_ajax($id)
    {
        if (isset($_POST['edit']) && $_POST['edit'] = "ok") {
            $data = array(
                "user_name" => $_POST['user_name'],
                "user_email" => $_POST['user_email'],
                "user_pass" => $_POST['user_pass'],
                "roles_id" => $_POST['roles_id']
            );
            $user_model = new models\Users();
            if ($user_model->update($data, $id) == true) {
                exit(json_encode(array(
                    "status" => "1",
                    "message" => Func::getAlert("Update thong tin nguoi dung thanh cong")
                )));
            } else {
                exit(json_encode(array(
                    "status" => "0",
                    "message" => "Error:" . $user_model->error
                )));
            }
        }
    }

    public function delete_ajax()
    {
        if (isset($_POST['user_id'])) {
            $user_id = $_POST['user_id'];
            $user_model = new models\Users();
            if (isset($_POST['del']) && $_POST['del'] == "ok")
            {
                $user = $user_model->select($user_id);
                $result = $user_model->delete($user_id);
                $result = array( array("status" => $result),$user);
            }
            else
            {
                // return select user
                $result = $user_model->select($user_id);
            }
            exit(json_encode($result));
        }
    }
}