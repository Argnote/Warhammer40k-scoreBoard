<?php $title = $title??"liste de données"  ?>
<h2><?= $title ?> </h2>

<?php $this->addModal("getData", $data);

if(isset($updateLink) && isset($updateLinkLabel)):?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <p><a href="<?= $updateLink ?>"><?= $updateLinkLabel?></a></p>
        </div>
    </div>
</div>
<br/>
<?php endif;?>

<?php if(isset($deleteLink)&& isset($deleteLinkLabel)):?>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner">
            <p>Attention la suppresion du compte est immédiate et irréversible !!!</p>
            <p><a href="<?= $deleteLink ?>"><?= $deleteLinkLabel?></a></p>
        </div>
    </div>
</div>
<?php endif;?>

<?php if(isset($archivedLink)&& isset($archivedLinkLabel)):?>
    <div class="row">
        <div class="col-sm-12">
            <div class="col-inner">
                <p>Attention la suppresion du compte est immédiate et irréversible !!!</p>
                <p><a href="<?= $archivedLink ?>"><?= $archivedLinkLabel?></a></p>
            </div>
        </div>
    </div>
<?php endif;?>




