<?php


namespace warhammerScoreBoard\forms;
use warhammerScoreBoard\core\Helper;

class InitialisationPartieForm
{
    public static function getForm(){
        $tab = [
            "config"=>[
                "method"=>"POST",
                "action"=>Helper::getUrl("Partie", "creationPartie"),
                "class"=>"Partie",
                "id"=>"formInitPartie"
            ],

            "fields"=>[
                "nombrePoint"=>[
                    "errorMsg"=>"Une partie à plus de 100 000 points? Mais vous êtes fou!!"
                ],
                "missionPrimaire"=>[
                    "required" => true,
                    "contrainte" => "mission",
                    "errorMsg"=>"Vous devez selectionner une mission différente à chaques fois"
                ]
            ]
        ];
            $tab["fields"] = array_merge($tab["fields"], InitialisationPartieForm::getMissionSecondaire());

        return $tab;
    }
    private static function getMissionSecondaire()
    {
        $result = [];
        for($j = 1; $j <=2; $j++)
        {
            for($i = 1; $i<=3; $i++)
            {
                $result += ["MissionSecondaire{$i}_Joueur{$j}"=>[
                    "required" => true,
                    "contrainte" => "mission",
                    "errorMsg"=>"Vous devez selectionner une mission différente à chaques fois"
                    ]
                ];
            }
        }
        return $result;
    }
}