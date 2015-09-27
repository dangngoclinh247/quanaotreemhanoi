<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/27/2015
 * Time: 4:12 PM
 */

namespace models;

use base;

class Prot extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select($id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("products_type") . " WHERE prot_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("products_type");
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTableName("products_type") . " WHERE prot_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("products_type") . "(prot_id,
                                                                    prot_name,
                                                                    prot_slug,
                                                                    prot_content,
                                                                    prot_seo_title,
                                                                    prot_seo_description,
                                                                    prot_add_date,
                                                                    prot_parent_id)
                VALUES (NULL ,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssssi",
            $data['prot_name'],
            $data['prot_slug'],
            $data['prot_content'],
            $data['prot_seo_title'],
            $data['prot_seo_description'],
            $data['prot_add_date'],
            $data['prot_parent_id']
        );
        $result = $stmt->execute();
        if ($result != true) {
            $result == $stmt->error;
        }
        $stmt->close();
        return $result;
    }

    public function update($data, $id)
    {
        $sql = "UPDATE " . $this->getTableName("products_type") . " SET prot_name=?,
                                        prot_slug=?,
                                        prot_content=?,
                                        prot_seo_title=?,
                                        prot_seo_description=?,
                                        prot_parent_id=?
                                      WHERE prot_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii", $data['prot_name'],
            $data['prot_slug'],
            $data['prot_content'],
            $data['prot_seo_title'],
            $data['prot_seo_description'],
            $data['prot_parent_id'],
            $id);
        return $stmt->execute();
    }
}