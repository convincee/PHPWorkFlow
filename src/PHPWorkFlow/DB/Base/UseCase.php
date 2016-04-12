<?php

namespace PHPWorkFlow\DB\Base;

use \DateTime;
use \Exception;
use \PDO;
use PHPWorkFlow\DB\Token as ChildToken;
use PHPWorkFlow\DB\TokenQuery as ChildTokenQuery;
use PHPWorkFlow\DB\TriggerFulfillment as ChildTriggerFulfillment;
use PHPWorkFlow\DB\TriggerFulfillmentQuery as ChildTriggerFulfillmentQuery;
use PHPWorkFlow\DB\UseCase as ChildUseCase;
use PHPWorkFlow\DB\UseCaseContext as ChildUseCaseContext;
use PHPWorkFlow\DB\UseCaseContextQuery as ChildUseCaseContextQuery;
use PHPWorkFlow\DB\UseCaseQuery as ChildUseCaseQuery;
use PHPWorkFlow\DB\WorkFlow as ChildWorkFlow;
use PHPWorkFlow\DB\WorkFlowQuery as ChildWorkFlowQuery;
use PHPWorkFlow\DB\WorkItem as ChildWorkItem;
use PHPWorkFlow\DB\WorkItemQuery as ChildWorkItemQuery;
use PHPWorkFlow\DB\Map\UseCaseTableMap;
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
 * Base class that represents a row from the 'PHPWF_use_case' table.
 *
 *
 *
