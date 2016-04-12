<?php
namespace PHPWorkFlow\Enum;

/**
 * Class WorkItemStatusEnum
 * @package PHPWorkFlow\Enum
 */
class WorkItemStatusEnum extends PHPWF_Enum
{
    const ENABLED = 'enabled';
    const IN_PROGRESS = 'in_progress';
    const CANCELLED = 'cancelled';
    const FINISHED = 'finished';
}
