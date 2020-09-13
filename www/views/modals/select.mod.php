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
    if(isset($data["defaultValue"])):?>
        <option disabled="disabled" selected="selected" value=""><?=$data["defaultValue"] ?></option>
    <?php endif;
    $categorie = "";
    foreach ($value as $name):
        if(isset($name[2]) && $name[2] != $categorie):
            $categorie = $name[2]?>
            <option disabled="disabled" value="">-- <?php echo $name[2] ?> --</option>
        <?php endif;?>
        <option value="<?=$name[0] ?>"><?=$name[1] ?></option>
    <?php
    endforeach;
endif;
?>

</select>
