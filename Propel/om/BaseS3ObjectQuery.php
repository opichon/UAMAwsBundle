<?php

namespace UAM\Bundle\AwsBundle\Propel\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \PDO;
use \Propel;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use UAM\Bundle\AwsBundle\Propel\S3Object;
use UAM\Bundle\AwsBundle\Propel\S3ObjectPeer;
use UAM\Bundle\AwsBundle\Propel\S3ObjectQuery;

/**
 * @method S3ObjectQuery orderById($order = Criteria::ASC) Order by the id column
 * @method S3ObjectQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method S3ObjectQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method S3ObjectQuery orderByBucket($order = Criteria::ASC) Order by the bucket column
 * @method S3ObjectQuery orderByPath($order = Criteria::ASC) Order by the path column
 * @method S3ObjectQuery orderByCredentials($order = Criteria::ASC) Order by the credentials column
 * @method S3ObjectQuery orderByPreauth($order = Criteria::ASC) Order by the preauth column
 * @method S3ObjectQuery orderByFilename($order = Criteria::ASC) Order by the filename column
 * @method S3ObjectQuery orderBySize($order = Criteria::ASC) Order by the size column
 * @method S3ObjectQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method S3ObjectQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method S3ObjectQuery groupById() Group by the id column
 * @method S3ObjectQuery groupByTitle() Group by the title column
 * @method S3ObjectQuery groupByDescription() Group by the description column
 * @method S3ObjectQuery groupByBucket() Group by the bucket column
 * @method S3ObjectQuery groupByPath() Group by the path column
 * @method S3ObjectQuery groupByCredentials() Group by the credentials column
 * @method S3ObjectQuery groupByPreauth() Group by the preauth column
 * @method S3ObjectQuery groupByFilename() Group by the filename column
 * @method S3ObjectQuery groupBySize() Group by the size column
 * @method S3ObjectQuery groupByCreatedAt() Group by the created_at column
 * @method S3ObjectQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method S3ObjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method S3ObjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method S3ObjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method S3Object findOne(PropelPDO $con = null) Return the first S3Object matching the query
 * @method S3Object findOneOrCreate(PropelPDO $con = null) Return the first S3Object matching the query, or a new S3Object object populated from the query conditions when no match is found
 *
 * @method S3Object findOneByTitle(string $title) Return the first S3Object filtered by the title column
 * @method S3Object findOneByDescription(string $description) Return the first S3Object filtered by the description column
 * @method S3Object findOneByBucket(string $bucket) Return the first S3Object filtered by the bucket column
 * @method S3Object findOneByPath(string $path) Return the first S3Object filtered by the path column
 * @method S3Object findOneByCredentials(string $credentials) Return the first S3Object filtered by the credentials column
 * @method S3Object findOneByPreauth(string $preauth) Return the first S3Object filtered by the preauth column
 * @method S3Object findOneByFilename(string $filename) Return the first S3Object filtered by the filename column
 * @method S3Object findOneBySize(int $size) Return the first S3Object filtered by the size column
 * @method S3Object findOneByCreatedAt(string $created_at) Return the first S3Object filtered by the created_at column
 * @method S3Object findOneByUpdatedAt(string $updated_at) Return the first S3Object filtered by the updated_at column
 *
 * @method array findById(int $id) Return S3Object objects filtered by the id column
 * @method array findByTitle(string $title) Return S3Object objects filtered by the title column
 * @method array findByDescription(string $description) Return S3Object objects filtered by the description column
 * @method array findByBucket(string $bucket) Return S3Object objects filtered by the bucket column
 * @method array findByPath(string $path) Return S3Object objects filtered by the path column
 * @method array findByCredentials(string $credentials) Return S3Object objects filtered by the credentials column
 * @method array findByPreauth(string $preauth) Return S3Object objects filtered by the preauth column
 * @method array findByFilename(string $filename) Return S3Object objects filtered by the filename column
 * @method array findBySize(int $size) Return S3Object objects filtered by the size column
 * @method array findByCreatedAt(string $created_at) Return S3Object objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return S3Object objects filtered by the updated_at column
 */
