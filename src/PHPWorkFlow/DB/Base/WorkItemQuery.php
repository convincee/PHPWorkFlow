<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\WorkItem as ChildWorkItem;
use PHPWorkFlow\DB\WorkItemQuery as ChildWorkItemQuery;
use PHPWorkFlow\DB\Map\WorkItemTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_work_item' table.
 *
 *
 *
 * @method     ChildWorkItemQuery orderByWorkItemId($order = Criteria::ASC) Order by the work_item_id column
 * @method     ChildWorkItemQuery orderByUseCaseId($order = Criteria::ASC) Order by the use_case_id column
 * @method     ChildWorkItemQuery orderByTransitionId($order = Criteria::ASC) Order by the transition_id column
 * @method     ChildWorkItemQuery orderByWorkItemStatus($order = Criteria::ASC) Order by the work_item_status column
 * @method     ChildWorkItemQuery orderByEnabledDate($order = Criteria::ASC) Order by the enabled_date column
 * @method     ChildWorkItemQuery orderByCancelledDate($order = Criteria::ASC) Order by the cancelled_date column
 * @method     ChildWorkItemQuery orderByFinishedDate($order = Criteria::ASC) Order by the finished_date column
 * @method     ChildWorkItemQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildWorkItemQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildWorkItemQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildWorkItemQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildWorkItemQuery groupByWorkItemId() Group by the work_item_id column
 * @method     ChildWorkItemQuery groupByUseCaseId() Group by the use_case_id column
 * @method     ChildWorkItemQuery groupByTransitionId() Group by the transition_id column
 * @method     ChildWorkItemQuery groupByWorkItemStatus() Group by the work_item_status column
 * @method     ChildWorkItemQuery groupByEnabledDate() Group by the enabled_date column
 * @method     ChildWorkItemQuery groupByCancelledDate() Group by the cancelled_date column
 * @method     ChildWorkItemQuery groupByFinishedDate() Group by the finished_date column
 * @method     ChildWorkItemQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildWorkItemQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildWorkItemQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildWorkItemQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildWorkItemQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWorkItemQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWorkItemQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWorkItemQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWorkItemQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWorkItemQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWorkItemQuery leftJoinUseCase($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCase relation
 * @method     ChildWorkItemQuery rightJoinUseCase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCase relation
 * @method     ChildWorkItemQuery innerJoinUseCase($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCase relation
 *
 * @method     ChildWorkItemQuery joinWithUseCase($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCase relation
 *
 * @method     ChildWorkItemQuery leftJoinWithUseCase() Adds a LEFT JOIN clause and with to the query using the UseCase relation
 * @method     ChildWorkItemQuery rightJoinWithUseCase() Adds a RIGHT JOIN clause and with to the query using the UseCase relation
 * @method     ChildWorkItemQuery innerJoinWithUseCase() Adds a INNER JOIN clause and with to the query using the UseCase relation
 *
 * @method     ChildWorkItemQuery leftJoinTransition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transition relation
 * @method     ChildWorkItemQuery rightJoinTransition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transition relation
 * @method     ChildWorkItemQuery innerJoinTransition($relationAlias = null) Adds a INNER JOIN clause to the query using the Transition relation
 *
 * @method     ChildWorkItemQuery joinWithTransition($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transition relation
 *
 * @method     ChildWorkItemQuery leftJoinWithTransition() Adds a LEFT JOIN clause and with to the query using the Transition relation
 * @method     ChildWorkItemQuery rightJoinWithTransition() Adds a RIGHT JOIN clause and with to the query using the Transition relation
 * @method     ChildWorkItemQuery innerJoinWithTransition() Adds a INNER JOIN clause and with to the query using the Transition relation
 *
 * @method     ChildWorkItemQuery leftJoinArc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arc relation
 * @method     ChildWorkItemQuery rightJoinArc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arc relation
 * @method     ChildWorkItemQuery innerJoinArc($relationAlias = null) Adds a INNER JOIN clause to the query using the Arc relation
 *
 * @method     ChildWorkItemQuery joinWithArc($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Arc relation
 *
 * @method     ChildWorkItemQuery leftJoinWithArc() Adds a LEFT JOIN clause and with to the query using the Arc relation
 * @method     ChildWorkItemQuery rightJoinWithArc() Adds a RIGHT JOIN clause and with to the query using the Arc relation
 * @method     ChildWorkItemQuery innerJoinWithArc() Adds a INNER JOIN clause and with to the query using the Arc relation
 *
 * @method     ChildWorkItemQuery leftJoinCreatingWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CreatingWorkItem relation
 * @method     ChildWorkItemQuery rightJoinCreatingWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CreatingWorkItem relation
 * @method     ChildWorkItemQuery innerJoinCreatingWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CreatingWorkItem relation
 *
 * @method     ChildWorkItemQuery joinWithCreatingWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CreatingWorkItem relation
 *
 * @method     ChildWorkItemQuery leftJoinWithCreatingWorkItem() Adds a LEFT JOIN clause and with to the query using the CreatingWorkItem relation
 * @method     ChildWorkItemQuery rightJoinWithCreatingWorkItem() Adds a RIGHT JOIN clause and with to the query using the CreatingWorkItem relation
 * @method     ChildWorkItemQuery innerJoinWithCreatingWorkItem() Adds a INNER JOIN clause and with to the query using the CreatingWorkItem relation
 *
 * @method     ChildWorkItemQuery leftJoinConsumingWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConsumingWorkItem relation
 * @method     ChildWorkItemQuery rightJoinConsumingWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConsumingWorkItem relation
 * @method     ChildWorkItemQuery innerJoinConsumingWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the ConsumingWorkItem relation
 *
 * @method     ChildWorkItemQuery joinWithConsumingWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ConsumingWorkItem relation
 *
 * @method     ChildWorkItemQuery leftJoinWithConsumingWorkItem() Adds a LEFT JOIN clause and with to the query using the ConsumingWorkItem relation
 * @method     ChildWorkItemQuery rightJoinWithConsumingWorkItem() Adds a RIGHT JOIN clause and with to the query using the ConsumingWorkItem relation
 * @method     ChildWorkItemQuery innerJoinWithConsumingWorkItem() Adds a INNER JOIN clause and with to the query using the ConsumingWorkItem relation
 *
 * @method     \PHPWorkFlow\DB\UseCaseQuery|\PHPWorkFlow\DB\TransitionQuery|\PHPWorkFlow\DB\ArcQuery|\PHPWorkFlow\DB\TokenQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWorkItem findOne(ConnectionInterface $con = null) Return the first ChildWorkItem matching the query
 * @method     ChildWorkItem findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWorkItem matching the query, or a new ChildWorkItem object populated from the query conditions when no match is found
 *
 * @method     ChildWorkItem findOneByWorkItemId(int $work_item_id) Return the first ChildWorkItem filtered by the work_item_id column
 * @method     ChildWorkItem findOneByUseCaseId(int $use_case_id) Return the first ChildWorkItem filtered by the use_case_id column
 * @method     ChildWorkItem findOneByTransitionId(int $transition_id) Return the first ChildWorkItem filtered by the transition_id column
 * @method     ChildWorkItem findOneByWorkItemStatus(string $work_item_status) Return the first ChildWorkItem filtered by the work_item_status column
 * @method     ChildWorkItem findOneByEnabledDate(string $enabled_date) Return the first ChildWorkItem filtered by the enabled_date column
 * @method     ChildWorkItem findOneByCancelledDate(string $cancelled_date) Return the first ChildWorkItem filtered by the cancelled_date column
 * @method     ChildWorkItem findOneByFinishedDate(string $finished_date) Return the first ChildWorkItem filtered by the finished_date column
 * @method     ChildWorkItem findOneByCreatedAt(string $created_at) Return the first ChildWorkItem filtered by the created_at column
 * @method     ChildWorkItem findOneByCreatedBy(int $created_by) Return the first ChildWorkItem filtered by the created_by column
 * @method     ChildWorkItem findOneByModifiedAt(string $modified_at) Return the first ChildWorkItem filtered by the modified_at column
 * @method     ChildWorkItem findOneByModifiedBy(int $modified_by) Return the first ChildWorkItem filtered by the modified_by column *

 * @method     ChildWorkItem requirePk($key, ConnectionInterface $con = null) Return the ChildWorkItem by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOne(ConnectionInterface $con = null) Return the first ChildWorkItem matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWorkItem requireOneByWorkItemId(int $work_item_id) Return the first ChildWorkItem filtered by the work_item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByUseCaseId(int $use_case_id) Return the first ChildWorkItem filtered by the use_case_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByTransitionId(int $transition_id) Return the first ChildWorkItem filtered by the transition_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByWorkItemStatus(string $work_item_status) Return the first ChildWorkItem filtered by the work_item_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByEnabledDate(string $enabled_date) Return the first ChildWorkItem filtered by the enabled_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByCancelledDate(string $cancelled_date) Return the first ChildWorkItem filtered by the cancelled_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByFinishedDate(string $finished_date) Return the first ChildWorkItem filtered by the finished_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByCreatedAt(string $created_at) Return the first ChildWorkItem filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByCreatedBy(int $created_by) Return the first ChildWorkItem filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByModifiedAt(string $modified_at) Return the first ChildWorkItem filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkItem requireOneByModifiedBy(int $modified_by) Return the first ChildWorkItem filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWorkItem[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWorkItem objects based on current ModelCriteria
 * @method     ChildWorkItem[]|ObjectCollection findByWorkItemId(int $work_item_id) Return ChildWorkItem objects filtered by the work_item_id column
 * @method     ChildWorkItem[]|ObjectCollection findByUseCaseId(int $use_case_id) Return ChildWorkItem objects filtered by the use_case_id column
 * @method     ChildWorkItem[]|ObjectCollection findByTransitionId(int $transition_id) Return ChildWorkItem objects filtered by the transition_id column
 * @method     ChildWorkItem[]|ObjectCollection findByWorkItemStatus(string $work_item_status) Return ChildWorkItem objects filtered by the work_item_status column
 * @method     ChildWorkItem[]|ObjectCollection findByEnabledDate(string $enabled_date) Return ChildWorkItem objects filtered by the enabled_date column
 * @method     ChildWorkItem[]|ObjectCollection findByCancelledDate(string $cancelled_date) Return ChildWorkItem objects filtered by the cancelled_date column
 * @method     ChildWorkItem[]|ObjectCollection findByFinishedDate(string $finished_date) Return ChildWorkItem objects filtered by the finished_date column
 * @method     ChildWorkItem[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildWorkItem objects filtered by the created_at column
 * @method     ChildWorkItem[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildWorkItem objects filtered by the created_by column
 * @method     ChildWorkItem[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildWorkItem objects filtered by the modified_at column
 * @method     ChildWorkItem[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildWorkItem objects filtered by the modified_by column
 * @method     ChildWorkItem[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WorkItemQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\WorkItemQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\WorkItem', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWorkItemQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWorkItemQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWorkItemQuery) {
            return $criteria;
        }
        $query = new ChildWorkItemQuery();
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
     * @return ChildWorkItem|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WorkItemTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WorkItemTableMap::DATABASE_NAME);
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
     * @return ChildWorkItem A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT work_item_id, use_case_id, transition_id, work_item_status, enabled_date, cancelled_date, finished_date, created_at, created_by, modified_at, modified_by FROM PHPWF_work_item WHERE work_item_id = :p0';
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
            /** @var ChildWorkItem $obj */
            $obj = new ChildWorkItem();
            $obj->hydrate($row);
            WorkItemTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWorkItem|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the work_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkItemId(1234); // WHERE work_item_id = 1234
     * $query->filterByWorkItemId(array(12, 34)); // WHERE work_item_id IN (12, 34)
     * $query->filterByWorkItemId(array('min' => 12)); // WHERE work_item_id > 12
     * </code>
     *
     * @param     mixed $workItemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByWorkItemId($workItemId = null, $comparison = null)
    {
        if (is_array($workItemId)) {
            $useMinMax = false;
            if (isset($workItemId['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $workItemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($workItemId['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $workItemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $workItemId, $comparison);
    }

    /**
     * Filter the query on the use_case_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUseCaseId(1234); // WHERE use_case_id = 1234
     * $query->filterByUseCaseId(array(12, 34)); // WHERE use_case_id IN (12, 34)
     * $query->filterByUseCaseId(array('min' => 12)); // WHERE use_case_id > 12
     * </code>
     *
     * @see       filterByUseCase()
     *
     * @param     mixed $useCaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByUseCaseId($useCaseId = null, $comparison = null)
    {
        if (is_array($useCaseId)) {
            $useMinMax = false;
            if (isset($useCaseId['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_USE_CASE_ID, $useCaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useCaseId['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_USE_CASE_ID, $useCaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_USE_CASE_ID, $useCaseId, $comparison);
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
     * @see       filterByArc()
     *
     * @param     mixed $transitionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByTransitionId($transitionId = null, $comparison = null)
    {
        if (is_array($transitionId)) {
            $useMinMax = false;
            if (isset($transitionId['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $transitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transitionId['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $transitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $transitionId, $comparison);
    }

    /**
     * Filter the query on the work_item_status column
     *
     * Example usage:
     * <code>
     * $query->filterByWorkItemStatus('fooValue');   // WHERE work_item_status = 'fooValue'
     * $query->filterByWorkItemStatus('%fooValue%'); // WHERE work_item_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $workItemStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByWorkItemStatus($workItemStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($workItemStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $workItemStatus)) {
                $workItemStatus = str_replace('*', '%', $workItemStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_STATUS, $workItemStatus, $comparison);
    }

    /**
     * Filter the query on the enabled_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEnabledDate('2011-03-14'); // WHERE enabled_date = '2011-03-14'
     * $query->filterByEnabledDate('now'); // WHERE enabled_date = '2011-03-14'
     * $query->filterByEnabledDate(array('max' => 'yesterday')); // WHERE enabled_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $enabledDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByEnabledDate($enabledDate = null, $comparison = null)
    {
        if (is_array($enabledDate)) {
            $useMinMax = false;
            if (isset($enabledDate['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_ENABLED_DATE, $enabledDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enabledDate['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_ENABLED_DATE, $enabledDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_ENABLED_DATE, $enabledDate, $comparison);
    }

    /**
     * Filter the query on the cancelled_date column
     *
     * Example usage:
     * <code>
     * $query->filterByCancelledDate('2011-03-14'); // WHERE cancelled_date = '2011-03-14'
     * $query->filterByCancelledDate('now'); // WHERE cancelled_date = '2011-03-14'
     * $query->filterByCancelledDate(array('max' => 'yesterday')); // WHERE cancelled_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $cancelledDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByCancelledDate($cancelledDate = null, $comparison = null)
    {
        if (is_array($cancelledDate)) {
            $useMinMax = false;
            if (isset($cancelledDate['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_CANCELLED_DATE, $cancelledDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cancelledDate['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_CANCELLED_DATE, $cancelledDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_CANCELLED_DATE, $cancelledDate, $comparison);
    }

    /**
     * Filter the query on the finished_date column
     *
     * Example usage:
     * <code>
     * $query->filterByFinishedDate('2011-03-14'); // WHERE finished_date = '2011-03-14'
     * $query->filterByFinishedDate('now'); // WHERE finished_date = '2011-03-14'
     * $query->filterByFinishedDate(array('max' => 'yesterday')); // WHERE finished_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $finishedDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByFinishedDate($finishedDate = null, $comparison = null)
    {
        if (is_array($finishedDate)) {
            $useMinMax = false;
            if (isset($finishedDate['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_FINISHED_DATE, $finishedDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($finishedDate['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_FINISHED_DATE, $finishedDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_FINISHED_DATE, $finishedDate, $comparison);
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(WorkItemTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkItemTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByUseCase($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(WorkItemTableMap::COL_USE_CASE_ID, $useCase->getUseCaseId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WorkItemTableMap::COL_USE_CASE_ID, $useCase->toKeyValue('PrimaryKey', 'UseCaseId'), $comparison);
        } else {
            throw new PropelException('filterByUseCase() only accepts arguments of type \PHPWorkFlow\DB\UseCase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UseCase relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function joinUseCase($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UseCase');

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
            $this->addJoinObject($join, 'UseCase');
        }

        return $this;
    }

    /**
     * Use the UseCase relation UseCase object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\UseCaseQuery A secondary query class using the current class as primary query
     */
    public function useUseCaseQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUseCase($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UseCase', '\PHPWorkFlow\DB\UseCaseQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Transition object
     *
     * @param \PHPWorkFlow\DB\Transition|ObjectCollection $transition The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByTransition($transition, $comparison = null)
    {
        if ($transition instanceof \PHPWorkFlow\DB\Transition) {
            return $this
                ->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $transition->getTransitionId(), $comparison);
        } elseif ($transition instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $transition->toKeyValue('PrimaryKey', 'TransitionId'), $comparison);
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\Arc object
     *
     * @param \PHPWorkFlow\DB\Arc|ObjectCollection $arc The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByArc($arc, $comparison = null)
    {
        if ($arc instanceof \PHPWorkFlow\DB\Arc) {
            return $this
                ->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $arc->getTransitionId(), $comparison);
        } elseif ($arc instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WorkItemTableMap::COL_TRANSITION_ID, $arc->toKeyValue('PrimaryKey', 'TransitionId'), $comparison);
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
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\Token object
     *
     * @param \PHPWorkFlow\DB\Token|ObjectCollection $token the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByCreatingWorkItem($token, $comparison = null)
    {
        if ($token instanceof \PHPWorkFlow\DB\Token) {
            return $this
                ->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $token->getCreatingWorkItemId(), $comparison);
        } elseif ($token instanceof ObjectCollection) {
            return $this
                ->useCreatingWorkItemQuery()
                ->filterByPrimaryKeys($token->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCreatingWorkItem() only accepts arguments of type \PHPWorkFlow\DB\Token or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CreatingWorkItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function joinCreatingWorkItem($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CreatingWorkItem');

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
            $this->addJoinObject($join, 'CreatingWorkItem');
        }

        return $this;
    }

    /**
     * Use the CreatingWorkItem relation Token object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\TokenQuery A secondary query class using the current class as primary query
     */
    public function useCreatingWorkItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCreatingWorkItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CreatingWorkItem', '\PHPWorkFlow\DB\TokenQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Token object
     *
     * @param \PHPWorkFlow\DB\Token|ObjectCollection $token the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkItemQuery The current query, for fluid interface
     */
    public function filterByConsumingWorkItem($token, $comparison = null)
    {
        if ($token instanceof \PHPWorkFlow\DB\Token) {
            return $this
                ->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $token->getConsumingWorkItemId(), $comparison);
        } elseif ($token instanceof ObjectCollection) {
            return $this
                ->useConsumingWorkItemQuery()
                ->filterByPrimaryKeys($token->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByConsumingWorkItem() only accepts arguments of type \PHPWorkFlow\DB\Token or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConsumingWorkItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function joinConsumingWorkItem($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ConsumingWorkItem');

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
            $this->addJoinObject($join, 'ConsumingWorkItem');
        }

        return $this;
    }

    /**
     * Use the ConsumingWorkItem relation Token object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\TokenQuery A secondary query class using the current class as primary query
     */
    public function useConsumingWorkItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConsumingWorkItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConsumingWorkItem', '\PHPWorkFlow\DB\TokenQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildWorkItem $workItem Object to remove from the list of results
     *
     * @return $this|ChildWorkItemQuery The current query, for fluid interface
     */
    public function prune($workItem = null)
    {
        if ($workItem) {
            $this->addUsingAlias(WorkItemTableMap::COL_WORK_ITEM_ID, $workItem->getWorkItemId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_work_item table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WorkItemTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WorkItemTableMap::clearInstancePool();
            WorkItemTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WorkItemTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WorkItemTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WorkItemTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WorkItemTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WorkItemQuery
