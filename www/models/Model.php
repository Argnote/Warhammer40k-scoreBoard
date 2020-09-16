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
//        echo "<pre>";
//        print_r($donnees);
//        echo "</pre>";
        $className = get_class($this);
        $articleObj = new $className;
        foreach ( $donnees as $key => $value) {
            $method = 'set'.ucfirst($key);
            if (method_exists($articleObj, $method) && !empty($value)) {
                $articleObj->$method(htmlspecialchars($value));
            }
            elseif (method_exists($articleObj, "getExtendInstance"))
            {
                foreach ($articleObj->getExtendInstance() as $instance)
                {
                    $classNameInstance = get_class($instance);
                    $articleObjInstance = new $classNameInstance;
                    if (method_exists($articleObjInstance, $method) && !empty($value)) {
                        $articleObj->$method(htmlspecialchars($value));
                        $articleObj->setAllInstance();
                    }
                }
            }
        }
        if(method_exists($articleObj, "downInstance"))
            $articleObj->downInstance();
        return $articleObj;
    }
}
