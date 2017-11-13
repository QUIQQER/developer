<?php

/**
 * This file contains QUI\Developer\EventHandlerDatabase
 */

namespace QUI\Developer;

use QUI;

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
        QUI\Developer\Panels\QueryCollector::add($query);
    }

    /**
     * @param $DataBase
     * @param $query
     */
    public static function onDataBaseQueryEnd($DataBase, $query)
    {

    }
}
