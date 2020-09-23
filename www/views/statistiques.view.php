<?php $title = $title??"Statistique"  ?>
<h2><?= $title ?> </h2>
<div class="row">
    <div class="col-sm-12">
        <?php if(isset($avertissement)): ?>
            <div class="col-sm-inner graph">
                <p><?=$avertissement?></p>
            </div>
            <br/>
        <?php endif;?>
        <?php if(isset($statVictoireData)): ?>
            <div class="col-sm-inner graph">
                <input type="hidden" value="<?= $statVictoireData ?>" id="statVictoireData">
                <div>
                    <canvas id="statVictoire" height="100"></canvas>
                </div>
            </div>
            <br/>
            <?php endif;?>

            <?php if(isset($statMissionClassementLabel) && isset($statMissionClassementData)): ?>
            <div class="col-inner graph">
                <input type="hidden" value="<?= $statMissionClassementLabel ?>" id="statMissionClassementLabel">
                <input type="hidden" value="<?= $statMissionClassementData ?>" id="statMissionClassementData">
                <div>
                    <canvas id="statClassementMission" height="300"></canvas>
                </div>
            </div>
            <?php endif;?>
    </div>
</div>
<script src="../public/lib/Chart.bundle.js"></script>
<script src="../public/script/configGraph.js"></script>
<script src="../public/script/statVictoire.js"></script>
<script src="../public/script/statClassementMission.js"></script>
