<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_splashpage
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
     * This display function returns in json format the Helloworld greetings
     *   found within the latitude and longitude boundaries of the map.
     * These bounds are provided in the parameters
     *   minlat, minlng, maxlat, maxlng
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
        $firstname = $input->get('firstname', 'STRING');
        $lastname = $input->get('lastname', 'STRING');
        $sex = $input->get('sex');
        $membership = $input->get('membership');
        $zipcode = $input->get('zipcode', 'STRING');

        $spot_id = $input->get('spot_id');
        $hotspot_name = $input->get('hotspot_name', 'STRING');
        $groupname = $input->get('groupname', 'STRING');
        $currDate = date('Y-m-d H:i:s');

//        $model = JModelLegacy::getInstance('login', 'SplashpageModelLogin');
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

        $status = 0;
        if ($campaign_id != '') {
            $campaign_description = $campaign['message_sms'];
            $campaign_name = $campaign['name'];
            // Call API to send a campaign
            $phoneSMS = $mobilephone;
            $messageSMS = $campaign_description;
            $senderSMS = $hotspot_name;

            $resultSMS = 'OK';
//            $resultSMS = trim($model->sendWorldLine($phoneSMS, $messageSMS, $senderSMS)); // WorldLine Web SMS

            $status = 0;
            if (substr($resultSMS, 0, 2) == 'OK') $status = 1;

            // Call a method to Insert the success message sent
            $values = array($campaign_id, $clientMac, $username, $currDate, $status, $resultSMS);
            $model->saveMessage($values);
        }
        if ($status == 1) {
            $arr_result[] = array("section" => "go", "data" => $password);
        } else {
            $arr_result[] = array("section" => "error", "data" => Jtext::_('COM_SPLASPAGE_ERROR_PHONE'));
        }
        echo new JResponseJson($arr_result);
    }

}