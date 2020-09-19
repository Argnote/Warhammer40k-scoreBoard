<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\core\Helper;

class GetListDataPartie
{
    public static function getData($listPartie)
    {
        $liste = array();
        $liste["head"] = [
            "nomArmee"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"Votre armee"
            ],
            "adversaire"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"Votre adversaire"
            ],
            "date"=>[
                "class"=>"col-sm-2",
                "type"=>"label",
                "label"=>"Date de la partie"
            ],
            "resultat"=>[
                "class"=>"col-sm-2",
                "type"=>"label",
                "label"=>"Résultat"
            ],
            "Details"=>[
                "class"=>"col-sm-2",
                "type"=>"label",
                "label"=>"Détails"
            ]
        ];

        foreach ($listPartie as $partie)
        {
            $statut = "";
            switch ($partie["gagnant"]):
            case -1:
                $statut="Défaite";
                break;
            case 0:
                $statut="En cours";
                break;
            case 1:
                $statut="Victoire";
                break;
            case 2:
                $statut="Egalité";
                break;
            endswitch;

            $armeeAdversaire = $partie["ArmeeJoueur2"]??"Non sélectionné";
            $item = [
                "nomArmee"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$partie["nomArmee"]??'Non sélectionné'
                ],
                "adversaire"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$partie["nomJoueur2"]." (".$armeeAdversaire.")"
                ],
                "date"=>[
                    "class"=>"col-sm-2",
                    "type"=>"label",
                    "label"=>date("d-m-Y", strtotime($partie["dateDebut"]))
                ],
                "statut"=>[
                    "class"=>"col-sm-2",
                    "type"=>"label",
                    "label"=>$statut
                ],
                "Details"=>[
                    "class"=>"col-sm-2",
                    "type"=>"link",
                    "label"=>"Consulter la partie",
                    "link"=>Helper::getUrl("Partie","historiquePartie")."?partie=".$partie["idPartie"]
                ]
            ];
            $liste[] = $item;
        }
        return $liste;
    }
}
