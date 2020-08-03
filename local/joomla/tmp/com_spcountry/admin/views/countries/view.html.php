<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			2nd August, 2020
	@created		20th July, 2020
	@package		SP Country
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
 * Spcountry View class for the Countries
 */
class SpcountryViewCountries extends JViewLegacy
{
	/**
	 * Countries view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			SpcountryHelper::addSubmenu('countries');
		}

		// Assign data to the view
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->user = JFactory::getUser();
		// Add the list ordering clause.
		$this->listOrder = $this->escape($this->state->get('list.ordering', 'a.id'));
		$this->listDirn = $this->escape($this->state->get('list.direction', 'asc'));
		$this->saveOrder = $this->listOrder == 'ordering';
		// set the return here value
		$this->return_here = urlencode(base64_encode((string) JUri::getInstance()));
		// get global action permissions
		$this->canDo = SpcountryHelper::getActions('country');
		$this->canEdit = $this->canDo->get('core.edit');
		$this->canState = $this->canDo->get('core.edit.state');
		$this->canCreate = $this->canDo->get('core.create');
		$this->canDelete = $this->canDo->get('core.delete');
		$this->canBatch = $this->canDo->get('core.batch');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
			$this->sidebar = JHtmlSidebar::render();
			// load the batch html
			if ($this->canCreate && $this->canEdit && $this->canState)
			{
				$this->batchDisplay = JHtmlBatch_::render();
			}
		}
		
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
		JToolBarHelper::title(JText::_('COM_SPCOUNTRY_COUNTRIES'), 'location');
		JHtmlSidebar::setAction('index.php?option=com_spcountry&view=countries');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('country.add');
		}

		// Only load if there are items
		if (SpcountryHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('country.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('countries.publish');
				JToolBarHelper::unpublishList('countries.unpublish');
				JToolBarHelper::archiveList('countries.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('countries.checkin');
				}
			}

			// Add a batch button
			if ($this->canBatch && $this->canCreate && $this->canEdit && $this->canState)
			{
				// Get the toolbar object instance
				$bar = JToolBar::getInstance('toolbar');
				// set the batch button name
				$title = JText::_('JTOOLBAR_BATCH');
				// Instantiate a new JLayoutFile instance and render the batch button
				$layout = new JLayoutFile('joomla.toolbar.batch');
				// add the button to the page
				$dhtml = $layout->render(array('title' => $title));
				$bar->appendButton('Custom', $dhtml, 'batch');
			}

			if ($this->state->get('filter.published') == -2 && ($this->canState && $this->canDelete))
			{
				JToolbarHelper::deleteList('', 'countries.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('countries.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('country.export'))
			{
				JToolBarHelper::custom('countries.exportData', 'download', '', 'COM_SPCOUNTRY_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('country.import'))
		{
			JToolBarHelper::custom('countries.importData', 'upload', '', 'COM_SPCOUNTRY_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = SpcountryHelper::getHelpUrl('countries');
		if (SpcountryHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_SPCOUNTRY_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_spcountry');
		}

		if ($this->canState)
		{
			JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_published',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
			);
			// only load if batch allowed
			if ($this->canBatch)
			{
				JHtmlBatch_::addListSelection(
					JText::_('COM_SPCOUNTRY_KEEP_ORIGINAL_STATE'),
					'batch[published]',
					JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('all' => false)), 'value', 'text', '', true)
				);
			}
		}

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		if ($this->canBatch && $this->canCreate && $this->canEdit)
		{
			JHtmlBatch_::addListSelection(
				JText::_('COM_SPCOUNTRY_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Country Code Isotwo Selection
		$this->country_code_isotwoOptions = $this->getTheCountry_code_isotwoSelections();
		// We do some sanitation for Country Code Isotwo filter
		if (SpcountryHelper::checkArray($this->country_code_isotwoOptions) &&
			isset($this->country_code_isotwoOptions[0]->value) &&
			!SpcountryHelper::checkString($this->country_code_isotwoOptions[0]->value))
		{
			unset($this->country_code_isotwoOptions[0]);
		}
		// Only load Country Code Isotwo filter if it has values
		if (SpcountryHelper::checkArray($this->country_code_isotwoOptions))
		{
			// Country Code Isotwo Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_ISOTWO_LABEL').' -',
				'filter_country_code_isotwo',
				JHtml::_('select.options', $this->country_code_isotwoOptions, 'value', 'text', $this->state->get('filter.country_code_isotwo'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Country Code Isotwo Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_ISOTWO_LABEL').' -',
					'batch[country_code_isotwo]',
					JHtml::_('select.options', $this->country_code_isotwoOptions, 'value', 'text')
				);
			}
		}

		// Set Country Code Isothree Selection
		$this->country_code_isothreeOptions = $this->getTheCountry_code_isothreeSelections();
		// We do some sanitation for Country Code Isothree filter
		if (SpcountryHelper::checkArray($this->country_code_isothreeOptions) &&
			isset($this->country_code_isothreeOptions[0]->value) &&
			!SpcountryHelper::checkString($this->country_code_isothreeOptions[0]->value))
		{
			unset($this->country_code_isothreeOptions[0]);
		}
		// Only load Country Code Isothree filter if it has values
		if (SpcountryHelper::checkArray($this->country_code_isothreeOptions))
		{
			// Country Code Isothree Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_ISOTHREE_LABEL').' -',
				'filter_country_code_isothree',
				JHtml::_('select.options', $this->country_code_isothreeOptions, 'value', 'text', $this->state->get('filter.country_code_isothree'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Country Code Isothree Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_ISOTHREE_LABEL').' -',
					'batch[country_code_isothree]',
					JHtml::_('select.options', $this->country_code_isothreeOptions, 'value', 'text')
				);
			}
		}

		// Set Name Selection
		$this->nameOptions = $this->getTheNameSelections();
		// We do some sanitation for Name filter
		if (SpcountryHelper::checkArray($this->nameOptions) &&
			isset($this->nameOptions[0]->value) &&
			!SpcountryHelper::checkString($this->nameOptions[0]->value))
		{
			unset($this->nameOptions[0]);
		}
		// Only load Name filter if it has values
		if (SpcountryHelper::checkArray($this->nameOptions))
		{
			// Name Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCOUNTRY_COUNTRY_NAME_LABEL').' -',
				'filter_name',
				JHtml::_('select.options', $this->nameOptions, 'value', 'text', $this->state->get('filter.name'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Name Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCOUNTRY_COUNTRY_NAME_LABEL').' -',
					'batch[name]',
					JHtml::_('select.options', $this->nameOptions, 'value', 'text')
				);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_('COM_SPCOUNTRY_COUNTRIES'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_spcountry/assets/css/countries.css", (SpcountryHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 50)
		{
			// use the helper htmlEscape method instead and shorten the string
			return SpcountryHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return SpcountryHelper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields()
	{
		return array(
			'ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.published' => JText::_('JSTATUS'),
			'a.country_code_isotwo' => JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_ISOTWO_LABEL'),
			'a.country_code_isothree' => JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_ISOTHREE_LABEL'),
			'a.name' => JText::_('COM_SPCOUNTRY_COUNTRY_NAME_LABEL'),
			'a.country_code_phone' => JText::_('COM_SPCOUNTRY_COUNTRY_COUNTRY_CODE_PHONE_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheCountry_code_isotwoSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('country_code_isotwo'));
		$query->from($db->quoteName('#__spcountry_country'));
		$query->order($db->quoteName('country_code_isotwo') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $country_code_isotwo)
			{
				// Now add the country_code_isotwo and its text to the options array
				$_filter[] = JHtml::_('select.option', $country_code_isotwo, $country_code_isotwo);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheCountry_code_isothreeSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('country_code_isothree'));
		$query->from($db->quoteName('#__spcountry_country'));
		$query->order($db->quoteName('country_code_isothree') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $country_code_isothree)
			{
				// Now add the country_code_isothree and its text to the options array
				$_filter[] = JHtml::_('select.option', $country_code_isothree, $country_code_isothree);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheNameSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('name'));
		$query->from($db->quoteName('#__spcountry_country'));
		$query->order($db->quoteName('name') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $name)
			{
				// Now add the name and its text to the options array
				$_filter[] = JHtml::_('select.option', $name, $name);
			}
			return $_filter;
		}
		return false;
	}
}
