<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/19/2015
 * Time: 9:18 AM
 */

namespace models;

use base\Models;

class Cart extends Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "cart";

    const STATUS_NOT_CONFIRMED = 1; // chưa xác nhận
    const STATUS_CONFIRMED = 2; // đã xác nhận
    const STATUS_PAID = 3; // Đã thanh toán
    const STATUS_COMPLETE = 4; // Đã giao

    private $_cart_id;
    private $_user_id;
    private $_cart_price;
    private $_cart_notes;
    private $_cart_status;
    private $_cart_add_date;
    private $_cart_update_date;
    private $_cart_ship_date;
    private $_cart_paid_date;

    /**
     * @return null
     */
    public function getCartId()
    {
        return $this->_cart_id;
    }

    /**
     * @param null $cart_id
     */
    public function setCartId($cart_id)
    {
        $this->_cart_id = $cart_id;
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
        $this->_user_id = $user_id;
    }

    /**
     * @return int
     */
    public function getCartPrice()
    {
        return $this->_cart_price;
    }

    /**
     * @param int $cart_price
     */
    public function setCartPrice($cart_price)
    {
        $this->_cart_price = $cart_price;
    }

    /**
     * @return null
     */
    public function getCartNotes()
    {
        return $this->_cart_notes;
    }

    /**
     * @param null $cart_notes
     */
    public function setCartNotes($cart_notes)
    {
        $this->_cart_notes = $cart_notes;
    }

    /**
     * @return int
     */
    public function getCartStatus()
    {
        return $this->_cart_status;
    }

    /**
     * @param int $cart_status
     */
    public function setCartStatus($cart_status)
    {
        $this->_cart_status = $cart_status;
    }

    /**
     * @return bool|string
     */
    public function getCartAddDate()
    {
        return $this->_cart_add_date;
    }

    /**
     * @param bool|string $cart_add_date
     */
    public function setCartAddDate($cart_add_date)
    {
        $this->_cart_add_date = $cart_add_date;
    }

    /**
     * @return bool|string
     */
    public function getCartUpdateDate()
    {
        return $this->_cart_update_date;
    }

    /**
     * @param bool|string $cart_update_date
     */
    public function setCartUpdateDate($cart_update_date)
    {
        $this->_cart_update_date = $cart_update_date;
    }

    /**
     * @return null
     */
    public function getCartShipDate()
    {
        return $this->_cart_ship_date;
    }

    /**
     * @param null $cart_ship_date
     */
    public function setCartShipDate($cart_ship_date)
    {
        $this->_cart_ship_date = $cart_ship_date;
    }

    /**
     * @return mixed
     */
    public function getCartPaidDate()
    {
        return $this->_cart_paid_date;
    }

    /**
     * @param mixed $cart_paid_date
     */
    public function setCartPaidDate($cart_paid_date)
    {
        $this->_cart_paid_date = $cart_paid_date;
    }



    public function __construct()
    {
        parent::__construct();

        $this->_cart_id = null;
        $this->_user_id = null;
        $this->_cart_price = 0;
        $this->_cart_notes = null;
        $this->_cart_status = self::STATUS_NOT_CONFIRMED;
        $this->_cart_add_date = date("Y-m-d H:i:s");
        $this->_cart_update_date = date("Y-m-d H:i:s");
        $this->_cart_ship_date = null;
        $this->_cart_paid_date = null;
    }

    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(
                                                        user_id,
                                                        cart_price,
                                                        cart_notes,
                                                        cart_status,
                                                        cart_add_date,
                                                        cart_update_date,
                                                        cart_ship_date,
                                                        cart_paid_date
                                                        )
                VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iisissss",
            $this->getUserId(),
            $this->getCartPrice(),
            $this->getCartNotes(),
            $this->getCartStatus(),
            $this->getCartAddDate(),
            $this->getCartUpdateDate(),
            $this->getCartShipDate(),
            $this->getCartPaidDate()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET user_id=?,
                                      cart_price=?,
                                      cart_notes=?,
                                      cart_status=?,
                                      cart_add_date=?,
                                      cart_update_date=?,
                                      cart_ship_date=?,
                                      cart_paid_date=?
                                      WHERE cart_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("iisissssi",
            $this->getUserId(),
            $this->getCartPrice(),
            $this->getCartNotes(),
            $this->getCartStatus(),
            $this->getCartAddDate(),
            $this->getCartUpdateDate(),
            $this->getCartShipDate(),
            $this->getCartPaidDate(),
            $this->getCartId()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE cart_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getCartId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function select_all($start, $stop)
    {
        $sql = "SELECT c.*, u.user_name, u. FROM " . self::TABLE_NAME . " c,
                                " . Users::TABLE_NAME . " u
                WHERE c.user_id = u.user_id
                ORDER BY c.cart_id DESC
                LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    public function select_all_count()
    {
        $sql = "SELECT count(*) as totalItem FROM " . self::TABLE_NAME . " c,
                                " . Users::TABLE_NAME . " u
                WHERE c.user_id = u.user_id";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc()['totalItem'];
    }

    public function select()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE cart_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getCartId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
}