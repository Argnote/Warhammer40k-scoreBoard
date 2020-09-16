<?php

use warhammerScoreBoard\core\tools\EnumStatuNav;

$nav = $this->getNav();?>
<h2>Menu</h2>
<ul>
<?php foreach ($nav as $link):
        switch ($link["statu"]):
            case EnumStatuNav::default:?>

            <li><a href="<?= $link["url"]?>"><?= $link["text"]?></a> </li>

            <?php break;
            case EnumStatuNav::offline:
                if(empty($_SESSION["idUtilisateur1"])):?>

                    <li><a href="<?= $link["url"]?>"><?= $link["text"]?></a> </li>

                <?php endif;
                break;
            case EnumStatuNav::online:
                if(!empty($_SESSION["idUtilisateur1"])):?>

                    <li><a href="<?= $link["url"]?>"><?= $link["text"]?></a> </li>

                <?php endif;
                break;
            case EnumStatuNav::admin:
                if(!empty($_SESSION["idUtilisateur1"]) && $_SESSION["idRole"] == 2):?>

                    <li><a href="<?= $link["url"]?>"><?= $link["text"]?></a> </li>

                <?php endif;
                break;
                endswitch;
    endforeach;?>
    </ul>