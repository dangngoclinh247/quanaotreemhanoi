<?php
namespace base;
class Controllers
{

    protected $views;

    public function __construct()
    {
        $this->views = new Views();
    }
}