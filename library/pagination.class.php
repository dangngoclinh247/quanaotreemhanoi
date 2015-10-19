<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/6/2015
 * Time: 9:41 AM
 */

namespace library;

class Pagination
{

    private $_totalPage;
    private $_currentPage;
    private $_url; //{page};

    /**
     * @return mixed
     */
    public function getTotalPage()
    {
        return $this->_totalPage;
    }

    /**
     * @param mixed $totalPage
     */
    public function setTotalPage($totalPage)
    {
        $this->_totalPage = $totalPage;
    }

    /**
     * @return mixed
     */
    public function getCurrentPage()
    {
        return $this->_currentPage;
    }

    /**
     * @param mixed $currentPage
     */
    public function setCurrentPage($currentPage)
    {
        $this->_currentPage = $currentPage;
    }

    /**
     * @param $page
     * @return mixed
     */
    public function getUrl($page = 1)
    {
        return str_replace("{page}", $page, $this->_url);
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->_url = $url;
    }

    public function __construct()
    {
        $this->setTotalPage(0);
        $this->setCurrentPage(0);
    }

    public function getHTML()
    {
        $str = "";
        if ($this->_totalPage > 1)
        {
            $str .= '<ul class="pagination">';
            if ($this->_currentPage == 1)
            {
                $str .= '<li class="disabled">';
                $str .= '<a href="#" aria-label="Previous">';
                $str .= '<span aria-hidden="true">&laquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }
            else
            {
                $str .= '<li>';
                $str .= '<a href="' . $this->getUrl($this->_currentPage-1) . '" aria-label="Previous">';
                $str .= '<span aria-hidden="true">&laquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }

            for($i = 1; $i <= $this->_totalPage; $i++)
            {
                if($i == $this->_currentPage)
                {
                    $str .= '<li class="active"><a href="' . $this->getUrl($i) . '">' . $i . '</a></li>';
                }
                else
                {
                    $str .= '<li><a href="' . $this->getUrl($i) . '">' . $i . '</a></li>';
                }
            }

            if($this->_currentPage == $this->_totalPage)
            {
                $str .= '<li class="disabled">';
                $str .= '<a href="#" aria-label="Next">';
                $str .= '<span aria-hidden="true">&raquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }
            else
            {
                $str .= '<li>';
                $str .= '<a href="' . $this->getUrl($this->_currentPage+1) . '" aria-label="Next">';
                $str .= '<span aria-hidden="true">&raquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }
            $str .= '</ul>';
        }
        return $str;
    }
    public function toStrong()
    {
        $str = "";
        if ($this->_totalPage > 1)
        {
            $str .= '<ul class="pagination">';
            if ($this->_currentPage == 1)
            {
                $str .= '<li class="disabled">';
                $str .= '<a href="#" aria-label="Previous">';
                $str .= '<span aria-hidden="true">&laquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }
            else
            {
                $str .= '<li>';
                $str .= '<a href="' . $this->getUrl($this->_currentPage-1) . '" aria-label="Previous">';
                $str .= '<span aria-hidden="true">&laquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }

            for($i = 1; $i <= $this->_totalPage; $i++)
            {
                if($i == $this->_currentPage)
                {
                    $str .= '<li class="active"><a href="' . $this->getUrl($i) . '">' . $i . '</a></li>';
                }
                else
                {
                    $str .= '<li><a href="' . $this->getUrl($i) . '">' . $i . '</a></li>';
                }
            }

            if($this->_currentPage == $this->_totalPage)
            {
                $str .= '<li class="disabled">';
                $str .= '<a href="#" aria-label="Next">';
                $str .= '<span aria-hidden="true">&raquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }
            else
            {
                $str .= '<li>';
                $str .= '<a href="' . $this->getUrl($this->_currentPage+1) . '" aria-label="Next">';
                $str .= '<span aria-hidden="true">&raquo;</span>';
                $str .= '</a>';
                $str .= '</li>';
            }
            $str .= '</ul>';
        }
        return $str;
    }
}