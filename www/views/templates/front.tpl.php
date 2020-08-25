<?php
use warhammerScoreBoard\core\Helper;
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
    <link rel="stylesheet" href="../../public/css/grille.css">
	<title>Warhammer 40000 score-board</title>

</head>
<body>
  <div>
        <?php include "views/".$this->view.".view.php";?>
  </div>
  <script src="../../public/lib/jquery-3.5.1.min.js"></script>
  <script src="../../public/script/activeSelectedDisabled.js"></script>
  <script src="../../public/script/disableSubmit.js"></script>
</body>
</html>
