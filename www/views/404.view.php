<?php

use warhammerScoreBoard\core\Helper;

if(empty($_SESSION['role'])) {
  $chemin = Helper::getUrl("Home","default");
}else
  $chemin = Helper::getUrl("User","default");


?>
<div>
  <h1>Erreur 404</h1>
  <p>Vous êtes perdu ?</p>
  <a href="<?php echo $chemin; ?>">Retour à l'accueil</a>
</div>
