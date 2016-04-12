<?php

namespace PHPWorkFlow\DB\Base;

use \DateTime;
use \Exception;
use \PDO;
use PHPWorkFlow\DB\Place as ChildPlace;
use PHPWorkFlow\DB\PlaceQuery as ChildPlaceQuery;
use PHPWorkFlow\DB\TokenQuery as ChildTokenQuery;
use PHPWorkFlow\DB\UseCase as ChildUseCase;
use PHPWorkFlow\DB\UseCaseQuery as ChildUseCaseQuery;
use PHPWorkFlow\DB\WorkItem as ChildWorkItem;
use PHPWorkFlow\DB\WorkItemQuery as ChildWorkItemQuery;
use PHPWorkFlow\DB\Map\TokenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'PHPWF_token' table.
 *
 *
 *
* @package    propel.generator.PHPWorkFlow.DB.Base
*/
abstract class Token implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PHPWorkFlow\\DB\\Map\\TokenTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the token_id field.
     *
     * @var        int
     */
    protected $token_id;

    /**
     * The value for the use_case_id field.
     *
     * @var        int
     */
    protected $use_case_id;

    /**
     * The value for the place_id field.
     *
     * @var        int
     */
    protected $place_id;

    /**
     * The value for the creating_work_item_id field.
     *
     * @var        int
     */
    protected $creating_work_item_id;

    /**
     * The value for the consuming_work_item_id field.
     *
     * @var        int
     */
    protected $consuming_work_item_id;

    /**
     * The value for the token_status field.
     *
     * @var        string
     */
    protected $token_status;

    /**
     * The value for the enabled_date field.
     *
     * @var        \DateTime
     */
    protected $enabled_date;

    /**
     * The value for the cancelled_date field.
     *
     * @var        \DateTime
     */
    protected $cancelled_date;

    /**
     * The value for the consumed_date field.
     *
     * @var        \DateTime
     */
    protected $consumed_date;

    /**
     * The value for the created_at field.
     *
     * @var        \DateTime
     */
    protected $created_at;

    /**
     * The value for the created_by field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $created_by;

    /**
     * The value for the modified_at field.
     *
     * @var        \DateTime
     */
    protected $modified_at;

    /**
     * The value for the modified_by field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $modified_by;

    /**
     * @var        ChildUseCase
     */
    protected $aUseCase;

    /**
     * @var        ChildWorkItem
     */
    protected $aCreatingWorkItem;

    /**
     * @var        ChildWorkItem
     */
    protected $aConsumingWorkItem;

    /**
     * @var        ChildPlace
     */
    protected $aPlace;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->created_by = 0;
        $this->modified_by = 0;
    }

    /**
     * Initializes internal state of PHPWorkFlow\DB\Base\Token object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Token</code> instance.  If
     * <code>obj</code> is an instance of <code>Token</code>, delegates to
     * <code>equals(Token)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Token The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        return array_keys(get_object_vars($this));
    }

    /**
     * Get the [token_id] column value.
     *
     * @return int
     */
    public function getTokenId()
    {
        return $this->token_id;
    }

    /**
     * Get the [use_case_id] column value.
     *
     * @return int
     */
    public function getUseCaseId()
    {
        return $this->use_case_id;
    }

    /**
     * Get the [place_id] column value.
     *
     * @return int
     */
    public function getPlaceId()
    {
        return $this->place_id;
    }

    /**
     * Get the [creating_work_item_id] column value.
     *
     * @return int
     */
    public function getCreatingWorkItemId()
    {
        return $this->creating_work_item_id;
    }

    /**
     * Get the [consuming_work_item_id] column value.
     *
     * @return int
     */
    public function getConsumingWorkItemId()
    {
        return $this->consuming_work_item_id;
    }

    /**
     * Get the [token_status] column value.
     *
     * @return string
     */
    public function getTokenStatus()
    {
        return $this->token_status;
    }

    /**
     * Get the [optionally formatted] temporal [enabled_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEnabledDate($format = NULL)
    {
        if ($format === null) {
            return $this->enabled_date;
        } else {
            return $this->enabled_date instanceof \DateTime ? $this->enabled_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [cancelled_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCancelledDate($format = NULL)
    {
        if ($format === null) {
            return $this->cancelled_date;
        } else {
            return $this->cancelled_date instanceof \DateTime ? $this->cancelled_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [consumed_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getConsumedDate($format = NULL)
    {
        if ($format === null) {
            return $this->consumed_date;
        } else {
            return $this->consumed_date instanceof \DateTime ? $this->consumed_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = NULL)
    {
        if ($format === null) {
            return $this->created_at;
        } else {
            return $this->created_at instanceof \DateTime ? $this->created_at->format($format) : null;
        }
    }

    /**
     * Get the [created_by] column value.
     *
     * @return int
     */
    public function getCreatedBy()
    {
        return $this->created_by;
    }

    /**
     * Get the [optionally formatted] temporal [modified_at] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getModifiedAt($format = NULL)
    {
        if ($format === null) {
            return $this->modified_at;
        } else {
            return $this->modified_at instanceof \DateTime ? $this->modified_at->format($format) : null;
        }
    }

    /**
     * Get the [modified_by] column value.
     *
     * @return int
     */
    public function getModifiedBy()
    {
        return $this->modified_by;
    }

    /**
     * Set the value of [token_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setTokenId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->token_id !== $v) {
            $this->token_id = $v;
            $this->modifiedColumns[TokenTableMap::COL_TOKEN_ID] = true;
        }

        return $this;
    } // setTokenId()

    /**
     * Set the value of [use_case_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setUseCaseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->use_case_id !== $v) {
            $this->use_case_id = $v;
            $this->modifiedColumns[TokenTableMap::COL_USE_CASE_ID] = true;
        }

        if ($this->aUseCase !== null && $this->aUseCase->getUseCaseId() !== $v) {
            $this->aUseCase = null;
        }

        return $this;
    } // setUseCaseId()

    /**
     * Set the value of [place_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setPlaceId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->place_id !== $v) {
            $this->place_id = $v;
            $this->modifiedColumns[TokenTableMap::COL_PLACE_ID] = true;
        }

        if ($this->aPlace !== null && $this->aPlace->getPlaceId() !== $v) {
            $this->aPlace = null;
        }

        return $this;
    } // setPlaceId()

    /**
     * Set the value of [creating_work_item_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setCreatingWorkItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->creating_work_item_id !== $v) {
            $this->creating_work_item_id = $v;
            $this->modifiedColumns[TokenTableMap::COL_CREATING_WORK_ITEM_ID] = true;
        }

        if ($this->aCreatingWorkItem !== null && $this->aCreatingWorkItem->getWorkItemId() !== $v) {
            $this->aCreatingWorkItem = null;
        }

        return $this;
    } // setCreatingWorkItemId()

    /**
     * Set the value of [consuming_work_item_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setConsumingWorkItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->consuming_work_item_id !== $v) {
            $this->consuming_work_item_id = $v;
            $this->modifiedColumns[TokenTableMap::COL_CONSUMING_WORK_ITEM_ID] = true;
        }

        if ($this->aConsumingWorkItem !== null && $this->aConsumingWorkItem->getWorkItemId() !== $v) {
            $this->aConsumingWorkItem = null;
        }

        return $this;
    } // setConsumingWorkItemId()

    /**
     * Set the value of [token_status] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setTokenStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->token_status !== $v) {
            $this->token_status = $v;
            $this->modifiedColumns[TokenTableMap::COL_TOKEN_STATUS] = true;
        }

        return $this;
    } // setTokenStatus()

    /**
     * Sets the value of [enabled_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setEnabledDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->enabled_date !== null || $dt !== null) {
            if ($this->enabled_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->enabled_date->format("Y-m-d H:i:s")) {
                $this->enabled_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TokenTableMap::COL_ENABLED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEnabledDate()

    /**
     * Sets the value of [cancelled_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setCancelledDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->cancelled_date !== null || $dt !== null) {
            if ($this->cancelled_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->cancelled_date->format("Y-m-d H:i:s")) {
                $this->cancelled_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TokenTableMap::COL_CANCELLED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setCancelledDate()

    /**
     * Sets the value of [consumed_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setConsumedDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->consumed_date !== null || $dt !== null) {
            if ($this->consumed_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->consumed_date->format("Y-m-d H:i:s")) {
                $this->consumed_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TokenTableMap::COL_CONSUMED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setConsumedDate()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TokenTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[TokenTableMap::COL_CREATED_BY] = true;
        }

        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [modified_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setModifiedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_at !== null || $dt !== null) {
            if ($this->modified_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->modified_at->format("Y-m-d H:i:s")) {
                $this->modified_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[TokenTableMap::COL_MODIFIED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setModifiedAt()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[TokenTableMap::COL_MODIFIED_BY] = true;
        }

        return $this;
    } // setModifiedBy()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->created_by !== 0) {
                return false;
            }

            if ($this->modified_by !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : TokenTableMap::translateFieldName('TokenId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->token_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : TokenTableMap::translateFieldName('UseCaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->use_case_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : TokenTableMap::translateFieldName('PlaceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->place_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : TokenTableMap::translateFieldName('CreatingWorkItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->creating_work_item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : TokenTableMap::translateFieldName('ConsumingWorkItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->consuming_work_item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : TokenTableMap::translateFieldName('TokenStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->token_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : TokenTableMap::translateFieldName('EnabledDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->enabled_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : TokenTableMap::translateFieldName('CancelledDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->cancelled_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : TokenTableMap::translateFieldName('ConsumedDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->consumed_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : TokenTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : TokenTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : TokenTableMap::translateFieldName('ModifiedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : TokenTableMap::translateFieldName('ModifiedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modified_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = TokenTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\PHPWorkFlow\\DB\\Token'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
        if ($this->aUseCase !== null && $this->use_case_id !== $this->aUseCase->getUseCaseId()) {
            $this->aUseCase = null;
        }
        if ($this->aPlace !== null && $this->place_id !== $this->aPlace->getPlaceId()) {
            $this->aPlace = null;
        }
        if ($this->aCreatingWorkItem !== null && $this->creating_work_item_id !== $this->aCreatingWorkItem->getWorkItemId()) {
            $this->aCreatingWorkItem = null;
        }
        if ($this->aConsumingWorkItem !== null && $this->consuming_work_item_id !== $this->aConsumingWorkItem->getWorkItemId()) {
            $this->aConsumingWorkItem = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TokenTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildTokenQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUseCase = null;
            $this->aCreatingWorkItem = null;
            $this->aConsumingWorkItem = null;
            $this->aPlace = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Token::setDeleted()
     * @see Token::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildTokenQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $isInsert = $this->isNew();
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                TokenTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUseCase !== null) {
                if ($this->aUseCase->isModified() || $this->aUseCase->isNew()) {
                    $affectedRows += $this->aUseCase->save($con);
                }
                $this->setUseCase($this->aUseCase);
            }

            if ($this->aCreatingWorkItem !== null) {
                if ($this->aCreatingWorkItem->isModified() || $this->aCreatingWorkItem->isNew()) {
                    $affectedRows += $this->aCreatingWorkItem->save($con);
                }
                $this->setCreatingWorkItem($this->aCreatingWorkItem);
            }

            if ($this->aConsumingWorkItem !== null) {
                if ($this->aConsumingWorkItem->isModified() || $this->aConsumingWorkItem->isNew()) {
                    $affectedRows += $this->aConsumingWorkItem->save($con);
                }
                $this->setConsumingWorkItem($this->aConsumingWorkItem);
            }

            if ($this->aPlace !== null) {
                if ($this->aPlace->isModified() || $this->aPlace->isNew()) {
                    $affectedRows += $this->aPlace->save($con);
                }
                $this->setPlace($this->aPlace);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[TokenTableMap::COL_TOKEN_ID] = true;
        if (null !== $this->token_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TokenTableMap::COL_TOKEN_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TokenTableMap::COL_TOKEN_ID)) {
            $modifiedColumns[':p' . $index++]  = 'token_id';
        }
        if ($this->isColumnModified(TokenTableMap::COL_USE_CASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'use_case_id';
        }
        if ($this->isColumnModified(TokenTableMap::COL_PLACE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'place_id';
        }
        if ($this->isColumnModified(TokenTableMap::COL_CREATING_WORK_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'creating_work_item_id';
        }
        if ($this->isColumnModified(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'consuming_work_item_id';
        }
        if ($this->isColumnModified(TokenTableMap::COL_TOKEN_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'token_status';
        }
        if ($this->isColumnModified(TokenTableMap::COL_ENABLED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'enabled_date';
        }
        if ($this->isColumnModified(TokenTableMap::COL_CANCELLED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'cancelled_date';
        }
        if ($this->isColumnModified(TokenTableMap::COL_CONSUMED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'consumed_date';
        }
        if ($this->isColumnModified(TokenTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(TokenTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(TokenTableMap::COL_MODIFIED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'modified_at';
        }
        if ($this->isColumnModified(TokenTableMap::COL_MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'modified_by';
        }

        $sql = sprintf(
            'INSERT INTO PHPWF_token (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'token_id':
                        $stmt->bindValue($identifier, $this->token_id, PDO::PARAM_INT);
                        break;
                    case 'use_case_id':
                        $stmt->bindValue($identifier, $this->use_case_id, PDO::PARAM_INT);
                        break;
                    case 'place_id':
                        $stmt->bindValue($identifier, $this->place_id, PDO::PARAM_INT);
                        break;
                    case 'creating_work_item_id':
                        $stmt->bindValue($identifier, $this->creating_work_item_id, PDO::PARAM_INT);
                        break;
                    case 'consuming_work_item_id':
                        $stmt->bindValue($identifier, $this->consuming_work_item_id, PDO::PARAM_INT);
                        break;
                    case 'token_status':
                        $stmt->bindValue($identifier, $this->token_status, PDO::PARAM_STR);
                        break;
                    case 'enabled_date':
                        $stmt->bindValue($identifier, $this->enabled_date ? $this->enabled_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'cancelled_date':
                        $stmt->bindValue($identifier, $this->cancelled_date ? $this->cancelled_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'consumed_date':
                        $stmt->bindValue($identifier, $this->consumed_date ? $this->consumed_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'created_at':
                        $stmt->bindValue($identifier, $this->created_at ? $this->created_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'created_by':
                        $stmt->bindValue($identifier, $this->created_by, PDO::PARAM_INT);
                        break;
                    case 'modified_at':
                        $stmt->bindValue($identifier, $this->modified_at ? $this->modified_at->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'modified_by':
                        $stmt->bindValue($identifier, $this->modified_by, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setTokenId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TokenTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getTokenId();
                break;
            case 1:
                return $this->getUseCaseId();
                break;
            case 2:
                return $this->getPlaceId();
                break;
            case 3:
                return $this->getCreatingWorkItemId();
                break;
            case 4:
                return $this->getConsumingWorkItemId();
                break;
            case 5:
                return $this->getTokenStatus();
                break;
            case 6:
                return $this->getEnabledDate();
                break;
            case 7:
                return $this->getCancelledDate();
                break;
            case 8:
                return $this->getConsumedDate();
                break;
            case 9:
                return $this->getCreatedAt();
                break;
            case 10:
                return $this->getCreatedBy();
                break;
            case 11:
                return $this->getModifiedAt();
                break;
            case 12:
                return $this->getModifiedBy();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Token'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Token'][$this->hashCode()] = true;
        $keys = TokenTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getTokenId(),
            $keys[1] => $this->getUseCaseId(),
            $keys[2] => $this->getPlaceId(),
            $keys[3] => $this->getCreatingWorkItemId(),
            $keys[4] => $this->getConsumingWorkItemId(),
            $keys[5] => $this->getTokenStatus(),
            $keys[6] => $this->getEnabledDate(),
            $keys[7] => $this->getCancelledDate(),
            $keys[8] => $this->getConsumedDate(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getCreatedBy(),
            $keys[11] => $this->getModifiedAt(),
            $keys[12] => $this->getModifiedBy(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[7]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[7]];
            $result[$keys[7]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[8]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[8]];
            $result[$keys[8]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[9]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[9]];
            $result[$keys[9]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[11]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[11]];
            $result[$keys[11]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUseCase) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'useCase';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_use_case';
                        break;
                    default:
                        $key = 'UseCase';
                }

                $result[$key] = $this->aUseCase->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCreatingWorkItem) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'workItem';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_work_item';
                        break;
                    default:
                        $key = 'WorkItem';
                }

                $result[$key] = $this->aCreatingWorkItem->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aConsumingWorkItem) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'workItem';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_work_item';
                        break;
                    default:
                        $key = 'WorkItem';
                }

                $result[$key] = $this->aConsumingWorkItem->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPlace) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'place';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_place';
                        break;
                    default:
                        $key = 'Place';
                }

                $result[$key] = $this->aPlace->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\PHPWorkFlow\DB\Token
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = TokenTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\PHPWorkFlow\DB\Token
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setTokenId($value);
                break;
            case 1:
                $this->setUseCaseId($value);
                break;
            case 2:
                $this->setPlaceId($value);
                break;
            case 3:
                $this->setCreatingWorkItemId($value);
                break;
            case 4:
                $this->setConsumingWorkItemId($value);
                break;
            case 5:
                $this->setTokenStatus($value);
                break;
            case 6:
                $this->setEnabledDate($value);
                break;
            case 7:
                $this->setCancelledDate($value);
                break;
            case 8:
                $this->setConsumedDate($value);
                break;
            case 9:
                $this->setCreatedAt($value);
                break;
            case 10:
                $this->setCreatedBy($value);
                break;
            case 11:
                $this->setModifiedAt($value);
                break;
            case 12:
                $this->setModifiedBy($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = TokenTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setTokenId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUseCaseId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPlaceId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCreatingWorkItemId($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setConsumingWorkItemId($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setTokenStatus($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setEnabledDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCancelledDate($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setConsumedDate($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setCreatedAt($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedBy($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setModifiedAt($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setModifiedBy($arr[$keys[12]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\PHPWorkFlow\DB\Token The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TokenTableMap::DATABASE_NAME);

        if ($this->isColumnModified(TokenTableMap::COL_TOKEN_ID)) {
            $criteria->add(TokenTableMap::COL_TOKEN_ID, $this->token_id);
        }
        if ($this->isColumnModified(TokenTableMap::COL_USE_CASE_ID)) {
            $criteria->add(TokenTableMap::COL_USE_CASE_ID, $this->use_case_id);
        }
        if ($this->isColumnModified(TokenTableMap::COL_PLACE_ID)) {
            $criteria->add(TokenTableMap::COL_PLACE_ID, $this->place_id);
        }
        if ($this->isColumnModified(TokenTableMap::COL_CREATING_WORK_ITEM_ID)) {
            $criteria->add(TokenTableMap::COL_CREATING_WORK_ITEM_ID, $this->creating_work_item_id);
        }
        if ($this->isColumnModified(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID)) {
            $criteria->add(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID, $this->consuming_work_item_id);
        }
        if ($this->isColumnModified(TokenTableMap::COL_TOKEN_STATUS)) {
            $criteria->add(TokenTableMap::COL_TOKEN_STATUS, $this->token_status);
        }
        if ($this->isColumnModified(TokenTableMap::COL_ENABLED_DATE)) {
            $criteria->add(TokenTableMap::COL_ENABLED_DATE, $this->enabled_date);
        }
        if ($this->isColumnModified(TokenTableMap::COL_CANCELLED_DATE)) {
            $criteria->add(TokenTableMap::COL_CANCELLED_DATE, $this->cancelled_date);
        }
        if ($this->isColumnModified(TokenTableMap::COL_CONSUMED_DATE)) {
            $criteria->add(TokenTableMap::COL_CONSUMED_DATE, $this->consumed_date);
        }
        if ($this->isColumnModified(TokenTableMap::COL_CREATED_AT)) {
            $criteria->add(TokenTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(TokenTableMap::COL_CREATED_BY)) {
            $criteria->add(TokenTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(TokenTableMap::COL_MODIFIED_AT)) {
            $criteria->add(TokenTableMap::COL_MODIFIED_AT, $this->modified_at);
        }
        if ($this->isColumnModified(TokenTableMap::COL_MODIFIED_BY)) {
            $criteria->add(TokenTableMap::COL_MODIFIED_BY, $this->modified_by);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildTokenQuery::create();
        $criteria->add(TokenTableMap::COL_TOKEN_ID, $this->token_id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getTokenId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getTokenId();
    }

    /**
     * Generic method to set the primary key (token_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setTokenId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getTokenId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \PHPWorkFlow\DB\Token (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUseCaseId($this->getUseCaseId());
        $copyObj->setPlaceId($this->getPlaceId());
        $copyObj->setCreatingWorkItemId($this->getCreatingWorkItemId());
        $copyObj->setConsumingWorkItemId($this->getConsumingWorkItemId());
        $copyObj->setTokenStatus($this->getTokenStatus());
        $copyObj->setEnabledDate($this->getEnabledDate());
        $copyObj->setCancelledDate($this->getCancelledDate());
        $copyObj->setConsumedDate($this->getConsumedDate());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setModifiedAt($this->getModifiedAt());
        $copyObj->setModifiedBy($this->getModifiedBy());
        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setTokenId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \PHPWorkFlow\DB\Token Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Declares an association between this object and a ChildUseCase object.
     *
     * @param  ChildUseCase $v
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUseCase(ChildUseCase $v = null)
    {
        if ($v === null) {
            $this->setUseCaseId(NULL);
        } else {
            $this->setUseCaseId($v->getUseCaseId());
        }

        $this->aUseCase = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUseCase object, it will not be re-added.
        if ($v !== null) {
            $v->addToken($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUseCase object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUseCase The associated ChildUseCase object.
     * @throws PropelException
     */
    public function getUseCase(ConnectionInterface $con = null)
    {
        if ($this->aUseCase === null && ($this->use_case_id !== null)) {
            $this->aUseCase = ChildUseCaseQuery::create()->findPk($this->use_case_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUseCase->addTokens($this);
             */
        }

        return $this->aUseCase;
    }

    /**
     * Declares an association between this object and a ChildWorkItem object.
     *
     * @param  ChildWorkItem $v
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCreatingWorkItem(ChildWorkItem $v = null)
    {
        if ($v === null) {
            $this->setCreatingWorkItemId(NULL);
        } else {
            $this->setCreatingWorkItemId($v->getWorkItemId());
        }

        $this->aCreatingWorkItem = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWorkItem object, it will not be re-added.
        if ($v !== null) {
            $v->addCreatingWorkItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWorkItem object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildWorkItem The associated ChildWorkItem object.
     * @throws PropelException
     */
    public function getCreatingWorkItem(ConnectionInterface $con = null)
    {
        if ($this->aCreatingWorkItem === null && ($this->creating_work_item_id !== null)) {
            $this->aCreatingWorkItem = ChildWorkItemQuery::create()->findPk($this->creating_work_item_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCreatingWorkItem->addCreatingWorkItems($this);
             */
        }

        return $this->aCreatingWorkItem;
    }

    /**
     * Declares an association between this object and a ChildWorkItem object.
     *
     * @param  ChildWorkItem $v
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     * @throws PropelException
     */
    public function setConsumingWorkItem(ChildWorkItem $v = null)
    {
        if ($v === null) {
            $this->setConsumingWorkItemId(NULL);
        } else {
            $this->setConsumingWorkItemId($v->getWorkItemId());
        }

        $this->aConsumingWorkItem = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWorkItem object, it will not be re-added.
        if ($v !== null) {
            $v->addConsumingWorkItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWorkItem object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildWorkItem The associated ChildWorkItem object.
     * @throws PropelException
     */
    public function getConsumingWorkItem(ConnectionInterface $con = null)
    {
        if ($this->aConsumingWorkItem === null && ($this->consuming_work_item_id !== null)) {
            $this->aConsumingWorkItem = ChildWorkItemQuery::create()->findPk($this->consuming_work_item_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aConsumingWorkItem->addConsumingWorkItems($this);
             */
        }

        return $this->aConsumingWorkItem;
    }

    /**
     * Declares an association between this object and a ChildPlace object.
     *
     * @param  ChildPlace $v
     * @return $this|\PHPWorkFlow\DB\Token The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPlace(ChildPlace $v = null)
    {
        if ($v === null) {
            $this->setPlaceId(NULL);
        } else {
            $this->setPlaceId($v->getPlaceId());
        }

        $this->aPlace = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildPlace object, it will not be re-added.
        if ($v !== null) {
            $v->addToken($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildPlace object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildPlace The associated ChildPlace object.
     * @throws PropelException
     */
    public function getPlace(ConnectionInterface $con = null)
    {
        if ($this->aPlace === null && ($this->place_id !== null)) {
            $this->aPlace = ChildPlaceQuery::create()->findPk($this->place_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPlace->addTokens($this);
             */
        }

        return $this->aPlace;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUseCase) {
            $this->aUseCase->removeToken($this);
        }
        if (null !== $this->aCreatingWorkItem) {
            $this->aCreatingWorkItem->removeCreatingWorkItem($this);
        }
        if (null !== $this->aConsumingWorkItem) {
            $this->aConsumingWorkItem->removeConsumingWorkItem($this);
        }
        if (null !== $this->aPlace) {
            $this->aPlace->removeToken($this);
        }
        $this->token_id = null;
        $this->use_case_id = null;
        $this->place_id = null;
        $this->creating_work_item_id = null;
        $this->consuming_work_item_id = null;
        $this->token_status = null;
        $this->enabled_date = null;
        $this->cancelled_date = null;
        $this->consumed_date = null;
        $this->created_at = null;
        $this->created_by = null;
        $this->modified_at = null;
        $this->modified_by = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
        } // if ($deep)

        $this->aUseCase = null;
        $this->aCreatingWorkItem = null;
        $this->aConsumingWorkItem = null;
        $this->aPlace = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TokenTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {

    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {

    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
