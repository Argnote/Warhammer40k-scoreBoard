<?php

namespace warhammerScoreBoard\models;

class Model
{

    public function __toArray():array
    {
        $property = get_object_vars($this);
        return $property;
    }

    public function hydrate(array $donnees)
    {
        $className = get_class($this);
        $articleObj = new $className;

        foreach ( $donnees as $key => $value) {

            $method = 'set'.ucfirst($key);
            if (method_exists($articleObj, $method)) {
                $articleObj->$method($value);
            }
        }
        return $articleObj;
    }
}
