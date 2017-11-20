<?php

/**
 * This file contains QUI\Developer\Panels\QueryCollector
 */

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
     * @param array $query
     * @param float|bool $duration
     */
    public static function add($query, $duration = false)
    {
        $params = array();

        if (is_array($query)) {
            $params = $query;
        }

        $params['duration'] = $duration ? $duration : 0;

        self::$queries[] = $params;
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
     * @return float
     */
    public static function getTotalElapsedTime()
    {
        $duration = 0;

        foreach (self::$queries as $query) {
            $duration = $duration + $query['duration'];
        }

        return $duration;
    }
}
