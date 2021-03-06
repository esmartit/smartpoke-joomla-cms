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

class SplashpageViewLogin extends JViewLegacy
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

        $mobilephone = $phonecode.$mobile;

        $spot_id = $input->get('spot_id');
        $hotspot_name = $input->get('hotspot_name');
        $groupname = $input->get('groupname');
        $currDate = date('Y-m-d H:i:s');

        $model = $this->getModel();

        $validMobile = $this->validateMobile($countrycode, $mobile);
        if ( $validMobile != 1 ) {
            $arr_result[] = array("section" => "error", "data" => Jtext::_('COM_SPLASPAGE_ERROR_PHONE'));
        } else {

            $username = $countrycode . $mobile;
            // Call API to get the password from RadCheck - Freeradius
            $password = $model->getPassword($username);

            if ($password != '') {
                // Call API to update GroupName
                $data = array("username" => $username, "groupName" => $groupname);
                $updateGroupname = $model->updateGroupname($data);
                if (empty($updateGroupname)) {
                    $arr_result[] = array("section" => "go", "data" => $password);
                } else {
                    $arr_result[] = array("section" => "error", "data" => $updateGroupname);
                }
            } else {
                $newpwd = $this->createPassword(4, '0123456789' );
                $newpwd = substr('1111'.$newpwd,-4);

                // Call Method to verify if there is a campaign to send
                $campaign = $model->getCampaign($smsemail = 1, $type = "LOGIN");
                $campaign_id = $campaign['id'];

                $status = 0;
                if ($campaign_id != '') {

                    $campaign_description = $campaign['message_sms'];
                    $campaign_name = $campaign['name'];
                    // Call API to send a campaign
                    $phoneSMS = $mobilephone;
                    $messageSMS = $campaign_description." ".$newpwd;
                    $senderSMS = $hotspot_name;

                    $unicode = 'false';
                    if ($this->specialChars($messageSMS)) {
                        $unicode = 'true';
                        $messageSMS = urlencode(utf8_decode($messageSMS));
                    }
                    $resultSMS = 'OK';
//                    $resultSMS = trim(self::sendWorldLine($phoneSMS,  $messageSMS, 'SmartPoke', '', $unicode)); // WorldLine Web SMS

                    $status = 0;
                    if (substr($resultSMS, 0, 2) == 'OK') $status = 1;

                    // Call a method to Insert the success message sent
                    $values = array($campaign_id, $clientMac, $username, $currDate, $status, $resultSMS);
                    $model->saveMessage($values);
                }

                if ($status == 1) {
                    $arr_result[] = array("section" => "ok", "data" => $newpwd);
                } else {
                    $arr_result[] = array("section" => "error", "data" => Jtext::_('COM_SPLASPAGE_ERROR_MSG'));
                }
            }
        }
        echo new JResponseJson($arr_result);
    }

    /**
     * Returns True if found special character in the message
     * @return boolean
     */
    protected function specialChars($string) {
        if (preg_match('/#$%&+@^`~ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýþÿ¡¢£¤¥¦§¨©ª«¬®¯°±²³´µ¶·¸¹º»¼½¾¿/', $string) == 1) {
            return true;
        }
        return false;
    }

    protected function validateMobile($code, $number) {

        $res = 0;
        switch($code) {
            case "COL":
                if (preg_match("/^[3]{1}[0125]{1}[0-9]{1}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
            case "CRI":
                if (preg_match("/^[5678]{1}[0-9]{3}[0-9]{4}$/", $number)) {
                    $res = 1;
                }
                break;
            case "DEU":
                if (preg_match("/^[1]{1}[567]{1}[0-9]{8}$/", $number) || preg_match("/^[1]{1}[567]{1}[0-9]{9}$/", $number)) {
                    $res = 1;
                }
                break;
            case "DNK":
                if (preg_match("/^[23456789]{1}[0-9]{1}[0-9]{6}$/", $number)) {
                    $res = 1;
                }
                break;
            case "ESP":
                if (preg_match("/^[67]{1}[0-9]{2}[0-9]{6}$/", $number)) {
                    $res = 1;
                }
                break;
            case "FRA":
                if (preg_match("/^[6]{1}[0-9]{2}[0-9]{6}$/", $number)) {
                    $res = 1;
                }
                break;
            case "GBR":
                if (preg_match("/^[7]{1}[0-9]{2}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
            case "GTM":
                if (preg_match("/^[45]{1}[0-9]{3}[0-9]{4}$/", $number)) {
                    $res = 1;
                }
                break;
            case "ITA":
                if (preg_match("/^[3]{1}[0-9]{2}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
            case "MEX":
                if (preg_match("/^[58]{1}[15]{1}[0-9]{8}$/", $number) || preg_match("/^[2-9]{3}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
            case "NLD":
                if (preg_match("/^[6]{1}[0-9]{2}[0-9]{6}$/", $number)) {
                    $res = 1;
                }
                break;
            case "PER":
                if (preg_match("/^[9]{1}[0-9]{2}[0-9]{6}$/", $number)) {
                    $res = 1;
                }
                break;
            case "POR":
                if (preg_match("/^[9]{1}[0-9]{2}[0-9]{6}$/", $number)) {
                    $res = 1;
                }
                break;
            case "RUS":
                if (preg_match("/^[9]{1}[0-9]{2}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
            case "USA":
                if (preg_match("/^[1-9]{1}[0-9]{2}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
            case "VEN":
                if (preg_match("/^[4]{1}[0-9]{2}[0-9]{7}$/", $number)) {
                    $res = 1;
                }
                break;
        }
        return $res;
    }

    protected function createPassword($length, $chars) {

        if (!$chars)
            $chars = "ABCDEFGHJKMNPQRSTUVWXYZ23456789";

        if (!$length)
            $length = 4;

        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= ($length - 1)) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;
    }

}


