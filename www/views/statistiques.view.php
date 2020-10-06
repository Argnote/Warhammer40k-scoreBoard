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

        <?php if(isset($statMissionClassement)): ?>
            <div class="col-inner graph">
                <input type="hidden" value="<?= $statMissionClassement ?>" id="statMissionClassement">
                <div>
                    <canvas id="statMissionClassementCanvas" height="300"></canvas>
                </div>
            </div>
            <br/>
        <?php endif;?>
        <?php if(isset($statMissionClassementParPoint)): ?>
            <div class="col-inner graph">
                <input type="hidden" value="<?= $statMissionClassementParPoint ?>" id="statMissionClassementParPoint">
                <div>
                    <canvas id="statClassementMissionParPointCanvas" height="300"></canvas>
                </div>
            </div>
            <br/>
        <?php endif;?>
    </div>
</div>
<script src="../public/lib/Chart.bundle.js"></script>
<script src="../public/script/configGraph.js"></script>
<script src="../public/script/statVictoire.js"></script>
<script src="../public/script/statClassementMission.js"></script>
<script src="../public/script/statClassementMissionParPoint.js"></script>
