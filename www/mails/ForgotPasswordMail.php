<?php

namespace warhammerScoreBoard\mails;

class ForgotPasswordMail {

    public static function getMail($email,$url){
        return [
            "sender"=>[
                "email"=>"ne-pas-repondre@warhammerScoreBoard.com",
                "pseudo"=>"Administrateur warhammerScoreBoard"
            ],

            "addressee"=>[
                "email"=>$email,
                "pseudo"=>$email
            ],

            "body"=>[
                "html" => "true",
                "subject" => "Mot de passe oublie",
                "body" => "Bonjour, voici le lien pour changer votre mot de passe <a href=\"$url\">nouveau mot de passe</a>.Si il ne fonctionne pas vous pouvez le copier dans un nouvel onglet : $url<br/>
                           Si vous n'êtes pas à l'origine de cette demande, n'utilsez pas ce lien!",
                "altBody" => "Bonjour, voici le lien pour changer votre mot de passe $url<br/>
                              Si vous n'êtes pas à l'origine de cette demande, n'utilsez pas ce lien!"
            ]
        ];
    }
}