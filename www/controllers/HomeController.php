<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\core\View;

class HomeController extends Controller
{
    public function defaultAction()
    {
        Helper::checkDisconnected();
        $myView = new View("home", "front");
    }
}
