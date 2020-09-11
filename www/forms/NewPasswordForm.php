<?php

namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;

class NewPasswordForm {

    public static function getForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>Helper::getUrl("Utilisateur", "newPassword"),
                "class"=>"formDisabled",
                "id"=>"formForgotpassword",
                "submit"=>"Valider"
            ],

            "fields"=>[
                "motDePasse"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "label"=>"Entrez votre nouveau mot de passe : ",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 8 et 20 caractères avec une minuscule, une majuscule, un nombre et un caractère spécial"
                ],
                "confirmationMotDePasse"=>[
                    "type"=>"password",
                    "placeholder"=>"Confirmation",
                    "label"=>"Confirmez votre nouveau mot de passe : ",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "confirmWith"=>"pwd",
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ],
            ]
        ];
    }
}