<?php

use warhammerScoreBoard\core\Helper;

?>

<h2>Score de la partie</h2>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner joueur">
            <p><?=$_SESSION['pseudoJoueur1']??'Joueur1'?></p>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="col-inner">
            <?php $this->addModal("tableauScore",$scoreJoueur1);?>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="col-inner joueur">
            <p><?=$_SESSION['pseudoJoueur2']??'Joueur2'?></p>
        </div>
    </div>
    <div class="col-sm-12">
        <div class="col-inner">
            <?php $this->addModal("tableauScore",$scoreJoueur2);?>
        </div>
    </div>
</div>
<?php if(isset($reprisePartie)):?>
    <a href="<?= $reprisePartie ?>">Reprendre la partie </a>
<?php endif; ?>

<?php if(isset($archivedLink)&& isset($archivedLinkLabel)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-inner">
                <p><a href="<?= $archivedLink ?>"><?= $archivedLinkLabel?></a></p>
            </div>
        </div>
    </div>
<?php endif;?>
