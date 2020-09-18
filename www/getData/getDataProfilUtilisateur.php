<?php
namespace warhammerScoreBoard\getData;

use warhammerScoreBoard\core\Helper;

class getDataProfilUtilisateur
{
    public static function getData($data)
    {
        return [
            "id"=>[
                "label"=>"Id de l'utilisateur : ",
                "value"=>$data["idUtilisateur"],
                "type"=>"data",
                "admin"=>true
            ],
            "nom"=>[
                "label"=>"Nom : ",
                "value"=>$data["nomUtilisateur"],
                "type"=>"data"
            ],
            "prenom"=>[
                "label"=>"Prenom : ",
                "value"=>$data["prenom"],
                "type"=>"data"
            ],
            "pseudo"=>[
                "label"=>"Pseudo : ",
                "value"=>$data["pseudo"],
                "type"=>"data"
            ],
            "dateDeNaissance"=>[
                "label"=>"Date de naissance : ",
                "value"=>$data["dateDeNaissance"],
                "type"=>"data"
            ],
            "email"=>[
                "label"=>"Email : ",
                "value"=>$data["email"],
                "type"=>"data"
            ],
            "nomRole"=>[
                "label"=>"Role : ",
                "value"=>$data["nomRole"],
                "type"=>"data"
            ],
            "dateInscription"=>[
                "label"=>"Date d'inscription : ",
                "value"=>$data["dateInscription"],
                "type"=>"data"
            ],
            "updateMotDePasse"=>[
                "label"=>"Modifier le mot de passe : ",
                "valueLink"=>Helper::getUrl("Utilisateur","newPassword")."?id=".urlencode($data["idUtilisateur"])."&token=".urlencode($data["token"]),
                "value"=>"nouveau mot de passe",
                "type"=>"link"
            ],

        ];
    }
}