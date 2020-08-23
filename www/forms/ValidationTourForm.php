<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;

class ValidationTourForm
{
    public static function getForm(array $missionJoueur)
    {
        $form = array();
        $form = ["config"=>[
            "method"=>"POST",
            "action"=>Helper::getUrl("Partie", "savePoint"),
            "class"=>"Partie",
            "id"=>"formValidationPartie",
            "submit"=>"Valider le tour"
            ]
        ];
        $form["fields"] = array();
            foreach ($missionJoueur as $mission)
            {
                $data = $mission["idJoueur"]."mission".$mission["idMission"];
                $configMission = [
                    $data."_label" =>[
                        "type" => "label",
                        "for" => "mission".$mission["idMission"]."[value]",
                        "text" => $mission["nomMission"],
                    ],
                    $data =>[
                        "type" =>"number",
                        "value" => 0,
                        "pointMaxTour" => $mission["nombrePointPossibletour"],
                        "id" => "mission".$mission["idMission"],
                        "name" => $data."[nombrePoint]",
                        "marquageFinPartie" => $mission["marquageFinPartie"],
                        "errorMsg"=>"La mission : \"".$mission["nomMission"]."\" ne peut pas rapporter plus de ".$mission["nombrePointPossibletour"]." points par round."
                    ],
                    $data."_joueurId" =>[
                        "type" => "hidden",
                        "value" => $mission["idJoueur"],
                        "name" => $data."[idJoueur]"
                    ],
                    $data."_missionId" =>[
                        "type" => "hidden",
                        "value" => $mission["idMission"],
                        "name" => $data."[idMission]"
                    ]
                ];
//                echo "<pre>";
//                print_r($configMission);
//                echo "</pre>";
                $form["fields"] = array_merge($form["fields"],$configMission);
            }
        return $form;
    }
}