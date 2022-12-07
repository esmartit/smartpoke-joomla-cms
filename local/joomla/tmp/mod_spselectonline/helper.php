<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectonline
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectOnlineHelper
{

    /**
     * Returns the CountryList
     * @return mixed
     */
    public static function getSpotCountryAjax() {

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('country', 'b.name')))
            ->from($db->quoteName('#__spspot_spot'))
            ->join('INNER', $db->quoteName('#__spcountry_country', 'b') . ' ON ' . $db->quoteName('country') . ' = ' . $db->quoteName('b.country_code_isotwo'))
            ->group($db->quoteName('country'));
        $db->setQuery($query);
        $countryList = $db->loadRowList();

        return $countryList;

    }

    /**
     * Returns the StateList
     * @return mixed
     */
    public static function getSpotStateAjax() {

        $countryId = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('state', 'b.name')))
            ->from($db->quoteName('#__spspot_spot'))
            ->join('INNER', $db->quoteName('#__spstate_state', 'b') . ' ON ' . $db->quoteName('state') . ' = ' . $db->quoteName('b.state_code'));

        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }
        $query->group($db->quoteName('state'));

        $db->setQuery($query);
        $stateList = $db->loadRowList();

        return $stateList;

    }

    /**
     * Returns the CityList
     * @return mixed
     */
    public static function getSpotCityAjax() {

        $data = $_REQUEST['data'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('city', 'b.name')));
        $query->from($db->quoteName('#__spspot_spot'));
        $query->join('INNER', $db->quoteName('#__spcity_city', 'b') . ' ON ' . $db->quoteName('city') . ' = ' . $db->quoteName('b.city_code'));

        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }

        if (!empty($stateId)) {
            $query->where($db->quoteName('state'). " = " .$db->quote($stateId));
        }
        $query->group($db->quoteName('city'));

        $db->setQuery($query);
        $cityList = $db->loadRowList();

        return $cityList;
    }

    /**
     * Returns the ZipCodeList
     * @return mixed
     */
    public static function getSpotZipCodeAjax() {

        $data = $_REQUEST['data'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('a.zipcode', 'b.location')))
            ->from($db->quoteName('#__spspot_spot', 'a'))
            ->join('INNER', $db->quoteName('#__spzipcode_zipcode', 'b') . ' ON ' . $db->quoteName('a.zipcode') . ' = ' . $db->quoteName('b.zipcode'));

        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }

        if (!empty($stateId)) {
            $query->where($db->quoteName('state'). " = " .$db->quote($stateId));
        }

        if (!empty($cityId)) {
            $query->where($db->quoteName('city_id'). " = " .$db->quote($cityId));
        }
        $query->group($db->quoteName('a.zipcode'));

        $db->setQuery($query);
        $zipcodeList = $db->loadRowList();

        return $zipcodeList;
    }

    /**
     * Returns the SpotList
     * @return mixed
     */
    public static function getSpotsAjax()
    {

        $data = $_REQUEST['data'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];
        $zipcode = implode(",", $data['zipcodeId']);

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('spot_id', 'name')));
        $query->from($db->quoteName('#__spspot_spot'));

        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }

        if (!empty($stateId)) {
            $query->where($db->quoteName('state'). " = " .$db->quote($stateId));
        }

        if (!empty($cityId)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($cityId));
        }

        if (!empty($zipcode[0])) {
            $query->where('zipcode' . " IN (" . $zipcode . ")");
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
        $query
            ->select($db->quoteName(array('sensor_id', 'location')))
            ->from($db->quoteName('#__spsensor_sensor'));

        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }

        $db->setQuery($query);
        $sensorList = $db->loadRowList();

        return $sensorList;
    }

    /**
     * Returns the ZoneList
     * @return mixed
     */
    public static function getZonesAjax()
    {
        $spotId = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('zone', 'b.name')))
            ->from($db->quoteName('#__spsensor_sensor', 'a'))
            ->join('INNER', $db->quoteName('#__spzone_zone', 'b') . ' ON ' . $db->quoteName('a.zone') . ' = ' . $db->quoteName('b.id'));

        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }
        $query->group($db->quoteName('zone'));

        $db->setQuery($query);
        $zoneList = $db->loadRowList();

        return $zoneList;
    }

    /**
     * Returns the DeviceList
     * @return mixed
     */
    public static function getDevicesAjax()
    {
        $type = $_REQUEST['data'];
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('device')))
            ->from($db->quoteName('#__spdevice_device'));

        if ($type == '0' || $type == '1') {
            $query->where($db->quoteName('type'). " = " .$db->quote($type));
        }

        $db->setQuery($query);
        $deviceList = $db->loadObjectList();

        return $deviceList;
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

    public static function getTimeZone() {
        $userTz = JFactory::getUser()->getParam('timezone');
        $timeZone = JFactory::getConfig()->get('offset');
        if($userTz) {
            $timeZone = $userTz;
        }
        return $timeZone;
    }

}