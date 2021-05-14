<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_splashpage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * SplashPage Model
 *
 * @since  0.0.1
 */
class SplashpageModelRegister extends JModelItem
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

    public function signUp($data)
    {
        $this->plugin = JPluginHelper::getPlugin('system', 'backend_plugin');
        $base_uri = json_decode($this->plugin->params, true);

        $ch = curl_init();

        $dir_req = $base_uri['ms_radius'] . '/api/users/signUp';

        $param = json_encode($data);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
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

    public function getCampaign($smsemail = 1, $type = "REGISTER")
    {
        $currDate = date('Y-m-d');

        $db    = JFactory::getDBO();
        $query = $db
            ->getQuery(true)
            ->select('id, name, message_sms, message_email, deferred, deferreddate')
            ->from('#__spcampaign_campaign')
            ->where($db->quoteName('validdate'). " >= " . $db->quote($currDate), 'and')
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

    public function saveCustomer($values = null)
    {
        $currDate = date('Y-m-d H:i:s');

        $customer = new stdClass();
        $customer->id = null;
        $customer->alias = strtolower($values[10]).$values[11];
        $customer->communication = $values[0];
        $customer->dateofbirth = $values[1];
        $customer->email = $values[2];
        $customer->firstname = $values[3];
        $customer->lastname = $values[4];
        $customer->membership = $values[12];
        $customer->mobile_phone = $values[5];
        $customer->sex = $values[6];
        $customer->spot = $values[7];
        $customer->username = $values[8];
        $customer->zipcode = $values[9];
        $customer->created = $currDate;
        $customer->modified = $currDate;
        $customer->params = '';
        $db = JFactory::getDBO();
        $db->insertObject('#__spcustomer_customer', $customer, 'id');
        return;
    }

    public function sendWorldLine($phone, $message, $sender, $deferred, $unicode) {

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
            '&unicode='.$unicode.
            '&concatenate=5'.
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

}