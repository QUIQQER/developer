<?php

/**
 * This file contains QUI\Developer\EventHandler
 */

namespace QUI\Developer;

use QUI;
use Tracy\Debugger;

/**
 * Class EventHandler
 *
 * @package QUI\Developer
 */
class EventHandler
{
    /**
     * event: on header loaded
     */
    public static function onHeaderLoaded()
    {
        if (!defined('QUIQQER_DEVELOPER')) {
            define('QUIQQER_DEVELOPER', true);
        }

        Debugger::enable();

        Debugger::$logSeverity = E_NOTICE | E_WARNING;
        Debugger::enable(Debugger::DEVELOPMENT, VAR_DIR.'/log');

        Debugger::timer('page onHeaderLoaded');
    }

    /**
     * event: on admin loaded
     */
    public static function onAdminLoad()
    {
        if (!defined('QUIQQER_DEVELOPER')) {
            define('QUIQQER_DEVELOPER', true);
        }
    }

    /**
     * @param $Rewrite
     * @param $url
     */
    public static function onRequest($Rewrite, $url)
    {
        if (isset($_REQUEST['_tracy_bar'])) {
            Debugger::getBar()->dispatchAssets();
            exit;
        }
    }

    /**
     * @param string $output
     */
    public static function onRequestOutput(&$output)
    {
        //Debugger::barDump(QUI\Developer\Panels\QueryCollector::getQueries(), 'DB Params');
        //Debugger::barDump([2, 4, 6, 8], 'even numbers up to ten');
        Debugger::getBar()->addPanel(new Panels\QueryPanel());
        Debugger::getBar()->addPanel(new Panels\UserPanel());
    }
}
