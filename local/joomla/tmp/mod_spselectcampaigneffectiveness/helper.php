<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectcampaigneffectiveness
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectCampaignEffectivenessHelper
{

    /**
     * Returns the SmsMonth
     * @return mixed
     */
    public static function getSmsEmailTotalAjax()
    {
        $campaignId = $_REQUEST['data'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $query->from($db->quoteName('#__spmessage_message', 'a'));
        $query->join('INNER', $db->quoteName('#__spcampaign_campaign', 'c') . ' ON ' . $db->quoteName('c.id'). ' = ' . $db->quoteName('campaign_id'));
        $query->where($db->quoteName('c.type'). " = " . $db->quote('CAMPAIGN'));

        if (!empty($campaignId)) {
            $query->where($db->quoteName('campaign_id'). " = ". $db->quote($campaignId));
        }

        $db->setQuery($query);
        $value = $db->loadResult();
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
        $query->where($db->quoteName('smsemail'). " = " . $db->quote($smsemail));
        $query->where($db->quoteName('type'). " = " . $db->quote('CAMPAIGN'));
        $query->where($db->quoteName('published'). " = '1'");
        $db->setQuery($query);
        $campaignList = $db->loadRowList();

        return $campaignList;
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
     * Returns the NewUserTarget
     * @return mixed
     */
    public static function getNewUsersAjax()
    {
        $data = $_REQUEST['data'];
        $campaignId = $data['campaignId'];
        $dStart = $data['dateStart'].' 00:00:00';
        $dEnd = $data['dateEnd'].' 23:59:59';
        $type = $data['type'];

        $timeOffset = timezone_offset_get(  timezone_open(self::getTimeZone()), new DateTime() );

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $query->from($db->quoteName('#__spcustomer_customer'));
        $query->where("TIMESTAMP(created + INTERVAL ". $db->quote($timeOffset). " SECOND) >= ". $db->quote($dStart));
        $query->where("TIMESTAMP(created + INTERVAL ". $db->quote($timeOffset). " SECOND) <= ". $db->quote($dEnd));
        if ($type == 'T') {
            $query->where('username'. " IN (SELECT username FROM jos_spmessage_message WHERE campaign_id = ".$campaignId.")");
        } else {
            $query->where('username'. " NOT IN (SELECT username FROM jos_spmessage_message WHERE campaign_id = ".$campaignId.")");
        }

        $db->setQuery($query);
        $newUsersTarget = $db->loadResult();

        return $newUsersTarget;
    }

    /**
     * Returns the PresenceUserTarget
     * @return mixed
     */
    public static function getPresenceUsersAjax()
    {
        $data = $_REQUEST['data'];
        $campaignId = $data['campaignId'];
        $username = $data['username'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $query->from($db->quoteName('#__spmessage_message'));
        $query->where($db->quoteName('campaign_id') ." = ". $db->quote($campaignId));
        $query->where($db->quoteName('username') ." = ". $db->quote($username));

        $db->setQuery($query);
        $presenceUsersTarget = $db->loadResult();

        return $presenceUsersTarget;
    }

}