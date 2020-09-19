<?php use warhammerScoreBoard\core\Helper;?>
<div class="row rowOdd">
    <div class="col-sm-2">
        ID l'utilisateur
    </div>
    <div class="col-sm-3">
        Pseudo de l'utilisateur
    </div>
    <div class="col-sm-3">
        Email de l'utilisateur
    </div>
    <div class="col-sm-2">
        Role de l'utilisateur
    </div>
    <div class="col-sm-2">
        Consulter l'utilisateur
    </div>
</div>
<?php

$i = 0;
foreach ($data as $utilisateur):?>
<div class="row <?php if($i % 2 != 0){echo "rowOdd";} ?>">
    <div class="col-sm-2">
        <?= $utilisateur->getIdUtilisateur()??"Non renseigné"?>
    </div>
    <div class="col-sm-3">
        <?= $utilisateur->getPseudo()??"Non renseigné"?>
    </div>
    <div class="col-sm-3">
        <?= $utilisateur->getEmail()??"Non renseigné"?>
    </div>
    <div class="col-sm-2">
        <?= $utilisateur->getNomRole()??"Non renseigné"?>
    </div>
    <div class="col-sm-2">
        <a href="<?= Helper::getUrl("Utilisateur","getUtilisateur")."?idUtilisateur=".$utilisateur->getIdUtilisateur()??""?>">Consulter le profil</a>
    </div>
</div>
    <?php $i ++;
endforeach;?>