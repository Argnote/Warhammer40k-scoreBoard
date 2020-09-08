<?php

namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;

class LoginForm {

    public static function getForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>Helper::getUrl("Utilisateur", "login"),
                "class"=>"User formDisabled",
                "id"=>"formLoginUser",
                "submit"=>"Se connecter"
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email",
                    "class"=>"form-control form-control-user",
                    "label"=>"Entrez votre adresse email : ",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"identifiant ou mot de passe incorrect"
                ],
                "motDePasse"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "class"=>"form-control form-control-user",
                    "label"=>"Entrez votre mot de passe : ",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"identifiant ou mot de passe incorrect"
                ],
            ]
        ];
    }
}