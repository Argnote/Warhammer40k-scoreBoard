<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\models\Utilisateur;

class updateUtilisateurForm
{
    public static function getForm(string $admin = null, array $role = null)
    {
        $utilisateur = [
            "config" => [
                "method" => "POST",
                "action" => Helper::getUrl("Utilisateur", "updateUtilisateur").$admin,
                "class" => "formDisabled",
                "id" => "formUpdateUtilisateur",
                "submit" => "Modifier le profil"
            ],

            "fields" => [
                "nomUtilisateur" => [
                    "type" => "text",
                    "placeholder" => "Modifier le nom",
                    "class" => "form-control form-control-user",
                    "id" => "nomUtilisateur",
                    "label" => "Modifier le nom :",
                    "required" => false,
                    "min-length" => 1,
                    "max-length" => 100,
                    "errorMsg" => "Votre nom doit faire entre 1 et 100 caractères et ne doit pas contenir de caractères spéciaux ni de nombres"
                ],
                "prenom" => [
                    "type" => "text",
                    "placeholder" => "Modifier le prénom",
                    "class" => "form-control form-control-user",
                    "id" => "prenom",
                    "label" => "Modifier le prenom :",
                    "required" => false,
                    "min-length" => 1,
                    "max-length" => 50,
                    "errorMsg" => "Votre prénom doit faire entre 1 et 50 caractères et ne doit pas contenir de caractères spéciaux ni de nombres"
                ],
                "pseudo" => [
                    "type" => "text",
                    "placeholder" => "Modifier le pseudo",
                    "class" => "form-control form-control-user",
                    "id" => "pseudo",
                    "label" => "Modifier le pseudo :",
                    "required" => false,
                    "uniq" => ["table" => "utilisateur", "column" => "pseudo", "class" => Utilisateur::class],
                    "min-length" => 1,
                    "max-length" => 50,
                    "errorMsg" => "Votre pseudo doit faire entre 1 et 50 caractères et ne doit pas contenir de caractères spéciaux"
                ],
                "email" => [
                    "type" => "email",
                    "placeholder" => "Modifier l'email",
                    "class" => "form-control form-control-user",
                    "id" => "email",
                    "label" => "Modifier l'adresse email :",
                    "required" => false,
                    "uniq" => ["table" => "utilisateur", "column" => "email", "class" => Utilisateur::class],
                    "errorMsg" => "Adresse mail invalide"
                ],
                "dateDeNaissance" => [
                    "type" => "date",
                    "class" => "form-control form-control-user",
                    "id" => "dateDeNaissance",
                    "label" => "Modifier la date de naissance :",
                    "required" => false,
                    "errorMsg" => "Erreur dans la date de naissance"
                ],
            ]
        ];
        if($_SESSION["role"] == 3 && !empty($role))
        {
            $admin =[
                "idRole" =>
                    [
                        "type" => "select",
                        "value" => $role,
                        "label" => "Modifier le role:",
                        "errorMsg" => "Le role n'est pas valide",
                        "required" => false,
                        "config" =>[
                            "required" => false,
                            "form"=>$utilisateur["config"]["id"],
                            "defaultValue" => "Nouveau role",
                            "name" => "idRole"
                        ]
                    ]
            ];
            $utilisateur["fields"] = array_merge($utilisateur["fields"],$admin);
        }
        return $utilisateur;
    }
}