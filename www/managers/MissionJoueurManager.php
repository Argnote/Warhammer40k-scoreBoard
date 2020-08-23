<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\mission;
use warhammerScoreBoard\models\MissionJoueur;

class MissionJoueurManager extends Manager
{
    public function __construct()
    {
        parent::__construct(MissionJoueur::class, 'joueur_has_mission');
    }

    public function getMissionJoueur(array $data = ["*"], array $conditions = null)
    {
        $requete = new QueryBuilder(MissionJoueur::class, "joueur_has_mission");
        $requete->querySelect($data);
        $requete->queryFrom();
        $requete->queryJoin("joueur_has_mission","mission","idMission","idMission");
        $requete->queryJoin("mission","categorie","idCategorie","idCategorie");
        $requete->queryJoin("joueur_has_mission","joueur","idJoueur","idJoueur");
        if(!empty($conditions))
        {
            foreach ($conditions as $condition )
            {
                $requete->queryWhere($condition[0], $condition[1], $condition[2]);
            }
        }

        $requete->queryOrderBy("typeCategorie,nomMission","ASC");
        return $requete->queryGetArray();
    }
}