<?php
namespace controllers\admin;
use base;
class Welcome extends base\Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->views->render("welcome/index");
    }
}