<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_sphotspotpage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;

class SplashpageViewRegister extends JViewLegacy
{
    /**
     */

    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $countrycode = $input->get('countrycode');
        $phonecode = $input->get('phonecode');
        $mobile = $input->get('mobile');
        $clientMac = $input->get('client_mac');
        $username = $input->get('username');
        $password = $input->get('password');

        $mobilephone = $phonecode.$mobile;

        $communication = '1';
        $bdate = $input->get('bdate', '0000-00-00');
        $email_cli = $input->get('email_cli',  '', 'STRING');
        $firstname = $input->get('firstname', '', 'STRING');
        $lastname = $input->get('lastname', '', 'STRING');
        $sex = $input->get('sex');
        $membership = $input->get('membership');
        $zipcode = $input->get('zipcode', 'STRING');

        $spot_id = $input->get('spot_id');
        $hotspot_name = $input->get('hotspot_name', 'STRING');
        $groupname = $input->get('groupname', 'STRING');

        $model = $this->getModel();

        // Call Insert into Customer Table
        $values = array($communication, $bdate, $email_cli, $firstname, $lastname, $mobilephone, $sex, $spot_id, $username, $zipcode, $countrycode, $mobile, $membership);
        $model->saveCustomer($values);

        // Call API SignUp to insert in radcheck and radusergroup on freeradius
        $data = array("username" => $username,
            "password"=>$password,
            "groupName" => $groupname,
            "clientMac" => $clientMac,
            "bDate" => $bdate,
            "gender" => $sex,
            "zipCode" => $zipcode,
            "memberShip" => $membership,
            "spotId" => $spot_id,
            "hotspotName" => $hotspot_name
        );
        $model->signUp($data);

        $campaign = $model->getCampaign($smsemail = 1, $type = "REGISTER");
        $campaign_id = $campaign['id'];

        $status = 1;
        $messageSMS = '';
        if ($campaign_id != '') {
            $campaign_description = $campaign['message_sms'];
            $campaign_name = $campaign['name'];
            //$deferred = $campaign['deferred'];
            //$deferreddate = '';
            //if ($deferred == 1) {
            //    $deferreddate = $campaign['deferreddate'];
            //}
            // Call API to send a campaign
            $phoneSMS = $mobilephone;
            $messageSMS = $firstname.", ".$campaign_description;
            $senderSMS = $hotspot_name;

            //$unicode = 'false';
            //if ($this->specialChars($messageSMS)) {
            //	$unicode = 'true';
            //    $messageSMS = urlencode(utf8_decode($messageSMS));
            //}
            //            $resultSMS = 'OK';
            //$resultSMS = $model->sendWorldLine($phoneSMS, $messageSMS, $senderSMS, '', $unicode); // WorldLine Web SMS

            //if (substr($resultSMS, 0, 2) != 'OK') $status = 0;

            // Call a method to Insert the success message sent
            //$currDate = date('Y-m-d H:i:s');
            //$values = array($campaign_id, $clientMac, $username, $currDate, $status, $resultSMS);
            //$model->saveMessage($values);
        }
        $arr_result[] = array("section" => "go", "pass" => $password, "msg" => $messageSMS);

        echo new JResponseJson($arr_result);
    }

    /**
     * Returns True if found special character in the message
     * @return boolean
     */
    public static function specialChars($string) {
        $special = '#$%&+@^`~ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ¡¢£¤¥¦§¨©ª«¬®¯°±²³´µ¶·¸¹º»¼½¾¿€';
        for ($i=0; $i<strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $pattern = '/'.$char.'/';
            if (preg_match($pattern, $special) == 1)
                return true;

        }
        return false;
    }

}