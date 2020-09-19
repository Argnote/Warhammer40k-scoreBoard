<?php


namespace warhammerScoreBoard\getData;


use warhammerScoreBoard\core\Helper;

class GetListDataUtilisateur
{
    public static function getData($listUtilisateur)
    {
        $liste = array();
        $liste["head"] = [
            "idUtilisateur"=>[
                "class"=>"col-sm-1",
                "type"=>"label",
                "label"=>"ID de l'utilisateur"
            ],
            "pseudo"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"Pseudo de l'utilisateur"
            ],
            "email"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"Email de l'utilisateur"
                ],
            "role"=>[
                "class"=>"col-sm-2",
                "type"=>"label",
                "label"=>"Role de l'utilisateur"
            ],
            "ConsultationUtilisateur"=>[
                "class"=>"col-sm-3",
                "type"=>"label",
                "label"=>"Consulter l'utilisateur"
            ]
        ];

        foreach ($listUtilisateur as $utilisateur)
        {
            $item = [
                "idUtilisateur"=>[
                    "class"=>"col-sm-1",
                    "type"=>"label",
                    "label"=>$utilisateur->getIdUtilisateur()??"Non renseigné"
                ],
                "pseudo"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$utilisateur->getPseudo()??"Non renseigné"
                ],
                "email"=>[
                    "class"=>"col-sm-3",
                    "type"=>"label",
                    "label"=>$utilisateur->getEmail()??"Non renseigné"
                ],
                "role"=>[
                    "class"=>"col-sm-2",
                    "type"=>"label",
                    "label"=>$utilisateur->getNomRole()??"Non renseigné"
                ],
                "ConsultationUtilisateur"=>[
                    "class"=>"col-sm-3",
                    "type"=>"link",
                    "label"=>"Consulter l'utilisateur",
                    "link"=> Helper::getUrl("Utilisateur","getUtilisateur")."?idUtilisateur=".$utilisateur->getIdUtilisateur()??""
                ]
            ];
            $liste[] = $item;
        }
        return $liste;
    }
}
