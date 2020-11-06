<?php
/**
 * @package    smartpoke-cms
 *
 * @author     gustavo.rodriguez <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

use Joomla\CMS\MVC\View\HtmlView;

defined('_JEXEC') or die;

/**
 * Splash view.
 *
 * @package   smartpoke-cms
 * @since     1.0.0
 */
class SplashViewSplash extends HtmlView
{
    /**
     * Display the Hello World view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {

        $jinput = JFactory::getApplication()->input;
        $this->login_url     = $jinput->get('login_url',null,'STRING');
        $this->continue_url     = $jinput->get('continue_url',null,'STRING');
        $this->ap_name     = $jinput->get('ap_name');
        $this->ap_mac     = $jinput->get('ap_mac');
        $this->ap_tags     = $jinput->get('ap_tags');
        $this->client_mac     = $jinput->get('client_mac');

        // Display the view
        parent::display($tpl);
    }
}
