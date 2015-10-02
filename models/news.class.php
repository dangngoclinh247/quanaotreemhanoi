<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/30/2015
 * Time: 12:59 AM
 *
 * News Model
 *
 * @package     quanaotreemhanoi
 * @subpackage  models
 * @author      Liam Dang <liam@dangngoclinh.com>
 */

namespace models;

use base;

class News extends base\Models
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * get image featured = 1 where news_id = $news_id
     *
     * @param $news_id
     * @return array
     */
    public function getImageFeatured($news_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("images") . " WHERE news_id=? AND featured='1'";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     * select news row where news_id = $news_id
     *
     * @param $news_id
     * @return array
     */
    public function select($news_id)
    {
        $sql = "SELECT * FROM " . $this->getTableName("news") . " WHERE news_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    /**
     *
     * Select all news row - join news_type, users, news_type_details
     *
     * @return array
     */
    public function selectall_admin_index()
    {
        $sql = "SELECT *
                FROM
                    (
                        SELECT newsuser.news_id, news_name, news_slug, news_content, news_seo_title,
                        news_seo_description, news_add_date, news_update_date, user_name, ntype_id
                        FROM
                            (
                                SELECT news_id, news_name, news_slug, news_content, news_seo_title,
                                news_seo_description, news_add_date, news_update_date, qhn_news.user_id, user_name
                                FROM qhn_news
                                LEFT JOIN qhn_users ON qhn_news.user_id = qhn_users.user_id
                            ) as newsuser
                        LEFT JOIN qhn_news_type_details
                        ON qhn_news_type_details.news_id = newsuser.news_id
                        UNION
                        SELECT newsuser_1.news_id, news_name, news_slug, news_content, news_seo_title,
                        news_seo_description, news_add_date, news_update_date, user_name, ntype_id
                        FROM
                            (
                                SELECT news_id, news_name, news_slug, news_content, news_seo_title,
                                news_seo_description, news_add_date, news_update_date, qhn_news.user_id, user_name
                                FROM qhn_news
                                LEFT JOIN qhn_users ON qhn_news.user_id = qhn_users.user_id
                            ) as newsuser_1
                        RIGHT JOIN qhn_news_type_details
                        ON qhn_news_type_details.news_id = newsuser_1.news_id
                    ) as newsusertypes
                LEFT JOIN qhn_news_type ON newsusertypes.ntype_id = qhn_news_type.ntype_id
                ORDER BY news_id";
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    /**
     *
     * Insert new row news table
     *
     * @param $data
     * @return bool
     */
    public function insert($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("news") . "(news_name,
                                                                    news_slug,
                                                                    news_content,
                                                                    news_seo_title,
                                                                    news_seo_description,
                                                                    news_add_date,
                                                                    news_update_date,
                                                                    user_id,
                                                                    nstatus_id)
                VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssssii",
            $data['news_name'],
            $data['news_slug'],
            $data['news_content'],
            $data['news_seo_title'],
            $data['news_seo_description'],
            date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s"),
            $data['user_id'],
            $data['nstatus_id']
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
     * Insert new row for news table (nstatus_id = 3 trash)
     *
     * @param data = array(user_id)
     * @return boolean or int(insert_id)
     *
     */
    public function insert_null($data)
    {
        $sql = "INSERT INTO " . $this->getTableName("news") . "(news_add_date, news_update_date, user_id, nstatus_id) VALUES (?, ?, ?, ?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssii", date("Y-m-d H:i:s"),
            date("Y-m-d H:i:s"),
            $data['user_id'],
            $data['nstatus_id']);
        $result = $stmt->execute();
        if ($result == true) {
            $result = $stmt->insert_id;
        }
        $stmt->close();
        return $result;
    }

    /**
     *
     * Update table news
     *
     * @param $data (array)
     * @param $news_id
     * @return boolean
     */
    public function update($data, $news_id)
    {
        $sql = "UPDATE " . $this->getTableName("news") . " SET  news_name=?,
                                                                news_slug=?,
                                                                news_content=?,
                                                                news_seo_title=?,
                                                                news_seo_description=?,
                                                                news_update_date=?,
                                                                news_publish_date=?,
                                                                nstatus_id=?
                                                            WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssssii", $data['news_name'],
            $data['news_slug'],
            $data['news_content'],
            $data['news_seo_title'],
            $data['news_seo_description'],
            date("Y-m-d H:i:s"),
            $data['news_publish_date'],
            $data['nstatus_id'],
            $news_id);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * update all news type details
     *
     * @param $data
     * @param $news_id
     */
    public function insert_news_type_detail($data, $news_id)
    {
        $sql = "INSERT INTO " . $this->getTableName("news_type_details") . "(news_id, ntype_id) VALUES (?, ?)";
        $stmt = $this->prepare($sql);
        foreach ($data as $ntype_id) {
            try {
                $stmt->bind_param("ii", $news_id, $ntype_id);
                $stmt->execute();
            } catch (\Exception $e) {

            }
        }
        $stmt->close();
    }

    /**
     * Delete row of news_type_detail where news_id and ntype_id
     *
     * @param $data
     * @param $news_id
     */
    public function delete_news_type_detail($data, $news_id)
    {
        $sql = "DELETE FROM " . $this->getTableName("news_type_details") . " WHERE news_id=? AND ntype_id=?";
        $stmt = $this->prepare($sql);
        foreach ($data as $ntype_id) {
            try {
                $stmt->bind_param("ii", $news_id, $ntype_id);
                $stmt->execute();
            } catch (\Exception $e) {

            }
        }
        $stmt->close();
    }

    /**
     *
     * Delete all news_type_details where news_id = $news_id
     *
     * @param $news_id
     */
    public function delete_news_type_detail_all($news_id)
    {
        $sql = "DELETE FROM " . $this->getTableName("news_type_details") . " WHERE news_id=?";
        $stmt = $this->prepare($sql);

        $stmt->bind_param("i", $news_id);
        $stmt->execute();

        $stmt->close();
    }

    /**
     * get all ntype_id id of $news
     *
     * @param $news_id
     * @return array() $ntype_id
     */
    public function select_news_type($news_id)
    {
        $sql = "SELECT ntype_id FROM " . $this->getTableName("news_type_details") . " WHERE news_id=?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $news_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = array();
        while($row = $result->fetch_assoc())
        {
            $data[] = $row['ntype_id'];
        }
        $stmt->close();
        return $data;
    }
}