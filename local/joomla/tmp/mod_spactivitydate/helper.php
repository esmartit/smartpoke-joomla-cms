<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spactivitydate
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPActivityDateHelper
{
    /**
     * Returns the userTime zone if the user has set one, or the global config one
     * @return mixed
     */
    public static function getTimeZone() {
        $userTz = JFactory::getUser()->getParam('timezone');
        $timeZone = JFactory::getConfig()->get('offset');
        if($userTz) {
            $timeZone = $userTz;
        }
        return $timeZone;
    }
}