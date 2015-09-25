<?php
/**
 * Created by PhpStorm.
 * User: TruongHung
 * Date: 9/24/2015
 * Time: 11:28 AM
 */

namespace models;

use base;
class users_roles extends base\models
{

    public function __construct()
    {
        parent::__construct();
    }
    public function delete($id)
    {

    }

    public function update($data, $id)
    {
        // TODO: Implement update() method.
    }

    public function insert($data)
    {
        // TODO: Implement insert() method.
    }

    public function select($id)
    {
        // TODO: Implement select() method.
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("users_roles");
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }
}