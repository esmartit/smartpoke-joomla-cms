<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		13th April, 2020
	@package		SP Business
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
 * Spbusiness View class
 */
class SpbusinessViewSpbusiness extends JViewLegacy
{
	/**
	 * View display method
	 * @return void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->icons			= $this->get('Icons');
		$this->contributors		= SpbusinessHelper::getContributors();
		
		// get the manifest details of the component
		$this->manifest = SpbusinessHelper::manifest();
		
		// Set the toolbar
		$this->addToolBar();
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		$canDo = SpbusinessHelper::getActions('spbusiness');
		JToolBarHelper::title(JText::_('COM_SPBUSINESS_DASHBOARD'), 'grid-2');

		// set help url for this view if found
		$help_url = SpbusinessHelper::getHelpUrl('spbusiness');
		if (SpbusinessHelper::checkString($help_url))
		{
			JToolbarHelper::help('COM_SPBUSINESS_HELP_MANAGER', false, $help_url);
		}

		if ($canDo->get('core.admin') || $canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_spbusiness');
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		
		// add dashboard style sheets
		$document->addStyleSheet(JURI::root() . "administrator/components/com_spbusiness/assets/css/dashboard.css");
		
		// set page title
		$document->setTitle(JText::_('COM_SPBUSINESS_DASHBOARD'));
		
		// add manifest to page JavaScript
		$document->addScriptDeclaration("var manifest = jQuery.parseJSON('" . json_encode($this->manifest) . "');", "text/javascript");
	}
}
