<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/9/2015
 * Time: 11:01 AM
 */

namespace models;


use base\Models;

class News_Type_Details extends Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "news_type_details";

    private $_news_id;
    private $_ntype_id;

    /**
     * @return mixed
     */
    public function getNewsId()
    {
        return $this->_news_id;
    }

    /**
     * @param mixed $news_id
     */
    public function setNewsId($news_id)
    {
        $this->_news_id = $news_id;
    }

    /**
     * @return mixed
     */
    public function getNtypeId()
    {
        return $this->_ntype_id;
    }

    /**
     * @param mixed $ntype_id
     */
    public function setNtypeId($ntype_id)
    {
        $this->_ntype_id = $ntype_id;
    }


    public function __construct()
    {
        parent::__construct();

        $this->_news_id = null;
        $this->_ntype_id = null;
    }

    /**
     * Insert new row
     *
     * @return mixed
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(news_id, ntype_id)
                VALUES (?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $this->getNewsId(),
            $this->getNtypeId());
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
        $sql = "INSERT INTO " . self::TABLE_NAME . "(news_id, ntype_id) VALUES (?, ?)";
        $stmt = $this->prepare($sql);
        foreach ($data as $ntype_id) {
            $stmt->bind_param("ii", $this->getNewsId(), $ntype_id);
            $stmt->execute();
        }
        $stmt->close();
    }

    /**
     * Delete row where $_ntype_id and $_news_id
     *
     * @return bool
     */
    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE news_id=? AND ntype_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $this->getNewsId(), $this->getNtypeId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * DELETE Multi data type
     *
     * @param $data
     */
    public function delete_multi_type($data)
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE news_id=? AND ntype_id=?";
        $stmt = $this->prepare($sql);
        foreach ($data as $ntype_id) {
            try {
                $stmt->bind_param("ii", $this->getNewsId(), $ntype_id);
                $stmt->execute();
            } catch (\Exception $e) {

            }
        }
        $stmt->close();
    }

    /**
     * DELETE ALL Type of $news_id
     *
     * @return bool
     */
    public function deleteAllType()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Delete row of news_type_detail where news_id and ntype_id
     *
     * @return bool
     */
    public function delete_news_type()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE ntype_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNtypeId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     *
     * Delete all row where $_news_id
     *
     * @return bool
     */
    public function delete_news()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * get all ntype_id where $news_id
     *
     * @param $news_id
     * @return array() $ntype_id
     */
    public function select_news_type($news_id = "")
    {
        if ($news_id != "") {
            $this->setNewsId($news_id);
        }

        $sql = "SELECT ntype_id FROM " . self::TABLE_NAME . " WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }
}