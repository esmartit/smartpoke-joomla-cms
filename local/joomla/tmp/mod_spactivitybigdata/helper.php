<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spactivitybigdata
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPActivityBigDataHelper
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

    /**
     * Returns the SpotList
     * @return mixed
     */
    public static function showGraphBigDataAjax()
    {
        $graphType = $_REQUEST['data'];
        if ($graphType == '') {
            $graphType = '0';
        }

        return $graphType;
    }

}