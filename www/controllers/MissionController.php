<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\tools\TransformArrayToSelected;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\MissionForm;
use warhammerScoreBoard\getData\GetDataMission;
use warhammerScoreBoard\getData\GetListDataMission;
use warhammerScoreBoard\managers\MissionManager;
use warhammerScoreBoard\models\Mission;

class MissionController extends Controller
{
    //Affichage de la liste des missions pour un admin
    public function getListMissionAction()
    {
        Helper::checkAdmin();

        //Récupération des missions
        $missionManager = new MissionManager();
        $missions = $missionManager->getManyMission();
        $listMission = GetListDataMission::getData($missions);

        //Formatage des données avant affichage
        $myView = new View("listData","front");
        $myView->assignTitle("Liste des missions");
        $myView->assignLink("create",Helper::getUrl("Mission","createMission"),"Ajouter une mission");
        $myView->assign("listData", $listMission);
    }

    //Affichage d'une mission pour un admin
    public function getMissionAction()
    {
        Helper::checkAdmin();

        //Récupération d'une mission grace au parametre d'url idMission
        if(empty($_GET["idMission"]) || !is_numeric($_GET["idMission"]))
            $this->redirectTo("Mission","getListMission");
        $missionManager = new MissionManager();

        //Formatage des données avant affichage si il y un résultat
        $result = $missionManager->getMission($_GET["idMission"]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurMission();
            $this->redirectTo("Errors", "errorMessage");
        }
        $mission = GetDataMission::getData($result);
        $myView = new View("getData","front");
        $myView->assignTitle("Consultation mission");
        $myView->assign("data",$mission);
        $myView->assignLink("update",Helper::getUrl("Mission","updateMission")."?idMission=".$_GET["idMission"],"Modifier la mission");
    }

    //création d'une mission pour un admin
    public function createMissionAction()
    {
        Helper::checkAdmin();

        //Création du formulaire
        $missionManager = new MissionManager();
        $categorie = $missionManager->getAllCategorie();
        $categorie = TransformArrayToSelected::transformArrayToSelected($categorie,"idCategorie","nomCategorie");
        $form = MissionForm::getForm($categorie);
        $myView = new View("createData","front");

        //Vérification des données avant enregistrement 
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($form, $_POST);
            if (empty($errors))
            {
                $mission = new Mission();
                $mission = $mission->hydrate($_POST);
                $missionManager->save($mission);
                $this->redirectTo("Mission", "getListMission");
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }
        $myView->assignTitle("Nouvelle mission");
        $myView->assign("createData",$form);
    }

    //Modification d'une armées pour un admin
    public function updateMissionAction()
    {
        Helper::checkAdmin();

        //Récupération d'une mission grace au parametre d'url idMission
        if(empty($_GET["idMission"]) || !is_numeric($_GET["idMission"]))
            $this->redirectTo("Mission", "getListMission");

        $missionManager = new MissionManager();
        $result = $missionManager->getMission($_GET["idMission"]);

        //Erreur si il n'y a pas de mission trouvée
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurMission();
            $this->redirectTo("Errors", "errorMessage");
        }

        //Formatage du formulaire avant affichage
        $categorie = $missionManager->getAllCategorie();
        $categorie = TransformArrayToSelected::transformArrayToSelected($categorie,"idCategorie","nomCategorie");
        $form = MissionForm::getForm($categorie,$_GET["idMission"],$result);
        $myView = new View("updateData","front");

        //vérification des données avant remplacement dans la db 
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($form, $_POST);
            if (empty($errors))
            {
                $mission = new Mission();
                $mission = $mission->hydrate($_POST);
                $mission->setIdMission($_GET["idMission"]);
                $missionManager->save($mission);
                $this->redirectTo("Mission", "getMission","?idMission=".$_GET["idMission"]);
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }
        $myView->assignTitle("Modification de la mission");
        $myView->assign("updateData",$form);
    }
}