<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\tools\TransformArrayToSelected;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\ArmeeForm;
use warhammerScoreBoard\getData\GetDataArmee;
use warhammerScoreBoard\getData\getListDataArmee;
use warhammerScoreBoard\managers\ArmeeManager;
use warhammerScoreBoard\models\Armee;

class ArmeeController extends \warhammerScoreBoard\core\Controller
{
    public function getListArmeeAction()
    {
        Helper::checkAdmin();
        $armeeManager = new ArmeeManager();
        $armee = $armeeManager->getManyArmee();
        $listArmee = getListDataArmee::getData($armee);
//        echo "<pre>";
//        print_r($listMission);
//        echo "</pre>";
        $myView = new View("listData","front");
        $myView->assignTitle("Liste des armées");
        $myView->assignLink("create",Helper::getUrl("Armee","createArmee"),"Ajouter une armée");
        $myView->assign("listData", $listArmee);
    }

    public function getArmeeAction()
    {
        Helper::checkAdmin();
        if(empty($_GET["idArmee"]))
            $this->redirectTo("Armee","getListArmee");
        $armeeManager = new ArmeeManager();

        $result = $armeeManager->getArmee($_GET["idArmee"]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurArmee();
            $this->redirectTo("Errors", "errorMessage");
        }
        $armee = GetDataArmee::getData($result);
        $myView = new View("getData","front");
        $myView->assignTitle("Consultation Armee");
        $myView->assign("data",$armee);
        $myView->assignLink("update",Helper::getUrl("Armee","updateArmee")."?idArmee=".$_GET["idArmee"],"Modifier l'armée");
    }

    public function createArmeeAction()
    {
        Helper::checkAdmin();
        $armeeManager = new ArmeeManager();
        $faction = $armeeManager->getAllFaction();
        $faction = TransformArrayToSelected::transformArrayToSelected($faction,"idFaction","nomFaction");
        $form = ArmeeForm::getForm($faction);
        $myView = new View("createData","front");

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($form, $_POST);
            if (empty($errors))
            {
                $armee = new Armee();
                $armee = $armee->hydrate($_POST);
                $armeeManager->save($armee);
                $this->redirectTo("Armee", "getListArmee");
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }
        $myView->assignTitle("Nouvelle Armée");
        $myView->assign("createData",$form);


    }

    public function updateArmeeAction()
    {
        Helper::checkAdmin();
        if(empty($_GET["idArmee"]) || !is_numeric($_GET["idArmee"]))
            $this->redirectTo("Armee", "getListArmee");

        $armeeManager = new ArmeeManager();

        $result = $armeeManager->getArmee($_GET["idArmee"]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurArmee();
            $this->redirectTo("Errors", "errorMessage");
        }

        $faction = $armeeManager->getAllFaction();
        $faction = TransformArrayToSelected::transformArrayToSelected($faction,"idFaction","nomFaction");
        $form = ArmeeForm::getForm($faction,$_GET["idArmee"]);
        $myView = new View("updateData","front");

        if($_SERVER["REQUEST_METHOD"] == "POST") {
            $validator = new Validator();
            $errors = $validator->checkForm($form, $_POST);
            if (empty($errors))
            {
                $armee = new Armee();
                $armee = $armee->hydrate($_POST);
                $armee->setIdArmee($_GET["idArmee"]);
                $armeeManager->save($armee);
                $this->redirectTo("Armee", "getArmee","?idArmee=".$_GET["idArmee"]);
            }
            else
            {
                $errors = array_unique($errors);
                $myView->assign("errors", $errors);
            }
        }
        $myView->assignTitle("Modification armee");
        $myView->assign("updateData",$form);
    }
}