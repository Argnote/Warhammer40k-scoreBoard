<?php


namespace warhammerScoreBoard\models\modelsFusion;

use warhammerScoreBoard\models\Armee;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\Partie;

class GetPartiePlayed extends ModelFusion
{
    public function __construct()
    {
        $extendInstances = array();
        $extendInstances[] = new Armee();
        $extendInstances[] = new Partie();
        $extendInstances[] = new Joueur();
        parent::__construct($extendInstances);
    }
}