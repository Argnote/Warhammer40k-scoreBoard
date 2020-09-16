<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\mission;
use warhammerScoreBoard\models\Tour;

class TourManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Tour::class, 'tour');
    }

    public function getTour(array $data = ["*"], array $conditions = null)
    {
        $requete = new QueryBuilder(Tour::class, "tour");
        $requete->querySelect($data);
        $requete->queryFrom();
        $requete->queryJoin("tour","partie","idPartie","idPartie");
        if(!empty($conditions))
        {
            foreach ($conditions as $condition )
            {
                $requete->queryWhere($condition[0], $condition[1], $condition[2], $condition[3]);
            }
        }
        $requete->queryOrderBy("numeroTour","ASC");
        return $requete->queryGetArrayToArray();
    }
}