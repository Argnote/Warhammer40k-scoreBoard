<?php use warhammerScoreBoard\core\Helper; ?>
<div>
  <h2>Connexion</h2>
    <?php if(isset($errors)):
    $this->addModal("errors",$errors);
    endif;?>
    <?php $this->addModal("form", $configFormUser); ?>
</br>
<a href="<?= Helper::getUrl("Home","default")?>">Retour à l'accueil</a>
    </br>
<!--    <a href="--><?//= Helper::getUrl("User","forgotPassword")?><!--">Mot de passe oublié</a>-->
</div>
