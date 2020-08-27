<?php
use warhammerScoreBoard\core\Helper;
?>
<div>
    <h2>Mot de passe oublié</h2>
    <?php $this->addModal("form", $configFormUser); ?>
    </br>
    <a href="<?= Helper::getUrl("Home","default")?>">Retour à l'accueil</a>
</div>