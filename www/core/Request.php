<?php

namespace warhammerScoreBoard\core;

class Request
{

    /**
     * Ici c'est un objet Mais mieux vaut utiliser un objet
     * Par exemple pour symfony c'est un ParameterBag
     */
    protected static $pathParams;

    protected static $queryParams;

    public function __construct()
    {

    }

    public static function processPathParams(array $params): void
    {
        self::$pathParams = [];

        foreach($params as $key => $value)
        {
            if(is_string($key))
            {
                self::$pathParams[$key] = $value;
            }
        }
    }

    public static function processQueryParams(array $params): void
    {
        self::$queryParams = [];

        foreach($params as $key => $value)
        {
            if(is_string($key))
            {
                self::$queryParams[$key] = $value;
            }
        }
    }


    public function getPathParams(): ?array
    {
        return self::$pathParams;
    }

    public function getQueryParams(): ?array
    {
        return self::$queryParams;
    }
}