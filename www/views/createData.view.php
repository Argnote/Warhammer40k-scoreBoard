<?php use warhammerScoreBoard\core\Helper;?>
<?php $title = $title??"Modification liste de données"  ?>
<h2><?= $title ?> </h2>
<?php
if(isset($errors)):
    $this->addModal("errors",$errors);
endif;?>
<?php $this->addModal("form", $createData); ?>
