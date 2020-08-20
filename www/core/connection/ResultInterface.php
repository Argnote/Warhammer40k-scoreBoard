<?php 

namespace warhammerScoreBoard\core\connection;

interface ResultInterface 
{

    public function getArrayResult();
    public function getOneOrNullResult();
    public function getValueResult();
}