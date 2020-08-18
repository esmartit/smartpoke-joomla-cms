<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spexportcustomer
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPExportCustomerHelper
{

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

    /**
     * Returns the UserList
     * @return mixed
     */
    public static function getCustomerListAjax()
    {
        $data = $_REQUEST['data'];
        $dStart = $data['dateStart'].' 00:00:00';
        $dEnd = $data['dateEnd'].' 23:59:59';
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];
        $zipcode = implode(",", $data['zipcodeId']);
        $spotId = $data['spotId'];
        $ageS = $data['ageStart'];
        $ageE = $data['ageEnd'];
        $gender = $data['gender'];
        $zipCode = implode(",", $data['zipCode']);
        $member = $data['memberShip'];

        $timeOffset = timezone_offset_get(  timezone_open(self::getTimeZone()), new DateTime() );

        switch ($gender) {
            case 'MALE':
                $sex = '0';
                break;
            case 'FEMALE':
                $sex = '1';
                break;
            default:
                $sex = '';
                break;
        }
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('firstname', 'lastname', 'mobile_phone', 'email', 'username', 'TIMESTAMPDIFF(YEAR, dateofbirth, now()) as age', 'sex', 'c.zipcode', 'membership', 'communication', 'name'));
        $query->from($db->quoteName('#__spcustomer_customer', 'c'));
        $query->join('INNER', $db->quoteName('#__spspot_spot', 's') . ' ON ' . $db->quoteName('s.spot_id'). ' = ' . $db->quoteName('spot'));
        $query->where("TIMESTAMP(c.created + INTERVAL ". $db->quote($timeOffset). " SECOND) >= ". $db->quote($dStart));
        $query->where("TIMESTAMP(c.created + INTERVAL ". $db->quote($timeOffset). " SECOND) <= ". $db->quote($dEnd));


        if (!empty($ageS) && !empty($ageE)) {
            $query->where('TIMESTAMPDIFF(YEAR, dateofbirth, now())  >= ' . $ageS);
            $query->where('TIMESTAMPDIFF(YEAR, dateofbirth, now())  <= ' . $ageE);
        }
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
            $query->where('s.zipcode' . " IN (" . $zipcode . ")");
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot') . " = " . $db->quote($spotId));
        }
        if ($sex != "") {
            $query->where($db->quoteName('sex') . " = " . $db->quote($sex));
        }
        if (!empty($zipCode[0])) {
            $query->where('c.zipcode' . " IN (" . $zipCode . ")");
        }
        if ($member != "") {
            $query->where($db->quoteName('membership') . " = " . $db->quote($member));
        }

        $db->setQuery($query);
        $userList = $db->loadObjectList();

        return $userList;
    }
}