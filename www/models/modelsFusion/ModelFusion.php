<?php


namespace warhammerScoreBoard\models\modelsFusion;
use Exception;
use warhammerScoreBoard\models\Model;

class modelFusion extends Model
{
    protected $extendInstances = array();

    public function __construct(array $extends)
    {
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
        foreach($this->extendInstances as $object)
        {
            if(method_exists($object, $funcName))
                return call_user_func_array(array($object, $funcName), $tArgs);
        }
        throw new Exception("The $funcName method doesn't exist");
    }

    protected function getExtendInstance()
    {
        return $this->extendInstances;
    }

    protected function setAllInstance()
    {
        foreach ($this->extendInstances as $instance)
        {
            $properties = $instance->getAll();
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