<?php

foreach ($data as $item):
    if (!isset($item["admin"]) || (isset($_SESSION["role"]) && $_SESSION["role"] == 3)):?>

        <div class="row">
            <div class="col-sm-6">
                <div class="col-inner col-left">
                    <label><?= $item["label"]?></label>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-inner col-right">
                    <?php if($item["type"] == "link"):?>
                    <label><a href="<?=$item["valueLink"] ?>"><?= $item["value"]?></a></label>
                    <?php else: ?>
                    <label> <?= $item["value"]??"Non renseigné"?></label>
                    <?php endif;?>
                </div>
            </div>
        </div>
    <?php endif;
endforeach;?>
