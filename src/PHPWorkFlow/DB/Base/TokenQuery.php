<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\Token as ChildToken;
use PHPWorkFlow\DB\TokenQuery as ChildTokenQuery;
use PHPWorkFlow\DB\Map\TokenTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_token' table.
 *
 *
 *
 * @method     ChildTokenQuery orderByTokenId($order = Criteria::ASC) Order by the token_id column
 * @method     ChildTokenQuery orderByUseCaseId($order = Criteria::ASC) Order by the use_case_id column
 * @method     ChildTokenQuery orderByPlaceId($order = Criteria::ASC) Order by the place_id column
 * @method     ChildTokenQuery orderByCreatingWorkItemId($order = Criteria::ASC) Order by the creating_work_item_id column
 * @method     ChildTokenQuery orderByConsumingWorkItemId($order = Criteria::ASC) Order by the consuming_work_item_id column
 * @method     ChildTokenQuery orderByTokenStatus($order = Criteria::ASC) Order by the token_status column
 * @method     ChildTokenQuery orderByEnabledDate($order = Criteria::ASC) Order by the enabled_date column
 * @method     ChildTokenQuery orderByCancelledDate($order = Criteria::ASC) Order by the cancelled_date column
 * @method     ChildTokenQuery orderByConsumedDate($order = Criteria::ASC) Order by the consumed_date column
 * @method     ChildTokenQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildTokenQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildTokenQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildTokenQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildTokenQuery groupByTokenId() Group by the token_id column
 * @method     ChildTokenQuery groupByUseCaseId() Group by the use_case_id column
 * @method     ChildTokenQuery groupByPlaceId() Group by the place_id column
 * @method     ChildTokenQuery groupByCreatingWorkItemId() Group by the creating_work_item_id column
 * @method     ChildTokenQuery groupByConsumingWorkItemId() Group by the consuming_work_item_id column
 * @method     ChildTokenQuery groupByTokenStatus() Group by the token_status column
 * @method     ChildTokenQuery groupByEnabledDate() Group by the enabled_date column
 * @method     ChildTokenQuery groupByCancelledDate() Group by the cancelled_date column
 * @method     ChildTokenQuery groupByConsumedDate() Group by the consumed_date column
 * @method     ChildTokenQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildTokenQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildTokenQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildTokenQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildTokenQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildTokenQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildTokenQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildTokenQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildTokenQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildTokenQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildTokenQuery leftJoinUseCase($relationAlias = null) Adds a LEFT JOIN clause to the query using the UseCase relation
 * @method     ChildTokenQuery rightJoinUseCase($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UseCase relation
 * @method     ChildTokenQuery innerJoinUseCase($relationAlias = null) Adds a INNER JOIN clause to the query using the UseCase relation
 *
 * @method     ChildTokenQuery joinWithUseCase($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UseCase relation
 *
 * @method     ChildTokenQuery leftJoinWithUseCase() Adds a LEFT JOIN clause and with to the query using the UseCase relation
 * @method     ChildTokenQuery rightJoinWithUseCase() Adds a RIGHT JOIN clause and with to the query using the UseCase relation
 * @method     ChildTokenQuery innerJoinWithUseCase() Adds a INNER JOIN clause and with to the query using the UseCase relation
 *
 * @method     ChildTokenQuery leftJoinCreatingWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the CreatingWorkItem relation
 * @method     ChildTokenQuery rightJoinCreatingWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CreatingWorkItem relation
 * @method     ChildTokenQuery innerJoinCreatingWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the CreatingWorkItem relation
 *
 * @method     ChildTokenQuery joinWithCreatingWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CreatingWorkItem relation
 *
 * @method     ChildTokenQuery leftJoinWithCreatingWorkItem() Adds a LEFT JOIN clause and with to the query using the CreatingWorkItem relation
 * @method     ChildTokenQuery rightJoinWithCreatingWorkItem() Adds a RIGHT JOIN clause and with to the query using the CreatingWorkItem relation
 * @method     ChildTokenQuery innerJoinWithCreatingWorkItem() Adds a INNER JOIN clause and with to the query using the CreatingWorkItem relation
 *
 * @method     ChildTokenQuery leftJoinConsumingWorkItem($relationAlias = null) Adds a LEFT JOIN clause to the query using the ConsumingWorkItem relation
 * @method     ChildTokenQuery rightJoinConsumingWorkItem($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ConsumingWorkItem relation
 * @method     ChildTokenQuery innerJoinConsumingWorkItem($relationAlias = null) Adds a INNER JOIN clause to the query using the ConsumingWorkItem relation
 *
 * @method     ChildTokenQuery joinWithConsumingWorkItem($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ConsumingWorkItem relation
 *
 * @method     ChildTokenQuery leftJoinWithConsumingWorkItem() Adds a LEFT JOIN clause and with to the query using the ConsumingWorkItem relation
 * @method     ChildTokenQuery rightJoinWithConsumingWorkItem() Adds a RIGHT JOIN clause and with to the query using the ConsumingWorkItem relation
 * @method     ChildTokenQuery innerJoinWithConsumingWorkItem() Adds a INNER JOIN clause and with to the query using the ConsumingWorkItem relation
 *
 * @method     ChildTokenQuery leftJoinPlace($relationAlias = null) Adds a LEFT JOIN clause to the query using the Place relation
 * @method     ChildTokenQuery rightJoinPlace($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Place relation
 * @method     ChildTokenQuery innerJoinPlace($relationAlias = null) Adds a INNER JOIN clause to the query using the Place relation
 *
 * @method     ChildTokenQuery joinWithPlace($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Place relation
 *
 * @method     ChildTokenQuery leftJoinWithPlace() Adds a LEFT JOIN clause and with to the query using the Place relation
 * @method     ChildTokenQuery rightJoinWithPlace() Adds a RIGHT JOIN clause and with to the query using the Place relation
 * @method     ChildTokenQuery innerJoinWithPlace() Adds a INNER JOIN clause and with to the query using the Place relation
 *
 * @method     \PHPWorkFlow\DB\UseCaseQuery|\PHPWorkFlow\DB\WorkItemQuery|\PHPWorkFlow\DB\PlaceQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildToken findOne(ConnectionInterface $con = null) Return the first ChildToken matching the query
 * @method     ChildToken findOneOrCreate(ConnectionInterface $con = null) Return the first ChildToken matching the query, or a new ChildToken object populated from the query conditions when no match is found
 *
 * @method     ChildToken findOneByTokenId(int $token_id) Return the first ChildToken filtered by the token_id column
 * @method     ChildToken findOneByUseCaseId(int $use_case_id) Return the first ChildToken filtered by the use_case_id column
 * @method     ChildToken findOneByPlaceId(int $place_id) Return the first ChildToken filtered by the place_id column
 * @method     ChildToken findOneByCreatingWorkItemId(int $creating_work_item_id) Return the first ChildToken filtered by the creating_work_item_id column
 * @method     ChildToken findOneByConsumingWorkItemId(int $consuming_work_item_id) Return the first ChildToken filtered by the consuming_work_item_id column
 * @method     ChildToken findOneByTokenStatus(string $token_status) Return the first ChildToken filtered by the token_status column
 * @method     ChildToken findOneByEnabledDate(string $enabled_date) Return the first ChildToken filtered by the enabled_date column
 * @method     ChildToken findOneByCancelledDate(string $cancelled_date) Return the first ChildToken filtered by the cancelled_date column
 * @method     ChildToken findOneByConsumedDate(string $consumed_date) Return the first ChildToken filtered by the consumed_date column
 * @method     ChildToken findOneByCreatedAt(string $created_at) Return the first ChildToken filtered by the created_at column
 * @method     ChildToken findOneByCreatedBy(int $created_by) Return the first ChildToken filtered by the created_by column
 * @method     ChildToken findOneByModifiedAt(string $modified_at) Return the first ChildToken filtered by the modified_at column
 * @method     ChildToken findOneByModifiedBy(int $modified_by) Return the first ChildToken filtered by the modified_by column *

 * @method     ChildToken requirePk($key, ConnectionInterface $con = null) Return the ChildToken by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOne(ConnectionInterface $con = null) Return the first ChildToken matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildToken requireOneByTokenId(int $token_id) Return the first ChildToken filtered by the token_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByUseCaseId(int $use_case_id) Return the first ChildToken filtered by the use_case_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByPlaceId(int $place_id) Return the first ChildToken filtered by the place_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByCreatingWorkItemId(int $creating_work_item_id) Return the first ChildToken filtered by the creating_work_item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByConsumingWorkItemId(int $consuming_work_item_id) Return the first ChildToken filtered by the consuming_work_item_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByTokenStatus(string $token_status) Return the first ChildToken filtered by the token_status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByEnabledDate(string $enabled_date) Return the first ChildToken filtered by the enabled_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByCancelledDate(string $cancelled_date) Return the first ChildToken filtered by the cancelled_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByConsumedDate(string $consumed_date) Return the first ChildToken filtered by the consumed_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByCreatedAt(string $created_at) Return the first ChildToken filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByCreatedBy(int $created_by) Return the first ChildToken filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByModifiedAt(string $modified_at) Return the first ChildToken filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildToken requireOneByModifiedBy(int $modified_by) Return the first ChildToken filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildToken[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildToken objects based on current ModelCriteria
 * @method     ChildToken[]|ObjectCollection findByTokenId(int $token_id) Return ChildToken objects filtered by the token_id column
 * @method     ChildToken[]|ObjectCollection findByUseCaseId(int $use_case_id) Return ChildToken objects filtered by the use_case_id column
 * @method     ChildToken[]|ObjectCollection findByPlaceId(int $place_id) Return ChildToken objects filtered by the place_id column
 * @method     ChildToken[]|ObjectCollection findByCreatingWorkItemId(int $creating_work_item_id) Return ChildToken objects filtered by the creating_work_item_id column
 * @method     ChildToken[]|ObjectCollection findByConsumingWorkItemId(int $consuming_work_item_id) Return ChildToken objects filtered by the consuming_work_item_id column
 * @method     ChildToken[]|ObjectCollection findByTokenStatus(string $token_status) Return ChildToken objects filtered by the token_status column
 * @method     ChildToken[]|ObjectCollection findByEnabledDate(string $enabled_date) Return ChildToken objects filtered by the enabled_date column
 * @method     ChildToken[]|ObjectCollection findByCancelledDate(string $cancelled_date) Return ChildToken objects filtered by the cancelled_date column
 * @method     ChildToken[]|ObjectCollection findByConsumedDate(string $consumed_date) Return ChildToken objects filtered by the consumed_date column
 * @method     ChildToken[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildToken objects filtered by the created_at column
 * @method     ChildToken[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildToken objects filtered by the created_by column
 * @method     ChildToken[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildToken objects filtered by the modified_at column
 * @method     ChildToken[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildToken objects filtered by the modified_by column
 * @method     ChildToken[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class TokenQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\TokenQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\Token', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildTokenQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildTokenQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildTokenQuery) {
            return $criteria;
        }
        $query = new ChildTokenQuery();
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
     * @return ChildToken|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TokenTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(TokenTableMap::DATABASE_NAME);
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
     * @return ChildToken A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT token_id, use_case_id, place_id, creating_work_item_id, consuming_work_item_id, token_status, enabled_date, cancelled_date, consumed_date, created_at, created_by, modified_at, modified_by FROM PHPWF_token WHERE token_id = :p0';
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
            /** @var ChildToken $obj */
            $obj = new ChildToken();
            $obj->hydrate($row);
            TokenTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildToken|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TokenTableMap::COL_TOKEN_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TokenTableMap::COL_TOKEN_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the token_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTokenId(1234); // WHERE token_id = 1234
     * $query->filterByTokenId(array(12, 34)); // WHERE token_id IN (12, 34)
     * $query->filterByTokenId(array('min' => 12)); // WHERE token_id > 12
     * </code>
     *
     * @param     mixed $tokenId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByTokenId($tokenId = null, $comparison = null)
    {
        if (is_array($tokenId)) {
            $useMinMax = false;
            if (isset($tokenId['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_TOKEN_ID, $tokenId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tokenId['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_TOKEN_ID, $tokenId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_TOKEN_ID, $tokenId, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByUseCaseId($useCaseId = null, $comparison = null)
    {
        if (is_array($useCaseId)) {
            $useMinMax = false;
            if (isset($useCaseId['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_USE_CASE_ID, $useCaseId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($useCaseId['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_USE_CASE_ID, $useCaseId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_USE_CASE_ID, $useCaseId, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByPlaceId($placeId = null, $comparison = null)
    {
        if (is_array($placeId)) {
            $useMinMax = false;
            if (isset($placeId['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_PLACE_ID, $placeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($placeId['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_PLACE_ID, $placeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_PLACE_ID, $placeId, $comparison);
    }

    /**
     * Filter the query on the creating_work_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatingWorkItemId(1234); // WHERE creating_work_item_id = 1234
     * $query->filterByCreatingWorkItemId(array(12, 34)); // WHERE creating_work_item_id IN (12, 34)
     * $query->filterByCreatingWorkItemId(array('min' => 12)); // WHERE creating_work_item_id > 12
     * </code>
     *
     * @see       filterByCreatingWorkItem()
     *
     * @param     mixed $creatingWorkItemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByCreatingWorkItemId($creatingWorkItemId = null, $comparison = null)
    {
        if (is_array($creatingWorkItemId)) {
            $useMinMax = false;
            if (isset($creatingWorkItemId['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_CREATING_WORK_ITEM_ID, $creatingWorkItemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($creatingWorkItemId['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_CREATING_WORK_ITEM_ID, $creatingWorkItemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_CREATING_WORK_ITEM_ID, $creatingWorkItemId, $comparison);
    }

    /**
     * Filter the query on the consuming_work_item_id column
     *
     * Example usage:
     * <code>
     * $query->filterByConsumingWorkItemId(1234); // WHERE consuming_work_item_id = 1234
     * $query->filterByConsumingWorkItemId(array(12, 34)); // WHERE consuming_work_item_id IN (12, 34)
     * $query->filterByConsumingWorkItemId(array('min' => 12)); // WHERE consuming_work_item_id > 12
     * </code>
     *
     * @see       filterByConsumingWorkItem()
     *
     * @param     mixed $consumingWorkItemId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByConsumingWorkItemId($consumingWorkItemId = null, $comparison = null)
    {
        if (is_array($consumingWorkItemId)) {
            $useMinMax = false;
            if (isset($consumingWorkItemId['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID, $consumingWorkItemId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($consumingWorkItemId['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID, $consumingWorkItemId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID, $consumingWorkItemId, $comparison);
    }

    /**
     * Filter the query on the token_status column
     *
     * Example usage:
     * <code>
     * $query->filterByTokenStatus('fooValue');   // WHERE token_status = 'fooValue'
     * $query->filterByTokenStatus('%fooValue%'); // WHERE token_status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $tokenStatus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByTokenStatus($tokenStatus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($tokenStatus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $tokenStatus)) {
                $tokenStatus = str_replace('*', '%', $tokenStatus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_TOKEN_STATUS, $tokenStatus, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByEnabledDate($enabledDate = null, $comparison = null)
    {
        if (is_array($enabledDate)) {
            $useMinMax = false;
            if (isset($enabledDate['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_ENABLED_DATE, $enabledDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($enabledDate['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_ENABLED_DATE, $enabledDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_ENABLED_DATE, $enabledDate, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByCancelledDate($cancelledDate = null, $comparison = null)
    {
        if (is_array($cancelledDate)) {
            $useMinMax = false;
            if (isset($cancelledDate['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_CANCELLED_DATE, $cancelledDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cancelledDate['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_CANCELLED_DATE, $cancelledDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_CANCELLED_DATE, $cancelledDate, $comparison);
    }

    /**
     * Filter the query on the consumed_date column
     *
     * Example usage:
     * <code>
     * $query->filterByConsumedDate('2011-03-14'); // WHERE consumed_date = '2011-03-14'
     * $query->filterByConsumedDate('now'); // WHERE consumed_date = '2011-03-14'
     * $query->filterByConsumedDate(array('max' => 'yesterday')); // WHERE consumed_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $consumedDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByConsumedDate($consumedDate = null, $comparison = null)
    {
        if (is_array($consumedDate)) {
            $useMinMax = false;
            if (isset($consumedDate['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_CONSUMED_DATE, $consumedDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($consumedDate['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_CONSUMED_DATE, $consumedDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_CONSUMED_DATE, $consumedDate, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(TokenTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(TokenTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TokenTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\UseCase object
     *
     * @param \PHPWorkFlow\DB\UseCase|ObjectCollection $useCase The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTokenQuery The current query, for fluid interface
     */
    public function filterByUseCase($useCase, $comparison = null)
    {
        if ($useCase instanceof \PHPWorkFlow\DB\UseCase) {
            return $this
                ->addUsingAlias(TokenTableMap::COL_USE_CASE_ID, $useCase->getUseCaseId(), $comparison);
        } elseif ($useCase instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TokenTableMap::COL_USE_CASE_ID, $useCase->toKeyValue('PrimaryKey', 'UseCaseId'), $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
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
     * Filter the query by a related \PHPWorkFlow\DB\WorkItem object
     *
     * @param \PHPWorkFlow\DB\WorkItem|ObjectCollection $workItem The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTokenQuery The current query, for fluid interface
     */
    public function filterByCreatingWorkItem($workItem, $comparison = null)
    {
        if ($workItem instanceof \PHPWorkFlow\DB\WorkItem) {
            return $this
                ->addUsingAlias(TokenTableMap::COL_CREATING_WORK_ITEM_ID, $workItem->getWorkItemId(), $comparison);
        } elseif ($workItem instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TokenTableMap::COL_CREATING_WORK_ITEM_ID, $workItem->toKeyValue('PrimaryKey', 'WorkItemId'), $comparison);
        } else {
            throw new PropelException('filterByCreatingWorkItem() only accepts arguments of type \PHPWorkFlow\DB\WorkItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CreatingWorkItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
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
     * Use the CreatingWorkItem relation WorkItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\WorkItemQuery A secondary query class using the current class as primary query
     */
    public function useCreatingWorkItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCreatingWorkItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CreatingWorkItem', '\PHPWorkFlow\DB\WorkItemQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkItem object
     *
     * @param \PHPWorkFlow\DB\WorkItem|ObjectCollection $workItem The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTokenQuery The current query, for fluid interface
     */
    public function filterByConsumingWorkItem($workItem, $comparison = null)
    {
        if ($workItem instanceof \PHPWorkFlow\DB\WorkItem) {
            return $this
                ->addUsingAlias(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID, $workItem->getWorkItemId(), $comparison);
        } elseif ($workItem instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TokenTableMap::COL_CONSUMING_WORK_ITEM_ID, $workItem->toKeyValue('PrimaryKey', 'WorkItemId'), $comparison);
        } else {
            throw new PropelException('filterByConsumingWorkItem() only accepts arguments of type \PHPWorkFlow\DB\WorkItem or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ConsumingWorkItem relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
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
     * Use the ConsumingWorkItem relation WorkItem object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PHPWorkFlow\DB\WorkItemQuery A secondary query class using the current class as primary query
     */
    public function useConsumingWorkItemQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinConsumingWorkItem($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ConsumingWorkItem', '\PHPWorkFlow\DB\WorkItemQuery');
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\Place object
     *
     * @param \PHPWorkFlow\DB\Place|ObjectCollection $place The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildTokenQuery The current query, for fluid interface
     */
    public function filterByPlace($place, $comparison = null)
    {
        if ($place instanceof \PHPWorkFlow\DB\Place) {
            return $this
                ->addUsingAlias(TokenTableMap::COL_PLACE_ID, $place->getPlaceId(), $comparison);
        } elseif ($place instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TokenTableMap::COL_PLACE_ID, $place->toKeyValue('PrimaryKey', 'PlaceId'), $comparison);
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
     * @return $this|ChildTokenQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildToken $token Object to remove from the list of results
     *
     * @return $this|ChildTokenQuery The current query, for fluid interface
     */
    public function prune($token = null)
    {
        if ($token) {
            $this->addUsingAlias(TokenTableMap::COL_TOKEN_ID, $token->getTokenId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_token table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            TokenTableMap::clearInstancePool();
            TokenTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(TokenTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(TokenTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            TokenTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            TokenTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // TokenQuery
