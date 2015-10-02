<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/29/2015
 * Time: 10:20 PM
 */

namespace library;


class Upload
{
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->_tmp_name;
    }

    /**
     * @param mixed $tmp_name
     */
    public function setTmpName($tmp_name)
    {
        $this->_tmp_name = $tmp_name;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->_size;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->_size = $size;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->_type = $type;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->_error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error)
    {
        $this->_error = $error;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->_path;
    }

    public function getPathFull()
    {
        return SITE_ROOT . $this->getPath();
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->_path = $path;
    }

    /**
     * @return mixed
     */
    public function getLimitSize()
    {
        return $this->_limit_size;
    }

    /**
     * @param mixed $limit_size
     */
    public function setLimitSize($limit_size)
    {
        $this->_limit_size = $limit_size;
    }

    public function getFileType()
    {
        return strtolower(pathinfo($this->getName(), PATHINFO_EXTENSION));
    }

    public function getFileName()
    {
        return strtolower(pathinfo($this->getName(), PATHINFO_FILENAME));
    }

    private $_name;
    private $_new_name; // new name file
    private $_tmp_name;
    private $_size;
    private $_type;
    private $_error; // don't error if != 0

    private $_accept; // array accept file
    private $_limit_size; // limited file size

    private $_path;
    private $_destination;

    private $_time;

    public function __construct($data)
    {
        $this->setName($data['name']);
        $this->setTmpName($data['tmp_name']);
        $this->setType($data['type']);
        $this->setError($data['error']);
        $this->setName($data['name']);
        $this->setName($data['name']);

        $this->_path = "/upload/" . date("Y") . "/" . date("m");
        $this->_destination = "";
        $this->_accept = null;
        $this->_new_name = "";
    }

    public function setAccept($data)
    {
        $this->_accept = $data;
    }

    public function setNewName($name)   // new name don't have extension
    {
        $this->_new_name = $name;
    }

    private function getNewName()
    {
        if ($this->_new_name == "")
            return $this->getFileName();
    }

    private function setDestination()
    {
        $destination = $this->getPath() . "/" . $this->getNewName() . "." . $this->getFileType();
        $i = 2;
        while (file_exists(SITE_ROOT . $destination)) {
            $destination = $this->getPath() . "/" . $this->getNewName() . "_$i." . $this->getFileType();
            $i++;
        }
        $this->_destination = strtolower($destination);
    }

    /**
     * return string of destination
     *
     * @return string
     */
    public function getDestination()
    {
        if ($this->_destination == "") {
            $this->setDestination();
        }
        return $this->_destination;
    }

    public function send()
    {
        // check path exists
        if(!is_dir($this->getPathFull() . "/") && !mkdir($this->getPathFull() . "/", 0775, true))
        {
            return 3; // can't not create directory
        }

        $result = 1; // can't not update file type
        if ($this->_accept != null) {
            if (in_array($this->getFileType(), $this->_accept)) {
                if (move_uploaded_file($this->getTmpName(), SITE_ROOT . $this->getDestination())) {
                    $this->_time = date("Y-m-d h:s:i");
                    $result = 0;
                } else {
                    $result = 2; // upload error
                }
            }
        } else {
            if (move_uploaded_file($this->getTmpName(), SITE_ROOT . $this->getDestination())) {
                $this->_time = date("Y-m-d h:s:i");
                $result = 0;
            } else {
                $result = 2; // upload error
            }
        }
        return $result;
    }

    public function getResult()
    {
        if ($this->_destination == "") {
            return false;
        } else {
            return $this->getDestination();
        }
    }
}