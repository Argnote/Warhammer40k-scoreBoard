<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\tools\Message;
use warhammerScoreBoard\core\View;

class ErrorsController extends Controller
{
  //page d'erreur par default
  public function quatreCentQuatreAction(){
    $myView = new View('404', 'front');
  }

  public function errorMessageAction()
  {
      $view = new View("message", "front");
      //si il n'y a pas de message d'erreur, redirige vers 404
      if(empty($_SESSION["messageError"]))
          $this->redirectTo("Errors","quatreCentQuatre");

      //affichage de l'erreur
      $view->assign("message",$_SESSION["messageError"]);
      unset($_SESSION["messageError"]);
  }
}

 ?>
