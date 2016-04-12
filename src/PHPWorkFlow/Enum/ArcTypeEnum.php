<?php
namespace PHPWorkFlow\Enum;

/**
 * Class ArcTypeEnum
 * @package PHPWorkFlow\Enum
 */
class ArcTypeEnum extends PHPWF_Enum
{
    const SEQ = 'seq';
    const OR_SPLIT = 'or_split';
    const OR_JOIN = 'or_join';
    const AND_SPLIT = 'and_split';
    const AND_JOIN = 'and_join';
}
