<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/3/2015
 * Time: 10:46 PM
 */

namespace models;

use base;
use library\Func;

class Products extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "products";

    const STATUS_HIDE = 0;
    const STATUS_SHOW = 1;
    const STATUS_TRASH = 3;

    private $_pro_id;
    private $_id;
    private $_pro_name;
    private $_pro_slug;
    private $_pro_content;
    private $_pro_size;
    private $_pro_size_info;
    private $_pro_price;
    private $_pro_quantity;
    private $_pro_seo_title;
    private $_pro_seo_description;
    private $_pro_status; // = 0 | 1
    private $_pro_add_date;
    private $_pro_update_date;
    private $_user_id;
    private $_brand_id;
    private $_pro_rate;
    private $_pro_rating;
    private $_pro_featured;

    /**
     * @return null
     */
    public function getProId()
    {
        return $this->_pro_id;
    }

    /**
     * @param null $pro_id
     */
    public function setProId($pro_id)
    {
        $this->_pro_id = $pro_id;
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->_id = $this->trim($id);
    }

    /**
     * @return null
     */
    public function getProName()
    {
        return $this->_pro_name;
    }

    /**
     * @param null $pro_name
     */
    public function setProName($pro_name)
    {
        $this->_pro_name = $this->trim($pro_name);
    }

    /**
     * @return null
     */
    public function getProSlug()
    {
        return $this->_pro_slug;
    }

    /**
     * @param null $pro_slug
     * @param $setup (if setup = true - create slug)
     */
    public function setProSlug($pro_slug, $setup = false)
    {
        $this->_pro_slug = $this->trim($pro_slug);
        if ($setup) {
            if ($this->_pro_slug != null) {
                $this->_pro_slug = Func::getSlug($this->_pro_slug);
            } else if ($this->_pro_name != null) {
                $this->_pro_slug = Func::getSlug($this->_pro_name);
            }
        }
    }

    /**
     * @return null
     */
    public function getProContent()
    {
        return $this->_pro_content;
    }

    /**
     * @param null $pro_content
     */
    public function setProContent($pro_content)
    {
        $this->_pro_content = $pro_content;
    }

    /**
     * @return null
     */
    public function getProSize()
    {
        return $this->_pro_size;
    }

    /**
     * @param null $pro_size
     */
    public function setProSize($pro_size)
    {
        $this->_pro_size = $this->trim($pro_size);
    }

    /**
     * @return null
     */
    public function getProSizeInfo()
    {
        return $this->_pro_size_info;
    }

    /**
     * @param null $pro_size_info
     */
    public function setProSizeInfo($pro_size_info)
    {
        $this->_pro_size_info = $this->trim($pro_size_info);
    }

    /**
     * @return null
     */
    public function getProPrice()
    {
        return $this->_pro_price;
    }

    /**
     * @param null $pro_price
     */
    public function setProPrice($pro_price)
    {
        $this->_pro_price = $this->trim($pro_price);
    }

    /**
     * @return null
     */
    public function getProQuantity()
    {
        return $this->_pro_quantity;
    }

    /**
     * @param null $pro_quantity
     */
    public function setProQuantity($pro_quantity)
    {
        $this->_pro_quantity = $this->trim($pro_quantity);
    }

    /**
     * @return null
     */
    public function getProSeoTitle()
    {
        return $this->_pro_seo_title;
    }

    /**
     * @param null $pro_seo_title
     */
    public function setProSeoTitle($pro_seo_title)
    {
        $this->_pro_seo_title = $this->trim($pro_seo_title);
    }

    /**
     * @return null
     */
    public function getProSeoDescription()
    {
        return $this->_pro_seo_description;
    }

    /**
     * @param null $pro_seo_description
     */
    public function setProSeoDescription($pro_seo_description)
    {

        $this->_pro_seo_description = $this->trim($pro_seo_description);
    }

    /**
     * @return int
     */
    public function getProStatus()
    {
        return $this->_pro_status;
    }

    /**
     * @param int $pro_status
     */
    public function setProStatus($pro_status)
    {
        $pro_status = trim($pro_status);
        if ($pro_status == self::STATUS_HIDE
            || $pro_status == self::STATUS_SHOW
        ) {
            $this->_pro_status = $pro_status;
        }
        // else $this->_pro_status = self::STATUS_HIDE;
    }

    /**
     * @return null
     */
    public function getProAddDate()
    {
        return $this->_pro_add_date;
    }

    /**
     * @param null $pro_add_date
     */
    public function setProAddDate($pro_add_date)
    {
        $date = new \DateTime($pro_add_date);
        $this->_pro_add_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return null
     */
    public function getProUpdateDate()
    {
        return $this->_pro_update_date;
    }

    /**
     * @param null $pro_update_date
     */
    public function setProUpdateDate($pro_update_date)
    {
        $date = new \DateTime($pro_update_date);
        $this->_pro_update_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return null
     */
    public function getUserId()
    {
        return $this->_user_id;
    }

    /**
     * @param null $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $this->trim($user_id);
    }

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
     * @return mixed
     */
    public function getProRate()
    {
        return $this->_pro_rate;
    }

    /**
     * @param mixed $pro_rate
     */
    public function setProRate($pro_rate)
    {
        $this->_pro_rate = $pro_rate;
    }

    /**
     * @return mixed
     */
    public function getProFeatured()
    {
        return $this->_pro_featured;
    }

    /**
     * @param mixed $pro_featured
     */
    public function setProFeatured($pro_featured)
    {
        if($pro_featured != 1) {
            $this->_pro_featured = 0;
        }
        else
        {
            $this->_pro_featured = 1;
        }
    }


    public function __construct()
    {
        parent::__construct();

        $this->_pro_id = null;
        $this->_id = null;
        $this->_pro_name = null;
        $this->_pro_slug = null;
        $this->_pro_content = null;
        $this->_pro_size = null;
        $this->_pro_size_info = null;
        $this->_pro_price = null;
        $this->_pro_quantity = null;
        $this->_pro_seo_title = null;
        $this->_pro_seo_description = null;
        $this->_pro_status = self::STATUS_HIDE;
        $this->_pro_add_date = date("Y-m-d H:i:s");
        $this->_pro_update_date = date("Y-m-d H:i:s");
        $this->_user_id = null;
        $this->_brand_id = null;
        $this->_pro_rate = null;
        $this->_pro_featured = 0;
    }

    /**
     * insert new products rows
     *
     * @return bool
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(id,
                                                pro_name,
                                                pro_slug,
                                                pro_content,
                                                pro_size,
                                                pro_size_info,
                                                pro_price,
                                                pro_quantity,
                                                pro_seo_title,
                                                pro_seo_description,
                                                pro_status,
                                                pro_add_date,
                                                pro_update_date,
                                                user_id,
                                                brand_id
                                              )
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssisiississii",
            $this->getId(),
            $this->getProName(),
            $this->getProSlug(),
            $this->getProContent(),
            $this->getProSize(),
            $this->getProSizeInfo(),
            $this->getProPrice(),
            $this->getProQuantity(),
            $this->getProSeoTitle(),
            $this->getProSeoDescription(),
            $this->getProStatus(),
            $this->getProAddDate(),
            $this->getProUpdateDate(),
            $this->getUserId(),
            $this->getBrandId()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Update products
     *
     * @return bool
     */
    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET  id=?,
                                                        pro_name=?,
                                                        pro_slug=?,
                                                        pro_content=?,
                                                        pro_size=?,
                                                        pro_size_info=?,
                                                        pro_price=?,
                                                        pro_quantity=?,
                                                        pro_seo_title=?,
                                                        pro_seo_description=?,
                                                        pro_status=?,
                                                        pro_update_date=?,
                                                        brand_id=?
                                                    WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssisiissisii",
            $this->getId(),
            $this->getProName(),
            $this->getProSlug(),
            $this->getProContent(),
            $this->getProSize(),
            $this->getProSizeInfo(),
            $this->getProPrice(),
            $this->getProQuantity(),
            $this->getProSeoTitle(),
            $this->getProSeoDescription(),
            $this->getProStatus(),
            $this->getProUpdateDate(),
            $this->getBrandId(),
            $this->getProId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update_rate()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET  pro_rate=?,
                                                     pro_rating=pro_rating+1
                                                    WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("di",
            $this->getProRate(),
            $this->getProId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update_featured()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET pro_featured=?
                                                    WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("di",
            $this->getProFeatured(),
            $this->getProId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * DELETE products WHERE pro_id
     * @param $shift
     * @return bool
     */
    public function delete($shift = false)
    {
        if ($shift == true) {
            $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE pro_id=?";
        } else {
            $sql = "UPDATE " . self::TABLE_NAME . " SET pro_status=" . self::STATUS_TRASH . " WHERE pro_id=?";
        }
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }


    /**
     * SELECT * pro row where $pro_id
     *
     * @return array
     */
    public function select()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getProId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT products rows by id
     *
     * @return array
     */
    public function selectById()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $this->getId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * @param $prot_id
     * @return array
     */
    public function selectRelated($prot_id = "", $not_in = 1)
    {
        $prot_id = trim($prot_id);
        if($prot_id == "")
        {
            $sql = "SELECT p.*, i.img_url, i.img_alt FROM " . self::TABLE_NAME . " p
                LEFT JOIN " . Images::TABLE_NAME . " i ON p.pro_id=i.pro_id AND featured=1
                ORDER BY RAND()
                LIMIT 10";
        }
        else {
            $sql = "SELECT p.*, i.img_url, i.img_alt FROM " . Products_Type_Details::TABLE_NAME . " d
                JOIN " . self::TABLE_NAME . " p ON p.pro_id=d.pro_id AND d.prot_id IN ({$prot_id}) AND d.prot_id<>{$not_in}
                JOIN " . Images::TABLE_NAME . " i ON p.pro_id=i.pro_id AND featured=1";
        }
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    /**
     * SELECT limit products
     *
     * @param $start
     * @param $stop
     * @param $status = SHOW
     * @return array
     */
    public function selectLimit($start, $stop, $status = self::STATUS_SHOW)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " p LEFT JOIN " . Brand::TABLE_NAME . " b ON p.brand_id=b.brand_id
                WHERE pro_status=?
                ORDER BY pro_id DESC LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iii", $status, $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    public function select_home_limit($start, $stop, $status = self::STATUS_SHOW)
    {
        $sql = "SELECT p.*, i.img_url FROM " . self::TABLE_NAME . " p LEFT JOIN " . Images::TABLE_NAME . " i ON p.pro_id=i.pro_id AND featured=1
                WHERE pro_status = ?
                GROUP BY p.pro_id
                ORDER BY p.pro_id DESC LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iii", $status, $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Count all Products
     * @param $status = SHOW
     * @return mixed
     */
    public function selectLimitCount($status = self::STATUS_SHOW)
    {
        $sql = "SELECT count(*) as totalItem FROM " . self::TABLE_NAME . " WHERE pro_status=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        return $result['totalItem'];
    }

    public function select_featured($limit = 10)
    {
        $status = self::STATUS_SHOW;
        $sql = "SELECT p.*, i.img_url FROM " . self::TABLE_NAME . " p LEFT JOIN " . Images::TABLE_NAME . " i ON p.pro_id=i.pro_id AND featured=1
                WHERE pro_status=? AND pro_featured=?
                GROUP BY p.pro_id
                ORDER BY p.pro_id DESC LIMIT ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iii", $status, $this->getProFeatured(), $limit);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Search products
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
                FROM " . self::TABLE_NAME . " p LEFT JOIN " . Brand::TABLE_NAME . " b ON p.brand_id=b.brand_id
                WHERE LOWER(id) LIKE LOWER(?) OR
                        LOWER(pro_name) LIKE LOWER(?) OR
                        LOWER(pro_slug) LIKE LOWER(?)
                ORDER BY pro_id DESC LIMIT ?, ?";
        ////$sql = "SELECT * FROM " . self::TABLE_NAME . " LIMIT ?, ? ORDER BY pro_id";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssii", $keyword, $keyword, $keyword,
            $start,
            $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Count products in search
     *
     * @param $keyword
     * @return mixed
     */
    public function searchCount($keyword)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT count(*) as totalItem
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(id) LIKE LOWER(?) OR
                        LOWER(pro_name) LIKE LOWER(?) OR
                        LOWER(pro_slug) LIKE LOWER(?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sss", $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        return $result['totalItem'];
    }
}