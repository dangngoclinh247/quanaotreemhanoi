<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/19/2015
 * Time: 10:34 PM
 */

namespace models;

use base\Models;

class Contact extends Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "contact";

    private $_contact_id;
    private $_user_id;
    private $_contact_name;
    private $_contact_email;
    private $_contact_phone;
    private $_contact_content;
    private $_contact_add_date;
    private $_contact_view;

    /**
     * @return mixed
     */
    public function getContactId()
    {
        return $this->_contact_id;
    }

    /**
     * @param mixed $contact_id
     */
    public function setContactId($contact_id)
    {
        $this->_contact_id = $contact_id;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = $user_id;
    }

    /**
     * @return mixed
     */
    public function getContactName()
    {
        return $this->_contact_name;
    }

    /**
     * @param mixed $contact_name
     */
    public function setContactName($contact_name)
    {
        $this->_contact_name = $contact_name;
    }

    /**
     * @return mixed
     */
    public function getContactEmail()
    {
        return $this->_contact_email;
    }

    /**
     * @param mixed $contact_email
     */
    public function setContactEmail($contact_email)
    {
        $this->_contact_email = $contact_email;
    }

    /**
     * @return mixed
     */
    public function getContactPhone()
    {
        return $this->_contact_phone;
    }

    /**
     * @param mixed $contact_phone
     */
    public function setContactPhone($contact_phone)
    {
        $this->_contact_phone = $contact_phone;
    }

    /**
     * @return mixed
     */
    public function getContactContent()
    {
        return $this->_contact_content;
    }

    /**
     * @param mixed $contact_content
     */
    public function setContactContent($contact_content)
    {
        $this->_contact_content = $contact_content;
    }

    /**
     * @return mixed
     */
    public function getContactAddDate()
    {
        return $this->_contact_add_date;
    }

    /**
     * @param mixed $contact_add_date
     */
    public function setContactAddDate($contact_add_date)
    {
        $this->_contact_add_date = $contact_add_date;
    }

    /**
     * @return mixed
     */
    public function getContactView()
    {
        return $this->_contact_view;
    }

    /**
     * @param mixed $contact_view
     */
    public function setContactView($contact_view)
    {
        $this->_contact_view = $contact_view;
    }

    public function __construct()
    {
        parent::__construct();

        $this->_contact_id = null;
        $this->_user_id = null;
        $this->_contact_name = null;
        $this->_contact_email = null;
        $this->_contact_phone = null;
        $this->_contact_content = null;
        $this->_contact_add_date = date("Y-m-d H:i:s");
        $this->_contact_view = 0;
    }

    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(user_id,
                                                    contact_name,
                                                    contact_email,
                                                    contact_phone,
                                                    contact_content,
                                                    contact_add_date)
        VALUES (?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("isssss",
            $this->getUserId(),
            $this->getContactName(),
            $this->getContactEmail(),
            $this->getContactPhone(),
            $this->getContactContent(),
            $this->getContactAddDate()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE contact_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getContactId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function update_view()
    {
        $sql = "UPDATE " . self::TABLE_NAME . " SET contact_view=contact_view+1 WHERE contact_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getContactId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function select()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE contact_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getContactId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function select_all($start, $stop)
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " c,
                            LEFT JOIN " . Users::TABLE_NAME . " u ON c.user_id=u.user_id
                            ORDER BY contact_id DESC
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
        $sql = "SELECT count(*) as totalItem FROM " . self::TABLE_NAME . " c";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc()['totalItem'];
    }

    public function select_all_unview()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " c,
                            LEFT JOIN " . Users::TABLE_NAME . " u ON c.user_id=u.user_id
                            WHERE c.contact_view=0
                            ORDER BY contact_id DESC
                            LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    public function select_all_unview_count()
    {
        $sql = "SELECT count(*) as totalItem FROM " . self::TABLE_NAME . " c,
                            LEFT JOIN " . Users::TABLE_NAME . " u ON c.user_id=u.user_id
                            WHERE c.contact_view=0";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc()['totalItem'];
    }
}