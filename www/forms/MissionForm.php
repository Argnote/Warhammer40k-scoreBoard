<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\models\Mission;

class MissionForm
{
    public static function getForm(array $listCategorie, int $idMission = null, Mission $actuallyValue = null){
        $link = Helper::getUrl("Mission", "createMission");
        $required = true;
        if(is_numeric($idMission))
        {
            $required = false;
            $link = Helper::getUrl("Mission", "updateMission")."?idMission=".$idMission;
        }
        if(empty($actuallyValue))
            $actuallyValue = new Mission();
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
                    "placeholder"=>$actuallyValue->getNomMission(),
                    "label"=>"Entrez le nom de la mission : ",
                    "classGrill"=>"col-sm-6",
                    "id"=>"nomMission",
                    "required"=>$required,
                    "uniq" => ["table" => "mission", "column" => "nomMission", "class" => Mission::class],
                    "errorMsg"=>"Ce nom de mission est déja utlisé"
                ],
                "description"=>[
                    "type"=>"textarea",
                    "value"=>strip_tags($actuallyValue->getDescription()),
                    "placeholder"=>"Description",
                    "label"=>"Entrez la description de la mission : ",
                    "classGrill"=>"col-sm-6",
                    "id"=>"description",
                    "rows"=>10,
                    "cols"=>40,
                    "required"=>false,
                    "errorMsg"=>"Votre mot de passe de confirmation ne correspond pas"
                ],
                "marquageFinPartie"=>[
                    "classGrill"=>"col-sm-6",
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
                    "label" => "Modifier le type de marquage :",
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
                    "value"=>$actuallyValue->getNombrePointPossiblePartie()??15,
                    "label"=>"Entrez le nombre de point possible par partie : ",
                    "classGrill"=>"col-sm-6",
                    "id"=>"",
                    "min" => 1,
                    "max" => 45,
                    "required"=>$required,
                    "errorMsg"=>"Une mission ne peut pas rapporter plus de 45 points par partie"
                ],
                "nombrePointPossibleTour"=>[
                    "type"=>"number",
                    "value"=>$actuallyValue->getNombrePointPossibleTour()??15,
                    "min" => 1,
                    "max" => 45,
                    "label"=>"Entrez le nombre de point possible par tour : ",
                    "classGrill"=>"col-sm-6",
                    "id"=>"",
                    "required"=>$required,
                    "errorMsg"=>"Une mission ne peut pas rapporter plus de 15 points par tour"
                ],
                "idCategorie"=>                    [
                    "type" => "select",
                    "classGrill"=>"col-sm-6",
                    "value" => $listCategorie,
                    "label" => "Modifier la catégorie :",
                    "errorMsg" => "Le role n'est pas valide",
                    "required" => $required,
                    "config" =>[
                        "required" => $required,
                        "form"=>"formMission",
                        "defaultValue" => "Catégories",
                        "name" => "idCategorie"
                    ]
                ],
                "archived"=>[
                    "type" => "select",
                    "classGrill"=>"col-sm-6",
                    "value" => [
                        0=>[
                            "value"=>"false",
                            "label"=>"Mission Active"
                        ],
                        1=>[
                            "value"=> true,
                            "label"=>"Mission Innactive"
                        ],
                    ],
                    "label" => "statut de la mission :",
                    "errorMsg" => "Archivage incorrecte",
                    "required" => $required,
                    "config" =>[
                        "required" => $required,
                        "form"=>"formMission",
                        "defaultValue" => "statut de la mission",
                        "name" => "archived"
                    ]
                ]

            ]

        ];
    }
}