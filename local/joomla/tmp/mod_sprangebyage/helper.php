<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sprangebyage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPRangeByAgeHelper
{
    /**
     * Returns the userTime zone if the user has set one, or the global config one
     * @return mixed
     */
    public static function getRangeByAgeAjax() {

        $db = JFactory::getDbo();
        $db->setQuery('select TIMESTAMPDIFF(YEAR, dateofbirth, now()) as years, count(*) 
                            from jos_spcustomer_customer 
                            where published = 1
                            group by years');

        $ageList = $db->loadRowList();

        return $ageList;
    }
}