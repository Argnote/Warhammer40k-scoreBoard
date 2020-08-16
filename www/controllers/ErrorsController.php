<?php

namespace warhammerScoreBoard\controllers;

use warhammerScoreBoard\core\Controller;
use warhammerScoreBoard\core\View;

class ErrorsController extends Controller
{
  public function quatreCentQuatreAction(){
    $myView = new View('404', 'front');
  }
}

 ?>
