<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\models\Armee;

class GetDataArmee
{
    public static function getData(Armee $armee)
    {

        $archived = "";
        switch ($armee->getArchived()):
            case 0:
                $archived="Armée active";
                break;
            case 1:
                $archived="Armée inactive";
                break;
        endswitch;

        return [
            "id"=>[
                "label"=>"Id de l'armee : ",
                "value"=>$armee->getIdArmee(),
                "type"=>"data",
                "admin"=>true
            ],
            "nom"=>[
                "label"=>"Nom de l'armée : ",
                "value"=>$armee->getNomArmee(),
                "type"=>"data",
                "admin"=>true
            ],
            "idFaction"=>[
                "label"=>"Id de la faction : ",
                "value"=>$armee->getIdFaction(),
                "type"=>"data",
                "admin"=>true
            ],
            "nomFaction"=>[
                "label"=>"Nom de la faction : ",
                "value"=>$armee->getNomFaction(),
                "type"=>"data",
                "admin"=>true
            ],
            "archived"=>[
                "label"=>"Archivé : ",
                "value"=>$archived,
                "type"=>"data"
            ],
        ];
    }
}