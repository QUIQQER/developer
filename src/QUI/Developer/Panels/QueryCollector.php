<?php

namespace QUI\Developer\Panels;

/**
 * Class QueryCollector
 *
 * @package QUI\Developer\Panels
 */
class QueryCollector
{
    /**
     * @var array
     */
    protected static $queries = array();

    /**
     * @param string $query
     */
    public static function add($query)
    {
        self::$queries[] = $query;
    }

    /**
     * @return array
     */
    public static function getQueries()
    {
        return self::$queries;
    }

    /**
     * @return int
     */
    public static function length()
    {
        return count(self::$queries);
    }

    /**
     * @return int
     */
    public static function getTotalElapsedTime()
    {
        return 0;
    }
}
