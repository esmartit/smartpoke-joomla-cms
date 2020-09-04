<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.1
	@build			3rd September, 2020
	@created		14th April, 2020
	@package		SP Sensor
	@subpackage		view.html.php
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Spsensor View class for the Listsensor
 */
class SpsensorViewListsensor extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{		
		// get combined params of both component and menu
		$this->app = JFactory::getApplication();
		$this->params = $this->app->getParams();
		$this->menu = $this->app->getMenu()->getActive();
		// get the user object
		$this->user = JFactory::getUser();
		// Initialise variables.
		$this->items = $this->get('Items');

		// Set the toolbar
		$this->addToolBar();

		// set the document
		$this->_prepareDocument();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode(PHP_EOL, $errors), 500);
		}

		parent::display($tpl);
	}


/***[JCBGUI.site_view.php_jview.36.$$$$]***/
    public function getSpotList() {

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('spot_id', 'name')));
        $query->from($db->quoteName('#__spspot_spot'));

        $db->setQuery($query);
        $spotList = $db->loadRowList();

        return $spotList;

    }

    public function getZoneList() {

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'name')));
        $query->from($db->quoteName('#__spzone_zone'));

        $db->setQuery($query);
        $spotList = $db->loadRowList();

        return $spotList;

    }/***[/JCBGUI$$$$]***/


	/**
	 * Prepares the document
	 */
	protected function _prepareDocument()
	{

		// always make sure jquery is loaded.
		JHtml::_('jquery.framework');
		// Load the header checker class.
		require_once( JPATH_COMPONENT_SITE.'/helpers/headercheck.php' );
		// Initialize the header checker.
		$HeaderCheck = new spsensorHeaderCheck;

		// Add View JavaScript File
		$this->document->addScript(JURI::root(true) . "/components/com_spsensor/assets/js/listsensor.js", (SpsensorHelper::jVersion()->isCompatible("3.8.0")) ? array("version" => "auto") : "text/javascript");
		// load the meta description
		if ($this->params->get('menu-meta_description'))
		{
			$this->document->setDescription($this->params->get('menu-meta_description'));
		}
		// load the key words if set
		if ($this->params->get('menu-meta_keywords'))
		{
			$this->document->setMetadata('keywords', $this->params->get('menu-meta_keywords'));
		}
		// check the robot params
		if ($this->params->get('robots'))
		{
			$this->document->setMetadata('robots', $this->params->get('robots'));
		}
		// add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/components/com_spsensor/assets/css/listsensor.css', (SpsensorHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// adding the joomla toolbar to the front
		JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');
		
		// set help url for this view if found
		$help_url = SpsensorHelper::getHelpUrl('listsensor');
		if (SpsensorHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_SPSENSOR_HELP_MANAGER', false, $help_url);
		}
		// now initiate the toolbar
		$this->toolbar = JToolbar::getInstance();
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var, $sorten = false, $length = 40)
	{
		// use the helper htmlEscape method instead.
		return SpsensorHelper::htmlEscape($var, $this->_charset, $sorten, $length);
	}
}
