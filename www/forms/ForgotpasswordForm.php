<?php

namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;

class ForgotpasswordForm {

    public static function getForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>Helper::getUrl("Utilisateur", "forgotPassword"),
                "class"=>"User",
                "id"=>"formForgotpassword",
                "submit"=>"Valider"
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
                    "label"=>"Entrez votre l'adresse email du compte : ",
                    "placeholder"=>"Votre email",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Adresse mail invalide"
                ]
            ]
        ];
    }
}