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
     *
     * @throws \QUI\Exception
     */
    public static function onHeaderLoaded()
    {
        if (!defined('QUIQQER_DEVELOPER')) {
            define('QUIQQER_DEVELOPER', true);
        }

        if (defined('QUIQQER_AJAX')) {
            return;
        }

        Profiler::enable();

        $Conf = QUI::getPackage('quiqqer/developer')->getConfig();

        if ($Conf->getValue('config', 'tracyDebugBar')) {
            Debugger::enable();
            Debugger::$logSeverity = E_ALL;
            Debugger::enable(Debugger::DEVELOPMENT, VAR_DIR.'/log');
        }
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
     *
     * @throws \QUI\Exception
     */
    public static function onRequest($Rewrite, $url)
    {
        $Conf = QUI::getPackage('quiqqer/developer')->getConfig();

        if ($Conf->getValue('config', 'tracyDebugBar')) {
            if (isset($_REQUEST['_tracy_bar']) || defined('QUIQQER_AJAX')) {
                Debugger::getBar()->dispatchAssets();
                exit;
            }
        }
    }

    /**
     * event : on admin request
     *
     * @throws \QUI\Exception
     */
    public static function onAdminRequest()
    {
        $Conf = QUI::getPackage('quiqqer/developer')->getConfig();

        if ($Conf->getValue('config', 'tracyDebugBar')) {
            if (isset($_REQUEST['_tracy_bar']) || defined('QUIQQER_AJAX')) {
                Debugger::getBar()->dispatchAssets();
                exit;
            }
        }
    }

    /**
     * @param string $output
     *
     * @throws \QUI\Exception
     */
    public static function onRequestOutput(&$output)
    {
        if (defined('QUIQQER_AJAX')) {
            return;
        }

        $Conf = QUI::getPackage('quiqqer/developer')->getConfig();

        if ($Conf->getValue('config', 'tracyDebugBar')) {
            Debugger::getBar()->addPanel(
                new TracyBarAdapter()
            );

            Debugger::getBar()->addPanel(new Panels\QueryPanel());
            Debugger::getBar()->addPanel(new Panels\UserPanel());
        }
    }
}
