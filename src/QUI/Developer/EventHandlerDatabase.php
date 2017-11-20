<?php

/**
 * This file contains QUI\Developer\EventHandlerDatabase
 */

namespace QUI\Developer;

use QUI;
use Tracy\Debugger;

/**
 * Class EventHandlerDatabase
 *
 * @package QUI\Developer
 */
class EventHandlerDatabase
{
    /**
     * @param $DataBase
     * @param $query
     */
    public static function onDataBaseQuery($DataBase, $query)
    {
    }

    /**
     * @param $DataBase
     * @param $query
     * @param float $startTime
     * @param float $endTime
     */
    public static function onDataBaseQueryEnd($DataBase, $query, $startTime, $endTime)
    {
        $diff = $endTime - $startTime;

        QUI\Developer\Panels\QueryCollector::add($query, $diff);
    }
}
