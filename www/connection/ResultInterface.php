<?php 

namespace warhammerScoreBoard\connection;

interface ResultInterface 
{

    public function getArrayResult();
    public function getOneOrNullResult();
    public function getValueResult();
}