<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		6th April, 2020
	@package		SP Campaign
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
 * Spcampaign View class for the Campaigns
 */
class SpcampaignViewCampaigns extends JViewLegacy
{
	/**
	 * Campaigns view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			SpcampaignHelper::addSubmenu('campaigns');
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
		$this->canDo = SpcampaignHelper::getActions('campaign');
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
		JToolBarHelper::title(JText::_('COM_SPCAMPAIGN_CAMPAIGNS'), 'comment');
		JHtmlSidebar::setAction('index.php?option=com_spcampaign&view=campaigns');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('campaign.add');
		}

		// Only load if there are items
		if (SpcampaignHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('campaign.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('campaigns.publish');
				JToolBarHelper::unpublishList('campaigns.unpublish');
				JToolBarHelper::archiveList('campaigns.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('campaigns.checkin');
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
				JToolbarHelper::deleteList('', 'campaigns.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('campaigns.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('campaign.export'))
			{
				JToolBarHelper::custom('campaigns.exportData', 'download', '', 'COM_SPCAMPAIGN_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('campaign.import'))
		{
			JToolBarHelper::custom('campaigns.importData', 'upload', '', 'COM_SPCAMPAIGN_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = SpcampaignHelper::getHelpUrl('campaigns');
		if (SpcampaignHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_SPCAMPAIGN_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_spcampaign');
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
					JText::_('COM_SPCAMPAIGN_KEEP_ORIGINAL_STATE'),
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
				JText::_('COM_SPCAMPAIGN_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Smsemail Selection
		$this->smsemailOptions = $this->getTheSmsemailSelections();
		// We do some sanitation for Smsemail filter
		if (SpcampaignHelper::checkArray($this->smsemailOptions) &&
			isset($this->smsemailOptions[0]->value) &&
			!SpcampaignHelper::checkString($this->smsemailOptions[0]->value))
		{
			unset($this->smsemailOptions[0]);
		}
		// Only load Smsemail filter if it has values
		if (SpcampaignHelper::checkArray($this->smsemailOptions))
		{
			// Smsemail Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCAMPAIGN_CAMPAIGN_SMSEMAIL_LABEL').' -',
				'filter_smsemail',
				JHtml::_('select.options', $this->smsemailOptions, 'value', 'text', $this->state->get('filter.smsemail'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Smsemail Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCAMPAIGN_CAMPAIGN_SMSEMAIL_LABEL').' -',
					'batch[smsemail]',
					JHtml::_('select.options', $this->smsemailOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_SPCAMPAIGN_CAMPAIGNS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_spcampaign/assets/css/campaigns.css", (SpcampaignHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			return SpcampaignHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return SpcampaignHelper::htmlEscape($var, $this->_charset);
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
			'a.name' => JText::_('COM_SPCAMPAIGN_CAMPAIGN_NAME_LABEL'),
			'a.validdate' => JText::_('COM_SPCAMPAIGN_CAMPAIGN_VALIDDATE_LABEL'),
			'a.smsemail' => JText::_('COM_SPCAMPAIGN_CAMPAIGN_SMSEMAIL_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheSmsemailSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('smsemail'));
		$query->from($db->quoteName('#__spcampaign_campaign'));
		$query->order($db->quoteName('smsemail') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $smsemail)
			{
				// Translate the smsemail selection
				$text = $model->selectionTranslation($smsemail,'smsemail');
				// Now add the smsemail and its text to the options array
				$_filter[] = JHtml::_('select.option', $smsemail, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}
}