abstract class BaseS3ObjectQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseS3ObjectQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'UAM\\Bundle\\AwsBundle\\Propel\\S3Object', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new S3ObjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   S3ObjectQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return S3ObjectQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof S3ObjectQuery) {
            return $criteria;
        }
        $query = new S3ObjectQuery();
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
     * @param     PropelPDO $con an optional connection object
     *
     * @return   S3Object|S3Object[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = S3ObjectPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(S3ObjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 S3Object A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 S3Object A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `title`, `description`, `bucket`, `path`, `credentials`, `preauth`, `filename`, `size`, `created_at`, `updated_at` FROM `s3object` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new S3Object();
            $obj->hydrate($row);
            S3ObjectPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return S3Object|S3Object[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|S3Object[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(S3ObjectPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(S3ObjectPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(S3ObjectPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(S3ObjectPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::TITLE, $title, $comparison);
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
     * @return S3ObjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(S3ObjectPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the bucket column
     *
     * Example usage:
     * <code>
     * $query->filterByBucket('fooValue');   // WHERE bucket = 'fooValue'
     * $query->filterByBucket('%fooValue%'); // WHERE bucket LIKE '%fooValue%'
     * </code>
     *
     * @param     string $bucket The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByBucket($bucket = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($bucket)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $bucket)) {
                $bucket = str_replace('*', '%', $bucket);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::BUCKET, $bucket, $comparison);
    }

    /**
     * Filter the query on the path column
     *
     * Example usage:
     * <code>
     * $query->filterByPath('fooValue');   // WHERE path = 'fooValue'
     * $query->filterByPath('%fooValue%'); // WHERE path LIKE '%fooValue%'
     * </code>
     *
     * @param     string $path The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByPath($path = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($path)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $path)) {
                $path = str_replace('*', '%', $path);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::PATH, $path, $comparison);
    }

    /**
     * Filter the query on the credentials column
     *
     * Example usage:
     * <code>
     * $query->filterByCredentials('fooValue');   // WHERE credentials = 'fooValue'
     * $query->filterByCredentials('%fooValue%'); // WHERE credentials LIKE '%fooValue%'
     * </code>
     *
     * @param     string $credentials The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByCredentials($credentials = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($credentials)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $credentials)) {
                $credentials = str_replace('*', '%', $credentials);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::CREDENTIALS, $credentials, $comparison);
    }

    /**
     * Filter the query on the preauth column
     *
     * Example usage:
     * <code>
     * $query->filterByPreauth('fooValue');   // WHERE preauth = 'fooValue'
     * $query->filterByPreauth('%fooValue%'); // WHERE preauth LIKE '%fooValue%'
     * </code>
     *
     * @param     string $preauth The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByPreauth($preauth = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($preauth)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $preauth)) {
                $preauth = str_replace('*', '%', $preauth);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::PREAUTH, $preauth, $comparison);
    }

    /**
     * Filter the query on the filename column
     *
     * Example usage:
     * <code>
     * $query->filterByFilename('fooValue');   // WHERE filename = 'fooValue'
     * $query->filterByFilename('%fooValue%'); // WHERE filename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $filename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByFilename($filename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($filename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $filename)) {
                $filename = str_replace('*', '%', $filename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::FILENAME, $filename, $comparison);
    }

    /**
     * Filter the query on the size column
     *
     * Example usage:
     * <code>
     * $query->filterBySize(1234); // WHERE size = 1234
     * $query->filterBySize(array(12, 34)); // WHERE size IN (12, 34)
     * $query->filterBySize(array('min' => 12)); // WHERE size >= 12
     * $query->filterBySize(array('max' => 12)); // WHERE size <= 12
     * </code>
     *
     * @param     mixed $size The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterBySize($size = null, $comparison = null)
    {
        if (is_array($size)) {
            $useMinMax = false;
            if (isset($size['min'])) {
                $this->addUsingAlias(S3ObjectPeer::SIZE, $size['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($size['max'])) {
                $this->addUsingAlias(S3ObjectPeer::SIZE, $size['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::SIZE, $size, $comparison);
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
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(S3ObjectPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(S3ObjectPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at > '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(S3ObjectPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(S3ObjectPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(S3ObjectPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Exclude object from result
     *
     * @param   S3Object $s3Object Object to remove from the list of results
     *
     * @return S3ObjectQuery The current query, for fluid interface
     */
    public function prune($s3Object = null)
    {
        if ($s3Object) {
            $this->addUsingAlias(S3ObjectPeer::ID, $s3Object->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     S3ObjectQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(S3ObjectPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     S3ObjectQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(S3ObjectPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     S3ObjectQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(S3ObjectPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     S3ObjectQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(S3ObjectPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     S3ObjectQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(S3ObjectPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     S3ObjectQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(S3ObjectPeer::CREATED_AT);
    }
}
