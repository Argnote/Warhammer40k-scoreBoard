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

        $archived = "";
        switch ($mission->getArchived()):
            case 0:
                $archived="Mission active";
                break;
            case 1:
                $archived="Mission inactive";
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
                "type"=>"data",
                "admin"=>true
            ],
            "marquage"=>[
                "label"=>"Type de marquage : ",
                "value"=>$marquage,
                "type"=>"data",
                "admin"=>true
            ],
            "nombrePointPossiblePartie"=>[
                "label"=>"Nombre de points par partie : ",
                "value"=>$mission->getNombrePointPossiblePartie(),
                "type"=>"data",
                "admin"=>true
            ],
            "nombrePointPossibleTour"=>[
                "label"=>"Nombre de points par tour : ",
                "value"=>$mission->getNombrePointPossibleTour(),
                "type"=>"data",
                "admin"=>true
            ],
            "categorie"=>[
                "label"=>"Catégorie : ",
                "value"=>$mission->getNomCategorie(),
                "type"=>"data",
                "admin"=>true
            ],
            "archived"=>[
                "label"=>"Archivé : ",
                "value"=>$archived,
                "type"=>"data",
                "admin"=>true
            ],
        ];
    }
}