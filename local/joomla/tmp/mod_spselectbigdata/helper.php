<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectbigdata
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectBigDataHelper
{

    /**
     * Returns the BrandList
     * @return mixed
     */
    public static function getBrands()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'name')))
            ->from($db->quoteName('#__spbrand_brand'));
        $db->setQuery($query);
        $brandList = $db->loadObjectList();

        return $brandList;
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

    public static function getTimeZone() {
        $userTz = JFactory::getUser()->getParam('timezone');
        $timeZone = JFactory::getConfig()->get('offset');
        if($userTz) {
            $timeZone = $userTz;
        }
        return $timeZone;
    }

}