<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\getData\GetListDataMission;
use warhammerScoreBoard\managers\MissionManager;

class MissionController extends Controller
{
    public function getListMissionAction()
    {
        Helper::checkAdmin();
        $missionManager = new MissionManager();
        $missions = $missionManager->getMission();
        $listMission = GetListDataMission::getData($missions);
//        echo "<pre>";
//        print_r($listMission);
//        echo "</pre>";
        $myView = new View("listData","front");
        $myView->assign("title", "Liste des missions");
        $myView->assign("listData", $listMission);
    }
}