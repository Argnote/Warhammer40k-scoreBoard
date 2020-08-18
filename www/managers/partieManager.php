<?php


namespace warhammerScoreBoard\managers;


use warhammerScoreBoard\core\Manager;
use warhammerScoreBoard\models\mission;

class partieManager extends Manager
{
    public function __construct()
    {
        parent::__construct(Mission::class, 'mission');
    }
}