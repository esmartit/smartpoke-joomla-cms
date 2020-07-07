<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectsmartpoke
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectSmartPokeHelper
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
     * Returns the SensorList
     * @return mixed
     */
    public static function getSensorsAjax()
    {
        $spotId = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('sensor_id', 'location')));
        $query->from($db->quoteName('#__spsensor_sensor'));

        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }

        $db->setQuery($query);
        $sensorList = $db->loadRowList();

        return $sensorList;
    }

    /**
     * Returns the CampaignList
     * @return mixed
     */
    public static function getCampaignsAjax()
    {
        $currDate = date('Y-m-d');
        $smsemail = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'name')));
        $query->from($db->quoteName('#__spcampaign_campaign'));
        $query->where($db->quoteName('validdate'). " >= " . $db->quote($currDate), 'AND');
        $query->where($db->quoteName('smsemail'). " = ". $db->quote($smsemail), 'AND');
        $query->where($db->quoteName('type'). " = 'CAMPAIGN'");
        $db->setQuery($query);
        $campaignList = $db->loadRowList();

        return $campaignList;
    }

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

}