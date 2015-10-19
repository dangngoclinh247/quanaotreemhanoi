<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/2/2015
 * Time: 9:04 PM
 */

namespace models;

use base;
use library\Func;

class Brand extends base\Models
{

    const TABLE_NAME = DB_TABLE_PREFIX . "products_brand";

    private $_brand_id;
    private $_brand_name;
    private $_brand_slug;
    private $_brand_content;
    private $_brand_seo_title;
    private $_brand_seo_description;
    private $_brand_add_date;
    private $_brand_update_date;

    /**
     * @return null
     */
    public function getBrandId()
    {
        return $this->_brand_id;
    }

    /**
     * @param null $brand_id
     */
    public function setBrandId($brand_id)
    {
        $this->_brand_id = $this->trim($brand_id);
    }

    /**
     * @return null
     */
    public function getBrandName()
    {
        return $this->_brand_name;
    }

    /**
     * @param null $brand_name
     */
    public function setBrandName($brand_name)
    {
        $this->_brand_name = $this->trim($brand_name);
    }

    /**
     * @return mixed
     */
    public function getBrandSlug()
    {
        return $this->_brand_slug;
    }

    /**
     *
     * @param mixed $brand_slug
     * @param bool $setup
     */
    public function setBrandSlug($brand_slug, $setup = false)
    {
        $this->_brand_slug = $this->trim($brand_slug);
        if($setup)
        {
            if ($this->_brand_slug != null) {
                $this->_brand_slug = Func::getSlug($this->_brand_slug);
            } else if ($this->_brand_name != null) {
                $this->_brand_slug = Func::getSlug($this->_brand_name);
            }
        }
    }

    /**
     * @return null
     */
    public function getBrandContent()
    {
        return $this->_brand_content;
    }

    /**
     * @param null $brand_content
     */
    public function setBrandContent($brand_content)
    {
        $this->_brand_content = $this->trim($brand_content);
    }

    /**
     * @return null
     */
    public function getBrandSeoTitle()
    {
        return $this->_brand_seo_title;
    }

    /**
     * @param null $brand_seo_title
     */
    public function setBrandSeoTitle($brand_seo_title)
    {
        $this->_brand_seo_title = $this->trim($brand_seo_title);
    }

    /**
     * @return null
     */
    public function getBrandSeoDescription()
    {
        return $this->_brand_seo_description;
    }

    /**
     * @param null $brand_seo_description
     */
    public function setBrandSeoDescription($brand_seo_description)
    {
        $this->_brand_seo_description = $this->trim($brand_seo_description);
    }

    /**
     * @return bool|string
     */
    public function getBrandAddDate()
    {
        return $this->_brand_add_date;
    }

    /**
     * @param bool|string $brand_add_date
     */
    public function setBrandAddDate($brand_add_date)
    {
        $date = new \DateTime($brand_add_date);
        $this->_brand_add_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return bool|string
     */
    public function getBrandUpdateDate()
    {
        return $this->_brand_update_date;
    }

    /**
     * @param bool|string $brand_update_date
     */
    public function setBrandUpdateDate($brand_update_date)
    {
        $date = new \DateTime($brand_update_date);
        $this->_brand_update_date = $date->format("Y-m-d H:i:s");
    }


    public function __construct($tableName = "")
    {
        parent::__construct();

        $this->_brand_id = null;
        $this->_brand_name = null;
        $this->_brand_content = null;
        $this->_brand_seo_title = null;
        $this->_brand_seo_description = null;
        $this->_brand_add_date = date("Y-m-d H:i:s");
        $this->_brand_update_date = date("Y-m-d H:i:s");

    }

    /**
     * INSERT new rows to products_brand
     *
     * @return number (insert_id) || false
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(brand_id,
                                                brand_name,
                                                brand_slug,
                                                brand_content,
                                                brand_seo_title,
                                                brand_seo_description,
                                                brand_add_date,
                                                brand_update_date
                                              )
                            VALUES (NULL,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssss",
                                    $this->getBrandName(),
                                    $this->getBrandSlug(),
                                    $this->getBrandContent(),
                                    $this->getBrandSeoTitle(),
                                    $this->getBrandSeoDescription(),
                                    $this->getBrandAddDate(),
                                    $this->getBrandUpdateDate()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * UPDATE products_brand
     *
     * @return bool
     */
    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET brand_name=?,
                                                    brand_slug=?,
                                                    brand_content=?,
                                                    brand_seo_title=?,
                                                    brand_seo_description=?,
                                                    brand_update_date=?
                                                WHERE brand_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssssi", $this->getBrandName(),
                                    $this->getBrandSlug(),
                                    $this->getBrandContent(),
                                    $this->getBrandSeoTitle(),
                                    $this->getBrandSeoDescription(),
                                    $this->getBrandUpdateDate(),
                                    $this->getBrandId());
        return $stmt->execute();
    }

    /**
     * SELECT * brand row where $brand_id
     *
     * @param $brand_id
     * @return array
     */
    public function select($brand_id = null)
    {
        if($brand_id == null)
        {
            $brand_id = $this->getBrandId();
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE brand_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * select products brand row where $brand_name
     *
     * @return array
     */
    public function selectByName()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE brand_name=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $this->getBrandName());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * select products brand row where $brand_name but different $brand_id
     *
     * @return array
     */
    public function selectByNameDiffID()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE brand_name=? AND brand_id<>?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("si", $this->getBrandName(), $this->getBrandId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT ALL products_brand
     *
     * @return array
     */
    public function selectAll()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY brand_id DESC";
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    /**
     * Delete from products brand where $brand_id
     *
     * @param $brand_id
     * @return bool
     */
    public function delete($brand_id)
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE brand_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * return all rows match $keyword
     *
     * @param $keyword
     * @param int $start
     * @param int $stop
     * @return array
     */
    public function search($keyword, $start = 0, $stop = 25)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT *
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(brand_name) LIKE LOWER(?) OR
                        LOWER(brand_content) LIKE LOWER(?) OR
                        LOWER(brand_seo_title) LIKE LOWER(?) OR
                        LOWER(brand_seo_description) LIKE LOWER(?)
                ORDER BY pro_id DESC LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssii",  $keyword,
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
     * Return total row of search
     *
     * @param $keyword
     * @return mixed
     */
    public function searchCount($keyword)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT count(*) as totalItem
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(brand_name) LIKE LOWER(?) OR
                        LOWER(brand_content) LIKE LOWER(?) OR
                        LOWER(brand_seo_title) LIKE LOWER(?) OR
                        LOWER(brand_seo_description) LIKE LOWER(?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssss", $keyword, $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        return $result['totalItem'];
    }
}