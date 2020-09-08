<?php
?>
    <h2><?=$tourInfo?></h2>
    <?php if(isset($errors)):
        $this->addModal("errors",$errors);
    endif;?>
        <div class="row">
            <?php foreach ($joueurs as $joueur):?>
            <div class="col-sm-6">
                <div class="col-inner joueur">
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
            <div class="col-sm-12">
                <div class="col-inner">
                    <button class="btn btn-primary buttonDisabled"><?= $missionsJoueur1["config"]["submit"];?></button>
                </div>
            </div>
        </div>

    </form>

<?php if(!empty($scoreJoueur1) && !empty($scoreJoueur2)):?>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->addModal("tableauScore",$scoreJoueur1);?>
        </div>
        <div class="col-sm-6">
            <?php $this->addModal("tableauScore",$scoreJoueur2);?>
        </div>
    </div>
<?php endif;?>