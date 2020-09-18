<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\EnumStatuNav;

class GetDataNavForm
{

    public static function getForm()
    {
        return [
            "home" => [
                "url" => Helper::getUrl("Home","default"),
                "text" => "Accueil",
                "statu" => EnumStatuNav::default,
                "id" => "",
                "class" => "",
            ],
            "inscription" => [
                "url" => Helper::getUrl("Utilisateur","register"),
                "text" => "S'inscrire",
                "statu" => EnumStatuNav::offline,
                "id" => "",
                "class" => "",
            ],
            "connexion" => [
                "url" => Helper::getUrl("Utilisateur","login"),
                "text" => "Se connecter",
                "statu" => EnumStatuNav::offline,
                "id" => "",
                "class" => "",
            ],
            "motDePasseOublie" => [
                "url" => Helper::getUrl("Utilisateur","forgotPassword"),
                "text" => "Mot de passe oublié",
                "statu" => EnumStatuNav::offline,
                "id" => "",
                "class" => "",
            ],
            "listeDesParties" => [
                "url" => Helper::getUrl("Partie","getListPartie"),
                "text" => "Consulter ses parties",
                "statu" => EnumStatuNav::online,
                "id" => "",
                "class" => "",
            ],
            "profil" => [
                "url" => Helper::getUrl("Utilisateur","getUtilisateur"),
                "text" => "Consulter son profil",
                "statu" => EnumStatuNav::online,
                "id" => "",
                "class" => "",
            ],
            "deconnexion" => [
                "url" => Helper::getUrl("Utilisateur","logout"),
                "text" => "Se déconnecter",
                "statu" => EnumStatuNav::online,
                "id" => "",
                "class" => "",
            ],
        ];
    }
}