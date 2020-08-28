<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sptopcampaign
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;

/**
 * Helper for mod_sptopcampaign
 *
 * @since  1.6
 */
class ModSPTopCampaignHelper
{
    public static function getTopCampaignsAjax()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select(array('campaign_id', 'c.name', 'MIN(DATE(senddate)) as sent', 'c.validdate', 'COUNT(username) as total'))
            ->from($db->quoteName('#__spmessage_message', 'm'))
            ->join('INNER', $db->quoteName('#__spcampaign_campaign', 'c') . ' ON ' . $db->quoteName('c.id') . ' = ' . $db->quoteName('m.campaign_id'))
            ->where($db->quoteName('validdate'). '<= NOW()')
            ->where($db->quoteName('type'). '='. $db->quote( 'CAMPAIGN'))
            ->where($db->quoteName('c.published'). '= 1')
            ->group($db->quoteName('campaign_id'));
        $db->setQuery($query);
        $campaignList = $db->loadObjectList();

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

}
