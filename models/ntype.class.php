<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/25/2015
 * Time: 1:02 PM
 */

namespace models;

use base;

class Ntype extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "news_type";

    private $_ntype_id;
    private $_ntype_name;
    private $_ntype_slug;
    private $_ntype_content;
    private $_ntype_seo_title;
    private $_ntype_seo_description;
    private $_ntype_add_date;
    private $_ntype_parent_id;

    /**
     * @return null
     */
    public function getNtypeId()
    {
        return $this->_ntype_id;
    }

    /**
     * @param null $ntype_id
     */
    public function setNtypeId($ntype_id)
    {
        $this->_ntype_id = $this->trim(intval($ntype_id));
    }

    /**
     * @return null
     */
    public function getNtypeName()
    {
        return $this->_ntype_name;
    }

    /**
     * @param null $ntype_name
     */
    public function setNtypeName($ntype_name)
    {
        $this->_ntype_name = $this->trim($ntype_name);
    }

    /**
     * @return null
     */
    public function getNtypeSlug()
    {
        return $this->_ntype_slug;
    }

    /**
     * @param null $ntype_slug
     */
    public function setNtypeSlug($ntype_slug)
    {
        $this->_ntype_slug = $this->trim($ntype_slug);
    }

    /**
     * @return null
     */
    public function getNtypeContent()
    {
        return $this->_ntype_content;
    }

    /**
     * @param null $ntype_content
     */
    public function setNtypeContent($ntype_content)
    {
        $this->_ntype_content = $this->trim($ntype_content);
    }

    /**
     * @return null
     */
    public function getNtypeSeoTitle()
    {
        return $this->_ntype_seo_title;
    }

    /**
     * @param null $ntype_seo_title
     */
    public function setNtypeSeoTitle($ntype_seo_title)
    {
        $this->_ntype_seo_title = $this->trim($ntype_seo_title);
    }

    /**
     * @return null
     */
    public function getNtypeSeoDescription()
    {
        return $this->_ntype_seo_description;
    }

    /**
     * @param null $ntype_seo_description
     */
    public function setNtypeSeoDescription($ntype_seo_description)
    {
        $this->_ntype_seo_description = $this->trim($ntype_seo_description);
    }

    /**
     * @return bool|string
     */
    public function getNtypeAddDate()
    {
        return $this->_ntype_add_date;
    }

    /**
     * @param bool|string $ntype_add_date
     */
    public function setNtypeAddDate($ntype_add_date)
    {
        $date = new \DateTime($ntype_add_date);
        $this->_ntype_add_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return null
     */
    public function getNtypeParentId()
    {
        return $this->_ntype_parent_id;
    }

    /**
     * @param null $ntype_parent_id
     */
    public function setNtypeParentId($ntype_parent_id)
    {
        $this->_ntype_parent_id = $this->trim($ntype_parent_id);
    }

    public function __construct()
    {
        parent::__construct();

        $this->_ntype_id = null;
        $this->_ntype_name = null;
        $this->_ntype_slug = null;
        $this->_ntype_content = null;
        $this->_ntype_seo_title = null;
        $this->_ntype_seo_description = null;
        $this->_ntype_add_date = date("Y-m-d H:i:s");
        $this->_ntype_parent_id = null;
    }

    /**
     * insert into new row news_type
     *
     * @return bool
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(ntype_id,
                                                                    ntype_name,
                                                                    ntype_slug,
                                                                    ntype_content,
                                                                    ntype_seo_title,
                                                                    ntype_seo_description,
                                                                    ntype_add_date,
                                                                    ntype_parent_id)
                VALUES (NULL ,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssssi", $this->getNtypeName(),
            $this->getNtypeSlug(),
            $this->getNtypeContent(),
            $this->getNtypeSeoTitle(),
            $this->getNtypeSeoDescription(),
            $this->getNtypeAddDate(),
            $this->getNtypeParentId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     *  UPDATE
     *
     * @return bool
     */
    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET ntype_name=?,
                                        ntype_slug=?,
                                        ntype_content=?,
                                        ntype_seo_title=?,
                                        ntype_seo_description=?,
                                        ntype_parent_id=?
                                      WHERE ntype_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii",
            $this->getNtypeName(),
            $this->getNtypeSlug(),
            $this->getNtypeContent(),
            $this->getNtypeSeoTitle(),
            $this->getNtypeSeoDescription(),
            $this->getNtypeParentId(),
            $this->getNtypeId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Delete from news_type where $_ntype_id
     *
     * @return bool
     */
    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE ntype_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNtypeId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * select news_type row where $_ntype_id
     *
     * @return array
     */
    public function select($ntype_id = "")
    {
        if($ntype_id != "")
        {
            $this->setNtypeId($ntype_id);
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE ntype_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNtypeId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * select all news_type row
     *
     * @return array
     */
    public function selectAll()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY ntype_id DESC";
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    /**
     * get all info news_type where news_id (right join news_type_details)
     *
     * @param $news_id
     * @return array
     */
    public function selectNTypeIdByNewsId($news_id)
    {
        $sql = "SELECT ntype_id
                FROM qhn_news_type_details
              WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Search width $keyword
     *
     * @param $keyword
     * @param $start
     * @param $stop
     * @return array
     */
    public function search($keyword, $start, $stop)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT *
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(ntype_name) LIKE LOWER(?) OR
                        LOWER(ntype_slug) LIKE LOWER(?) OR
                        LOWER(ntype_seo_title) LIKE LOWER(?) OR
                        LOWER(ntype_seo_description) LIKE LOWER(?)
                ORDER BY ntype_id DESC LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssii",
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Return COUNT of search()
     *
     * @param $keyword
     * @return mixed
     */
    public function searchCount($keyword)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT count(*) as totalItem
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(ntype_name) LIKE LOWER(?) OR
                        LOWER(ntype_slug) LIKE LOWER(?) OR
                        LOWER(ntype_seo_title) LIKE LOWER(?) OR
                        LOWER(ntype_seo_description) LIKE LOWER(?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssss",
            $keyword,
            $keyword,
            $keyword,
            $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        return $result['totalItem'];
    }
}