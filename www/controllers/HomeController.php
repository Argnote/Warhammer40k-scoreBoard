<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\models\mission;

class HomeController extends Controller
{
    public function defaultAction()
    {
        $requete = new QueryBuilder(Mission::class, "mission");
        $requete->querySelect("*");
        $requete->queryManyFrom(["mission"]);
        $requete->queryJoin("mission","categorie","idCategorie","idCategorie");
        $requete->queryWhere("typeCategorie", "=", "1");
        $result = $requete->queryGetArray();
        print_r($result);
        Helper::checkDisconnected();
        $myView = new View("home", "front");
    }
}
