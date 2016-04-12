<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\Transition;
use PHPWorkFlow\DB\TransitionQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'PHPWF_transition' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TransitionTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.TransitionTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_transition';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\Transition';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.Transition';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 16;

    /**
     * the column name for the transition_id field
     */
    const COL_TRANSITION_ID = 'PHPWF_transition.transition_id';

    /**
     * the column name for the work_flow_id field
     */
    const COL_WORK_FLOW_ID = 'PHPWF_transition.work_flow_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'PHPWF_transition.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'PHPWF_transition.description';

    /**
     * the column name for the transition_type field
     */
    const COL_TRANSITION_TYPE = 'PHPWF_transition.transition_type';

    /**
     * the column name for the transition_trigger_method field
     */
    const COL_TRANSITION_TRIGGER_METHOD = 'PHPWF_transition.transition_trigger_method';

    /**
     * the column name for the position_x field
     */
    const COL_POSITION_X = 'PHPWF_transition.position_x';

    /**
     * the column name for the position_y field
     */
    const COL_POSITION_Y = 'PHPWF_transition.position_y';

    /**
     * the column name for the dimension_x field
     */
    const COL_DIMENSION_X = 'PHPWF_transition.dimension_x';

    /**
     * the column name for the dimension_y field
     */
    const COL_DIMENSION_Y = 'PHPWF_transition.dimension_y';

    /**
     * the column name for the yasper_name field
     */
    const COL_YASPER_NAME = 'PHPWF_transition.yasper_name';

    /**
     * the column name for the time_delay field
     */
    const COL_TIME_DELAY = 'PHPWF_transition.time_delay';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_transition.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_transition.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_transition.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_transition.modified_by';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('TransitionId', 'WorkFlowId', 'Name', 'Description', 'TransitionType', 'TransitionTriggerMethod', 'PositionX', 'PositionY', 'DimensionX', 'DimensionY', 'YasperName', 'TimeDelay', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('transitionId', 'workFlowId', 'name', 'description', 'transitionType', 'transitionTriggerMethod', 'positionX', 'positionY', 'dimensionX', 'dimensionY', 'yasperName', 'timeDelay', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(TransitionTableMap::COL_TRANSITION_ID, TransitionTableMap::COL_WORK_FLOW_ID, TransitionTableMap::COL_NAME, TransitionTableMap::COL_DESCRIPTION, TransitionTableMap::COL_TRANSITION_TYPE, TransitionTableMap::COL_TRANSITION_TRIGGER_METHOD, TransitionTableMap::COL_POSITION_X, TransitionTableMap::COL_POSITION_Y, TransitionTableMap::COL_DIMENSION_X, TransitionTableMap::COL_DIMENSION_Y, TransitionTableMap::COL_YASPER_NAME, TransitionTableMap::COL_TIME_DELAY, TransitionTableMap::COL_CREATED_AT, TransitionTableMap::COL_CREATED_BY, TransitionTableMap::COL_MODIFIED_AT, TransitionTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('transition_id', 'work_flow_id', 'name', 'description', 'transition_type', 'transition_trigger_method', 'position_x', 'position_y', 'dimension_x', 'dimension_y', 'yasper_name', 'time_delay', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('TransitionId' => 0, 'WorkFlowId' => 1, 'Name' => 2, 'Description' => 3, 'TransitionType' => 4, 'TransitionTriggerMethod' => 5, 'PositionX' => 6, 'PositionY' => 7, 'DimensionX' => 8, 'DimensionY' => 9, 'YasperName' => 10, 'TimeDelay' => 11, 'CreatedAt' => 12, 'CreatedBy' => 13, 'ModifiedAt' => 14, 'ModifiedBy' => 15, ),
        self::TYPE_CAMELNAME     => array('transitionId' => 0, 'workFlowId' => 1, 'name' => 2, 'description' => 3, 'transitionType' => 4, 'transitionTriggerMethod' => 5, 'positionX' => 6, 'positionY' => 7, 'dimensionX' => 8, 'dimensionY' => 9, 'yasperName' => 10, 'timeDelay' => 11, 'createdAt' => 12, 'createdBy' => 13, 'modifiedAt' => 14, 'modifiedBy' => 15, ),
        self::TYPE_COLNAME       => array(TransitionTableMap::COL_TRANSITION_ID => 0, TransitionTableMap::COL_WORK_FLOW_ID => 1, TransitionTableMap::COL_NAME => 2, TransitionTableMap::COL_DESCRIPTION => 3, TransitionTableMap::COL_TRANSITION_TYPE => 4, TransitionTableMap::COL_TRANSITION_TRIGGER_METHOD => 5, TransitionTableMap::COL_POSITION_X => 6, TransitionTableMap::COL_POSITION_Y => 7, TransitionTableMap::COL_DIMENSION_X => 8, TransitionTableMap::COL_DIMENSION_Y => 9, TransitionTableMap::COL_YASPER_NAME => 10, TransitionTableMap::COL_TIME_DELAY => 11, TransitionTableMap::COL_CREATED_AT => 12, TransitionTableMap::COL_CREATED_BY => 13, TransitionTableMap::COL_MODIFIED_AT => 14, TransitionTableMap::COL_MODIFIED_BY => 15, ),
        self::TYPE_FIELDNAME     => array('transition_id' => 0, 'work_flow_id' => 1, 'name' => 2, 'description' => 3, 'transition_type' => 4, 'transition_trigger_method' => 5, 'position_x' => 6, 'position_y' => 7, 'dimension_x' => 8, 'dimension_y' => 9, 'yasper_name' => 10, 'time_delay' => 11, 'created_at' => 12, 'created_by' => 13, 'modified_at' => 14, 'modified_by' => 15, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('PHPWF_transition');
        $this->setPhpName('Transition');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\Transition');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('transition_id', 'TransitionId', 'INTEGER', true, null, null);
        $this->addForeignKey('work_flow_id', 'WorkFlowId', 'INTEGER', 'PHPWF_work_flow', 'work_flow_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', true, 1023, null);
        $this->addColumn('transition_type', 'TransitionType', 'VARCHAR', true, 255, null);
        $this->addColumn('transition_trigger_method', 'TransitionTriggerMethod', 'VARCHAR', true, 255, null);
        $this->addColumn('position_x', 'PositionX', 'INTEGER', true, null, 0);
        $this->addColumn('position_y', 'PositionY', 'INTEGER', true, null, 0);
        $this->addColumn('dimension_x', 'DimensionX', 'INTEGER', true, null, 0);
        $this->addColumn('dimension_y', 'DimensionY', 'INTEGER', true, null, 0);
        $this->addColumn('yasper_name', 'YasperName', 'VARCHAR', true, 255, null);
        $this->addColumn('time_delay', 'TimeDelay', 'INTEGER', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('created_by', 'CreatedBy', 'INTEGER', true, null, 0);
        $this->addColumn('modified_at', 'ModifiedAt', 'TIMESTAMP', true, null, null);
        $this->addColumn('modified_by', 'ModifiedBy', 'INTEGER', true, null, 0);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('WorkFlow', '\\PHPWorkFlow\\DB\\WorkFlow', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':work_flow_id',
    1 => ':work_flow_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Arc', '\\PHPWorkFlow\\DB\\Arc', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'Arcs', false);
        $this->addRelation('Command', '\\PHPWorkFlow\\DB\\Command', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'Commands', false);
        $this->addRelation('Gate', '\\PHPWorkFlow\\DB\\Gate', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'Gates', false);
        $this->addRelation('Notification', '\\PHPWorkFlow\\DB\\Notification', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'Notifications', false);
        $this->addRelation('Route', '\\PHPWorkFlow\\DB\\Route', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'Routes', false);
        $this->addRelation('TriggerFulfillment', '\\PHPWorkFlow\\DB\\TriggerFulfillment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'TriggerFulfillments', false);
        $this->addRelation('WorkItem', '\\PHPWorkFlow\\DB\\WorkItem', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'WorkItems', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to PHPWF_transition     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ArcTableMap::clearInstancePool();
        CommandTableMap::clearInstancePool();
        GateTableMap::clearInstancePool();
        NotificationTableMap::clearInstancePool();
        RouteTableMap::clearInstancePool();
        TriggerFulfillmentTableMap::clearInstancePool();
        WorkItemTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TransitionId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TransitionId', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('TransitionId', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? TransitionTableMap::CLASS_DEFAULT : TransitionTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (Transition object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TransitionTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TransitionTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TransitionTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TransitionTableMap::OM_CLASS;
            /** @var Transition $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TransitionTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = TransitionTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TransitionTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Transition $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TransitionTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(TransitionTableMap::COL_TRANSITION_ID);
            $criteria->addSelectColumn(TransitionTableMap::COL_WORK_FLOW_ID);
            $criteria->addSelectColumn(TransitionTableMap::COL_NAME);
            $criteria->addSelectColumn(TransitionTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(TransitionTableMap::COL_TRANSITION_TYPE);
            $criteria->addSelectColumn(TransitionTableMap::COL_TRANSITION_TRIGGER_METHOD);
            $criteria->addSelectColumn(TransitionTableMap::COL_POSITION_X);
            $criteria->addSelectColumn(TransitionTableMap::COL_POSITION_Y);
            $criteria->addSelectColumn(TransitionTableMap::COL_DIMENSION_X);
            $criteria->addSelectColumn(TransitionTableMap::COL_DIMENSION_Y);
            $criteria->addSelectColumn(TransitionTableMap::COL_YASPER_NAME);
            $criteria->addSelectColumn(TransitionTableMap::COL_TIME_DELAY);
            $criteria->addSelectColumn(TransitionTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TransitionTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(TransitionTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(TransitionTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.transition_id');
            $criteria->addSelectColumn($alias . '.work_flow_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.transition_type');
            $criteria->addSelectColumn($alias . '.transition_trigger_method');
            $criteria->addSelectColumn($alias . '.position_x');
            $criteria->addSelectColumn($alias . '.position_y');
            $criteria->addSelectColumn($alias . '.dimension_x');
            $criteria->addSelectColumn($alias . '.dimension_y');
            $criteria->addSelectColumn($alias . '.yasper_name');
            $criteria->addSelectColumn($alias . '.time_delay');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.created_by');
            $criteria->addSelectColumn($alias . '.modified_at');
            $criteria->addSelectColumn($alias . '.modified_by');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(TransitionTableMap::DATABASE_NAME)->getTable(TransitionTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TransitionTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TransitionTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TransitionTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Transition or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Transition object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransitionTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\Transition) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TransitionTableMap::DATABASE_NAME);
            $criteria->add(TransitionTableMap::COL_TRANSITION_ID, (array) $values, Criteria::IN);
        }

        $query = TransitionQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TransitionTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TransitionTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_transition table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TransitionQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Transition or Criteria object.
     *
     * @param mixed               $criteria Criteria or Transition object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransitionTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Transition object
        }

        if ($criteria->containsKey(TransitionTableMap::COL_TRANSITION_ID) && $criteria->keyContainsValue(TransitionTableMap::COL_TRANSITION_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TransitionTableMap::COL_TRANSITION_ID.')');
        }


        // Set the correct dbName
        $query = TransitionQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TransitionTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TransitionTableMap::buildTableMap();
