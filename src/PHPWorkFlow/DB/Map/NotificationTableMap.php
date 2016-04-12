<?php

namespace PHPWorkFlow\DB\Map;

use PHPWorkFlow\DB\Notification;
use PHPWorkFlow\DB\NotificationQuery;
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
 * This class defines the structure of the 'PHPWF_notification' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class NotificationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'PHPWorkFlow.DB.Map.NotificationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'PHPWorkFlow';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'PHPWF_notification';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\PHPWorkFlow\\DB\\Notification';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'PHPWorkFlow.DB.Notification';

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
     * the column name for the notification_id field
     */
    const COL_NOTIFICATION_ID = 'PHPWF_notification.notification_id';

    /**
     * the column name for the transition_id field
     */
    const COL_TRANSITION_ID = 'PHPWF_notification.transition_id';

    /**
     * the column name for the notification_type field
     */
    const COL_NOTIFICATION_TYPE = 'PHPWF_notification.notification_type';

    /**
     * the column name for the notification_string field
     */
    const COL_NOTIFICATION_STRING = 'PHPWF_notification.notification_string';

    /**
     * the column name for the created_at field
     */
    const COL_CREATED_AT = 'PHPWF_notification.created_at';

    /**
     * the column name for the created_by field
     */
    const COL_CREATED_BY = 'PHPWF_notification.created_by';

    /**
     * the column name for the modified_at field
     */
    const COL_MODIFIED_AT = 'PHPWF_notification.modified_at';

    /**
     * the column name for the modified_by field
     */
    const COL_MODIFIED_BY = 'PHPWF_notification.modified_by';

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
        self::TYPE_PHPNAME       => array('NotificationId', 'TransitionId', 'NotificationType', 'NotificationString', 'CreatedAt', 'CreatedBy', 'ModifiedAt', 'ModifiedBy', ),
        self::TYPE_CAMELNAME     => array('notificationId', 'transitionId', 'notificationType', 'notificationString', 'createdAt', 'createdBy', 'modifiedAt', 'modifiedBy', ),
        self::TYPE_COLNAME       => array(NotificationTableMap::COL_NOTIFICATION_ID, NotificationTableMap::COL_TRANSITION_ID, NotificationTableMap::COL_NOTIFICATION_TYPE, NotificationTableMap::COL_NOTIFICATION_STRING, NotificationTableMap::COL_CREATED_AT, NotificationTableMap::COL_CREATED_BY, NotificationTableMap::COL_MODIFIED_AT, NotificationTableMap::COL_MODIFIED_BY, ),
        self::TYPE_FIELDNAME     => array('notification_id', 'transition_id', 'notification_type', 'notification_string', 'created_at', 'created_by', 'modified_at', 'modified_by', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('NotificationId' => 0, 'TransitionId' => 1, 'NotificationType' => 2, 'NotificationString' => 3, 'CreatedAt' => 4, 'CreatedBy' => 5, 'ModifiedAt' => 6, 'ModifiedBy' => 7, ),
        self::TYPE_CAMELNAME     => array('notificationId' => 0, 'transitionId' => 1, 'notificationType' => 2, 'notificationString' => 3, 'createdAt' => 4, 'createdBy' => 5, 'modifiedAt' => 6, 'modifiedBy' => 7, ),
        self::TYPE_COLNAME       => array(NotificationTableMap::COL_NOTIFICATION_ID => 0, NotificationTableMap::COL_TRANSITION_ID => 1, NotificationTableMap::COL_NOTIFICATION_TYPE => 2, NotificationTableMap::COL_NOTIFICATION_STRING => 3, NotificationTableMap::COL_CREATED_AT => 4, NotificationTableMap::COL_CREATED_BY => 5, NotificationTableMap::COL_MODIFIED_AT => 6, NotificationTableMap::COL_MODIFIED_BY => 7, ),
        self::TYPE_FIELDNAME     => array('notification_id' => 0, 'transition_id' => 1, 'notification_type' => 2, 'notification_string' => 3, 'created_at' => 4, 'created_by' => 5, 'modified_at' => 6, 'modified_by' => 7, ),
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
        $this->setName('PHPWF_notification');
        $this->setPhpName('Notification');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\PHPWorkFlow\\DB\\Notification');
        $this->setPackage('PHPWorkFlow.DB');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('notification_id', 'NotificationId', 'INTEGER', true, null, null);
        $this->addForeignKey('transition_id', 'TransitionId', 'INTEGER', 'PHPWF_transition', 'transition_id', true, null, null);
        $this->addColumn('notification_type', 'NotificationType', 'VARCHAR', true, 32, null);
        $this->addColumn('notification_string', 'NotificationString', 'VARCHAR', true, 255, null);
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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('NotificationId', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('NotificationId', TableMap::TYPE_PHPNAME, $indexType)];
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
                : self::translateFieldName('NotificationId', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? NotificationTableMap::CLASS_DEFAULT : NotificationTableMap::OM_CLASS;
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
     * @return array           (Notification object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = NotificationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = NotificationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + NotificationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = NotificationTableMap::OM_CLASS;
            /** @var Notification $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            NotificationTableMap::addInstanceToPool($obj, $key);
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
            $key = NotificationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = NotificationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Notification $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                NotificationTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(NotificationTableMap::COL_NOTIFICATION_ID);
            $criteria->addSelectColumn(NotificationTableMap::COL_TRANSITION_ID);
            $criteria->addSelectColumn(NotificationTableMap::COL_NOTIFICATION_TYPE);
            $criteria->addSelectColumn(NotificationTableMap::COL_NOTIFICATION_STRING);
            $criteria->addSelectColumn(NotificationTableMap::COL_CREATED_AT);
            $criteria->addSelectColumn(NotificationTableMap::COL_CREATED_BY);
            $criteria->addSelectColumn(NotificationTableMap::COL_MODIFIED_AT);
            $criteria->addSelectColumn(NotificationTableMap::COL_MODIFIED_BY);
        } else {
            $criteria->addSelectColumn($alias . '.notification_id');
            $criteria->addSelectColumn($alias . '.transition_id');
            $criteria->addSelectColumn($alias . '.notification_type');
            $criteria->addSelectColumn($alias . '.notification_string');
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
        return Propel::getServiceContainer()->getDatabaseMap(NotificationTableMap::DATABASE_NAME)->getTable(NotificationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(NotificationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(NotificationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new NotificationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Notification or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Notification object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \PHPWorkFlow\DB\Notification) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(NotificationTableMap::DATABASE_NAME);
            $criteria->add(NotificationTableMap::COL_NOTIFICATION_ID, (array) $values, Criteria::IN);
        }

        $query = NotificationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            NotificationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                NotificationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the PHPWF_notification table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return NotificationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Notification or Criteria object.
     *
     * @param mixed               $criteria Criteria or Notification object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Notification object
        }

        if ($criteria->containsKey(NotificationTableMap::COL_NOTIFICATION_ID) && $criteria->keyContainsValue(NotificationTableMap::COL_NOTIFICATION_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.NotificationTableMap::COL_NOTIFICATION_ID.')');
        }


        // Set the correct dbName
        $query = NotificationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // NotificationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
NotificationTableMap::buildTableMap();
