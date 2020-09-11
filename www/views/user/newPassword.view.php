<?php if(isset($errors)):
    $this->addModal("errors",$errors);
endif;?>
    <h2>Nouveau mot de passe</h2>
    <?php $this->addModal("form", $configFormUser); ?>
