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
    const TABLE_NAME = DB_TABLE_PREFIX . "news";

    const STATUS_TRASH = 3; // (delete)
    const STATUS_DRAFT = 2; // hide default
    const STATUS_APPROVE = 1; // show

    private $_news_id;
    private $_news_name;
    private $_news_slug;
    private $_news_content;
    private $_news_seo_title;
    private $_news_seo_description;
    private $_news_update_date;
    private $_news_add_date;
    private $_news_publish_date;
    private $_user_id;
    private $_status;

    /**
     * @return mixed
     */
    public function getNewsId()
    {
        return $this->_news_id;
    }

    /**
     * @param mixed $news_id
     */
    public function setNewsId($news_id)
    {
        $this->_news_id = intval($news_id);
    }

    /**
     * @return mixed
     */
    public function getNewsName()
    {
        return $this->_news_name;
    }

    /**
     * @param mixed $news_name
     */
    public function setNewsName($news_name)
    {
        $this->_news_name = $this->trim($news_name);
    }

    /**
     * @return mixed
     */
    public function getNewsSlug()
    {
        return $this->_news_slug;
    }

    /**
     * @param mixed $news_slug
     */
    public function setNewsSlug($news_slug)
    {
        $this->_news_slug = $this->trim($news_slug);
    }

    /**
     * @return mixed
     */
    public function getNewsContent()
    {
        return $this->_news_content;
    }

    /**
     * @param mixed $news_content
     */
    public function setNewsContent($news_content)
    {
        $this->_news_content = $this->trim($news_content);
    }

    /**
     * @return mixed
     */
    public function getNewsSeoTitle()
    {
        return $this->_news_seo_title;
    }

    /**
     * @param mixed $news_seo_title
     */
    public function setNewsSeoTitle($news_seo_title)
    {
        $this->_news_seo_title = $this->trim($news_seo_title);
    }

    /**
     * @return mixed
     */
    public function getNewsSeoDescription()
    {
        return $this->_news_seo_description;
    }

    /**
     * @param mixed $news_seo_description
     */
    public function setNewsSeoDescription($news_seo_description)
    {
        $this->_news_seo_description = $this->trim($news_seo_description);
    }

    /**
     * @return mixed
     */
    public function getNewsUpdateDate()
    {
        return $this->_news_update_date;
    }

    /**
     * @param mixed $news_update_date
     */
    public function setNewsUpdateDate($news_update_date)
    {
        $date = new \DateTime($news_update_date);
        $this->_news_update_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return mixed
     */
    public function getNewsAddDate()
    {
        return $this->_news_add_date;
    }

    /**
     * @param mixed $news_add_date
     */
    public function setNewsAddDate($news_add_date)
    {
        $date = new \DateTime($news_add_date);
        $this->_news_add_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return mixed
     */
    public function getNewsPublishDate()
    {
        return $this->_news_publish_date;
    }

    /**
     * @param mixed $news_publish_date
     */
    public function setNewsPublishDate($news_publish_date)
    {
        $date = new \DateTime($news_publish_date);
        $this->_news_publish_date = $date->format("Y-m-d H:i:s");
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_user_id;
    }

    /**
     * @param mixed $user_id
     */
    public function setUserId($user_id)
    {
        $this->_user_id = intval($user_id);
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        if ($status == self::STATUS_APPROVE
            || $status == self::STATUS_DRAFT
            || $status == self::STATUS_TRASH
        ) {
            $this->_status = $status;
        } else {
            $this->_status = self::STATUS_TRASH;
        }
    }


    public function __construct()
    {
        parent::__construct();

        $this->_news_id = null;
        $this->_news_name = null;
        $this->_news_slug = null;
        $this->_news_content = null;
        $this->_news_seo_title = null;
        $this->_news_seo_description = null;
        $this->_news_publish_date = date("Y-m-d H:i:s");
        $this->_news_update_date = date("Y-m-d H:i:s");
        $this->_news_add_date = date("Y-m-d H:i:s");
        $this->_news_id = null;
        $this->_status = self::STATUS_DRAFT;
    }


    /**
     * Insert new row news table
     *
     * @return bool
     */
    public function insert()
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . "(news_name,
                                                        news_slug,
                                                        news_content,
                                                        news_seo_title,
                                                        news_seo_description,
                                                        news_publish_date,
                                                        news_add_date,
                                                        news_update_date,
                                                        user_id,
                                                        status)
                VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ssssssssii",
            $this->getNewsName(),
            $this->getNewsSlug(),
            $this->getNewsContent(),
            $this->getNewsSeoTitle(),
            $this->getNewsSeoDescription(),
            $this->getNewsPublishDate(),
            $this->getNewsAddDate(),
            $this->getNewsUpdateDate(),
            $this->getUserId(),
            $this->getStatus()
        );
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    /**
     * Update table news
     *
     * @return boolean
     */
    public function update()
    {
        $result = false;
        if ($this->getNewsId() != null) {
            $sql = "UPDATE " . self::TABLE_NAME . " SET  news_name=?,
                                                        news_slug=?,
                                                        news_content=?,
                                                        news_seo_title=?,
                                                        news_seo_description=?,
                                                        news_update_date=?,
                                                        news_publish_date=?,
                                                        status=?
                                                    WHERE news_id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("sssssssii",
                $this->getNewsName(),
                $this->getNewsSlug(),
                $this->getNewsContent(),
                $this->getNewsSeoTitle(),
                $this->getNewsSeoDescription(),
                $this->getNewsUpdateDate(),
                $this->getNewsPublishDate(),
                $this->getStatus(),
                $this->getNewsId());
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
    }

    /**
     * DELETE where $_news_id
     *
     * @return bool
     */
    public function delete()
    {
        $result = false;
        if ($this->getNewsId() != null) {
            $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE news_id=?";
            $stmt = $this->prepare($sql);
            $stmt->bind_param("i", $news_id);
            $result = $stmt->execute();
            $stmt->close();
        }
        return $result;
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
    public function select($news_id = "")
    {
        if ($news_id != "") {
            $this->setNewsId($news_id);
        }
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE news_id = ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("i", $this->getNewsId());
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc();
    }

    public function select_limit($start = 0, $stop = 10)
    {
        $sql = "SELECT n.*, u.user_name, i.img_url, i.img_alt FROM " . self::TABLE_NAME . " n
                            LEFT JOIN " . Users::TABLE_NAME . " u ON n.user_id=u.user_id
                            LEFT JOIN " . Images::TABLE_NAME . " i ON n.news_id=i.news_id AND i.featured = " . Images::FEATURED_YES . "
                ORDER BY n.news_publish_date DESC
                LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("ii", $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    public function select_limit_count()
    {
        $sql = "SELECT count(*) as totalItem FROM qhn_news
                                WHERE status = 1";
        $stmt = $this->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->fetch_assoc()['totalItem'];
    }

    /**
     *
     * Select all news row - join news_type, users, news_type_details
     * @param $start
     * @param $stop
     * @return array
     */
    public function select_admin_index($start = 0, $stop = 25)
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
                GROUP BY news_id
                ORDER BY newsusertypes.news_update_date DESC LIMIT {$start}, {$stop}";
        $result = $this->query($sql);
        return $this->fetch_assoc_all($result);
    }

    public function select_admin_index_count()
    {
        $sql = "SELECT count(*) as totalItem
                FROM
                    (
                        SELECT newsuser.news_id, news_name, news_slug, news_content, news_seo_title,
                        news_seo_description, news_add_date, news_update_date, user_name, ntype_id
                        FROM
                            (
                                SELECT news_id, news_name, news_slug, news_content, news_seo_title,
                                news_seo_description, news_add_date, news_update_date, qhn_news.user_id, user_name
                                FROM " . self::TABLE_NAME . "
                                LEFT JOIN qhn_users ON " . self::TABLE_NAME . ".user_id = qhn_users.user_id
                            ) as newsuser
                        LEFT JOIN " . News_Type_Details::TABLE_NAME . "
                        ON " . News_Type_Details::TABLE_NAME . ".news_id = newsuser.news_id
                        GROUP BY news_id
                        UNION
                        SELECT newsuser_1.news_id, news_name, news_slug, news_content, news_seo_title,
                        news_seo_description, news_add_date, news_update_date, user_name, ntype_id
                        FROM
                            (
                                SELECT news_id, news_name, news_slug, news_content, news_seo_title,
                                news_seo_description, news_add_date, news_update_date, qhn_news.user_id, user_name
                                FROM " . self::TABLE_NAME . "
                                LEFT JOIN qhn_users ON qhn_news.user_id = qhn_users.user_id
                            ) as newsuser_1
                        RIGHT JOIN " . News_Type_Details::TABLE_NAME . "
                        ON " . News_Type_Details::TABLE_NAME . ".news_id = newsuser_1.news_id
                        GROUP BY news_id
                    ) as newsusertypes
                LEFT JOIN " . Ntype::TABLE_NAME . " ON newsusertypes.ntype_id = " . Ntype::TABLE_NAME . ".ntype_id";
        $result = $this->query($sql);
        $result = $result->fetch_assoc();
        return $result['totalItem'];
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
        while ($row = $result->fetch_assoc()) {
            $data[] = $row['ntype_id'];
        }
        $stmt->close();
        return $data;
    }


    /**
     * return all rows match $keyword
     *
     * @param $keyword
     * @param int $start
     * @param int $stop
     * @return array
     */
    public function search($keyword, $start = 0, $stop = 25)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT *
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(news_name) LIKE LOWER(?) OR
                        LOWER(news_slug) LIKE LOWER(?) OR
                        LOWER(news_content) LIKE LOWER(?) OR
                        LOWER(news_seo_title) LIKE LOWER(?) OR
                        LOWER(news_seo_description) LIKE LOWER(?)
                ORDER BY news_id DESC LIMIT ?, ?";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssssii",
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $keyword,
            $start, $stop);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $this->fetch_assoc_all($result);
    }

    /**
     * Return total row of search
     *
     * @param $keyword
     * @return mixed
     */
    public function searchCount($keyword)
    {
        $keyword = "%{$keyword}%";
        $sql = "SELECT count(*) as totalItem
                FROM " . self::TABLE_NAME . "
                WHERE LOWER(news_name) LIKE LOWER(?) OR
                        LOWER(news_slug) LIKE LOWER(?) OR
                        LOWER(news_content) LIKE LOWER(?) OR
                        LOWER(news_seo_title) LIKE LOWER(?) OR
                        LOWER(news_seo_description) LIKE LOWER(?)";
        $stmt = $this->prepare($sql);
        $stmt->bind_param("sssss", $keyword, $keyword, $keyword, $keyword, $keyword);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $result = $result->fetch_assoc();
        return $result['totalItem'];
    }
}