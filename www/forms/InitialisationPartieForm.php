<?php


namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;

class InitialisationPartieForm
{
    public static function getForm()
    {
        $tab = [
            "config" => [
                "method" => "POST",
                "action" => Helper::getUrl("Partie", "initialisationPartie"),
                "class" => "Partie",
                "id" => "formInitPartie"
            ],

            "fields" => [
                "format" => [
                    "type" => "number",
                    "placeholder" => "Nombre de point de la partie",
                    "name" => "format",
                    "required" => false,
                    "errorMsg" => "Une partie à plus de 100 000 points? Mais vous êtes fou!!"
                ],
                "missionPrincipale" => [
                    "name" => "missionPrincipale",
                    "defaultValue" => "Objectif Pricipale",
                    "form" => "formInitPartie",
                    "required" => true,
                    "contrainte" => "number",
                    "errorMsg" => "Vous devez selectionner une mission différente à chaques fois"
                ]
            ]
        ];
        $tab["fields"] = array_merge($tab["fields"], InitialisationPartieForm::getMissionSecondaire());

        return $tab;
    }

    private static function getMissionSecondaire()
    {
        $result = [];
        for ($j = 1; $j <= 2; $j++) {
            $result += ["armee{$j}" => [
                "required" => false,
                "defaultValue" => "choix de l'armée",
                "name" => "armee".$j,
                "form" => "formInitPartie",
                "contrainte" => "armee",
                "errorMsg" => "Vous devez selectionner une armée valide"
            ]
            ];
            for ($i = 1; $i <= 3; $i++) {
                $result += ["missionSecondaire{$i}_Joueur{$j}" => [
                    "required" => true,
                    "name" => "missionSecondaire{$i}_Joueur{$j}",
                    "defaultValue" => "Objectif secondaire $i",
                    "form" => "formInitPartie",
                    "contrainte" => "number",
                    "errorMsg" => "Vous devez selectionner une mission différente à chaques fois"
                ]
                ];
            }
        }
        return $result;
    }
}