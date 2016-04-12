<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\WorkItem;
use PHPWorkFlow\DB\WorkItemQuery;
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
 * This class defines the structure of the 'PHPWF_work_item' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class WorkItemTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.WorkItemTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_work_item';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\WorkItem';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.WorkItem';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 11;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 11;

    /**
     * the column name for the work_item_id field
     */
    const COL_WORK_ITEM_ID = 'PHPWF_work_item.work_item_id';

    /**
     * the column name for the use_case_id field
     */
    const COL_USE_CASE_ID = 'PHPWF_work_item.use_case_id';

    /**
     * the column name for the transition_id field
     */
    const COL_TRANSITION_ID = 'PHPWF_work_item.transition_id';

    /**
     * the column name for the work_item_status field
     */
    const COL_WORK_ITEM_STATUS = 'PHPWF_work_item.work_item_status';

    /**
     * the column name for the enabled_date field
     */
    const COL_ENABLED_DATE = 'PHPWF_work_item.enabled_date';

    /**
     * the column name for the cancelled_date field
     */
    const COL_CANCELLED_DATE = 'PHPWF_work_item.cancelled_date';

    /**
     * the column name for the finished_date field
     */
    const COL_FINISHED_DATE = 'PHPWF_work_item.finished_date';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_work_item.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_work_item.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_work_item.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_work_item.modified_by';

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
        self::TYPE_PHPNAME       => array('WorkItemId', 'UseCaseId', 'TransitionId', 'WorkItemStatus', 'EnabledDate', 'CancelledDate', 'FinishedDate', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('workItemId', 'useCaseId', 'transitionId', 'workItemStatus', 'enabledDate', 'cancelledDate', 'finishedDate', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(WorkItemTableMap::COL_WORK_ITEM_ID, WorkItemTableMap::COL_USE_CASE_ID, WorkItemTableMap::COL_TRANSITION_ID, WorkItemTableMap::COL_WORK_ITEM_STATUS, WorkItemTableMap::COL_ENABLED_DATE, WorkItemTableMap::COL_CANCELLED_DATE, WorkItemTableMap::COL_FINISHED_DATE, WorkItemTableMap::COL_CREATED_AT, WorkItemTableMap::COL_CREATED_BY, WorkItemTableMap::COL_MODIFIED_AT, WorkItemTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('work_item_id', 'use_case_id', 'transition_id', 'work_item_status', 'enabled_date', 'cancelled_date', 'finished_date', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('WorkItemId' => 0, 'UseCaseId' => 1, 'TransitionId' => 2, 'WorkItemStatus' => 3, 'EnabledDate' => 4, 'CancelledDate' => 5, 'FinishedDate' => 6, 'CreatedAt' => 7, 'CreatedBy' => 8, 'ModifiedAt' => 9, 'ModifiedBy' => 10, ),
        self::TYPE_CAMELNAME     => array('workItemId' => 0, 'useCaseId' => 1, 'transitionId' => 2, 'workItemStatus' => 3, 'enabledDate' => 4, 'cancelledDate' => 5, 'finishedDate' => 6, 'createdAt' => 7, 'createdBy' => 8, 'modifiedAt' => 9, 'modifiedBy' => 10, ),
        self::TYPE_COLNAME       => array(WorkItemTableMap::COL_WORK_ITEM_ID => 0, WorkItemTableMap::COL_USE_CASE_ID => 1, WorkItemTableMap::COL_TRANSITION_ID => 2, WorkItemTableMap::COL_WORK_ITEM_STATUS => 3, WorkItemTableMap::COL_ENABLED_DATE => 4, WorkItemTableMap::COL_CANCELLED_DATE => 5, WorkItemTableMap::COL_FINISHED_DATE => 6, WorkItemTableMap::COL_CREATED_AT => 7, WorkItemTableMap::COL_CREATED_BY => 8, WorkItemTableMap::COL_MODIFIED_AT => 9, WorkItemTableMap::COL_MODIFIED_BY => 10, ),
        self::TYPE_FIELDNAME     => array('work_item_id' => 0, 'use_case_id' => 1, 'transition_id' => 2, 'work_item_status' => 3, 'enabled_date' => 4, 'cancelled_date' => 5, 'finished_date' => 6, 'created_at' => 7, 'created_by' => 8, 'modified_at' => 9, 'modified_by' => 10, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, )
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
        $this->setName('PHPWF_work_item');
        $this->setPhpName('WorkItem');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\WorkItem');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('work_item_id', 'WorkItemId', 'INTEGER', true, null, null);
        $this->addForeignKey('use_case_id', 'UseCaseId', 'INTEGER', 'PHPWF_use_case', 'use_case_id', true, null, null);
        $this->addForeignKey('transition_id', 'TransitionId', 'INTEGER', 'PHPWF_transition', 'transition_id', true, null, null);
        $this->addForeignKey('transition_id', 'TransitionId', 'INTEGER', 'PHPWF_arc', 'transition_id', true, null, null);
        $this->addColumn('work_item_status', 'WorkItemStatus', 'VARCHAR', true, 255, null);
        $this->addColumn('enabled_date', 'EnabledDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('cancelled_date', 'CancelledDate', 'TIMESTAMP', false, null, null);
        $this->addColumn('finished_date', 'FinishedDate', 'TIMESTAMP', false, null, null);
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
        $this->addRelation('UseCase', '\\PHPWorkFlow\\DB\\UseCase', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Transition', '\\PHPWorkFlow\\DB\\Transition', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Arc', '\\PHPWorkFlow\\DB\\Arc', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('CreatingWorkItem', '\\PHPWorkFlow\\DB\\Token', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':creating_work_item_id',
    1 => ':work_item_id',
  ),
), 'CASCADE', 'CASCADE', 'CreatingWorkItems', false);
        $this->addRelation('ConsumingWorkItem', '\\PHPWorkFlow\\DB\\Token', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':consuming_work_item_id',
    1 => ':work_item_id',
  ),
), 'CASCADE', 'CASCADE', 'ConsumingWorkItems', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to PHPWF_work_item     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        TokenTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('WorkItemId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('WorkItemId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('WorkItemId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? WorkItemTableMap::CLASS_DEFAULT : WorkItemTableMap::OM_CLASS;
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
     * @return array           (WorkItem object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = WorkItemTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = WorkItemTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + WorkItemTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = WorkItemTableMap::OM_CLASS;
            /** @var WorkItem $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            WorkItemTableMap::addInstanceToPool($obj, $key);
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
            $key = WorkItemTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = WorkItemTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var WorkItem $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                WorkItemTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(WorkItemTableMap::COL_WORK_ITEM_ID);
            $criteria->addSelectColumn(WorkItemTableMap::COL_USE_CASE_ID);
            $criteria->addSelectColumn(WorkItemTableMap::COL_TRANSITION_ID);
            $criteria->addSelectColumn(WorkItemTableMap::COL_WORK_ITEM_STATUS);
            $criteria->addSelectColumn(WorkItemTableMap::COL_ENABLED_DATE);
            $criteria->addSelectColumn(WorkItemTableMap::COL_CANCELLED_DATE);
            $criteria->addSelectColumn(WorkItemTableMap::COL_FINISHED_DATE);
            $criteria->addSelectColumn(WorkItemTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(WorkItemTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(WorkItemTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(WorkItemTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.work_item_id');
            $criteria->addSelectColumn($alias . '.use_case_id');
            $criteria->addSelectColumn($alias . '.transition_id');
            $criteria->addSelectColumn($alias . '.work_item_status');
            $criteria->addSelectColumn($alias . '.enabled_date');
            $criteria->addSelectColumn($alias . '.cancelled_date');
            $criteria->addSelectColumn($alias . '.finished_date');
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
        return Propel::getServiceContainer()->getDatabaseMap(WorkItemTableMap::DATABASE_NAME)->getTable(WorkItemTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(WorkItemTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(WorkItemTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new WorkItemTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a WorkItem or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or WorkItem object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(WorkItemTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\WorkItem) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(WorkItemTableMap::DATABASE_NAME);
            $criteria->add(WorkItemTableMap::COL_WORK_ITEM_ID, (array) $values, Criteria::IN);
        }

        $query = WorkItemQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            WorkItemTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                WorkItemTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_work_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return WorkItemQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a WorkItem or Criteria object.
     *
     * @param mixed               $criteria Criteria or WorkItem object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WorkItemTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from WorkItem object
        }

        if ($criteria->containsKey(WorkItemTableMap::COL_WORK_ITEM_ID) && $criteria->keyContainsValue(WorkItemTableMap::COL_WORK_ITEM_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.WorkItemTableMap::COL_WORK_ITEM_ID.')');
        }


        // Set the correct dbName
        $query = WorkItemQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // WorkItemTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
WorkItemTableMap::buildTableMap();
