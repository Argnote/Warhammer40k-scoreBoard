<?php

namespace warhammerScoreBoard\core\tools;

class Message
{

    public static function InscriptionSucess()
    {
        return [
            "title" => "Inscription",

            "body" => [
                "Votre compte à bien été enregistré.",
                "Merci de vérifier vos emails afin de valider votre compte."
            ]
        ];
    }

    public static function mailInscriptionSucess()
    {
        return [
            "title" => "Inscription",

            "body" => [
                "Votre email à été validé avec succes.",
                "Vous pouvez maintenant vous connecter à votre espace."
            ]
        ];
    }

    public static function sendMailForgotPasswordSucess()
    {
        return [
            "title" => "Mot de passe oublié",

            "body" => [
                "Un email vous à été envoyé afin de changer votre mot de passe.",
            ]
        ];
    }

    public static function newPasswordSucess()
    {
        return [
            "title" => "Changement de mot de passe",

            "body" => [
                "Votre mot de passe à été changé avec succes",
                "Vous pouvez maintenant vous connecter à votre espace avec votre nouveau mot de passe."
            ]
        ];
    }

    public static function linkNoValid()
    {
        return [
            "title" => "Validation",

            "body" => [
                "Le lien n'est pas valide"
            ]
        ];
    }

    public static function erreurChargementPartie()
    {
        return [
            "title" => "Historique de la partie",

            "body" => [
                "Une érreur est survenue lors du chargement de la partie"
            ]
        ];
    }

    public static function erreurInviteNonConnecte()
    {
        return [
            "title" => "Reprendre une partie",

            "body" => [
                "L'ami qui a joué la partie avec vous doit être connecté"
            ]
        ];
    }

    public static function erreurComptePrincipalNonConnecte()
    {
        return [
            "title" => "Reprendre une partie",

            "body" => [
                "Vous essayé de reprendre une partie qui ne vous appartient pas!"
            ]
        ];
    }

    public static function erreurProfilNotFound()
    {
        return [
            "title" => "Consultation du profil",

            "body" => [
                "Le profil n'a pas été trouvé"
            ]
        ];
    }
}