<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\Arc as ChildArc;
use PHPWorkFlow\DB\ArcQuery as ChildArcQuery;
use PHPWorkFlow\DB\Map\ArcTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_arc' table.
 *
 *
 *
 * @method     ChildArcQuery orderByArcId($order = Criteria::ASC) Order by the arc_id column
 * @method     ChildArcQuery orderByWorkFlowId($order = Criteria::ASC) Order by the work_flow_id column
 * @method     ChildArcQuery orderByTransitionId($order = Criteria::ASC) Order by the transition_id column
 * @method     ChildArcQuery orderByPlaceId($order = Criteria::ASC) Order by the place_id column
 * @method     ChildArcQuery orderByDirection($order = Criteria::ASC) Order by the direction column
 * @method     ChildArcQuery orderByArcType($order = Criteria::ASC) Order by the arc_type column
 * @method     ChildArcQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildArcQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildArcQuery orderByYasperName($order = Criteria::ASC) Order by the yasper_name column
 * @method     ChildArcQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildArcQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildArcQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildArcQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildArcQuery groupByArcId() Group by the arc_id column
 * @method     ChildArcQuery groupByWorkFlowId() Group by the work_flow_id column
 * @method     ChildArcQuery groupByTransitionId() Group by the transition_id column
 * @method     ChildArcQuery groupByPlaceId() Group by the place_id column
 * @method     ChildArcQuery groupByDirection() Group by the direction column
 * @method     ChildArcQuery groupByArcType() Group by the arc_type column
 * @method     ChildArcQuery groupByDescription() Group by the description column
 * @method     ChildArcQuery groupByName() Group by the name column
 * @method     ChildArcQuery groupByYasperName() Group by the yasper_name column
 * @method     ChildArcQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildArcQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildArcQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildArcQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildArcQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildArcQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildArcQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildArcQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildArcQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildArcQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildArcQuery leftJoinWorkFlow($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkFlow relation
 * @method     ChildArcQuery rightJoinWorkFlow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkFlow relation
 * @method     ChildArcQuery innerJoinWorkFlow($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkFlow relation
 *
 * @method     ChildArcQuery joinWithWorkFlow($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkFlow relation
 *
 * @method     ChildArcQuery leftJoinWithWorkFlow() Adds a LEFT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildArcQuery rightJoinWithWorkFlow() Adds a RIGHT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildArcQuery innerJoinWithWorkFlow() Adds a INNER JOIN clause and with to the query using the WorkFlow relation
 *
 * @method     ChildArcQuery leftJoinTransition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Transition relation
 * @method     ChildArcQuery rightJoinTransition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Transition relation
 * @method     ChildArcQuery innerJoinTransition($relationAlias = null) Adds a INNER JOIN clause to the query using the Transition relation
 *
 * @method     ChildArcQuery joinWithTransition($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Transition relation
 *
 * @method     ChildArcQuery leftJoinWithTransition() Adds a LEFT JOIN clause and with to the query using the Transition relation
 * @method     ChildArcQuery rightJoinWithTransition() Adds a RIGHT JOIN clause and with to the query using the Transition relation
 * @method     ChildArcQuery innerJoinWithTransition() Adds a INNER JOIN clause and with to the query using the Transition relation
 *
 * @method     ChildArcQuery leftJoinPlace($relationAlias = null) Adds a LEFT JOIN clause to the query using the Place relation
 * @method     ChildArcQuery rightJoinPlace($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Place relation
 * @method     ChildArcQuery innerJoinPlace($relationAlias = null) Adds a INNER JOIN clause to the query using the Place relation
 *
 * @method     ChildArcQuery joinWithPlace($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Place relation
 *
 * @method     ChildArcQuery leftJoinWithPlace() Adds a LEFT JOIN clause and with to the query using the Place relation
 * @method     ChildArcQuery rightJoinWithPlace() Adds a RIGHT JOIN clause and with to the query using the Place relation
 * @method     ChildArcQuery innerJoinWithPlace() Adds a INNER JOIN clause and with to the query using the Place relation
 *
 * @method     ChildArcQuery leftJoinWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkItem relation
 * @method     ChildArcQuery rightJoinWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkItem relation
 * @method     ChildArcQuery innerJoinWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkItem relation
 *
 * @method     ChildArcQuery joinWithWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkItem relation
 *
 * @method     ChildArcQuery leftJoinWithWorkItem() Adds a LEFT JOIN clause and with to the query using the WorkItem relation
 * @method     ChildArcQuery rightJoinWithWorkItem() Adds a RIGHT JOIN clause and with to the query using the WorkItem relation
 * @method     ChildArcQuery innerJoinWithWorkItem() Adds a INNER JOIN clause and with to the query using the WorkItem relation
 *
 * @method     \PHPWorkFlow\DB\WorkFlowQuery|\PHPWorkFlow\DB\TransitionQuery|\PHPWorkFlow\DB\PlaceQuery|\PHPWorkFlow\DB\WorkItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildArc findOne(ConnectionInterface $con = null) Return the first ChildArc matching the query
 * @method     ChildArc findOneOrCreate(ConnectionInterface $con = null) Return the first ChildArc matching the query, or a new ChildArc object populated from the query conditions when no match is found
 *
 * @method     ChildArc findOneByArcId(int $arc_id) Return the first ChildArc filtered by the arc_id column
 * @method     ChildArc findOneByWorkFlowId(int $work_flow_id) Return the first ChildArc filtered by the work_flow_id column
 * @method     ChildArc findOneByTransitionId(int $transition_id) Return the first ChildArc filtered by the transition_id column
 * @method     ChildArc findOneByPlaceId(int $place_id) Return the first ChildArc filtered by the place_id column
 * @method     ChildArc findOneByDirection(string $direction) Return the first ChildArc filtered by the direction column
 * @method     ChildArc findOneByArcType(string $arc_type) Return the first ChildArc filtered by the arc_type column
 * @method     ChildArc findOneByDescription(string $description) Return the first ChildArc filtered by the description column
 * @method     ChildArc findOneByName(string $name) Return the first ChildArc filtered by the name column
 * @method     ChildArc findOneByYasperName(string $yasper_name) Return the first ChildArc filtered by the yasper_name column
 * @method     ChildArc findOneByCreatedAt(string $created_at) Return the first ChildArc filtered by the created_at column
 * @method     ChildArc findOneByCreatedBy(int $created_by) Return the first ChildArc filtered by the created_by column
 * @method     ChildArc findOneByModifiedAt(string $modified_at) Return the first ChildArc filtered by the modified_at column
 * @method     ChildArc findOneByModifiedBy(int $modified_by) Return the first ChildArc filtered by the modified_by column *

 * @method     ChildArc requirePk($key, ConnectionInterface $con = null) Return the ChildArc by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOne(ConnectionInterface $con = null) Return the first ChildArc matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArc requireOneByArcId(int $arc_id) Return the first ChildArc filtered by the arc_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByWorkFlowId(int $work_flow_id) Return the first ChildArc filtered by the work_flow_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByTransitionId(int $transition_id) Return the first ChildArc filtered by the transition_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByPlaceId(int $place_id) Return the first ChildArc filtered by the place_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByDirection(string $direction) Return the first ChildArc filtered by the direction column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByArcType(string $arc_type) Return the first ChildArc filtered by the arc_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByDescription(string $description) Return the first ChildArc filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByName(string $name) Return the first ChildArc filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByYasperName(string $yasper_name) Return the first ChildArc filtered by the yasper_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByCreatedAt(string $created_at) Return the first ChildArc filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByCreatedBy(int $created_by) Return the first ChildArc filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByModifiedAt(string $modified_at) Return the first ChildArc filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildArc requireOneByModifiedBy(int $modified_by) Return the first ChildArc filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildArc[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildArc objects based on current ModelCriteria
 * @method     ChildArc[]|ObjectCollection findByArcId(int $arc_id) Return ChildArc objects filtered by the arc_id column
 * @method     ChildArc[]|ObjectCollection findByWorkFlowId(int $work_flow_id) Return ChildArc objects filtered by the work_flow_id column
 * @method     ChildArc[]|ObjectCollection findByTransitionId(int $transition_id) Return ChildArc objects filtered by the transition_id column
 * @method     ChildArc[]|ObjectCollection findByPlaceId(int $place_id) Return ChildArc objects filtered by the place_id column
 * @method     ChildArc[]|ObjectCollection findByDirection(string $direction) Return ChildArc objects filtered by the direction column
 * @method     ChildArc[]|ObjectCollection findByArcType(string $arc_type) Return ChildArc objects filtered by the arc_type column
 * @method     ChildArc[]|ObjectCollection findByDescription(string $description) Return ChildArc objects filtered by the description column
 * @method     ChildArc[]|ObjectCollection findByName(string $name) Return ChildArc objects filtered by the name column
 * @method     ChildArc[]|ObjectCollection findByYasperName(string $yasper_name) Return ChildArc objects filtered by the yasper_name column
 * @method     ChildArc[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildArc objects filtered by the created_at column
 * @method     ChildArc[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildArc objects filtered by the created_by column
 * @method     ChildArc[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildArc objects filtered by the modified_at column
 * @method     ChildArc[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildArc objects filtered by the modified_by column
 * @method     ChildArc[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ArcQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\ArcQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\Arc', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildArcQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildArcQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildArcQuery) {
            return $criteria;
        }
        $query = new ChildArcQuery();
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
     * @return ChildArc|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ArcTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ArcTableMap::DATABASE_NAME);
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
     * @return ChildArc A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT arc_id, work_flow_id, transition_id, place_id, direction, arc_type, description, name, yasper_name, created_at, created_by, modified_at, modified_by FROM PHPWF_arc WHERE arc_id = :p0';
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
            /** @var ChildArc $obj */
            $obj = new ChildArc();
            $obj->hydrate($row);
            ArcTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildArc|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArcTableMap::COL_ARC_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArcTableMap::COL_ARC_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the arc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArcId(1234); // WHERE arc_id = 1234
     * $query->filterByArcId(array(12, 34)); // WHERE arc_id IN (12, 34)
     * $query->filterByArcId(array('min' => 12)); // WHERE arc_id > 12
     * </code>
     *
     * @param     mixed $arcId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByArcId($arcId = null, $comparison = null)
    {
        if (is_array($arcId)) {
            $useMinMax = false;
            if (isset($arcId['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_ARC_ID, $arcId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($arcId['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_ARC_ID, $arcId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_ARC_ID, $arcId, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByWorkFlowId($workFlowId = null, $comparison = null)
    {
        if (is_array($workFlowId)) {
            $useMinMax = false;
            if (isset($workFlowId['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_WORK_FLOW_ID, $workFlowId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($workFlowId['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_WORK_FLOW_ID, $workFlowId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_WORK_FLOW_ID, $workFlowId, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByTransitionId($transitionId = null, $comparison = null)
    {
        if (is_array($transitionId)) {
            $useMinMax = false;
            if (isset($transitionId['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_TRANSITION_ID, $transitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($transitionId['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_TRANSITION_ID, $transitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_TRANSITION_ID, $transitionId, $comparison);
    }

    /**
     * Filter the query on the place_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlaceId(1234); // WHERE place_id = 1234
     * $query->filterByPlaceId(array(12, 34)); // WHERE place_id IN (12, 34)
     * $query->filterByPlaceId(array('min' => 12)); // WHERE place_id > 12
     * </code>
     *
     * @see       filterByPlace()
     *
     * @param     mixed $placeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByPlaceId($placeId = null, $comparison = null)
    {
        if (is_array($placeId)) {
            $useMinMax = false;
            if (isset($placeId['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_PLACE_ID, $placeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($placeId['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_PLACE_ID, $placeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_PLACE_ID, $placeId, $comparison);
    }

    /**
     * Filter the query on the direction column
     *
     * Example usage:
     * <code>
     * $query->filterByDirection('fooValue');   // WHERE direction = 'fooValue'
     * $query->filterByDirection('%fooValue%'); // WHERE direction LIKE '%fooValue%'
     * </code>
     *
     * @param     string $direction The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByDirection($direction = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($direction)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $direction)) {
                $direction = str_replace('*', '%', $direction);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_DIRECTION, $direction, $comparison);
    }

    /**
     * Filter the query on the arc_type column
     *
     * Example usage:
     * <code>
     * $query->filterByArcType('fooValue');   // WHERE arc_type = 'fooValue'
     * $query->filterByArcType('%fooValue%'); // WHERE arc_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $arcType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByArcType($arcType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($arcType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $arcType)) {
                $arcType = str_replace('*', '%', $arcType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_ARC_TYPE, $arcType, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArcTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArcTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArcTableMap::COL_YASPER_NAME, $yasperName, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(ArcTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(ArcTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArcTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkFlow object
     *
     * @param \PHPWorkFlow\DB\WorkFlow|ObjectCollection $workFlow The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArcQuery The current query, for fluid interface
     */
    public function filterByWorkFlow($workFlow, $comparison = null)
    {
        if ($workFlow instanceof \PHPWorkFlow\DB\WorkFlow) {
            return $this
                ->addUsingAlias(ArcTableMap::COL_WORK_FLOW_ID, $workFlow->getWorkFlowId(), $comparison);
        } elseif ($workFlow instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArcTableMap::COL_WORK_FLOW_ID, $workFlow->toKeyValue('PrimaryKey', 'WorkFlowId'), $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\Transition object
     *
     * @param \PHPWorkFlow\DB\Transition|ObjectCollection $transition The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArcQuery The current query, for fluid interface
     */
    public function filterByTransition($transition, $comparison = null)
    {
        if ($transition instanceof \PHPWorkFlow\DB\Transition) {
            return $this
                ->addUsingAlias(ArcTableMap::COL_TRANSITION_ID, $transition->getTransitionId(), $comparison);
        } elseif ($transition instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArcTableMap::COL_TRANSITION_ID, $transition->toKeyValue('PrimaryKey', 'TransitionId'), $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\Place object
     *
     * @param \PHPWorkFlow\DB\Place|ObjectCollection $place The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildArcQuery The current query, for fluid interface
     */
    public function filterByPlace($place, $comparison = null)
    {
        if ($place instanceof \PHPWorkFlow\DB\Place) {
            return $this
                ->addUsingAlias(ArcTableMap::COL_PLACE_ID, $place->getPlaceId(), $comparison);
        } elseif ($place instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArcTableMap::COL_PLACE_ID, $place->toKeyValue('PrimaryKey', 'PlaceId'), $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\WorkItem object
     *
     * @param \PHPWorkFlow\DB\WorkItem|ObjectCollection $workItem the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildArcQuery The current query, for fluid interface
     */
    public function filterByWorkItem($workItem, $comparison = null)
    {
        if ($workItem instanceof \PHPWorkFlow\DB\WorkItem) {
            return $this
                ->addUsingAlias(ArcTableMap::COL_TRANSITION_ID, $workItem->getTransitionId(), $comparison);
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
     * @return $this|ChildArcQuery The current query, for fluid interface
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
     * @param   ChildArc $arc Object to remove from the list of results
     *
     * @return $this|ChildArcQuery The current query, for fluid interface
     */
    public function prune($arc = null)
    {
        if ($arc) {
            $this->addUsingAlias(ArcTableMap::COL_ARC_ID, $arc->getArcId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_arc table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ArcTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArcTableMap::clearInstancePool();
            ArcTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ArcTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ArcTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ArcTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ArcTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ArcQuery
