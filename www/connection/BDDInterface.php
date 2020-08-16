<?php

namespace HotelFactory\connection;

interface BDDInterface
{
    public function connect();

    public function query(string $query, array $parameters = null);

}