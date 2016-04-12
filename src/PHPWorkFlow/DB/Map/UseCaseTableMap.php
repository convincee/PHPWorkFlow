<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\UseCase;
use PHPWorkFlow\DB\UseCaseQuery;
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
 * This class defines the structure of the 'PHPWF_use_case' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UseCaseTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.UseCaseTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_use_case';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\UseCase';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.UseCase';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 13;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 13;

    /**
     * the column name for the use_case_id field
     */
    const COL_USE_CASE_ID = 'PHPWF_use_case.use_case_id';

    /**
     * the column name for the work_flow_id field
     */
    const COL_WORK_FLOW_ID = 'PHPWF_use_case.work_flow_id';

    /**
     * the column name for the parent_use_case_id field
     */
    const COL_PARENT_USE_CASE_ID = 'PHPWF_use_case.parent_use_case_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'PHPWF_use_case.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'PHPWF_use_case.description';

    /**
     * the column name for the use_case_group field
     */
    const COL_USE_CASE_GROUP = 'PHPWF_use_case.use_case_group';

    /**
     * the column name for the use_case_status field
     */
    const COL_USE_CASE_STATUS = 'PHPWF_use_case.use_case_status';

    /**
     * the column name for the start_date field
     */
    const COL_START_DATE = 'PHPWF_use_case.start_date';

    /**
     * the column name for the end_date field
     */
    const COL_END_DATE = 'PHPWF_use_case.end_date';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_use_case.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_use_case.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_use_case.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_use_case.modified_by';

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
        self::TYPE_PHPNAME       => array('UseCaseId', 'WorkFlowId', 'ParentUseCaseId', 'Name', 'Description', 'UseCaseGroup', 'UseCaseStatus', 'StartDate', 'EndDate', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('useCaseId', 'workFlowId', 'parentUseCaseId', 'name', 'description', 'useCaseGroup', 'useCaseStatus', 'startDate', 'endDate', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(UseCaseTableMap::COL_USE_CASE_ID, UseCaseTableMap::COL_WORK_FLOW_ID, UseCaseTableMap::COL_PARENT_USE_CASE_ID, UseCaseTableMap::COL_NAME, UseCaseTableMap::COL_DESCRIPTION, UseCaseTableMap::COL_USE_CASE_GROUP, UseCaseTableMap::COL_USE_CASE_STATUS, UseCaseTableMap::COL_START_DATE, UseCaseTableMap::COL_END_DATE, UseCaseTableMap::COL_CREATED_AT, UseCaseTableMap::COL_CREATED_BY, UseCaseTableMap::COL_MODIFIED_AT, UseCaseTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('use_case_id', 'work_flow_id', 'parent_use_case_id', 'name', 'description', 'use_case_group', 'use_case_status', 'start_date', 'end_date', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('UseCaseId' => 0, 'WorkFlowId' => 1, 'ParentUseCaseId' => 2, 'Name' => 3, 'Description' => 4, 'UseCaseGroup' => 5, 'UseCaseStatus' => 6, 'StartDate' => 7, 'EndDate' => 8, 'CreatedAt' => 9, 'CreatedBy' => 10, 'ModifiedAt' => 11, 'ModifiedBy' => 12, ),
        self::TYPE_CAMELNAME     => array('useCaseId' => 0, 'workFlowId' => 1, 'parentUseCaseId' => 2, 'name' => 3, 'description' => 4, 'useCaseGroup' => 5, 'useCaseStatus' => 6, 'startDate' => 7, 'endDate' => 8, 'createdAt' => 9, 'createdBy' => 10, 'modifiedAt' => 11, 'modifiedBy' => 12, ),
        self::TYPE_COLNAME       => array(UseCaseTableMap::COL_USE_CASE_ID => 0, UseCaseTableMap::COL_WORK_FLOW_ID => 1, UseCaseTableMap::COL_PARENT_USE_CASE_ID => 2, UseCaseTableMap::COL_NAME => 3, UseCaseTableMap::COL_DESCRIPTION => 4, UseCaseTableMap::COL_USE_CASE_GROUP => 5, UseCaseTableMap::COL_USE_CASE_STATUS => 6, UseCaseTableMap::COL_START_DATE => 7, UseCaseTableMap::COL_END_DATE => 8, UseCaseTableMap::COL_CREATED_AT => 9, UseCaseTableMap::COL_CREATED_BY => 10, UseCaseTableMap::COL_MODIFIED_AT => 11, UseCaseTableMap::COL_MODIFIED_BY => 12, ),
        self::TYPE_FIELDNAME     => array('use_case_id' => 0, 'work_flow_id' => 1, 'parent_use_case_id' => 2, 'name' => 3, 'description' => 4, 'use_case_group' => 5, 'use_case_status' => 6, 'start_date' => 7, 'end_date' => 8, 'created_at' => 9, 'created_by' => 10, 'modified_at' => 11, 'modified_by' => 12, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
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
        $this->setName('PHPWF_use_case');
        $this->setPhpName('UseCase');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\UseCase');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('use_case_id', 'UseCaseId', 'INTEGER', true, null, null);
        $this->addForeignKey('work_flow_id', 'WorkFlowId', 'INTEGER', 'PHPWF_work_flow', 'work_flow_id', true, null, null);
        $this->addForeignKey('parent_use_case_id', 'ParentUseCaseId', 'INTEGER', 'PHPWF_use_case', 'use_case_id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('use_case_group', 'UseCaseGroup', 'VARCHAR', false, 255, null);
        $this->addColumn('use_case_status', 'UseCaseStatus', 'VARCHAR', true, 255, null);
        $this->addColumn('start_date', 'StartDate', 'TIMESTAMP', true, null, null);
        $this->addColumn('end_date', 'EndDate', 'TIMESTAMP', true, null, null);
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
        $this->addRelation('UseCaseRelatedByParentUseCaseId', '\\PHPWorkFlow\\DB\\UseCase', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent_use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('WorkFlow', '\\PHPWorkFlow\\DB\\WorkFlow', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':work_flow_id',
    1 => ':work_flow_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Token', '\\PHPWorkFlow\\DB\\Token', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', 'Tokens', false);
        $this->addRelation('TriggerFulfillment', '\\PHPWorkFlow\\DB\\TriggerFulfillment', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', 'TriggerFulfillments', false);
        $this->addRelation('UseCaseRelatedByUseCaseId', '\\PHPWorkFlow\\DB\\UseCase', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent_use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', 'UseCasesRelatedByUseCaseId', false);
        $this->addRelation('UseCaseContext', '\\PHPWorkFlow\\DB\\UseCaseContext', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', 'UseCaseContexts', false);
        $this->addRelation('WorkItem', '\\PHPWorkFlow\\DB\\WorkItem', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':use_case_id',
    1 => ':use_case_id',
  ),
), 'CASCADE', 'CASCADE', 'WorkItems', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to PHPWF_use_case     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        TokenTableMap::clearInstancePool();
        TriggerFulfillmentTableMap::clearInstancePool();
        UseCaseTableMap::clearInstancePool();
        UseCaseContextTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UseCaseId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UseCaseId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('UseCaseId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UseCaseTableMap::CLASS_DEFAULT : UseCaseTableMap::OM_CLASS;
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
     * @return array           (UseCase object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UseCaseTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UseCaseTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UseCaseTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UseCaseTableMap::OM_CLASS;
            /** @var UseCase $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UseCaseTableMap::addInstanceToPool($obj, $key);
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
            $key = UseCaseTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UseCaseTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UseCase $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UseCaseTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UseCaseTableMap::COL_USE_CASE_ID);
            $criteria->addSelectColumn(UseCaseTableMap::COL_WORK_FLOW_ID);
            $criteria->addSelectColumn(UseCaseTableMap::COL_PARENT_USE_CASE_ID);
            $criteria->addSelectColumn(UseCaseTableMap::COL_NAME);
            $criteria->addSelectColumn(UseCaseTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(UseCaseTableMap::COL_USE_CASE_GROUP);
            $criteria->addSelectColumn(UseCaseTableMap::COL_USE_CASE_STATUS);
            $criteria->addSelectColumn(UseCaseTableMap::COL_START_DATE);
            $criteria->addSelectColumn(UseCaseTableMap::COL_END_DATE);
            $criteria->addSelectColumn(UseCaseTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UseCaseTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(UseCaseTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(UseCaseTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.use_case_id');
            $criteria->addSelectColumn($alias . '.work_flow_id');
            $criteria->addSelectColumn($alias . '.parent_use_case_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.use_case_group');
            $criteria->addSelectColumn($alias . '.use_case_status');
            $criteria->addSelectColumn($alias . '.start_date');
            $criteria->addSelectColumn($alias . '.end_date');
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
        return Propel::getServiceContainer()->getDatabaseMap(UseCaseTableMap::DATABASE_NAME)->getTable(UseCaseTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UseCaseTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UseCaseTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UseCaseTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UseCase or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UseCase object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\UseCase) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UseCaseTableMap::DATABASE_NAME);
            $criteria->add(UseCaseTableMap::COL_USE_CASE_ID, (array) $values, Criteria::IN);
        }

        $query = UseCaseQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UseCaseTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UseCaseTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_use_case table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UseCaseQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UseCase or Criteria object.
     *
     * @param mixed               $criteria Criteria or UseCase object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UseCase object
        }

        if ($criteria->containsKey(UseCaseTableMap::COL_USE_CASE_ID) && $criteria->keyContainsValue(UseCaseTableMap::COL_USE_CASE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UseCaseTableMap::COL_USE_CASE_ID.')');
        }


        // Set the correct dbName
        $query = UseCaseQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UseCaseTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UseCaseTableMap::buildTableMap();
