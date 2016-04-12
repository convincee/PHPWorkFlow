<?php

namespace PHPWorkFlow\DB\Base;

use \DateTime;
use \Exception;
use \PDO;
use PHPWorkFlow\DB\Arc as ChildArc;
use PHPWorkFlow\DB\ArcQuery as ChildArcQuery;
use PHPWorkFlow\DB\Place as ChildPlace;
use PHPWorkFlow\DB\PlaceQuery as ChildPlaceQuery;
use PHPWorkFlow\DB\Transition as ChildTransition;
use PHPWorkFlow\DB\TransitionQuery as ChildTransitionQuery;
use PHPWorkFlow\DB\UseCase as ChildUseCase;
use PHPWorkFlow\DB\UseCaseQuery as ChildUseCaseQuery;
use PHPWorkFlow\DB\WorkFlow as ChildWorkFlow;
use PHPWorkFlow\DB\WorkFlowQuery as ChildWorkFlowQuery;
use PHPWorkFlow\DB\Map\WorkFlowTableMap;
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
 * Base class that represents a row from the 'PHPWF_work_flow' table.
 *
 *
 *
* @package    propel.generator.PHPWorkFlow.DB.Base
*/
abstract class WorkFlow implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PHPWorkFlow\\DB\\Map\\WorkFlowTableMap';


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
     * The value for the work_flow_id field.
     *
     * @var        int
     */
    protected $work_flow_id;

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
     * The value for the trigger_class field.
     *
     * @var        string
     */
    protected $trigger_class;

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
     * @var        ObjectCollection|ChildArc[] Collection to store aggregation of ChildArc objects.
     */
    protected $collArcs;
    protected $collArcsPartial;

    /**
     * @var        ObjectCollection|ChildPlace[] Collection to store aggregation of ChildPlace objects.
     */
    protected $collPlaces;
    protected $collPlacesPartial;

    /**
     * @var        ObjectCollection|ChildTransition[] Collection to store aggregation of ChildTransition objects.
     */
    protected $collTransitions;
    protected $collTransitionsPartial;

    /**
     * @var        ObjectCollection|ChildUseCase[] Collection to store aggregation of ChildUseCase objects.
     */
    protected $collUseCases;
    protected $collUseCasesPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildArc[]
     */
    protected $arcsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPlace[]
     */
    protected $placesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildTransition[]
     */
    protected $transitionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildUseCase[]
     */
    protected $useCasesScheduledForDeletion = null;

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
     * Initializes internal state of PHPWorkFlow\DB\Base\WorkFlow object.
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
     * Compares this with another <code>WorkFlow</code> instance.  If
     * <code>obj</code> is an instance of <code>WorkFlow</code>, delegates to
     * <code>equals(WorkFlow)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|WorkFlow The current object, for fluid interface
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
     * Get the [work_flow_id] column value.
     *
     * @return int
     */
    public function getWorkFlowId()
    {
        return $this->work_flow_id;
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
     * Get the [trigger_class] column value.
     *
     * @return string
     */
    public function getTriggerClass()
    {
        return $this->trigger_class;
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
     * Set the value of [work_flow_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setWorkFlowId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->work_flow_id !== $v) {
            $this->work_flow_id = $v;
            $this->modifiedColumns[WorkFlowTableMap::COL_WORK_FLOW_ID] = true;
        }

        return $this;
    } // setWorkFlowId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[WorkFlowTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[WorkFlowTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [trigger_class] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setTriggerClass($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->trigger_class !== $v) {
            $this->trigger_class = $v;
            $this->modifiedColumns[WorkFlowTableMap::COL_TRIGGER_CLASS] = true;
        }

        return $this;
    } // setTriggerClass()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkFlowTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[WorkFlowTableMap::COL_CREATED_BY] = true;
        }

        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [modified_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setModifiedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_at !== null || $dt !== null) {
            if ($this->modified_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->modified_at->format("Y-m-d H:i:s")) {
                $this->modified_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[WorkFlowTableMap::COL_MODIFIED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setModifiedAt()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[WorkFlowTableMap::COL_MODIFIED_BY] = true;
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : WorkFlowTableMap::translateFieldName('WorkFlowId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->work_flow_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : WorkFlowTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : WorkFlowTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : WorkFlowTableMap::translateFieldName('TriggerClass', TableMap::TYPE_PHPNAME, $indexType)];
            $this->trigger_class = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : WorkFlowTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : WorkFlowTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : WorkFlowTableMap::translateFieldName('ModifiedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : WorkFlowTableMap::translateFieldName('ModifiedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modified_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = WorkFlowTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\PHPWorkFlow\\DB\\WorkFlow'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(WorkFlowTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildWorkFlowQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collArcs = null;

            $this->collPlaces = null;

            $this->collTransitions = null;

            $this->collUseCases = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see WorkFlow::setDeleted()
     * @see WorkFlow::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(WorkFlowTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildWorkFlowQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(WorkFlowTableMap::DATABASE_NAME);
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
                WorkFlowTableMap::addInstanceToPool($this);
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

            if ($this->arcsScheduledForDeletion !== null) {
                if (!$this->arcsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\ArcQuery::create()
                        ->filterByPrimaryKeys($this->arcsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->arcsScheduledForDeletion = null;
                }
            }

            if ($this->collArcs !== null) {
                foreach ($this->collArcs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->placesScheduledForDeletion !== null) {
                if (!$this->placesScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\PlaceQuery::create()
                        ->filterByPrimaryKeys($this->placesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->placesScheduledForDeletion = null;
                }
            }

            if ($this->collPlaces !== null) {
                foreach ($this->collPlaces as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->transitionsScheduledForDeletion !== null) {
                if (!$this->transitionsScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\TransitionQuery::create()
                        ->filterByPrimaryKeys($this->transitionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->transitionsScheduledForDeletion = null;
                }
            }

            if ($this->collTransitions !== null) {
                foreach ($this->collTransitions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->useCasesScheduledForDeletion !== null) {
                if (!$this->useCasesScheduledForDeletion->isEmpty()) {
                    \PHPWorkFlow\DB\UseCaseQuery::create()
                        ->filterByPrimaryKeys($this->useCasesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->useCasesScheduledForDeletion = null;
                }
            }

            if ($this->collUseCases !== null) {
                foreach ($this->collUseCases as $referrerFK) {
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

        $this->modifiedColumns[WorkFlowTableMap::COL_WORK_FLOW_ID] = true;
        if (null !== $this->work_flow_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . WorkFlowTableMap::COL_WORK_FLOW_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(WorkFlowTableMap::COL_WORK_FLOW_ID)) {
            $modifiedColumns[':p' . $index++]  = 'work_flow_id';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_TRIGGER_CLASS)) {
            $modifiedColumns[':p' . $index++]  = 'trigger_class';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_MODIFIED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'modified_at';
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'modified_by';
        }

        $sql = sprintf(
            'INSERT INTO PHPWF_work_flow (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'work_flow_id':
                        $stmt->bindValue($identifier, $this->work_flow_id, PDO::PARAM_INT);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'trigger_class':
                        $stmt->bindValue($identifier, $this->trigger_class, PDO::PARAM_STR);
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
        $this->setWorkFlowId($pk);

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
        $pos = WorkFlowTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getWorkFlowId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getTriggerClass();
                break;
            case 4:
                return $this->getCreatedAt();
                break;
            case 5:
                return $this->getCreatedBy();
                break;
            case 6:
                return $this->getModifiedAt();
                break;
            case 7:
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

        if (isset($alreadyDumpedObjects['WorkFlow'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['WorkFlow'][$this->hashCode()] = true;
        $keys = WorkFlowTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getWorkFlowId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getTriggerClass(),
            $keys[4] => $this->getCreatedAt(),
            $keys[5] => $this->getCreatedBy(),
            $keys[6] => $this->getModifiedAt(),
            $keys[7] => $this->getModifiedBy(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[4]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[4]];
            $result[$keys[4]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[6]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[6]];
            $result[$keys[6]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collArcs) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'arcs';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_arcs';
                        break;
                    default:
                        $key = 'Arcs';
                }

                $result[$key] = $this->collArcs->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPlaces) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'places';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_places';
                        break;
                    default:
                        $key = 'Places';
                }

                $result[$key] = $this->collPlaces->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTransitions) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'transitions';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'PHPWF_transitions';
                        break;
                    default:
                        $key = 'Transitions';
                }

                $result[$key] = $this->collTransitions->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collUseCases) {

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

                $result[$key] = $this->collUseCases->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\PHPWorkFlow\DB\WorkFlow
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = WorkFlowTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\PHPWorkFlow\DB\WorkFlow
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setWorkFlowId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setTriggerClass($value);
                break;
            case 4:
                $this->setCreatedAt($value);
                break;
            case 5:
                $this->setCreatedBy($value);
                break;
            case 6:
                $this->setModifiedAt($value);
                break;
            case 7:
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
        $keys = WorkFlowTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setWorkFlowId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setName($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setDescription($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setTriggerClass($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setCreatedAt($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setCreatedBy($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setModifiedAt($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setModifiedBy($arr[$keys[7]]);
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
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object, for fluid interface
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
        $criteria = new Criteria(WorkFlowTableMap::DATABASE_NAME);

        if ($this->isColumnModified(WorkFlowTableMap::COL_WORK_FLOW_ID)) {
            $criteria->add(WorkFlowTableMap::COL_WORK_FLOW_ID, $this->work_flow_id);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_NAME)) {
            $criteria->add(WorkFlowTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_DESCRIPTION)) {
            $criteria->add(WorkFlowTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_TRIGGER_CLASS)) {
            $criteria->add(WorkFlowTableMap::COL_TRIGGER_CLASS, $this->trigger_class);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_CREATED_AT)) {
            $criteria->add(WorkFlowTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_CREATED_BY)) {
            $criteria->add(WorkFlowTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_MODIFIED_AT)) {
            $criteria->add(WorkFlowTableMap::COL_MODIFIED_AT, $this->modified_at);
        }
        if ($this->isColumnModified(WorkFlowTableMap::COL_MODIFIED_BY)) {
            $criteria->add(WorkFlowTableMap::COL_MODIFIED_BY, $this->modified_by);
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
        $criteria = ChildWorkFlowQuery::create();
        $criteria->add(WorkFlowTableMap::COL_WORK_FLOW_ID, $this->work_flow_id);

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
        $validPk = null !== $this->getWorkFlowId();

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
        return $this->getWorkFlowId();
    }

    /**
     * Generic method to set the primary key (work_flow_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setWorkFlowId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getWorkFlowId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \PHPWorkFlow\DB\WorkFlow (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setTriggerClass($this->getTriggerClass());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setCreatedBy($this->getCreatedBy());
        $copyObj->setModifiedAt($this->getModifiedAt());
        $copyObj->setModifiedBy($this->getModifiedBy());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getArcs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArc($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPlaces() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPlace($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTransitions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTransition($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getUseCases() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addUseCase($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setWorkFlowId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \PHPWorkFlow\DB\WorkFlow Clone of current object.
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
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('Arc' == $relationName) {
            return $this->initArcs();
        }
        if ('Place' == $relationName) {
            return $this->initPlaces();
        }
        if ('Transition' == $relationName) {
            return $this->initTransitions();
        }
        if ('UseCase' == $relationName) {
            return $this->initUseCases();
        }
    }

    /**
     * Clears out the collArcs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addArcs()
     */
    public function clearArcs()
    {
        $this->collArcs = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collArcs collection loaded partially.
     */
    public function resetPartialArcs($v = true)
    {
        $this->collArcsPartial = $v;
    }

    /**
     * Initializes the collArcs collection.
     *
     * By default this just sets the collArcs collection to an empty array (like clearcollArcs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArcs($overrideExisting = true)
    {
        if (null !== $this->collArcs && !$overrideExisting) {
            return;
        }
        $this->collArcs = new ObjectCollection();
        $this->collArcs->setModel('\PHPWorkFlow\DB\Arc');
    }

    /**
     * Gets an array of ChildArc objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWorkFlow is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildArc[] List of ChildArc objects
     * @throws PropelException
     */
    public function getArcs(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collArcsPartial && !$this->isNew();
        if (null === $this->collArcs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArcs) {
                // return empty collection
                $this->initArcs();
            } else {
                $collArcs = ChildArcQuery::create(null, $criteria)
                    ->filterByWorkFlow($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collArcsPartial && count($collArcs)) {
                        $this->initArcs(false);

                        foreach ($collArcs as $obj) {
                            if (false == $this->collArcs->contains($obj)) {
                                $this->collArcs->append($obj);
                            }
                        }

                        $this->collArcsPartial = true;
                    }

                    return $collArcs;
                }

                if ($partial && $this->collArcs) {
                    foreach ($this->collArcs as $obj) {
                        if ($obj->isNew()) {
                            $collArcs[] = $obj;
                        }
                    }
                }

                $this->collArcs = $collArcs;
                $this->collArcsPartial = false;
            }
        }

        return $this->collArcs;
    }

    /**
     * Sets a collection of ChildArc objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $arcs A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function setArcs(Collection $arcs, ConnectionInterface $con = null)
    {
        /** @var ChildArc[] $arcsToDelete */
        $arcsToDelete = $this->getArcs(new Criteria(), $con)->diff($arcs);


        $this->arcsScheduledForDeletion = $arcsToDelete;

        foreach ($arcsToDelete as $arcRemoved) {
            $arcRemoved->setWorkFlow(null);
        }

        $this->collArcs = null;
        foreach ($arcs as $arc) {
            $this->addArc($arc);
        }

        $this->collArcs = $arcs;
        $this->collArcsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Arc objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Arc objects.
     * @throws PropelException
     */
    public function countArcs(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collArcsPartial && !$this->isNew();
        if (null === $this->collArcs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArcs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getArcs());
            }

            $query = ChildArcQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWorkFlow($this)
                ->count($con);
        }

        return count($this->collArcs);
    }

    /**
     * Method called to associate a ChildArc object to this object
     * through the ChildArc foreign key attribute.
     *
     * @param  ChildArc $l ChildArc
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function addArc(ChildArc $l)
    {
        if ($this->collArcs === null) {
            $this->initArcs();
            $this->collArcsPartial = true;
        }

        if (!$this->collArcs->contains($l)) {
            $this->doAddArc($l);
        }

        return $this;
    }

    /**
     * @param ChildArc $arc The ChildArc object to add.
     */
    protected function doAddArc(ChildArc $arc)
    {
        $this->collArcs[]= $arc;
        $arc->setWorkFlow($this);
    }

    /**
     * @param  ChildArc $arc The ChildArc object to remove.
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function removeArc(ChildArc $arc)
    {
        if ($this->getArcs()->contains($arc)) {
            $pos = $this->collArcs->search($arc);
            $this->collArcs->remove($pos);
            if (null === $this->arcsScheduledForDeletion) {
                $this->arcsScheduledForDeletion = clone $this->collArcs;
                $this->arcsScheduledForDeletion->clear();
            }
            $this->arcsScheduledForDeletion[]= clone $arc;
            $arc->setWorkFlow(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkFlow is new, it will return
     * an empty collection; or if this WorkFlow has previously
     * been saved, it will retrieve related Arcs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkFlow.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildArc[] List of ChildArc objects
     */
    public function getArcsJoinTransition(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildArcQuery::create(null, $criteria);
        $query->joinWith('Transition', $joinBehavior);

        return $this->getArcs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkFlow is new, it will return
     * an empty collection; or if this WorkFlow has previously
     * been saved, it will retrieve related Arcs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkFlow.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildArc[] List of ChildArc objects
     */
    public function getArcsJoinPlace(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildArcQuery::create(null, $criteria);
        $query->joinWith('Place', $joinBehavior);

        return $this->getArcs($query, $con);
    }

    /**
     * Clears out the collPlaces collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPlaces()
     */
    public function clearPlaces()
    {
        $this->collPlaces = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPlaces collection loaded partially.
     */
    public function resetPartialPlaces($v = true)
    {
        $this->collPlacesPartial = $v;
    }

    /**
     * Initializes the collPlaces collection.
     *
     * By default this just sets the collPlaces collection to an empty array (like clearcollPlaces());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPlaces($overrideExisting = true)
    {
        if (null !== $this->collPlaces && !$overrideExisting) {
            return;
        }
        $this->collPlaces = new ObjectCollection();
        $this->collPlaces->setModel('\PHPWorkFlow\DB\Place');
    }

    /**
     * Gets an array of ChildPlace objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWorkFlow is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPlace[] List of ChildPlace objects
     * @throws PropelException
     */
    public function getPlaces(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPlacesPartial && !$this->isNew();
        if (null === $this->collPlaces || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPlaces) {
                // return empty collection
                $this->initPlaces();
            } else {
                $collPlaces = ChildPlaceQuery::create(null, $criteria)
                    ->filterByWorkFlow($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPlacesPartial && count($collPlaces)) {
                        $this->initPlaces(false);

                        foreach ($collPlaces as $obj) {
                            if (false == $this->collPlaces->contains($obj)) {
                                $this->collPlaces->append($obj);
                            }
                        }

                        $this->collPlacesPartial = true;
                    }

                    return $collPlaces;
                }

                if ($partial && $this->collPlaces) {
                    foreach ($this->collPlaces as $obj) {
                        if ($obj->isNew()) {
                            $collPlaces[] = $obj;
                        }
                    }
                }

                $this->collPlaces = $collPlaces;
                $this->collPlacesPartial = false;
            }
        }

        return $this->collPlaces;
    }

    /**
     * Sets a collection of ChildPlace objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $places A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function setPlaces(Collection $places, ConnectionInterface $con = null)
    {
        /** @var ChildPlace[] $placesToDelete */
        $placesToDelete = $this->getPlaces(new Criteria(), $con)->diff($places);


        $this->placesScheduledForDeletion = $placesToDelete;

        foreach ($placesToDelete as $placeRemoved) {
            $placeRemoved->setWorkFlow(null);
        }

        $this->collPlaces = null;
        foreach ($places as $place) {
            $this->addPlace($place);
        }

        $this->collPlaces = $places;
        $this->collPlacesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Place objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Place objects.
     * @throws PropelException
     */
    public function countPlaces(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPlacesPartial && !$this->isNew();
        if (null === $this->collPlaces || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPlaces) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPlaces());
            }

            $query = ChildPlaceQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWorkFlow($this)
                ->count($con);
        }

        return count($this->collPlaces);
    }

    /**
     * Method called to associate a ChildPlace object to this object
     * through the ChildPlace foreign key attribute.
     *
     * @param  ChildPlace $l ChildPlace
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function addPlace(ChildPlace $l)
    {
        if ($this->collPlaces === null) {
            $this->initPlaces();
            $this->collPlacesPartial = true;
        }

        if (!$this->collPlaces->contains($l)) {
            $this->doAddPlace($l);
        }

        return $this;
    }

    /**
     * @param ChildPlace $place The ChildPlace object to add.
     */
    protected function doAddPlace(ChildPlace $place)
    {
        $this->collPlaces[]= $place;
        $place->setWorkFlow($this);
    }

    /**
     * @param  ChildPlace $place The ChildPlace object to remove.
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function removePlace(ChildPlace $place)
    {
        if ($this->getPlaces()->contains($place)) {
            $pos = $this->collPlaces->search($place);
            $this->collPlaces->remove($pos);
            if (null === $this->placesScheduledForDeletion) {
                $this->placesScheduledForDeletion = clone $this->collPlaces;
                $this->placesScheduledForDeletion->clear();
            }
            $this->placesScheduledForDeletion[]= clone $place;
            $place->setWorkFlow(null);
        }

        return $this;
    }

    /**
     * Clears out the collTransitions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addTransitions()
     */
    public function clearTransitions()
    {
        $this->collTransitions = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collTransitions collection loaded partially.
     */
    public function resetPartialTransitions($v = true)
    {
        $this->collTransitionsPartial = $v;
    }

    /**
     * Initializes the collTransitions collection.
     *
     * By default this just sets the collTransitions collection to an empty array (like clearcollTransitions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTransitions($overrideExisting = true)
    {
        if (null !== $this->collTransitions && !$overrideExisting) {
            return;
        }
        $this->collTransitions = new ObjectCollection();
        $this->collTransitions->setModel('\PHPWorkFlow\DB\Transition');
    }

    /**
     * Gets an array of ChildTransition objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWorkFlow is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildTransition[] List of ChildTransition objects
     * @throws PropelException
     */
    public function getTransitions(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collTransitionsPartial && !$this->isNew();
        if (null === $this->collTransitions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTransitions) {
                // return empty collection
                $this->initTransitions();
            } else {
                $collTransitions = ChildTransitionQuery::create(null, $criteria)
                    ->filterByWorkFlow($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collTransitionsPartial && count($collTransitions)) {
                        $this->initTransitions(false);

                        foreach ($collTransitions as $obj) {
                            if (false == $this->collTransitions->contains($obj)) {
                                $this->collTransitions->append($obj);
                            }
                        }

                        $this->collTransitionsPartial = true;
                    }

                    return $collTransitions;
                }

                if ($partial && $this->collTransitions) {
                    foreach ($this->collTransitions as $obj) {
                        if ($obj->isNew()) {
                            $collTransitions[] = $obj;
                        }
                    }
                }

                $this->collTransitions = $collTransitions;
                $this->collTransitionsPartial = false;
            }
        }

        return $this->collTransitions;
    }

    /**
     * Sets a collection of ChildTransition objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $transitions A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function setTransitions(Collection $transitions, ConnectionInterface $con = null)
    {
        /** @var ChildTransition[] $transitionsToDelete */
        $transitionsToDelete = $this->getTransitions(new Criteria(), $con)->diff($transitions);


        $this->transitionsScheduledForDeletion = $transitionsToDelete;

        foreach ($transitionsToDelete as $transitionRemoved) {
            $transitionRemoved->setWorkFlow(null);
        }

        $this->collTransitions = null;
        foreach ($transitions as $transition) {
            $this->addTransition($transition);
        }

        $this->collTransitions = $transitions;
        $this->collTransitionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Transition objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Transition objects.
     * @throws PropelException
     */
    public function countTransitions(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collTransitionsPartial && !$this->isNew();
        if (null === $this->collTransitions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTransitions) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getTransitions());
            }

            $query = ChildTransitionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWorkFlow($this)
                ->count($con);
        }

        return count($this->collTransitions);
    }

    /**
     * Method called to associate a ChildTransition object to this object
     * through the ChildTransition foreign key attribute.
     *
     * @param  ChildTransition $l ChildTransition
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function addTransition(ChildTransition $l)
    {
        if ($this->collTransitions === null) {
            $this->initTransitions();
            $this->collTransitionsPartial = true;
        }

        if (!$this->collTransitions->contains($l)) {
            $this->doAddTransition($l);
        }

        return $this;
    }

    /**
     * @param ChildTransition $transition The ChildTransition object to add.
     */
    protected function doAddTransition(ChildTransition $transition)
    {
        $this->collTransitions[]= $transition;
        $transition->setWorkFlow($this);
    }

    /**
     * @param  ChildTransition $transition The ChildTransition object to remove.
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function removeTransition(ChildTransition $transition)
    {
        if ($this->getTransitions()->contains($transition)) {
            $pos = $this->collTransitions->search($transition);
            $this->collTransitions->remove($pos);
            if (null === $this->transitionsScheduledForDeletion) {
                $this->transitionsScheduledForDeletion = clone $this->collTransitions;
                $this->transitionsScheduledForDeletion->clear();
            }
            $this->transitionsScheduledForDeletion[]= clone $transition;
            $transition->setWorkFlow(null);
        }

        return $this;
    }

    /**
     * Clears out the collUseCases collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addUseCases()
     */
    public function clearUseCases()
    {
        $this->collUseCases = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collUseCases collection loaded partially.
     */
    public function resetPartialUseCases($v = true)
    {
        $this->collUseCasesPartial = $v;
    }

    /**
     * Initializes the collUseCases collection.
     *
     * By default this just sets the collUseCases collection to an empty array (like clearcollUseCases());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initUseCases($overrideExisting = true)
    {
        if (null !== $this->collUseCases && !$overrideExisting) {
            return;
        }
        $this->collUseCases = new ObjectCollection();
        $this->collUseCases->setModel('\PHPWorkFlow\DB\UseCase');
    }

    /**
     * Gets an array of ChildUseCase objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildWorkFlow is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildUseCase[] List of ChildUseCase objects
     * @throws PropelException
     */
    public function getUseCases(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collUseCasesPartial && !$this->isNew();
        if (null === $this->collUseCases || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collUseCases) {
                // return empty collection
                $this->initUseCases();
            } else {
                $collUseCases = ChildUseCaseQuery::create(null, $criteria)
                    ->filterByWorkFlow($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collUseCasesPartial && count($collUseCases)) {
                        $this->initUseCases(false);

                        foreach ($collUseCases as $obj) {
                            if (false == $this->collUseCases->contains($obj)) {
                                $this->collUseCases->append($obj);
                            }
                        }

                        $this->collUseCasesPartial = true;
                    }

                    return $collUseCases;
                }

                if ($partial && $this->collUseCases) {
                    foreach ($this->collUseCases as $obj) {
                        if ($obj->isNew()) {
                            $collUseCases[] = $obj;
                        }
                    }
                }

                $this->collUseCases = $collUseCases;
                $this->collUseCasesPartial = false;
            }
        }

        return $this->collUseCases;
    }

    /**
     * Sets a collection of ChildUseCase objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $useCases A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function setUseCases(Collection $useCases, ConnectionInterface $con = null)
    {
        /** @var ChildUseCase[] $useCasesToDelete */
        $useCasesToDelete = $this->getUseCases(new Criteria(), $con)->diff($useCases);


        $this->useCasesScheduledForDeletion = $useCasesToDelete;

        foreach ($useCasesToDelete as $useCaseRemoved) {
            $useCaseRemoved->setWorkFlow(null);
        }

        $this->collUseCases = null;
        foreach ($useCases as $useCase) {
            $this->addUseCase($useCase);
        }

        $this->collUseCases = $useCases;
        $this->collUseCasesPartial = false;

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
    public function countUseCases(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collUseCasesPartial && !$this->isNew();
        if (null === $this->collUseCases || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collUseCases) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getUseCases());
            }

            $query = ChildUseCaseQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByWorkFlow($this)
                ->count($con);
        }

        return count($this->collUseCases);
    }

    /**
     * Method called to associate a ChildUseCase object to this object
     * through the ChildUseCase foreign key attribute.
     *
     * @param  ChildUseCase $l ChildUseCase
     * @return $this|\PHPWorkFlow\DB\WorkFlow The current object (for fluent API support)
     */
    public function addUseCase(ChildUseCase $l)
    {
        if ($this->collUseCases === null) {
            $this->initUseCases();
            $this->collUseCasesPartial = true;
        }

        if (!$this->collUseCases->contains($l)) {
            $this->doAddUseCase($l);
        }

        return $this;
    }

    /**
     * @param ChildUseCase $useCase The ChildUseCase object to add.
     */
    protected function doAddUseCase(ChildUseCase $useCase)
    {
        $this->collUseCases[]= $useCase;
        $useCase->setWorkFlow($this);
    }

    /**
     * @param  ChildUseCase $useCase The ChildUseCase object to remove.
     * @return $this|ChildWorkFlow The current object (for fluent API support)
     */
    public function removeUseCase(ChildUseCase $useCase)
    {
        if ($this->getUseCases()->contains($useCase)) {
            $pos = $this->collUseCases->search($useCase);
            $this->collUseCases->remove($pos);
            if (null === $this->useCasesScheduledForDeletion) {
                $this->useCasesScheduledForDeletion = clone $this->collUseCases;
                $this->useCasesScheduledForDeletion->clear();
            }
            $this->useCasesScheduledForDeletion[]= clone $useCase;
            $useCase->setWorkFlow(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this WorkFlow is new, it will return
     * an empty collection; or if this WorkFlow has previously
     * been saved, it will retrieve related UseCases from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in WorkFlow.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildUseCase[] List of ChildUseCase objects
     */
    public function getUseCasesJoinUseCaseRelatedByParentUseCaseId(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildUseCaseQuery::create(null, $criteria);
        $query->joinWith('UseCaseRelatedByParentUseCaseId', $joinBehavior);

        return $this->getUseCases($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->work_flow_id = null;
        $this->name = null;
        $this->description = null;
        $this->trigger_class = null;
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
            if ($this->collArcs) {
                foreach ($this->collArcs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPlaces) {
                foreach ($this->collPlaces as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTransitions) {
                foreach ($this->collTransitions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collUseCases) {
                foreach ($this->collUseCases as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collArcs = null;
        $this->collPlaces = null;
        $this->collTransitions = null;
        $this->collUseCases = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(WorkFlowTableMap::DEFAULT_STRING_FORMAT);
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
