<?php

namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\models\Utilisateur;

class RegisterForm {
    public static function getForm(){
        return [
            "config"=>[
                "method"=>"POST",
                "action"=>Helper::getUrl("Utilisateur", "register"),
                "class"=>"formDisabled",
                "id"=>"formRegisterUser",
                "submit"=>"S'inscrire"
            ],

            "fields"=>[
                "prenom"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre prénom",
                    "class"=>"form-control form-control-user",
                    "id"=>"prenom",
                    "label"=>"Votre prenom :",
                    "required"=>false,
                    "min-length"=>1,
                    "max-length"=>50,
                    "errorMsg"=>"Votre prénom doit faire entre 1 et 50 caractères et ne doit pas contenir de caractères spéciaux ni de nombres"
                ],
                "nomUtilisateur"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre nom",
                    "class"=>"form-control form-control-user",
                    "id"=>"nomUtilisateur",
                    "label"=>"Votre nom :",
                    "required"=>false,
                    "min-length"=>1,
                    "max-length"=>100,
                    "errorMsg"=>"Votre nom doit faire entre 1 et 100 caractères et ne doit pas contenir de caractères spéciaux ni de nombres"
                ],
                "pseudo"=>[
                    "type"=>"text",
                    "placeholder"=>"Votre pseudo",
                    "class"=>"form-control form-control-user",
                    "id"=>"pseudo",
                    "label"=>"Votre pseudo :",
                    "required"=>true,
                    "uniq"=>["table"=>"utilisateur","column"=>"pseudo","class"=>Utilisateur::class],
                    "min-length"=>1,
                    "max-length"=>50,
                    "errorMsg"=>"Votre pseudo doit faire entre 1 et 50 caractères et ne doit pas contenir de caractères spéciaux"
                ],
                "email"=>[
                    "type"=>"email",
                    "placeholder"=>"Votre email",
                    "class"=>"form-control form-control-user",
                    "id"=>"email",
                    "label"=>"votre adresse email :",
                    "required"=>true,
                    "uniq"=>["table"=>"utilisateur","column"=>"email","class"=>Utilisateur::class],
                    "errorMsg"=>"Adresse mail invalide"
                ],
                "motDePasse"=>[
                    "type"=>"password",
                    "placeholder"=>"Votre mot de passe",
                    "class"=>"form-control form-control-user",
                    "id"=>"password",
                    "label"=>"Votre mot de passe :",
                    "required"=>true,
                    "errorMsg"=>"Votre mot de passe doit faire entre 8 et 20 caractères avec une minuscule, une majuscule, un nombre et un caractère spécial"
                ],
                "confirmationMotDePasse"=>[
                    "type"=>"password",
                    "placeholder"=>"Confirmation",
                    "class"=>"form-control form-control-user",
                    "id"=>"passwordConfirm",
                    "label"=>"Confirmez le mot de passe :",
                    "required"=>true,
                    "confirmWith"=>"pwd",
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ],
                "dateDeNaissance"=>[
                    "type"=>"date",
                    "class"=>"form-control form-control-user",
                    "id"=>"dateDeNaissance",
                    "label"=>"Votre date de naissance :",
                    "required"=>false,
                    "errorMsg"=>"Vous devez avoir plus de 18 ans pour vous inscrire"
                ],
                "captcha"=>[
                    "type"=>"captcha",
                    "class"=>"form-control form-control-user",
                    "id"=>"captcha",
                    "label"=>"Merci de recopier le texte de l'image :",
                    "required"=>true,
                    "placeholder"=>"Veuillez saisir les caractères",
                    "errorMsg"=>"Captcha incorrect"
                ]
            ]
        ];
    }
}