<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_spcaptiveportal
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\View\HtmlView;

class SpCaptivePortalViewLogin extends JViewLegacy
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

        $challenge = $input->get('challenge');
        $currDate = date('Y-m-d H:i:s');

        $uamsecret = "3Sm4rt1T";
        $userpassword = 1;

        $model = $this->getModel();

        $validMobile = $this->validateMobile($countrycode, $mobile);
        if ( $validMobile != 1 ) {
            $arr_result[] = array("section" => "error", "data" => Jtext::_('COM_SPCAPTIVEPORTAL_ERROR_PHONE'));
        } else {

            $username = $countrycode . $mobile;
            // Call API to get the password from RadCheck - Freeradius
            $password = $model->getPassword($username);

            $hexchal = pack ("H32", $challenge);
            if ($uamsecret) {
                $newchal = pack ("H*", md5($hexchal . $uamsecret));
            } else {
                $newchal = $hexchal;
            }
            $response = md5("\0" . $password . $newchal);
            $newpwd = pack("a32", $password);
            $pappassword = implode ("", unpack("H32", ($newpwd ^ $newchal)));

            if ($password != '') {
                // Call API to update GroupName
                $data = array("username" => $username, "groupName" => $groupname);
                $updateGroupname = $model->updateGroupname($data);
                if (empty($updateGroupname)) {
                    $arr_result[] = array("section" => "go", "data" => $pappassword);
                } else {
                    $arr_result[] = array("section" => "error", "data" => $updateGroupname);
                }
            } else {
                $newpwd = $this->createPassword(4, '0123456789' );
                $newpwd = substr('1111'.$newpwd,-4);

                // Call Method to verify if there is a campaign to send
                $campaign = $model->getCampaign($smsemail = 1, $type = "LOGIN");
                $campaign_id = $campaign['id'];

                $status = 1;
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
//                    $resultSMS = trim($model->sendWorldLine($phoneSMS, $messageSMS, 'SmartPoke', '', $unicode)); // WorldLine Web SMS

                    $status = 0;
                    if (substr($resultSMS, 0, 2) == 'OK') $status = 1;

                    // Call a method to Insert the success message sent
                    $values = array($campaign_id, $clientMac, $username, $currDate, $status, $resultSMS);
                    $model->saveMessage($values);
                }

                if ($status == 1) {
                    $arr_result[] = array("section" => "ok", "data" => $newpwd);
                } else {
                    $arr_result[] = array("section" => "error", "data" => Jtext::_('COM_SPCAPTIVEPORTAL_ERROR_MSG'));
                }
            }
        }
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


