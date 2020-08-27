<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\enumStatuNav;

class navForm
{

    public static function getForm()
    {
        return [
            "home" => [
                "url" => Helper::getUrl("Home","default"),
                "text" => "Acceuil",
                "statu" => enumStatuNav::default,
                "id" => "",
                "class" => "",
            ],
            "connexion" => [
                "url" => Helper::getUrl("Utilisateur","login"),
                "text" => "Se connecter",
                "statu" => enumStatuNav::offline,
                "id" => "",
                "class" => "",
            ],
            "motDePasseOublie" => [
                "url" => Helper::getUrl("Utilisateur","login"),
                "text" => "Mot de passe oublié",
                "statu" => enumStatuNav::offline,
                "id" => "",
                "class" => "",
            ],
            "deconnexion" => [
                "url" => Helper::getUrl("Utilisateur","logout"),
                "text" => "Se déconnecter",
                "statu" => enumStatuNav::online,
                "id" => "",
                "class" => "",
            ],
        ];
    }
}