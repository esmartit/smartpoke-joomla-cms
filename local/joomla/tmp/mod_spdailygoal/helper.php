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
     * Retrieves the hello message
     *
     * @param   array  $params An object containing the module parameters
     *
     * @access public
     */
    public static function getValue($params)
    {
        $db    = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName('value'))
            ->from($db->quoteName('#__spvalue_value'))
            ->where($db->quoteName('code_value') . ' = ' . $db->quote('daily_goal_device'));

        $db->setQuery($query);
        $value = $db->loadResult();

        return number_format($value);
    }
}