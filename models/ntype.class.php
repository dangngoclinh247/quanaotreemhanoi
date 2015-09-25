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

    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("news_type");
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function insert($data)
    {

        $sql = "INSERT INTO " . $this->getTableName("news_type") . "(ntype_id,
                                                                    ntype_name,
                                                                    ntype_slug,
                                                                    ntype_seo_title,
                                                                    ntype_seo_description,
                                                                    ntype_add_date,
                                                                    ntype_parent_id)
                VALUES (NULL ,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssi",
            $data['ntype_name'],
            $data['ntype_slug'],
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

    public function insertNonParentId($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("news_type") . "(ntype_id,
                                                                    ntype_name,
                                                                    ntype_slug,
                                                                    ntype_seo_title,
                                                                    ntype_seo_description,
                                                                    ntype_add_date,
                                                                    ntype_parent_id)
                VALUES (NULL ,?,?,?,?,?,NULL)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssss",
            $data['ntype_name'],
            $data['ntype_slug'],
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