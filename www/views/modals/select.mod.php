<select
        <?php
        if (isset($data["required"]) && $data["required"] == true):?>
        required="required"
        <?php endif;?>
        name="<?= $data["name"]??'' ?>"
        form="<?= $data["form"]??'' ?>"
        class="<?= $data["class"]??'' ?>"
        id="<?= $data["id"]??'' ?>">
<?php
if(!empty($value)):
    if(!empty($data["defaultValue"])):?>
        <option disabled="disabled" selected="selected" value=""><?=$data["defaultValue"] ?></option>
    <?php endif;
    foreach ($value as $name):?>
        <option value="<?=$name["0"] ?>"><?=$name["1"] ?></option>
    <?php endforeach;
endif;?>
</select>
