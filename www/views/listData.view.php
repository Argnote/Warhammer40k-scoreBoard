<?php $title = $title??"liste de données"  ?>
<h2><?= $title ?> </h2>

<?php if(isset($createLink)&& isset($createLinkLabel)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-inner">
                <p><a href="<?= $createLink ?>"><?= $createLinkLabel?></a></p>
            </div>
        </div>
    </div>
<?php endif;?>

<div class="col-sm-12">
    <?php $this->addModal("listData", $listData);?>
</div>