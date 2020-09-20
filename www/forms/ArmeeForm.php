<?php


namespace warhammerScoreBoard\forms;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\models\Armee;

class ArmeeForm
{
    public static function getForm(array $listFaction,int $idArmee = null){
        $link = Helper::getUrl("Armee", "createArmee");
        $required = true;
        if(is_numeric($idArmee))
        {
            $required = false;
            $link = Helper::getUrl("Armee", "updateArmee")."?idArmee=".$idArmee;
        }

        return [
            "config"=>[
                "method"=>"POST",
                "action"=>$link,
                "class"=>"formDisabled",
                "id"=>"formArmee",
                "submit"=>"Valider"
            ],

            "fields"=>[
                "nomArmee"=>[
                    "type"=>"text",
                    "placeholder"=>"nom de l'armée",
                    "label"=>"Entrez le nom de l'armée : ",
                    "class"=>"",
                    "id"=>"nomArmee",
                    "required"=>$required,
                    "uniq" => ["table" => "armee", "column" => "nomArmee", "class" => Armee::class],
                    "errorMsg"=>"Ce nom d'armée est déja utlisé"
                ],
                "idFaction"=>[
                    "type" => "select",
                    "value" => $listFaction,
                    "label" => "Modifier la faction :",
                    "errorMsg" => "Le la faction n'est pas valide",
                    "required" => $required,
                    "config" =>[
                        "required" => $required,
                        "form"=>"formArmee",
                        "defaultValue" => "Faction",
                        "name" => "idFaction"
                    ]
                ],
                "archived"=>[
                    "type" => "select",
                    "value" => [
                        0=>[
                            "value"=>"false",
                            "label"=>"Armée Active"
                        ],
                        1=>[
                            "value"=> true,
                            "label"=>"Armée Innactive"
                        ],
                    ],
                    "label" => "statut de l'armée :",
                    "errorMsg" => "Archivage incorrecte",
                    "required" => $required,
                    "config" =>[
                        "required" => $required,
                        "form"=>"formArmee",
                        "defaultValue" => "statut de l'armée",
                        "name" => "archived"
                    ]
                ]

            ]

        ];
    }
}