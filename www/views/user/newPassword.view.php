<?php
use warhammerScoreBoard\core\Helper;
?>
<div>
    <h2>Nouveau mot de passe</h2>
    <?php $this->addModal("form", $configFormUser); ?>
    </br>
    <a href="<?= Helper::getUrl("Home","default")?>">Retour à l'accueil</a>
</div>