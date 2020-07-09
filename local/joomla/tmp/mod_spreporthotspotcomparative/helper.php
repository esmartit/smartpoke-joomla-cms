<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spreporthotspotcomparative
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPReportHotSpotComparativeHelper
{
    /**
     * Returns the HotSpotList
     * @return mixed
     */
    public static function getHotSpotsAjax()
    {
        $city = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('spot_id', 'name')));
        $query->from($db->quoteName('#__spspot_spot'));

        if (!empty($city)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($city));
        }

        $db->setQuery($query);
        $hotspotList = $db->loadRowList();

        return $hotspotList;
    }

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