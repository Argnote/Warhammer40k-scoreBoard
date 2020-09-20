<?php $title = $title??"liste de données"  ?>
<h2><?= $title ?> </h2>

<?php if(isset($createLink)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-inner">
                <p><a href="<?= $createLink ?>">Ajouter une nouvelle entré</a></p>
            </div>
        </div>
    </div>
<?php endif;?>

<div class="col-sm-12">
    <?php $this->addModal("ListData", $listData);?>
</div>