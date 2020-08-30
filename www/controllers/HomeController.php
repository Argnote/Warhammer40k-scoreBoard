<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\QueryBuilder;
use warhammerScoreBoard\core\View;
use warhammerScoreBoard\forms\LoginForm;
use warhammerScoreBoard\models\mission;

class HomeController extends Controller
{
    public function defaultAction()
    {
        $myView = new View("home", "front");
        if(!empty($_SESSION["idUtilisateur1"]) && empty($_SESSION["idUtilisateur2"]))
        {
            $configFormUser = LoginForm::getForm();
            $myView->assign("configFormUser", $configFormUser);
        }
    }
}
