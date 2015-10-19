<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/4/2015
 * Time: 11:00 PM
 */

namespace controllers\admin;

use base;
class Admin_Controllers extends base\Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->views->addHeader('<link rel="stylesheet" href="/templates/admin/css/bootstrap.min.css">');
        $this->views->addHeader('<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">');
        //$this->views->addHeader('<link rel="stylesheet" href="/templates/admin/css/stydle.css">');
        $this->views->addHeader('<link rel="stylesheet" href="/templates/admin/css/dashboard.css">');
    }
}