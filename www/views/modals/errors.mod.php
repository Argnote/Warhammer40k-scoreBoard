    <div class="row">
        <div class="col-sm-12 col-inner">
            <div class="col-inner">
                <p>les érreurs suivantes sont survenues : </p>
            </div>
            <?php foreach ($data as $erreur):?>
                <div class="col-inner">
                    <p> - <?=$erreur?></p>
                </div>
            <?php endforeach;?>
        </div>
    </div>
