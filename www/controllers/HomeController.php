<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\LoginForm;
use warhammerScoreBoard\models\mission;

class HomeController extends Controller
{
    public function defaultAction()
    {
        $myView = new View("home", "front");

        //Affichage du formulaire de connexion dans la card de connexion d'un ami
        if(!empty($_SESSION["idUtilisateur1"]) && empty($_SESSION["idUtilisateur2"]))
        {
            $configFormUser = LoginForm::getForm();
            $myView->assign("configFormUser", $configFormUser);
        }
    }

    public function getMentionLegalAction()
    {
        $message = Message::mentionsLegal();
        $myView = new View("message","front");
        $myView->assign("message",$message);
    }

    public function getCharteAction()
    {
        new View("charte","front");
    }
}
