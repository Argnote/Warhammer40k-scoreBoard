<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\models\Livre;
use warhammerScoreBoard\models\modelsFusion\GetPartiePlayed;

class LivreManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Livre::class, 'livre');
    }

    public function getAllLivre()
    {
        $requete = new QueryBuilder(Livre::class, "livre");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        return $requete->queryGetArray();
    }

    public function getAllLivreToArray()
    {
        $requete = new QueryBuilder(Livre::class, "livre");
        $requete->querySelect(["*"]);
        $requete->queryFrom();
        return $requete->queryGetArrayToArray();
    }

    public function getLivre(int $livre)
    {
        $requete = new QueryBuilder(Livre::class, "livre");
        $requete->querySelect(["idLivre"]);
        $requete->queryFrom();
        $requete->queryWhere("idLivre","=", $livre);
        return $requete->queryGetValue();
    }
}