<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\models\Joueur;
use warhammerScoreBoard\models\mission;

class JoueurManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Joueur::class, 'joueur');
    }
}