<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;

class ValidationTourForm
{
    public static function getForm(array $missionJoueur, bool $finPartie)
    {
        if(!$finPartie)
        {
            $url = Helper::getUrl("Partie", "validationTour");
        }
        else
        {
            $url = Helper::getUrl("Partie", "validationTour");
        }
        $fields = 0;
        $form = ["config"=>[
            "method"=>"POST",
            "action"=>$url,
            "class"=>"Partie formDisabled",
            "id"=>"formValidationPartie",
            "submit"=>"Valider le tour",
            "finTour"=>$finPartie,
            "nbFields"=>$fields
            ]
        ];
        $form["fields"] = array();
            foreach ($missionJoueur as $mission)
            {
                $form["config"]["nbFields"] ++;
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
                        "contrainte" =>"score",
                        "nombrePointPossibletour" => $mission["nombrePointPossibletour"],
                        "id" => "mission".$mission["idMission"],
                        "class" => "valuePoint",
                        "name" => $data."[nombrePoint]",
                        "marquageFinPartie" => $mission["marquageFinPartie"],
                        "errorMsg"=>"La mission : \"".$mission["nomMission"]."\" ne peut pas rapporter plus de ".$mission["nombrePointPossibletour"]." points par round et moins de 0."
                    ],
                    $data."_joueurId" =>[
                        "type" => "hidden",
                        "contrainte" =>"joueur",
                        "value" => $mission["idJoueur"],
                        "name" => $data."[idJoueur]",
                        "errorMsg"=>"Aucun joueur portant cette id n'est connecté, merci de ne pas modifier le DOM!"
                    ],
                    $data."_missionId" =>[
                        "type" => "hidden",
                        "contrainte" =>"missionJoueur",
                        "idJoueur" => $mission["idJoueur"],
                        "value" => $mission["idMission"],
                        "name" => $data."[idMission]",
                        "errorMsg"=>"Cette mission n'a pas été selectionnée par un joueur, merci de ne pas modifier le DOM!"
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