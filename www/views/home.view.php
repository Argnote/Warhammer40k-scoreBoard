<?php use warhammerScoreBoard\core\Helper;?>
  <h2>Bienvenue <?=$_SESSION['pseudoJoueur1']??'' ?> </h2>
<div class="row">
    <div class="col-sm-12">
        <div class="col-inner homeCard">
            <p>
                Warhammer40k scoreboard est un outil permettant d'enregistrer facilement ses parties de warhammer 40k V9.<br/>
                Il est possible de jouer de facon anonyme ou alors de se connecter afin de consulter ses parties jouées.<br/>
                Jouer en mode connecté permet également de connaitre ses statistiques personnel au fur et à mesure des parties.
            </p>
        </div>
    </div>
</div>
<div class="row">
    <?php if(!empty($_SESSION["idUtilisateur1"]) && !empty($configFormUser) && empty($_SESSION["idUtilisateur2"])): ?>
    <div class="col-sm-6">
        <div class="col-inner homeCard">
            <h4>Connecter un ami</h4>
            <?php $this->addModal("form", $configFormUser); ?>
        </div>
    </div>
    <?php endif;?>
    <?php if(!empty($_SESSION["idUtilisateur1"]) && !empty($_SESSION["idUtilisateur2"])): ?>
        <div class="col-sm-6">
            <div class="col-inner homeCard">
                <h4>Déconnecter un ami</h4>
                <a href="<?= Helper::getUrl("Utilisateur","logoutGuest")?>">Déconnecter <?= $_SESSION["pseudoJoueur2"]?></a>
            </div>
        </div>
    <?php endif;?>
    <div class="col-sm-6">
        <div class="col-inner homeCard">
            <h4>Débuter une partie</h4>
            <a href="<?= Helper::getUrl("Partie","initialisationPartie")?>">nouvelle partie</a>
        </div>
    </div>
</div>