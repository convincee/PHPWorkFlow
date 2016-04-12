<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\UseCase as ChildUseCase;
use PHPWorkFlow\DB\UseCaseQuery as ChildUseCaseQuery;
use PHPWorkFlow\DB\Map\UseCaseTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_use_case' table.
 *
 *
 *
 * @method     ChildUseCaseQuery orderByUseCaseId($order = Criteria::ASC) Order by the use_case_id column
 * @method     ChildUseCaseQuery orderByWorkFlowId($order = Criteria::ASC) Order by the work_flow_id column
 * @method     ChildUseCaseQuery orderByParentUseCaseId($order = Criteria::ASC) Order by the parent_use_case_id column
 * @method     ChildUseCaseQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildUseCaseQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildUseCaseQuery orderByUseCaseGroup($order = Criteria::ASC) Order by the use_case_group column
 * @method     ChildUseCaseQuery orderByUseCaseStatus($order = Criteria::ASC) Order by the use_case_status column
 * @method     ChildUseCaseQuery orderByStartDate($order = Criteria::ASC) Order by the start_date column
 * @method     ChildUseCaseQuery orderByEndDate($order = Criteria::ASC) Order by the end_date column
 * @method     ChildUseCaseQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUseCaseQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildUseCaseQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildUseCaseQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildUseCaseQuery groupByUseCaseId() Group by the use_case_id column
 * @method     ChildUseCaseQuery groupByWorkFlowId() Group by the work_flow_id column
 * @method     ChildUseCaseQuery groupByParentUseCaseId() Group by the parent_use_case_id column
 * @method     ChildUseCaseQuery groupByName() Group by the name column
 * @method     ChildUseCaseQuery groupByDescription() Group by the description column
 * @method     ChildUseCaseQuery groupByUseCaseGroup() Group by the use_case_group column
 * @method     ChildUseCaseQuery groupByUseCaseStatus() Group by the use_case_status column
 * @method     ChildUseCaseQuery groupByStartDate() Group by the start_date column
 * @method     ChildUseCaseQuery groupByEndDate() Group by the end_date column
 * @method     ChildUseCaseQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUseCaseQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildUseCaseQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildUseCaseQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildUseCaseQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUseCaseQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUseCaseQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUseCaseQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUseCaseQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUseCaseQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUseCaseQuery leftJoinUseCaseRelatedByParentUseCaseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCaseRelatedByParentUseCaseId relation
 * @method     ChildUseCaseQuery rightJoinUseCaseRelatedByParentUseCaseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCaseRelatedByParentUseCaseId relation
 * @method     ChildUseCaseQuery innerJoinUseCaseRelatedByParentUseCaseId($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCaseRelatedByParentUseCaseId relation
 *
 * @method     ChildUseCaseQuery joinWithUseCaseRelatedByParentUseCaseId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCaseRelatedByParentUseCaseId relation
 *
 * @method     ChildUseCaseQuery leftJoinWithUseCaseRelatedByParentUseCaseId() Adds a LEFT JOIN clause and with to the query using the UseCaseRelatedByParentUseCaseId relation
 * @method     ChildUseCaseQuery rightJoinWithUseCaseRelatedByParentUseCaseId() Adds a RIGHT JOIN clause and with to the query using the UseCaseRelatedByParentUseCaseId relation
 * @method     ChildUseCaseQuery innerJoinWithUseCaseRelatedByParentUseCaseId() Adds a INNER JOIN clause and with to the query using the UseCaseRelatedByParentUseCaseId relation
 *
 * @method     ChildUseCaseQuery leftJoinWorkFlow($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkFlow relation
 * @method     ChildUseCaseQuery rightJoinWorkFlow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkFlow relation
 * @method     ChildUseCaseQuery innerJoinWorkFlow($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkFlow relation
 *
 * @method     ChildUseCaseQuery joinWithWorkFlow($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkFlow relation
 *
 * @method     ChildUseCaseQuery leftJoinWithWorkFlow() Adds a LEFT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildUseCaseQuery rightJoinWithWorkFlow() Adds a RIGHT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildUseCaseQuery innerJoinWithWorkFlow() Adds a INNER JOIN clause and with to the query using the WorkFlow relation
 *
 * @method     ChildUseCaseQuery leftJoinToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the Token relation
 * @method     ChildUseCaseQuery rightJoinToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Token relation
 * @method     ChildUseCaseQuery innerJoinToken($relationAlias = null) Adds a INNER JOIN clause to the query using the Token relation
 *
 * @method     ChildUseCaseQuery joinWithToken($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Token relation
 *
 * @method     ChildUseCaseQuery leftJoinWithToken() Adds a LEFT JOIN clause and with to the query using the Token relation
 * @method     ChildUseCaseQuery rightJoinWithToken() Adds a RIGHT JOIN clause and with to the query using the Token relation
 * @method     ChildUseCaseQuery innerJoinWithToken() Adds a INNER JOIN clause and with to the query using the Token relation
 *
 * @method     ChildUseCaseQuery leftJoinTriggerFulfillment($relationAlias = null) Adds a LEFT JOIN clause to the query using the TriggerFulfillment relation
 * @method     ChildUseCaseQuery rightJoinTriggerFulfillment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the TriggerFulfillment relation
 * @method     ChildUseCaseQuery innerJoinTriggerFulfillment($relationAlias = null) Adds a INNER JOIN clause to the query using the TriggerFulfillment relation
 *
 * @method     ChildUseCaseQuery joinWithTriggerFulfillment($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the TriggerFulfillment relation
 *
 * @method     ChildUseCaseQuery leftJoinWithTriggerFulfillment() Adds a LEFT JOIN clause and with to the query using the TriggerFulfillment relation
 * @method     ChildUseCaseQuery rightJoinWithTriggerFulfillment() Adds a RIGHT JOIN clause and with to the query using the TriggerFulfillment relation
 * @method     ChildUseCaseQuery innerJoinWithTriggerFulfillment() Adds a INNER JOIN clause and with to the query using the TriggerFulfillment relation
 *
 * @method     ChildUseCaseQuery leftJoinUseCaseRelatedByUseCaseId($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCaseRelatedByUseCaseId relation
 * @method     ChildUseCaseQuery rightJoinUseCaseRelatedByUseCaseId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCaseRelatedByUseCaseId relation
 * @method     ChildUseCaseQuery innerJoinUseCaseRelatedByUseCaseId($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCaseRelatedByUseCaseId relation
 *
 * @method     ChildUseCaseQuery joinWithUseCaseRelatedByUseCaseId($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCaseRelatedByUseCaseId relation
 *
 * @method     ChildUseCaseQuery leftJoinWithUseCaseRelatedByUseCaseId() Adds a LEFT JOIN clause and with to the query using the UseCaseRelatedByUseCaseId relation
 * @method     ChildUseCaseQuery rightJoinWithUseCaseRelatedByUseCaseId() Adds a RIGHT JOIN clause and with to the query using the UseCaseRelatedByUseCaseId relation
 * @method     ChildUseCaseQuery innerJoinWithUseCaseRelatedByUseCaseId() Adds a INNER JOIN clause and with to the query using the UseCaseRelatedByUseCaseId relation
 *
 * @method     ChildUseCaseQuery leftJoinUseCaseContext($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCaseContext relation
 * @method     ChildUseCaseQuery rightJoinUseCaseContext($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCaseContext relation
 * @method     ChildUseCaseQuery innerJoinUseCaseContext($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCaseContext relation
 *
 * @method     ChildUseCaseQuery joinWithUseCaseContext($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCaseContext relation
 *
 * @method     ChildUseCaseQuery leftJoinWithUseCaseContext() Adds a LEFT JOIN clause and with to the query using the UseCaseContext relation
 * @method     ChildUseCaseQuery rightJoinWithUseCaseContext() Adds a RIGHT JOIN clause and with to the query using the UseCaseContext relation
 * @method     ChildUseCaseQuery innerJoinWithUseCaseContext() Adds a INNER JOIN clause and with to the query using the UseCaseContext relation
 *
 * @method     ChildUseCaseQuery leftJoinWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkItem relation
 * @method     ChildUseCaseQuery rightJoinWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkItem relation
 * @method     ChildUseCaseQuery innerJoinWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkItem relation
 *
 * @method     ChildUseCaseQuery joinWithWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkItem relation
 *
 * @method     ChildUseCaseQuery leftJoinWithWorkItem() Adds a LEFT JOIN clause and with to the query using the WorkItem relation
 * @method     ChildUseCaseQuery rightJoinWithWorkItem() Adds a RIGHT JOIN clause and with to the query using the WorkItem relation
 * @method     ChildUseCaseQuery innerJoinWithWorkItem() Adds a INNER JOIN clause and with to the query using the WorkItem relation
 *
 * @method     \PHPWorkFlow\DB\UseCaseQuery|\PHPWorkFlow\DB\WorkFlowQuery|\PHPWorkFlow\DB\TokenQuery|\PHPWorkFlow\DB\TriggerFulfillmentQuery|\PHPWorkFlow\DB\UseCaseContextQuery|\PHPWorkFlow\DB\WorkItemQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUseCase findOne(ConnectionInterface $con = null) Return the first ChildUseCase matching the query
 * @method     ChildUseCase findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUseCase matching the query, or a new ChildUseCase object populated from the query conditions when no match is found
 *
 * @method     ChildUseCase findOneByUseCaseId(int $use_case_id) Return the first ChildUseCase filtered by the use_case_id column
 * @method     ChildUseCase findOneByWorkFlowId(int $work_flow_id) Return the first ChildUseCase filtered by the work_flow_id column
 * @method     ChildUseCase findOneByParentUseCaseId(int $parent_use_case_id) Return the first ChildUseCase filtered by the parent_use_case_id column
 * @method     ChildUseCase findOneByName(string $name) Return the first ChildUseCase filtered by the name column
 * @method     ChildUseCase findOneByDescription(string $description) Return the first ChildUseCase filtered by the description column
 * @method     ChildUseCase findOneByUseCaseGroup(string $use_case_group) Return the first ChildUseCase filtered by the use_case_group column
 * @method     ChildUseCase findOneByUseCaseStatus(string $use_case_status) Return the first ChildUseCase filtered by the use_case_status column
 * @method     ChildUseCase findOneByStartDate(string $start_date) Return the first ChildUseCase filtered by the start_date column
 * @method     ChildUseCase findOneByEndDate(string $end_date) Return the first ChildUseCase filtered by the end_date column
 * @method     ChildUseCase findOneByCreatedAt(string $created_at) Return the first ChildUseCase filtered by the created_at column
 * @method     ChildUseCase findOneByCreatedBy(int $created_by) Return the first ChildUseCase filtered by the created_by column
 * @method     ChildUseCase findOneByModifiedAt(string $modified_at) Return the first ChildUseCase filtered by the modified_at column
 * @method     ChildUseCase findOneByModifiedBy(int $modified_by) Return the first ChildUseCase filtered by the modified_by column *

 * @method     ChildUseCase requirePk($key, ConnectionInterface $con = null) Return the ChildUseCase by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOne(ConnectionInterface $con = null) Return the first ChildUseCase matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUseCase requireOneByUseCaseId(int $use_case_id) Return the first ChildUseCase filtered by the use_case_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByWorkFlowId(int $work_flow_id) Return the first ChildUseCase filtered by the work_flow_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByParentUseCaseId(int $parent_use_case_id) Return the first ChildUseCase filtered by the parent_use_case_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByName(string $name) Return the first ChildUseCase filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByDescription(string $description) Return the first ChildUseCase filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByUseCaseGroup(string $use_case_group) Return the first ChildUseCase filtered by the use_case_group column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByUseCaseStatus(string $use_case_status) Return the first ChildUseCase filtered by the use_case_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByStartDate(string $start_date) Return the first ChildUseCase filtered by the start_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByEndDate(string $end_date) Return the first ChildUseCase filtered by the end_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByCreatedAt(string $created_at) Return the first ChildUseCase filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByCreatedBy(int $created_by) Return the first ChildUseCase filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByModifiedAt(string $modified_at) Return the first ChildUseCase filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCase requireOneByModifiedBy(int $modified_by) Return the first ChildUseCase filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUseCase[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUseCase objects based on current ModelCriteria
 * @method     ChildUseCase[]|ObjectCollection findByUseCaseId(int $use_case_id) Return ChildUseCase objects filtered by the use_case_id column
 * @method     ChildUseCase[]|ObjectCollection findByWorkFlowId(int $work_flow_id) Return ChildUseCase objects filtered by the work_flow_id column
 * @method     ChildUseCase[]|ObjectCollection findByParentUseCaseId(int $parent_use_case_id) Return ChildUseCase objects filtered by the parent_use_case_id column
 * @method     ChildUseCase[]|ObjectCollection findByName(string $name) Return ChildUseCase objects filtered by the name column
 * @method     ChildUseCase[]|ObjectCollection findByDescription(string $description) Return ChildUseCase objects filtered by the description column
 * @method     ChildUseCase[]|ObjectCollection findByUseCaseGroup(string $use_case_group) Return ChildUseCase objects filtered by the use_case_group column
 * @method     ChildUseCase[]|ObjectCollection findByUseCaseStatus(string $use_case_status) Return ChildUseCase objects filtered by the use_case_status column
 * @method     ChildUseCase[]|ObjectCollection findByStartDate(string $start_date) Return ChildUseCase objects filtered by the start_date column
 * @method     ChildUseCase[]|ObjectCollection findByEndDate(string $end_date) Return ChildUseCase objects filtered by the end_date column
 * @method     ChildUseCase[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUseCase objects filtered by the created_at column
 * @method     ChildUseCase[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildUseCase objects filtered by the created_by column
 * @method     ChildUseCase[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildUseCase objects filtered by the modified_at column
 * @method     ChildUseCase[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildUseCase objects filtered by the modified_by column
 * @method     ChildUseCase[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UseCaseQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\UseCaseQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\UseCase', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUseCaseQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUseCaseQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUseCaseQuery) {
            return $criteria;
        }
        $query = new ChildUseCaseQuery();
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
     * @return ChildUseCase|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UseCaseTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UseCaseTableMap::DATABASE_NAME);
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
     * @return ChildUseCase A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT use_case_id, work_flow_id, parent_use_case_id, name, description, use_case_group, use_case_status, start_date, end_date, created_at, created_by, modified_at, modified_by FROM PHPWF_use_case WHERE use_case_id = :p0';
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
            /** @var ChildUseCase $obj */
            $obj = new ChildUseCase();
            $obj->hydrate($row);
            UseCaseTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUseCase|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $keys, Criteria::IN);
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
     * @param     mixed $useCaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByUseCaseId($useCaseId = null, $comparison = null)
    {
        if (is_array($useCaseId)) {
            $useMinMax = false;
            if (isset($useCaseId['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $useCaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useCaseId['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $useCaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $useCaseId, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByWorkFlowId($workFlowId = null, $comparison = null)
    {
        if (is_array($workFlowId)) {
            $useMinMax = false;
            if (isset($workFlowId['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_WORK_FLOW_ID, $workFlowId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($workFlowId['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_WORK_FLOW_ID, $workFlowId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_WORK_FLOW_ID, $workFlowId, $comparison);
    }

    /**
     * Filter the query on the parent_use_case_id column
     *
     * Example usage:
     * <code>
     * $query->filterByParentUseCaseId(1234); // WHERE parent_use_case_id = 1234
     * $query->filterByParentUseCaseId(array(12, 34)); // WHERE parent_use_case_id IN (12, 34)
     * $query->filterByParentUseCaseId(array('min' => 12)); // WHERE parent_use_case_id > 12
     * </code>
     *
     * @see       filterByUseCaseRelatedByParentUseCaseId()
     *
     * @param     mixed $parentUseCaseId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByParentUseCaseId($parentUseCaseId = null, $comparison = null)
    {
        if (is_array($parentUseCaseId)) {
            $useMinMax = false;
            if (isset($parentUseCaseId['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_PARENT_USE_CASE_ID, $parentUseCaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parentUseCaseId['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_PARENT_USE_CASE_ID, $parentUseCaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_PARENT_USE_CASE_ID, $parentUseCaseId, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UseCaseTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UseCaseTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the use_case_group column
     *
     * Example usage:
     * <code>
     * $query->filterByUseCaseGroup('fooValue');   // WHERE use_case_group = 'fooValue'
     * $query->filterByUseCaseGroup('%fooValue%'); // WHERE use_case_group LIKE '%fooValue%'
     * </code>
     *
     * @param     string $useCaseGroup The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByUseCaseGroup($useCaseGroup = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($useCaseGroup)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $useCaseGroup)) {
                $useCaseGroup = str_replace('*', '%', $useCaseGroup);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_GROUP, $useCaseGroup, $comparison);
    }

    /**
     * Filter the query on the use_case_status column
     *
     * Example usage:
     * <code>
     * $query->filterByUseCaseStatus('fooValue');   // WHERE use_case_status = 'fooValue'
     * $query->filterByUseCaseStatus('%fooValue%'); // WHERE use_case_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $useCaseStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByUseCaseStatus($useCaseStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($useCaseStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $useCaseStatus)) {
                $useCaseStatus = str_replace('*', '%', $useCaseStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_STATUS, $useCaseStatus, $comparison);
    }

    /**
     * Filter the query on the start_date column
     *
     * Example usage:
     * <code>
     * $query->filterByStartDate('2011-03-14'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate('now'); // WHERE start_date = '2011-03-14'
     * $query->filterByStartDate(array('max' => 'yesterday')); // WHERE start_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $startDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByStartDate($startDate = null, $comparison = null)
    {
        if (is_array($startDate)) {
            $useMinMax = false;
            if (isset($startDate['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_START_DATE, $startDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($startDate['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_START_DATE, $startDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_START_DATE, $startDate, $comparison);
    }

    /**
     * Filter the query on the end_date column
     *
     * Example usage:
     * <code>
     * $query->filterByEndDate('2011-03-14'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate('now'); // WHERE end_date = '2011-03-14'
     * $query->filterByEndDate(array('max' => 'yesterday')); // WHERE end_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $endDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByEndDate($endDate = null, $comparison = null)
    {
        if (is_array($endDate)) {
            $useMinMax = false;
            if (isset($endDate['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_END_DATE, $endDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($endDate['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_END_DATE, $endDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_END_DATE, $endDate, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(UseCaseTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByUseCaseRelatedByParentUseCaseId($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_PARENT_USE_CASE_ID, $useCase->getUseCaseId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UseCaseTableMap::COL_PARENT_USE_CASE_ID, $useCase->toKeyValue('PrimaryKey', 'UseCaseId'), $comparison);
        } else {
            throw new PropelException('filterByUseCaseRelatedByParentUseCaseId() only accepts arguments of type \PHPWorkFlow\DB\UseCase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UseCaseRelatedByParentUseCaseId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function joinUseCaseRelatedByParentUseCaseId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UseCaseRelatedByParentUseCaseId');

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
            $this->addJoinObject($join, 'UseCaseRelatedByParentUseCaseId');
        }

        return $this;
    }

    /**
     * Use the UseCaseRelatedByParentUseCaseId relation UseCase object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\UseCaseQuery A secondary query class using the current class as primary query
     */
    public function useUseCaseRelatedByParentUseCaseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUseCaseRelatedByParentUseCaseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UseCaseRelatedByParentUseCaseId', '\PHPWorkFlow\DB\UseCaseQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkFlow object
     *
     * @param \PHPWorkFlow\DB\WorkFlow|ObjectCollection $workFlow The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByWorkFlow($workFlow, $comparison = null)
    {
        if ($workFlow instanceof \PHPWorkFlow\DB\WorkFlow) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_WORK_FLOW_ID, $workFlow->getWorkFlowId(), $comparison);
        } elseif ($workFlow instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UseCaseTableMap::COL_WORK_FLOW_ID, $workFlow->toKeyValue('PrimaryKey', 'WorkFlowId'), $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\Token object
     *
     * @param \PHPWorkFlow\DB\Token|ObjectCollection $token the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByToken($token, $comparison = null)
    {
        if ($token instanceof \PHPWorkFlow\DB\Token) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $token->getUseCaseId(), $comparison);
        } elseif ($token instanceof ObjectCollection) {
            return $this
                ->useTokenQuery()
                ->filterByPrimaryKeys($token->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByToken() only accepts arguments of type \PHPWorkFlow\DB\Token or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Token relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function joinToken($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Token');

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
            $this->addJoinObject($join, 'Token');
        }

        return $this;
    }

    /**
     * Use the Token relation Token object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\TokenQuery A secondary query class using the current class as primary query
     */
    public function useTokenQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinToken($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Token', '\PHPWorkFlow\DB\TokenQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\TriggerFulfillment object
     *
     * @param \PHPWorkFlow\DB\TriggerFulfillment|ObjectCollection $triggerFulfillment the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByTriggerFulfillment($triggerFulfillment, $comparison = null)
    {
        if ($triggerFulfillment instanceof \PHPWorkFlow\DB\TriggerFulfillment) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $triggerFulfillment->getUseCaseId(), $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByUseCaseRelatedByUseCaseId($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $useCase->getParentUseCaseId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            return $this
                ->useUseCaseRelatedByUseCaseIdQuery()
                ->filterByPrimaryKeys($useCase->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUseCaseRelatedByUseCaseId() only accepts arguments of type \PHPWorkFlow\DB\UseCase or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UseCaseRelatedByUseCaseId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function joinUseCaseRelatedByUseCaseId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UseCaseRelatedByUseCaseId');

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
            $this->addJoinObject($join, 'UseCaseRelatedByUseCaseId');
        }

        return $this;
    }

    /**
     * Use the UseCaseRelatedByUseCaseId relation UseCase object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\UseCaseQuery A secondary query class using the current class as primary query
     */
    public function useUseCaseRelatedByUseCaseIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinUseCaseRelatedByUseCaseId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UseCaseRelatedByUseCaseId', '\PHPWorkFlow\DB\UseCaseQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\UseCaseContext object
     *
     * @param \PHPWorkFlow\DB\UseCaseContext|ObjectCollection $useCaseContext the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByUseCaseContext($useCaseContext, $comparison = null)
    {
        if ($useCaseContext instanceof \PHPWorkFlow\DB\UseCaseContext) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $useCaseContext->getUseCaseId(), $comparison);
        } elseif ($useCaseContext instanceof ObjectCollection) {
            return $this
                ->useUseCaseContextQuery()
                ->filterByPrimaryKeys($useCaseContext->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUseCaseContext() only accepts arguments of type \PHPWorkFlow\DB\UseCaseContext or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UseCaseContext relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function joinUseCaseContext($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UseCaseContext');

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
            $this->addJoinObject($join, 'UseCaseContext');
        }

        return $this;
    }

    /**
     * Use the UseCaseContext relation UseCaseContext object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\UseCaseContextQuery A secondary query class using the current class as primary query
     */
    public function useUseCaseContextQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUseCaseContext($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UseCaseContext', '\PHPWorkFlow\DB\UseCaseContextQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkItem object
     *
     * @param \PHPWorkFlow\DB\WorkItem|ObjectCollection $workItem the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUseCaseQuery The current query, for fluid interface
     */
    public function filterByWorkItem($workItem, $comparison = null)
    {
        if ($workItem instanceof \PHPWorkFlow\DB\WorkItem) {
            return $this
                ->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $workItem->getUseCaseId(), $comparison);
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
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
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
     * @param   ChildUseCase $useCase Object to remove from the list of results
     *
     * @return $this|ChildUseCaseQuery The current query, for fluid interface
     */
    public function prune($useCase = null)
    {
        if ($useCase) {
            $this->addUsingAlias(UseCaseTableMap::COL_USE_CASE_ID, $useCase->getUseCaseId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_use_case table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UseCaseTableMap::clearInstancePool();
            UseCaseTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UseCaseTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UseCaseTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UseCaseTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UseCaseQuery
