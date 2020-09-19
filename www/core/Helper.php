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
        die("echec de la redirection");
    }

    public static function checkAdmin()
    {
        if(empty($_SESSION['role']) || $_SESSION['role'] != 3)
            Helper::redirectTo("Home","default");
    }

    public static function checkConnected()
    {
        if(empty($_SESSION['token']))
            Helper::redirectTo("Home","default");
    }
    public static function checkDisconnected()
    {
        if(!empty($_SESSION['token']))
            Helper::redirectTo("Home","default");
    }
    public static function checkPartie()
    {
        if(empty($_SESSION['idPartie']))
            Helper::redirectTo("Home","default");
    }
}