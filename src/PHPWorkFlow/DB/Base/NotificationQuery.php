<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\Notification as ChildNotification;
use PHPWorkFlow\DB\NotificationQuery as ChildNotificationQuery;
use PHPWorkFlow\DB\Map\NotificationTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_notification' table.
 *
 *
 *
 * @method     ChildNotificationQuery orderByNotificationId($order = Criteria::ASC) Order by the notification_id column
 * @method     ChildNotificationQuery orderByTransitionId($order = Criteria::ASC) Order by the transition_id column
 * @method     ChildNotificationQuery orderByNotificationType($order = Criteria::ASC) Order by the notification_type column
 * @method     ChildNotificationQuery orderByNotificationString($order = Criteria::ASC) Order by the notification_string column
 * @method     ChildNotificationQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildNotificationQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildNotificationQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildNotificationQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildNotificationQuery groupByNotificationId() Group by the notification_id column
 * @method     ChildNotificationQuery groupByTransitionId() Group by the transition_id column
 * @method     ChildNotificationQuery groupByNotificationType() Group by the notification_type column
 * @method     ChildNotificationQuery groupByNotificationString() Group by the notification_string column
 * @method     ChildNotificationQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildNotificationQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildNotificationQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildNotificationQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildNotificationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildNotificationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildNotificationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildNotificationQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildNotificationQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildNotificationQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildNotificationQuery leftJoinTransition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transition relation
 * @method     ChildNotificationQuery rightJoinTransition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transition relation
 * @method     ChildNotificationQuery innerJoinTransition($relationAlias = null) Adds a INNER JOIN clause to the query using the Transition relation
 *
 * @method     ChildNotificationQuery joinWithTransition($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transition relation
 *
 * @method     ChildNotificationQuery leftJoinWithTransition() Adds a LEFT JOIN clause and with to the query using the Transition relation
 * @method     ChildNotificationQuery rightJoinWithTransition() Adds a RIGHT JOIN clause and with to the query using the Transition relation
 * @method     ChildNotificationQuery innerJoinWithTransition() Adds a INNER JOIN clause and with to the query using the Transition relation
 *
 * @method     \PHPWorkFlow\DB\TransitionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildNotification findOne(ConnectionInterface $con = null) Return the first ChildNotification matching the query
 * @method     ChildNotification findOneOrCreate(ConnectionInterface $con = null) Return the first ChildNotification matching the query, or a new ChildNotification object populated from the query conditions when no match is found
 *
 * @method     ChildNotification findOneByNotificationId(int $notification_id) Return the first ChildNotification filtered by the notification_id column
 * @method     ChildNotification findOneByTransitionId(int $transition_id) Return the first ChildNotification filtered by the transition_id column
 * @method     ChildNotification findOneByNotificationType(string $notification_type) Return the first ChildNotification filtered by the notification_type column
 * @method     ChildNotification findOneByNotificationString(string $notification_string) Return the first ChildNotification filtered by the notification_string column
 * @method     ChildNotification findOneByCreatedAt(string $created_at) Return the first ChildNotification filtered by the created_at column
 * @method     ChildNotification findOneByCreatedBy(int $created_by) Return the first ChildNotification filtered by the created_by column
 * @method     ChildNotification findOneByModifiedAt(string $modified_at) Return the first ChildNotification filtered by the modified_at column
 * @method     ChildNotification findOneByModifiedBy(int $modified_by) Return the first ChildNotification filtered by the modified_by column *

 * @method     ChildNotification requirePk($key, ConnectionInterface $con = null) Return the ChildNotification by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOne(ConnectionInterface $con = null) Return the first ChildNotification matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotification requireOneByNotificationId(int $notification_id) Return the first ChildNotification filtered by the notification_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByTransitionId(int $transition_id) Return the first ChildNotification filtered by the transition_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByNotificationType(string $notification_type) Return the first ChildNotification filtered by the notification_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByNotificationString(string $notification_string) Return the first ChildNotification filtered by the notification_string column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByCreatedAt(string $created_at) Return the first ChildNotification filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByCreatedBy(int $created_by) Return the first ChildNotification filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByModifiedAt(string $modified_at) Return the first ChildNotification filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildNotification requireOneByModifiedBy(int $modified_by) Return the first ChildNotification filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildNotification[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildNotification objects based on current ModelCriteria
 * @method     ChildNotification[]|ObjectCollection findByNotificationId(int $notification_id) Return ChildNotification objects filtered by the notification_id column
 * @method     ChildNotification[]|ObjectCollection findByTransitionId(int $transition_id) Return ChildNotification objects filtered by the transition_id column
 * @method     ChildNotification[]|ObjectCollection findByNotificationType(string $notification_type) Return ChildNotification objects filtered by the notification_type column
 * @method     ChildNotification[]|ObjectCollection findByNotificationString(string $notification_string) Return ChildNotification objects filtered by the notification_string column
 * @method     ChildNotification[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildNotification objects filtered by the created_at column
 * @method     ChildNotification[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildNotification objects filtered by the created_by column
 * @method     ChildNotification[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildNotification objects filtered by the modified_at column
 * @method     ChildNotification[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildNotification objects filtered by the modified_by column
 * @method     ChildNotification[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class NotificationQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\NotificationQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\Notification', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildNotificationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildNotificationQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildNotificationQuery) {
            return $criteria;
        }
        $query = new ChildNotificationQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildNotification|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = NotificationTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(NotificationTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNotification A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT notification_id, transition_id, notification_type, notification_string, created_at, created_by, modified_at, modified_by FROM PHPWF_notification WHERE notification_id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildNotification $obj */
            $obj = new ChildNotification();
            $obj->hydrate($row);
            NotificationTableMap::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildNotification|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the notification_id column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationId(1234); // WHERE notification_id = 1234
     * $query->filterByNotificationId(array(12, 34)); // WHERE notification_id IN (12, 34)
     * $query->filterByNotificationId(array('min' => 12)); // WHERE notification_id > 12
     * </code>
     *
     * @param     mixed $notificationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByNotificationId($notificationId = null, $comparison = null)
    {
        if (is_array($notificationId)) {
            $useMinMax = false;
            if (isset($notificationId['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_ID, $notificationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($notificationId['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_ID, $notificationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_ID, $notificationId, $comparison);
    }

    /**
     * Filter the query on the transition_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTransitionId(1234); // WHERE transition_id = 1234
     * $query->filterByTransitionId(array(12, 34)); // WHERE transition_id IN (12, 34)
     * $query->filterByTransitionId(array('min' => 12)); // WHERE transition_id > 12
     * </code>
     *
     * @see       filterByTransition()
     *
     * @param     mixed $transitionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByTransitionId($transitionId = null, $comparison = null)
    {
        if (is_array($transitionId)) {
            $useMinMax = false;
            if (isset($transitionId['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_TRANSITION_ID, $transitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transitionId['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_TRANSITION_ID, $transitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_TRANSITION_ID, $transitionId, $comparison);
    }

    /**
     * Filter the query on the notification_type column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationType('fooValue');   // WHERE notification_type = 'fooValue'
     * $query->filterByNotificationType('%fooValue%'); // WHERE notification_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notificationType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByNotificationType($notificationType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notificationType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notificationType)) {
                $notificationType = str_replace('*', '%', $notificationType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_TYPE, $notificationType, $comparison);
    }

    /**
     * Filter the query on the notification_string column
     *
     * Example usage:
     * <code>
     * $query->filterByNotificationString('fooValue');   // WHERE notification_string = 'fooValue'
     * $query->filterByNotificationString('%fooValue%'); // WHERE notification_string LIKE '%fooValue%'
     * </code>
     *
     * @param     string $notificationString The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByNotificationString($notificationString = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($notificationString)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $notificationString)) {
                $notificationString = str_replace('*', '%', $notificationString);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_STRING, $notificationString, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the created_by column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedBy(1234); // WHERE created_by = 1234
     * $query->filterByCreatedBy(array(12, 34)); // WHERE created_by IN (12, 34)
     * $query->filterByCreatedBy(array('min' => 12)); // WHERE created_by > 12
     * </code>
     *
     * @param     mixed $createdBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_CREATED_BY, $createdBy, $comparison);
    }

    /**
     * Filter the query on the modified_at column
     *
     * Example usage:
     * <code>
     * $query->filterByModifiedAt('2011-03-14'); // WHERE modified_at = '2011-03-14'
     * $query->filterByModifiedAt('now'); // WHERE modified_at = '2011-03-14'
     * $query->filterByModifiedAt(array('max' => 'yesterday')); // WHERE modified_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $modifiedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
    }

    /**
     * Filter the query on the modified_by column
     *
     * Example usage:
     * <code>
     * $query->filterByModifiedBy(1234); // WHERE modified_by = 1234
     * $query->filterByModifiedBy(array(12, 34)); // WHERE modified_by IN (12, 34)
     * $query->filterByModifiedBy(array('min' => 12)); // WHERE modified_by > 12
     * </code>
     *
     * @param     mixed $modifiedBy The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(NotificationTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(NotificationTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(NotificationTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Transition object
     *
     * @param \PHPWorkFlow\DB\Transition|ObjectCollection $transition The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildNotificationQuery The current query, for fluid interface
     */
    public function filterByTransition($transition, $comparison = null)
    {
        if ($transition instanceof \PHPWorkFlow\DB\Transition) {
            return $this
                ->addUsingAlias(NotificationTableMap::COL_TRANSITION_ID, $transition->getTransitionId(), $comparison);
        } elseif ($transition instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(NotificationTableMap::COL_TRANSITION_ID, $transition->toKeyValue('PrimaryKey', 'TransitionId'), $comparison);
        } else {
            throw new PropelException('filterByTransition() only accepts arguments of type \PHPWorkFlow\DB\Transition or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Transition relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function joinTransition($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Transition');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Transition');
        }

        return $this;
    }

    /**
     * Use the Transition relation Transition object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\TransitionQuery A secondary query class using the current class as primary query
     */
    public function useTransitionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTransition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Transition', '\PHPWorkFlow\DB\TransitionQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildNotification $notification Object to remove from the list of results
     *
     * @return $this|ChildNotificationQuery The current query, for fluid interface
     */
    public function prune($notification = null)
    {
        if ($notification) {
            $this->addUsingAlias(NotificationTableMap::COL_NOTIFICATION_ID, $notification->getNotificationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_notification table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            NotificationTableMap::clearInstancePool();
            NotificationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(NotificationTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(NotificationTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            NotificationTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            NotificationTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // NotificationQuery
