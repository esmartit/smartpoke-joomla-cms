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
     * Returns the SpotSensorList
     * @return mixed
     */
    public static function getSpotSensorsAjax()
    {
        $data = $_REQUEST['data'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];
        $zipcode = implode(",", $data['zipcodeId']);
        $spotId = $_REQUEST['spot'];
        $sensorId = $_REQUEST['sensor'];
        $zoneId = $_REQUEST['zone'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select((array('spot_id', 'name', 'COUNT(spot_id)')));
        $query->from($db->quoteName('#__spspot_spot'));
        $query->join('INNER', $db->quoteName('#__spsensor_sensor') . ' ON ' . $db->quoteName('spot') . ' = ' . $db->quoteName('spot_id'));

        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }

        if (!empty($stateId)) {
            $query->where($db->quoteName('state'). " = " .$db->quote($stateId));
        }

        if (!empty($cityId)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($cityId));
        }

        if (!empty($zipcode[0])) {
            $query->where('zipcode' . " IN (" . $zipcode . ")");
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }
        if (!empty($sensorId)) {
            $query->where($db->quoteName('sensor_id'). " = " .$db->quote($sensorId));
        }
        if (!empty($zoneId)) {
            $query->where($db->quoteName('zone'). " = " .$db->quote($zoneId));
        }
        $query->group($db->quoteName('spot'), $db->quoteName('name'));

        $db->setQuery($query);
        $spotList = $db->loadRowList();

        $query = $db->getQuery(true);
        $query->select((array('sensor_id', 'location', 'z.name')));
        $query->from($db->quoteName('#__spsensor_sensor'));
        $query->join('INNER', $db->quoteName('#__spspot_spot') . ' ON ' . $db->quoteName('spot_id') . ' = ' . $db->quoteName('spot'));
        $query->join('INNER', $db->quoteName('#__spzone_zone', 'z') . ' ON ' . $db->quoteName('z.id') . ' = ' . $db->quoteName('zone'));

        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }

        if (!empty($stateId)) {
            $query->where($db->quoteName('state'). " = " .$db->quote($stateId));
        }

        if (!empty($cityId)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($cityId));
        }

        if (!empty($zipcode[0])) {
            $query->where('zipcode' . " IN (" . $zipcode . ")");
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }
        if (!empty($sensorId)) {
            $query->where($db->quoteName('sensor_id'). " = " .$db->quote($sensorId));
        }
        if (!empty($zoneId)) {
            $query->where($db->quoteName('zone'). " = " .$db->quote($zoneId));
        }
        $query->order($db->quoteName('spot'), $db->quoteName('location'));

        $db->setQuery($query);
        $sensorList = $db->loadRowList();

        $spotsensorList = ['spot'=>$spotList, 'sensor'=>$sensorList];

        return $spotsensorList;
    }

    /**
     * Returns the HotSpotList
     * @return mixed
     */
    public static function getHotSpotsAjax()
    {
        $spotId = $_REQUEST['data'];

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query
            ->select($db->quoteName(array('id', 'name')))
            ->from($db->quoteName('#__sphotspot_hotspot'));

        if (!empty($spotId)) {
            $query->where($db->quoteName('spot'). " = " .$db->quote($spotId));
        }

        $db->setQuery($query);
        $hotspotList = $db->loadRowList();

        return $hotspotList;
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
        $query->select(array('name', 'message_sms', 'message_email', 'deferred', 'deferreddate'));
        $query->from($db->quoteName('#__spcampaign_campaign'));
        $query->where($db->quoteName('id'). " = ". $db->quote($campaignId));
        $db->setQuery($query);
        $campaign = $db->loadAssoc();

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
     * Returns the UserInfo
     * @return mixed
     */
    public static function getUserInfoAjax() {
        $username = $_REQUEST['data'];

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('firstname', 'lastname', 'mobile_phone', 'email'));
        $query->from($db->quoteName('#__spcustomer_customer'));
        $query->where($db->quoteName('username'). " = " .$db->quote($username));

        $db->setQuery($query);
        $userInfo = $db->loadObjectList();

        return $userInfo;
    }

    /**
     * Returns the UserList
     * @return mixed
     */
    public static function getUserListAjax()
    {
        $data = $_REQUEST['data'];
        $countryId = $data['countryId'];
        $stateId = $data['stateId'];
        $cityId = $data['cityId'];
        $zipcode = implode(",", $data['zipcodeId']);
        $spotId = $data['spotId'];
        $ageS = $data['ageStart'];
        $ageE = $data['ageEnd'];
        $gender = $data['gender'];
        $zipCode = implode(",", $data['zipCode']);
        $member = $data['memberShip'];

        switch ($gender) {
            case 'MALE':
                $sex = '0';
                break;
            case 'FEMALE':
                $sex = '1';
                break;
            default:
                $sex = '';
                break;
        }
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select(array('firstname', 'lastname', 'mobile_phone', 'email', 'username', 'TIMESTAMPDIFF(YEAR, dateofbirth, now()) as age', 'sex', 'c.zipcode', 'membership', 'name'));
        $query->from($db->quoteName('#__spcustomer_customer', 'c'));
        $query->join('INNER', $db->quoteName('#__spspot_spot', 's') . ' ON ' . $db->quoteName('s.spot_id'). ' = ' . $db->quoteName('spot'));
        $query->where($db->quoteName('communication') . " = 1");
        $query->where($db->quoteName('c.published') . " = 1");



        if (!empty($ageS) && !empty($ageE)) {
            $query->where('TIMESTAMPDIFF(YEAR, dateofbirth, now())  >= ' . $ageS);
            $query->where('TIMESTAMPDIFF(YEAR, dateofbirth, now())  <= ' . $ageE);
        }
        if (!empty($countryId)) {
            $query->where($db->quoteName('country'). " = " .$db->quote($countryId));
        }

        if (!empty($stateId)) {
            $query->where($db->quoteName('state'). " = " .$db->quote($stateId));
        }

        if (!empty($cityId)) {
            $query->where($db->quoteName('city'). " = " .$db->quote($cityId));
        }

        if (!empty($zipcode[0])) {
            $query->where('s.zipcode' . " IN (" . $zipcode . ")");
        }
        if (!empty($spotId)) {
            $query->where($db->quoteName('spot') . " = " . $db->quote($spotId));
        }
        if ($sex != "") {
            $query->where($db->quoteName('sex') . " = " . $db->quote($sex));
        }
        if (!empty($zipCode)) {
            $query->where('c.zipcode' . " IN (" . $zipCode . ")");
        }
        if ($member != "") {
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
    public static function sendSMSAjax() {
        $arrlist = $_REQUEST['data'];
        $list = ($arrlist['str']);

        $ok = 0;
        $nok = 0;

        $campaignId = $arrlist['campaign'];
        $arrCampaign = self::getMessageCampaign($campaignId);
        $messageCampaign = $arrCampaign['message_sms'];
        $deferred = $arrCampaign['deferred'];
        $deferreddate = '';
        if ($deferred == '1') {
            $deferreddate = $arrCampaign['deferreddate'];
        }

        for ($i=0; $i<count($list); $i++) {
            $field = $list[$i]['name'];
            $data = $list[$i]['value'];

            if ($field == 'id[]') {
                $msgMobile = substr($data, 0, strpos($data, "-"));
                $strName = substr($data, (strpos($data, "-") + 1), (strlen($data) - strpos($data, "-")));
                $msgName = substr($strName, 0, strpos($strName, "/"));
                $msgDevice = '';
                $strUsername = substr($data, (strpos($data, "/") + 1), (strlen($data) - strpos($data, "/")));
                $msgUsername = substr($strUsername, 0, strpos($strUsername, "|"));

                $phoneSMS = $msgMobile;
                // $messageSMS = $msgDesc;
                $messageSMS = trim($msgName).', '.$messageCampaign;

                $status = 0;
                $resultSMS = trim(self::sendWorldLine($phoneSMS, urlencode(utf8_decode($messageSMS)), 'SmartPoke', $deferreddate)); // WorldLine Web SMS
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
     * Returns the SendWorlLineSMS
     * @return mixed
     */
    public static function sendWorldLine($phone, $message, $sender, $deferred) {

        //  certificado pem extraido de un pkcs12 con la ruta completa absoluta
        $cert = '/bitnami/joomla/certs_sms/esmartit.pem';
        $key = '/bitnami/joomla/certs_sms/esmartit_key.pem';

        //  password del certificado pem
        $passwd = "Te2pp2so";

        $param = 'user=ESMARTIT'.
            '&company=ESMARTIT'.
            '&passwd=P45_m61X'.
            '&gsm=%2B'.$phone.
            '&type=plus'.
            '&unicode=true'.
            '&msg='.$message.
            '&sender='.$sender;
        if ($deferred != '') {
            $param .= '&deferred='.$deferred;
        }

        //    $url = 'https://push.tempos21.com/mdirectnx-trust/send?'; Ruta con IP
        $url = 'https://push.tempos21.com/mdirectnx/send?';
        $ch = curl_init();

        //  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //  curl_setopt($ch, CURLOPT_URL, $url);
        //  curl_setopt($ch, CURLOPT_POST, 1);
        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $param);

        curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_SSLVERSION, 1);
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

    /**
     * Returns the SendEmail
     * @return mixed
     */
    public static function sendEmailAjax() {
        $arrlist = $_REQUEST['data'];
        $list = ($arrlist['str']);

        $ok = 0;
        $nok = 0;

        $campaignId = $arrlist['campaign'];
        $arrCampaign = self::getMessageCampaign($campaignId);
        $messageTitle = $arrCampaign['name'];
        $messageCampaign = $arrCampaign['message_email'];
        $deferred = $arrCampaign['deferred'];
        $deferreddate = '';
        if ($deferred == '1') {
            $deferreddate = $arrCampaign['$deferreddate'];
        }

        for ($i=0; $i<count($list); $i++) {
            $field = $list[$i]['name'];
            $data = $list[$i]['value'];

            if ($field == 'id[]') {
                $strName = substr($data, (strpos($data, "-") + 1), (strlen($data) - strpos($data, "-")));
                $msgName = substr($strName, 0, strpos($strName, "/"));
                $msgDevice = '';
                $strUsername = substr($data, (strpos($data, "/") + 1), (strlen($data) - strpos($data, "/")));
                $msgUsername = substr($strUsername, 0, strpos($strUsername, "|"));
                $userEmail = substr($data, (strpos($data, "|") + 1), (strlen($data) - strpos($data, "|")));
                $messageEmail = trim($msgName).", \n".$messageCampaign;

                $status = 0;
                $result = trim(self::sendJoomlaEmail($userEmail, $messageTitle, $messageEmail, 'SmartPoke')); // WorldLine Web SMS
                if ($result) {
                    $status = 1;
                    $description = 'Email was sent successfully';
                    $ok = $ok + 1;
                } else {
                    $nok = $nok + 1;
                    $description = 'Email could not sent correctly';
                }
                $currDate = date('Y-m-d H:i:s');

                $values = array($campaignId, $msgDevice, $msgUsername, $currDate, $status, $description);
                self::saveMessage($values);
            }
        }
        $message = "Total eMail(s) Ok: ".$ok." Total eMail(s) NOk: ".$nok;
        return $message;
    }

    /**
     * Returns the SendJoomlaEmail
     * @return mixed
     */
    public static function sendJoomlaEmail($email, $title, $message, $sender) {

        $subject = $title;
        $body = $message;
        $to = $email;
        $from = 'no-reply@esmartit.es';

        // Invoke JMail Class
        $output = JFactory::getMailer()->sendMail($from, $sender, $to, $subject, $body);

        return $output;
    }

    /**
     * Returns the SaveMessage
     * @return mixed
     */
    public static function saveMessage($values = null)
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

    public static function saveFileAjax() {

        $uploadDir = '/bitnami/joomla/tmpfiles/';
        $response = array();

        $uploadStatus = 1;
        $uploadedFile = '';
        $token = time();

        $file_name = $_FILES['file']['name'];
        $file_temp = $_FILES["file"]["tmp_name"];

        $response['status'] = 0;
        $response['message'] = 'Upload failed, please try again.';
        $response['file'] = $file_name;

        if (!empty($_FILES['file']['name'])){

            $fileName = "smartpokeFile-".$token.".json";
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
                $uploadedFile = $fileName;
            } else {
                $uploadStatus = 0;
                $response['status'] = 0;
                $response['message'] = 'Sorry, there was an error uploading your file.';
                $response['file'] = $file_name;
            }
            if ($uploadStatus == 1){
                $response['status'] = 1;
                $response['message'] = 'Upload file successfully!';
                $response['file'] = $uploadedFile;
            }
        }
        return $response;
    }
}