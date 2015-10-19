<?php
namespace controllers\admin;

use base;

class Welcome extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->views->render("admin/index");
    }
}