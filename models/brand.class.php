<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/2/2015
 * Time: 9:04 PM
 */

namespace models;

use base;
class Brand extends base\Models
{

    public function __constrcut()
    {
        parent::__construct();
    }

    /**
     * INSERT new rows to products_brand
     *
     * @param $data
     * @return number (insert_id) || false
     */
    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("products_brand") . "(brand_id,
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
            $data['brand_name'],
            $data['brand_slug'],
            $data['brand_content'],
            $data['brand_seo_title'],
            $data['brand_seo_description'],
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s")
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * UPDATE products_brand SET $data WHERE $brand_id
     *
     * @param $data
     * @param $brand_id
     * @return bool
     */
    public function update($data, $brand_id)
    {
        $sql = "UPDATE " . $this->getTableName("products_brand") . " SET brand_name=?,
                                                                        brand_slug=?,
                                                                        brand_content=?,
                                                                        brand_seo_title=?,
                                                                        brand_seo_description=?,
                                                                        brand_update_date=?
                                                                    WHERE brand_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssi", $data['brand_name'],
            $data['brand_slug'],
            $data['brand_content'],
            $data['brand_seo_title'],
            $data['brand_seo_description'],
            date("Y-m-d H:i:s"),
            $brand_id);
        return $stmt->execute();
    }

    /**
     * SELECT * brand row where $brand_id
     *
     * @param $brand_id
     * @return array
     */
    public function select($brand_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("products_brand") . " WHERE brand_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $brand_id);
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
        $sql = "SELECT * FROM " . $this->getTableName("products_brand");
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
        $sql = "DELETE FROM " . $this->getTableName("products_brand") . " WHERE brand_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $brand_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}