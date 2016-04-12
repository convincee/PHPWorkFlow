<?php
namespace PHPWorkFlow\Enum;

/**
 * Class TransitionTypeEnum
 * @package PHPWorkFlow\Enum
 */
class TransitionTypeEnum extends PHPWF_Enum
{
    const USER = 'user';
    const AUTO = 'auto';
    const GATE = 'gate';
    const NOTIFICATION = 'notification';
    const TIMED = 'timed';
    const EMITTER = 'emitter';
    const CONSUMER = 'consumer';
}
