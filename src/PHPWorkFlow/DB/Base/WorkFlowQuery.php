<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\WorkFlow as ChildWorkFlow;
use PHPWorkFlow\DB\WorkFlowQuery as ChildWorkFlowQuery;
use PHPWorkFlow\DB\Map\WorkFlowTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_work_flow' table.
 *
 *
 *
 * @method     ChildWorkFlowQuery orderByWorkFlowId($order = Criteria::ASC) Order by the work_flow_id column
 * @method     ChildWorkFlowQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildWorkFlowQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildWorkFlowQuery orderByTriggerClass($order = Criteria::ASC) Order by the trigger_class column
 * @method     ChildWorkFlowQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildWorkFlowQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildWorkFlowQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildWorkFlowQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildWorkFlowQuery groupByWorkFlowId() Group by the work_flow_id column
 * @method     ChildWorkFlowQuery groupByName() Group by the name column
 * @method     ChildWorkFlowQuery groupByDescription() Group by the description column
 * @method     ChildWorkFlowQuery groupByTriggerClass() Group by the trigger_class column
 * @method     ChildWorkFlowQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildWorkFlowQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildWorkFlowQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildWorkFlowQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildWorkFlowQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildWorkFlowQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildWorkFlowQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildWorkFlowQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildWorkFlowQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildWorkFlowQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildWorkFlowQuery leftJoinArc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arc relation
 * @method     ChildWorkFlowQuery rightJoinArc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arc relation
 * @method     ChildWorkFlowQuery innerJoinArc($relationAlias = null) Adds a INNER JOIN clause to the query using the Arc relation
 *
 * @method     ChildWorkFlowQuery joinWithArc($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Arc relation
 *
 * @method     ChildWorkFlowQuery leftJoinWithArc() Adds a LEFT JOIN clause and with to the query using the Arc relation
 * @method     ChildWorkFlowQuery rightJoinWithArc() Adds a RIGHT JOIN clause and with to the query using the Arc relation
 * @method     ChildWorkFlowQuery innerJoinWithArc() Adds a INNER JOIN clause and with to the query using the Arc relation
 *
 * @method     ChildWorkFlowQuery leftJoinPlace($relationAlias = null) Adds a LEFT JOIN clause to the query using the Place relation
 * @method     ChildWorkFlowQuery rightJoinPlace($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Place relation
 * @method     ChildWorkFlowQuery innerJoinPlace($relationAlias = null) Adds a INNER JOIN clause to the query using the Place relation
 *
 * @method     ChildWorkFlowQuery joinWithPlace($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Place relation
 *
 * @method     ChildWorkFlowQuery leftJoinWithPlace() Adds a LEFT JOIN clause and with to the query using the Place relation
 * @method     ChildWorkFlowQuery rightJoinWithPlace() Adds a RIGHT JOIN clause and with to the query using the Place relation
 * @method     ChildWorkFlowQuery innerJoinWithPlace() Adds a INNER JOIN clause and with to the query using the Place relation
 *
 * @method     ChildWorkFlowQuery leftJoinTransition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transition relation
 * @method     ChildWorkFlowQuery rightJoinTransition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transition relation
 * @method     ChildWorkFlowQuery innerJoinTransition($relationAlias = null) Adds a INNER JOIN clause to the query using the Transition relation
 *
 * @method     ChildWorkFlowQuery joinWithTransition($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transition relation
 *
 * @method     ChildWorkFlowQuery leftJoinWithTransition() Adds a LEFT JOIN clause and with to the query using the Transition relation
 * @method     ChildWorkFlowQuery rightJoinWithTransition() Adds a RIGHT JOIN clause and with to the query using the Transition relation
 * @method     ChildWorkFlowQuery innerJoinWithTransition() Adds a INNER JOIN clause and with to the query using the Transition relation
 *
 * @method     ChildWorkFlowQuery leftJoinUseCase($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCase relation
 * @method     ChildWorkFlowQuery rightJoinUseCase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCase relation
 * @method     ChildWorkFlowQuery innerJoinUseCase($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCase relation
 *
 * @method     ChildWorkFlowQuery joinWithUseCase($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCase relation
 *
 * @method     ChildWorkFlowQuery leftJoinWithUseCase() Adds a LEFT JOIN clause and with to the query using the UseCase relation
 * @method     ChildWorkFlowQuery rightJoinWithUseCase() Adds a RIGHT JOIN clause and with to the query using the UseCase relation
 * @method     ChildWorkFlowQuery innerJoinWithUseCase() Adds a INNER JOIN clause and with to the query using the UseCase relation
 *
 * @method     \PHPWorkFlow\DB\ArcQuery|\PHPWorkFlow\DB\PlaceQuery|\PHPWorkFlow\DB\TransitionQuery|\PHPWorkFlow\DB\UseCaseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildWorkFlow findOne(ConnectionInterface $con = null) Return the first ChildWorkFlow matching the query
 * @method     ChildWorkFlow findOneOrCreate(ConnectionInterface $con = null) Return the first ChildWorkFlow matching the query, or a new ChildWorkFlow object populated from the query conditions when no match is found
 *
 * @method     ChildWorkFlow findOneByWorkFlowId(int $work_flow_id) Return the first ChildWorkFlow filtered by the work_flow_id column
 * @method     ChildWorkFlow findOneByName(string $name) Return the first ChildWorkFlow filtered by the name column
 * @method     ChildWorkFlow findOneByDescription(string $description) Return the first ChildWorkFlow filtered by the description column
 * @method     ChildWorkFlow findOneByTriggerClass(string $trigger_class) Return the first ChildWorkFlow filtered by the trigger_class column
 * @method     ChildWorkFlow findOneByCreatedAt(string $created_at) Return the first ChildWorkFlow filtered by the created_at column
 * @method     ChildWorkFlow findOneByCreatedBy(int $created_by) Return the first ChildWorkFlow filtered by the created_by column
 * @method     ChildWorkFlow findOneByModifiedAt(string $modified_at) Return the first ChildWorkFlow filtered by the modified_at column
 * @method     ChildWorkFlow findOneByModifiedBy(int $modified_by) Return the first ChildWorkFlow filtered by the modified_by column *

 * @method     ChildWorkFlow requirePk($key, ConnectionInterface $con = null) Return the ChildWorkFlow by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOne(ConnectionInterface $con = null) Return the first ChildWorkFlow matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWorkFlow requireOneByWorkFlowId(int $work_flow_id) Return the first ChildWorkFlow filtered by the work_flow_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByName(string $name) Return the first ChildWorkFlow filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByDescription(string $description) Return the first ChildWorkFlow filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByTriggerClass(string $trigger_class) Return the first ChildWorkFlow filtered by the trigger_class column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByCreatedAt(string $created_at) Return the first ChildWorkFlow filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByCreatedBy(int $created_by) Return the first ChildWorkFlow filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByModifiedAt(string $modified_at) Return the first ChildWorkFlow filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildWorkFlow requireOneByModifiedBy(int $modified_by) Return the first ChildWorkFlow filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildWorkFlow[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildWorkFlow objects based on current ModelCriteria
 * @method     ChildWorkFlow[]|ObjectCollection findByWorkFlowId(int $work_flow_id) Return ChildWorkFlow objects filtered by the work_flow_id column
 * @method     ChildWorkFlow[]|ObjectCollection findByName(string $name) Return ChildWorkFlow objects filtered by the name column
 * @method     ChildWorkFlow[]|ObjectCollection findByDescription(string $description) Return ChildWorkFlow objects filtered by the description column
 * @method     ChildWorkFlow[]|ObjectCollection findByTriggerClass(string $trigger_class) Return ChildWorkFlow objects filtered by the trigger_class column
 * @method     ChildWorkFlow[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildWorkFlow objects filtered by the created_at column
 * @method     ChildWorkFlow[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildWorkFlow objects filtered by the created_by column
 * @method     ChildWorkFlow[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildWorkFlow objects filtered by the modified_at column
 * @method     ChildWorkFlow[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildWorkFlow objects filtered by the modified_by column
 * @method     ChildWorkFlow[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class WorkFlowQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\WorkFlowQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\WorkFlow', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildWorkFlowQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildWorkFlowQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildWorkFlowQuery) {
            return $criteria;
        }
        $query = new ChildWorkFlowQuery();
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
     * @return ChildWorkFlow|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WorkFlowTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(WorkFlowTableMap::DATABASE_NAME);
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
     * @return ChildWorkFlow A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT work_flow_id, name, description, trigger_class, created_at, created_by, modified_at, modified_by FROM PHPWF_work_flow WHERE work_flow_id = :p0';
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
            /** @var ChildWorkFlow $obj */
            $obj = new ChildWorkFlow();
            $obj->hydrate($row);
            WorkFlowTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildWorkFlow|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $keys, Criteria::IN);
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
     * @param     mixed $workFlowId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByWorkFlowId($workFlowId = null, $comparison = null)
    {
        if (is_array($workFlowId)) {
            $useMinMax = false;
            if (isset($workFlowId['min'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $workFlowId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($workFlowId['max'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $workFlowId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $workFlowId, $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WorkFlowTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WorkFlowTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the trigger_class column
     *
     * Example usage:
     * <code>
     * $query->filterByTriggerClass('fooValue');   // WHERE trigger_class = 'fooValue'
     * $query->filterByTriggerClass('%fooValue%'); // WHERE trigger_class LIKE '%fooValue%'
     * </code>
     *
     * @param     string $triggerClass The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByTriggerClass($triggerClass = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($triggerClass)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $triggerClass)) {
                $triggerClass = str_replace('*', '%', $triggerClass);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WorkFlowTableMap::COL_TRIGGER_CLASS, $triggerClass, $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkFlowTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkFlowTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkFlowTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(WorkFlowTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WorkFlowTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Arc object
     *
     * @param \PHPWorkFlow\DB\Arc|ObjectCollection $arc the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByArc($arc, $comparison = null)
    {
        if ($arc instanceof \PHPWorkFlow\DB\Arc) {
            return $this
                ->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $arc->getWorkFlowId(), $comparison);
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\Place object
     *
     * @param \PHPWorkFlow\DB\Place|ObjectCollection $place the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByPlace($place, $comparison = null)
    {
        if ($place instanceof \PHPWorkFlow\DB\Place) {
            return $this
                ->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $place->getWorkFlowId(), $comparison);
        } elseif ($place instanceof ObjectCollection) {
            return $this
                ->usePlaceQuery()
                ->filterByPrimaryKeys($place->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPlace() only accepts arguments of type \PHPWorkFlow\DB\Place or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Place relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function joinPlace($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Place');

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
            $this->addJoinObject($join, 'Place');
        }

        return $this;
    }

    /**
     * Use the Place relation Place object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\PlaceQuery A secondary query class using the current class as primary query
     */
    public function usePlaceQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPlace($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Place', '\PHPWorkFlow\DB\PlaceQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Transition object
     *
     * @param \PHPWorkFlow\DB\Transition|ObjectCollection $transition the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByTransition($transition, $comparison = null)
    {
        if ($transition instanceof \PHPWorkFlow\DB\Transition) {
            return $this
                ->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $transition->getWorkFlowId(), $comparison);
        } elseif ($transition instanceof ObjectCollection) {
            return $this
                ->useTransitionQuery()
                ->filterByPrimaryKeys($transition->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildWorkFlowQuery The current query, for fluid interface
     */
    public function filterByUseCase($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $useCase->getWorkFlowId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            return $this
                ->useUseCaseQuery()
                ->filterByPrimaryKeys($useCase->getPrimaryKeys())
                ->endUse();
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
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildWorkFlow $workFlow Object to remove from the list of results
     *
     * @return $this|ChildWorkFlowQuery The current query, for fluid interface
     */
    public function prune($workFlow = null)
    {
        if ($workFlow) {
            $this->addUsingAlias(WorkFlowTableMap::COL_WORK_FLOW_ID, $workFlow->getWorkFlowId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_work_flow table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(WorkFlowTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            WorkFlowTableMap::clearInstancePool();
            WorkFlowTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(WorkFlowTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(WorkFlowTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            WorkFlowTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            WorkFlowTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // WorkFlowQuery
