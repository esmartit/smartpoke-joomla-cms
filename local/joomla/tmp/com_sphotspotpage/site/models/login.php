<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_sphotspotpage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * SpHotSpotPage Model
 *
 * @since  0.0.1
 */
class SpHotSpotPageModelLogin extends JModelItem
{
    /**
     * Method to getPassword the form data.
     *
     * @param string $user The form data.
     *
     * @return  boolean  True on success.
     *
     * @since   1.6
     */

    public function getPassword($user = null)
    {
        $this->plugin = JPluginHelper::getPlugin('system', 'backend_plugin');
        $base_uri = json_decode($this->plugin->params, true);

        $ch = curl_init();

        $dir_req = $base_uri['ms_radius'] . '/api/radcheck/search/findByUsername?username=' . $user;

        curl_setopt($ch, CURLOPT_URL, $dir_req);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $data = json_decode($res);
        $pass = '';
        if (!empty($data)) $pass = $data->value;

        return $pass;
    }

    public function updateGroupname($data)
    {
        $this->plugin = JPluginHelper::getPlugin('system', 'backend_plugin');
        $base_uri = json_decode($this->plugin->params, true);

        $ch = curl_init();

        $dir_req = $base_uri['ms_radius'] . '/api/users/group';

        $param = json_encode($data);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($ch, CURLOPT_URL, $dir_req);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $res = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        $result = json_decode($res);

        return $result;
    }

    public function getCampaign($smsemail = null, $type = null)
    {
        $db    = JFactory::getDBO();
        $query = $db
            ->getQuery(true)
            ->select('id, name, message_sms')
            ->from('#__spcampaign_campaign')
            ->where($db->quoteName('smsemail') . " = " . $db->quote($smsemail), 'and')
            ->where($db->quoteName('type') . " = " . $db->quote($type))
            ->setLimit(1);
        $db->setQuery((string) $query);
        $messages = $db->loadAssoc();

        return $messages;
    }

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

}