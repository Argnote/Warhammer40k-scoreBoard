<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\core\Helper;

class getListDataArmee
{
    public static function getData($listArmee)
    {
        $liste = array();
        $liste["head"] = [
            "idArmee"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"id de l'armée"
            ],
            "nomArmee"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"nom de l'armée"
            ],
            "NomFaction"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"nom de la faction"
            ],
            "ConsultationArmee"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"Consulter l'armée"
            ]
        ];

        foreach ($listArmee as $armee)
        {
            $item = [
                "idMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$armee["idArmee"]
                ],
                "nomMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$armee["nomArmee"]
                ],
                "NomCategorie"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$armee["nomFaction"]
                ],
                "ConsultationMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"link",
                    "label" => "Consulter l'armée",
                    "link"=>Helper::getUrl("Armee","getArmee")."?idArmee=".urlencode($armee["idArmee"]),
                ]
            ];
            $liste[] = $item;
        }
        return $liste;
    }
}