<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\modelsFusion\GetPoint;
use warhammerScoreBoard\models\Point;

class PointManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Point::class, 'point');
    }

    public function getPoint(array $data = ["*"], array $conditions = null)
    {
        {
            $requete = new QueryBuilder(GetPoint::class, "point");
            $requete->querySelect($data);
            $requete->queryFrom();
            $requete->queryJoin("point","joueur","idjoueur","idjoueur");
            $requete->queryJoin("point","tour","idTour","idTour");
            $requete->queryJoin("point","mission","idMission","idMission");
            $requete->queryJoin("mission", "livre", "idLivre", "idLivre");
            $requete->queryJoin("mission","categorie","idCategorie","idCategorie");
            if(!empty($conditions))
            {
                foreach ($conditions as $condition )
                {
                    $requete->queryWhere($condition[0], $condition[1], $condition[2]);
                }
            }
            $requete->queryOrderBy("numeroTour,typeCategorie,nomMission","ASC");
            return $requete->queryGetArrayToArray();
        }
    }

    public function totalPoint(int $idJoueur, int $mission = null)
    {
        $requete = new QueryBuilder(Point::class, "point");
        $requete->querySelect(["SUM(nombrePoint) as total"]);
        $requete->queryFrom();
        $requete->queryWhere("idJoueur", "=", $idJoueur);
        if (!empty($mission))
            $requete->queryWhere("idMission", "=", $mission);
        return $requete->queryGetValueToArray();
    }
}