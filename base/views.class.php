<?php
namespace base;
class Views
{
    private $page;
    public $options;

    public function __construct()
    {
        $this->page = array(
            "page_title" => "",
            "meta_description" => "",
            "page_header" => array()
        );
    }

    public function render($name)
    {
        include "views/" . $name . ".php";
    }

    public function setPageTitle($str)
    {
        $this->page['page_title'] = $str;
    }

    public function getPageTitle()
    {
        return $this->page['page_title'];
    }

    public function setMetaDescription($str)
    {
        $this->page['meta_description'] = $str;
    }

    public function getMetaDescription()
    {
        return $this->page['meta_description'];
    }

    public function addHeader($str)
    {
        $this->page['page_header'][] = $str;
    }

    public function getHeader()
    {
        foreach($this->page['page_header'] as $header)
        {
            echo $header . "\n";
        }
    }

    public function getShortText($str, $number)
    {
        $result = substr($str, 0, $number);
        $result = explode(" ", $result);
        unset($result[count($result)-1]);
        $result = implode(" ", $result);
        return $result;
    }
}