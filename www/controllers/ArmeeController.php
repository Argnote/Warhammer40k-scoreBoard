<?php


namespace warhammerScoreBoard\controllers;


use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\tools\TransformArrayToSelected;
use warhammerScoreBoard\core\Validator;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\ArmeeForm;
use warhammerScoreBoard\getData\GetDataArmee;
use warhammerScoreBoard\getData\GetListDataArmee;
use warhammerScoreBoard\managers\ArmeeManager;
use warhammerScoreBoard\models\Armee;

class ArmeeController extends \warhammerScoreBoard\core\Controller
{
    //Affichage de la liste des armées pour un admin
    public function getListArmeeAction()
    {
        Helper::checkAdmin();

        //Récupération des armées
        $armeeManager = new ArmeeManager();
        $armee = $armeeManager->getManyArmee();

        //Formatage des données avant affichage
        $listArmee = GetListDataArmee::getData($armee);
        $myView = new View("listData","front");
        $myView->assignTitle("Liste des armées");
        $myView->assignLink("create",Helper::getUrl("Armee","createArmee"),"Ajouter une armée");
        $myView->assign("listData", $listArmee);
    }

    //Affichage d'une armées pour un admin
    public function getArmeeAction()
    {
        Helper::checkAdmin();

        //Récupération d'une armée grace au parametre d'url idArmee
        if(empty($_GET["idArmee"]) || !is_numeric($_GET["idArmee"]))
            $this->redirectTo("Armee","getListArmee");
        $armeeManager = new ArmeeManager();
        $result = $armeeManager->getArmee($_GET["idArmee"]);

        //Formatage des données avant affichage si il y un résultat
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

    //création d'une armées pour un admin
    public function createArmeeAction()
    {
        Helper::checkAdmin();

        //Création du formulaire
        $armeeManager = new ArmeeManager();
        $faction = $armeeManager->getAllFaction();
        $faction = TransformArrayToSelected::transformArrayToSelected($faction,"idFaction","nomFaction");
        $form = ArmeeForm::getForm($faction);
        $myView = new View("createData","front");

        //Vérification des données avant enregistrement 
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

    //Modification d'une armées pour un admin
    public function updateArmeeAction()
    {
        Helper::checkAdmin();

        //Récupération d'une armée grace au parametre d'url idArmee
        if(empty($_GET["idArmee"]) || !is_numeric($_GET["idArmee"]))
            $this->redirectTo("Armee", "getListArmee");

        $armeeManager = new ArmeeManager();

        //Erreur si il n'y a pas d'armée trouvée
        $result = $armeeManager->getArmee($_GET["idArmee"]);
        if(empty($result))
        {
            $_SESSION["messageError"] = Message::erreurArmee();
            $this->redirectTo("Errors", "errorMessage");
        }

        //Formatage du formulaire avant affichage
        $faction = $armeeManager->getAllFaction();
        $faction = TransformArrayToSelected::transformArrayToSelected($faction,"idFaction","nomFaction");
        $form = ArmeeForm::getForm($faction,$_GET["idArmee"]);
        $myView = new View("updateData","front");

        //vérification des données avant remplacement dans la db 
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