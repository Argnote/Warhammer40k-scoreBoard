<select
        name="<?= $data["config"]["name"]??'' ?>"
        form="<?= $data["config"]["form"]??'' ?>"
        class="<?= $data["config"]["class"]??'' ?>"
        id="<?= $data["config"]["id"]??'' ?>">
<?php
if(!empty($data["option"])):
    if(!empty($data["config"]["defaultValue"])):?>
        <option selected="selected" value=""><?=$data["config"]["defaultValue"] ?></option>
    <?php endif;
    foreach ($data["option"] as $name):?>
        <option value="<?=$name["0"] ?>"><?=$name["1"] ?></option>
    <?php endforeach;
endif;?>
</select>
