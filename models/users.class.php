<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/3/2015
 * Time: 10:46 PM
 */
namespace models;

use base;

class Users extends base\Models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "users";

    const ROLES_SUBSCRIBER = 1; //Subscriber
    const ROLES_CONTRIBUTOR = 2; //Contributor
    const ROLES_AUTHOR = 3; //Author
    const ROLES_EDITOR = 4; //Editor
    const ROLES_ADMINISTRATOR = 5; //Administrator
    const ROLES_SUPER_ADMIN = 6; //Super Admin

    private $_user_id;
    private $_user_name;
    private $_user_pass;
    private $_salt;
    private $_user_email;
    private $_img_id;
    private $_user_phone1;
    private $_user_phone2;
    private $_user_address;
    private $_user_add_date;
    private $_user_update_date;
    private $_shipping_id;
    private $_roles_id;

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
    public function getUserName()
    {
        return $this->_user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->_user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getUserPass()
    {
        return $this->_user_pass;
    }

    /**
     * @param mixed $user_pass
     */
    public function setUserPass($user_pass)
    {
        $this->_user_pass = $user_pass;
    }

    /**
     * @return mixed
     */
    public function getSalt()
    {
        return $this->_salt;
    }

    /**
     * @param mixed $salt
     */
    public function setSalt($salt)
    {
        $this->_salt = $salt;
    }

    /**
     * @return mixed
     */
    public function getUserEmail()
    {
        return $this->_user_email;
    }

    /**
     * @param mixed $user_email
     */
    public function setUserEmail($user_email)
    {
        $this->_user_email = $user_email;
    }

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
        $this->_img_id = $img_id;
    }

    /**
     * @return mixed
     */
    public function getUserPhone1()
    {
        return $this->_user_phone1;
    }

    /**
     * @param mixed $user_phone1
     */
    public function setUserPhone1($user_phone1)
    {
        $this->_user_phone1 = $user_phone1;
    }

    /**
     * @return mixed
     */
    public function getUserPhone2()
    {
        return $this->_user_phone2;
    }

    /**
     * @param mixed $user_phone2
     */
    public function setUserPhone2($user_phone2)
    {
        $this->_user_phone2 = $user_phone2;
    }

    /**
     * @return mixed
     */
    public function getUserAddress()
    {
        return $this->_user_address;
    }

    /**
     * @param mixed $user_address
     */
    public function setUserAddress($user_address)
    {
        $this->_user_address = $user_address;
    }

    /**
     * @return mixed
     */
    public function getUserAddDate()
    {
        return $this->_user_add_date;
    }

    /**
     * @param mixed $user_add_date
     */
    public function setUserAddDate($user_add_date)
    {
        $this->_user_add_date = $user_add_date;
    }

    /**
     * @return mixed
     */
    public function getUserUpdateDate()
    {
        return $this->_user_update_date;
    }

    /**
     * @param mixed $user_update_date
     */
    public function setUserUpdateDate($user_update_date)
    {
        $this->_user_update_date = $user_update_date;
    }

    /**
     * @return mixed
     */
    public function getShippingId()
    {
        return $this->_shipping_id;
    }

    /**
     * @param mixed $shipping_id
     */
    public function setShippingId($shipping_id)
    {
        $this->_shipping_id = $shipping_id;
    }

    /**
     * @return mixed
     */
    public function getRolesId()
    {
        return $this->_roles_id;
    }

    /**
     * @param mixed $roles_id
     */
    public function setRolesId($roles_id)
    {
        $this->_roles_id = $roles_id;
    }

    public function __construct()
    {
        parent::__construct();

        $this->_user_id = null;
        $this->_user_name = null;
        $this->_user_pass = null;
        $this->_salt = null;
        $this->_user_email = null;
        $this->_img_id = null;
        $this->_user_phone1 = null;
        $this->_user_phone2 = null;
        $this->_user_address = null;
        $this->_user_add_date = date("Y-m-d H:i:s");
        $this->_user_update_date = date("Y-m-d H:i:s");
        $this->_shipping_id = null;
        $this->_roles_id = self::ROLES_SUBSCRIBER;
    }

    /**
     * Insert into users width $data
     *
     * @return bool
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(
                                                        user_name,
                                                        user_pass,
                                                        salt,
                                                        user_email,
                                                        img_id,
                                                        user_phone1,
                                                        user_phone2,
                                                        user_address,
                                                        user_add_date,
                                                        user_update_date,
                                                        shipping_id,
                                                        roles_id
                                                      )
                      VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssisssssii",
            $this->getUserName(),
            $this->getUserPass(),
            $this->getSalt(),
            $this->getUserEmail(),
            $this->getImgId(),
            $this->getUserPhone1(),
            $this->getUserPhone2(),
            $this->getUserAddress(),
            $this->getUserAddDate(),
            $this->getUserUpdateDate(),
            $this->getShippingId(),
            $this->getRolesId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Delete FROM users Where $user_id
     *
     * @return bool
     */
    public function delete()
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE user_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getUserId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Update users name SET = $data Where $user_id
     *
     * @return bool
     */
    public function update()
    {
        if ($this->getUserPass() == null) {
            $result = $this->update_non_pass();
        } else {
            $sql = "UPDATE " . self::TABLE_NAME . "
                    SET user_name=?,
                        user_pass=?,
                        salt=?,
                        user_email=?,
                        img_id=?,
                        user_phone1=?,
                        user_phone2=?,
                        user_address=?,
                        user_update_date=?,
                        shipping_id=?,
                        roles_id=?
                    WHERE user_id=?";

            $stmt = $this->prepare($sql);
            $stmt->bind_param("ssssissssiii",
                $this->getUserName(),
                $this->getUserPass(),
                $this->getSalt(),
                $this->getUserEmail(),
                $this->getImgId(),
                $this->getUserPhone1(),
                $this->getUserPhone2(),
                $this->getUserAddress(),
                $this->getUserUpdateDate(),
                $this->getShippingId(),
                $this->getRolesId(),
                $this->getUserId());
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }

    /**
     * Update users but non change pass
     *
     * @return bool
     */
    public function update_non_pass()
    {
        $sql = "UPDATE " . self::TABLE_NAME . "
                SET user_name=?,
                    user_email=?,
                    img_id=?,
                    user_phone1=?,
                    user_phone2=?,
                    user_address=?,
                    user_update_date=?,
                    shipping_id=?,
                    roles_id=?
                WHERE user_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssissssiii",
            $this->getUserName(),
            $this->getUserEmail(),
            $this->getImgId(),
            $this->getUserPhone1(),
            $this->getUserPhone2(),
            $this->getUserAddress(),
            $this->getUserUpdateDate(),
            $this->getShippingId(),
            $this->getRolesId(),
            $this->getUserId());
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * SELECT * FROM users where $user_id
     *
     * @return array
     */
    public function select()
    {
        $sql = "SELECT u.*, i.img_url FROM " . self::TABLE_NAME . " u
                LEFT JOIN " . Images::TABLE_NAME . " i ON u.img_id = i.img_id
                WHERE u.user_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getUserId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT * FROM users Where $user_email (check email when register)
     *
     * @return array
     */
    public function select_by_email()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE user_email=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $this->getUserEmail());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT * FROM users Where $user_email and user_id <> $user_id (check email when update users)
     *
     * @return array
     */
    public function select_by_email_not_id()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE user_email=? AND user_id<>?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("si", $this->getUserEmail(), $this->getUserId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * SELECT * FROM users
     *
     * @return array
     */
    public function select_all()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " as users,
                                " . $this->getTableName("users_roles") . " as usersroles
                WHERE users.roles_id = usersroles.roles_id";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * @param $start
     * @param $stop
     * @return array
     */
    public function select_limit($start, $stop)
    {
        $sql = "SELECT users.*, usersroles.roles_name
                FROM " . self::TABLE_NAME . " as users, " . Users_Roles::TABLE_NAME . " as usersroles
                WHERE users.roles_id = usersroles.roles_id
                ORDER BY users.user_id DESC
                LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    public function select_limit_count()
    {
        $sql = "SELECT count(*) as totalItem FROM " . self::TABLE_NAME . " as users,
                                " . Users_Roles::TABLE_NAME . " as usersroles
                WHERE users.roles_id = usersroles.roles_id";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc()["totalItem"];
    }

    /**
     * SELECT * FROM users where $user_email and $user_pass (Process for login page)
     *
     * @return array
     */
    public function select_by_email_and_pass()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE user_email=? AND user_pass=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ss", $this->getUserEmail(), $this->getUserPass());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
}