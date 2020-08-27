<?php use warhammerScoreBoard\core\Helper;?>
<main>
  <h2>Inscription</h2>
    <?php
    if(isset($errors)):
        $this->addModal("errors",$errors);
    endif;?>
    <?php $this->addModal("form", $configFormUser); ?>

</br>
<a href="<?= Helper::getUrl("Utilisateur","login")?>">Se connecter</a>
</br>
<a href="<?= Helper::getUrl("Home","default")?>">Retour à l'accueil</a>
</main>
