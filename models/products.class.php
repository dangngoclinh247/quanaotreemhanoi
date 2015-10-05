<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/3/2015
 * Time: 10:46 PM
 */

namespace models;

use base;
class Products extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * insert new products rows
     *
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("products") . "(id,
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
        $stmt->bind_param("ssssssiississii",
            $data['id'],
            $data['pro_name'],
            $data['pro_slug'],
            $data['pro_content'],
            $data['pro_size'],
            $data['pro_size_info'],
            $data['pro_price'],
            $data['pro_quantity'],
            $data['pro_seo_title'],
            $data['pro_seo_description'],
            $data['pro_status'],
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s"),
            $data['user_id'],
            $data['brand_id']
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * SELECT * pro row where $pro_id
     *
     * @param $pro_id
     * @return array
     */
    public function select($pro_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("products") . " WHERE pro_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $pro_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectById($id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("products") . " WHERE id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }
}