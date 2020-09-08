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

    public function getArmee(array $conditions = null)
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
        $requete->queryOrderBy("idFaction,nomArmee","ASC","faction");
        return $requete->queryGetArray();
    }
}