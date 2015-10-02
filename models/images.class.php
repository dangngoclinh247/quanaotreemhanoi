<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/30/2015
 * Time: 12:39 PM
 */

namespace models;

use base;

class Images extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * set column featured = 1 for table images
     *
     * @param $news_id
     * @param $img_id
     * @return bool
     */
    public function setImageNewsFeatured($news_id, $img_id)
    {
        $result = false;
        if ($this->resetImageNewsFeatured($news_id)) {
            $sql = "UPDATE " . $this->getTableName("images") . " SET featured=1 WHERE news_id=? AND img_id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("ii", $news_id, $img_id);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }

    /**
     * set featured  = 0 for all images where news_id = $news_id
     *
     * @param news_id
     * @return bool
     */
    private function resetImageNewsFeatured($news_id)
    {
        $sql = "UPDATE " . $this->getTableName("images") . " SET featured=0 WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * select images row where news_id = $news_id and img_id = $img_id
     *
     * @param $news_id
     * @param $img_id
     * @return array
     */
    public function selectNews($news_id, $img_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("images") . " WHERE news_id=? AND img_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $news_id, $img_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * Select all images where news_id = $news_id
     *
     * @param $news_id
     * @return array()
     */
    public function selectAllNews($news_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("images") . " WHERE news_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * insert image of news
     *
     * @param $data
     * @param $news_id
     * @return bool
     */
    public function insert_news($data, $news_id)
    {
        $sql = "INSERT INTO " . $this->getTableName("images") . "(  news_id,
                                                                    img_url,
                                                                    img_alt,
                                                                    img_description,
                                                                    img_add_date)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("issss", $news_id,
            $data['img_url'],
            $data['img_alt'],
            $data['img_description'],
            date("Y-m-d H:i:s")
        );
        $result = $stmt->execute();
        if ($result != true) {
            $result == $stmt->error;
        }
        $stmt->close();
        return $result;
    }

    /**
     * insert image Products
     *
     * @param $data
     * @param $products_id
     * @return bool
     */
    public function insert_products($data, $products_id)
    {
        $sql = "INSERT INTO " . $this->getTableName("images") . "(  products_id,
                                                                    img_url,
                                                                    img_alt,
                                                                    img_description,
                                                                    img_add_date)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("isss",
            $products_id,
            $data['img_url'],
            $data['img_alt'],
            $data['img_description'],
            date("Y-m-d H:i:s")
        );
        $result = $stmt->execute();
        if ($result != true) {
            $result == $stmt->error;
        }
        $stmt->close();
        return $result;
    }
}