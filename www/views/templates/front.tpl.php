<?php

use warhammerScoreBoard\core\Helper;
use warhammerScoreBoard\getData\GetDataNav;

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/htlm; utf-8"/>
    <link rel="stylesheet" href="../../public/css/grille.css">
    <link rel="stylesheet" href="../../public/css/style.css">
	<title>Warhammer 40000 score-board</title>
    <script src="../../public/lib/jquery-3.5.1.min.js"></script>
</head>
<body>
    <header>
          <div class="row container header" >
                  <div class="col-sm-3">
<!--                      <div class="col-inner header">-->
                          <img src="../../public/img/logoOrchido.png" class="logo">
<!--                      </div>-->
                  </div>
                  <div class="col-sm-6">
                      <div class="col-inner header">
                          <h1>Warhammer40K scoreboard</h1>
                      </div>
                  </div>
              </div>
    </header>
        <div class="row container core">
          <div class="col-sm-3">
              <div class="col-inner nav">
                  <nav>
                      <?php $this->setNav(GetDataNav::getForm());
                      include "views/modals/nav.mod.php";?>
                  </nav>
              </div>
            </div>
            <div class="col-sm-9">
                <div class="col-inner main">
                    <main>
                        <?php include "views/".$this->view.".view.php";?>
                    </main>
                </div>
            </div>
      </div>

    <footer>
          <nav class="footer" >
              <a href="<?= Helper::getUrl("Home","getMentionLegal")?>">Mentions légales</a>
                 |
              <a href="<?= Helper::getUrl("Home","getCharte")?>">Charte</a>

        </nav>
    </footer>
    <script src="../../public/script/activeSelectedDisabled.js"></script>
    <script src="../../public/script/disableSubmit.js"></script>
    <script src="../../public/script/hiddenMissionByLivre.js"></script>
</body>
</html>
