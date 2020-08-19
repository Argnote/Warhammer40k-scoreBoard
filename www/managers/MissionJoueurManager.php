<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\models\MissionJoueur;

class MissionJoueurManager extends Manager
{
    public function __construct()
    {
        parent::__construct(MissionJoueur::class, 'joueur_has_mission');
    }
}