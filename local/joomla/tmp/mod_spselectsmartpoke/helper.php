<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectsmartpoke
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

class ModSPSelectSmartPokeHelper
{

    /**
     * Returns the SpotList
     * @return mixed
     */
    public static function getSpotsAjax()
    {
        $city = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('spot_id', 'name')));
        $query->from($db->quoteName('#__spspot_spot'));
        $query->where($db->quoteName('city'). " = " .$db->quote($city));

        $db->setQuery($query);
        $spotList = $db->loadRowList();

        return $spotList;
    }

    /**
     * Returns the SensorList
     * @return mixed
     */
    public static function getSensorsAjax()
    {
        $spotId = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('sensor_id', 'location')));
        $query->from($db->quoteName('#__spsensor_sensor'));
        $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));

        $db->setQuery($query);
        $sensorList = $db->loadRowList();

        return $sensorList;
    }

    /**
     * Returns the SensorList
     * @return mixed
     */
    public static function getSpotSensorsAjax()
    {
        $cityId = $_REQUEST['city'];
        $spotId = $_REQUEST['spot'];
        $sensorId = $_REQUEST['sensor'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select((array('spot_id', 'name', 'COUNT(spot_id)')));
        $query->from($db->quoteName('#__spspot_spot'));
        $query->join('INNER', $db->quoteName('#__spsensor_sensor') . ' ON ' . $db->quoteName('spot') . ' = ' . $db->quoteName('spot_id'));

        if (!empty($cityId)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($cityId));
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }
        if (!empty($sensorId)) {
            $query->where($db->quoteName('sensor_id'). " = " .$db->quote($sensorId));
        }
        $query->group($db->quoteName('spot'), $db->quoteName('name'));

        $db->setQuery($query);
        $spotList = $db->loadRowList();

        $query = $db->getQuery(true);
        $query->select((array('sensor_id', 'location', 'z.name')));
        $query->from($db->quoteName('#__spsensor_sensor'));
        $query->join('INNER', $db->quoteName('#__spspot_spot') . ' ON ' . $db->quoteName('spot_id') . ' = ' . $db->quoteName('spot'));
        $query->join('INNER', $db->quoteName('#__spzone_zone', 'z') . ' ON ' . $db->quoteName('z.id') . ' = ' . $db->quoteName('zone'));

        if (!empty($cityId)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($cityId));
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }
        if (!empty($sensorId)) {
            $query->where($db->quoteName('sensor_id'). " = " .$db->quote($sensorId));
        }
        $query->order($db->quoteName('spot'), $db->quoteName('location'));

        $db->setQuery($query);
        $sensorList = $db->loadRowList();

        $spotsensorList = ['spot'=>$spotList, 'sensor'=>$sensorList];

        return $spotsensorList;
    }

    /**
     * Returns the CampaignList
     * @return mixed
     */
    public static function getCampaignsAjax()
    {
        $currDate = date('Y-m-d');
        $smsemail = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'name')));
        $query->from($db->quoteName('#__spcampaign_campaign'));
        $query->where($db->quoteName('validdate'). " >= " . $db->quote($currDate), 'AND');
        $query->where($db->quoteName('smsemail'). " = ". $db->quote($smsemail), 'AND');
        $query->where($db->quoteName('type'). " = 'CAMPAIGN'");
        $db->setQuery($query);
        $campaignList = $db->loadRowList();

        return $campaignList;
    }

    /**
     * Returns the CampaignList
     * @return mixed
     */
    public static function getMessageCampaign($value = '1')
    {
        $campaignId = $value;

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName('message_sms'));
        $query->from($db->quoteName('#__spcampaign_campaign'));
        $query->where($db->quoteName('id'). " = ". $db->quote($campaignId), 'AND');
        $db->setQuery($query);
        $campaign = $db->loadResult();

        return $campaign;
    }


    /**
     * Returns the BrandList
     * @return mixed
     */
    public static function getBrands()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'name')))
            ->from($db->quoteName('#__spbrand_brand'));
        $db->setQuery($query);
        $brandList = $db->loadObjectList();

        return $brandList;
    }

    /**
     * Returns the ZipcodeList
     * @return mixed
     */
    public static function getZipCodes()
    {
        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('zipcode')))
            ->from($db->quoteName('#__spcustomer_customer'))
            ->where($db->quoteName('zipcode'). '!=' .$db->quote(''))
            ->group($db->quoteName('zipcode'));
        $db->setQuery($query);
        $zipcodeList = $db->loadObjectList();

        return $zipcodeList;
    }

    public static function getTimeZone() {
        $userTz = JFactory::getUser()->getParam('timezone');
        $timeZone = JFactory::getConfig()->get('offset');
        if($userTz) {
            $timeZone = $userTz;
        }
        return $timeZone;
    }

    /**
     * Returns the UserList
     * @return mixed
     */
    public static function getUserListAjax()
    {
        $data = $_REQUEST['data'];
        $cityId = $data['cityId'];
        $spotId = $data['spotId'];
        $ageS = $data['ageStart'];
        $ageE = $data['ageEnd'];
        $sex = $data['gender'];
        $zipCode = implode(",", $data['zipCode']);
        $member = $data['memberShip'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('firstname', 'lastname', 'mobile_phone', 'email', 'username', 'TIMESTAMPDIFF(YEAR, dateofbirth, now()) as age', 'sex', 'zipcode', 'membership', 'name'));
        $query->from($db->quoteName('#__spcustomer_customer', 'c'));
        $query->join('INNER', $db->quoteName('#__spspot_spot', 's') . ' ON ' . $db->quoteName('s.spot_id'). ' = ' . $db->quoteName('spot'));

        if (!empty($ageS) && !empty($ageE)) {
            $query->where('TIMESTAMPDIFF(YEAR, dateofbirth, now())  >= ' . $ageS);
            $query->where('TIMESTAMPDIFF(YEAR, dateofbirth, now())  <= ' . $ageE);
        }
        if (!empty($cityId)) {
            $query->where($db->quoteName('city') . " = " . $db->quote($cityId));
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot') . " = " . $db->quote($spotId));
        }
        if (!empty($sex)) {
            $query->where($db->quoteName('sex') . " = " . $db->quote($sex));
        }
        if (!empty($zipCode[0])) {
            $query->where('zipcode' . " IN (" . $zipCode . ")");
        }
        if (!empty($member)) {
            $query->where($db->quoteName('membership') . " = " . $db->quote($member));
        }

        $db->setQuery($query);
        $userList = $db->loadObjectList();

        return $userList;
    }

    /**
     * Returns the SendSMS
     * @return mixed
     */
    public function sendSMSAjax() {
        $arrlist = $_REQUEST['data'];
        $list = ($arrlist['str']);

        $ok = 0;
        $nok = 0;

        $campaignId = $arrlist['campaign'];
        $messageCampaign = self::getMessageCampaign($campaignId);

        for ($i=0; $i<count($list); $i++) {
            $field = $list[$i]['name'];
            $data = $list[$i]['value'];

            if ($field == 'id[]') {
                $msgMobile = substr($data, 0, strpos($data, "-"));
                $strName = substr($data, (strpos($data, "-") + 1), (strlen($data) - strpos($data, "-")));
                $msgName = substr($strName, 0, strpos($strName, "/"));
                $msgDevice = '';
                $msgUsername = substr($data, (strpos($data, "/") + 1), (strlen($data) - strpos($data, "/")));

                $phoneSMS = $msgMobile;
                // $messageSMS = $msgDesc;
                $messageSMS = trim($msgName).', '.$messageCampaign;

                $status = 0;
                $resultSMS = trim(self::sendWorldLine($phoneSMS, $messageSMS, 'SmartPoke')); // WorldLine Web SMS
                if (substr($resultSMS, 0, 2) == 'OK') {
                    $status = 1;
                    $ok = $ok + 1;
                } else $nok = $nok + 1;
                $currDate = date('Y-m-d H:i:s');

                $values = array($campaignId, $msgDevice, $msgUsername, $currDate, $status, $resultSMS);
                self::saveMessage($values);
            }
        }
        $message = "Total SMS Ok: ".$ok." Total SMS NOk: ".$nok;
        return $message;
    }

    /**
     * Returns the SaveMessage
     * @return mixed
     */
    public function saveMessage($values = null)
    {
        $msg = new stdClass();
        $msg->id = null;
        $msg->campaign_id = $values[0];
        $msg->device_sms = $values[1];
        $msg->username = $values[2];
        $msg->senddate = $values[3];
        $msg->status = $values[4];
        $msg->description = $values[5];
        $msg->params = '';
        $msg->metakey= '';
        $msg->metadesc = '';
        $msg->metadata = '';
        $db = JFactory::getDBO();
        $db->insertObject('#__spmessage_message', $msg, 'id');
        return;
    }

    /**
     * Returns the SendWorlLineSMS
     * @return mixed
     */
    public function sendWorldLine($phone, $message, $sender) {

        //  certificado pem extraido de un pkcs12 con la ruta completa absoluta
        $cert = '/bitnami/joomla/certs_sms/esmartit.pem';
        $key = '/bitnami/joomla/certs_sms/esmartit_key.pem';

        //  password del certificado pem
        $passwd = "Te2pp2so";

        $param='user=ESMARTIT'.
            '&company=ESMARTIT'.
            '&passwd=P45_m61X'.
            '&gsm=%2B'.$phone.
            '&type=plus'.
            '&msg='.$message.
            '&sender='.$sender;

        //    $url = 'https://push.tempos21.com/mdirectnx-trust/send?'; Ruta con IP
        $url = 'https://push.tempos21.com/mdirectnx/send?';
        $ch = curl_init();

        //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //  curl_setopt($ch, CURLOPT_URL, $url);
        //  curl_setopt($ch, CURLOPT_POST, 1);
        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSLCERT, $cert);
        curl_setopt($ch, CURLOPT_SSLKEY, $key);
        curl_setopt($ch, CURLOPT_SSLCERTPASSWD, $passwd);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);

        if (curl_errno($ch)) {
            $output = 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $output;
    }
}