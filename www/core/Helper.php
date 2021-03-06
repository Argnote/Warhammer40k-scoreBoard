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

    //vérifie qu'un admin est connecté 
    public static function checkAdmin()
    {
        if(empty($_SESSION['role']) || $_SESSION['role'] != 3)
            Helper::redirectTo("Home","default");
    }

    //vérifie qu'un compte est connecté 
    public static function checkConnected()
    {
        if(empty($_SESSION['idUtilisateur1']))
            Helper::redirectTo("Home","default");
    }

    //vérifie que aucun compte n'est connecté
    public static function checkDisconnected()
    {
        if(!empty($_SESSION['idUtilisateur1']))
            Helper::redirectTo("Home","default");
    }

    //vérifie qu'une partie existe dans la session
    public static function checkPartie()
    {
        if(empty($_SESSION['idPartie']))
            Helper::redirectTo("Partie","getListPartie");
    }
}