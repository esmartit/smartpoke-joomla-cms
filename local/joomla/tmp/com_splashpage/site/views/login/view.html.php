<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_splashpage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

/**
 * Splash Page view.
 *
 * @package   com_splashpage
 * @since     1.0.0
 */
class SplashpageViewLogin extends HtmlView
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
        $this->login_url = $jinput->get('login_url',null,'STRING');
        $this->continue_url = $jinput->get('continue_url',null,'STRING');
        $this->ap_name = $jinput->get('ap_name');
        $this->ap_mac = $jinput->get('ap_mac');
        $this->ap_tags = $jinput->get('ap_tags');
        $this->client_mac = $jinput->get('client_mac');
        $this->client_ip = $jinput->get('client_ip');

        $document = JFactory::getDocument();
        // everything's dependent upon JQuery
        JHtml::_('jquery.framework');
        $document->addScript(JURI::root() . "media/com_splashpage/js/splashpage.js");

        // Display the view
        parent::display($tpl);

    }
}
