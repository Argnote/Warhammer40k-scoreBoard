<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\core\Helper;

class GetListDataMission
{
    public static function getData($listMission)
    {
        $liste = array();
        $liste["head"] = [
                "idMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>"idMission"
                ],
                "nomMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>"nom de la mission"
                ],
                "NomCategorie"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>"nom de la catégorie"
                ],
                "ConsultationMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>"Consulter la mission"
                ]
        ];

        foreach ($listMission as $mission)
        {
            $item = [
                "idMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$mission["idMission"]
                ],
                "nomMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$mission["nomMission"]
                ],
                "NomCategorie"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$mission["nomCategorie"]
                ],
                "ConsultationMission"=>[
                    "class"=>"col-sm-3",
                    "type"=>"link",
                    "label" => "Consulter la mission",
                    "link"=>Helper::getUrl("Mission","getMission")."?idMission=".urlencode($mission["idMission"]),
                ]
            ];
            $liste[] = $item;
        }
        return $liste;
    }
}