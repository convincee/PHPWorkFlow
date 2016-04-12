<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\Transition as ChildTransition;
use PHPWorkFlow\DB\TransitionQuery as ChildTransitionQuery;
use PHPWorkFlow\DB\Map\TransitionTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_transition' table.
 *
 *
 *
 * @method     ChildTransitionQuery orderByTransitionId($order = Criteria::ASC) Order by the transition_id column
 * @method     ChildTransitionQuery orderByWorkFlowId($order = Criteria::ASC) Order by the work_flow_id column
 * @method     ChildTransitionQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildTransitionQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildTransitionQuery orderByTransitionType($order = Criteria::ASC) Order by the transition_type column
 * @method     ChildTransitionQuery orderByTransitionTriggerMethod($order = Criteria::ASC) Order by the transition_trigger_method column
 * @method     ChildTransitionQuery orderByPositionX($order = Criteria::ASC) Order by the position_x column
 * @method     ChildTransitionQuery orderByPositionY($order = Criteria::ASC) Order by the position_y column
 * @method     ChildTransitionQuery orderByDimensionX($order = Criteria::ASC) Order by the dimension_x column
 * @method     ChildTransitionQuery orderByDimensionY($order = Criteria::ASC) Order by the dimension_y column
 * @method     ChildTransitionQuery orderByYasperName($order = Criteria::ASC) Order by the yasper_name column
 * @method     ChildTransitionQuery orderByTimeDelay($order = Criteria::ASC) Order by the time_delay column
 * @method     ChildTransitionQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTransitionQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildTransitionQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildTransitionQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildTransitionQuery groupByTransitionId() Group by the transition_id column
 * @method     ChildTransitionQuery groupByWorkFlowId() Group by the work_flow_id column
 * @method     ChildTransitionQuery groupByName() Group by the name column
 * @method     ChildTransitionQuery groupByDescription() Group by the description column
 * @method     ChildTransitionQuery groupByTransitionType() Group by the transition_type column
 * @method     ChildTransitionQuery groupByTransitionTriggerMethod() Group by the transition_trigger_method column
 * @method     ChildTransitionQuery groupByPositionX() Group by the position_x column
 * @method     ChildTransitionQuery groupByPositionY() Group by the position_y column
 * @method     ChildTransitionQuery groupByDimensionX() Group by the dimension_x column
 * @method     ChildTransitionQuery groupByDimensionY() Group by the dimension_y column
 * @method     ChildTransitionQuery groupByYasperName() Group by the yasper_name column
 * @method     ChildTransitionQuery groupByTimeDelay() Group by the time_delay column
 * @method     ChildTransitionQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTransitionQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildTransitionQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildTransitionQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildTransitionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTransitionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTransitionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTransitionQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTransitionQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTransitionQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTransitionQuery leftJoinWorkFlow($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkFlow relation
 * @method     ChildTransitionQuery rightJoinWorkFlow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkFlow relation
 * @method     ChildTransitionQuery innerJoinWorkFlow($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkFlow relation
 *
 * @method     ChildTransitionQuery joinWithWorkFlow($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkFlow relation
 *
 * @method     ChildTransitionQuery leftJoinWithWorkFlow() Adds a LEFT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildTransitionQuery rightJoinWithWorkFlow() Adds a RIGHT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildTransitionQuery innerJoinWithWorkFlow() Adds a INNER JOIN clause and with to the query using the WorkFlow relation
 *
 * @method     ChildTransitionQuery leftJoinArc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arc relation
 * @method     ChildTransitionQuery rightJoinArc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arc relation
 * @method     ChildTransitionQuery innerJoinArc($relationAlias = null) Adds a INNER JOIN clause to the query using the Arc relation
 *
 * @method     ChildTransitionQuery joinWithArc($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Arc relation
 *
 * @method     ChildTransitionQuery leftJoinWithArc() Adds a LEFT JOIN clause and with to the query using the Arc relation
 * @method     ChildTransitionQuery rightJoinWithArc() Adds a RIGHT JOIN clause and with to the query using the Arc relation
 * @method     ChildTransitionQuery innerJoinWithArc() Adds a INNER JOIN clause and with to the query using the Arc relation
 *
 * @method     ChildTransitionQuery leftJoinCommand($relationAlias = null) Adds a LEFT JOIN clause to the query using the Command relation
 * @method     ChildTransitionQuery rightJoinCommand($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Command relation
 * @method     ChildTransitionQuery innerJoinCommand($relationAlias = null) Adds a INNER JOIN clause to the query using the Command relation
 *
 * @method     ChildTransitionQuery joinWithCommand($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Command relation
 *
 * @method     ChildTransitionQuery leftJoinWithCommand() Adds a LEFT JOIN clause and with to the query using the Command relation
 * @method     ChildTransitionQuery rightJoinWithCommand() Adds a RIGHT JOIN clause and with to the query using the Command relation
 * @method     ChildTransitionQuery innerJoinWithCommand() Adds a INNER JOIN clause and with to the query using the Command relation
 *
 * @method     ChildTransitionQuery leftJoinGate($relationAlias = null) Adds a LEFT JOIN clause to the query using the Gate relation
 * @method     ChildTransitionQuery rightJoinGate($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Gate relation
 * @method     ChildTransitionQuery innerJoinGate($relationAlias = null) Adds a INNER JOIN clause to the query using the Gate relation
 *
 * @method     ChildTransitionQuery joinWithGate($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Gate relation
 *
 * @method     ChildTransitionQuery leftJoinWithGate() Adds a LEFT JOIN clause and with to the query using the Gate relation
 * @method     ChildTransitionQuery rightJoinWithGate() Adds a RIGHT JOIN clause and with to the query using the Gate relation
 * @method     ChildTransitionQuery innerJoinWithGate() Adds a INNER JOIN clause and with to the query using the Gate relation
 *
 * @method     ChildTransitionQuery leftJoinNotification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Notification relation
 * @method     ChildTransitionQuery rightJoinNotification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Notification relation
 * @method     ChildTransitionQuery innerJoinNotification($relationAlias = null) Adds a INNER JOIN clause to the query using the Notification relation
 *
 * @method     ChildTransitionQuery joinWithNotification($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Notification relation
 *
 * @method     ChildTransitionQuery leftJoinWithNotification() Adds a LEFT JOIN clause and with to the query using the Notification relation
 * @method     ChildTransitionQuery rightJoinWithNotification() Adds a RIGHT JOIN clause and with to the query using the Notification relation
 * @method     ChildTransitionQuery innerJoinWithNotification() Adds a INNER JOIN clause and with to the query using the Notification relation
 *
 * @method     ChildTransitionQuery leftJoinRoute($relationAlias = null) Adds a LEFT JOIN clause to the query using the Route relation
 * @method     ChildTransitionQuery rightJoinRoute($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Route relation
 * @method     ChildTransitionQuery innerJoinRoute($relationAlias = null) Adds a INNER JOIN clause to the query using the Route relation
 *
 * @method     ChildTransitionQuery joinWithRoute($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Route relation
 *
 * @method     ChildTransitionQuery leftJoinWithRoute() Adds a LEFT JOIN clause and with to the query using the Route relation
 * @method     ChildTransitionQuery rightJoinWithRoute() Adds a RIGHT JOIN clause and with to the query using the Route relation
 * @method     ChildTransitionQuery innerJoinWithRoute() Adds a INNER JOIN clause and with to the query using the Route relation
 *
 * @method     ChildTransitionQuery leftJoinTriggerFulfillment($relationAlias = null) Adds a LEFT JOIN clause to the query using the TriggerFulfillment relation
 * @method     ChildTransitionQuery rightJoinTriggerFulfillment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TriggerFulfillment relation
 * @method     ChildTransitionQuery innerJoinTriggerFulfillment($relationAlias = null) Adds a INNER JOIN clause to the query using the TriggerFulfillment relation
 *
 * @method     ChildTransitionQuery joinWithTriggerFulfillment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TriggerFulfillment relation
 *
 * @method     ChildTransitionQuery leftJoinWithTriggerFulfillment() Adds a LEFT JOIN clause and with to the query using the TriggerFulfillment relation
 * @method     ChildTransitionQuery rightJoinWithTriggerFulfillment() Adds a RIGHT JOIN clause and with to the query using the TriggerFulfillment relation
 * @method     ChildTransitionQuery innerJoinWithTriggerFulfillment() Adds a INNER JOIN clause and with to the query using the TriggerFulfillment relation
 *
 * @method     ChildTransitionQuery leftJoinWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkItem relation
 * @method     ChildTransitionQuery rightJoinWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkItem relation
 * @method     ChildTransitionQuery innerJoinWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkItem relation
 *
 * @method     ChildTransitionQuery joinWithWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkItem relation
 *
 * @method     ChildTransitionQuery leftJoinWithWorkItem() Adds a LEFT JOIN clause and with to the query using the WorkItem relation
 * @method     ChildTransitionQuery rightJoinWithWorkItem() Adds a RIGHT JOIN clause and with to the query using the WorkItem relation
 * @method     ChildTransitionQuery innerJoinWithWorkItem() Adds a INNER JOIN clause and with to the query using the WorkItem relation
 *
 * @method     \PHPWorkFlow\DB\WorkFlowQuery|\PHPWorkFlow\DB\ArcQuery|\PHPWorkFlow\DB\CommandQuery|\PHPWorkFlow\DB\GateQuery|\PHPWorkFlow\DB\NotificationQuery|\PHPWorkFlow\DB\RouteQuery|\PHPWorkFlow\DB\TriggerFulfillmentQuery|\PHPWorkFlow\DB\WorkItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTransition findOne(ConnectionInterface $con = null) Return the first ChildTransition matching the query
 * @method     ChildTransition findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTransition matching the query, or a new ChildTransition object populated from the query conditions when no match is found
 *
 * @method     ChildTransition findOneByTransitionId(int $transition_id) Return the first ChildTransition filtered by the transition_id column
 * @method     ChildTransition findOneByWorkFlowId(int $work_flow_id) Return the first ChildTransition filtered by the work_flow_id column
 * @method     ChildTransition findOneByName(string $name) Return the first ChildTransition filtered by the name column
 * @method     ChildTransition findOneByDescription(string $description) Return the first ChildTransition filtered by the description column
 * @method     ChildTransition findOneByTransitionType(string $transition_type) Return the first ChildTransition filtered by the transition_type column
 * @method     ChildTransition findOneByTransitionTriggerMethod(string $transition_trigger_method) Return the first ChildTransition filtered by the transition_trigger_method column
 * @method     ChildTransition findOneByPositionX(int $position_x) Return the first ChildTransition filtered by the position_x column
 * @method     ChildTransition findOneByPositionY(int $position_y) Return the first ChildTransition filtered by the position_y column
 * @method     ChildTransition findOneByDimensionX(int $dimension_x) Return the first ChildTransition filtered by the dimension_x column
 * @method     ChildTransition findOneByDimensionY(int $dimension_y) Return the first ChildTransition filtered by the dimension_y column
 * @method     ChildTransition findOneByYasperName(string $yasper_name) Return the first ChildTransition filtered by the yasper_name column
 * @method     ChildTransition findOneByTimeDelay(int $time_delay) Return the first ChildTransition filtered by the time_delay column
 * @method     ChildTransition findOneByCreatedAt(string $created_at) Return the first ChildTransition filtered by the created_at column
 * @method     ChildTransition findOneByCreatedBy(int $created_by) Return the first ChildTransition filtered by the created_by column
 * @method     ChildTransition findOneByModifiedAt(string $modified_at) Return the first ChildTransition filtered by the modified_at column
 * @method     ChildTransition findOneByModifiedBy(int $modified_by) Return the first ChildTransition filtered by the modified_by column *

 * @method     ChildTransition requirePk($key, ConnectionInterface $con = null) Return the ChildTransition by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOne(ConnectionInterface $con = null) Return the first ChildTransition matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransition requireOneByTransitionId(int $transition_id) Return the first ChildTransition filtered by the transition_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByWorkFlowId(int $work_flow_id) Return the first ChildTransition filtered by the work_flow_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByName(string $name) Return the first ChildTransition filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByDescription(string $description) Return the first ChildTransition filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByTransitionType(string $transition_type) Return the first ChildTransition filtered by the transition_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByTransitionTriggerMethod(string $transition_trigger_method) Return the first ChildTransition filtered by the transition_trigger_method column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByPositionX(int $position_x) Return the first ChildTransition filtered by the position_x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByPositionY(int $position_y) Return the first ChildTransition filtered by the position_y column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByDimensionX(int $dimension_x) Return the first ChildTransition filtered by the dimension_x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByDimensionY(int $dimension_y) Return the first ChildTransition filtered by the dimension_y column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByYasperName(string $yasper_name) Return the first ChildTransition filtered by the yasper_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByTimeDelay(int $time_delay) Return the first ChildTransition filtered by the time_delay column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByCreatedAt(string $created_at) Return the first ChildTransition filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByCreatedBy(int $created_by) Return the first ChildTransition filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByModifiedAt(string $modified_at) Return the first ChildTransition filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTransition requireOneByModifiedBy(int $modified_by) Return the first ChildTransition filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTransition[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTransition objects based on current ModelCriteria
 * @method     ChildTransition[]|ObjectCollection findByTransitionId(int $transition_id) Return ChildTransition objects filtered by the transition_id column
 * @method     ChildTransition[]|ObjectCollection findByWorkFlowId(int $work_flow_id) Return ChildTransition objects filtered by the work_flow_id column
 * @method     ChildTransition[]|ObjectCollection findByName(string $name) Return ChildTransition objects filtered by the name column
 * @method     ChildTransition[]|ObjectCollection findByDescription(string $description) Return ChildTransition objects filtered by the description column
 * @method     ChildTransition[]|ObjectCollection findByTransitionType(string $transition_type) Return ChildTransition objects filtered by the transition_type column
 * @method     ChildTransition[]|ObjectCollection findByTransitionTriggerMethod(string $transition_trigger_method) Return ChildTransition objects filtered by the transition_trigger_method column
 * @method     ChildTransition[]|ObjectCollection findByPositionX(int $position_x) Return ChildTransition objects filtered by the position_x column
 * @method     ChildTransition[]|ObjectCollection findByPositionY(int $position_y) Return ChildTransition objects filtered by the position_y column
 * @method     ChildTransition[]|ObjectCollection findByDimensionX(int $dimension_x) Return ChildTransition objects filtered by the dimension_x column
 * @method     ChildTransition[]|ObjectCollection findByDimensionY(int $dimension_y) Return ChildTransition objects filtered by the dimension_y column
 * @method     ChildTransition[]|ObjectCollection findByYasperName(string $yasper_name) Return ChildTransition objects filtered by the yasper_name column
 * @method     ChildTransition[]|ObjectCollection findByTimeDelay(int $time_delay) Return ChildTransition objects filtered by the time_delay column
 * @method     ChildTransition[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTransition objects filtered by the created_at column
 * @method     ChildTransition[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildTransition objects filtered by the created_by column
 * @method     ChildTransition[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildTransition objects filtered by the modified_at column
 * @method     ChildTransition[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildTransition objects filtered by the modified_by column
 * @method     ChildTransition[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TransitionQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\TransitionQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\Transition', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTransitionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTransitionQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTransitionQuery) {
            return $criteria;
        }
        $query = new ChildTransitionQuery();
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
     * @return ChildTransition|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TransitionTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TransitionTableMap::DATABASE_NAME);
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
     * @return ChildTransition A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT transition_id, work_flow_id, name, description, transition_type, transition_trigger_method, position_x, position_y, dimension_x, dimension_y, yasper_name, time_delay, created_at, created_by, modified_at, modified_by FROM PHPWF_transition WHERE transition_id = :p0';
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
            /** @var ChildTransition $obj */
            $obj = new ChildTransition();
            $obj->hydrate($row);
            TransitionTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTransition|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $keys, Criteria::IN);
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
     * @param     mixed $transitionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByTransitionId($transitionId = null, $comparison = null)
    {
        if (is_array($transitionId)) {
            $useMinMax = false;
            if (isset($transitionId['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $transitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transitionId['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $transitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $transitionId, $comparison);
    }

    /**
     * Filter the query on the work_flow_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkFlowId(1234); // WHERE work_flow_id = 1234
     * $query->filterByWorkFlowId(array(12, 34)); // WHERE work_flow_id IN (12, 34)
     * $query->filterByWorkFlowId(array('min' => 12)); // WHERE work_flow_id > 12
     * </code>
     *
     * @see       filterByWorkFlow()
     *
     * @param     mixed $workFlowId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByWorkFlowId($workFlowId = null, $comparison = null)
    {
        if (is_array($workFlowId)) {
            $useMinMax = false;
            if (isset($workFlowId['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_WORK_FLOW_ID, $workFlowId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($workFlowId['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_WORK_FLOW_ID, $workFlowId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_WORK_FLOW_ID, $workFlowId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the transition_type column
     *
     * Example usage:
     * <code>
     * $query->filterByTransitionType('fooValue');   // WHERE transition_type = 'fooValue'
     * $query->filterByTransitionType('%fooValue%'); // WHERE transition_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transitionType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByTransitionType($transitionType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transitionType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $transitionType)) {
                $transitionType = str_replace('*', '%', $transitionType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_TYPE, $transitionType, $comparison);
    }

    /**
     * Filter the query on the transition_trigger_method column
     *
     * Example usage:
     * <code>
     * $query->filterByTransitionTriggerMethod('fooValue');   // WHERE transition_trigger_method = 'fooValue'
     * $query->filterByTransitionTriggerMethod('%fooValue%'); // WHERE transition_trigger_method LIKE '%fooValue%'
     * </code>
     *
     * @param     string $transitionTriggerMethod The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByTransitionTriggerMethod($transitionTriggerMethod = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($transitionTriggerMethod)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $transitionTriggerMethod)) {
                $transitionTriggerMethod = str_replace('*', '%', $transitionTriggerMethod);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_TRIGGER_METHOD, $transitionTriggerMethod, $comparison);
    }

    /**
     * Filter the query on the position_x column
     *
     * Example usage:
     * <code>
     * $query->filterByPositionX(1234); // WHERE position_x = 1234
     * $query->filterByPositionX(array(12, 34)); // WHERE position_x IN (12, 34)
     * $query->filterByPositionX(array('min' => 12)); // WHERE position_x > 12
     * </code>
     *
     * @param     mixed $positionX The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByPositionX($positionX = null, $comparison = null)
    {
        if (is_array($positionX)) {
            $useMinMax = false;
            if (isset($positionX['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_POSITION_X, $positionX['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($positionX['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_POSITION_X, $positionX['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_POSITION_X, $positionX, $comparison);
    }

    /**
     * Filter the query on the position_y column
     *
     * Example usage:
     * <code>
     * $query->filterByPositionY(1234); // WHERE position_y = 1234
     * $query->filterByPositionY(array(12, 34)); // WHERE position_y IN (12, 34)
     * $query->filterByPositionY(array('min' => 12)); // WHERE position_y > 12
     * </code>
     *
     * @param     mixed $positionY The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByPositionY($positionY = null, $comparison = null)
    {
        if (is_array($positionY)) {
            $useMinMax = false;
            if (isset($positionY['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_POSITION_Y, $positionY['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($positionY['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_POSITION_Y, $positionY['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_POSITION_Y, $positionY, $comparison);
    }

    /**
     * Filter the query on the dimension_x column
     *
     * Example usage:
     * <code>
     * $query->filterByDimensionX(1234); // WHERE dimension_x = 1234
     * $query->filterByDimensionX(array(12, 34)); // WHERE dimension_x IN (12, 34)
     * $query->filterByDimensionX(array('min' => 12)); // WHERE dimension_x > 12
     * </code>
     *
     * @param     mixed $dimensionX The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByDimensionX($dimensionX = null, $comparison = null)
    {
        if (is_array($dimensionX)) {
            $useMinMax = false;
            if (isset($dimensionX['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_DIMENSION_X, $dimensionX['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dimensionX['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_DIMENSION_X, $dimensionX['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_DIMENSION_X, $dimensionX, $comparison);
    }

    /**
     * Filter the query on the dimension_y column
     *
     * Example usage:
     * <code>
     * $query->filterByDimensionY(1234); // WHERE dimension_y = 1234
     * $query->filterByDimensionY(array(12, 34)); // WHERE dimension_y IN (12, 34)
     * $query->filterByDimensionY(array('min' => 12)); // WHERE dimension_y > 12
     * </code>
     *
     * @param     mixed $dimensionY The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByDimensionY($dimensionY = null, $comparison = null)
    {
        if (is_array($dimensionY)) {
            $useMinMax = false;
            if (isset($dimensionY['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_DIMENSION_Y, $dimensionY['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dimensionY['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_DIMENSION_Y, $dimensionY['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_DIMENSION_Y, $dimensionY, $comparison);
    }

    /**
     * Filter the query on the yasper_name column
     *
     * Example usage:
     * <code>
     * $query->filterByYasperName('fooValue');   // WHERE yasper_name = 'fooValue'
     * $query->filterByYasperName('%fooValue%'); // WHERE yasper_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $yasperName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByYasperName($yasperName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($yasperName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $yasperName)) {
                $yasperName = str_replace('*', '%', $yasperName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_YASPER_NAME, $yasperName, $comparison);
    }

    /**
     * Filter the query on the time_delay column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeDelay(1234); // WHERE time_delay = 1234
     * $query->filterByTimeDelay(array(12, 34)); // WHERE time_delay IN (12, 34)
     * $query->filterByTimeDelay(array('min' => 12)); // WHERE time_delay > 12
     * </code>
     *
     * @param     mixed $timeDelay The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByTimeDelay($timeDelay = null, $comparison = null)
    {
        if (is_array($timeDelay)) {
            $useMinMax = false;
            if (isset($timeDelay['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_TIME_DELAY, $timeDelay['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeDelay['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_TIME_DELAY, $timeDelay['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_TIME_DELAY, $timeDelay, $comparison);
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
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(TransitionTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(TransitionTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TransitionTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkFlow object
     *
     * @param \PHPWorkFlow\DB\WorkFlow|ObjectCollection $workFlow The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByWorkFlow($workFlow, $comparison = null)
    {
        if ($workFlow instanceof \PHPWorkFlow\DB\WorkFlow) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_WORK_FLOW_ID, $workFlow->getWorkFlowId(), $comparison);
        } elseif ($workFlow instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TransitionTableMap::COL_WORK_FLOW_ID, $workFlow->toKeyValue('PrimaryKey', 'WorkFlowId'), $comparison);
        } else {
            throw new PropelException('filterByWorkFlow() only accepts arguments of type \PHPWorkFlow\DB\WorkFlow or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WorkFlow relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinWorkFlow($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WorkFlow');

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
            $this->addJoinObject($join, 'WorkFlow');
        }

        return $this;
    }

    /**
     * Use the WorkFlow relation WorkFlow object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\WorkFlowQuery A secondary query class using the current class as primary query
     */
    public function useWorkFlowQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWorkFlow($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WorkFlow', '\PHPWorkFlow\DB\WorkFlowQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Arc object
     *
     * @param \PHPWorkFlow\DB\Arc|ObjectCollection $arc the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByArc($arc, $comparison = null)
    {
        if ($arc instanceof \PHPWorkFlow\DB\Arc) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $arc->getTransitionId(), $comparison);
        } elseif ($arc instanceof ObjectCollection) {
            return $this
                ->useArcQuery()
                ->filterByPrimaryKeys($arc->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArc() only accepts arguments of type \PHPWorkFlow\DB\Arc or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Arc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinArc($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Arc');

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
            $this->addJoinObject($join, 'Arc');
        }

        return $this;
    }

    /**
     * Use the Arc relation Arc object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\ArcQuery A secondary query class using the current class as primary query
     */
    public function useArcQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Arc', '\PHPWorkFlow\DB\ArcQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Command object
     *
     * @param \PHPWorkFlow\DB\Command|ObjectCollection $command the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByCommand($command, $comparison = null)
    {
        if ($command instanceof \PHPWorkFlow\DB\Command) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $command->getTransitionId(), $comparison);
        } elseif ($command instanceof ObjectCollection) {
            return $this
                ->useCommandQuery()
                ->filterByPrimaryKeys($command->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCommand() only accepts arguments of type \PHPWorkFlow\DB\Command or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Command relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinCommand($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Command');

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
            $this->addJoinObject($join, 'Command');
        }

        return $this;
    }

    /**
     * Use the Command relation Command object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\CommandQuery A secondary query class using the current class as primary query
     */
    public function useCommandQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCommand($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Command', '\PHPWorkFlow\DB\CommandQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Gate object
     *
     * @param \PHPWorkFlow\DB\Gate|ObjectCollection $gate the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByGate($gate, $comparison = null)
    {
        if ($gate instanceof \PHPWorkFlow\DB\Gate) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $gate->getTransitionId(), $comparison);
        } elseif ($gate instanceof ObjectCollection) {
            return $this
                ->useGateQuery()
                ->filterByPrimaryKeys($gate->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByGate() only accepts arguments of type \PHPWorkFlow\DB\Gate or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Gate relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinGate($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Gate');

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
            $this->addJoinObject($join, 'Gate');
        }

        return $this;
    }

    /**
     * Use the Gate relation Gate object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\GateQuery A secondary query class using the current class as primary query
     */
    public function useGateQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinGate($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Gate', '\PHPWorkFlow\DB\GateQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Notification object
     *
     * @param \PHPWorkFlow\DB\Notification|ObjectCollection $notification the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByNotification($notification, $comparison = null)
    {
        if ($notification instanceof \PHPWorkFlow\DB\Notification) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $notification->getTransitionId(), $comparison);
        } elseif ($notification instanceof ObjectCollection) {
            return $this
                ->useNotificationQuery()
                ->filterByPrimaryKeys($notification->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByNotification() only accepts arguments of type \PHPWorkFlow\DB\Notification or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Notification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinNotification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Notification');

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
            $this->addJoinObject($join, 'Notification');
        }

        return $this;
    }

    /**
     * Use the Notification relation Notification object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\NotificationQuery A secondary query class using the current class as primary query
     */
    public function useNotificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinNotification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Notification', '\PHPWorkFlow\DB\NotificationQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Route object
     *
     * @param \PHPWorkFlow\DB\Route|ObjectCollection $route the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByRoute($route, $comparison = null)
    {
        if ($route instanceof \PHPWorkFlow\DB\Route) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $route->getTransitionId(), $comparison);
        } elseif ($route instanceof ObjectCollection) {
            return $this
                ->useRouteQuery()
                ->filterByPrimaryKeys($route->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByRoute() only accepts arguments of type \PHPWorkFlow\DB\Route or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Route relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinRoute($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Route');

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
            $this->addJoinObject($join, 'Route');
        }

        return $this;
    }

    /**
     * Use the Route relation Route object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\RouteQuery A secondary query class using the current class as primary query
     */
    public function useRouteQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinRoute($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Route', '\PHPWorkFlow\DB\RouteQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\TriggerFulfillment object
     *
     * @param \PHPWorkFlow\DB\TriggerFulfillment|ObjectCollection $triggerFulfillment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByTriggerFulfillment($triggerFulfillment, $comparison = null)
    {
        if ($triggerFulfillment instanceof \PHPWorkFlow\DB\TriggerFulfillment) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $triggerFulfillment->getTransitionId(), $comparison);
        } elseif ($triggerFulfillment instanceof ObjectCollection) {
            return $this
                ->useTriggerFulfillmentQuery()
                ->filterByPrimaryKeys($triggerFulfillment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTriggerFulfillment() only accepts arguments of type \PHPWorkFlow\DB\TriggerFulfillment or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the TriggerFulfillment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinTriggerFulfillment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('TriggerFulfillment');

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
            $this->addJoinObject($join, 'TriggerFulfillment');
        }

        return $this;
    }

    /**
     * Use the TriggerFulfillment relation TriggerFulfillment object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\TriggerFulfillmentQuery A secondary query class using the current class as primary query
     */
    public function useTriggerFulfillmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTriggerFulfillment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'TriggerFulfillment', '\PHPWorkFlow\DB\TriggerFulfillmentQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkItem object
     *
     * @param \PHPWorkFlow\DB\WorkItem|ObjectCollection $workItem the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildTransitionQuery The current query, for fluid interface
     */
    public function filterByWorkItem($workItem, $comparison = null)
    {
        if ($workItem instanceof \PHPWorkFlow\DB\WorkItem) {
            return $this
                ->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $workItem->getTransitionId(), $comparison);
        } elseif ($workItem instanceof ObjectCollection) {
            return $this
                ->useWorkItemQuery()
                ->filterByPrimaryKeys($workItem->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWorkItem() only accepts arguments of type \PHPWorkFlow\DB\WorkItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WorkItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function joinWorkItem($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WorkItem');

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
            $this->addJoinObject($join, 'WorkItem');
        }

        return $this;
    }

    /**
     * Use the WorkItem relation WorkItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\WorkItemQuery A secondary query class using the current class as primary query
     */
    public function useWorkItemQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinWorkItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WorkItem', '\PHPWorkFlow\DB\WorkItemQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildTransition $transition Object to remove from the list of results
     *
     * @return $this|ChildTransitionQuery The current query, for fluid interface
     */
    public function prune($transition = null)
    {
        if ($transition) {
            $this->addUsingAlias(TransitionTableMap::COL_TRANSITION_ID, $transition->getTransitionId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_transition table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TransitionTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TransitionTableMap::clearInstancePool();
            TransitionTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TransitionTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TransitionTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TransitionTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TransitionTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TransitionQuery
