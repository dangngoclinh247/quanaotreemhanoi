<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/6/2015
 * Time: 1:40 PM
 */

namespace models;


use base;

class Products_Type_Details extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "products_type_details";

    private $_pro_id;
    private $_prot_id;

    /**
     * @return mixed
     */
    public function getProId()
    {
        return $this->_pro_id;
    }

    /**
     * @param mixed $pro_id
     */
    public function setProId($pro_id)
    {
        $this->_pro_id = $this->trim($pro_id);
    }

    /**
     * @return mixed
     */
    public function getProtId()
    {
        return $this->_prot_id;
    }

    /**
     * @param mixed $prot_id
     */
    public function setProtId($prot_id)
    {
        $this->_prot_id = $this->trim($prot_id);
    }


    public function __construct()
    {
        parent::__construct();

        $this->_pro_id = null;
        $this->_prot_id = null;
    }

    public function selectByProducts($pro_id)
    {
        $sql = "SELECT prot_id FROM " . $this->getTableName("products_type_details") . " WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $pro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row['prot_id'];
        }
        $stmt->close();
        return $data;
    }

    public function selectInfoByProducts()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " d, " . Products_Type::TABLE_NAME . " t WHERE pro_id=? AND d.prot_id=t.prot_id";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Insert new row
     *
     * @return mixed
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(pro_id, prot_id)
                VALUES (?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $this->getProId(), $this->getProtId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Insert Multi rows data and $_news_id
     *
     * @param $data
     */
    public function insert_multi_type($data)
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(pro_id, prot_id) VALUES (?, ?)";
        $stmt = $this->prepare($sql);
        foreach ($data as $prot_id) {
            $stmt->bind_param("ii", $this->getProId(), $prot_id);
            $stmt->execute();
        }
        $stmt->close();
    }

    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE pro_id=? AND prot_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $this->getProId(), $this->getProtId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * DELETE Multi data type
     *
     * @param $data
     */
    function delete_multi_type($data)
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE pro_id=? AND prot_id=?";
        $stmt = $this->prepare($sql);
        foreach ($data as $prot_id) {
            $stmt->bind_param("ii", $this->getProId(), $prot_id);
            $stmt->execute();
        }
        $stmt->close();
    }

    /**
     * DELETE ALL Type of $pro_id
     *
     * @return bool
     */
    public function deleteAllType()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}