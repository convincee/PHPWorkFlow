<?php

namespace PHPWorkFlow\DB\Base;

use \DateTime;
use \Exception;
use \PDO;
use PHPWorkFlow\DB\Arc as ChildArc;
use PHPWorkFlow\DB\ArcQuery as ChildArcQuery;
use PHPWorkFlow\DB\Token as ChildToken;
use PHPWorkFlow\DB\TokenQuery as ChildTokenQuery;
use PHPWorkFlow\DB\Transition as ChildTransition;
use PHPWorkFlow\DB\TransitionQuery as ChildTransitionQuery;
use PHPWorkFlow\DB\UseCase as ChildUseCase;
use PHPWorkFlow\DB\UseCaseQuery as ChildUseCaseQuery;
use PHPWorkFlow\DB\WorkItem as ChildWorkItem;
use PHPWorkFlow\DB\WorkItemQuery as ChildWorkItemQuery;
use PHPWorkFlow\DB\Map\WorkItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'PHPWF_work_item' table.
 *
 *
 *
* @package    propel.generator.PHPWorkFlow.DB.Base
*/
abstract class WorkItem implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PHPWorkFlow\\DB\\Map\\WorkItemTableMap';


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
     * The value for the work_item_id field.
     *
     * @var        int
     */
    protected $work_item_id;

    /**
     * The value for the use_case_id field.
     *
     * @var        int
     */
    protected $use_case_id;

    /**
     * The value for the transition_id field.
     *
     * @var        int
     */
    protected $transition_id;

    /**
     * The value for the work_item_status field.
     *
     * @var        string
     */
    protected $work_item_status;

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
     * The value for the finished_date field.
     *
     * @var        \DateTime
     */
    protected $finished_date;

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
     * @var        ChildTransition
     */
    protected $aTransition;

    /**
     * @var        ChildArc
     */
    protected $aArc;

    /**
     * @var        ObjectCollection|ChildToken[] Collection to store aggregation of ChildToken objects.
     */
    protected $collCreatingWorkItems;
    protected $collCreatingWorkItemsPartial;

    /**
     * @var        ObjectCollection|ChildToken[] Collection to store aggregation of ChildToken objects.
     */
    protected $collConsumingWorkItems;
    protected $collConsumingWorkItemsPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildToken[]
     */
    protected $creatingWorkItemsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildToken[]
     */
    protected $consumingWorkItemsScheduledForDeletion = null;

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
     * Initializes internal state of PHPWorkFlow\DB\Base\WorkItem object.
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
     * Compares this with another <code>WorkItem</code> instance.  If
     * <code>obj</code> is an instance of <code>WorkItem</code>, delegates to
     * <code>equals(WorkItem)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|WorkItem The current object, for fluid interface
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
     * Get the [work_item_id] column value.
     *
     * @return int
     */
    public function getWorkItemId()
    {
        return $this->work_item_id;
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
     * Get the [transition_id] column value.
     *
     * @return int
     */
    public function getTransitionId()
    {
        return $this->transition_id;
    }

    /**
     * Get the [work_item_status] column value.
     *
     * @return string
     */
    public function getWorkItemStatus()
    {
        return $this->work_item_status;
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
     * Get the [optionally formatted] temporal [finished_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getFinishedDate($format = NULL)
    {
        if ($format === null) {
            return $this->finished_date;
        } else {
            return $this->finished_date instanceof \DateTime ? $this->finished_date->format($format) : null;
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
     * Set the value of [work_item_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setWorkItemId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->work_item_id !== $v) {
            $this->work_item_id = $v;
            $this->modifiedColumns[WorkItemTableMap::COL_WORK_ITEM_ID] = true;
        }

        return $this;
    } // setWorkItemId()

    /**
     * Set the value of [use_case_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setUseCaseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->use_case_id !== $v) {
            $this->use_case_id = $v;
            $this->modifiedColumns[WorkItemTableMap::COL_USE_CASE_ID] = true;
        }

        if ($this->aUseCase !== null && $this->aUseCase->getUseCaseId() !== $v) {
            $this->aUseCase = null;
        }

        return $this;
    } // setUseCaseId()

    /**
     * Set the value of [transition_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setTransitionId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->transition_id !== $v) {
            $this->transition_id = $v;
            $this->modifiedColumns[WorkItemTableMap::COL_TRANSITION_ID] = true;
        }

        if ($this->aTransition !== null && $this->aTransition->getTransitionId() !== $v) {
            $this->aTransition = null;
        }

        if ($this->aArc !== null && $this->aArc->getTransitionId() !== $v) {
            $this->aArc = null;
        }

        return $this;
    } // setTransitionId()

    /**
     * Set the value of [work_item_status] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setWorkItemStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->work_item_status !== $v) {
            $this->work_item_status = $v;
            $this->modifiedColumns[WorkItemTableMap::COL_WORK_ITEM_STATUS] = true;
        }

        return $this;
    } // setWorkItemStatus()

    /**
     * Sets the value of [enabled_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setEnabledDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->enabled_date !== null || $dt !== null) {
            if ($this->enabled_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->enabled_date->format("Y-m-d H:i:s")) {
                $this->enabled_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkItemTableMap::COL_ENABLED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEnabledDate()

    /**
     * Sets the value of [cancelled_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setCancelledDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->cancelled_date !== null || $dt !== null) {
            if ($this->cancelled_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->cancelled_date->format("Y-m-d H:i:s")) {
                $this->cancelled_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkItemTableMap::COL_CANCELLED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setCancelledDate()

    /**
     * Sets the value of [finished_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setFinishedDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->finished_date !== null || $dt !== null) {
            if ($this->finished_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->finished_date->format("Y-m-d H:i:s")) {
                $this->finished_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkItemTableMap::COL_FINISHED_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setFinishedDate()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkItemTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[WorkItemTableMap::COL_CREATED_BY] = true;
        }

        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [modified_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setModifiedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_at !== null || $dt !== null) {
            if ($this->modified_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->modified_at->format("Y-m-d H:i:s")) {
                $this->modified_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkItemTableMap::COL_MODIFIED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setModifiedAt()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[WorkItemTableMap::COL_MODIFIED_BY] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : WorkItemTableMap::translateFieldName('WorkItemId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->work_item_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : WorkItemTableMap::translateFieldName('UseCaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->use_case_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : WorkItemTableMap::translateFieldName('TransitionId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->transition_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : WorkItemTableMap::translateFieldName('WorkItemStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->work_item_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : WorkItemTableMap::translateFieldName('EnabledDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->enabled_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : WorkItemTableMap::translateFieldName('CancelledDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->cancelled_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : WorkItemTableMap::translateFieldName('FinishedDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->finished_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : WorkItemTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : WorkItemTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : WorkItemTableMap::translateFieldName('ModifiedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : WorkItemTableMap::translateFieldName('ModifiedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modified_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 11; // 11 = WorkItemTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\PHPWorkFlow\\DB\\WorkItem'), 0, $e);
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
        if ($this->aTransition !== null && $this->transition_id !== $this->aTransition->getTransitionId()) {
            $this->aTransition = null;
        }
        if ($this->aArc !== null && $this->transition_id !== $this->aArc->getTransitionId()) {
            $this->aArc = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(WorkItemTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildWorkItemQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUseCase = null;
            $this->aTransition = null;
            $this->aArc = null;
            $this->collCreatingWorkItems = null;

            $this->collConsumingWorkItems = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see WorkItem::setDeleted()
     * @see WorkItem::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WorkItemTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildWorkItemQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(WorkItemTableMap::DATABASE_NAME);
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
                WorkItemTableMap::addInstanceToPool($this);
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

            if ($this->aTransition !== null) {
                if ($this->aTransition->isModified() || $this->aTransition->isNew()) {
                    $affectedRows += $this->aTransition->save($con);
                }
                $this->setTransition($this->aTransition);
            }

            if ($this->aArc !== null) {
                if ($this->aArc->isModified() || $this->aArc->isNew()) {
                    $affectedRows += $this->aArc->save($con);
                }
                $this->setArc($this->aArc);
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

            if ($this->creatingWorkItemsScheduledForDeletion !== null) {
                if (!$this->creatingWorkItemsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\TokenQuery::create()
                        ->filterByPrimaryKeys($this->creatingWorkItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->creatingWorkItemsScheduledForDeletion = null;
                }
            }

            if ($this->collCreatingWorkItems !== null) {
                foreach ($this->collCreatingWorkItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->consumingWorkItemsScheduledForDeletion !== null) {
                if (!$this->consumingWorkItemsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\TokenQuery::create()
                        ->filterByPrimaryKeys($this->consumingWorkItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->consumingWorkItemsScheduledForDeletion = null;
                }
            }

            if ($this->collConsumingWorkItems !== null) {
                foreach ($this->collConsumingWorkItems as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
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

        $this->modifiedColumns[WorkItemTableMap::COL_WORK_ITEM_ID] = true;
        if (null !== $this->work_item_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WorkItemTableMap::COL_WORK_ITEM_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WorkItemTableMap::COL_WORK_ITEM_ID)) {
            $modifiedColumns[':p' . $index++]  = 'work_item_id';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_USE_CASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'use_case_id';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_TRANSITION_ID)) {
            $modifiedColumns[':p' . $index++]  = 'transition_id';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_WORK_ITEM_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'work_item_status';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_ENABLED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'enabled_date';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_CANCELLED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'cancelled_date';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_FINISHED_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'finished_date';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_MODIFIED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'modified_at';
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'modified_by';
        }

        $sql = sprintf(
            'INSERT INTO PHPWF_work_item (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'work_item_id':
                        $stmt->bindValue($identifier, $this->work_item_id, PDO::PARAM_INT);
                        break;
                    case 'use_case_id':
                        $stmt->bindValue($identifier, $this->use_case_id, PDO::PARAM_INT);
                        break;
                    case 'transition_id':
                        $stmt->bindValue($identifier, $this->transition_id, PDO::PARAM_INT);
                        break;
                    case 'work_item_status':
                        $stmt->bindValue($identifier, $this->work_item_status, PDO::PARAM_STR);
                        break;
                    case 'enabled_date':
                        $stmt->bindValue($identifier, $this->enabled_date ? $this->enabled_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'cancelled_date':
                        $stmt->bindValue($identifier, $this->cancelled_date ? $this->cancelled_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'finished_date':
                        $stmt->bindValue($identifier, $this->finished_date ? $this->finished_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $this->setWorkItemId($pk);

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
        $pos = WorkItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getWorkItemId();
                break;
            case 1:
                return $this->getUseCaseId();
                break;
            case 2:
                return $this->getTransitionId();
                break;
            case 3:
                return $this->getWorkItemStatus();
                break;
            case 4:
                return $this->getEnabledDate();
                break;
            case 5:
                return $this->getCancelledDate();
                break;
            case 6:
                return $this->getFinishedDate();
                break;
            case 7:
                return $this->getCreatedAt();
                break;
            case 8:
                return $this->getCreatedBy();
                break;
            case 9:
                return $this->getModifiedAt();
                break;
            case 10:
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

        if (isset($alreadyDumpedObjects['WorkItem'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['WorkItem'][$this->hashCode()] = true;
        $keys = WorkItemTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getWorkItemId(),
            $keys[1] => $this->getUseCaseId(),
            $keys[2] => $this->getTransitionId(),
            $keys[3] => $this->getWorkItemStatus(),
            $keys[4] => $this->getEnabledDate(),
            $keys[5] => $this->getCancelledDate(),
            $keys[6] => $this->getFinishedDate(),
            $keys[7] => $this->getCreatedAt(),
            $keys[8] => $this->getCreatedBy(),
            $keys[9] => $this->getModifiedAt(),
            $keys[10] => $this->getModifiedBy(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[5]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[5]];
            $result[$keys[5]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

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

        if ($result[$keys[9]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[9]];
            $result[$keys[9]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
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
            if (null !== $this->aTransition) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transition';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_transition';
                        break;
                    default:
                        $key = 'Transition';
                }

                $result[$key] = $this->aTransition->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aArc) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'arc';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_arc';
                        break;
                    default:
                        $key = 'Arc';
                }

                $result[$key] = $this->aArc->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collCreatingWorkItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tokens';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_tokens';
                        break;
                    default:
                        $key = 'Tokens';
                }

                $result[$key] = $this->collCreatingWorkItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collConsumingWorkItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'tokens';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_tokens';
                        break;
                    default:
                        $key = 'Tokens';
                }

                $result[$key] = $this->collConsumingWorkItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\PHPWorkFlow\DB\WorkItem
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = WorkItemTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\PHPWorkFlow\DB\WorkItem
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setWorkItemId($value);
                break;
            case 1:
                $this->setUseCaseId($value);
                break;
            case 2:
                $this->setTransitionId($value);
                break;
            case 3:
                $this->setWorkItemStatus($value);
                break;
            case 4:
                $this->setEnabledDate($value);
                break;
            case 5:
                $this->setCancelledDate($value);
                break;
            case 6:
                $this->setFinishedDate($value);
                break;
            case 7:
                $this->setCreatedAt($value);
                break;
            case 8:
                $this->setCreatedBy($value);
                break;
            case 9:
                $this->setModifiedAt($value);
                break;
            case 10:
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
        $keys = WorkItemTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setWorkItemId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUseCaseId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTransitionId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setWorkItemStatus($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEnabledDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCancelledDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setFinishedDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCreatedAt($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setCreatedBy($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setModifiedAt($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setModifiedBy($arr[$keys[10]]);
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
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object, for fluid interface
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
        $criteria = new Criteria(WorkItemTableMap::DATABASE_NAME);

        if ($this->isColumnModified(WorkItemTableMap::COL_WORK_ITEM_ID)) {
            $criteria->add(WorkItemTableMap::COL_WORK_ITEM_ID, $this->work_item_id);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_USE_CASE_ID)) {
            $criteria->add(WorkItemTableMap::COL_USE_CASE_ID, $this->use_case_id);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_TRANSITION_ID)) {
            $criteria->add(WorkItemTableMap::COL_TRANSITION_ID, $this->transition_id);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_WORK_ITEM_STATUS)) {
            $criteria->add(WorkItemTableMap::COL_WORK_ITEM_STATUS, $this->work_item_status);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_ENABLED_DATE)) {
            $criteria->add(WorkItemTableMap::COL_ENABLED_DATE, $this->enabled_date);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_CANCELLED_DATE)) {
            $criteria->add(WorkItemTableMap::COL_CANCELLED_DATE, $this->cancelled_date);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_FINISHED_DATE)) {
            $criteria->add(WorkItemTableMap::COL_FINISHED_DATE, $this->finished_date);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_CREATED_AT)) {
            $criteria->add(WorkItemTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_CREATED_BY)) {
            $criteria->add(WorkItemTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_MODIFIED_AT)) {
            $criteria->add(WorkItemTableMap::COL_MODIFIED_AT, $this->modified_at);
        }
        if ($this->isColumnModified(WorkItemTableMap::COL_MODIFIED_BY)) {
            $criteria->add(WorkItemTableMap::COL_MODIFIED_BY, $this->modified_by);
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
        $criteria = ChildWorkItemQuery::create();
        $criteria->add(WorkItemTableMap::COL_WORK_ITEM_ID, $this->work_item_id);

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
        $validPk = null !== $this->getWorkItemId();

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
        return $this->getWorkItemId();
    }

    /**
     * Generic method to set the primary key (work_item_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setWorkItemId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getWorkItemId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \PHPWorkFlow\DB\WorkItem (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUseCaseId($this->getUseCaseId());
        $copyObj->setTransitionId($this->getTransitionId());
        $copyObj->setWorkItemStatus($this->getWorkItemStatus());
        $copyObj->setEnabledDate($this->getEnabledDate());
        $copyObj->setCancelledDate($this->getCancelledDate());
        $copyObj->setFinishedDate($this->getFinishedDate());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setModifiedAt($this->getModifiedAt());
        $copyObj->setModifiedBy($this->getModifiedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCreatingWorkItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCreatingWorkItem($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getConsumingWorkItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addConsumingWorkItem($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setWorkItemId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \PHPWorkFlow\DB\WorkItem Clone of current object.
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
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
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
            $v->addWorkItem($this);
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
                $this->aUseCase->addWorkItems($this);
             */
        }

        return $this->aUseCase;
    }

    /**
     * Declares an association between this object and a ChildTransition object.
     *
     * @param  ChildTransition $v
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTransition(ChildTransition $v = null)
    {
        if ($v === null) {
            $this->setTransitionId(NULL);
        } else {
            $this->setTransitionId($v->getTransitionId());
        }

        $this->aTransition = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildTransition object, it will not be re-added.
        if ($v !== null) {
            $v->addWorkItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildTransition object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildTransition The associated ChildTransition object.
     * @throws PropelException
     */
    public function getTransition(ConnectionInterface $con = null)
    {
        if ($this->aTransition === null && ($this->transition_id !== null)) {
            $this->aTransition = ChildTransitionQuery::create()->findPk($this->transition_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTransition->addWorkItems($this);
             */
        }

        return $this->aTransition;
    }

    /**
     * Declares an association between this object and a ChildArc object.
     *
     * @param  ChildArc $v
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     * @throws PropelException
     */
    public function setArc(ChildArc $v = null)
    {
        if ($v === null) {
            $this->setTransitionId(NULL);
        } else {
            $this->setTransitionId($v->getTransitionId());
        }

        $this->aArc = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildArc object, it will not be re-added.
        if ($v !== null) {
            $v->addWorkItem($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildArc object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildArc The associated ChildArc object.
     * @throws PropelException
     */
    public function getArc(ConnectionInterface $con = null)
    {
        if ($this->aArc === null && ($this->transition_id !== null)) {
            $this->aArc = ChildArcQuery::create()
                ->filterByWorkItem($this) // here
                ->findOne($con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aArc->addWorkItems($this);
             */
        }

        return $this->aArc;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('CreatingWorkItem' == $relationName) {
            return $this->initCreatingWorkItems();
        }
        if ('ConsumingWorkItem' == $relationName) {
            return $this->initConsumingWorkItems();
        }
    }

    /**
     * Clears out the collCreatingWorkItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCreatingWorkItems()
     */
    public function clearCreatingWorkItems()
    {
        $this->collCreatingWorkItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCreatingWorkItems collection loaded partially.
     */
    public function resetPartialCreatingWorkItems($v = true)
    {
        $this->collCreatingWorkItemsPartial = $v;
    }

    /**
     * Initializes the collCreatingWorkItems collection.
     *
     * By default this just sets the collCreatingWorkItems collection to an empty array (like clearcollCreatingWorkItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCreatingWorkItems($overrideExisting = true)
    {
        if (null !== $this->collCreatingWorkItems && !$overrideExisting) {
            return;
        }
        $this->collCreatingWorkItems = new ObjectCollection();
        $this->collCreatingWorkItems->setModel('\PHPWorkFlow\DB\Token');
    }

    /**
     * Gets an array of ChildToken objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWorkItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     * @throws PropelException
     */
    public function getCreatingWorkItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCreatingWorkItemsPartial && !$this->isNew();
        if (null === $this->collCreatingWorkItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCreatingWorkItems) {
                // return empty collection
                $this->initCreatingWorkItems();
            } else {
                $collCreatingWorkItems = ChildTokenQuery::create(null, $criteria)
                    ->filterByCreatingWorkItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCreatingWorkItemsPartial && count($collCreatingWorkItems)) {
                        $this->initCreatingWorkItems(false);

                        foreach ($collCreatingWorkItems as $obj) {
                            if (false == $this->collCreatingWorkItems->contains($obj)) {
                                $this->collCreatingWorkItems->append($obj);
                            }
                        }

                        $this->collCreatingWorkItemsPartial = true;
                    }

                    return $collCreatingWorkItems;
                }

                if ($partial && $this->collCreatingWorkItems) {
                    foreach ($this->collCreatingWorkItems as $obj) {
                        if ($obj->isNew()) {
                            $collCreatingWorkItems[] = $obj;
                        }
                    }
                }

                $this->collCreatingWorkItems = $collCreatingWorkItems;
                $this->collCreatingWorkItemsPartial = false;
            }
        }

        return $this->collCreatingWorkItems;
    }

    /**
     * Sets a collection of ChildToken objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $creatingWorkItems A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWorkItem The current object (for fluent API support)
     */
    public function setCreatingWorkItems(Collection $creatingWorkItems, ConnectionInterface $con = null)
    {
        /** @var ChildToken[] $creatingWorkItemsToDelete */
        $creatingWorkItemsToDelete = $this->getCreatingWorkItems(new Criteria(), $con)->diff($creatingWorkItems);


        $this->creatingWorkItemsScheduledForDeletion = $creatingWorkItemsToDelete;

        foreach ($creatingWorkItemsToDelete as $creatingWorkItemRemoved) {
            $creatingWorkItemRemoved->setCreatingWorkItem(null);
        }

        $this->collCreatingWorkItems = null;
        foreach ($creatingWorkItems as $creatingWorkItem) {
            $this->addCreatingWorkItem($creatingWorkItem);
        }

        $this->collCreatingWorkItems = $creatingWorkItems;
        $this->collCreatingWorkItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Token objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Token objects.
     * @throws PropelException
     */
    public function countCreatingWorkItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCreatingWorkItemsPartial && !$this->isNew();
        if (null === $this->collCreatingWorkItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCreatingWorkItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCreatingWorkItems());
            }

            $query = ChildTokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCreatingWorkItem($this)
                ->count($con);
        }

        return count($this->collCreatingWorkItems);
    }

    /**
     * Method called to associate a ChildToken object to this object
     * through the ChildToken foreign key attribute.
     *
     * @param  ChildToken $l ChildToken
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function addCreatingWorkItem(ChildToken $l)
    {
        if ($this->collCreatingWorkItems === null) {
            $this->initCreatingWorkItems();
            $this->collCreatingWorkItemsPartial = true;
        }

        if (!$this->collCreatingWorkItems->contains($l)) {
            $this->doAddCreatingWorkItem($l);
        }

        return $this;
    }

    /**
     * @param ChildToken $creatingWorkItem The ChildToken object to add.
     */
    protected function doAddCreatingWorkItem(ChildToken $creatingWorkItem)
    {
        $this->collCreatingWorkItems[]= $creatingWorkItem;
        $creatingWorkItem->setCreatingWorkItem($this);
    }

    /**
     * @param  ChildToken $creatingWorkItem The ChildToken object to remove.
     * @return $this|ChildWorkItem The current object (for fluent API support)
     */
    public function removeCreatingWorkItem(ChildToken $creatingWorkItem)
    {
        if ($this->getCreatingWorkItems()->contains($creatingWorkItem)) {
            $pos = $this->collCreatingWorkItems->search($creatingWorkItem);
            $this->collCreatingWorkItems->remove($pos);
            if (null === $this->creatingWorkItemsScheduledForDeletion) {
                $this->creatingWorkItemsScheduledForDeletion = clone $this->collCreatingWorkItems;
                $this->creatingWorkItemsScheduledForDeletion->clear();
            }
            $this->creatingWorkItemsScheduledForDeletion[]= $creatingWorkItem;
            $creatingWorkItem->setCreatingWorkItem(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkItem is new, it will return
     * an empty collection; or if this WorkItem has previously
     * been saved, it will retrieve related CreatingWorkItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkItem.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getCreatingWorkItemsJoinUseCase(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('UseCase', $joinBehavior);

        return $this->getCreatingWorkItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkItem is new, it will return
     * an empty collection; or if this WorkItem has previously
     * been saved, it will retrieve related CreatingWorkItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkItem.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getCreatingWorkItemsJoinPlace(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('Place', $joinBehavior);

        return $this->getCreatingWorkItems($query, $con);
    }

    /**
     * Clears out the collConsumingWorkItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addConsumingWorkItems()
     */
    public function clearConsumingWorkItems()
    {
        $this->collConsumingWorkItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collConsumingWorkItems collection loaded partially.
     */
    public function resetPartialConsumingWorkItems($v = true)
    {
        $this->collConsumingWorkItemsPartial = $v;
    }

    /**
     * Initializes the collConsumingWorkItems collection.
     *
     * By default this just sets the collConsumingWorkItems collection to an empty array (like clearcollConsumingWorkItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initConsumingWorkItems($overrideExisting = true)
    {
        if (null !== $this->collConsumingWorkItems && !$overrideExisting) {
            return;
        }
        $this->collConsumingWorkItems = new ObjectCollection();
        $this->collConsumingWorkItems->setModel('\PHPWorkFlow\DB\Token');
    }

    /**
     * Gets an array of ChildToken objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWorkItem is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     * @throws PropelException
     */
    public function getConsumingWorkItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collConsumingWorkItemsPartial && !$this->isNew();
        if (null === $this->collConsumingWorkItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collConsumingWorkItems) {
                // return empty collection
                $this->initConsumingWorkItems();
            } else {
                $collConsumingWorkItems = ChildTokenQuery::create(null, $criteria)
                    ->filterByConsumingWorkItem($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collConsumingWorkItemsPartial && count($collConsumingWorkItems)) {
                        $this->initConsumingWorkItems(false);

                        foreach ($collConsumingWorkItems as $obj) {
                            if (false == $this->collConsumingWorkItems->contains($obj)) {
                                $this->collConsumingWorkItems->append($obj);
                            }
                        }

                        $this->collConsumingWorkItemsPartial = true;
                    }

                    return $collConsumingWorkItems;
                }

                if ($partial && $this->collConsumingWorkItems) {
                    foreach ($this->collConsumingWorkItems as $obj) {
                        if ($obj->isNew()) {
                            $collConsumingWorkItems[] = $obj;
                        }
                    }
                }

                $this->collConsumingWorkItems = $collConsumingWorkItems;
                $this->collConsumingWorkItemsPartial = false;
            }
        }

        return $this->collConsumingWorkItems;
    }

    /**
     * Sets a collection of ChildToken objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $consumingWorkItems A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWorkItem The current object (for fluent API support)
     */
    public function setConsumingWorkItems(Collection $consumingWorkItems, ConnectionInterface $con = null)
    {
        /** @var ChildToken[] $consumingWorkItemsToDelete */
        $consumingWorkItemsToDelete = $this->getConsumingWorkItems(new Criteria(), $con)->diff($consumingWorkItems);


        $this->consumingWorkItemsScheduledForDeletion = $consumingWorkItemsToDelete;

        foreach ($consumingWorkItemsToDelete as $consumingWorkItemRemoved) {
            $consumingWorkItemRemoved->setConsumingWorkItem(null);
        }

        $this->collConsumingWorkItems = null;
        foreach ($consumingWorkItems as $consumingWorkItem) {
            $this->addConsumingWorkItem($consumingWorkItem);
        }

        $this->collConsumingWorkItems = $consumingWorkItems;
        $this->collConsumingWorkItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Token objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Token objects.
     * @throws PropelException
     */
    public function countConsumingWorkItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collConsumingWorkItemsPartial && !$this->isNew();
        if (null === $this->collConsumingWorkItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collConsumingWorkItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getConsumingWorkItems());
            }

            $query = ChildTokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByConsumingWorkItem($this)
                ->count($con);
        }

        return count($this->collConsumingWorkItems);
    }

    /**
     * Method called to associate a ChildToken object to this object
     * through the ChildToken foreign key attribute.
     *
     * @param  ChildToken $l ChildToken
     * @return $this|\PHPWorkFlow\DB\WorkItem The current object (for fluent API support)
     */
    public function addConsumingWorkItem(ChildToken $l)
    {
        if ($this->collConsumingWorkItems === null) {
            $this->initConsumingWorkItems();
            $this->collConsumingWorkItemsPartial = true;
        }

        if (!$this->collConsumingWorkItems->contains($l)) {
            $this->doAddConsumingWorkItem($l);
        }

        return $this;
    }

    /**
     * @param ChildToken $consumingWorkItem The ChildToken object to add.
     */
    protected function doAddConsumingWorkItem(ChildToken $consumingWorkItem)
    {
        $this->collConsumingWorkItems[]= $consumingWorkItem;
        $consumingWorkItem->setConsumingWorkItem($this);
    }

    /**
     * @param  ChildToken $consumingWorkItem The ChildToken object to remove.
     * @return $this|ChildWorkItem The current object (for fluent API support)
     */
    public function removeConsumingWorkItem(ChildToken $consumingWorkItem)
    {
        if ($this->getConsumingWorkItems()->contains($consumingWorkItem)) {
            $pos = $this->collConsumingWorkItems->search($consumingWorkItem);
            $this->collConsumingWorkItems->remove($pos);
            if (null === $this->consumingWorkItemsScheduledForDeletion) {
                $this->consumingWorkItemsScheduledForDeletion = clone $this->collConsumingWorkItems;
                $this->consumingWorkItemsScheduledForDeletion->clear();
            }
            $this->consumingWorkItemsScheduledForDeletion[]= $consumingWorkItem;
            $consumingWorkItem->setConsumingWorkItem(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkItem is new, it will return
     * an empty collection; or if this WorkItem has previously
     * been saved, it will retrieve related ConsumingWorkItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkItem.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getConsumingWorkItemsJoinUseCase(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('UseCase', $joinBehavior);

        return $this->getConsumingWorkItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkItem is new, it will return
     * an empty collection; or if this WorkItem has previously
     * been saved, it will retrieve related ConsumingWorkItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkItem.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getConsumingWorkItemsJoinPlace(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('Place', $joinBehavior);

        return $this->getConsumingWorkItems($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUseCase) {
            $this->aUseCase->removeWorkItem($this);
        }
        if (null !== $this->aTransition) {
            $this->aTransition->removeWorkItem($this);
        }
        if (null !== $this->aArc) {
            $this->aArc->removeWorkItem($this);
        }
        $this->work_item_id = null;
        $this->use_case_id = null;
        $this->transition_id = null;
        $this->work_item_status = null;
        $this->enabled_date = null;
        $this->cancelled_date = null;
        $this->finished_date = null;
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
            if ($this->collCreatingWorkItems) {
                foreach ($this->collCreatingWorkItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collConsumingWorkItems) {
                foreach ($this->collConsumingWorkItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCreatingWorkItems = null;
        $this->collConsumingWorkItems = null;
        $this->aUseCase = null;
        $this->aTransition = null;
        $this->aArc = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(WorkItemTableMap::DEFAULT_STRING_FORMAT);
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
