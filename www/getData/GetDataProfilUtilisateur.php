<?php
namespace warhammerScoreBoard\getData;

use warhammerScoreBoard\core\Helper;

class GetDataProfilUtilisateur
{
    public static function getData($utilisateur)
    {
        return [
            "id"=>[
                "label"=>"Id de l'utilisateur : ",
                "value"=>$utilisateur["idUtilisateur"],
                "type"=>"data",
                "admin"=>true
            ],
            "nom"=>[
                "label"=>"Nom : ",
                "value"=>$utilisateur["nomUtilisateur"],
                "type"=>"data"
            ],
            "prenom"=>[
                "label"=>"Prenom : ",
                "value"=>$utilisateur["prenom"],
                "type"=>"data"
            ],
            "pseudo"=>[
                "label"=>"Pseudo : ",
                "value"=>$utilisateur["pseudo"],
                "type"=>"data"
            ],
            "dateDeNaissance"=>[
                "label"=>"Date de naissance : ",
                "value"=>$utilisateur["dateDeNaissance"]?date("d-m-Y",strtotime($utilisateur["dateDeNaissance"])):null,
                "type"=>"data"
            ],
            "email"=>[
                "label"=>"Email : ",
                "value"=>$utilisateur["email"],
                "type"=>"data"
            ],
            "nomRole"=>[
                "label"=>"Role : ",
                "value"=>$utilisateur["nomRole"],
                "type"=>"data"
            ],
            "dateInscription"=>[
                "label"=>"Date d'inscription : ",
                "value"=>date('d-m-Y',strtotime($utilisateur["dateInscription"])),
                "type"=>"data"
            ],
            "updateMotDePasse"=>[
                "label"=>"Modifier le mot de passe : ",
                "valueLink"=>Helper::getUrl("Utilisateur","newPassword"),
                "value"=>"nouveau mot de passe",
                "type"=>"link"
            ],

        ];
    }
}