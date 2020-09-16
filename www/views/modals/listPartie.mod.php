<?php use warhammerScoreBoard\core\Helper;?>
<div class="row">
    <div class="col-sm-3">
        <p>Votre armee</p>
    </div>
    <div class="col-sm-3">
        <p>Votre adversaire</p>
    </div>
    <div class="col-sm-2">
        <p>Date de la partie</p>
    </div>
    <div class="col-sm-2">
        <p>Résultat</p>
    </div>
    <div class="col-sm-2">
        <p>Détails</p>
    </div>
</div>
<?php
$i = 1;
foreach ($data as $partie):
?>
<div class="row <?php if($i % 2 != 0){echo "rowOdd";} ?>">
    <div class="col-sm-3">
        <p><?= $partie["nomArmee"]??'Non sélectionné'?></p>
    </div>
    <div class="col-sm-3">
        <p><?= $partie["nomJoueur2"]?> (<?= $partie["ArmeeJoueur2"]??'Non sélectionné'?>)</p>
    </div>
    <div class="col-sm-2">
        <p><?= $partie["dateDebut"]?></p>
    </div>
    <div class="col-sm-2">
        <?php switch ($partie["gagnant"]):
            case -1:?><p>Défaite</p>
                <?php break;
            case 0:?><p>En cours</p>
                <?php break;
            case 1:?><p>Victoire</p>
                <?php break;
            case 2:?><p>Egalité</p>
                <?php break;
         endswitch;?>
    </div>
    <div class="col-sm-2">
        <?php if(isset($_SESSION["idUtilisateur1"]) && $partie["idUtilisateur"] == $_SESSION["idUtilisateur1"] && $partie["gagnant"] == 0):?>
            <p><a href="<?= Helper::getUrl("Partie","reprendrePartie") ?>?partie=<?= $partie["idPartie"]?>">Reprendre la partie </a></p>
        <?php else:?>
            <p><a href="<?= Helper::getUrl("Partie","historiquePartie") ?>?partie=<?= $partie["idPartie"]?>">Consulter la partie </a></p>
        <?php endif;?>
    </div>
</div>
<?php $i ++;
endforeach;?>
