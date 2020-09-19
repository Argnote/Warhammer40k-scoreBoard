<?php use warhammerScoreBoard\core\Helper;?>
<div class="row rowOdd">
    <div class="col-sm-3">
        Votre armee
    </div>
    <div class="col-sm-3">
        Votre adversaire
    </div>
    <div class="col-sm-2">
        Date de la partie
    </div>
    <div class="col-sm-2">
        Résultat
    </div>
    <div class="col-sm-2">
        Détails
    </div>
</div>
<?php
$i = 0;
foreach ($data as $partie):
?>
<div class="row <?php if($i % 2 != 0){echo "rowOdd";} ?>">
    <div class="col-sm-3">
        <?= $partie["nomArmee"]??'Non sélectionné'?>
    </div>
    <div class="col-sm-3">
        <?= $partie["nomJoueur2"]?> (<?= $partie["ArmeeJoueur2"]??'Non sélectionné'?>)</p>
    </div>
    <div class="col-sm-2">
        <?= $partie["dateDebut"]?>
    </div>
    <div class="col-sm-2">
        <?php switch ($partie["gagnant"]):
            case -1:?>Défaite
                <?php break;
            case 0:?>En cours
                <?php break;
            case 1:?>Victoire
                <?php break;
            case 2:?>Egalité
                <?php break;
         endswitch;?>
    </div>
    <div class="col-sm-2">
        <?php if(isset($_SESSION["idUtilisateur1"]) && $partie["idUtilisateur"] == $_SESSION["idUtilisateur1"] && $partie["gagnant"] == 0):?>
            <a href="<?= Helper::getUrl("Partie","reprendrePartie") ?>?partie=<?= $partie["idPartie"]?>">Reprendre la partie </a>
        <?php else:?>
            <a href="<?= Helper::getUrl("Partie","historiquePartie") ?>?partie=<?= $partie["idPartie"]?>">Consulter la partie </a>
        <?php endif;?>
    </div>
</div>
<?php $i ++;
endforeach;?>
