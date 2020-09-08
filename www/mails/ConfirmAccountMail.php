<?php

namespace warhammerScoreBoard\mails;

class ConfirmAccountMail {

    public static function getMail($email,$pseudo,$url){
        return [
            "sender"=>[
                "email"=>"ne-pas-repondre@warhammerScoreBoard.com",
                "pseudo"=>"Administrateur warhammerScoreBoard"
            ],

            "addressee"=>[
                "email"=>$email,
                "pseudo"=>$pseudo
            ],

            "body"=>[
                "html" => "true",
                "subject" => "Confirmation de votre compte",
                "body" => "Bonjour et bienvenu $pseudo! Afin de valider votre compte, veillez cliquer sur ce lien <a href=\"$url\">Confirmation</a> ou le copier dans un nouvel onglet : $url<br/>
                          A bientot sur warhammerScoreBoard!",
                "altBody" => "Bonjour et bienvenu $pseudo! Afin de valider votre compte, veillez cliquer sur ce lien $url ou le copier dans un nouvel onglet <br/>
                          A bientot sur warhammerScoreBoard!"
            ]
        ];
    }
}