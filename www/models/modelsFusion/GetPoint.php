<?php

namespace warhammerScoreBoard\models\modelsFusion;

use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\Mission;
use warhammerScoreBoard\models\Point;
use warhammerScoreBoard\models\Tour;


class GetPoint extends ModelFusion
{
    public function __construct()
    {
        $extendInstances = array();
        $extendInstances[] = new Mission();
        $extendInstances[] = new Tour();
        $extendInstances[] = new Joueur();
        $extendInstances[] = new Point();
        parent::__construct($extendInstances);
    }
}