<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spavgtimebigdata
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPAvgTimeBigDataHelper
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

    function time2strAjax() {

        $str = "";                // initialize variable
        $time = $_REQUEST['data'];
        $time = floor($time);

        if (!$time)
            return "00:00:00";

        $d = $time / 86400;
        $d = floor($d);

        if ($d) {
            $str .= "$d d ";
            $time = $time % 86400;
        }

        $h = $time / 3600;
        $h = floor($h);
        if ($h) {
            $str .= substr("0$h:", -3);
            $time = $time % 3600;
        } else $str .= "00:";

        $m = $time / 60;
        $m = floor($m);

        if ($m) {
            $str .= substr("0$m:", -3);
            $time = $time % 60;
        } else $str .= "00:";

        if ($time)
            $str .= substr("0$time", -2);
        else $str .= "00:";


        $str = preg_replace("/, $/", '', $str);
        return $str;
    }

}