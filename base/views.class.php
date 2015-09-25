<?php
namespace base;
class Views
{
    public $page;

    public function __construct()
    {
        $this->page = new page();
    }

    public function render($name)
    {
        include "views/" . $name . ".php";
    }
}