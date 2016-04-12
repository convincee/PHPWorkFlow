<?php
namespace PHPWorkFlow\Enum;

/**
 * Class PHPWF_Enum
 * @package PHPWorkFlow\Enum
 */
class PHPWF_Enum
{
    /**
     * Get an array of enum constants
     * @param $with_keys
     * @return array
     */
    public static function GetValues($with_keys = true)
    {
        $values = [];
        $reflectionObj = new \ReflectionClass(get_called_class());
        foreach($reflectionObj->getConstants() as $constant => $value)
        {
            if ($with_keys)
            {
                $values[$constant] = $value;
            }
            else
            {
                $values[] = $value;
            }
        }
        return $values;
    }
}
