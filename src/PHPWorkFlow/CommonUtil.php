<?php

namespace PHPWorkFlow;

use PHPWorkFlow\DB\Arc;
use PHPWorkFlow\DB\WorkFlow;
use PHPWorkFlow\DB\Place;
use PHPWorkFlow\DB\Transition;
use PHPWorkFlow\DB\WorkItem;
use PHPWorkFlow\DB\UseCase;
use PHPWorkFlow\DB\Token;
use PHPWorkFlow\DB\Route;
use PHPWorkFlow\DB\TriggerFulfillment;
use PHPWorkFlow\DB\Notification;
use PHPWorkFlow\DB\Gate;
use PHPWorkFlow\DB\UseCaseContext;
use PHPWorkFlow\DB\Command;
/**
 * Class CommonUtil
 * @package PHPWorkFlow
 */
class CommonUtil
{
    use WorkFlowDAOTrait;
    /**
     * @param $object WorkFlow|Arc|Place|WorkItem|Transition|UseCase|Token|TriggerFulfillment|Notification|Route|Gate|UseCaseContext|Command
     */
    public function CommonObjectProperties($object)
    {
        if (!$object->getCreatedAt()) {
            $object->setCreatedAt(time());
        }
        if (!$object->getCreatedBy()) {
            $object->setCreatedBy(99999999);
        }
        $object->setModifiedAt(time());
        $object->setModifiedBy(99999999);
    }

    /**
     * @static
     * @param      $inString
     * @param bool $upperCaseFirstChar
     * @return string
     */
    public function CamelCapitalizeFieldName($inString, $upperCaseFirstChar = false)
    {
        $listOfParts = preg_split("/_| /", $inString, -1);
        $outString = $listOfParts[0];
        if ($upperCaseFirstChar) {
            $outString = ucfirst($listOfParts[0]);
        }

        foreach (array_slice($listOfParts, 1) as $part) {
            $outString .= ucfirst($part);
        }
        return $outString;
    }

    /**
     * @param $object
     * @param $properties
     */
    public function PopulateObjectWithProperties($object, $properties)
    {
        foreach ($properties as $property_name => $property_value) {
            $update_method = 'set' . $property_name;
            $object->$update_method($property_value);
        }
    }

    /**
     * @param $valueIWantToRoundTo
     * @param $thingToRound
     * @return float
     */
    public function roundToNearest($valueIWantToRoundTo, $thingToRound)
    {
        return round($thingToRound/$valueIWantToRoundTo)*$valueIWantToRoundTo;
    }
}
