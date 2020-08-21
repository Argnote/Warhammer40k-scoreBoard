<?php use warhammerScoreBoard\core\Helper; ?>
<div>
  <h1>Connexion</h1>
    <?php $this->addModal("form", $configFormUser); ?>
</br>
<a href="/home">Retour à l'accueil</a>
    </br>
    <a href="<?= Helper::getUrl("User","forgotPassword")?>">Mot de passe oublié</a>
</div>
