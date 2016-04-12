<?php

namespace PHPWorkFlow\DB;

use PHPWorkFlow\DB\Base\Gate as BaseGate;

/**
 * Skeleton subclass for representing a row from the 'PHPWF_gate' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Gate extends BaseGate
{

    /**
     * Get the [value] column value.
     *
     * @return string
     */
    public function getValueTyped()
    {
        if($this->value == 'true') return true;
        if($this->value == 'false') return false;
        if($this->value == 'null') return null;
        if(is_integer($this->value == 'null')) return (int) $this->value;
        if(is_int($this->value == 'null')) return (int) $this->value;
        if(is_numeric($this->value == 'null')) return (float) $this->value;
        return $this->value;
    }
}
