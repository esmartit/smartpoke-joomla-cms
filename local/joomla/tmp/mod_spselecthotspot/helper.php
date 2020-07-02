<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselecthotspot
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectHotSpotHelper
{

    /**
     * Returns the SpotList
     * @return mixed
     */
    public static function getSpotsAjax()
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
        $spotList = $db->loadRowList();

        return $spotList;
    }

    /**
     * Returns the ZipcodeList
     * @return mixed
     */
    public static function getZipCodes()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('zipcode')))
            ->from($db->quoteName('#__spcustomer_customer'))
            ->where($db->quoteName('zipcode'). '!=' .$db->quote(''))
            ->group($db->quoteName('zipcode'));
        $db->setQuery($query);
        $zipcodeList = $db->loadObjectList();

        return $zipcodeList;
    }

}