 <h2>Mot de passe oublié</h2>
    <?php if(isset($errors)):
        $this->addModal("errors",$errors);
    endif;?>
    <?php $this->addModal("form", $configFormUser); ?>