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
        if(isset($name["category"]) && $name["category"] != $categorie):
            $categorie = $name["category"]?>
            <option disabled="disabled" value="">-- <?php echo $name["category"] ?> --</option>
        <?php endif;?>
        <option value="<?=$name["value"] ?>"><?=$name["label"] ?></option>
    <?php
    endforeach;
endif;
?>

</select>
<?php if (isset($data["required"]) && $data["required"] == true)
    {
        echo "*";
    }
    ?>
