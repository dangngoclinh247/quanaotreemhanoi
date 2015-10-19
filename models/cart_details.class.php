<?php
/**
 * Created by PhpStorm.
 * User: TruongHung
 * Date: 10/19/2015
 * Time: 10:32 AM
 */

namespace models;

use base\Models;

class Cart_Details extends Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "cart_details";

    private $_cdetail_id;
    private $_cart_id;
    private $_pro_id;
    private $_cdetail_size;
    private $_cdetail_quantity;
    private $_cdetail_price;
    private $_cdetail_add_date;
    private $_cdetail_update_date;

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->_cart_id;
    }

    /**
     * @param mixed $cart_id
     */
    public function setCartId($cart_id)
    {
        $this->_cart_id = $cart_id;
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
        $this->_pro_id = $pro_id;
    }

    /**
     * @return mixed
     */
    public function getCdetailQuantity()
    {
        return $this->_cdetail_quantity;
    }

    /**
     * @param mixed $cdetail_quantity
     */
    public function setCdetailQuantity($cdetail_quantity)
    {
        $this->_cdetail_quantity = $cdetail_quantity;
    }

    /**
     * @return mixed
     */
    public function getCdetailPrice()
    {
        return $this->_cdetail_price;
    }

    /**
     * @param mixed $cdetail_price
     */
    public function setCdetailPrice($cdetail_price)
    {
        $this->_cdetail_price = $cdetail_price;
    }

    /**
     * @return mixed
     */
    public function getCdetailAddDate()
    {
        return $this->_cdetail_add_date;
    }

    /**
     * @param mixed $cdetail_add_date
     */
    public function setCdetailAddDate($cdetail_add_date)
    {
        $this->_cdetail_add_date = $cdetail_add_date;
    }

    /**
     * @return mixed
     */
    public function getCdetailUpdateDate()
    {
        return $this->_cdetail_update_date;
    }

    /**
     * @param mixed $cdetail_update_date
     */
    public function setCdetailUpdateDate($cdetail_update_date)
    {
        $this->_cdetail_update_date = $cdetail_update_date;
    }

    /**
     * @return mixed
     */
    public function getCdetailId()
    {
        return $this->_cdetail_id;
    }

    /**
     * @param mixed $cdetail_id
     */
    public function setCdetailId($cdetail_id)
    {
        $this->_cdetail_id = $cdetail_id;
    }

    /**
     * @return null
     */
    public function getCdetailSize()
    {
        return $this->_cdetail_size;
    }

    /**
     * @param null $cdetail_size
     */
    public function setCdetailSize($cdetail_size)
    {
        $this->_cdetail_size = $cdetail_size;
    }

    public function __construct()
    {
        parent::__construct();

        $this->_cdetail_id = null;
        $this->_cart_id = null;
        $this->_pro_id = null;
        $this->_cdetail_size = null;
        $this->_cdetail_quantity = 1;
        $this->_cdetail_price = 0;
        $this->_cdetail_add_date = date("Y-m-d H:i:s");
        $this->_cdetail_update_date = date("Y-m-d H:i:s");
    }

    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(cart_id,
                                                        pro_id,
                                                        cdetail_size,
                                                        cdetail_quantity,
                                                        cdetail_price,
                                                        cdetail_add_date,
                                                        cdetail_update_date)
                VALUES (?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iiiiiss",
            $this->getCartId(),
            $this->getProId(),
            $this->getCdetailSize(),
            $this->getCdetailQuantity(),
            $this->getCdetailPrice(),
            $this->getCdetailAddDate(),
            $this->getCdetailUpdateDate()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET cart_id=?,
                                                    pro_id=?,
                                                    cdetail_size=?,
                                                    cdetail_quantity=?,
                                                    cdetail_price=?,
                                                    cdetail_update_date=?
                                                WHERE cdetail_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iiiiisi",
            $this->getCartId(),
            $this->getProId(),
            $this->getCdetailSize(),
            $this->getCdetailQuantity(),
            $this->getCdetailPrice(),
            $this->getCdetailUpdateDate(),
            $this->getCdetailId()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function select()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " d,
                                " . Products::TABLE_NAME . " p
                WHERE d.pro_id = p.pro_id
                  AND d.cdetail_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getCdetailId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function select_by_cart()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " d,
                                " . Products::TABLE_NAME . " p
                WHERE d.pro_id=p.pro_id
                  AND d.cart_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getCartId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
}