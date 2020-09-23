<?php


namespace warhammerScoreBoard\models\modelsFusion;
use Exception;
use warhammerScoreBoard\models\Model;

class modelFusion extends Model
{
    protected $extendInstances = array();

    public function __construct(array $extends)
    {
        //Ajoute les instances de la classe enfant dans un tableau
        $this->extendInstances = $extends;
        foreach ($this->extendInstances as $instance)
        {
            foreach ($instance->__toArray() as $property => $value)
            {
                $this->$property = null;
            }
        }
    }

    public function __call($funcName, $tArgs)
    {
        //Cherhce dans l'une des class instancier la méthode demandé 
        foreach($this->extendInstances as $object)
        {
            if(method_exists($object, $funcName))
                return call_user_func_array(array($object, $funcName), $tArgs);
        }
        throw new Exception("la méthode $funcName n'existe pas");
    }

    protected function getExtendInstance()
    {
        //retourne les instances
        return $this->extendInstances;
    }

    protected function setAllInstance()
    {
        //créer un propriété dans la class pour chaques propriétés des classes instanciées
        foreach ($this->extendInstances as $instance)
        {
            $properties = $instance->__toArray();
            foreach ($properties as $property => $value)
            {
                if($value != null)
                    $this->$property = $value;
            }
        }
    }

    protected function downInstance()
    {
        unset($this->extendInstances);
    }
}