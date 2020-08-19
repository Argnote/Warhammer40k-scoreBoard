<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\models\Partie;

class PartieManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Partie::class, 'partie');
    }
}