<?php


namespace warhammerScoreBoard\models\modelsFusion;

use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\Mission;
use warhammerScoreBoard\models\MissionJoueur;

class getMissionJoueur extends ModelFusion
{
    public function __construct()
    {
        $extendInstances = array();
        $extendInstances[] = new MissionJoueur();
        $extendInstances[] = new Mission();
        $extendInstances[] = new Joueur();
        parent::__construct($extendInstances);
    }
}