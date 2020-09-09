    <div class="row">
        <div class="col-sm-12">
            <div class="col-inner">
                <p>les erreurs suivantes sont survenues : </p>
            </div>
            <?php foreach ($data as $erreur):?>
                <div class="col-inner">
                    <p> - <?=$erreur?></p>
                </div>
            <?php endforeach;?>
        </div>
    </div>
