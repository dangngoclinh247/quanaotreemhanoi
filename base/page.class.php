<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/23/2015
 * Time: 2:31 PM
 */

namespace base;


class page
{
    private $_title;
    private $_meta_description;
    private $_webname;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->_meta_description;
    }

    /**
     * @param mixed $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->_meta_description = $meta_description;
    }

    /**
     * @return mixed
     */
    public function getWebname()
    {
        return $this->_webname;
    }

    /**
     * @param mixed $webname
     */
    public function setWebname($webname)
    {
        $this->_webname = $webname;
    }
}