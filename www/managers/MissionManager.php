<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Mission;

class MissionManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Mission::class, 'mission');
    }

    public function getManyMission(array $data = ["*"], array $conditions = null)
    {
        $requete = new QueryBuilder(Mission::class, "mission");
        $requete->querySelect($data);
        $requete->queryFrom();
        $requete->queryJoin("mission","categorie","idCategorie","idCategorie");
        if(!empty($conditions))
        {
            foreach ($conditions as $condition )
            {
                $requete->queryWhere($condition[0], $condition[1], $condition[2]);
            }
        }
        $requete->queryOrderBy("typeCategorie,nomCategorie,nomMission","ASC");
        return $requete->queryGetArrayToArray();
    }

    public function getMission(int $idMission)
    {
        $requete = new QueryBuilder(Mission::class, "mission");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        $requete->queryJoin("mission","categorie","idCategorie","idCategorie");
        $requete->queryWhere("idMission","=", $idMission);
        return $requete->queryGetValue();
    }

    public function getCategorie(int $idMission)
    {
        $requete = new QueryBuilder(Mission::class, "mission");
        $requete->querySelect("idCategorie");
        $requete->queryFrom();
        $requete->queryWhere("idMission", "=", $idMission);
        return $requete->queryGetValueToArray();
    }
}