<?php

use warhammerScoreBoard\core\Helper;

?>
<h2>Choix des statistiques</h2>
<div class="row">
    <?php if(!empty($_SESSION["idUtilisateur1"])):?>
    <div class="col-sm-6">
        <div class="col-inner homeCard">
            <h3>Statistiques personnels</h3>
                <a href="<?= Helper::getUrl("Statistique","getStatistiqueUtilisateur")?>">Consulter ses statistiques personnels</a>
            </div>
        </div>
    <?php endif;?>
    <div class="col-sm-6">
        <div class="col-inner homeCard">
            <h3>Statistiques générales</h3>
            <a href="<?= Helper::getUrl("Statistique","getStatisqueGenerale")?>">Consulter les statistiques générales</a>
        </div>
    </div>
</div>