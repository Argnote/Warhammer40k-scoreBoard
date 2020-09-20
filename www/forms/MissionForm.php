<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\models\Mission;

class MissionForm
{
    public static function getForm(array $listFaction,int $idMission = null){
        $link = Helper::getUrl("Mission", "createMission");
        $required = true;
        if(is_numeric($idMission))
        {
            $required = false;
            $link = Helper::getUrl("Mission", "updateMission")."?idMission=".$idMission;
        }

        return [
            "config"=>[
                "method"=>"POST",
                "action"=>$link,
                "class"=>"formDisabled",
                "id"=>"formMission",
                "submit"=>"Valider"
            ],

            "fields"=>[
                "nomMission"=>[
                    "type"=>"text",
                    "placeholder"=>"nom de la mission",
                    "label"=>"Entrez le nom de la mission : ",
                    "class"=>"",
                    "id"=>"nomMission",
                    "required"=>$required,
                    "uniq" => ["table" => "mission", "column" => "nomMission", "class" => Mission::class],
                    "errorMsg"=>"Ce nom de mission est déja utlisé"
                ],
                "description"=>[
                    "type"=>"textarea",
                    "placeholder"=>"Description",
                    "label"=>"Entrez la description de la mission : ",
                    "class"=>"",
                    "id"=>"description",
                    "rows"=>5,
                    "cols"=>30,
                    "required"=>false,
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ],
                "marquageFinPartie"=>[
                    "type" => "select",
                    "value" => [
                        0=>[
                            "value"=>1,
                            "label"=>"Progressif"
                        ],
                        1=>[
                            "value"=>2,
                            "label"=>"Fin de partie"
                        ],
                        2=>[
                            "value"=>3,
                            "label"=>"Progressif et Fin de partie"
                        ],
                    ],
                    "label" => "Modifier le type de marquage:",
                    "errorMsg" => "marquage incorrecte",
                    "required" => $required,
                    "config" =>[
                        "required" => $required,
                        "form"=>"formMission",
                        "defaultValue" => "type de marquage",
                        "name" => "marquageFinPartie"
                    ]
                ],
                "nombrePointPossiblePartie"=>[
                    "type"=>"number",
                    "value"=>15,
                    "label"=>"Entrez le nombre de point possible par partie : ",
                    "class"=>"",
                    "id"=>"",
                    "min" => 1,
                    "max" => 45,
                    "required"=>$required,
                    "errorMsg"=>"Une mission ne peut pas rapporter plus de 45 points par partie"
                ],
                "nombrePointPossibleTour"=>[
                    "type"=>"number",
                    "value"=>15,
                    "min" => 1,
                    "max" => 45,
                    "label"=>"Entrez le nombre de point possible par tour : ",
                    "class"=>"",
                    "id"=>"",
                    "required"=>$required,
                    "errorMsg"=>"Une mission ne peut pas rapporter plus de 15 points par tour"
                ],
                "idCategorie"=>                    [
                    "type" => "select",
                    "value" => $listFaction,
                    "label" => "Modifier la catégorie:",
                    "errorMsg" => "Le role n'est pas valide",
                    "required" => $required,
                    "config" =>[
                        "required" => $required,
                        "form"=>"formMission",
                        "defaultValue" => "Catégories",
                        "name" => "idCategorie"
                    ]
                ]
            ]
        ];
    }
}