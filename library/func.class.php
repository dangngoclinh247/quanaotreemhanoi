<?php
namespace library;
class Func
{

    public static $url_rewrite = false;

    public static function getMenu($menus, $url_current)
    {
        $data = "";
        foreach ($menus as $menu) {
            if ($menu['url'] == $url_current) {
                $data .= '<li class="active"><a href="' . $menu['url'] . '">' . $menu['name'] . '</a>';
            } else {
                $data .= "<li";
                // else check in menu sub
                if (isset($menu['submenu'])) {
                    if (in_array($url_current, $menu['submenu'])) {
                        $data .= ' class="active"';
                    }
                }
                $data .= '><a href="' . $menu['url'] . '">' . $menu['name'] . '</a>';
            }
            if (isset($menu['submenu'])) {
                $data .= "<ul>";
                $data .= Func::getMenu($menu['submenu'], "");
                $data .= "</ul>";
            } else {
                $data .= "</li>";
            }
        }
        return $data;
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
                "url" => "/admin.php?c=users",
                "submenu" => array(
                    array(
                        "name" => "Thêm người dùng",
                        "url" => "/admin.php?c=users&m=add"
                    ),
                    array(
                        "name" => "Danh Sach",
                        "url" => "/admin.php?c=users&m=add"
                    )
                )
            ),
            array(
                "name" => "Quản lý tin tức",
                "url" => "/admin.php?c=news",
                "submenu" => array(
                    array(
                        "name" => "Category",
                        "url" => "admin.php?c=news&m=ntype"
                    ),
                    array(
                        "name" => "Thêm Category",
                        "url" => "admin.php?c=news&m=ntype"
                    )
                )
            ),
            array(
                "name" => "Quản lý sản phẩm",
                "url" => "/admin.php?c=products",
                "submenu" => array(
                    array(
                        "name" => "Tags",
                        "url" => "/admin.php?c=products&m=tag"
                    ),
                    array(
                        "name" => "Category",
                        "url" => "/admin.php?c=products&m=type"
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

    public static function getUrlCurrent()
    {
        return $_SERVER["REQUEST_URI"];
    }

    public static function getSlug($str) //str: string
    {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        //$str = preg_replace('/[\-\-]/', '-', $str);
        return $str;
    }

    public static function sortNType($ntypes, $ntype_id = null)
    {
        $result = array();
        foreach($ntypes as $key => $ntype)
        {
            if($ntype['ntype_parent_id'] == $ntype_id)
            {
                unset($ntypes[$key]);
                $ntype["submenu"] = Func::sortNType($ntypes, $ntype['ntype_id']);
                $result[] = $ntype;
            }
        }
        return $result;
    }
}