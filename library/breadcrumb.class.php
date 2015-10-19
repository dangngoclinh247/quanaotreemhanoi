<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/14/2015
 * Time: 1:03 AM
 */

namespace library;


class Breadcrumb
{
    const ACTIVE_TRUE = true;
    const ACTIVE_FALSE = false;

    private $_h2;
    private $_list;

    public function __construct()
    {
        $this->_h2 = null;
        $this->_list = array();
    }

    public function setH2($str)
    {
        $this->_h2 = $str;
    }

    public function addLink($href, $text, $active = false)
    {
        $this->_list[] = array(
            "href" => $href,
            "text" => $text,
            "active" => $active
        );
    }

    public function toString()
    {
        $result = "";
        $result .= '<div class="row">';
        $result .= $this->getH2();
        $result .= $this->getList();
        $result .= '</div>';
        return $result;
    }

    private function getH2()
    {
        $result = "";
        $result .= '<div class="col-md-8">';
        $result .= '<h2>' . $this->_h2 . '</h2>';
        $result .= '</div>';
        return $result;
    }

    private function getList()
    {
        $result = "";
        if(count($this->_list) > 0) {
            $result .= '<div class="col-md-4">';
            $result .= '<ol class="breadcrumb text-right">';
            foreach($this->_list as $atag)
            {
                if($atag['active'])
                {
                    $result .= '<li class="active">' . $atag['text'] . '</li>';
                }
                else
                {
                    $result .= '<li><a href="' . $atag['href'] . '">' . $atag['text'] . '</a></li>';
                }
            }
            $result .= '</ol>';
            $result .= '</div>';
        }
        return $result;
    }
}