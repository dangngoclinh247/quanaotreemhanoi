<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/26/2015
 * Time: 1:56 PM
 */

namespace models;

use base;

class Products_Tag extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "products_tag";

    private $_ptag_id;
    private $_ptag_name;
    private $_ptag_slug;
    private $_ptag_content;
    private $_ptag_seo_title;
    private $_ptag_seo_description;
    private $_ptag_add_date;

    /**
     * @return mixed
     */
    public function getPtagId()
    {
        return $this->_ptag_id;
    }

    /**
     * @param mixed $ptag_id
     */
    public function setPtagId($ptag_id)
    {
        $this->_ptag_id = $ptag_id;
    }

    /**
     * @return mixed
     */
    public function getPtagName()
    {
        return $this->_ptag_name;
    }

    /**
     * @param mixed $ptag_name
     */
    public function setPtagName($ptag_name)
    {
        $this->_ptag_name = $this->trim($ptag_name);
    }

    /**
     * @return mixed
     */
    public function getPtagSlug()
    {
        return $this->_ptag_slug;
    }

    /**
     * @param mixed $ptag_slug
     */
    public function setPtagSlug($ptag_slug)
    {
        $this->_ptag_slug = $this->trim($ptag_slug);
    }

    /**
     * @return mixed
     */
    public function getPtagContent()
    {
        return $this->_ptag_content;
    }

    /**
     * @param mixed $ptag_content
     */
    public function setPtagContent($ptag_content)
    {
        $this->_ptag_content = $this->trim($ptag_content);
    }

    /**
     * @return mixed
     */
    public function getPtagSeoTitle()
    {
        return $this->_ptag_seo_title;
    }

    /**
     * @param mixed $ptag_seo_title
     */
    public function setPtagSeoTitle($ptag_seo_title)
    {
        $this->_ptag_seo_title = $this->trim($ptag_seo_title);
    }

    /**
     * @return mixed
     */
    public function getPtagSeoDescription()
    {
        return $this->_ptag_seo_description;
    }

    /**
     * @param mixed $ptag_seo_description
     */
    public function setPtagSeoDescription($ptag_seo_description)
    {
        $this->_ptag_seo_description = $this->trim($ptag_seo_description);
    }

    /**
     * @return mixed
     */
    public function getPtagAddDate()
    {
        return $this->_ptag_add_date;
    }

    /**
     * @param mixed $ptag_add_date
     */
    public function setPtagAddDate($ptag_add_date)
    {
        $date = new \DateTime($ptag_add_date);
        $this->_ptag_add_date = $date->format("Y-m-d H:i:s");
    }

    public function __construct()
    {
        parent::__construct();

        $this->_ptag_id = null;
        $this->_ptag_name = null;
        $this->_ptag_slug = null;
        $this->_ptag_seo_title = null;
        $this->_ptag_seo_description = null;
        $this->_ptag_add_date = date("Y-m-d H:i:s");
    }

    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(ptag_id,
                                                        ptag_name,
                                                        ptag_slug,
                                                        ptag_content,
                                                        ptag_seo_title,
                                                        ptag_seo_description,
                                                        ptag_add_date)
                VALUES (NULL ,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssss",
            $this->getPtagName(),
            $this->getPtagSlug(),
            $this->getPtagContent(),
            $this->getPtagSeoTitle(),
            $this->getPtagSeoDescription(),
            $this->getPtagAddDate()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function select($ptag_id = null)
    {
        if($ptag_id != null)
        {
            $this->setPtagId($ptag_id);
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE ptag_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getPtagId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function selectAllLimit($start, $stop)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY ptag_id DESC LIMIT ?,?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    public function selectAllCount()
    {
        $sql = "SELECT count(*) as totalItem FROM " . self::TABLE_NAME;
        $result = $this->query($sql);
        $result = $result->fetch_assoc();
        return $result['totalItem'];
    }

    public function update()
    {
        $result = false;
        if($this->getPtagId() != null) {
            $sql = "UPDATE " . self::TABLE_NAME . " SET ptag_name=?,
                                                    ptag_slug=?,
                                                    ptag_content=?,
                                                    ptag_seo_title=?,
                                                    ptag_seo_description=?
                                                 WHERE ptag_id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssssi",
                $this->getPtagName(),
                $this->getPtagSlug(),
                $this->getPtagContent(),
                $this->getPtagSeoTitle(),
                $this->getPtagSeoDescription(),
                $this->getPtagId()
            );
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }

    /**
     * DELETE products_tag row
     *
     * @return bool
     */
    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE ptag_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getPtagId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Search item WHERE $keyword
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
                WHERE LOWER(ptag_name) LIKE LOWER(?) OR
                        LOWER(ptag_slug) LIKE LOWER(?) OR
                        LOWER(ptag_content) LIKE LOWER(?) OR
                        LOWER(ptag_seo_title) LIKE LOWER(?) OR
                        LOWER(ptag_name) LIKE LOWER(?)
                ORDER BY ptag_id DESC LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii",
            $keyword,
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
     * Return totalItem in search
     *
     * @param $keyword
     * @return mixed
     */
    public function searchCount($keyword)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT  count(*) as totalItem
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(ptag_name) LIKE LOWER(?) OR
                        LOWER(ptag_slug) LIKE LOWER(?) OR
                        LOWER(ptag_content) LIKE LOWER(?) OR
                        LOWER(ptag_seo_title) LIKE LOWER(?) OR
                        LOWER(ptag_name) LIKE LOWER(?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssss",
            $keyword,
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