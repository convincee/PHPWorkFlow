<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\UseCaseContext as ChildUseCaseContext;
use PHPWorkFlow\DB\UseCaseContextQuery as ChildUseCaseContextQuery;
use PHPWorkFlow\DB\Map\UseCaseContextTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_use_case_context' table.
 *
 *
 *
 * @method     ChildUseCaseContextQuery orderByUseCaseContextId($order = Criteria::ASC) Order by the use_case_context_id column
 * @method     ChildUseCaseContextQuery orderByUseCaseId($order = Criteria::ASC) Order by the use_case_id column
 * @method     ChildUseCaseContextQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildUseCaseContextQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildUseCaseContextQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method     ChildUseCaseContextQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildUseCaseContextQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildUseCaseContextQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildUseCaseContextQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildUseCaseContextQuery groupByUseCaseContextId() Group by the use_case_context_id column
 * @method     ChildUseCaseContextQuery groupByUseCaseId() Group by the use_case_id column
 * @method     ChildUseCaseContextQuery groupByName() Group by the name column
 * @method     ChildUseCaseContextQuery groupByDescription() Group by the description column
 * @method     ChildUseCaseContextQuery groupByValue() Group by the value column
 * @method     ChildUseCaseContextQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildUseCaseContextQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildUseCaseContextQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildUseCaseContextQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildUseCaseContextQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUseCaseContextQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUseCaseContextQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUseCaseContextQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUseCaseContextQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUseCaseContextQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUseCaseContextQuery leftJoinUseCase($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCase relation
 * @method     ChildUseCaseContextQuery rightJoinUseCase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCase relation
 * @method     ChildUseCaseContextQuery innerJoinUseCase($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCase relation
 *
 * @method     ChildUseCaseContextQuery joinWithUseCase($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCase relation
 *
 * @method     ChildUseCaseContextQuery leftJoinWithUseCase() Adds a LEFT JOIN clause and with to the query using the UseCase relation
 * @method     ChildUseCaseContextQuery rightJoinWithUseCase() Adds a RIGHT JOIN clause and with to the query using the UseCase relation
 * @method     ChildUseCaseContextQuery innerJoinWithUseCase() Adds a INNER JOIN clause and with to the query using the UseCase relation
 *
 * @method     \PHPWorkFlow\DB\UseCaseQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUseCaseContext findOne(ConnectionInterface $con = null) Return the first ChildUseCaseContext matching the query
 * @method     ChildUseCaseContext findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUseCaseContext matching the query, or a new ChildUseCaseContext object populated from the query conditions when no match is found
 *
 * @method     ChildUseCaseContext findOneByUseCaseContextId(int $use_case_context_id) Return the first ChildUseCaseContext filtered by the use_case_context_id column
 * @method     ChildUseCaseContext findOneByUseCaseId(int $use_case_id) Return the first ChildUseCaseContext filtered by the use_case_id column
 * @method     ChildUseCaseContext findOneByName(string $name) Return the first ChildUseCaseContext filtered by the name column
 * @method     ChildUseCaseContext findOneByDescription(string $description) Return the first ChildUseCaseContext filtered by the description column
 * @method     ChildUseCaseContext findOneByValue(string $value) Return the first ChildUseCaseContext filtered by the value column
 * @method     ChildUseCaseContext findOneByCreatedAt(string $created_at) Return the first ChildUseCaseContext filtered by the created_at column
 * @method     ChildUseCaseContext findOneByCreatedBy(int $created_by) Return the first ChildUseCaseContext filtered by the created_by column
 * @method     ChildUseCaseContext findOneByModifiedAt(string $modified_at) Return the first ChildUseCaseContext filtered by the modified_at column
 * @method     ChildUseCaseContext findOneByModifiedBy(int $modified_by) Return the first ChildUseCaseContext filtered by the modified_by column *

 * @method     ChildUseCaseContext requirePk($key, ConnectionInterface $con = null) Return the ChildUseCaseContext by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOne(ConnectionInterface $con = null) Return the first ChildUseCaseContext matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUseCaseContext requireOneByUseCaseContextId(int $use_case_context_id) Return the first ChildUseCaseContext filtered by the use_case_context_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByUseCaseId(int $use_case_id) Return the first ChildUseCaseContext filtered by the use_case_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByName(string $name) Return the first ChildUseCaseContext filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByDescription(string $description) Return the first ChildUseCaseContext filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByValue(string $value) Return the first ChildUseCaseContext filtered by the value column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByCreatedAt(string $created_at) Return the first ChildUseCaseContext filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByCreatedBy(int $created_by) Return the first ChildUseCaseContext filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByModifiedAt(string $modified_at) Return the first ChildUseCaseContext filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUseCaseContext requireOneByModifiedBy(int $modified_by) Return the first ChildUseCaseContext filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUseCaseContext[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUseCaseContext objects based on current ModelCriteria
 * @method     ChildUseCaseContext[]|ObjectCollection findByUseCaseContextId(int $use_case_context_id) Return ChildUseCaseContext objects filtered by the use_case_context_id column
 * @method     ChildUseCaseContext[]|ObjectCollection findByUseCaseId(int $use_case_id) Return ChildUseCaseContext objects filtered by the use_case_id column
 * @method     ChildUseCaseContext[]|ObjectCollection findByName(string $name) Return ChildUseCaseContext objects filtered by the name column
 * @method     ChildUseCaseContext[]|ObjectCollection findByDescription(string $description) Return ChildUseCaseContext objects filtered by the description column
 * @method     ChildUseCaseContext[]|ObjectCollection findByValue(string $value) Return ChildUseCaseContext objects filtered by the value column
 * @method     ChildUseCaseContext[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildUseCaseContext objects filtered by the created_at column
 * @method     ChildUseCaseContext[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildUseCaseContext objects filtered by the created_by column
 * @method     ChildUseCaseContext[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildUseCaseContext objects filtered by the modified_at column
 * @method     ChildUseCaseContext[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildUseCaseContext objects filtered by the modified_by column
 * @method     ChildUseCaseContext[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UseCaseContextQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\UseCaseContextQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\UseCaseContext', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUseCaseContextQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUseCaseContextQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUseCaseContextQuery) {
            return $criteria;
        }
        $query = new ChildUseCaseContextQuery();
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
     * @return ChildUseCaseContext|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = UseCaseContextTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UseCaseContextTableMap::DATABASE_NAME);
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
     * @return ChildUseCaseContext A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT use_case_context_id, use_case_id, name, description, value, created_at, created_by, modified_at, modified_by FROM PHPWF_use_case_context WHERE use_case_context_id = :p0';
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
            /** @var ChildUseCaseContext $obj */
            $obj = new ChildUseCaseContext();
            $obj->hydrate($row);
            UseCaseContextTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildUseCaseContext|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the use_case_context_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUseCaseContextId(1234); // WHERE use_case_context_id = 1234
     * $query->filterByUseCaseContextId(array(12, 34)); // WHERE use_case_context_id IN (12, 34)
     * $query->filterByUseCaseContextId(array('min' => 12)); // WHERE use_case_context_id > 12
     * </code>
     *
     * @param     mixed $useCaseContextId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByUseCaseContextId($useCaseContextId = null, $comparison = null)
    {
        if (is_array($useCaseContextId)) {
            $useMinMax = false;
            if (isset($useCaseContextId['min'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, $useCaseContextId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useCaseContextId['max'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, $useCaseContextId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, $useCaseContextId, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByUseCaseId($useCaseId = null, $comparison = null)
    {
        if (is_array($useCaseId)) {
            $useMinMax = false;
            if (isset($useCaseId['min'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_ID, $useCaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useCaseId['max'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_ID, $useCaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_ID, $useCaseId, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UseCaseContextTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
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

        return $this->addUsingAlias(UseCaseContextTableMap::COL_DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_VALUE, $value, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(UseCaseContextTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UseCaseContextTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function filterByUseCase($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_ID, $useCase->getUseCaseId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_ID, $useCase->toKeyValue('PrimaryKey', 'UseCaseId'), $comparison);
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
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
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
     * @param   ChildUseCaseContext $useCaseContext Object to remove from the list of results
     *
     * @return $this|ChildUseCaseContextQuery The current query, for fluid interface
     */
    public function prune($useCaseContext = null)
    {
        if ($useCaseContext) {
            $this->addUsingAlias(UseCaseContextTableMap::COL_USE_CASE_CONTEXT_ID, $useCaseContext->getUseCaseContextId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_use_case_context table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseContextTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UseCaseContextTableMap::clearInstancePool();
            UseCaseContextTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UseCaseContextTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UseCaseContextTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UseCaseContextTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UseCaseContextTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UseCaseContextQuery
