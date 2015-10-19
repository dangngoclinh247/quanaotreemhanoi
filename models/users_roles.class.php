<?php
/**
 * Created by PhpStorm.
 * User: TruongHung
 * Date: 9/24/2015
 * Time: 11:28 AM
 */

namespace models;

use base;
class Users_Roles extends base\models
{
    const TABLE_NAME = DB_TABLE_PREFIX . "users_roles";

    private $_roles_id;
    private $_roles_name;

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

    /**
     * @return mixed
     */
    public function getRolesName()
    {
        return $this->_roles_name;
    }

    /**
     * @param mixed $roles_name
     */
    public function setRolesName($roles_name)
    {
        $this->_roles_name = $roles_name;
    }


    public function __construct()
    {
        parent::__construct();
    }

    public function select()
    {

    }

    public function select_all()
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME;
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }
}