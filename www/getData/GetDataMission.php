<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\models\Mission;

class GetDataMission
{
    public static function getData(Mission $mission)
    {
        $marquage = "";
        switch ($mission->getMarquageFinPartie()):
            case 1:
                $marquage="Progressif";
                break;
            case 2:
                $marquage="Fin de partie";
                break;
            case 3:
                $marquage="Progressif et Fin de partie";
                break;
        endswitch;

        return [
            "id"=>[
                "label"=>"Id de la mission : ",
                "value"=>$mission->getIdMission(),
                "type"=>"data",
                "admin"=>true
            ],
            "nom"=>[
                "label"=>"Nom de la mission : ",
                "value"=>$mission->getNomMission(),
                "type"=>"data",
                "admin"=>true
            ],
            "description"=>[
                "label"=>"Description : ",
                "value"=>$mission->getDescription(),
                "type"=>"data"
            ],
            "marquage"=>[
                "label"=>"Type de marquage : ",
                "value"=>$marquage,
                "type"=>"data"
            ],
            "nombrePointPossiblePartie"=>[
                "label"=>"Nombre de points par partie : ",
                "value"=>$mission->getNombrePointPossiblePartie(),
                "type"=>"data"
            ],
            "nombrePointPossibleTour"=>[
                "label"=>"Nombre de points par tour : ",
                "value"=>$mission->getNombrePointPossibleTour(),
                "type"=>"data"
            ],
            "categorie"=>[
                "label"=>"Catégorie : ",
                "value"=>$mission->getNomCategorie(),
                "type"=>"data"
            ],
        ];
    }
}