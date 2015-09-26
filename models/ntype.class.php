<?php
/**
 * Created by PhpStorm.
 * User: TruongHung
 * Date: 9/25/2015
 * Time: 1:02 PM
 */

namespace models;

use base;

class Ntype extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select($id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("news_type") . " WHERE ntype_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("news_type");
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTableName("news_type") . " WHERE ntype_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("news_type") . "(ntype_id,
                                                                    ntype_name,
                                                                    ntype_slug,
                                                                    ntype_content,
                                                                    ntype_seo_title,
                                                                    ntype_seo_description,
                                                                    ntype_add_date,
                                                                    ntype_parent_id)
                VALUES (NULL ,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssssi",
            $data['ntype_name'],
            $data['ntype_slug'],
            $data['ntype_content'],
            $data['ntype_seo_title'],
            $data['ntype_seo_description'],
            $data['ntype_add_date'],
            $data['ntype_parent_id']
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
        $sql = "UPDATE " . $this->getTableName("news_type") . " SET ntype_name=?,
                                        ntype_slug=?,
                                        ntype_content=?,
                                        ntype_seo_title=?,
                                        ntype_seo_description=?,
                                        ntype_parent_id=?
                                      WHERE ntype_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii", $data['ntype_name'],
            $data['ntype_slug'],
            $data['ntype_content'],
            $data['ntype_seo_title'],
            $data['ntype_seo_description'],
            $data['ntype_parent_id'],
            $id);
        return $stmt->execute();
    }

    public function insertNonParentId($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("news_type") . "(ntype_id,
                                                                    ntype_name,
                                                                    ntype_slug,
                                                                    ntype_content,
                                                                    ntype_seo_title,
                                                                    ntype_seo_description,
                                                                    ntype_add_date,
                                                                    ntype_parent_id)
                VALUES (NULL ,?,?,?,?,?,?,NULL)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssss",
            $data['ntype_name'],
            $data['ntype_slug'],
            $data['ntype_content'],
            $data['ntype_seo_title'],
            $data['ntype_seo_description'],
            $data['ntype_add_date']
        );
        $result = $stmt->execute();
        if ($result != true) {
            $result == $stmt->error;
        }
        $stmt->close();
        return $result;
    }
}