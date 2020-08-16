<?php

namespace warhammerScoreBoard\core;

class Helper
{
    public static function getUrl($controller, $action)
    {
        $listOfRoutes = yaml_parse_file("routes.yml");

        foreach ($listOfRoutes as $url=>$route) {
            if ($route["controller"] == $controller && $route["action"]==$action) {
                return $url;
            }
        }


        header('Location: /vous-etes-perdu');
    }
    public static function redirectTo($controller, $action)
    {
        header('Location: '.Helper::getUrl($controller,$action));
    }

    public static function checkRole($role)
    {
        if($_SESSION['role'] != $role)
            header('Location: /vous-etes-perdu');
    }
    public static function checkDisconnected()
    {
        if(!empty($_SESSION['role']))
            Helper::redirectTo("User","default");
    }
}