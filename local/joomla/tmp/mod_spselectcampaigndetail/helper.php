<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectcampaigndetail
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectCampaignDetailHelper
{

    /**
     * Returns the SmsMonth
     * @return mixed
     */
    public static function getSmsEmailMonthAjax()
    {
        $smsemailValue = $_REQUEST['data'];

        $db    = JFactory::getDbo();
        $tables = $db->getTableList();

        $value = 0;
        if (in_array('jos_spvalue_value', $tables)) {
            $query = $db->getQuery(true);
            $query
                ->select($db->quoteName('value'))
                ->from($db->quoteName('#__spvalue_value'))
                ->where($db->quoteName('code_value') . ' = ' . $db->quote($smsemailValue));

            $db->setQuery($query);
            $value = $db->loadResult();
        }
        return $value;
    }

    /**
     * Returns the CampaignList
     * @return mixed
     */
    public static function getCampaignsAjax()
    {
        $smsemail = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'name')));
        $query->from($db->quoteName('#__spcampaign_campaign'));
        $query->where($db->quoteName('smsemail'). " = ". $db->quote($smsemail));
        $query->where($db->quoteName('published'). " = '1'");
        $db->setQuery($query);
        $campaignList = $db->loadRowList();

        return $campaignList;
    }

    /**
     * Returns the getCredit
     * @return mixed
     */
    public static function getMessagesMonthAjax()
    {
        $data = $_REQUEST['data'];
        $dStart = $data['dateStart'].' 00:00:00';
        $dEnd = $data['dateEnd'].' 23:59:59';
        $smsemail = $data['smsEmail'];

        $timeOffset = timezone_offset_get(  timezone_open(self::getTimeZone()), new DateTime() );

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query
            ->select(array('status', 'COUNT(*)'))
            ->from($db->quoteName('#__spmessage_message', 'a'))
            ->join('LEFT', $db->quoteName('#__spcustomer_customer', 'b') . ' ON ' . $db->quoteName('b.username'). ' = ' . $db->quoteName('a.username'))
            ->join('INNER', $db->quoteName('#__spcampaign_campaign', 'c') . ' ON ' . $db->quoteName('c.id'). ' = ' . $db->quoteName('campaign_id'))
            ->where("TIMESTAMP(senddate + INTERVAL ". $db->quote($timeOffset). " SECOND) >= ". $db->quote($dStart))
            ->where("TIMESTAMP(senddate + INTERVAL ". $db->quote($timeOffset). " SECOND) <= ". $db->quote($dEnd))
            ->where($db->quoteName('c.smsemail'). " = ". $db->quote($smsemail))
            ->group($db->quoteName('status'));
        $db->setQuery($query);
        $statusList = $db->loadRowList();

        return $statusList;
    }

    /**
     * Returns the MessagesList
     * @return mixed
     */
    public static function getMessagesCampaignAjax()
    {
        $data = $_REQUEST['data'];
        $dStart = $data['dateStart'].' 00:00:00';
        $dEnd = $data['dateEnd'].' 23:59:59';
        $campaignId = $data['campaignId'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];
        $zipcode = implode(",", $data['zipcodeId']);
        $spotId = $data['spotId'];

        $timeOffset = timezone_offset_get(  timezone_open(self::getTimeZone()), new DateTime() );

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('status', 'COUNT(*)'));
        $query->from($db->quoteName('#__spmessage_message', 'a'));
        $query->join('LEFT', $db->quoteName('#__spcustomer_customer', 'b') . ' ON ' . $db->quoteName('b.username'). ' = ' . $db->quoteName('a.username'));
        $query->join('INNER', $db->quoteName('#__spcampaign_campaign', 'c') . ' ON ' . $db->quoteName('c.id'). ' = ' . $db->quoteName('campaign_id'));
        $query->join('LEFT', $db->quoteName('#__spspot_spot', 's') . ' ON ' . $db->quoteName('s.spot_id'). ' = ' . $db->quoteName('spot'));
        $query->where("TIMESTAMP(senddate + INTERVAL ". $db->quote($timeOffset). " SECOND) >= ". $db->quote($dStart));
        $query->where("TIMESTAMP(senddate + INTERVAL ". $db->quote($timeOffset). " SECOND) <= ". $db->quote($dEnd));

        if (!empty($campaignId)) {
            $query->where($db->quoteName('campaign_id'). " = ". $db->quote($campaignId));
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
            $query->where($db->quoteName('spot'). " = ". $db->quote($spotId));
        }
        $query->group($db->quoteName('status'));

        $db->setQuery($query);
        $statusList = $db->loadRowList();

        return $statusList;
    }

    /**
     * Returns the MessagesList
     * @return mixed
     */
    public static function getCampaignDetailAjax()
    {
        $data = $_REQUEST['data'];
        $dStart = $data['dateStart'].' 00:00:00';
        $dEnd = $data['dateEnd'].' 23:59:59';
        $campaignId = $data['campaignId'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];
        $zipcode = implode(",", $data['zipcodeId']);
        $spotId = $data['spotId'];

        $timeOffset = timezone_offset_get(  timezone_open(self::getTimeZone()), new DateTime() );

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('c.name', 'device_sms', 'a.username', 'TIMESTAMP(senddate + INTERVAL '.$timeOffset.' SECOND) AS senddate', 'status', 'description', 's.name AS spot'));
        $query->from($db->quoteName('#__spmessage_message', 'a'));
        $query->join('LEFT', $db->quoteName('#__spcustomer_customer', 'b') . ' ON ' . $db->quoteName('b.username'). ' = ' . $db->quoteName('a.username'));
        $query->join('INNER', $db->quoteName('#__spcampaign_campaign', 'c') . ' ON ' . $db->quoteName('c.id'). ' = ' . $db->quoteName('campaign_id'));
        $query->join('LEFT', $db->quoteName('#__spspot_spot', 's') . ' ON ' . $db->quoteName('s.spot_id'). ' = ' . $db->quoteName('spot'));
        $query->where("TIMESTAMP(senddate + INTERVAL ". $db->quote($timeOffset). " SECOND) >= ". $db->quote($dStart));
        $query->where("TIMESTAMP(senddate + INTERVAL ". $db->quote($timeOffset). " SECOND) <= ". $db->quote($dEnd));

        if (!empty($campaignId)) {
            $query->where($db->quoteName('campaign_id'). " = ". $db->quote($campaignId));
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
            $query->where($db->quoteName('spot'). " = ". $db->quote($spotId));
        }

        $db->setQuery($query);
        $campaignList = $db->loadObjectList();

        return $campaignList;
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