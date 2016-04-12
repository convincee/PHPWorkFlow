<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\Place;
use PHPWorkFlow\DB\PlaceQuery;
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
 * This class defines the structure of the 'PHPWF_place' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PlaceTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.PlaceTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_place';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\Place';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.Place';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 14;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 14;

    /**
     * the column name for the place_id field
     */
    const COL_PLACE_ID = 'PHPWF_place.place_id';

    /**
     * the column name for the work_flow_id field
     */
    const COL_WORK_FLOW_ID = 'PHPWF_place.work_flow_id';

    /**
     * the column name for the place_type field
     */
    const COL_PLACE_TYPE = 'PHPWF_place.place_type';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'PHPWF_place.name';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'PHPWF_place.description';

    /**
     * the column name for the position_x field
     */
    const COL_POSITION_X = 'PHPWF_place.position_x';

    /**
     * the column name for the position_y field
     */
    const COL_POSITION_Y = 'PHPWF_place.position_y';

    /**
     * the column name for the dimension_x field
     */
    const COL_DIMENSION_X = 'PHPWF_place.dimension_x';

    /**
     * the column name for the dimension_y field
     */
    const COL_DIMENSION_Y = 'PHPWF_place.dimension_y';

    /**
     * the column name for the yasper_name field
     */
    const COL_YASPER_NAME = 'PHPWF_place.yasper_name';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_place.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_place.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_place.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_place.modified_by';

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
        self::TYPE_PHPNAME       => array('PlaceId', 'WorkFlowId', 'PlaceType', 'Name', 'Description', 'PositionX', 'PositionY', 'DimensionX', 'DimensionY', 'YasperName', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('placeId', 'workFlowId', 'placeType', 'name', 'description', 'positionX', 'positionY', 'dimensionX', 'dimensionY', 'yasperName', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(PlaceTableMap::COL_PLACE_ID, PlaceTableMap::COL_WORK_FLOW_ID, PlaceTableMap::COL_PLACE_TYPE, PlaceTableMap::COL_NAME, PlaceTableMap::COL_DESCRIPTION, PlaceTableMap::COL_POSITION_X, PlaceTableMap::COL_POSITION_Y, PlaceTableMap::COL_DIMENSION_X, PlaceTableMap::COL_DIMENSION_Y, PlaceTableMap::COL_YASPER_NAME, PlaceTableMap::COL_CREATED_AT, PlaceTableMap::COL_CREATED_BY, PlaceTableMap::COL_MODIFIED_AT, PlaceTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('place_id', 'work_flow_id', 'place_type', 'name', 'description', 'position_x', 'position_y', 'dimension_x', 'dimension_y', 'yasper_name', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('PlaceId' => 0, 'WorkFlowId' => 1, 'PlaceType' => 2, 'Name' => 3, 'Description' => 4, 'PositionX' => 5, 'PositionY' => 6, 'DimensionX' => 7, 'DimensionY' => 8, 'YasperName' => 9, 'CreatedAt' => 10, 'CreatedBy' => 11, 'ModifiedAt' => 12, 'ModifiedBy' => 13, ),
        self::TYPE_CAMELNAME     => array('placeId' => 0, 'workFlowId' => 1, 'placeType' => 2, 'name' => 3, 'description' => 4, 'positionX' => 5, 'positionY' => 6, 'dimensionX' => 7, 'dimensionY' => 8, 'yasperName' => 9, 'createdAt' => 10, 'createdBy' => 11, 'modifiedAt' => 12, 'modifiedBy' => 13, ),
        self::TYPE_COLNAME       => array(PlaceTableMap::COL_PLACE_ID => 0, PlaceTableMap::COL_WORK_FLOW_ID => 1, PlaceTableMap::COL_PLACE_TYPE => 2, PlaceTableMap::COL_NAME => 3, PlaceTableMap::COL_DESCRIPTION => 4, PlaceTableMap::COL_POSITION_X => 5, PlaceTableMap::COL_POSITION_Y => 6, PlaceTableMap::COL_DIMENSION_X => 7, PlaceTableMap::COL_DIMENSION_Y => 8, PlaceTableMap::COL_YASPER_NAME => 9, PlaceTableMap::COL_CREATED_AT => 10, PlaceTableMap::COL_CREATED_BY => 11, PlaceTableMap::COL_MODIFIED_AT => 12, PlaceTableMap::COL_MODIFIED_BY => 13, ),
        self::TYPE_FIELDNAME     => array('place_id' => 0, 'work_flow_id' => 1, 'place_type' => 2, 'name' => 3, 'description' => 4, 'position_x' => 5, 'position_y' => 6, 'dimension_x' => 7, 'dimension_y' => 8, 'yasper_name' => 9, 'created_at' => 10, 'created_by' => 11, 'modified_at' => 12, 'modified_by' => 13, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
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
        $this->setName('PHPWF_place');
        $this->setPhpName('Place');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\Place');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('place_id', 'PlaceId', 'INTEGER', true, null, null);
        $this->addForeignKey('work_flow_id', 'WorkFlowId', 'INTEGER', 'PHPWF_work_flow', 'work_flow_id', true, null, null);
        $this->addColumn('place_type', 'PlaceType', 'VARCHAR', true, 32, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', true, 255, null);
        $this->addColumn('position_x', 'PositionX', 'INTEGER', true, null, 0);
        $this->addColumn('position_y', 'PositionY', 'INTEGER', true, null, 0);
        $this->addColumn('dimension_x', 'DimensionX', 'INTEGER', true, null, 0);
        $this->addColumn('dimension_y', 'DimensionY', 'INTEGER', true, null, 0);
        $this->addColumn('yasper_name', 'YasperName', 'VARCHAR', true, 255, null);
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
    0 => ':place_id',
    1 => ':place_id',
  ),
), 'CASCADE', 'CASCADE', 'Arcs', false);
        $this->addRelation('Token', '\\PHPWorkFlow\\DB\\Token', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':place_id',
    1 => ':place_id',
  ),
), 'CASCADE', 'CASCADE', 'Tokens', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to PHPWF_place     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ArcTableMap::clearInstancePool();
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PlaceId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('PlaceId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('PlaceId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? PlaceTableMap::CLASS_DEFAULT : PlaceTableMap::OM_CLASS;
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
     * @return array           (Place object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PlaceTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PlaceTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PlaceTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PlaceTableMap::OM_CLASS;
            /** @var Place $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PlaceTableMap::addInstanceToPool($obj, $key);
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
            $key = PlaceTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PlaceTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Place $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PlaceTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(PlaceTableMap::COL_PLACE_ID);
            $criteria->addSelectColumn(PlaceTableMap::COL_WORK_FLOW_ID);
            $criteria->addSelectColumn(PlaceTableMap::COL_PLACE_TYPE);
            $criteria->addSelectColumn(PlaceTableMap::COL_NAME);
            $criteria->addSelectColumn(PlaceTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(PlaceTableMap::COL_POSITION_X);
            $criteria->addSelectColumn(PlaceTableMap::COL_POSITION_Y);
            $criteria->addSelectColumn(PlaceTableMap::COL_DIMENSION_X);
            $criteria->addSelectColumn(PlaceTableMap::COL_DIMENSION_Y);
            $criteria->addSelectColumn(PlaceTableMap::COL_YASPER_NAME);
            $criteria->addSelectColumn(PlaceTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(PlaceTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(PlaceTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(PlaceTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.place_id');
            $criteria->addSelectColumn($alias . '.work_flow_id');
            $criteria->addSelectColumn($alias . '.place_type');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.position_x');
            $criteria->addSelectColumn($alias . '.position_y');
            $criteria->addSelectColumn($alias . '.dimension_x');
            $criteria->addSelectColumn($alias . '.dimension_y');
            $criteria->addSelectColumn($alias . '.yasper_name');
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
        return Propel::getServiceContainer()->getDatabaseMap(PlaceTableMap::DATABASE_NAME)->getTable(PlaceTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PlaceTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PlaceTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PlaceTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Place or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Place object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\Place) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PlaceTableMap::DATABASE_NAME);
            $criteria->add(PlaceTableMap::COL_PLACE_ID, (array) $values, Criteria::IN);
        }

        $query = PlaceQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PlaceTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PlaceTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_place table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PlaceQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Place or Criteria object.
     *
     * @param mixed               $criteria Criteria or Place object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Place object
        }

        if ($criteria->containsKey(PlaceTableMap::COL_PLACE_ID) && $criteria->keyContainsValue(PlaceTableMap::COL_PLACE_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PlaceTableMap::COL_PLACE_ID.')');
        }


        // Set the correct dbName
        $query = PlaceQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PlaceTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PlaceTableMap::buildTableMap();
