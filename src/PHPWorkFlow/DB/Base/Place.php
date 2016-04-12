<?php

namespace PHPWorkFlow\DB\Base;

use \DateTime;
use \Exception;
use \PDO;
use PHPWorkFlow\DB\Arc as ChildArc;
use PHPWorkFlow\DB\ArcQuery as ChildArcQuery;
use PHPWorkFlow\DB\Place as ChildPlace;
use PHPWorkFlow\DB\PlaceQuery as ChildPlaceQuery;
use PHPWorkFlow\DB\Token as ChildToken;
use PHPWorkFlow\DB\TokenQuery as ChildTokenQuery;
use PHPWorkFlow\DB\WorkFlow as ChildWorkFlow;
use PHPWorkFlow\DB\WorkFlowQuery as ChildWorkFlowQuery;
use PHPWorkFlow\DB\Map\PlaceTableMap;
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
 * Base class that represents a row from the 'PHPWF_place' table.
 *
 *
 *
* @package    propel.generator.PHPWorkFlow.DB.Base
*/
abstract class Place implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\PHPWorkFlow\\DB\\Map\\PlaceTableMap';


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
     * The value for the place_id field.
     *
     * @var        int
     */
    protected $place_id;

    /**
     * The value for the work_flow_id field.
     *
     * @var        int
     */
    protected $work_flow_id;

    /**
     * The value for the place_type field.
     *
     * @var        string
     */
    protected $place_type;

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
     * The value for the position_x field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $position_x;

    /**
     * The value for the position_y field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $position_y;

    /**
     * The value for the dimension_x field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $dimension_x;

    /**
     * The value for the dimension_y field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $dimension_y;

    /**
     * The value for the yasper_name field.
     *
     * @var        string
     */
    protected $yasper_name;

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
     * @var        ChildWorkFlow
     */
    protected $aWorkFlow;

    /**
     * @var        ObjectCollection|ChildArc[] Collection to store aggregation of ChildArc objects.
     */
    protected $collArcs;
    protected $collArcsPartial;

    /**
     * @var        ObjectCollection|ChildToken[] Collection to store aggregation of ChildToken objects.
     */
    protected $collTokens;
    protected $collTokensPartial;

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
     * @var ObjectCollection|ChildToken[]
     */
    protected $tokensScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->position_x = 0;
        $this->position_y = 0;
        $this->dimension_x = 0;
        $this->dimension_y = 0;
        $this->created_by = 0;
        $this->modified_by = 0;
    }

    /**
     * Initializes internal state of PHPWorkFlow\DB\Base\Place object.
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
     * Compares this with another <code>Place</code> instance.  If
     * <code>obj</code> is an instance of <code>Place</code>, delegates to
     * <code>equals(Place)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Place The current object, for fluid interface
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
     * Get the [place_id] column value.
     *
     * @return int
     */
    public function getPlaceId()
    {
        return $this->place_id;
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
     * Get the [place_type] column value.
     *
     * @return string
     */
    public function getPlaceType()
    {
        return $this->place_type;
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
     * Get the [position_x] column value.
     *
     * @return int
     */
    public function getPositionX()
    {
        return $this->position_x;
    }

    /**
     * Get the [position_y] column value.
     *
     * @return int
     */
    public function getPositionY()
    {
        return $this->position_y;
    }

    /**
     * Get the [dimension_x] column value.
     *
     * @return int
     */
    public function getDimensionX()
    {
        return $this->dimension_x;
    }

    /**
     * Get the [dimension_y] column value.
     *
     * @return int
     */
    public function getDimensionY()
    {
        return $this->dimension_y;
    }

    /**
     * Get the [yasper_name] column value.
     *
     * @return string
     */
    public function getYasperName()
    {
        return $this->yasper_name;
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
     * Set the value of [place_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setPlaceId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->place_id !== $v) {
            $this->place_id = $v;
            $this->modifiedColumns[PlaceTableMap::COL_PLACE_ID] = true;
        }

        return $this;
    } // setPlaceId()

    /**
     * Set the value of [work_flow_id] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setWorkFlowId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->work_flow_id !== $v) {
            $this->work_flow_id = $v;
            $this->modifiedColumns[PlaceTableMap::COL_WORK_FLOW_ID] = true;
        }

        if ($this->aWorkFlow !== null && $this->aWorkFlow->getWorkFlowId() !== $v) {
            $this->aWorkFlow = null;
        }

        return $this;
    } // setWorkFlowId()

    /**
     * Set the value of [place_type] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setPlaceType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->place_type !== $v) {
            $this->place_type = $v;
            $this->modifiedColumns[PlaceTableMap::COL_PLACE_TYPE] = true;
        }

        return $this;
    } // setPlaceType()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[PlaceTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[PlaceTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [position_x] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setPositionX($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position_x !== $v) {
            $this->position_x = $v;
            $this->modifiedColumns[PlaceTableMap::COL_POSITION_X] = true;
        }

        return $this;
    } // setPositionX()

    /**
     * Set the value of [position_y] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setPositionY($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->position_y !== $v) {
            $this->position_y = $v;
            $this->modifiedColumns[PlaceTableMap::COL_POSITION_Y] = true;
        }

        return $this;
    } // setPositionY()

    /**
     * Set the value of [dimension_x] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setDimensionX($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->dimension_x !== $v) {
            $this->dimension_x = $v;
            $this->modifiedColumns[PlaceTableMap::COL_DIMENSION_X] = true;
        }

        return $this;
    } // setDimensionX()

    /**
     * Set the value of [dimension_y] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setDimensionY($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->dimension_y !== $v) {
            $this->dimension_y = $v;
            $this->modifiedColumns[PlaceTableMap::COL_DIMENSION_Y] = true;
        }

        return $this;
    } // setDimensionY()

    /**
     * Set the value of [yasper_name] column.
     *
     * @param string $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setYasperName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->yasper_name !== $v) {
            $this->yasper_name = $v;
            $this->modifiedColumns[PlaceTableMap::COL_YASPER_NAME] = true;
        }

        return $this;
    } // setYasperName()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            if ($this->created_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->created_at->format("Y-m-d H:i:s")) {
                $this->created_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PlaceTableMap::COL_CREATED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setCreatedAt()

    /**
     * Set the value of [created_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setCreatedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->created_by !== $v) {
            $this->created_by = $v;
            $this->modifiedColumns[PlaceTableMap::COL_CREATED_BY] = true;
        }

        return $this;
    } // setCreatedBy()

    /**
     * Sets the value of [modified_at] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTime value.
     *               Empty strings are treated as NULL.
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setModifiedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modified_at !== null || $dt !== null) {
            if ($this->modified_at === null || $dt === null || $dt->format("Y-m-d H:i:s") !== $this->modified_at->format("Y-m-d H:i:s")) {
                $this->modified_at = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PlaceTableMap::COL_MODIFIED_AT] = true;
            }
        } // if either are not null

        return $this;
    } // setModifiedAt()

    /**
     * Set the value of [modified_by] column.
     *
     * @param int $v new value
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
     */
    public function setModifiedBy($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->modified_by !== $v) {
            $this->modified_by = $v;
            $this->modifiedColumns[PlaceTableMap::COL_MODIFIED_BY] = true;
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
            if ($this->position_x !== 0) {
                return false;
            }

            if ($this->position_y !== 0) {
                return false;
            }

            if ($this->dimension_x !== 0) {
                return false;
            }

            if ($this->dimension_y !== 0) {
                return false;
            }

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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PlaceTableMap::translateFieldName('PlaceId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->place_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PlaceTableMap::translateFieldName('WorkFlowId', TableMap::TYPE_PHPNAME, $indexType)];
            $this->work_flow_id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PlaceTableMap::translateFieldName('PlaceType', TableMap::TYPE_PHPNAME, $indexType)];
            $this->place_type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PlaceTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PlaceTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PlaceTableMap::translateFieldName('PositionX', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position_x = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PlaceTableMap::translateFieldName('PositionY', TableMap::TYPE_PHPNAME, $indexType)];
            $this->position_y = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PlaceTableMap::translateFieldName('DimensionX', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dimension_x = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : PlaceTableMap::translateFieldName('DimensionY', TableMap::TYPE_PHPNAME, $indexType)];
            $this->dimension_y = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : PlaceTableMap::translateFieldName('YasperName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->yasper_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : PlaceTableMap::translateFieldName('CreatedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->created_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : PlaceTableMap::translateFieldName('CreatedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->created_by = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : PlaceTableMap::translateFieldName('ModifiedAt', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->modified_at = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 13 + $startcol : PlaceTableMap::translateFieldName('ModifiedBy', TableMap::TYPE_PHPNAME, $indexType)];
            $this->modified_by = (null !== $col) ? (int) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 14; // 14 = PlaceTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\PHPWorkFlow\\DB\\Place'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(PlaceTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPlaceQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aWorkFlow = null;
            $this->collArcs = null;

            $this->collTokens = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Place::setDeleted()
     * @see Place::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPlaceQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
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
                PlaceTableMap::addInstanceToPool($this);
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

        $this->modifiedColumns[PlaceTableMap::COL_PLACE_ID] = true;
        if (null !== $this->place_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PlaceTableMap::COL_PLACE_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PlaceTableMap::COL_PLACE_ID)) {
            $modifiedColumns[':p' . $index++]  = 'place_id';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_WORK_FLOW_ID)) {
            $modifiedColumns[':p' . $index++]  = 'work_flow_id';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_PLACE_TYPE)) {
            $modifiedColumns[':p' . $index++]  = 'place_type';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_POSITION_X)) {
            $modifiedColumns[':p' . $index++]  = 'position_x';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_POSITION_Y)) {
            $modifiedColumns[':p' . $index++]  = 'position_y';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_DIMENSION_X)) {
            $modifiedColumns[':p' . $index++]  = 'dimension_x';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_DIMENSION_Y)) {
            $modifiedColumns[':p' . $index++]  = 'dimension_y';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_YASPER_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'yasper_name';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'created_at';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_CREATED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'created_by';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_MODIFIED_AT)) {
            $modifiedColumns[':p' . $index++]  = 'modified_at';
        }
        if ($this->isColumnModified(PlaceTableMap::COL_MODIFIED_BY)) {
            $modifiedColumns[':p' . $index++]  = 'modified_by';
        }

        $sql = sprintf(
            'INSERT INTO PHPWF_place (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'place_id':
                        $stmt->bindValue($identifier, $this->place_id, PDO::PARAM_INT);
                        break;
                    case 'work_flow_id':
                        $stmt->bindValue($identifier, $this->work_flow_id, PDO::PARAM_INT);
                        break;
                    case 'place_type':
                        $stmt->bindValue($identifier, $this->place_type, PDO::PARAM_STR);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'position_x':
                        $stmt->bindValue($identifier, $this->position_x, PDO::PARAM_INT);
                        break;
                    case 'position_y':
                        $stmt->bindValue($identifier, $this->position_y, PDO::PARAM_INT);
                        break;
                    case 'dimension_x':
                        $stmt->bindValue($identifier, $this->dimension_x, PDO::PARAM_INT);
                        break;
                    case 'dimension_y':
                        $stmt->bindValue($identifier, $this->dimension_y, PDO::PARAM_INT);
                        break;
                    case 'yasper_name':
                        $stmt->bindValue($identifier, $this->yasper_name, PDO::PARAM_STR);
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
        $this->setPlaceId($pk);

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
        $pos = PlaceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getPlaceId();
                break;
            case 1:
                return $this->getWorkFlowId();
                break;
            case 2:
                return $this->getPlaceType();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getDescription();
                break;
            case 5:
                return $this->getPositionX();
                break;
            case 6:
                return $this->getPositionY();
                break;
            case 7:
                return $this->getDimensionX();
                break;
            case 8:
                return $this->getDimensionY();
                break;
            case 9:
                return $this->getYasperName();
                break;
            case 10:
                return $this->getCreatedAt();
                break;
            case 11:
                return $this->getCreatedBy();
                break;
            case 12:
                return $this->getModifiedAt();
                break;
            case 13:
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

        if (isset($alreadyDumpedObjects['Place'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Place'][$this->hashCode()] = true;
        $keys = PlaceTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPlaceId(),
            $keys[1] => $this->getWorkFlowId(),
            $keys[2] => $this->getPlaceType(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getDescription(),
            $keys[5] => $this->getPositionX(),
            $keys[6] => $this->getPositionY(),
            $keys[7] => $this->getDimensionX(),
            $keys[8] => $this->getDimensionY(),
            $keys[9] => $this->getYasperName(),
            $keys[10] => $this->getCreatedAt(),
            $keys[11] => $this->getCreatedBy(),
            $keys[12] => $this->getModifiedAt(),
            $keys[13] => $this->getModifiedBy(),
        );

        $utc = new \DateTimeZone('utc');
        if ($result[$keys[10]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[10]];
            $result[$keys[10]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        if ($result[$keys[12]] instanceof \DateTime) {
            // When changing timezone we don't want to change existing instances
            $dateTime = clone $result[$keys[12]];
            $result[$keys[12]] = $dateTime->setTimezone($utc)->format('Y-m-d\TH:i:s\Z');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
     * @return $this|\PHPWorkFlow\DB\Place
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PlaceTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\PHPWorkFlow\DB\Place
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setPlaceId($value);
                break;
            case 1:
                $this->setWorkFlowId($value);
                break;
            case 2:
                $this->setPlaceType($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setDescription($value);
                break;
            case 5:
                $this->setPositionX($value);
                break;
            case 6:
                $this->setPositionY($value);
                break;
            case 7:
                $this->setDimensionX($value);
                break;
            case 8:
                $this->setDimensionY($value);
                break;
            case 9:
                $this->setYasperName($value);
                break;
            case 10:
                $this->setCreatedAt($value);
                break;
            case 11:
                $this->setCreatedBy($value);
                break;
            case 12:
                $this->setModifiedAt($value);
                break;
            case 13:
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
        $keys = PlaceTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setPlaceId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setWorkFlowId($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setPlaceType($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setName($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setDescription($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setPositionX($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setPositionY($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setDimensionX($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setDimensionY($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setYasperName($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setCreatedAt($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setCreatedBy($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setModifiedAt($arr[$keys[12]]);
        }
        if (array_key_exists($keys[13], $arr)) {
            $this->setModifiedBy($arr[$keys[13]]);
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
     * @return $this|\PHPWorkFlow\DB\Place The current object, for fluid interface
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
        $criteria = new Criteria(PlaceTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PlaceTableMap::COL_PLACE_ID)) {
            $criteria->add(PlaceTableMap::COL_PLACE_ID, $this->place_id);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_WORK_FLOW_ID)) {
            $criteria->add(PlaceTableMap::COL_WORK_FLOW_ID, $this->work_flow_id);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_PLACE_TYPE)) {
            $criteria->add(PlaceTableMap::COL_PLACE_TYPE, $this->place_type);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_NAME)) {
            $criteria->add(PlaceTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_DESCRIPTION)) {
            $criteria->add(PlaceTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_POSITION_X)) {
            $criteria->add(PlaceTableMap::COL_POSITION_X, $this->position_x);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_POSITION_Y)) {
            $criteria->add(PlaceTableMap::COL_POSITION_Y, $this->position_y);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_DIMENSION_X)) {
            $criteria->add(PlaceTableMap::COL_DIMENSION_X, $this->dimension_x);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_DIMENSION_Y)) {
            $criteria->add(PlaceTableMap::COL_DIMENSION_Y, $this->dimension_y);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_YASPER_NAME)) {
            $criteria->add(PlaceTableMap::COL_YASPER_NAME, $this->yasper_name);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_CREATED_AT)) {
            $criteria->add(PlaceTableMap::COL_CREATED_AT, $this->created_at);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_CREATED_BY)) {
            $criteria->add(PlaceTableMap::COL_CREATED_BY, $this->created_by);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_MODIFIED_AT)) {
            $criteria->add(PlaceTableMap::COL_MODIFIED_AT, $this->modified_at);
        }
        if ($this->isColumnModified(PlaceTableMap::COL_MODIFIED_BY)) {
            $criteria->add(PlaceTableMap::COL_MODIFIED_BY, $this->modified_by);
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
        $criteria = ChildPlaceQuery::create();
        $criteria->add(PlaceTableMap::COL_PLACE_ID, $this->place_id);

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
        $validPk = null !== $this->getPlaceId();

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
        return $this->getPlaceId();
    }

    /**
     * Generic method to set the primary key (place_id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setPlaceId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getPlaceId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \PHPWorkFlow\DB\Place (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setWorkFlowId($this->getWorkFlowId());
        $copyObj->setPlaceType($this->getPlaceType());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setPositionX($this->getPositionX());
        $copyObj->setPositionY($this->getPositionY());
        $copyObj->setDimensionX($this->getDimensionX());
        $copyObj->setDimensionY($this->getDimensionY());
        $copyObj->setYasperName($this->getYasperName());
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

            foreach ($this->getTokens() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addToken($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setPlaceId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \PHPWorkFlow\DB\Place Clone of current object.
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
     * Declares an association between this object and a ChildWorkFlow object.
     *
     * @param  ChildWorkFlow $v
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
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
            $v->addPlace($this);
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
                $this->aWorkFlow->addPlaces($this);
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
        if ('Arc' == $relationName) {
            return $this->initArcs();
        }
        if ('Token' == $relationName) {
            return $this->initTokens();
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
     * If this ChildPlace is new, it will return
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
                    ->filterByPlace($this)
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
     * @return $this|ChildPlace The current object (for fluent API support)
     */
    public function setArcs(Collection $arcs, ConnectionInterface $con = null)
    {
        /** @var ChildArc[] $arcsToDelete */
        $arcsToDelete = $this->getArcs(new Criteria(), $con)->diff($arcs);


        $this->arcsScheduledForDeletion = $arcsToDelete;

        foreach ($arcsToDelete as $arcRemoved) {
            $arcRemoved->setPlace(null);
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
                ->filterByPlace($this)
                ->count($con);
        }

        return count($this->collArcs);
    }

    /**
     * Method called to associate a ChildArc object to this object
     * through the ChildArc foreign key attribute.
     *
     * @param  ChildArc $l ChildArc
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
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
        $arc->setPlace($this);
    }

    /**
     * @param  ChildArc $arc The ChildArc object to remove.
     * @return $this|ChildPlace The current object (for fluent API support)
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
            $arc->setPlace(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Place is new, it will return
     * an empty collection; or if this Place has previously
     * been saved, it will retrieve related Arcs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Place.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildArc[] List of ChildArc objects
     */
    public function getArcsJoinWorkFlow(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildArcQuery::create(null, $criteria);
        $query->joinWith('WorkFlow', $joinBehavior);

        return $this->getArcs($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Place is new, it will return
     * an empty collection; or if this Place has previously
     * been saved, it will retrieve related Arcs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Place.
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
     * If this ChildPlace is new, it will return
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
                    ->filterByPlace($this)
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
     * @return $this|ChildPlace The current object (for fluent API support)
     */
    public function setTokens(Collection $tokens, ConnectionInterface $con = null)
    {
        /** @var ChildToken[] $tokensToDelete */
        $tokensToDelete = $this->getTokens(new Criteria(), $con)->diff($tokens);


        $this->tokensScheduledForDeletion = $tokensToDelete;

        foreach ($tokensToDelete as $tokenRemoved) {
            $tokenRemoved->setPlace(null);
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
                ->filterByPlace($this)
                ->count($con);
        }

        return count($this->collTokens);
    }

    /**
     * Method called to associate a ChildToken object to this object
     * through the ChildToken foreign key attribute.
     *
     * @param  ChildToken $l ChildToken
     * @return $this|\PHPWorkFlow\DB\Place The current object (for fluent API support)
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
        $token->setPlace($this);
    }

    /**
     * @param  ChildToken $token The ChildToken object to remove.
     * @return $this|ChildPlace The current object (for fluent API support)
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
            $token->setPlace(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Place is new, it will return
     * an empty collection; or if this Place has previously
     * been saved, it will retrieve related Tokens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Place.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildToken[] List of ChildToken objects
     */
    public function getTokensJoinUseCase(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildTokenQuery::create(null, $criteria);
        $query->joinWith('UseCase', $joinBehavior);

        return $this->getTokens($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Place is new, it will return
     * an empty collection; or if this Place has previously
     * been saved, it will retrieve related Tokens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Place.
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
     * Otherwise if this Place is new, it will return
     * an empty collection; or if this Place has previously
     * been saved, it will retrieve related Tokens from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Place.
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
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aWorkFlow) {
            $this->aWorkFlow->removePlace($this);
        }
        $this->place_id = null;
        $this->work_flow_id = null;
        $this->place_type = null;
        $this->name = null;
        $this->description = null;
        $this->position_x = null;
        $this->position_y = null;
        $this->dimension_x = null;
        $this->dimension_y = null;
        $this->yasper_name = null;
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
            if ($this->collTokens) {
                foreach ($this->collTokens as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collArcs = null;
        $this->collTokens = null;
        $this->aWorkFlow = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PlaceTableMap::DEFAULT_STRING_FORMAT);
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
