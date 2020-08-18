<?php
use warhammerScoreBoard\core\Helper;
?>
<main>
    <h1>initialisation de la partie</h1>
    <form method=<?=$initPartie["config"]["method"]?> action="<?=$initPartie["config"]["action"]?>" id="<?=$initPartie["config"]["id"]?>">
        <div class="row">
            <div class="col-sm-6 col-inner">
                <?php $missionPrincipale += ["config"=>["name" => "MissionPrincipale"]];
                $missionPrincipale["config"]["defaultValue"] = "Objectif Pricipale";
                $missionPrincipale["config"]["form"] = $initPartie["config"]["id"];
                $this->addModal("select", $missionPrincipale);?>
            </div>
            <div class="col-sm-6 col-inner">
                <input type="number" placeholder="Nombre de point de la partie" name="nombrePoint">
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-inner">
                <p><?= $_SESSION['joueur1']??'joueur1' ?></p>
            </div>
            <div class="col-sm-6 col-inner">
                <p><?= $_SESSION['joueur2']??'joueur2' ?></p>
            </div>
        </div>
        <div class="row">
            <?php
            for($j = 1; $j <=2; $j++):?>
                <div class="col-sm-6 col-inner">
                <?php
                for($i = 1; $i<=3; $i++):
                    $missionSecondaire["config"]["name"] = "MissionSecondaire{$i}_Joueur{$j}";
                    $missionSecondaire["config"]["defaultValue"] = "Objectif secondaire $i";
                    $missionSecondaire["config"]["form"] = $initPartie["config"]["id"];?>
                    <div><?=$this->addModal("select", $missionSecondaire);?></div>
               <?php endfor; ?>
                </div>
            <?php endfor;?>
        </div>
        <input type="submit" value="Commencer la partie">
    </form>
</main>
