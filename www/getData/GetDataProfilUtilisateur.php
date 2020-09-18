<?php
namespace warhammerScoreBoard\getData;

use warhammerScoreBoard\core\Helper;

class GetDataProfilUtilisateur
{
    public static function getData($Utilisateur)
    {
        return [
            "id"=>[
                "label"=>"Id de l'utilisateur : ",
                "value"=>$Utilisateur["idUtilisateur"],
                "type"=>"data",
                "admin"=>true
            ],
            "nom"=>[
                "label"=>"Nom : ",
                "value"=>$Utilisateur["nomUtilisateur"],
                "type"=>"data"
            ],
            "prenom"=>[
                "label"=>"Prenom : ",
                "value"=>$Utilisateur["prenom"],
                "type"=>"data"
            ],
            "pseudo"=>[
                "label"=>"Pseudo : ",
                "value"=>$Utilisateur["pseudo"],
                "type"=>"data"
            ],
            "dateDeNaissance"=>[
                "label"=>"Date de naissance : ",
                "value"=>$Utilisateur["dateDeNaissance"]?date("d-m-Y",strtotime($Utilisateur["dateDeNaissance"])):null,
                "type"=>"data"
            ],
            "email"=>[
                "label"=>"Email : ",
                "value"=>$Utilisateur["email"],
                "type"=>"data"
            ],
            "nomRole"=>[
                "label"=>"Role : ",
                "value"=>$Utilisateur["nomRole"],
                "type"=>"data"
            ],
            "dateInscription"=>[
                "label"=>"Date d'inscription : ",
                "value"=>date('d-m-Y',strtotime($Utilisateur["dateInscription"])),
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