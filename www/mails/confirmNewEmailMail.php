<?php


namespace warhammerScoreBoard\mails;


class confirmNewEmailMail
{
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
                "body" => "Bonjour $pseudo! Afin de valider votre nouvelle adresse email, veillez cliquer sur ce lien <a href=\"$url\">Confirmation</a> ou le copier dans un nouvel onglet : $url<br/>
                          A bientot sur warhammerScoreBoard!",
                "altBody" => "Bonjour $pseudo! Afin de valider votre nouvelle adresse email, veillez cliquer sur ce lien $url ou le copier dans un nouvel onglet <br/>
                          A bientot sur warhammerScoreBoard!"
            ]
        ];
    }
}