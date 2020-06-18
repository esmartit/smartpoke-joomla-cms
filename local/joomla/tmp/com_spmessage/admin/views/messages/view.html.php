<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			17th June, 2020
	@created		16th June, 2020
	@package		SP Message
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
 * Spmessage View class for the Messages
 */
class SpmessageViewMessages extends JViewLegacy
{
	/**
	 * Messages view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			SpmessageHelper::addSubmenu('messages');
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
		$this->canDo = SpmessageHelper::getActions('message');
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
		JToolBarHelper::title(JText::_('COM_SPMESSAGE_MESSAGES'), 'envelope');
		JHtmlSidebar::setAction('index.php?option=com_spmessage&view=messages');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('message.add');
		}

		// Only load if there are items
		if (SpmessageHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('message.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('messages.publish');
				JToolBarHelper::unpublishList('messages.unpublish');
				JToolBarHelper::archiveList('messages.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('messages.checkin');
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
				JToolbarHelper::deleteList('', 'messages.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('messages.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('message.export'))
			{
				JToolBarHelper::custom('messages.exportData', 'download', '', 'COM_SPMESSAGE_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('message.import'))
		{
			JToolBarHelper::custom('messages.importData', 'upload', '', 'COM_SPMESSAGE_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = SpmessageHelper::getHelpUrl('messages');
		if (SpmessageHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_SPMESSAGE_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_spmessage');
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
					JText::_('COM_SPMESSAGE_KEEP_ORIGINAL_STATE'),
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
				JText::_('COM_SPMESSAGE_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Campaign Id Selection
		$this->campaign_idOptions = $this->getTheCampaign_idSelections();
		// We do some sanitation for Campaign Id filter
		if (SpmessageHelper::checkArray($this->campaign_idOptions) &&
			isset($this->campaign_idOptions[0]->value) &&
			!SpmessageHelper::checkString($this->campaign_idOptions[0]->value))
		{
			unset($this->campaign_idOptions[0]);
		}
		// Only load Campaign Id filter if it has values
		if (SpmessageHelper::checkArray($this->campaign_idOptions))
		{
			// Campaign Id Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPMESSAGE_MESSAGE_CAMPAIGN_ID_LABEL').' -',
				'filter_campaign_id',
				JHtml::_('select.options', $this->campaign_idOptions, 'value', 'text', $this->state->get('filter.campaign_id'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Campaign Id Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPMESSAGE_MESSAGE_CAMPAIGN_ID_LABEL').' -',
					'batch[campaign_id]',
					JHtml::_('select.options', $this->campaign_idOptions, 'value', 'text')
				);
			}
		}

		// Set Device Sms Selection
		$this->device_smsOptions = $this->getTheDevice_smsSelections();
		// We do some sanitation for Device Sms filter
		if (SpmessageHelper::checkArray($this->device_smsOptions) &&
			isset($this->device_smsOptions[0]->value) &&
			!SpmessageHelper::checkString($this->device_smsOptions[0]->value))
		{
			unset($this->device_smsOptions[0]);
		}
		// Only load Device Sms filter if it has values
		if (SpmessageHelper::checkArray($this->device_smsOptions))
		{
			// Device Sms Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPMESSAGE_MESSAGE_DEVICE_SMS_LABEL').' -',
				'filter_device_sms',
				JHtml::_('select.options', $this->device_smsOptions, 'value', 'text', $this->state->get('filter.device_sms'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Device Sms Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPMESSAGE_MESSAGE_DEVICE_SMS_LABEL').' -',
					'batch[device_sms]',
					JHtml::_('select.options', $this->device_smsOptions, 'value', 'text')
				);
			}
		}

		// Set Username Selection
		$this->usernameOptions = $this->getTheUsernameSelections();
		// We do some sanitation for Username filter
		if (SpmessageHelper::checkArray($this->usernameOptions) &&
			isset($this->usernameOptions[0]->value) &&
			!SpmessageHelper::checkString($this->usernameOptions[0]->value))
		{
			unset($this->usernameOptions[0]);
		}
		// Only load Username filter if it has values
		if (SpmessageHelper::checkArray($this->usernameOptions))
		{
			// Username Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPMESSAGE_MESSAGE_USERNAME_LABEL').' -',
				'filter_username',
				JHtml::_('select.options', $this->usernameOptions, 'value', 'text', $this->state->get('filter.username'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Username Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPMESSAGE_MESSAGE_USERNAME_LABEL').' -',
					'batch[username]',
					JHtml::_('select.options', $this->usernameOptions, 'value', 'text')
				);
			}
		}

		// Set Status Selection
		$this->statusOptions = $this->getTheStatusSelections();
		// We do some sanitation for Status filter
		if (SpmessageHelper::checkArray($this->statusOptions) &&
			isset($this->statusOptions[0]->value) &&
			!SpmessageHelper::checkString($this->statusOptions[0]->value))
		{
			unset($this->statusOptions[0]);
		}
		// Only load Status filter if it has values
		if (SpmessageHelper::checkArray($this->statusOptions))
		{
			// Status Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPMESSAGE_MESSAGE_STATUS_LABEL').' -',
				'filter_status',
				JHtml::_('select.options', $this->statusOptions, 'value', 'text', $this->state->get('filter.status'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Status Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPMESSAGE_MESSAGE_STATUS_LABEL').' -',
					'batch[status]',
					JHtml::_('select.options', $this->statusOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_SPMESSAGE_MESSAGES'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_spmessage/assets/css/messages.css", (SpmessageHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			return SpmessageHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return SpmessageHelper::htmlEscape($var, $this->_charset);
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
			'a.campaign_id' => JText::_('COM_SPMESSAGE_MESSAGE_CAMPAIGN_ID_LABEL'),
			'a.device_sms' => JText::_('COM_SPMESSAGE_MESSAGE_DEVICE_SMS_LABEL'),
			'a.username' => JText::_('COM_SPMESSAGE_MESSAGE_USERNAME_LABEL'),
			'a.senddate' => JText::_('COM_SPMESSAGE_MESSAGE_SENDDATE_LABEL'),
			'a.status' => JText::_('COM_SPMESSAGE_MESSAGE_STATUS_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheCampaign_idSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('campaign_id'));
		$query->from($db->quoteName('#__spmessage_message'));
		$query->order($db->quoteName('campaign_id') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $campaign_id)
			{
				// Now add the campaign_id and its text to the options array
				$_filter[] = JHtml::_('select.option', $campaign_id, $campaign_id);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheDevice_smsSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('device_sms'));
		$query->from($db->quoteName('#__spmessage_message'));
		$query->order($db->quoteName('device_sms') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $device_sms)
			{
				// Now add the device_sms and its text to the options array
				$_filter[] = JHtml::_('select.option', $device_sms, $device_sms);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheUsernameSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('username'));
		$query->from($db->quoteName('#__spmessage_message'));
		$query->order($db->quoteName('username') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $username)
			{
				// Now add the username and its text to the options array
				$_filter[] = JHtml::_('select.option', $username, $username);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheStatusSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('status'));
		$query->from($db->quoteName('#__spmessage_message'));
		$query->order($db->quoteName('status') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $status)
			{
				// Translate the status selection
				$text = $model->selectionTranslation($status,'status');
				// Now add the status and its text to the options array
				$_filter[] = JHtml::_('select.option', $status, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}
}
