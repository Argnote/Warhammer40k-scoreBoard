<?php $i = 1;
foreach($data as $item):?>
    <div class="row <?php if($i % 2 != 0){echo "rowOdd";} ?>">
        <?php foreach($item as $value):?>
            <div class="<?= $value["class"]??"" ?>">
                <?php if($value["type"] == "link"):?>
                    <a href="<?= $value["link"]??"Home" ?>"><?= $value["label"]??"Non renseigné" ?></a>
                <?php else:?>
                    <?= $value["label"]??"Non renseigné" ?>
                <?php endif;?>
            </div>
        <?php endforeach;?>
    </div>
<?php $i ++;
endforeach; ?>