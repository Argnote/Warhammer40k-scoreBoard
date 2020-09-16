<?php


namespace warhammerScoreBoard\core\tools;


class TransformArrayToSelected
{
    public static function transformArrayToSelected(array $selected , string $value, string $label , string $category = null)
    {
        for($i = 0; $i < count($selected); $i++)
        {
            $selected[$i]["value"] = $selected[$i][$value] ;
            unset($selected[$i][$value]);
            $selected[$i]["label"] = $selected[$i][$label] ;
            unset($selected[$i][$label]);
            if(!empty($category))
                $selected[$i]["category"] = $selected[$i][$category] ;
            unset($selected[$i][$category]);
        }
        return $selected;
    }
}