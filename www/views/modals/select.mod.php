<select
        <?php
        $required ="";
        if (isset($data["required"]) && $data["required"] == true):
            $required = "*"?>
        required="required"
        <?php endif;?>
        name="<?= $data["name"]??'' ?>"
        form="<?= $data["form"]??'' ?>"
        class="<?= $data["class"]??'' ?>"

        <?php if(!empty($data["id"])):?>
            id="<?= $data["id"]??'' ?>"
        <?php endif;?>>
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
<?= $required ?>
