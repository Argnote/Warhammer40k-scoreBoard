<?php
use HotelFactory\core\Helper;
?>
<div>
    <h1>Nouveau mot de passe</h1>
    <?php $this->addModal("form", $configFormUser); ?>
    </br>
    <a href="<?= Helper::getUrl("Home","default")?>">Retour à l'accueil</a>
</div>