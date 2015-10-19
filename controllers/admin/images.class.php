<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 10/12/2015
 * Time: 9:08 AM
 */

namespace controllers\admin;


class Images extends Admin_Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {

    }

    /**
     * get image panel WHERE $img_id
     *
     * @param $img_id
     */
    public function image($img_id)
    {
        $images_model = new \models\Images();
        $images_model->setImgId($img_id);
        $this->views->image = $images_model->select();
        $this->views->render("admin/images/image");
    }

    /**
     * set Featured = true Where $img_id
     *
     * @param $img_id
     */
    public function featured($img_id)
    {
        $result = 0;
        $images_model = new \models\Images();
        $images_model->setImgId($img_id);
        if($images_model->featured())
        {
            $result = 1;
        }
        echo $result;
    }

    /**
     * reset News Featured where $img_id
     *
     * @param $img_id
     */
    public function resetFeatured($img_id)
    {
        $result = 0;
        $images_model = new \models\Images();
        $images_model->setImgId($img_id);
        if($images_model->resetFeatured())
        {
            $result = 1;
        }
        echo $result;
    }

    /**
     * Reset News Featured where $news_id
     *
     * @param $news_id
     */
    public function resetNewsFeatured($news_id)
    {
        $result = 0;
        $images_model = new \models\Images();
        $images_model->setNewsId($news_id);
        if($images_model->resetNewsFeatured())
        {
            $result = 1;
        }
        echo $result;
    }
}