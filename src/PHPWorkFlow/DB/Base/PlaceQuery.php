<?php

namespace PHPWorkFlow\DB\Base;

use \Exception;
use \PDO;
use PHPWorkFlow\DB\Place as ChildPlace;
use PHPWorkFlow\DB\PlaceQuery as ChildPlaceQuery;
use PHPWorkFlow\DB\Map\PlaceTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'PHPWF_place' table.
 *
 *
 *
 * @method     ChildPlaceQuery orderByPlaceId($order = Criteria::ASC) Order by the place_id column
 * @method     ChildPlaceQuery orderByWorkFlowId($order = Criteria::ASC) Order by the work_flow_id column
 * @method     ChildPlaceQuery orderByPlaceType($order = Criteria::ASC) Order by the place_type column
 * @method     ChildPlaceQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method     ChildPlaceQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method     ChildPlaceQuery orderByPositionX($order = Criteria::ASC) Order by the position_x column
 * @method     ChildPlaceQuery orderByPositionY($order = Criteria::ASC) Order by the position_y column
 * @method     ChildPlaceQuery orderByDimensionX($order = Criteria::ASC) Order by the dimension_x column
 * @method     ChildPlaceQuery orderByDimensionY($order = Criteria::ASC) Order by the dimension_y column
 * @method     ChildPlaceQuery orderByYasperName($order = Criteria::ASC) Order by the yasper_name column
 * @method     ChildPlaceQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method     ChildPlaceQuery orderByCreatedBy($order = Criteria::ASC) Order by the created_by column
 * @method     ChildPlaceQuery orderByModifiedAt($order = Criteria::ASC) Order by the modified_at column
 * @method     ChildPlaceQuery orderByModifiedBy($order = Criteria::ASC) Order by the modified_by column
 *
 * @method     ChildPlaceQuery groupByPlaceId() Group by the place_id column
 * @method     ChildPlaceQuery groupByWorkFlowId() Group by the work_flow_id column
 * @method     ChildPlaceQuery groupByPlaceType() Group by the place_type column
 * @method     ChildPlaceQuery groupByName() Group by the name column
 * @method     ChildPlaceQuery groupByDescription() Group by the description column
 * @method     ChildPlaceQuery groupByPositionX() Group by the position_x column
 * @method     ChildPlaceQuery groupByPositionY() Group by the position_y column
 * @method     ChildPlaceQuery groupByDimensionX() Group by the dimension_x column
 * @method     ChildPlaceQuery groupByDimensionY() Group by the dimension_y column
 * @method     ChildPlaceQuery groupByYasperName() Group by the yasper_name column
 * @method     ChildPlaceQuery groupByCreatedAt() Group by the created_at column
 * @method     ChildPlaceQuery groupByCreatedBy() Group by the created_by column
 * @method     ChildPlaceQuery groupByModifiedAt() Group by the modified_at column
 * @method     ChildPlaceQuery groupByModifiedBy() Group by the modified_by column
 *
 * @method     ChildPlaceQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPlaceQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPlaceQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPlaceQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPlaceQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPlaceQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPlaceQuery leftJoinWorkFlow($relationAlias = null) Adds a LEFT JOIN clause to the query using the WorkFlow relation
 * @method     ChildPlaceQuery rightJoinWorkFlow($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WorkFlow relation
 * @method     ChildPlaceQuery innerJoinWorkFlow($relationAlias = null) Adds a INNER JOIN clause to the query using the WorkFlow relation
 *
 * @method     ChildPlaceQuery joinWithWorkFlow($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the WorkFlow relation
 *
 * @method     ChildPlaceQuery leftJoinWithWorkFlow() Adds a LEFT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildPlaceQuery rightJoinWithWorkFlow() Adds a RIGHT JOIN clause and with to the query using the WorkFlow relation
 * @method     ChildPlaceQuery innerJoinWithWorkFlow() Adds a INNER JOIN clause and with to the query using the WorkFlow relation
 *
 * @method     ChildPlaceQuery leftJoinArc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arc relation
 * @method     ChildPlaceQuery rightJoinArc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arc relation
 * @method     ChildPlaceQuery innerJoinArc($relationAlias = null) Adds a INNER JOIN clause to the query using the Arc relation
 *
 * @method     ChildPlaceQuery joinWithArc($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Arc relation
 *
 * @method     ChildPlaceQuery leftJoinWithArc() Adds a LEFT JOIN clause and with to the query using the Arc relation
 * @method     ChildPlaceQuery rightJoinWithArc() Adds a RIGHT JOIN clause and with to the query using the Arc relation
 * @method     ChildPlaceQuery innerJoinWithArc() Adds a INNER JOIN clause and with to the query using the Arc relation
 *
 * @method     ChildPlaceQuery leftJoinToken($relationAlias = null) Adds a LEFT JOIN clause to the query using the Token relation
 * @method     ChildPlaceQuery rightJoinToken($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Token relation
 * @method     ChildPlaceQuery innerJoinToken($relationAlias = null) Adds a INNER JOIN clause to the query using the Token relation
 *
 * @method     ChildPlaceQuery joinWithToken($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Token relation
 *
 * @method     ChildPlaceQuery leftJoinWithToken() Adds a LEFT JOIN clause and with to the query using the Token relation
 * @method     ChildPlaceQuery rightJoinWithToken() Adds a RIGHT JOIN clause and with to the query using the Token relation
 * @method     ChildPlaceQuery innerJoinWithToken() Adds a INNER JOIN clause and with to the query using the Token relation
 *
 * @method     \PHPWorkFlow\DB\WorkFlowQuery|\PHPWorkFlow\DB\ArcQuery|\PHPWorkFlow\DB\TokenQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPlace findOne(ConnectionInterface $con = null) Return the first ChildPlace matching the query
 * @method     ChildPlace findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPlace matching the query, or a new ChildPlace object populated from the query conditions when no match is found
 *
 * @method     ChildPlace findOneByPlaceId(int $place_id) Return the first ChildPlace filtered by the place_id column
 * @method     ChildPlace findOneByWorkFlowId(int $work_flow_id) Return the first ChildPlace filtered by the work_flow_id column
 * @method     ChildPlace findOneByPlaceType(string $place_type) Return the first ChildPlace filtered by the place_type column
 * @method     ChildPlace findOneByName(string $name) Return the first ChildPlace filtered by the name column
 * @method     ChildPlace findOneByDescription(string $description) Return the first ChildPlace filtered by the description column
 * @method     ChildPlace findOneByPositionX(int $position_x) Return the first ChildPlace filtered by the position_x column
 * @method     ChildPlace findOneByPositionY(int $position_y) Return the first ChildPlace filtered by the position_y column
 * @method     ChildPlace findOneByDimensionX(int $dimension_x) Return the first ChildPlace filtered by the dimension_x column
 * @method     ChildPlace findOneByDimensionY(int $dimension_y) Return the first ChildPlace filtered by the dimension_y column
 * @method     ChildPlace findOneByYasperName(string $yasper_name) Return the first ChildPlace filtered by the yasper_name column
 * @method     ChildPlace findOneByCreatedAt(string $created_at) Return the first ChildPlace filtered by the created_at column
 * @method     ChildPlace findOneByCreatedBy(int $created_by) Return the first ChildPlace filtered by the created_by column
 * @method     ChildPlace findOneByModifiedAt(string $modified_at) Return the first ChildPlace filtered by the modified_at column
 * @method     ChildPlace findOneByModifiedBy(int $modified_by) Return the first ChildPlace filtered by the modified_by column *

 * @method     ChildPlace requirePk($key, ConnectionInterface $con = null) Return the ChildPlace by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOne(ConnectionInterface $con = null) Return the first ChildPlace matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlace requireOneByPlaceId(int $place_id) Return the first ChildPlace filtered by the place_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByWorkFlowId(int $work_flow_id) Return the first ChildPlace filtered by the work_flow_id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByPlaceType(string $place_type) Return the first ChildPlace filtered by the place_type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByName(string $name) Return the first ChildPlace filtered by the name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByDescription(string $description) Return the first ChildPlace filtered by the description column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByPositionX(int $position_x) Return the first ChildPlace filtered by the position_x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByPositionY(int $position_y) Return the first ChildPlace filtered by the position_y column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByDimensionX(int $dimension_x) Return the first ChildPlace filtered by the dimension_x column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByDimensionY(int $dimension_y) Return the first ChildPlace filtered by the dimension_y column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByYasperName(string $yasper_name) Return the first ChildPlace filtered by the yasper_name column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByCreatedAt(string $created_at) Return the first ChildPlace filtered by the created_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByCreatedBy(int $created_by) Return the first ChildPlace filtered by the created_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByModifiedAt(string $modified_at) Return the first ChildPlace filtered by the modified_at column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPlace requireOneByModifiedBy(int $modified_by) Return the first ChildPlace filtered by the modified_by column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPlace[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPlace objects based on current ModelCriteria
 * @method     ChildPlace[]|ObjectCollection findByPlaceId(int $place_id) Return ChildPlace objects filtered by the place_id column
 * @method     ChildPlace[]|ObjectCollection findByWorkFlowId(int $work_flow_id) Return ChildPlace objects filtered by the work_flow_id column
 * @method     ChildPlace[]|ObjectCollection findByPlaceType(string $place_type) Return ChildPlace objects filtered by the place_type column
 * @method     ChildPlace[]|ObjectCollection findByName(string $name) Return ChildPlace objects filtered by the name column
 * @method     ChildPlace[]|ObjectCollection findByDescription(string $description) Return ChildPlace objects filtered by the description column
 * @method     ChildPlace[]|ObjectCollection findByPositionX(int $position_x) Return ChildPlace objects filtered by the position_x column
 * @method     ChildPlace[]|ObjectCollection findByPositionY(int $position_y) Return ChildPlace objects filtered by the position_y column
 * @method     ChildPlace[]|ObjectCollection findByDimensionX(int $dimension_x) Return ChildPlace objects filtered by the dimension_x column
 * @method     ChildPlace[]|ObjectCollection findByDimensionY(int $dimension_y) Return ChildPlace objects filtered by the dimension_y column
 * @method     ChildPlace[]|ObjectCollection findByYasperName(string $yasper_name) Return ChildPlace objects filtered by the yasper_name column
 * @method     ChildPlace[]|ObjectCollection findByCreatedAt(string $created_at) Return ChildPlace objects filtered by the created_at column
 * @method     ChildPlace[]|ObjectCollection findByCreatedBy(int $created_by) Return ChildPlace objects filtered by the created_by column
 * @method     ChildPlace[]|ObjectCollection findByModifiedAt(string $modified_at) Return ChildPlace objects filtered by the modified_at column
 * @method     ChildPlace[]|ObjectCollection findByModifiedBy(int $modified_by) Return ChildPlace objects filtered by the modified_by column
 * @method     ChildPlace[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PlaceQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \PHPWorkFlow\DB\Base\PlaceQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'PHPWorkFlow', $modelName = '\\PHPWorkFlow\\DB\\Place', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPlaceQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPlaceQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPlaceQuery) {
            return $criteria;
        }
        $query = new ChildPlaceQuery();
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
     * @return ChildPlace|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PlaceTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PlaceTableMap::DATABASE_NAME);
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
     * @return ChildPlace A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT place_id, work_flow_id, place_type, name, description, position_x, position_y, dimension_x, dimension_y, yasper_name, created_at, created_by, modified_at, modified_by FROM PHPWF_place WHERE place_id = :p0';
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
            /** @var ChildPlace $obj */
            $obj = new ChildPlace();
            $obj->hydrate($row);
            PlaceTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPlace|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $keys, Criteria::IN);
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
     * @param     mixed $placeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPlaceId($placeId = null, $comparison = null)
    {
        if (is_array($placeId)) {
            $useMinMax = false;
            if (isset($placeId['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $placeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($placeId['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $placeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $placeId, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByWorkFlowId($workFlowId = null, $comparison = null)
    {
        if (is_array($workFlowId)) {
            $useMinMax = false;
            if (isset($workFlowId['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_WORK_FLOW_ID, $workFlowId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($workFlowId['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_WORK_FLOW_ID, $workFlowId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_WORK_FLOW_ID, $workFlowId, $comparison);
    }

    /**
     * Filter the query on the place_type column
     *
     * Example usage:
     * <code>
     * $query->filterByPlaceType('fooValue');   // WHERE place_type = 'fooValue'
     * $query->filterByPlaceType('%fooValue%'); // WHERE place_type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $placeType The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPlaceType($placeType = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($placeType)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $placeType)) {
                $placeType = str_replace('*', '%', $placeType);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_PLACE_TYPE, $placeType, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PlaceTableMap::COL_NAME, $name, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PlaceTableMap::COL_DESCRIPTION, $description, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPositionX($positionX = null, $comparison = null)
    {
        if (is_array($positionX)) {
            $useMinMax = false;
            if (isset($positionX['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_POSITION_X, $positionX['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($positionX['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_POSITION_X, $positionX['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_POSITION_X, $positionX, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByPositionY($positionY = null, $comparison = null)
    {
        if (is_array($positionY)) {
            $useMinMax = false;
            if (isset($positionY['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_POSITION_Y, $positionY['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($positionY['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_POSITION_Y, $positionY['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_POSITION_Y, $positionY, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByDimensionX($dimensionX = null, $comparison = null)
    {
        if (is_array($dimensionX)) {
            $useMinMax = false;
            if (isset($dimensionX['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_DIMENSION_X, $dimensionX['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dimensionX['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_DIMENSION_X, $dimensionX['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_DIMENSION_X, $dimensionX, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByDimensionY($dimensionY = null, $comparison = null)
    {
        if (is_array($dimensionY)) {
            $useMinMax = false;
            if (isset($dimensionY['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_DIMENSION_Y, $dimensionY['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dimensionY['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_DIMENSION_Y, $dimensionY['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_DIMENSION_Y, $dimensionY, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
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

        return $this->addUsingAlias(PlaceTableMap::COL_YASPER_NAME, $yasperName, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_CREATED_AT, $createdAt, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByCreatedBy($createdBy = null, $comparison = null)
    {
        if (is_array($createdBy)) {
            $useMinMax = false;
            if (isset($createdBy['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_CREATED_BY, $createdBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdBy['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_CREATED_BY, $createdBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_CREATED_BY, $createdBy, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByModifiedAt($modifiedAt = null, $comparison = null)
    {
        if (is_array($modifiedAt)) {
            $useMinMax = false;
            if (isset($modifiedAt['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_MODIFIED_AT, $modifiedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedAt['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_MODIFIED_AT, $modifiedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_MODIFIED_AT, $modifiedAt, $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByModifiedBy($modifiedBy = null, $comparison = null)
    {
        if (is_array($modifiedBy)) {
            $useMinMax = false;
            if (isset($modifiedBy['min'])) {
                $this->addUsingAlias(PlaceTableMap::COL_MODIFIED_BY, $modifiedBy['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modifiedBy['max'])) {
                $this->addUsingAlias(PlaceTableMap::COL_MODIFIED_BY, $modifiedBy['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PlaceTableMap::COL_MODIFIED_BY, $modifiedBy, $comparison);
    }

    /**
     * Filter the query by a related \PHPWorkFlow\DB\WorkFlow object
     *
     * @param \PHPWorkFlow\DB\WorkFlow|ObjectCollection $workFlow The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByWorkFlow($workFlow, $comparison = null)
    {
        if ($workFlow instanceof \PHPWorkFlow\DB\WorkFlow) {
            return $this
                ->addUsingAlias(PlaceTableMap::COL_WORK_FLOW_ID, $workFlow->getWorkFlowId(), $comparison);
        } elseif ($workFlow instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PlaceTableMap::COL_WORK_FLOW_ID, $workFlow->toKeyValue('PrimaryKey', 'WorkFlowId'), $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
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
     * @return ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByArc($arc, $comparison = null)
    {
        if ($arc instanceof \PHPWorkFlow\DB\Arc) {
            return $this
                ->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $arc->getPlaceId(), $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
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
     * @return ChildPlaceQuery The current query, for fluid interface
     */
    public function filterByToken($token, $comparison = null)
    {
        if ($token instanceof \PHPWorkFlow\DB\Token) {
            return $this
                ->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $token->getPlaceId(), $comparison);
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
     * @return $this|ChildPlaceQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ChildPlace $place Object to remove from the list of results
     *
     * @return $this|ChildPlaceQuery The current query, for fluid interface
     */
    public function prune($place = null)
    {
        if ($place) {
            $this->addUsingAlias(PlaceTableMap::COL_PLACE_ID, $place->getPlaceId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the PHPWF_place table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PlaceTableMap::clearInstancePool();
            PlaceTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PlaceTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PlaceTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PlaceTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PlaceTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PlaceQuery
