<?php use warhammerScoreBoard\core\Helper;?>
  <h2>Inscription</h2>
    <?php
    if(isset($errors)):
        $this->addModal("errors",$errors);
    endif;?>
    <?php $this->addModal("form", $configFormUser); ?>

