<?php
namespace PHPWorkFlow\Enum;

/**
 * Class TokenStatusEnum
 * @package PHPWorkFlow\Enum
 */
class TokenStatusEnum extends PHPWF_Enum
{
    const FREE = 'free';
    const CONSUMED = 'consumed';
    const CANCELLED = 'cancelled';
}
