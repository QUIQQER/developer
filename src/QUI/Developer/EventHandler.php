<?php

/**
 * This file contains QUI\Developer\EventHandler
 */

namespace QUI\Developer;

use Netpromotion\Profiler\Adapter\TracyBarAdapter;
use Netpromotion\Profiler\Profiler;
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
        Profiler::enable();

        Debugger::$logSeverity = E_NOTICE | E_WARNING;
        Debugger::enable(Debugger::DEVELOPMENT, VAR_DIR.'/log');
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
     * event : on admin request
     */
    public static function onAdminRequest()
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
        Debugger::getBar()->addPanel(
            new TracyBarAdapter()
        );

        Debugger::getBar()->addPanel(new Panels\QueryPanel());
        Debugger::getBar()->addPanel(new Panels\UserPanel());
    }
}
