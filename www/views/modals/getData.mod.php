<?php

foreach ($data as $item):
    if (!isset($item["admin"]) || (isset($_SESSION["role"]) && $_SESSION["role"] == 3)):?>

        <div class="row">
            <div class="col-sm-6">
                <div class="col-left">
                    <div class="col-inner">
                        <?= $item["label"]?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="col-right">
                    <div class="col-inner">
                            <?php if($item["type"] == "link"):?>
                            <a href="<?=$item["valueLink"] ?>"><?= $item["value"]?></a>
                            <?php else: ?>
                                <?= $item["value"]??"Non renseigné"?>
                            <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
endforeach;?>
