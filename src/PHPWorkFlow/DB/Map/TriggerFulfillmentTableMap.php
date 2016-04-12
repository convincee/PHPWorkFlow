<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\TriggerFulfillment;
use PHPWorkFlow\DB\TriggerFulfillmentQuery;
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
 * This class defines the structure of the 'PHPWF_trigger_fulfillment' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class TriggerFulfillmentTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.TriggerFulfillmentTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_trigger_fulfillment';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\TriggerFulfillment';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.TriggerFulfillment';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 8;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 8;

    /**
     * the column name for the trigger_fulfillment_id field
     */
    const COL_TRIGGER_FULFILLMENT_ID = 'PHPWF_trigger_fulfillment.trigger_fulfillment_id';

    /**
     * the column name for the use_case_id field
     */
    const COL_USE_CASE_ID = 'PHPWF_trigger_fulfillment.use_case_id';

    /**
     * the column name for the transition_id field
     */
    const COL_TRANSITION_ID = 'PHPWF_trigger_fulfillment.transition_id';

    /**
     * the column name for the trigger_fulfillment_status field
     */
    const COL_TRIGGER_FULFILLMENT_STATUS = 'PHPWF_trigger_fulfillment.trigger_fulfillment_status';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_trigger_fulfillment.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_trigger_fulfillment.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_trigger_fulfillment.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_trigger_fulfillment.modified_by';

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
        self::TYPE_PHPNAME       => array('TriggerFulfillmentId', 'UseCaseId', 'TransitionId', 'TriggerFulfillmentStatus', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('triggerFulfillmentId', 'useCaseId', 'transitionId', 'triggerFulfillmentStatus', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, TriggerFulfillmentTableMap::COL_USE_CASE_ID, TriggerFulfillmentTableMap::COL_TRANSITION_ID, TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_STATUS, TriggerFulfillmentTableMap::COL_CREATED_AT, TriggerFulfillmentTableMap::COL_CREATED_BY, TriggerFulfillmentTableMap::COL_MODIFIED_AT, TriggerFulfillmentTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('trigger_fulfillment_id', 'use_case_id', 'transition_id', 'trigger_fulfillment_status', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('TriggerFulfillmentId' => 0, 'UseCaseId' => 1, 'TransitionId' => 2, 'TriggerFulfillmentStatus' => 3, 'CreatedAt' => 4, 'CreatedBy' => 5, 'ModifiedAt' => 6, 'ModifiedBy' => 7, ),
        self::TYPE_CAMELNAME     => array('triggerFulfillmentId' => 0, 'useCaseId' => 1, 'transitionId' => 2, 'triggerFulfillmentStatus' => 3, 'createdAt' => 4, 'createdBy' => 5, 'modifiedAt' => 6, 'modifiedBy' => 7, ),
        self::TYPE_COLNAME       => array(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID => 0, TriggerFulfillmentTableMap::COL_USE_CASE_ID => 1, TriggerFulfillmentTableMap::COL_TRANSITION_ID => 2, TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_STATUS => 3, TriggerFulfillmentTableMap::COL_CREATED_AT => 4, TriggerFulfillmentTableMap::COL_CREATED_BY => 5, TriggerFulfillmentTableMap::COL_MODIFIED_AT => 6, TriggerFulfillmentTableMap::COL_MODIFIED_BY => 7, ),
        self::TYPE_FIELDNAME     => array('trigger_fulfillment_id' => 0, 'use_case_id' => 1, 'transition_id' => 2, 'trigger_fulfillment_status' => 3, 'created_at' => 4, 'created_by' => 5, 'modified_at' => 6, 'modified_by' => 7, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
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
        $this->setName('PHPWF_trigger_fulfillment');
        $this->setPhpName('TriggerFulfillment');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\TriggerFulfillment');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('trigger_fulfillment_id', 'TriggerFulfillmentId', 'INTEGER', true, null, null);
        $this->addForeignKey('use_case_id', 'UseCaseId', 'INTEGER', 'PHPWF_use_case', 'use_case_id', true, null, null);
        $this->addForeignKey('transition_id', 'TransitionId', 'INTEGER', 'PHPWF_transition', 'transition_id', true, null, null);
        $this->addColumn('trigger_fulfillment_status', 'TriggerFulfillmentStatus', 'VARCHAR', true, 32, null);
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
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TriggerFulfillmentId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('TriggerFulfillmentId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('TriggerFulfillmentId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? TriggerFulfillmentTableMap::CLASS_DEFAULT : TriggerFulfillmentTableMap::OM_CLASS;
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
     * @return array           (TriggerFulfillment object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = TriggerFulfillmentTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = TriggerFulfillmentTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + TriggerFulfillmentTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = TriggerFulfillmentTableMap::OM_CLASS;
            /** @var TriggerFulfillment $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            TriggerFulfillmentTableMap::addInstanceToPool($obj, $key);
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
            $key = TriggerFulfillmentTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = TriggerFulfillmentTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var TriggerFulfillment $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                TriggerFulfillmentTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_USE_CASE_ID);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_TRANSITION_ID);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_STATUS);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(TriggerFulfillmentTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.trigger_fulfillment_id');
            $criteria->addSelectColumn($alias . '.use_case_id');
            $criteria->addSelectColumn($alias . '.transition_id');
            $criteria->addSelectColumn($alias . '.trigger_fulfillment_status');
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
        return Propel::getServiceContainer()->getDatabaseMap(TriggerFulfillmentTableMap::DATABASE_NAME)->getTable(TriggerFulfillmentTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(TriggerFulfillmentTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(TriggerFulfillmentTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new TriggerFulfillmentTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a TriggerFulfillment or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or TriggerFulfillment object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerFulfillmentTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\TriggerFulfillment) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(TriggerFulfillmentTableMap::DATABASE_NAME);
            $criteria->add(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, (array) $values, Criteria::IN);
        }

        $query = TriggerFulfillmentQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            TriggerFulfillmentTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                TriggerFulfillmentTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_trigger_fulfillment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return TriggerFulfillmentQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a TriggerFulfillment or Criteria object.
     *
     * @param mixed               $criteria Criteria or TriggerFulfillment object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerFulfillmentTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from TriggerFulfillment object
        }

        if ($criteria->containsKey(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID) && $criteria->keyContainsValue(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID.')');
        }


        // Set the correct dbName
        $query = TriggerFulfillmentQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // TriggerFulfillmentTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
TriggerFulfillmentTableMap::buildTableMap();
