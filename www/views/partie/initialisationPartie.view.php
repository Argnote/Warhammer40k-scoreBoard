<?php
use warhammerScoreBoard\core\Helper;
?>
<!--    <pre>-->
<!--        --><?php //print_r($initPartie["fields"]);?>
<!--    </pre>-->
    <h2>initialisation de la partie</h2>
    <?php if(isset($errors)):
        $this->addModal("errors",$errors);
    endif;?>
    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($livres as $livre): ?>
                <input type="checkbox" id="<?= $livre->getCodeLivre()?>" name="<?= $livre->getCodeLivre()?>" class="checkBoxLivre" checked="true">
                <label for="<?= $livre->getCodeLivre()?>"><?= $livre->getNomLivre()." ". $livre->getCodeLivre()?></label>
            <?php endforeach;?>
        </div>
    </div>
    <form method=<?=$initPartie["config"]["method"]?> action="<?=$initPartie["config"]["action"]?>" id="<?=$initPartie["config"]["id"]?>" class="<?=$initPartie["config"]["class"]?>">
        <div class="row">
            <div class="col-sm-6">
                <div class="col-inner">
                <?php
                $this->addModal("select",$initPartie["fields"]["missionPrincipal"], $missionPrincipal);?>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-inner">
                <input type="number" placeholder="Nombre de points" name="format">
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            for($j = 1; $j <=2; $j++):?>
                <div class="col-sm-6">
                    <div class="col-inner"><p><?=$_SESSION['pseudoJoueur'.$j]??'Joueur '.$j ?></p></div>
                    <div class="col-inner">
                        <?php
                        $this->addModal("select",$initPartie["fields"]["armee".$j], $armee);?>
                    </div>
                <?php
                for($i = 1; $i<=3; $i++):?>
                    <div class="col-inner"><?=$this->addModal("select",$initPartie["fields"]["missionSecondaire{$i}_Joueur{$j}"] ,$missionSecondaire);?></div>
               <?php endfor; ?>
                </div>
            <?php endfor;?>
        </div>
        <button class="btn btn-primary buttonDisabled">Commencer la partie</button>

    </form>
