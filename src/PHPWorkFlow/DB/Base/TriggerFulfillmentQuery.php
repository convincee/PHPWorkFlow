<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\TriggerFulfillment as ChildTriggerFulfillment;
use PHPWorkFlow\DB\TriggerFulfillmentQuery as ChildTriggerFulfillmentQuery;
use PHPWorkFlow\DB\Map\TriggerFulfillmentTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_trigger_fulfillment' table.
 *
 *
 *
 * @method     ChildTriggerFulfillmentQuery orderByTriggerFulfillmentId($order = Criteria::ASC) Order by the trigger_fulfillment_id column
 * @method     ChildTriggerFulfillmentQuery orderByUseCaseId($order = Criteria::ASC) Order by the use_case_id column
 * @method     ChildTriggerFulfillmentQuery orderByTransitionId($order = Criteria::ASC) Order by the transition_id column
 * @method     ChildTriggerFulfillmentQuery orderByTriggerFulfillmentStatus($order = Criteria::ASC) Order by the trigger_fulfillment_status column
 * @method     ChildTriggerFulfillmentQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTriggerFulfillmentQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildTriggerFulfillmentQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildTriggerFulfillmentQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildTriggerFulfillmentQuery groupByTriggerFulfillmentId() Group by the trigger_fulfillment_id column
 * @method     ChildTriggerFulfillmentQuery groupByUseCaseId() Group by the use_case_id column
 * @method     ChildTriggerFulfillmentQuery groupByTransitionId() Group by the transition_id column
 * @method     ChildTriggerFulfillmentQuery groupByTriggerFulfillmentStatus() Group by the trigger_fulfillment_status column
 * @method     ChildTriggerFulfillmentQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTriggerFulfillmentQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildTriggerFulfillmentQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildTriggerFulfillmentQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildTriggerFulfillmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTriggerFulfillmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTriggerFulfillmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTriggerFulfillmentQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTriggerFulfillmentQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTriggerFulfillmentQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTriggerFulfillmentQuery leftJoinUseCase($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCase relation
 * @method     ChildTriggerFulfillmentQuery rightJoinUseCase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCase relation
 * @method     ChildTriggerFulfillmentQuery innerJoinUseCase($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCase relation
 *
 * @method     ChildTriggerFulfillmentQuery joinWithUseCase($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCase relation
 *
 * @method     ChildTriggerFulfillmentQuery leftJoinWithUseCase() Adds a LEFT JOIN clause and with to the query using the UseCase relation
 * @method     ChildTriggerFulfillmentQuery rightJoinWithUseCase() Adds a RIGHT JOIN clause and with to the query using the UseCase relation
 * @method     ChildTriggerFulfillmentQuery innerJoinWithUseCase() Adds a INNER JOIN clause and with to the query using the UseCase relation
 *
 * @method     ChildTriggerFulfillmentQuery leftJoinTransition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transition relation
 * @method     ChildTriggerFulfillmentQuery rightJoinTransition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transition relation
 * @method     ChildTriggerFulfillmentQuery innerJoinTransition($relationAlias = null) Adds a INNER JOIN clause to the query using the Transition relation
 *
 * @method     ChildTriggerFulfillmentQuery joinWithTransition($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transition relation
 *
 * @method     ChildTriggerFulfillmentQuery leftJoinWithTransition() Adds a LEFT JOIN clause and with to the query using the Transition relation
 * @method     ChildTriggerFulfillmentQuery rightJoinWithTransition() Adds a RIGHT JOIN clause and with to the query using the Transition relation
 * @method     ChildTriggerFulfillmentQuery innerJoinWithTransition() Adds a INNER JOIN clause and with to the query using the Transition relation
 *
 * @method     \PHPWorkFlow\DB\UseCaseQuery|\PHPWorkFlow\DB\TransitionQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildTriggerFulfillment findOne(ConnectionInterface $con = null) Return the first ChildTriggerFulfillment matching the query
 * @method     ChildTriggerFulfillment findOneOrCreate(ConnectionInterface $con = null) Return the first ChildTriggerFulfillment matching the query, or a new ChildTriggerFulfillment object populated from the query conditions when no match is found
 *
 * @method     ChildTriggerFulfillment findOneByTriggerFulfillmentId(int $trigger_fulfillment_id) Return the first ChildTriggerFulfillment filtered by the trigger_fulfillment_id column
 * @method     ChildTriggerFulfillment findOneByUseCaseId(int $use_case_id) Return the first ChildTriggerFulfillment filtered by the use_case_id column
 * @method     ChildTriggerFulfillment findOneByTransitionId(int $transition_id) Return the first ChildTriggerFulfillment filtered by the transition_id column
 * @method     ChildTriggerFulfillment findOneByTriggerFulfillmentStatus(string $trigger_fulfillment_status) Return the first ChildTriggerFulfillment filtered by the trigger_fulfillment_status column
 * @method     ChildTriggerFulfillment findOneByCreatedAt(string $created_at) Return the first ChildTriggerFulfillment filtered by the created_at column
 * @method     ChildTriggerFulfillment findOneByCreatedBy(int $created_by) Return the first ChildTriggerFulfillment filtered by the created_by column
 * @method     ChildTriggerFulfillment findOneByModifiedAt(string $modified_at) Return the first ChildTriggerFulfillment filtered by the modified_at column
 * @method     ChildTriggerFulfillment findOneByModifiedBy(int $modified_by) Return the first ChildTriggerFulfillment filtered by the modified_by column *

 * @method     ChildTriggerFulfillment requirePk($key, ConnectionInterface $con = null) Return the ChildTriggerFulfillment by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOne(ConnectionInterface $con = null) Return the first ChildTriggerFulfillment matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTriggerFulfillment requireOneByTriggerFulfillmentId(int $trigger_fulfillment_id) Return the first ChildTriggerFulfillment filtered by the trigger_fulfillment_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByUseCaseId(int $use_case_id) Return the first ChildTriggerFulfillment filtered by the use_case_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByTransitionId(int $transition_id) Return the first ChildTriggerFulfillment filtered by the transition_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByTriggerFulfillmentStatus(string $trigger_fulfillment_status) Return the first ChildTriggerFulfillment filtered by the trigger_fulfillment_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByCreatedAt(string $created_at) Return the first ChildTriggerFulfillment filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByCreatedBy(int $created_by) Return the first ChildTriggerFulfillment filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByModifiedAt(string $modified_at) Return the first ChildTriggerFulfillment filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildTriggerFulfillment requireOneByModifiedBy(int $modified_by) Return the first ChildTriggerFulfillment filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildTriggerFulfillment[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildTriggerFulfillment objects based on current ModelCriteria
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByTriggerFulfillmentId(int $trigger_fulfillment_id) Return ChildTriggerFulfillment objects filtered by the trigger_fulfillment_id column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByUseCaseId(int $use_case_id) Return ChildTriggerFulfillment objects filtered by the use_case_id column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByTransitionId(int $transition_id) Return ChildTriggerFulfillment objects filtered by the transition_id column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByTriggerFulfillmentStatus(string $trigger_fulfillment_status) Return ChildTriggerFulfillment objects filtered by the trigger_fulfillment_status column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildTriggerFulfillment objects filtered by the created_at column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildTriggerFulfillment objects filtered by the created_by column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildTriggerFulfillment objects filtered by the modified_at column
 * @method     ChildTriggerFulfillment[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildTriggerFulfillment objects filtered by the modified_by column
 * @method     ChildTriggerFulfillment[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TriggerFulfillmentQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\TriggerFulfillmentQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\TriggerFulfillment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTriggerFulfillmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTriggerFulfillmentQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTriggerFulfillmentQuery) {
            return $criteria;
        }
        $query = new ChildTriggerFulfillmentQuery();
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
     * @return ChildTriggerFulfillment|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TriggerFulfillmentTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TriggerFulfillmentTableMap::DATABASE_NAME);
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
     * @return ChildTriggerFulfillment A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT trigger_fulfillment_id, use_case_id, transition_id, trigger_fulfillment_status, created_at, created_by, modified_at, modified_by FROM PHPWF_trigger_fulfillment WHERE trigger_fulfillment_id = :p0';
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
            /** @var ChildTriggerFulfillment $obj */
            $obj = new ChildTriggerFulfillment();
            $obj->hydrate($row);
            TriggerFulfillmentTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildTriggerFulfillment|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the trigger_fulfillment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerFulfillmentId(1234); // WHERE trigger_fulfillment_id = 1234
     * $query->filterByTriggerFulfillmentId(array(12, 34)); // WHERE trigger_fulfillment_id IN (12, 34)
     * $query->filterByTriggerFulfillmentId(array('min' => 12)); // WHERE trigger_fulfillment_id > 12
     * </code>
     *
     * @param     mixed $triggerFulfillmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByTriggerFulfillmentId($triggerFulfillmentId = null, $comparison = null)
    {
        if (is_array($triggerFulfillmentId)) {
            $useMinMax = false;
            if (isset($triggerFulfillmentId['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, $triggerFulfillmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($triggerFulfillmentId['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, $triggerFulfillmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, $triggerFulfillmentId, $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByUseCaseId($useCaseId = null, $comparison = null)
    {
        if (is_array($useCaseId)) {
            $useMinMax = false;
            if (isset($useCaseId['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_USE_CASE_ID, $useCaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useCaseId['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_USE_CASE_ID, $useCaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_USE_CASE_ID, $useCaseId, $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByTransitionId($transitionId = null, $comparison = null)
    {
        if (is_array($transitionId)) {
            $useMinMax = false;
            if (isset($transitionId['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRANSITION_ID, $transitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transitionId['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRANSITION_ID, $transitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRANSITION_ID, $transitionId, $comparison);
    }

    /**
     * Filter the query on the trigger_fulfillment_status column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerFulfillmentStatus('fooValue');   // WHERE trigger_fulfillment_status = 'fooValue'
     * $query->filterByTriggerFulfillmentStatus('%fooValue%'); // WHERE trigger_fulfillment_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerFulfillmentStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByTriggerFulfillmentStatus($triggerFulfillmentStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerFulfillmentStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerFulfillmentStatus)) {
                $triggerFulfillmentStatus = str_replace('*', '%', $triggerFulfillmentStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_STATUS, $triggerFulfillmentStatus, $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(TriggerFulfillmentTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TriggerFulfillmentTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByUseCase($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(TriggerFulfillmentTableMap::COL_USE_CASE_ID, $useCase->getUseCaseId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerFulfillmentTableMap::COL_USE_CASE_ID, $useCase->toKeyValue('PrimaryKey', 'UseCaseId'), $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
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
     * @return ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function filterByTransition($transition, $comparison = null)
    {
        if ($transition instanceof \PHPWorkFlow\DB\Transition) {
            return $this
                ->addUsingAlias(TriggerFulfillmentTableMap::COL_TRANSITION_ID, $transition->getTransitionId(), $comparison);
        } elseif ($transition instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TriggerFulfillmentTableMap::COL_TRANSITION_ID, $transition->toKeyValue('PrimaryKey', 'TransitionId'), $comparison);
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
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
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
     * @param   ChildTriggerFulfillment $triggerFulfillment Object to remove from the list of results
     *
     * @return $this|ChildTriggerFulfillmentQuery The current query, for fluid interface
     */
    public function prune($triggerFulfillment = null)
    {
        if ($triggerFulfillment) {
            $this->addUsingAlias(TriggerFulfillmentTableMap::COL_TRIGGER_FULFILLMENT_ID, $triggerFulfillment->getTriggerFulfillmentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_trigger_fulfillment table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerFulfillmentTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TriggerFulfillmentTableMap::clearInstancePool();
            TriggerFulfillmentTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TriggerFulfillmentTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TriggerFulfillmentTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TriggerFulfillmentTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TriggerFulfillmentTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TriggerFulfillmentQuery
