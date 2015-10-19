<?php
namespace library;
class Func
{

    public static $url_rewrite = false;

    public static function getMenu($menus, $url_current)
    {
        $data = "";
        foreach ($menus as $menu) {
            if(!isset($menu['url'])) {
                $menu['url'] = "#";
            }
            if($menu['url'] == $url_current || (isset($menu['submenu']) && Func::in_array_url($url_current, $menu['submenu']) == true))
            {
                $data .= '<li class="active"><a href="' . $menu['url'] . '">' . $menu['name'] . '</a>' . "\n";
            }
            else
            {
                $data .= '<li><a href="' . $menu['url'] . '">' . $menu['name'] . '</a>'."\n";
            }

            if (isset($menu['submenu'])) {
                $data .= "<ul>";
                $data .= Func::getMenu($menu['submenu'], $url_current);
                $data .= "</ul>\n";
            } else {
                $data .= "</li>\n";
            }
        }
        return $data;
    }

    public static function urlToString($url)
    {
        if($url == "")
            return "#";
        else
        return $url;
    }

    public static function in_array_url($url_current, $menus)
    {
        foreach($menus as $menu)
        {
            if($menu['url'] == $url_current)
            {
                return true;
            }
        }
        return false;
    }

    public static function arrayMenu()
    {
        return array(
            array(
                "name" => "Dashboard",
                "url" => Func::getUrl("welcome")
            ),
            array(
                "name" => "Quản lý người dùng",
                "submenu" => array(
                    array(
                        "name" => "Thêm người dùng",
                        "url" => "/admin.php?c=users&m=add"
                    ),
                    array(
                        "name" => "Danh Sach",
                        "url" => "/admin.php?c=users"
                    )
                )
            ),
            array(
                "name" => "Quản lý tin tức",
                "submenu" => array(
                    array(
                        "name" => "Danh sách tin tức",
                        "url" => "/admin.php?c=news"
                    ),
                    array(
                        "name" => "Thêm tin mới",
                        "url" => "/admin.php?c=news&m=add"
                    ),
                    array(
                        "name" => "Category",
                        "url" => "/admin.php?c=news_type"
                    )
                )
            ),
            array(
                "name" => "Quản lý sản phẩm",
                "submenu" => array(
                    array(
                        "name" => "Danh sách sản phẩm",
                        "url" => "/admin.php?c=products"
                    ),
                    array(
                        "name" => "Thêm sản phẩm",
                        "url" => "/admin.php?c=products&m=add"
                    ),
                    array(
                        "name" => "Tags",
                        "url" => "/admin.php?c=products_tag"
                    ),
                    array(
                        "name" => "Category",
                        "url" => "/admin.php?c=products_type&m=index"
                    ),
                    array(
                        "name" => "Thương hiệu",
                        "url" => "/admin.php?c=brand"
                    )
                )
            ),
            array(
                "name" => "Thông tin website",
                "submenu" => array(
                    array(
                        "name" => "Thông tin chung",
                        "url" => "/admin.php?c=options"
                    ),
                    array(
                        "name" => "Thêm sản phẩm",
                        "url" => "/admin.php?c=products&m=add"
                    ),
                    array(
                        "name" => "Tags",
                        "url" => "/admin.php?c=products_tag"
                    ),
                    array(
                        "name" => "Category",
                        "url" => "/admin.php?c=products_type&m=index"
                    ),
                    array(
                        "name" => "Thương hiệu",
                        "url" => "/admin.php?c=brand"
                    )
                )
            )
        );
    }

    public static function getUrl($c, $m = "index", $p = -1, $slug = "")
    {
        $url = "";
        if (Func::$url_rewrite == true) {
        } else {
            $url = "/admin.php?c=" . $c;
            if ($m != "index") {
                $url .= "&m=" . $m;
                if ($p != -1) {
                    $url .= "&p=" . $p;
                    if ($slug != "") {
                        $url .= "&sl=" . $slug;
                    }
                }
            }
        }
        return $url;
    }

    public static function getAlert($message, $type = "success", $close = true)
    {
        $result = '<div class="alert alert-' . $type;
        if($close == true)
            $result .= " alert-dismissible";
        $result .= '" role="alert">';
        $result .= ' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
        $result .= $message;
        $result .= '</div>';
        return $result;
    }

    /**
     * Return current url
     *
     * @return mixed
     */
    public static function getUrlCurrent()
    {
        return $_SERVER["REQUEST_URI"];
    }

    /**
     * Generator slug from $str
     *
     * @param $str
     * @return mixed|string
     */
    public static function getSlug($str) //str: string
    {
        $str = trim(mb_strtolower($str));
        $str = ltrim($str, "-");
        $str = rtrim($str, "-");
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        $str = preg_replace('/[\-]{2,}/', '-', $str);
        return $str;
    }

    /**
     * return Password hash from $password and $salt
     *
     * @param $password
     * @param $salt
     * @return string
     */
    public static function genPassword($password, $salt)
    {
        return hash('sha256', $password . $salt);
    }

    /**
     * Generator salt for password
     *
     * @return string
     */
    public static function genPasswordSalt()
    {
        return bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    }
}