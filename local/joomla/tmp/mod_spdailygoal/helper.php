<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spdailygoal
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPDailyGoalHelper
{
    /**
     * Returns the dailyGoal and dailyGoalReg from each cust
     * @return mixed
     */
    public static function getValueDev($params)
    {
        $db    = JFactory::getDbo();
        $tables = $db->getTableList();

        $value = 0;
        if (in_array('jos_spvalue_value', $tables)) {
            $query = $db->getQuery(true);
            $query
                ->select($db->quoteName('value'))
                ->from($db->quoteName('#__spvalue_value'))
                ->where($db->quoteName('code_value') . ' = ' . $db->quote('daily_goal_device'));

            $db->setQuery($query);
            $value = $db->loadResult();
        }
        return $value;
    }

    public static function getValueReg($params)
    {
        $db    = JFactory::getDbo();
        $tables = $db->getTableList();

        $value = 0;
        if (in_array('jos_spvalue_value', $tables)) {
            $query = $db->getQuery(true);
            $query
                ->select($db->quoteName('value'))
                ->from($db->quoteName('#__spvalue_value'))
                ->where($db->quoteName('code_value') . ' = ' . $db->quote('daily_goal_registered'));

            $db->setQuery($query);
            $value = $db->loadResult();
        }
        return $value;
    }

    public static function getTimeZone($params) {
        $userTz = JFactory::getUser()->getParam('timezone');
        $timeZone = JFactory::getConfig()->get('offset');
        if($userTz) {
            $timeZone = $userTz;
        }
        return $timeZone;
    }

}