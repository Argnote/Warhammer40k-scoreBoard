<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\connection\ResultInterface;
use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\InitialisationPartieForm;
use warhammerScoreBoard\managers\missionManager;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\mission;
use warhammerScoreBoard\models\Partie;
use warhammerScoreBoard\models\Utilisateur;

class PartieController extends Controller
{
    public function initialisationPartieAction()
    {
        $myView = new View("initialisationPartie", "front");
        $initPartie = InitialisationPartieForm::getForm();
        $myView->assign("initPartie", $initPartie);
        $missions = new missionManager();
        $missionsPrincipale = $missions->getMission(["idMission","nomMission"],["typeCategorie","=","1"]);
        $myView->assign("missionPrincipale", ["option"=>$missionsPrincipale]);
        $missionsSecondaire = $missions->getMission(["idMission","nomMission"],["typeCategorie","=","2"]);
        $myView->assign("missionSecondaire", ["option"=>$missionsSecondaire]);

    }

    public function creationPartieAction()
    {
        $partieM = new PartieManager();

    }
}