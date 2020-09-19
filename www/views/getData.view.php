<?php $title = $title??"liste de données"  ?>
<h2><?= $title ?> </h2>

<?php $this->addModal("getData", $data);

if(isset($updateLink)):?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <p><a href="<?= $updateLink ?>">Modifier <?= $title?></a></p>
        </div>
    </div>
</div>
<br/>
<?php endif;

if(isset($deleteLink)):?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <p>Attention la suppresion du compte est immédiate et irréversible !!!</p>
            <p><a href="<?= $deleteLink ?>">Supprimer <?= $title?></a></p>
        </div>
    </div>
</div>

<?php endif;?>


