<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\UseCaseContext;
use PHPWorkFlow\DB\UseCaseContextQuery;
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
 * This class defines the structure of the 'PHPWF_use_case_context' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class UseCaseContextTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.UseCaseContextTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_use_case_context';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\UseCaseContext';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.UseCaseContext';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 9;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 9;

    /**
     * the column name for the use_case_context_id field
     */
    const COL_USE_CASE_CONTEXT_ID = 'PHPWF_use_case_context.use_case_context_id';

    /**
     * the column name for the use_case_id field
     */
    const COL_USE_CASE_ID = 'PHPWF_use_case_context.use_case_id';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'PHPWF_use_case_context.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'PHPWF_use_case_context.description';

    /**
     * the column name for the value field
     */
    const COL_VALUE = 'PHPWF_use_case_context.value';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_use_case_context.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_use_case_context.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_use_case_context.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_use_case_context.modified_by';

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
        self::TYPE_PHPNAME       => array('UseCaseContextId', 'UseCaseId', 'Name', 'Description', 'Value', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('useCaseContextId', 'useCaseId', 'name', 'description', 'value', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, UseCaseContextTableMap::COL_USE_CASE_ID, UseCaseContextTableMap::COL_NAME, UseCaseContextTableMap::COL_DESCRIPTION, UseCaseContextTableMap::COL_VALUE, UseCaseContextTableMap::COL_CREATED_AT, UseCaseContextTableMap::COL_CREATED_BY, UseCaseContextTableMap::COL_MODIFIED_AT, UseCaseContextTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('use_case_context_id', 'use_case_id', 'name', 'description', 'value', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('UseCaseContextId' => 0, 'UseCaseId' => 1, 'Name' => 2, 'Description' => 3, 'Value' => 4, 'CreatedAt' => 5, 'CreatedBy' => 6, 'ModifiedAt' => 7, 'ModifiedBy' => 8, ),
        self::TYPE_CAMELNAME     => array('useCaseContextId' => 0, 'useCaseId' => 1, 'name' => 2, 'description' => 3, 'value' => 4, 'createdAt' => 5, 'createdBy' => 6, 'modifiedAt' => 7, 'modifiedBy' => 8, ),
        self::TYPE_COLNAME       => array(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID => 0, UseCaseContextTableMap::COL_USE_CASE_ID => 1, UseCaseContextTableMap::COL_NAME => 2, UseCaseContextTableMap::COL_DESCRIPTION => 3, UseCaseContextTableMap::COL_VALUE => 4, UseCaseContextTableMap::COL_CREATED_AT => 5, UseCaseContextTableMap::COL_CREATED_BY => 6, UseCaseContextTableMap::COL_MODIFIED_AT => 7, UseCaseContextTableMap::COL_MODIFIED_BY => 8, ),
        self::TYPE_FIELDNAME     => array('use_case_context_id' => 0, 'use_case_id' => 1, 'name' => 2, 'description' => 3, 'value' => 4, 'created_at' => 5, 'created_by' => 6, 'modified_at' => 7, 'modified_by' => 8, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $this->setName('PHPWF_use_case_context');
        $this->setPhpName('UseCaseContext');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\UseCaseContext');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('use_case_context_id', 'UseCaseContextId', 'INTEGER', true, null, null);
        $this->addForeignKey('use_case_id', 'UseCaseId', 'INTEGER', 'PHPWF_use_case', 'use_case_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('value', 'Value', 'VARCHAR', false, 255, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UseCaseContextId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('UseCaseContextId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('UseCaseContextId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? UseCaseContextTableMap::CLASS_DEFAULT : UseCaseContextTableMap::OM_CLASS;
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
     * @return array           (UseCaseContext object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = UseCaseContextTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = UseCaseContextTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + UseCaseContextTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = UseCaseContextTableMap::OM_CLASS;
            /** @var UseCaseContext $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            UseCaseContextTableMap::addInstanceToPool($obj, $key);
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
            $key = UseCaseContextTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = UseCaseContextTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var UseCaseContext $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                UseCaseContextTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_USE_CASE_ID);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_NAME);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_VALUE);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(UseCaseContextTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.use_case_context_id');
            $criteria->addSelectColumn($alias . '.use_case_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.value');
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
        return Propel::getServiceContainer()->getDatabaseMap(UseCaseContextTableMap::DATABASE_NAME)->getTable(UseCaseContextTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(UseCaseContextTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(UseCaseContextTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new UseCaseContextTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a UseCaseContext or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or UseCaseContext object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseContextTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\UseCaseContext) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(UseCaseContextTableMap::DATABASE_NAME);
            $criteria->add(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, (array) $values, Criteria::IN);
        }

        $query = UseCaseContextQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            UseCaseContextTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                UseCaseContextTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_use_case_context table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return UseCaseContextQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a UseCaseContext or Criteria object.
     *
     * @param mixed               $criteria Criteria or UseCaseContext object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseContextTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from UseCaseContext object
        }

        if ($criteria->containsKey(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID) && $criteria->keyContainsValue(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID.')');
        }


        // Set the correct dbName
        $query = UseCaseContextQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // UseCaseContextTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
UseCaseContextTableMap::buildTableMap();
