<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.1
	@build			1st October, 2020
	@created		1st October, 2020
	@package		SP HotSpot
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
 * Sphotspot View class for the Hotspots
 */
class SphotspotViewHotspots extends JViewLegacy
{
	/**
	 * Hotspots view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			SphotspotHelper::addSubmenu('hotspots');
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
		$this->canDo = SphotspotHelper::getActions('hotspot');
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
		JToolBarHelper::title(JText::_('COM_SPHOTSPOT_HOTSPOTS'), 'contract-2');
		JHtmlSidebar::setAction('index.php?option=com_sphotspot&view=hotspots');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('hotspot.add');
		}

		// Only load if there are items
		if (SphotspotHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('hotspot.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('hotspots.publish');
				JToolBarHelper::unpublishList('hotspots.unpublish');
				JToolBarHelper::archiveList('hotspots.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('hotspots.checkin');
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
				JToolbarHelper::deleteList('', 'hotspots.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('hotspots.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('hotspot.export'))
			{
				JToolBarHelper::custom('hotspots.exportData', 'download', '', 'COM_SPHOTSPOT_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('hotspot.import'))
		{
			JToolBarHelper::custom('hotspots.importData', 'upload', '', 'COM_SPHOTSPOT_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = SphotspotHelper::getHelpUrl('hotspots');
		if (SphotspotHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_SPHOTSPOT_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_sphotspot');
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
					JText::_('COM_SPHOTSPOT_KEEP_ORIGINAL_STATE'),
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
				JText::_('COM_SPHOTSPOT_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Spot Selection
		$this->spotOptions = $this->getTheSpotSelections();
		// We do some sanitation for Spot filter
		if (SphotspotHelper::checkArray($this->spotOptions) &&
			isset($this->spotOptions[0]->value) &&
			!SphotspotHelper::checkString($this->spotOptions[0]->value))
		{
			unset($this->spotOptions[0]);
		}
		// Only load Spot filter if it has values
		if (SphotspotHelper::checkArray($this->spotOptions))
		{
			// Spot Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPHOTSPOT_HOTSPOT_SPOT_LABEL').' -',
				'filter_spot',
				JHtml::_('select.options', $this->spotOptions, 'value', 'text', $this->state->get('filter.spot'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Spot Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPHOTSPOT_HOTSPOT_SPOT_LABEL').' -',
					'batch[spot]',
					JHtml::_('select.options', $this->spotOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_SPHOTSPOT_HOTSPOTS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_sphotspot/assets/css/hotspots.css", (SphotspotHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			return SphotspotHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return SphotspotHelper::htmlEscape($var, $this->_charset);
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
			'a.spot' => JText::_('COM_SPHOTSPOT_HOTSPOT_SPOT_LABEL'),
			'a.name' => JText::_('COM_SPHOTSPOT_HOTSPOT_NAME_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheSpotSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('spot'));
		$query->from($db->quoteName('#__sphotspot_hotspot'));
		$query->order($db->quoteName('spot') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $spot)
			{
				// Now add the spot and its text to the options array
				$_filter[] = JHtml::_('select.option', $spot, $spot);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheZoneSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('zone'));
		$query->from($db->quoteName('#__sphotspot_hotspot'));
		$query->order($db->quoteName('zone') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $zone)
			{
				// Now add the zone and its text to the options array
				$_filter[] = JHtml::_('select.option', $zone, $zone);
			}
			return $_filter;
		}
		return false;
	}
}
