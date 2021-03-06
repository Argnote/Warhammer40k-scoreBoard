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
                    "classGrill"=>"col-sm-6",
                    "placeholder"=>"Votre mot de passe",
                    "label"=>"Entrez le nouveau mot de passe : ",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 8 et 20 caractères avec une minuscule, une majuscule, un nombre et un caractère spécial"
                ],
                "confirmationMotDePasse"=>[
                    "type"=>"password",
                    "classGrill"=>"col-sm-6",
                    "placeholder"=>"Confirmation",
                    "label"=>"Confirmez le nouveau mot de passe : ",
                    "class"=>"form-control form-control-user",
                    "id"=>"",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ],
            ]
        ];
    }
}