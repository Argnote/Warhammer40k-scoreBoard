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
                "class" => "Partie formDisabled",
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
                "missionPrincipal" => [
                    "name" => "missionPrincipal",
                    "class" => "select",
                    "defaultValue" => "Objectif Pricipal",
                    "form" => "formInitPartie",
                    "required" => true,
                    "contrainte" => "numeric",
                    "errorMsg" => "Vous devez selectionner une mission différente à chaques fois"
                ]
            ]
        ];
        $tab["fields"] = array_merge($tab["fields"], InitialisationPartieForm::getMissionSecondaire());

        return $tab;
    }

    private static function getMissionSecondaire()
    {
        $result = array();
        for ($j = 1; $j <= 2; $j++) {
            $result += ["armee{$j}" => [
                "required" => false,
                "defaultValue" => "choix de l'armée",
                "name" => "armee".$j,
                "class" => "select",
                "form" => "formInitPartie",
                "contrainte" => "armee",
                "errorMsg" => "Vous devez selectionner une armée valide"
            ]
            ];
            $tabCompare = array();
            $missionJoueur = 1;
            for ($i = 1; $i <= 3; $i++) {
                if ($missionJoueur == $j)
                {
                    array_push($tabCompare,"missionSecondaire{$i}_Joueur{$j}");
                }
                else
                {
                    $tabCompare = array();
                    array_push($tabCompare,"missionSecondaire{$i}_Joueur{$j}");
                }
                $missionJoueur = $j;
                $result += ["missionSecondaire{$i}_Joueur{$j}" => [
                    "required" => true,
                    "name" => "missionSecondaire{$i}_Joueur{$j}",
                    "class" => "select",
                    "defaultValue" => "Objectif secondaire $i",
                    "form" => "formInitPartie",
                    "contrainte" => "mission",
                    "compare" => $tabCompare,
                    "errorMsg" => "Vous devez selectionner des missions différente issue de catégories différente"
                ]
                ];
            }
        }
        return $result;
    }
}