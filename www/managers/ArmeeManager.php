<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Armee;

class ArmeeManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Armee::class, 'armee');
    }

    public function getManyArmee(array $conditions = null, bool $activeOnly = null)
    {
        $requete = new QueryBuilder(Armee::class, "armee");
        $requete->querySelect(["idArmee","nomArmee","nomFaction"]);
        $requete->queryFrom();
        $requete->queryJoin("armee","faction","idFaction","idFaction");
        if(!empty($conditions))
        {
            foreach ($conditions as $condition )
            {
                $requete->queryWhere($condition[0], $condition[1], $condition[2]);
            }
        }
        if($activeOnly == true)
        {
            $requete->queryWhere("archived","=", "0");
        }
        $requete->queryOrderBy("idFaction,nomArmee","ASC","faction");
        return $requete->queryGetArrayToArray();
    }

    public function getArmee(int $idArmee)
    {
        $requete = new QueryBuilder(Armee::class, "armee");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        $requete->queryJoin("armee","faction","idFaction","idFaction");
        $requete->queryWhere("idArmee","=",$idArmee);
        return $requete->queryGetValue();
    }

    public function getAllFaction()
    {
        $requete = new QueryBuilder(Armee::class, "faction");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        return $requete->queryGetArrayToArray();
    }

    public function factionExist(int $idFaction)
    {
        $requete = new QueryBuilder(Armee::class, "faction");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        $requete->queryWhere("idFaction","=", $idFaction);
        return $requete->queryGetValue();
    }
}