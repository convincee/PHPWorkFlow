<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\Arc;
use PHPWorkFlow\DB\ArcQuery;
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
 * This class defines the structure of the 'PHPWF_arc' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class ArcTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.ArcTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_arc';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\Arc';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.Arc';

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
     * the column name for the arc_id field
     */
    const COL_ARC_ID = 'PHPWF_arc.arc_id';

    /**
     * the column name for the work_flow_id field
     */
    const COL_WORK_FLOW_ID = 'PHPWF_arc.work_flow_id';

    /**
     * the column name for the transition_id field
     */
    const COL_TRANSITION_ID = 'PHPWF_arc.transition_id';

    /**
     * the column name for the place_id field
     */
    const COL_PLACE_ID = 'PHPWF_arc.place_id';

    /**
     * the column name for the direction field
     */
    const COL_DIRECTION = 'PHPWF_arc.direction';

    /**
     * the column name for the arc_type field
     */
    const COL_ARC_TYPE = 'PHPWF_arc.arc_type';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'PHPWF_arc.description';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'PHPWF_arc.name';

    /**
     * the column name for the yasper_name field
     */
    const COL_YASPER_NAME = 'PHPWF_arc.yasper_name';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_arc.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_arc.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_arc.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_arc.modified_by';

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
        self::TYPE_PHPNAME       => array('ArcId', 'WorkFlowId', 'TransitionId', 'PlaceId', 'Direction', 'ArcType', 'Description', 'Name', 'YasperName', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('arcId', 'workFlowId', 'transitionId', 'placeId', 'direction', 'arcType', 'description', 'name', 'yasperName', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(ArcTableMap::COL_ARC_ID, ArcTableMap::COL_WORK_FLOW_ID, ArcTableMap::COL_TRANSITION_ID, ArcTableMap::COL_PLACE_ID, ArcTableMap::COL_DIRECTION, ArcTableMap::COL_ARC_TYPE, ArcTableMap::COL_DESCRIPTION, ArcTableMap::COL_NAME, ArcTableMap::COL_YASPER_NAME, ArcTableMap::COL_CREATED_AT, ArcTableMap::COL_CREATED_BY, ArcTableMap::COL_MODIFIED_AT, ArcTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('arc_id', 'work_flow_id', 'transition_id', 'place_id', 'direction', 'arc_type', 'description', 'name', 'yasper_name', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('ArcId' => 0, 'WorkFlowId' => 1, 'TransitionId' => 2, 'PlaceId' => 3, 'Direction' => 4, 'ArcType' => 5, 'Description' => 6, 'Name' => 7, 'YasperName' => 8, 'CreatedAt' => 9, 'CreatedBy' => 10, 'ModifiedAt' => 11, 'ModifiedBy' => 12, ),
        self::TYPE_CAMELNAME     => array('arcId' => 0, 'workFlowId' => 1, 'transitionId' => 2, 'placeId' => 3, 'direction' => 4, 'arcType' => 5, 'description' => 6, 'name' => 7, 'yasperName' => 8, 'createdAt' => 9, 'createdBy' => 10, 'modifiedAt' => 11, 'modifiedBy' => 12, ),
        self::TYPE_COLNAME       => array(ArcTableMap::COL_ARC_ID => 0, ArcTableMap::COL_WORK_FLOW_ID => 1, ArcTableMap::COL_TRANSITION_ID => 2, ArcTableMap::COL_PLACE_ID => 3, ArcTableMap::COL_DIRECTION => 4, ArcTableMap::COL_ARC_TYPE => 5, ArcTableMap::COL_DESCRIPTION => 6, ArcTableMap::COL_NAME => 7, ArcTableMap::COL_YASPER_NAME => 8, ArcTableMap::COL_CREATED_AT => 9, ArcTableMap::COL_CREATED_BY => 10, ArcTableMap::COL_MODIFIED_AT => 11, ArcTableMap::COL_MODIFIED_BY => 12, ),
        self::TYPE_FIELDNAME     => array('arc_id' => 0, 'work_flow_id' => 1, 'transition_id' => 2, 'place_id' => 3, 'direction' => 4, 'arc_type' => 5, 'description' => 6, 'name' => 7, 'yasper_name' => 8, 'created_at' => 9, 'created_by' => 10, 'modified_at' => 11, 'modified_by' => 12, ),
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
        $this->setName('PHPWF_arc');
        $this->setPhpName('Arc');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\Arc');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('arc_id', 'ArcId', 'INTEGER', true, null, null);
        $this->addForeignKey('work_flow_id', 'WorkFlowId', 'INTEGER', 'PHPWF_work_flow', 'work_flow_id', true, null, null);
        $this->addForeignKey('transition_id', 'TransitionId', 'INTEGER', 'PHPWF_transition', 'transition_id', true, null, null);
        $this->addForeignKey('place_id', 'PlaceId', 'INTEGER', 'PHPWF_place', 'place_id', true, null, null);
        $this->addColumn('direction', 'Direction', 'VARCHAR', true, 255, null);
        $this->addColumn('arc_type', 'ArcType', 'VARCHAR', true, 32, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
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
        $this->addRelation('Transition', '\\PHPWorkFlow\\DB\\Transition', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('Place', '\\PHPWorkFlow\\DB\\Place', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':place_id',
    1 => ':place_id',
  ),
), 'CASCADE', 'CASCADE', null, false);
        $this->addRelation('WorkItem', '\\PHPWorkFlow\\DB\\WorkItem', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':transition_id',
    1 => ':transition_id',
  ),
), 'CASCADE', 'CASCADE', 'WorkItems', false);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to PHPWF_arc     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ArcId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('ArcId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('ArcId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? ArcTableMap::CLASS_DEFAULT : ArcTableMap::OM_CLASS;
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
     * @return array           (Arc object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = ArcTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = ArcTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + ArcTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ArcTableMap::OM_CLASS;
            /** @var Arc $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            ArcTableMap::addInstanceToPool($obj, $key);
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
            $key = ArcTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = ArcTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Arc $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ArcTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(ArcTableMap::COL_ARC_ID);
            $criteria->addSelectColumn(ArcTableMap::COL_WORK_FLOW_ID);
            $criteria->addSelectColumn(ArcTableMap::COL_TRANSITION_ID);
            $criteria->addSelectColumn(ArcTableMap::COL_PLACE_ID);
            $criteria->addSelectColumn(ArcTableMap::COL_DIRECTION);
            $criteria->addSelectColumn(ArcTableMap::COL_ARC_TYPE);
            $criteria->addSelectColumn(ArcTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(ArcTableMap::COL_NAME);
            $criteria->addSelectColumn(ArcTableMap::COL_YASPER_NAME);
            $criteria->addSelectColumn(ArcTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(ArcTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(ArcTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(ArcTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.arc_id');
            $criteria->addSelectColumn($alias . '.work_flow_id');
            $criteria->addSelectColumn($alias . '.transition_id');
            $criteria->addSelectColumn($alias . '.place_id');
            $criteria->addSelectColumn($alias . '.direction');
            $criteria->addSelectColumn($alias . '.arc_type');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.name');
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
        return Propel::getServiceContainer()->getDatabaseMap(ArcTableMap::DATABASE_NAME)->getTable(ArcTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(ArcTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(ArcTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new ArcTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Arc or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Arc object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(ArcTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\Arc) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ArcTableMap::DATABASE_NAME);
            $criteria->add(ArcTableMap::COL_ARC_ID, (array) $values, Criteria::IN);
        }

        $query = ArcQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            ArcTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                ArcTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_arc table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return ArcQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Arc or Criteria object.
     *
     * @param mixed               $criteria Criteria or Arc object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArcTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Arc object
        }

        if ($criteria->containsKey(ArcTableMap::COL_ARC_ID) && $criteria->keyContainsValue(ArcTableMap::COL_ARC_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ArcTableMap::COL_ARC_ID.')');
        }


        // Set the correct dbName
        $query = ArcQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // ArcTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
ArcTableMap::buildTableMap();