* @package    propel.generator.PHPWorkFlow.DB.Base
*/
abstract class UseCase implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PHPWorkFlow\\DB\\Map\\UseCaseTableMap';


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
     * The value for the use_case_id field.
     *
     * @var        int
     */
    protected $use_case_id;

    /**
     * The value for the work_flow_id field.
     *
     * @var        int
     */
    protected $work_flow_id;

    /**
     * The value for the parent_use_case_id field.
     *
     * @var        int
     */
    protected $parent_use_case_id;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the use_case_group field.
     *
     * @var        string
     */
    protected $use_case_group;

    /**
     * The value for the use_case_status field.
     *
     * @var        string
     */
    protected $use_case_status;

    /**
     * The value for the start_date field.
     *
     * @var        \DateTime
     */
    protected $start_date;

    /**
     * The value for the end_date field.
     *
     * @var        \DateTime
     */
    protected $end_date;

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
    protected $aUseCaseRelatedByParentUseCaseId;

    /**
     * @var        ChildWorkFlow
     */
    protected $aWorkFlow;

    /**
     * @var        ObjectCollection|ChildToken[] Collection to store aggregation of ChildToken objects.
     */
    protected $collTokens;
    protected $collTokensPartial;

    /**
     * @var        ObjectCollection|ChildTriggerFulfillment[] Collection to store aggregation of ChildTriggerFulfillment objects.
     */
    protected $collTriggerFulfillments;
    protected $collTriggerFulfillmentsPartial;

    /**
     * @var        ObjectCollection|ChildUseCase[] Collection to store aggregation of ChildUseCase objects.
     */
    protected $collUseCasesRelatedByUseCaseId;
    protected $collUseCasesRelatedByUseCaseIdPartial;

    /**
     * @var        ObjectCollection|ChildUseCaseContext[] Collection to store aggregation of ChildUseCaseContext objects.
     */
    protected $collUseCaseContexts;
    protected $collUseCaseContextsPartial;

    /**
     * @var        ObjectCollection|ChildWorkItem[] Collection to store aggregation of ChildWorkItem objects.
     */
    protected $collWorkItems;
    protected $collWorkItemsPartial;

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
    protected $tokensScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTriggerFulfillment[]
     */
    protected $triggerFulfillmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUseCase[]
     */
    protected $useCasesRelatedByUseCaseIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUseCaseContext[]
     */
    protected $useCaseContextsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildWorkItem[]
     */
    protected $workItemsScheduledForDeletion = null;

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
     * Initializes internal state of PHPWorkFlow\DB\Base\UseCase object.
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
     * Compares this with another <code>UseCase</code> instance.  If
     * <code>obj</code> is an instance of <code>UseCase</code>, delegates to
     * <code>equals(UseCase)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|UseCase The current object, for fluid interface
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
     * Get the [use_case_id] column value.
     *
     * @return int
     */
    public function getUseCaseId()
    {
        return $this->use_case_id;
    }

    /**
     * Get the [work_flow_id] column value.
     *
     * @return int
     */
    public function getWorkFlowId()
    {
        return $this->work_flow_id;
    }

    /**
     * Get the [parent_use_case_id] column value.
     *
     * @return int
     */
    public function getParentUseCaseId()
    {
        return $this->parent_use_case_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [use_case_group] column value.
     *
     * @return string
     */
    public function getUseCaseGroup()
    {
        return $this->use_case_group;
    }

    /**
     * Get the [use_case_status] column value.
     *
     * @return string
     */
    public function getUseCaseStatus()
    {
        return $this->use_case_status;
    }

    /**
     * Get the [optionally formatted] temporal [start_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getStartDate($format = NULL)
    {
        if ($format === null) {
            return $this->start_date;
        } else {
            return $this->start_date instanceof \DateTime ? $this->start_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [end_date] column value.
     *
     *
     * @param      string $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEndDate($format = NULL)
    {
        if ($format === null) {
            return $this->end_date;
        } else {
            return $this->end_date instanceof \DateTime ? $this->end_date->format($format) : null;
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
     * Set the value of [use_case_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setUseCaseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->use_case_id !== $v) {
            $this->use_case_id = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_USE_CASE_ID] = true;
        }

        return $this;
    } // setUseCaseId()

    /**
     * Set the value of [work_flow_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setWorkFlowId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->work_flow_id !== $v) {
            $this->work_flow_id = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_WORK_FLOW_ID] = true;
        }

        if ($this->aWorkFlow !== null && $this->aWorkFlow->getWorkFlowId() !== $v) {
            $this->aWorkFlow = null;
        }

        return $this;
    } // setWorkFlowId()

    /**
     * Set the value of [parent_use_case_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setParentUseCaseId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->parent_use_case_id !== $v) {
            $this->parent_use_case_id = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_PARENT_USE_CASE_ID] = true;
        }

        if ($this->aUseCaseRelatedByParentUseCaseId !== null && $this->aUseCaseRelatedByParentUseCaseId->getUseCaseId() !== $v) {
            $this->aUseCaseRelatedByParentUseCaseId = null;
        }

        return $this;
    } // setParentUseCaseId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [use_case_group] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setUseCaseGroup($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->use_case_group !== $v) {
            $this->use_case_group = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_USE_CASE_GROUP] = true;
        }

        return $this;
    } // setUseCaseGroup()

    /**
     * Set the value of [use_case_status] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setUseCaseStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->use_case_status !== $v) {
            $this->use_case_status = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_USE_CASE_STATUS] = true;
        }

        return $this;
    } // setUseCaseStatus()

    /**
     * Sets the value of [start_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setStartDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->start_date !== null || $dt !== null) {
            if ($this->start_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->start_date->format("Y-m-d H:i:s")) {
                $this->start_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UseCaseTableMap::COL_START_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setStartDate()

    /**
     * Sets the value of [end_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setEndDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->end_date !== null || $dt !== null) {
            if ($this->end_date === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->end_date->format("Y-m-d H:i:s")) {
                $this->end_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UseCaseTableMap::COL_END_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEndDate()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UseCaseTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_CREATED_BY] = true;
        }

        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [modified_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setModifiedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_at !== null || $dt !== null) {
            if ($this->modified_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->modified_at->format("Y-m-d H:i:s")) {
                $this->modified_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UseCaseTableMap::COL_MODIFIED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setModifiedAt()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[UseCaseTableMap::COL_MODIFIED_BY] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UseCaseTableMap::translateFieldName('UseCaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->use_case_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UseCaseTableMap::translateFieldName('WorkFlowId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->work_flow_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UseCaseTableMap::translateFieldName('ParentUseCaseId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent_use_case_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UseCaseTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UseCaseTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UseCaseTableMap::translateFieldName('UseCaseGroup', TableMap::TYPE_PHPNAME, $indexType)];
            $this->use_case_group = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UseCaseTableMap::translateFieldName('UseCaseStatus', TableMap::TYPE_PHPNAME, $indexType)];
            $this->use_case_status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UseCaseTableMap::translateFieldName('StartDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->start_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UseCaseTableMap::translateFieldName('EndDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->end_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UseCaseTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UseCaseTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : UseCaseTableMap::translateFieldName('ModifiedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : UseCaseTableMap::translateFieldName('ModifiedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modified_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = UseCaseTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\PHPWorkFlow\\DB\\UseCase'), 0, $e);
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
        if ($this->aWorkFlow !== null && $this->work_flow_id !== $this->aWorkFlow->getWorkFlowId()) {
            $this->aWorkFlow = null;
        }
        if ($this->aUseCaseRelatedByParentUseCaseId !== null && $this->parent_use_case_id !== $this->aUseCaseRelatedByParentUseCaseId->getUseCaseId()) {
            $this->aUseCaseRelatedByParentUseCaseId = null;
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
            $con = Propel::getServiceContainer()->getReadConnection(UseCaseTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUseCaseQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUseCaseRelatedByParentUseCaseId = null;
            $this->aWorkFlow = null;
            $this->collTokens = null;

            $this->collTriggerFulfillments = null;

            $this->collUseCasesRelatedByUseCaseId = null;

            $this->collUseCaseContexts = null;

            $this->collWorkItems = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see UseCase::setDeleted()
     * @see UseCase::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUseCaseQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseTableMap::DATABASE_NAME);
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
                UseCaseTableMap::addInstanceToPool($this);
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

            if ($this->aUseCaseRelatedByParentUseCaseId !== null) {
                if ($this->aUseCaseRelatedByParentUseCaseId->isModified() || $this->aUseCaseRelatedByParentUseCaseId->isNew()) {
                    $affectedRows += $this->aUseCaseRelatedByParentUseCaseId->save($con);
                }
                $this->setUseCaseRelatedByParentUseCaseId($this->aUseCaseRelatedByParentUseCaseId);
            }

            if ($this->aWorkFlow !== null) {
                if ($this->aWorkFlow->isModified() || $this->aWorkFlow->isNew()) {
                    $affectedRows += $this->aWorkFlow->save($con);
                }
                $this->setWorkFlow($this->aWorkFlow);
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

            if ($this->tokensScheduledForDeletion !== null) {
                if (!$this->tokensScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\TokenQuery::create()
                        ->filterByPrimaryKeys($this->tokensScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->tokensScheduledForDeletion = null;
                }
            }

            if ($this->collTokens !== null) {
                foreach ($this->collTokens as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->triggerFulfillmentsScheduledForDeletion !== null) {
                if (!$this->triggerFulfillmentsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\TriggerFulfillmentQuery::create()
                        ->filterByPrimaryKeys($this->triggerFulfillmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->triggerFulfillmentsScheduledForDeletion = null;
                }
            }

            if ($this->collTriggerFulfillments !== null) {
                foreach ($this->collTriggerFulfillments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->useCasesRelatedByUseCaseIdScheduledForDeletion !== null) {
                if (!$this->useCasesRelatedByUseCaseIdScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\UseCaseQuery::create()
                        ->filterByPrimaryKeys($this->useCasesRelatedByUseCaseIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->useCasesRelatedByUseCaseIdScheduledForDeletion = null;
                }
            }

            if ($this->collUseCasesRelatedByUseCaseId !== null) {
                foreach ($this->collUseCasesRelatedByUseCaseId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->useCaseContextsScheduledForDeletion !== null) {
                if (!$this->useCaseContextsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\UseCaseContextQuery::create()
                        ->filterByPrimaryKeys($this->useCaseContextsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->useCaseContextsScheduledForDeletion = null;
                }
            }

            if ($this->collUseCaseContexts !== null) {
                foreach ($this->collUseCaseContexts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->workItemsScheduledForDeletion !== null) {
                if (!$this->workItemsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\WorkItemQuery::create()
                        ->filterByPrimaryKeys($this->workItemsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->workItemsScheduledForDeletion = null;
                }
            }

            if ($this->collWorkItems !== null) {
                foreach ($this->collWorkItems as $referrerFK) {
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

        $this->modifiedColumns[UseCaseTableMap::COL_USE_CASE_ID] = true;
        if (null !== $this->use_case_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UseCaseTableMap::COL_USE_CASE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UseCaseTableMap::COL_USE_CASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'use_case_id';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_WORK_FLOW_ID)) {
            $modifiedColumns[':p' . $index++]  = 'work_flow_id';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_PARENT_USE_CASE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'parent_use_case_id';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_USE_CASE_GROUP)) {
            $modifiedColumns[':p' . $index++]  = 'use_case_group';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_USE_CASE_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'use_case_status';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_START_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'start_date';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_END_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'end_date';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_MODIFIED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'modified_at';
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'modified_by';
        }

        $sql = sprintf(
            'INSERT INTO PHPWF_use_case (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'use_case_id':
                        $stmt->bindValue($identifier, $this->use_case_id, PDO::PARAM_INT);
                        break;
                    case 'work_flow_id':
                        $stmt->bindValue($identifier, $this->work_flow_id, PDO::PARAM_INT);
                        break;
                    case 'parent_use_case_id':
                        $stmt->bindValue($identifier, $this->parent_use_case_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'use_case_group':
                        $stmt->bindValue($identifier, $this->use_case_group, PDO::PARAM_STR);
                        break;
                    case 'use_case_status':
                        $stmt->bindValue($identifier, $this->use_case_status, PDO::PARAM_STR);
                        break;
                    case 'start_date':
                        $stmt->bindValue($identifier, $this->start_date ? $this->start_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
                        break;
                    case 'end_date':
                        $stmt->bindValue($identifier, $this->end_date ? $this->end_date->format("Y-m-d H:i:s") : null, PDO::PARAM_STR);
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
        $this->setUseCaseId($pk);

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
        $pos = UseCaseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUseCaseId();
                break;
            case 1:
                return $this->getWorkFlowId();
                break;
            case 2:
                return $this->getParentUseCaseId();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getDescription();
                break;
            case 5:
                return $this->getUseCaseGroup();
                break;
            case 6:
                return $this->getUseCaseStatus();
                break;
            case 7:
                return $this->getStartDate();
                break;
            case 8:
                return $this->getEndDate();
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

        if (isset($alreadyDumpedObjects['UseCase'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['UseCase'][$this->hashCode()] = true;
        $keys = UseCaseTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getUseCaseId(),
            $keys[1] => $this->getWorkFlowId(),
            $keys[2] => $this->getParentUseCaseId(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getDescription(),
            $keys[5] => $this->getUseCaseGroup(),
            $keys[6] => $this->getUseCaseStatus(),
            $keys[7] => $this->getStartDate(),
            $keys[8] => $this->getEndDate(),
            $keys[9] => $this->getCreatedAt(),
            $keys[10] => $this->getCreatedBy(),
            $keys[11] => $this->getModifiedAt(),
            $keys[12] => $this->getModifiedBy(),
        );

        $utc = new \DateTimeZone('utc');
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
            if (null !== $this->aUseCaseRelatedByParentUseCaseId) {

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

                $result[$key] = $this->aUseCaseRelatedByParentUseCaseId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aWorkFlow) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'workFlow';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_work_flow';
                        break;
                    default:
                        $key = 'WorkFlow';
                }

                $result[$key] = $this->aWorkFlow->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collTokens) {

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

                $result[$key] = $this->collTokens->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTriggerFulfillments) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'triggerFulfillments';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_trigger_fulfillments';
                        break;
                    default:
                        $key = 'TriggerFulfillments';
                }

                $result[$key] = $this->collTriggerFulfillments->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUseCasesRelatedByUseCaseId) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'useCases';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_use_cases';
                        break;
                    default:
                        $key = 'UseCases';
                }

                $result[$key] = $this->collUseCasesRelatedByUseCaseId->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUseCaseContexts) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'useCaseContexts';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_use_case_contexts';
                        break;
                    default:
                        $key = 'UseCaseContexts';
                }

                $result[$key] = $this->collUseCaseContexts->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWorkItems) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'workItems';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_work_items';
                        break;
                    default:
                        $key = 'WorkItems';
                }

                $result[$key] = $this->collWorkItems->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\PHPWorkFlow\DB\UseCase
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UseCaseTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\PHPWorkFlow\DB\UseCase
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setUseCaseId($value);
                break;
            case 1:
                $this->setWorkFlowId($value);
                break;
            case 2:
                $this->setParentUseCaseId($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setDescription($value);
                break;
            case 5:
                $this->setUseCaseGroup($value);
                break;
            case 6:
                $this->setUseCaseStatus($value);
                break;
            case 7:
                $this->setStartDate($value);
                break;
            case 8:
                $this->setEndDate($value);
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
        $keys = UseCaseTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setUseCaseId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setWorkFlowId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setParentUseCaseId($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setUseCaseGroup($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setUseCaseStatus($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setStartDate($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setEndDate($arr[$keys[8]]);
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
     * @return $this|\PHPWorkFlow\DB\UseCase The current object, for fluid interface
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
        $criteria = new Criteria(UseCaseTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UseCaseTableMap::COL_USE_CASE_ID)) {
            $criteria->add(UseCaseTableMap::COL_USE_CASE_ID, $this->use_case_id);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_WORK_FLOW_ID)) {
            $criteria->add(UseCaseTableMap::COL_WORK_FLOW_ID, $this->work_flow_id);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_PARENT_USE_CASE_ID)) {
            $criteria->add(UseCaseTableMap::COL_PARENT_USE_CASE_ID, $this->parent_use_case_id);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_NAME)) {
            $criteria->add(UseCaseTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_DESCRIPTION)) {
            $criteria->add(UseCaseTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_USE_CASE_GROUP)) {
            $criteria->add(UseCaseTableMap::COL_USE_CASE_GROUP, $this->use_case_group);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_USE_CASE_STATUS)) {
            $criteria->add(UseCaseTableMap::COL_USE_CASE_STATUS, $this->use_case_status);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_START_DATE)) {
            $criteria->add(UseCaseTableMap::COL_START_DATE, $this->start_date);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_END_DATE)) {
            $criteria->add(UseCaseTableMap::COL_END_DATE, $this->end_date);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_CREATED_AT)) {
            $criteria->add(UseCaseTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_CREATED_BY)) {
            $criteria->add(UseCaseTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_MODIFIED_AT)) {
            $criteria->add(UseCaseTableMap::COL_MODIFIED_AT, $this->modified_at);
        }
        if ($this->isColumnModified(UseCaseTableMap::COL_MODIFIED_BY)) {
            $criteria->add(UseCaseTableMap::COL_MODIFIED_BY, $this->modified_by);
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
        $criteria = ChildUseCaseQuery::create();
        $criteria->add(UseCaseTableMap::COL_USE_CASE_ID, $this->use_case_id);

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
        $validPk = null !== $this->getUseCaseId();

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
        return $this->getUseCaseId();
    }

    /**
     * Generic method to set the primary key (use_case_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setUseCaseId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getUseCaseId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \PHPWorkFlow\DB\UseCase (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setWorkFlowId($this->getWorkFlowId());
        $copyObj->setParentUseCaseId($this->getParentUseCaseId());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setUseCaseGroup($this->getUseCaseGroup());
        $copyObj->setUseCaseStatus($this->getUseCaseStatus());
        $copyObj->setStartDate($this->getStartDate());
        $copyObj->setEndDate($this->getEndDate());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setModifiedAt($this->getModifiedAt());
        $copyObj->setModifiedBy($this->getModifiedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getTokens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addToken($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTriggerFulfillments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTriggerFulfillment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUseCasesRelatedByUseCaseId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUseCaseRelatedByUseCaseId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUseCaseContexts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUseCaseContext($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWorkItems() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWorkItem($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setUseCaseId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \PHPWorkFlow\DB\UseCase Clone of current object.
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
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUseCaseRelatedByParentUseCaseId(ChildUseCase $v = null)
    {
        if ($v === null) {
            $this->setParentUseCaseId(NULL);
        } else {
            $this->setParentUseCaseId($v->getUseCaseId());
        }

        $this->aUseCaseRelatedByParentUseCaseId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUseCase object, it will not be re-added.
        if ($v !== null) {
            $v->addUseCaseRelatedByUseCaseId($this);
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
    public function getUseCaseRelatedByParentUseCaseId(ConnectionInterface $con = null)
    {
        if ($this->aUseCaseRelatedByParentUseCaseId === null && ($this->parent_use_case_id !== null)) {
            $this->aUseCaseRelatedByParentUseCaseId = ChildUseCaseQuery::create()->findPk($this->parent_use_case_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUseCaseRelatedByParentUseCaseId->addUseCasesRelatedByUseCaseId($this);
             */
        }

        return $this->aUseCaseRelatedByParentUseCaseId;
    }

    /**
     * Declares an association between this object and a ChildWorkFlow object.
     *
     * @param  ChildWorkFlow $v
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     * @throws PropelException
     */
    public function setWorkFlow(ChildWorkFlow $v = null)
    {
        if ($v === null) {
            $this->setWorkFlowId(NULL);
        } else {
            $this->setWorkFlowId($v->getWorkFlowId());
        }

        $this->aWorkFlow = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildWorkFlow object, it will not be re-added.
        if ($v !== null) {
            $v->addUseCase($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildWorkFlow object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildWorkFlow The associated ChildWorkFlow object.
     * @throws PropelException
     */
    public function getWorkFlow(ConnectionInterface $con = null)
    {
        if ($this->aWorkFlow === null && ($this->work_flow_id !== null)) {
            $this->aWorkFlow = ChildWorkFlowQuery::create()->findPk($this->work_flow_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aWorkFlow->addUseCases($this);
             */
        }

        return $this->aWorkFlow;
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
        if ('Token' == $relationName) {
            return $this->initTokens();
        }
        if ('TriggerFulfillment' == $relationName) {
            return $this->initTriggerFulfillments();
        }
        if ('UseCaseRelatedByUseCaseId' == $relationName) {
            return $this->initUseCasesRelatedByUseCaseId();
        }
        if ('UseCaseContext' == $relationName) {
            return $this->initUseCaseContexts();
        }
        if ('WorkItem' == $relationName) {
            return $this->initWorkItems();
        }
    }

    /**
     * Clears out the collTokens collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTokens()
     */
    public function clearTokens()
    {
        $this->collTokens = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTokens collection loaded partially.
     */
    public function resetPartialTokens($v = true)
    {
        $this->collTokensPartial = $v;
    }

    /**
     * Initializes the collTokens collection.
     *
     * By default this just sets the collTokens collection to an empty array (like clearcollTokens());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTokens($overrideExisting = true)
    {
        if (null !== $this->collTokens && !$overrideExisting) {
            return;
        }
        $this->collTokens = new ObjectCollection();
        $this->collTokens->setModel('\PHPWorkFlow\DB\Token');
    }

    /**
     * Gets an array of ChildToken objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUseCase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     * @throws PropelException
     */
    public function getTokens(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTokensPartial && !$this->isNew();
        if (null === $this->collTokens || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTokens) {
                // return empty collection
                $this->initTokens();
            } else {
                $collTokens = ChildTokenQuery::create(null, $criteria)
                    ->filterByUseCase($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTokensPartial && count($collTokens)) {
                        $this->initTokens(false);

                        foreach ($collTokens as $obj) {
                            if (false == $this->collTokens->contains($obj)) {
                                $this->collTokens->append($obj);
                            }
                        }

                        $this->collTokensPartial = true;
                    }

                    return $collTokens;
                }

                if ($partial && $this->collTokens) {
                    foreach ($this->collTokens as $obj) {
                        if ($obj->isNew()) {
                            $collTokens[] = $obj;
                        }
                    }
                }

                $this->collTokens = $collTokens;
                $this->collTokensPartial = false;
            }
        }

        return $this->collTokens;
    }

    /**
     * Sets a collection of ChildToken objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $tokens A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function setTokens(Collection $tokens, ConnectionInterface $con = null)
    {
        /** @var ChildToken[] $tokensToDelete */
        $tokensToDelete = $this->getTokens(new Criteria(), $con)->diff($tokens);


        $this->tokensScheduledForDeletion = $tokensToDelete;

        foreach ($tokensToDelete as $tokenRemoved) {
            $tokenRemoved->setUseCase(null);
        }

        $this->collTokens = null;
        foreach ($tokens as $token) {
            $this->addToken($token);
        }

        $this->collTokens = $tokens;
        $this->collTokensPartial = false;

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
    public function countTokens(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTokensPartial && !$this->isNew();
        if (null === $this->collTokens || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTokens) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTokens());
            }

            $query = ChildTokenQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUseCase($this)
                ->count($con);
        }

        return count($this->collTokens);
    }

    /**
     * Method called to associate a ChildToken object to this object
     * through the ChildToken foreign key attribute.
     *
     * @param  ChildToken $l ChildToken
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function addToken(ChildToken $l)
    {
        if ($this->collTokens === null) {
            $this->initTokens();
            $this->collTokensPartial = true;
        }

        if (!$this->collTokens->contains($l)) {
            $this->doAddToken($l);
        }

        return $this;
    }

    /**
     * @param ChildToken $token The ChildToken object to add.
     */
    protected function doAddToken(ChildToken $token)
    {
        $this->collTokens[]= $token;
        $token->setUseCase($this);
    }

    /**
     * @param  ChildToken $token The ChildToken object to remove.
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function removeToken(ChildToken $token)
    {
        if ($this->getTokens()->contains($token)) {
            $pos = $this->collTokens->search($token);
            $this->collTokens->remove($pos);
            if (null === $this->tokensScheduledForDeletion) {
                $this->tokensScheduledForDeletion = clone $this->collTokens;
                $this->tokensScheduledForDeletion->clear();
            }
            $this->tokensScheduledForDeletion[]= clone $token;
            $token->setUseCase(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related Tokens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getTokensJoinCreatingWorkItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('CreatingWorkItem', $joinBehavior);

        return $this->getTokens($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related Tokens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getTokensJoinConsumingWorkItem(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('ConsumingWorkItem', $joinBehavior);

        return $this->getTokens($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related Tokens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getTokensJoinPlace(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('Place', $joinBehavior);

        return $this->getTokens($query, $con);
    }

    /**
     * Clears out the collTriggerFulfillments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTriggerFulfillments()
     */
    public function clearTriggerFulfillments()
    {
        $this->collTriggerFulfillments = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTriggerFulfillments collection loaded partially.
     */
    public function resetPartialTriggerFulfillments($v = true)
    {
        $this->collTriggerFulfillmentsPartial = $v;
    }

    /**
     * Initializes the collTriggerFulfillments collection.
     *
     * By default this just sets the collTriggerFulfillments collection to an empty array (like clearcollTriggerFulfillments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTriggerFulfillments($overrideExisting = true)
    {
        if (null !== $this->collTriggerFulfillments && !$overrideExisting) {
            return;
        }
        $this->collTriggerFulfillments = new ObjectCollection();
        $this->collTriggerFulfillments->setModel('\PHPWorkFlow\DB\TriggerFulfillment');
    }

    /**
     * Gets an array of ChildTriggerFulfillment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUseCase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTriggerFulfillment[] List of ChildTriggerFulfillment objects
     * @throws PropelException
     */
    public function getTriggerFulfillments(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggerFulfillmentsPartial && !$this->isNew();
        if (null === $this->collTriggerFulfillments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTriggerFulfillments) {
                // return empty collection
                $this->initTriggerFulfillments();
            } else {
                $collTriggerFulfillments = ChildTriggerFulfillmentQuery::create(null, $criteria)
                    ->filterByUseCase($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTriggerFulfillmentsPartial && count($collTriggerFulfillments)) {
                        $this->initTriggerFulfillments(false);

                        foreach ($collTriggerFulfillments as $obj) {
                            if (false == $this->collTriggerFulfillments->contains($obj)) {
                                $this->collTriggerFulfillments->append($obj);
                            }
                        }

                        $this->collTriggerFulfillmentsPartial = true;
                    }

                    return $collTriggerFulfillments;
                }

                if ($partial && $this->collTriggerFulfillments) {
                    foreach ($this->collTriggerFulfillments as $obj) {
                        if ($obj->isNew()) {
                            $collTriggerFulfillments[] = $obj;
                        }
                    }
                }

                $this->collTriggerFulfillments = $collTriggerFulfillments;
                $this->collTriggerFulfillmentsPartial = false;
            }
        }

        return $this->collTriggerFulfillments;
    }

    /**
     * Sets a collection of ChildTriggerFulfillment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $triggerFulfillments A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function setTriggerFulfillments(Collection $triggerFulfillments, ConnectionInterface $con = null)
    {
        /** @var ChildTriggerFulfillment[] $triggerFulfillmentsToDelete */
        $triggerFulfillmentsToDelete = $this->getTriggerFulfillments(new Criteria(), $con)->diff($triggerFulfillments);


        $this->triggerFulfillmentsScheduledForDeletion = $triggerFulfillmentsToDelete;

        foreach ($triggerFulfillmentsToDelete as $triggerFulfillmentRemoved) {
            $triggerFulfillmentRemoved->setUseCase(null);
        }

        $this->collTriggerFulfillments = null;
        foreach ($triggerFulfillments as $triggerFulfillment) {
            $this->addTriggerFulfillment($triggerFulfillment);
        }

        $this->collTriggerFulfillments = $triggerFulfillments;
        $this->collTriggerFulfillmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related TriggerFulfillment objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related TriggerFulfillment objects.
     * @throws PropelException
     */
    public function countTriggerFulfillments(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTriggerFulfillmentsPartial && !$this->isNew();
        if (null === $this->collTriggerFulfillments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTriggerFulfillments) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTriggerFulfillments());
            }

            $query = ChildTriggerFulfillmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUseCase($this)
                ->count($con);
        }

        return count($this->collTriggerFulfillments);
    }

    /**
     * Method called to associate a ChildTriggerFulfillment object to this object
     * through the ChildTriggerFulfillment foreign key attribute.
     *
     * @param  ChildTriggerFulfillment $l ChildTriggerFulfillment
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function addTriggerFulfillment(ChildTriggerFulfillment $l)
    {
        if ($this->collTriggerFulfillments === null) {
            $this->initTriggerFulfillments();
            $this->collTriggerFulfillmentsPartial = true;
        }

        if (!$this->collTriggerFulfillments->contains($l)) {
            $this->doAddTriggerFulfillment($l);
        }

        return $this;
    }

    /**
     * @param ChildTriggerFulfillment $triggerFulfillment The ChildTriggerFulfillment object to add.
     */
    protected function doAddTriggerFulfillment(ChildTriggerFulfillment $triggerFulfillment)
    {
        $this->collTriggerFulfillments[]= $triggerFulfillment;
        $triggerFulfillment->setUseCase($this);
    }

    /**
     * @param  ChildTriggerFulfillment $triggerFulfillment The ChildTriggerFulfillment object to remove.
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function removeTriggerFulfillment(ChildTriggerFulfillment $triggerFulfillment)
    {
        if ($this->getTriggerFulfillments()->contains($triggerFulfillment)) {
            $pos = $this->collTriggerFulfillments->search($triggerFulfillment);
            $this->collTriggerFulfillments->remove($pos);
            if (null === $this->triggerFulfillmentsScheduledForDeletion) {
                $this->triggerFulfillmentsScheduledForDeletion = clone $this->collTriggerFulfillments;
                $this->triggerFulfillmentsScheduledForDeletion->clear();
            }
            $this->triggerFulfillmentsScheduledForDeletion[]= clone $triggerFulfillment;
            $triggerFulfillment->setUseCase(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related TriggerFulfillments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildTriggerFulfillment[] List of ChildTriggerFulfillment objects
     */
    public function getTriggerFulfillmentsJoinTransition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTriggerFulfillmentQuery::create(null, $criteria);
        $query->joinWith('Transition', $joinBehavior);

        return $this->getTriggerFulfillments($query, $con);
    }

    /**
     * Clears out the collUseCasesRelatedByUseCaseId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUseCasesRelatedByUseCaseId()
     */
    public function clearUseCasesRelatedByUseCaseId()
    {
        $this->collUseCasesRelatedByUseCaseId = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUseCasesRelatedByUseCaseId collection loaded partially.
     */
    public function resetPartialUseCasesRelatedByUseCaseId($v = true)
    {
        $this->collUseCasesRelatedByUseCaseIdPartial = $v;
    }

    /**
     * Initializes the collUseCasesRelatedByUseCaseId collection.
     *
     * By default this just sets the collUseCasesRelatedByUseCaseId collection to an empty array (like clearcollUseCasesRelatedByUseCaseId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUseCasesRelatedByUseCaseId($overrideExisting = true)
    {
        if (null !== $this->collUseCasesRelatedByUseCaseId && !$overrideExisting) {
            return;
        }
        $this->collUseCasesRelatedByUseCaseId = new ObjectCollection();
        $this->collUseCasesRelatedByUseCaseId->setModel('\PHPWorkFlow\DB\UseCase');
    }

    /**
     * Gets an array of ChildUseCase objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUseCase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUseCase[] List of ChildUseCase objects
     * @throws PropelException
     */
    public function getUseCasesRelatedByUseCaseId(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUseCasesRelatedByUseCaseIdPartial && !$this->isNew();
        if (null === $this->collUseCasesRelatedByUseCaseId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUseCasesRelatedByUseCaseId) {
                // return empty collection
                $this->initUseCasesRelatedByUseCaseId();
            } else {
                $collUseCasesRelatedByUseCaseId = ChildUseCaseQuery::create(null, $criteria)
                    ->filterByUseCaseRelatedByParentUseCaseId($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUseCasesRelatedByUseCaseIdPartial && count($collUseCasesRelatedByUseCaseId)) {
                        $this->initUseCasesRelatedByUseCaseId(false);

                        foreach ($collUseCasesRelatedByUseCaseId as $obj) {
                            if (false == $this->collUseCasesRelatedByUseCaseId->contains($obj)) {
                                $this->collUseCasesRelatedByUseCaseId->append($obj);
                            }
                        }

                        $this->collUseCasesRelatedByUseCaseIdPartial = true;
                    }

                    return $collUseCasesRelatedByUseCaseId;
                }

                if ($partial && $this->collUseCasesRelatedByUseCaseId) {
                    foreach ($this->collUseCasesRelatedByUseCaseId as $obj) {
                        if ($obj->isNew()) {
                            $collUseCasesRelatedByUseCaseId[] = $obj;
                        }
                    }
                }

                $this->collUseCasesRelatedByUseCaseId = $collUseCasesRelatedByUseCaseId;
                $this->collUseCasesRelatedByUseCaseIdPartial = false;
            }
        }

        return $this->collUseCasesRelatedByUseCaseId;
    }

    /**
     * Sets a collection of ChildUseCase objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $useCasesRelatedByUseCaseId A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function setUseCasesRelatedByUseCaseId(Collection $useCasesRelatedByUseCaseId, ConnectionInterface $con = null)
    {
        /** @var ChildUseCase[] $useCasesRelatedByUseCaseIdToDelete */
        $useCasesRelatedByUseCaseIdToDelete = $this->getUseCasesRelatedByUseCaseId(new Criteria(), $con)->diff($useCasesRelatedByUseCaseId);


        $this->useCasesRelatedByUseCaseIdScheduledForDeletion = $useCasesRelatedByUseCaseIdToDelete;

        foreach ($useCasesRelatedByUseCaseIdToDelete as $useCaseRelatedByUseCaseIdRemoved) {
            $useCaseRelatedByUseCaseIdRemoved->setUseCaseRelatedByParentUseCaseId(null);
        }

        $this->collUseCasesRelatedByUseCaseId = null;
        foreach ($useCasesRelatedByUseCaseId as $useCaseRelatedByUseCaseId) {
            $this->addUseCaseRelatedByUseCaseId($useCaseRelatedByUseCaseId);
        }

        $this->collUseCasesRelatedByUseCaseId = $useCasesRelatedByUseCaseId;
        $this->collUseCasesRelatedByUseCaseIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UseCase objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UseCase objects.
     * @throws PropelException
     */
    public function countUseCasesRelatedByUseCaseId(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUseCasesRelatedByUseCaseIdPartial && !$this->isNew();
        if (null === $this->collUseCasesRelatedByUseCaseId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUseCasesRelatedByUseCaseId) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUseCasesRelatedByUseCaseId());
            }

            $query = ChildUseCaseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUseCaseRelatedByParentUseCaseId($this)
                ->count($con);
        }

        return count($this->collUseCasesRelatedByUseCaseId);
    }

    /**
     * Method called to associate a ChildUseCase object to this object
     * through the ChildUseCase foreign key attribute.
     *
     * @param  ChildUseCase $l ChildUseCase
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function addUseCaseRelatedByUseCaseId(ChildUseCase $l)
    {
        if ($this->collUseCasesRelatedByUseCaseId === null) {
            $this->initUseCasesRelatedByUseCaseId();
            $this->collUseCasesRelatedByUseCaseIdPartial = true;
        }

        if (!$this->collUseCasesRelatedByUseCaseId->contains($l)) {
            $this->doAddUseCaseRelatedByUseCaseId($l);
        }

        return $this;
    }

    /**
     * @param ChildUseCase $useCaseRelatedByUseCaseId The ChildUseCase object to add.
     */
    protected function doAddUseCaseRelatedByUseCaseId(ChildUseCase $useCaseRelatedByUseCaseId)
    {
        $this->collUseCasesRelatedByUseCaseId[]= $useCaseRelatedByUseCaseId;
        $useCaseRelatedByUseCaseId->setUseCaseRelatedByParentUseCaseId($this);
    }

    /**
     * @param  ChildUseCase $useCaseRelatedByUseCaseId The ChildUseCase object to remove.
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function removeUseCaseRelatedByUseCaseId(ChildUseCase $useCaseRelatedByUseCaseId)
    {
        if ($this->getUseCasesRelatedByUseCaseId()->contains($useCaseRelatedByUseCaseId)) {
            $pos = $this->collUseCasesRelatedByUseCaseId->search($useCaseRelatedByUseCaseId);
            $this->collUseCasesRelatedByUseCaseId->remove($pos);
            if (null === $this->useCasesRelatedByUseCaseIdScheduledForDeletion) {
                $this->useCasesRelatedByUseCaseIdScheduledForDeletion = clone $this->collUseCasesRelatedByUseCaseId;
                $this->useCasesRelatedByUseCaseIdScheduledForDeletion->clear();
            }
            $this->useCasesRelatedByUseCaseIdScheduledForDeletion[]= $useCaseRelatedByUseCaseId;
            $useCaseRelatedByUseCaseId->setUseCaseRelatedByParentUseCaseId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related UseCasesRelatedByUseCaseId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUseCase[] List of ChildUseCase objects
     */
    public function getUseCasesRelatedByUseCaseIdJoinWorkFlow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUseCaseQuery::create(null, $criteria);
        $query->joinWith('WorkFlow', $joinBehavior);

        return $this->getUseCasesRelatedByUseCaseId($query, $con);
    }

    /**
     * Clears out the collUseCaseContexts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUseCaseContexts()
     */
    public function clearUseCaseContexts()
    {
        $this->collUseCaseContexts = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUseCaseContexts collection loaded partially.
     */
    public function resetPartialUseCaseContexts($v = true)
    {
        $this->collUseCaseContextsPartial = $v;
    }

    /**
     * Initializes the collUseCaseContexts collection.
     *
     * By default this just sets the collUseCaseContexts collection to an empty array (like clearcollUseCaseContexts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUseCaseContexts($overrideExisting = true)
    {
        if (null !== $this->collUseCaseContexts && !$overrideExisting) {
            return;
        }
        $this->collUseCaseContexts = new ObjectCollection();
        $this->collUseCaseContexts->setModel('\PHPWorkFlow\DB\UseCaseContext');
    }

    /**
     * Gets an array of ChildUseCaseContext objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUseCase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUseCaseContext[] List of ChildUseCaseContext objects
     * @throws PropelException
     */
    public function getUseCaseContexts(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUseCaseContextsPartial && !$this->isNew();
        if (null === $this->collUseCaseContexts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUseCaseContexts) {
                // return empty collection
                $this->initUseCaseContexts();
            } else {
                $collUseCaseContexts = ChildUseCaseContextQuery::create(null, $criteria)
                    ->filterByUseCase($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUseCaseContextsPartial && count($collUseCaseContexts)) {
                        $this->initUseCaseContexts(false);

                        foreach ($collUseCaseContexts as $obj) {
                            if (false == $this->collUseCaseContexts->contains($obj)) {
                                $this->collUseCaseContexts->append($obj);
                            }
                        }

                        $this->collUseCaseContextsPartial = true;
                    }

                    return $collUseCaseContexts;
                }

                if ($partial && $this->collUseCaseContexts) {
                    foreach ($this->collUseCaseContexts as $obj) {
                        if ($obj->isNew()) {
                            $collUseCaseContexts[] = $obj;
                        }
                    }
                }

                $this->collUseCaseContexts = $collUseCaseContexts;
                $this->collUseCaseContextsPartial = false;
            }
        }

        return $this->collUseCaseContexts;
    }

    /**
     * Sets a collection of ChildUseCaseContext objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $useCaseContexts A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function setUseCaseContexts(Collection $useCaseContexts, ConnectionInterface $con = null)
    {
        /** @var ChildUseCaseContext[] $useCaseContextsToDelete */
        $useCaseContextsToDelete = $this->getUseCaseContexts(new Criteria(), $con)->diff($useCaseContexts);


        $this->useCaseContextsScheduledForDeletion = $useCaseContextsToDelete;

        foreach ($useCaseContextsToDelete as $useCaseContextRemoved) {
            $useCaseContextRemoved->setUseCase(null);
        }

        $this->collUseCaseContexts = null;
        foreach ($useCaseContexts as $useCaseContext) {
            $this->addUseCaseContext($useCaseContext);
        }

        $this->collUseCaseContexts = $useCaseContexts;
        $this->collUseCaseContextsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related UseCaseContext objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related UseCaseContext objects.
     * @throws PropelException
     */
    public function countUseCaseContexts(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUseCaseContextsPartial && !$this->isNew();
        if (null === $this->collUseCaseContexts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUseCaseContexts) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUseCaseContexts());
            }

            $query = ChildUseCaseContextQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUseCase($this)
                ->count($con);
        }

        return count($this->collUseCaseContexts);
    }

    /**
     * Method called to associate a ChildUseCaseContext object to this object
     * through the ChildUseCaseContext foreign key attribute.
     *
     * @param  ChildUseCaseContext $l ChildUseCaseContext
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function addUseCaseContext(ChildUseCaseContext $l)
    {
        if ($this->collUseCaseContexts === null) {
            $this->initUseCaseContexts();
            $this->collUseCaseContextsPartial = true;
        }

        if (!$this->collUseCaseContexts->contains($l)) {
            $this->doAddUseCaseContext($l);
        }

        return $this;
    }

    /**
     * @param ChildUseCaseContext $useCaseContext The ChildUseCaseContext object to add.
     */
    protected function doAddUseCaseContext(ChildUseCaseContext $useCaseContext)
    {
        $this->collUseCaseContexts[]= $useCaseContext;
        $useCaseContext->setUseCase($this);
    }

    /**
     * @param  ChildUseCaseContext $useCaseContext The ChildUseCaseContext object to remove.
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function removeUseCaseContext(ChildUseCaseContext $useCaseContext)
    {
        if ($this->getUseCaseContexts()->contains($useCaseContext)) {
            $pos = $this->collUseCaseContexts->search($useCaseContext);
            $this->collUseCaseContexts->remove($pos);
            if (null === $this->useCaseContextsScheduledForDeletion) {
                $this->useCaseContextsScheduledForDeletion = clone $this->collUseCaseContexts;
                $this->useCaseContextsScheduledForDeletion->clear();
            }
            $this->useCaseContextsScheduledForDeletion[]= clone $useCaseContext;
            $useCaseContext->setUseCase(null);
        }

        return $this;
    }

    /**
     * Clears out the collWorkItems collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addWorkItems()
     */
    public function clearWorkItems()
    {
        $this->collWorkItems = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collWorkItems collection loaded partially.
     */
    public function resetPartialWorkItems($v = true)
    {
        $this->collWorkItemsPartial = $v;
    }

    /**
     * Initializes the collWorkItems collection.
     *
     * By default this just sets the collWorkItems collection to an empty array (like clearcollWorkItems());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWorkItems($overrideExisting = true)
    {
        if (null !== $this->collWorkItems && !$overrideExisting) {
            return;
        }
        $this->collWorkItems = new ObjectCollection();
        $this->collWorkItems->setModel('\PHPWorkFlow\DB\WorkItem');
    }

    /**
     * Gets an array of ChildWorkItem objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUseCase is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildWorkItem[] List of ChildWorkItem objects
     * @throws PropelException
     */
    public function getWorkItems(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collWorkItemsPartial && !$this->isNew();
        if (null === $this->collWorkItems || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWorkItems) {
                // return empty collection
                $this->initWorkItems();
            } else {
                $collWorkItems = ChildWorkItemQuery::create(null, $criteria)
                    ->filterByUseCase($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collWorkItemsPartial && count($collWorkItems)) {
                        $this->initWorkItems(false);

                        foreach ($collWorkItems as $obj) {
                            if (false == $this->collWorkItems->contains($obj)) {
                                $this->collWorkItems->append($obj);
                            }
                        }

                        $this->collWorkItemsPartial = true;
                    }

                    return $collWorkItems;
                }

                if ($partial && $this->collWorkItems) {
                    foreach ($this->collWorkItems as $obj) {
                        if ($obj->isNew()) {
                            $collWorkItems[] = $obj;
                        }
                    }
                }

                $this->collWorkItems = $collWorkItems;
                $this->collWorkItemsPartial = false;
            }
        }

        return $this->collWorkItems;
    }

    /**
     * Sets a collection of ChildWorkItem objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $workItems A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function setWorkItems(Collection $workItems, ConnectionInterface $con = null)
    {
        /** @var ChildWorkItem[] $workItemsToDelete */
        $workItemsToDelete = $this->getWorkItems(new Criteria(), $con)->diff($workItems);


        $this->workItemsScheduledForDeletion = $workItemsToDelete;

        foreach ($workItemsToDelete as $workItemRemoved) {
            $workItemRemoved->setUseCase(null);
        }

        $this->collWorkItems = null;
        foreach ($workItems as $workItem) {
            $this->addWorkItem($workItem);
        }

        $this->collWorkItems = $workItems;
        $this->collWorkItemsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WorkItem objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related WorkItem objects.
     * @throws PropelException
     */
    public function countWorkItems(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collWorkItemsPartial && !$this->isNew();
        if (null === $this->collWorkItems || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWorkItems) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getWorkItems());
            }

            $query = ChildWorkItemQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUseCase($this)
                ->count($con);
        }

        return count($this->collWorkItems);
    }

    /**
     * Method called to associate a ChildWorkItem object to this object
     * through the ChildWorkItem foreign key attribute.
     *
     * @param  ChildWorkItem $l ChildWorkItem
     * @return $this|\PHPWorkFlow\DB\UseCase The current object (for fluent API support)
     */
    public function addWorkItem(ChildWorkItem $l)
    {
        if ($this->collWorkItems === null) {
            $this->initWorkItems();
            $this->collWorkItemsPartial = true;
        }

        if (!$this->collWorkItems->contains($l)) {
            $this->doAddWorkItem($l);
        }

        return $this;
    }

    /**
     * @param ChildWorkItem $workItem The ChildWorkItem object to add.
     */
    protected function doAddWorkItem(ChildWorkItem $workItem)
    {
        $this->collWorkItems[]= $workItem;
        $workItem->setUseCase($this);
    }

    /**
     * @param  ChildWorkItem $workItem The ChildWorkItem object to remove.
     * @return $this|ChildUseCase The current object (for fluent API support)
     */
    public function removeWorkItem(ChildWorkItem $workItem)
    {
        if ($this->getWorkItems()->contains($workItem)) {
            $pos = $this->collWorkItems->search($workItem);
            $this->collWorkItems->remove($pos);
            if (null === $this->workItemsScheduledForDeletion) {
                $this->workItemsScheduledForDeletion = clone $this->collWorkItems;
                $this->workItemsScheduledForDeletion->clear();
            }
            $this->workItemsScheduledForDeletion[]= clone $workItem;
            $workItem->setUseCase(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related WorkItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWorkItem[] List of ChildWorkItem objects
     */
    public function getWorkItemsJoinTransition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWorkItemQuery::create(null, $criteria);
        $query->joinWith('Transition', $joinBehavior);

        return $this->getWorkItems($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this UseCase is new, it will return
     * an empty collection; or if this UseCase has previously
     * been saved, it will retrieve related WorkItems from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in UseCase.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildWorkItem[] List of ChildWorkItem objects
     */
    public function getWorkItemsJoinArc(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildWorkItemQuery::create(null, $criteria);
        $query->joinWith('Arc', $joinBehavior);

        return $this->getWorkItems($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUseCaseRelatedByParentUseCaseId) {
            $this->aUseCaseRelatedByParentUseCaseId->removeUseCaseRelatedByUseCaseId($this);
        }
        if (null !== $this->aWorkFlow) {
            $this->aWorkFlow->removeUseCase($this);
        }
        $this->use_case_id = null;
        $this->work_flow_id = null;
        $this->parent_use_case_id = null;
        $this->name = null;
        $this->description = null;
        $this->use_case_group = null;
        $this->use_case_status = null;
        $this->start_date = null;
        $this->end_date = null;
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
            if ($this->collTokens) {
                foreach ($this->collTokens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTriggerFulfillments) {
                foreach ($this->collTriggerFulfillments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUseCasesRelatedByUseCaseId) {
                foreach ($this->collUseCasesRelatedByUseCaseId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUseCaseContexts) {
                foreach ($this->collUseCaseContexts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWorkItems) {
                foreach ($this->collWorkItems as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collTokens = null;
        $this->collTriggerFulfillments = null;
        $this->collUseCasesRelatedByUseCaseId = null;
        $this->collUseCaseContexts = null;
        $this->collWorkItems = null;
        $this->aUseCaseRelatedByParentUseCaseId = null;
        $this->aWorkFlow = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UseCaseTableMap::DEFAULT_STRING_FORMAT);
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
