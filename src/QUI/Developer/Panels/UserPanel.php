<?php

/**
 * This file contains QUI\Developer\Panels\UserPanel
 */

namespace QUI\Developer\Panels;

use QUI;
use Tracy;

/**
 * Class UserPanel
 * - SHows current user information
 *
 * @package QUI\Developer\Panels
 */
class UserPanel implements Tracy\IBarPanel
{
    /**
     * @return string
     * @internal
     */
    public function getTitle()
    {
        $User = QUI::getUserBySession();

        return $User->getName();
    }

    /**
     * Renders HTML code for custom tab.
     *
     * @return string
     * @internal
     */
    public function getTab()
    {
        $img = base64_encode(file_get_contents(__DIR__.'/UserPanel.png'));

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
        $Engine = QUI::getTemplateManager()->getEngine();
        $User   = QUI::getUserBySession();

        if (QUI::getUsers()->isNobodyUser($User)) {
            return $Engine->fetch(dirname(__FILE__).'/UserPanel.Login.html');
        }

        $attributes = $User->getAttributes();
        ksort($attributes);

        $extras = $attributes['extra'];

        if (!is_array($extras)) {
            $extras = json_decode($extras, true);
        }

        unset($attributes['extra']);

        $Engine->assign(array(
            'User'       => $User,
            'attributes' => $attributes,
            'extras'     => $extras
        ));

        return $Engine->fetch(dirname(__FILE__).'/UserPanel.Data.html');
    }
}
