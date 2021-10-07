<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_spcaptiveportal
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

/**
 * Captive Portal view.
 *
 * @package   com_spcaptiveportal
 * @since     1.0.0
 */
class SpCaptivePortalViewLogin extends HtmlView
{
    /**
     * Display the Login view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        $jinput = JFactory::getApplication()->input;
//        $this->login_url = $jinput->get('login_url',null,'STRING');
//        $this->continue_url = $jinput->get('continue_url',null,'STRING');
//        $this->ap_name = $jinput->get('ap_name');
//        $this->ap_mac = $jinput->get('ap_mac');
//        $this->ap_tags = $jinput->get('ap_tags');
//        $this->client_mac = $jinput->get('client_mac');
//        $this->client_ip = $jinput->get('client_ip');

        $this->res = $jinput->get('res',null,'STRING');
        $this->challenge = $jinput->get('challenge',null,'STRING');
        $this->uamip = $jinput->get('uamip',null,'STRING');
        $this->uamport = $jinput->get('uamport',null,'STRING');
        $this->reply = $jinput->get('reply',null,'STRING');
        $this->timeleft = $jinput->get('timeleft',null,'STRING');

        $this->login_url = $jinput->get('login_url',null,'STRING');
        $this->user_url = $jinput->get('userurl',null,'STRING');
        $this->continue_url = $jinput->get('redirurl',null,'STRING');
        $this->ap_name = $jinput->get('nasid');
        $this->ap_mac = $jinput->get('called');
        $this->ap_tags = $jinput->get('');
        $this->client_mac = $jinput->get('mac');
        $this->client_ip = $jinput->get('ip');


        $document = JFactory::getDocument();
        // everything's dependent upon JQuery
        JHtml::_('jquery.framework');
        $document->addScript(JURI::root() . "media/com_spcaptiveportal/js/spcaptiveportal.js");

        // Display the view
        parent::display($tpl);

    }
}
