<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\getData\GetDataMission;
use warhammerScoreBoard\getData\GetListDataMission;
use warhammerScoreBoard\managers\MissionManager;

class MissionController extends Controller
{
    public function getListMissionAction()
    {
        Helper::checkAdmin();
        $missionManager = new MissionManager();
        $missions = $missionManager->getManyMission();
        $listMission = GetListDataMission::getData($missions);
//        echo "<pre>";
//        print_r($listMission);
//        echo "</pre>";
        $myView = new View("listData","front");
        $myView->assign("title", "Liste des missions");
        $myView->assign("listData", $listMission);
    }

    public function getMissionAction()
    {
        Helper::checkAdmin();
        if(empty($_GET["idMission"]))
            $this->redirectTo("Mission","getListMission");
        $missionManager = new MissionManager();

        $result = $missionManager->getMission($_GET["idMission"]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurMission();
            $this->redirectTo("Errors", "errorMessage");
        }
        $mission = GetDataMission::getData($result);
        $myView = new View("getData","front");
        $myView->assign("title","Description de la mission");
        $myView->assign("data",$mission);


    }
}