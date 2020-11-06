<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sptraffichotspot
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPTrafficHotSpotHelper
{
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

    function toxByteAjax() {

        $size = $_REQUEST['data'];
        // Terabytes
        if ( $size > 1099511627776 ) {
            $ret = $size / 1099511627776;
            $ret = round($ret,2)." Tb";
            return $ret;
        }

        // Gigabytes
        if ( $size > 1073741824 ) {
            $ret = $size / 1073741824;
            $ret = round($ret,2)." Gb";
            return $ret;
        }

        // Megabytes
        if ( $size > 1048576 ) {
            $ret = $size / 1048576;
            $ret = round($ret,2)." Mb";
            return $ret;
        }

        // Kilobytes
        if ($size > 1024 ) {
            $ret = $size / 1024;
            $ret = round($ret,2)." Kb";
            return $ret;
        }

        // Bytes
        if ( ($size != "") && ($size <= 1024 ) ) {
            $ret = $size." B";
            return $ret;
        }
    }
}