<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/13/2015
 * Time: 11:30 PM
 */

namespace models;


use base\Models;

class Options extends Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "options";

    const AUTOLOAD_YES = "yes";
    const AUTOLOAD_NO = "no";

    private $_option_id;
    private $_option_name;
    private $_option_value;
    private $_autoload;

    /**
     * @return mixed
     */
    public function getOptionId()
    {
        return $this->_option_id;
    }

    /**
     * @param mixed $option_id
     */
    public function setOptionId($option_id)
    {
        $this->_option_id = $option_id;
    }

    /**
     * @return mixed
     */
    public function getOptionName()
    {
        return $this->_option_name;
    }

    /**
     * @param mixed $option_name
     */
    public function setOptionName($option_name)
    {
        $this->_option_name = $option_name;
    }

    /**
     * @return mixed
     */
    public function getOptionValue()
    {
        return $this->_option_value;
    }

    /**
     * @param mixed $option_value
     */
    public function setOptionValue($option_value)
    {
        $this->_option_value = $option_value;
    }

    /**
     * @return mixed
     */
    public function getAutoload()
    {
        return $this->_autoload;
    }

    /**
     * @param mixed $autoload
     */
    public function setAutoload($autoload)
    {
        $this->_autoload = $autoload;
    }

    public function __construct()
    {
        parent::__construct();

        $this->_option_id = null;
        $this->_option_name = null;
        $this->_option_value = null;
        $this->_autoload = self::AUTOLOAD_YES;
    }

    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(option_name, option_value, autoload)
                VALUES (?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sss",
            $this->getOptionName(),
            $this->getOptionValue(),
            $this->getAutoload());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . "
                SET option_value=?,
                    autoload=?
                WHERE option_name=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sss",
            $this->getOptionValue(),
            $this->getAutoload(),
            $this->getOptionName());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    public function hasOptionName($option_name = "")
    {
        if($option_name != "")
        {
            $this->setOptionName($option_name);
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE option_name=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $this->getOptionName());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return count($result->fetch_assoc()) > 0;
    }

    public function select()
    {

    }

    public function select_all($autoload = self::AUTOLOAD_YES)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE autoload=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $autoload);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $this->fetch_assoc_all($result);
        return $this->toArray($result);
    }

    private function toArray($options)
    {
        $result = array();
        foreach($options as $option)
        {
            $result[$option['option_name']] = $option['option_value'];
        }
        return $result;
    }
}