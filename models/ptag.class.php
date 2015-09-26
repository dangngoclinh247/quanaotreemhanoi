<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/26/2015
 * Time: 1:56 PM
 */

namespace models;

use base;
class Ptag extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("products_tag") . "(ptag_id,
                                                                    ptag_name,
                                                                    ptag_slug,
                                                                    ptag_content,
                                                                    ptag_seo_title,
                                                                    ptag_seo_description,
                                                                    ptag_add_date)
                VALUES (NULL ,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssss",
            $data['ptag_name'],
            $data['ptag_slug'],
            $data['ptag_content'],
            $data['ptag_seo_title'],
            $data['ptag_seo_description'],
            $data['ptag_add_date']
        );
        $result = $stmt->execute();
        if ($result != true) {
            $result = $this->error;
        }
        $stmt->close();
        return $result;
    }

    public function select($ptag_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("products_tag") . " WHERE ptag_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $ptag_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("products_tag");
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function update($data, $ptag_id)
    {
        $sql = "UPDATE " . $this->getTableName("products_tag") . " SET ptag_name=?,
                                        ptag_slug=?,
                                        prag_content=?,
                                        prag_seo_title=?,
                                        prag_seo_description=?,
                                        prag_parent_id=?
                                      WHERE prag_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii", $data['ptag_name'],
            $data['ptag_slug'],
            $data['prag_content'],
            $data['prag_seo_title'],
            $data['prag_seo_description'],
            $data['prag_parent_id'],
            $ptag_id);
        return $stmt->execute();
    }

    public function delete($ptag_id)
    {
        $sql = "DELETE FROM " . $this->getTableName("products_tag") . " WHERE prag_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $ptag_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }
}