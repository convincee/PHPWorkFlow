<?php
namespace PHPWorkFlow\Enum;

/**
 * Class UseCaseStatusEnum
 * @package PHPWorkFlow\Enum
 */
class TriggerFulfillmentStatusEnum extends PHPWF_Enum
{
    const FREE = 'free';
    const CONSUMED = 'closed';
    const CANCELLED = 'cancelled';
}
