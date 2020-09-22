<script src="../public/lib/Chart.bundle.js"></script>
<h2>Statistiques</h2>
<div class="row">
    <div class="col-sm-6">
        <h3>Statistiques générales</h3>
        <div class="col-sm-12 graph">
            <?php if(isset($statVictoireData)): ?>
                <input type="hidden" value="<?= $statVictoireData ?>" id="statVictoireData">
                <canvas id="statVictoire"></canvas>
            <?php endif;?>
        </div>
    </div>
    <div class="col-sm-6">
        <h3>Statistiques particuliers</h3>
    </div>
</div>
<script src="../public/script/configGraph.js"></script>
<script src="../public/script/statVictoire.js"></script>
