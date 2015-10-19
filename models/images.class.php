<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/30/2015
 * Time: 12:39 PM
 */

namespace models;

use base;

class Images extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "images";

    const FEATURED_YES = 1;
    const FEATURED_NO = 0;

    private $_img_id;
    private $_news_id;
    private $_pro_id;
    private $_img_url;
    private $_img_alt;
    private $_img_description;
    private $_img_add_date;
    private $_featured;

    /**
     * @return mixed
     */
    public function getImgId()
    {
        return $this->_img_id;
    }

    /**
     * @param mixed $img_id
     */
    public function setImgId($img_id)
    {
        $this->_img_id = $this->trim($img_id);
    }

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
        $this->_news_id = $this->trim($news_id);
    }

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
    public function getImgUrl()
    {
        return $this->_img_url;
    }

    /**
     * @param mixed $img_url
     */
    public function setImgUrl($img_url)
    {
        $this->_img_url = $this->trim($img_url);
    }

    /**
     * @return mixed
     */
    public function getImgAlt()
    {
        return $this->_img_alt;
    }

    /**
     * @param mixed $img_alt
     */
    public function setImgAlt($img_alt)
    {
        $this->_img_alt = $this->trim($img_alt);
    }

    /**
     * @return mixed
     */
    public function getImgDescription()
    {
        return $this->_img_description;
    }

    /**
     * @param mixed $img_description
     */
    public function setImgDescription($img_description)
    {
        $this->_img_description = $this->trim($img_description);
    }

    /**
     * @return mixed
     */
    public function getImgAddDate()
    {
        return $this->_img_add_date;
    }

    /**
     * @param mixed $img_add_date
     */
    public function setImgAddDate($img_add_date)
    {
        $date = new \DateTime($img_add_date);
        $this->_img_add_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return mixed
     */
    public function getFeatured()
    {
        return $this->_featured;
    }

    /**
     * @param mixed $featured
     */
    public function setFeatured($featured)
    {
        if ($featured == self::FEATURED_NO
            || $featured == self::FEATURED_YES
        ) {
            $this->_featured = $featured;
        }
    }


    public function __construct()
    {
        parent::__construct();

        $this->_news_id = null;
        $this->_pro_id = null;
        $this->_img_url = null;
        $this->_img_alt = null;
        $this->_img_description = null;
        $this->_img_add_date = date("Y-m-d H:i:s");
        $this->_featured = self::FEATURED_NO;
    }

    /**
     * insert image of news
     *
     * @return bool
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(  news_id,
                                                        pro_id,
                                                        img_url,
                                                        img_alt,
                                                        img_description,
                                                        img_add_date)
                VALUES (?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iissss",
            $this->getNewsId(),
            $this->getProId(),
            $this->getImgUrl(),
            $this->getImgAlt(),
            $this->getImgDescription(),
            $this->getImgAddDate()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * select images row where news_id = $news_id and img_id = $img_id
     * @param $img_id
     * @return array
     */
    public function select($img_id = null)
    {
        if ($img_id != null) {
            $this->setImgId($img_id);
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getImgId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * select images row where news_id = $news_id and img_id = $img_id
     * @param $news_id
     * @return array
     */
    public function selectNewsFeatured($news_id = null)
    {
        if ($news_id != null) {
            $this->setNewsId($news_id);
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE news_id=? AND featured=" . self::FEATURED_YES;
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * set column featured = FEATURED_YES for table images
     *
     * @return bool
     */
    public function featured()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET featured=" . self::FEATURED_YES . " WHERE img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getImgId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * RESET FEATURED = no for img_id
     *
     * @return bool
     */
    public function resetFeatured()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET featured=" . self::FEATURED_NO . " WHERE img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getImgId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * set featured  = 0 for all images where news_id = $news_id
     *
     * @return bool
     */
    public function resetNewsFeatured()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET featured=" . self::FEATURED_NO . " WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Select all images where news_id = $news_id
     * @param $featured
     * @return array()
     */
    public function selectAllNews($featured = false)
    {
        if ($featured == false) {
            $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE news_id=?";
        } else {
            $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE news_id=? AND featured=" . self::FEATURED_YES;
        }
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        if ($featured == true) {
            return $result->fetch_assoc();
        }
        return $this->fetch_assoc_all($result);
    }

    /**
     * Select All images Where $pro_id and $featured = 0|1
     *
     * @param $featured
     * @return array
     */
    public function selectAllProducts($featured = false)
    {
        if ($featured == false) {
            $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE pro_id=?";
        } else {
            $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE pro_id=? AND featured=" . self::FEATURED_YES;
        }
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * SELECT * FROM images where $pro_id and $img_id
     *
     * @param $pro_id
     * @param $img_id
     * @return array
     */
    public function selectProducts($pro_id, $img_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("images") . " WHERE pro_id=? AND img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $pro_id, $img_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT ALL Featured of Products
     *
     * @return array
     */
    public function selectProductsFeatured()
    {
        $sql = "SELECT * FROM " . $this->getTableName("images") . " WHERE pro_id=? AND featured=" . self::FEATURED_YES;
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * SET featured = 1 Where $pro_id and $img_id
     *
     * @param $pro_id
     * @param $img_id
     * @return bool
     */
    public function setProductsFeatured($pro_id, $img_id)
    {
        $sql = "UPDATE " . $this->getTableName("images") . " SET featured=1 WHERE pro_id=? AND img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $pro_id, $img_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * SET featured = 0 WHERE $pro_id AND $img_id
     *
     * @param $pro_id
     * @param $img_id
     * @return bool
     */
    public function unsetProductsFeatured($pro_id, $img_id)
    {
        $sql = "UPDATE " . $this->getTableName("images") . " SET featured=0 WHERE pro_id=? AND img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $pro_id, $img_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}