<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/27/2015
 * Time: 4:12 PM
 */

namespace models;

use base;

class Products_Type extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "products_type";

    private $_prot_id;
    private $_prot_name;
    private $_prot_slug;
    private $_prot_content;
    private $_prot_seo_title;
    private $_prot_seo_description;
    private $_prot_add_date;
    private $_prot_parent_id;

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

    /**
     * @return mixed
     */
    public function getProtName()
    {
        return $this->_prot_name;
    }

    /**
     * @param mixed $prot_name
     */
    public function setProtName($prot_name)
    {
        $this->_prot_name = $this->trim($prot_name);
    }

    /**
     * @return mixed
     */
    public function getProtSlug()
    {
        return $this->_prot_slug;
    }

    /**
     * @param mixed $prot_slug
     */
    public function setProtSlug($prot_slug)
    {
        $this->_prot_slug = $this->trim($prot_slug);
    }

    /**
     * @return mixed
     */
    public function getProtContent()
    {
        return $this->_prot_content;
    }

    /**
     * @param mixed $prot_content
     */
    public function setProtContent($prot_content)
    {
        $this->_prot_content = $this->trim($prot_content);
    }

    /**
     * @return mixed
     */
    public function getProtSeoTitle()
    {
        return $this->_prot_seo_title;
    }

    /**
     * @param mixed $prot_seo_title
     */
    public function setProtSeoTitle($prot_seo_title)
    {
        $this->_prot_seo_title = $this->trim($prot_seo_title);
    }

    /**
     * @return mixed
     */
    public function getProtSeoDescription()
    {
        return $this->_prot_seo_description;
    }

    /**
     * @param mixed $prot_seo_description
     */
    public function setProtSeoDescription($prot_seo_description)
    {
        $this->_prot_seo_description = $this->trim($prot_seo_description);
    }

    /**
     * @return mixed
     */
    public function getProtAddDate()
    {
        return $this->_prot_add_date;
    }

    /**
     * @param mixed $prot_add_date
     */
    public function setProtAddDate($prot_add_date)
    {
        $date = new \DateTime($prot_add_date);
        $this->_prot_add_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return mixed
     */
    public function getProtParentId()
    {
        return $this->_prot_parent_id;
    }

    /**
     * @param mixed $prot_parent_id
     */
    public function setProtParentId($prot_parent_id)
    {
        $this->_prot_parent_id = $this->trim($prot_parent_id);
    }

    public function __construct()
    {
        parent::__construct();

        $this->_prot_id = null;
        $this->_prot_name = null;
        $this->_prot_content = null;
        $this->_prot_seo_title = null;
        $this->_prot_seo_description = null;
        $this->_prot_add_date = date("Y-m-d H:i:s");
        $this->_prot_parent_id = null;
    }

    /**
     * DELETE row WHERE $_prot_id
     *
     * @return bool
     */
    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE prot_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProtId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * INSERT INTO new row
     *
     * @return bool
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(prot_id,
                                                        prot_name,
                                                        prot_slug,
                                                        prot_content,
                                                        prot_seo_title,
                                                        prot_seo_description,
                                                        prot_add_date,
                                                        prot_parent_id)
                VALUES (NULL ,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssssi",
            $this->getProtName(),
            $this->getProtSlug(),
            $this->getProtContent(),
            $this->getProtSeoTitle(),
            $this->getProtSeoDescription(),
            $this->getProtAddDate(),
            $this->getProtParentId()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * UPDATE row WHERE $_prot_id
     *
     * @return bool
     */
    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET prot_name=?,
                                        prot_slug=?,
                                        prot_content=?,
                                        prot_seo_title=?,
                                        prot_seo_description=?,
                                        prot_parent_id=?
                                      WHERE prot_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii",
            $this->getProtName(),
            $this->getProtSlug(),
            $this->getProtContent(),
            $this->getProtSeoTitle(),
            $this->getProtSeoDescription(),
            $this->getProtParentId(),
            $this->getProtId()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * SELECT WHERE $_prot_id
     *
     * @return array
     */
    public function select()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE prot_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProtId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY prot_id DESC";
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function selectAllLimit($start, $stop)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY prot_id DESC LIMIT ?,?";
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
}