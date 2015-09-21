<?php
/**
 * Created by PhpStorm.
 * User: Liam Dang
 * Date: 9/19/2015
 * Time: 2:19 AM
 */

if(isset($_GET['url']))
{
    $url = $_GET['url'];
    $url = explode("/", $url);

    
    if(isset($url[2]))
    {
        echo $url[2];
    }
}
else
{
    new index();
}
