<?php

namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;

class ForgotpasswordForm {

    public static function getForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>Helper::getUrl("User", "forgotPassword"),
                "class"=>"User",
                "id"=>"formForgotpassword",
                "submit"=>"Valider"
            ],

            "fields"=>[
                "email"=>[
                    "type"=>"email",
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