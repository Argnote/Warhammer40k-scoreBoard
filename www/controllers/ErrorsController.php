<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\View;

class ErrorsController extends Controller
{
  public function quatreCentQuatreAction(){
    $myView = new View('404', 'front');
  }

  public function errorMessageAction()
  {
      $view = new View("message", "front");
      $view->assign("message",$_SESSION["messageError"]);
      unset($_SESSION["messageError"]);
  }
}

 ?>
