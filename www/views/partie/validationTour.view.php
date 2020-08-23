<?php
?>
<main>
    <h1>Round <?=$tourInfo?></h1>
    <?php if(!empty($score))
    {
    $this->addModal("tableauScore",$score);
    }?>
        <div class="row">
            <?php foreach ($joueurs as $joueur):?>
            <div class="col-sm-6">
                <div class="col-inner">
                    <p><?=$joueur;?></p>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    <form method="<?= $missionsJoueur1["config"]["method"]?>"
          action="<?= $missionsJoueur1["config"]["action"]?>"
          id="<?= $missionsJoueur1["config"]["id"]?>"
          class="<?= $missionsJoueur1["config"]["class"]?>">
        <div class="row">
            <div class="col-sm-6">
            <?php $this->addModal("formScore",$missionsJoueur1);?>
            </div>
            <div class="col-sm-6">
            <?php $this->addModal("formScore",$missionsJoueur2);?>
            </div>
        <button class="btn btn-primary"><?= $missionsJoueur1["config"]["submit"];?></button>
    </form>
</main>
