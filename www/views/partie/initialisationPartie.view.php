<?php
use warhammerScoreBoard\core\Helper;
?>
<main>
<!--    <pre>-->
<!--        --><?php //print_r($initPartie["fields"]);?>
<!--    </pre>-->
    <h1>initialisation de la partie</h1>
    <?php if(isset($errors)):
        $this->addModal("errors",$errors);
    endif;?>
    <form method=<?=$initPartie["config"]["method"]?> action="<?=$initPartie["config"]["action"]?>" id="<?=$initPartie["config"]["id"]?>">
        <div class="row">
            <div class="col-sm-6 col-inner">
                <?php
                $this->addModal("select",$initPartie["fields"]["missionPrincipale"], $missionPrincipale);?>
            </div>
            <div class="col-sm-6 col-inner">
                <input type="number" placeholder="Nombre de point de la partie" name="format">
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
        <input type="submit" value="Commencer la partie">
        <script>
            $(function()
            {
                $('#formInitPartie').submit(function()
                {
                    $('#button').attr("disabled", "disabled");
                });
            });
        </script>
    </form>
</main>
