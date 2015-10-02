<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
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

    /**
     * select news_type row where ntype_id = $id
     *
     * @param $id
     * @return array
     */
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

    /**
     * select all news_type row
     *
     * @return array
     */
    public function selectAll()
    {
        $sql = "SELECT * FROM " . $this->getTableName("news_type");
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    /**
     * get all info news_type where news_id (right join news_type_details)
     *
     * @param $news_id
     * @return array
     */
    public function selectNTypeIdByNewsId($news_id)
    {
        $sql = "SELECT ntype_id
                FROM qhn_news_type_details
              WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);

    }

    /**
     * Delete from news_type where ntype_id = $id
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->getTableName("news_type") . " WHERE ntype_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * insert into new row news_type value = $data
     *
     * @param $data
     * @return bool
     */
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

    /**
     *
     *
     * @param $data
     * @param $id
     * @return bool
     */
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