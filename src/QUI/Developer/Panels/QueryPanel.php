<?php

/**
 * This file contains QUI\Developer\Panels\QueryPanel
 */

namespace QUI\Developer\Panels;

use QUI;
use Tracy;

/**
 * Class QueryPanel
 *
 * @package QUI\Developer\Panels
 */
class QueryPanel implements Tracy\IBarPanel
{
    /**
     * @return string
     * @internal
     */
    public function getTitle()
    {
        $c = QueryCollector::length();

        if ($c === 0) {
            $title = 'no queries';
        } elseif ($c === 1) {
            $title = '1 query';
        } else {
            $title = "$c queries";
        }

        $time = QueryCollector::getTotalElapsedTime();
        $time = round($time * 1000, 4);

        return "$title, ".$time.'&nbsp;ms';
    }

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     * @internal
     */
    public function getTab()
    {
        $img = base64_encode(file_get_contents(__DIR__.'/QueryPanel.png'));

        return '<img width="16" height="16" src="data:image/png;base64,'.$img.'" />'
               .$this->getTitle()
               .'</span>';
    }

    /**
     * Renders HTML code for custom panel.
     *
     * @return string html
     * @internal
     */
    public function getPanel()
    {
        $Engine  = QUI::getTemplateManager()->getEngine();
        $queries = QueryCollector::getQueries();


        foreach ($queries as $key => $query) {
            $query['duration'] = round($query['duration'] * 1000, 4);
            $queries[$key]     = $query;
        }


        $Engine->assign(array(
            'queries' => $queries
        ));

        return $Engine->fetch(dirname(__FILE__).'/QueryPanel.html');
    }
}
