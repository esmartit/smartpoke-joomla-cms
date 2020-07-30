<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			29th July, 2020
	@created		24th April, 2020
	@package		SP Customer
	@subpackage		view.html.php
	@author			Adolfo Zignago <https://esmartit.es>	
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
 * Spcustomer View class for the Customers
 */
class SpcustomerViewCustomers extends JViewLegacy
{
	/**
	 * Customers view display method
	 * @return void
	 */
	function display($tpl = null)
	{
		if ($this->getLayout() !== 'modal')
		{
			// Include helper submenu
			SpcustomerHelper::addSubmenu('customers');
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
		$this->canDo = SpcustomerHelper::getActions('customer');
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
		JToolBarHelper::title(JText::_('COM_SPCUSTOMER_CUSTOMERS'), 'puzzle');
		JHtmlSidebar::setAction('index.php?option=com_spcustomer&view=customers');
		JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');

		if ($this->canCreate)
		{
			JToolBarHelper::addNew('customer.add');
		}

		// Only load if there are items
		if (SpcustomerHelper::checkArray($this->items))
		{
			if ($this->canEdit)
			{
				JToolBarHelper::editList('customer.edit');
			}

			if ($this->canState)
			{
				JToolBarHelper::publishList('customers.publish');
				JToolBarHelper::unpublishList('customers.unpublish');
				JToolBarHelper::archiveList('customers.archive');

				if ($this->canDo->get('core.admin'))
				{
					JToolBarHelper::checkin('customers.checkin');
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
				JToolbarHelper::deleteList('', 'customers.delete', 'JTOOLBAR_EMPTY_TRASH');
			}
			elseif ($this->canState && $this->canDelete)
			{
				JToolbarHelper::trash('customers.trash');
			}

			if ($this->canDo->get('core.export') && $this->canDo->get('customer.export'))
			{
				JToolBarHelper::custom('customers.exportData', 'download', '', 'COM_SPCUSTOMER_EXPORT_DATA', true);
			}
		}

		if ($this->canDo->get('core.import') && $this->canDo->get('customer.import'))
		{
			JToolBarHelper::custom('customers.importData', 'upload', '', 'COM_SPCUSTOMER_IMPORT_DATA', false);
		}

		// set help url for this view if found
		$help_url = SpcustomerHelper::getHelpUrl('customers');
		if (SpcustomerHelper::checkString($help_url))
		{
				JToolbarHelper::help('COM_SPCUSTOMER_HELP_MANAGER', false, $help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_spcustomer');
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
					JText::_('COM_SPCUSTOMER_KEEP_ORIGINAL_STATE'),
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
				JText::_('COM_SPCUSTOMER_KEEP_ORIGINAL_ACCESS'),
				'batch[access]',
				JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text')
			);
		}

		// Set Sex Selection
		$this->sexOptions = $this->getTheSexSelections();
		// We do some sanitation for Sex filter
		if (SpcustomerHelper::checkArray($this->sexOptions) &&
			isset($this->sexOptions[0]->value) &&
			!SpcustomerHelper::checkString($this->sexOptions[0]->value))
		{
			unset($this->sexOptions[0]);
		}
		// Only load Sex filter if it has values
		if (SpcustomerHelper::checkArray($this->sexOptions))
		{
			// Sex Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCUSTOMER_CUSTOMER_SEX_LABEL').' -',
				'filter_sex',
				JHtml::_('select.options', $this->sexOptions, 'value', 'text', $this->state->get('filter.sex'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Sex Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCUSTOMER_CUSTOMER_SEX_LABEL').' -',
					'batch[sex]',
					JHtml::_('select.options', $this->sexOptions, 'value', 'text')
				);
			}
		}

		// Set Zipcode Selection
		$this->zipcodeOptions = $this->getTheZipcodeSelections();
		// We do some sanitation for Zipcode filter
		if (SpcustomerHelper::checkArray($this->zipcodeOptions) &&
			isset($this->zipcodeOptions[0]->value) &&
			!SpcustomerHelper::checkString($this->zipcodeOptions[0]->value))
		{
			unset($this->zipcodeOptions[0]);
		}
		// Only load Zipcode filter if it has values
		if (SpcustomerHelper::checkArray($this->zipcodeOptions))
		{
			// Zipcode Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCUSTOMER_CUSTOMER_ZIPCODE_LABEL').' -',
				'filter_zipcode',
				JHtml::_('select.options', $this->zipcodeOptions, 'value', 'text', $this->state->get('filter.zipcode'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Zipcode Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCUSTOMER_CUSTOMER_ZIPCODE_LABEL').' -',
					'batch[zipcode]',
					JHtml::_('select.options', $this->zipcodeOptions, 'value', 'text')
				);
			}
		}

		// Set Membership Selection
		$this->membershipOptions = $this->getTheMembershipSelections();
		// We do some sanitation for Membership filter
		if (SpcustomerHelper::checkArray($this->membershipOptions) &&
			isset($this->membershipOptions[0]->value) &&
			!SpcustomerHelper::checkString($this->membershipOptions[0]->value))
		{
			unset($this->membershipOptions[0]);
		}
		// Only load Membership filter if it has values
		if (SpcustomerHelper::checkArray($this->membershipOptions))
		{
			// Membership Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCUSTOMER_CUSTOMER_MEMBERSHIP_LABEL').' -',
				'filter_membership',
				JHtml::_('select.options', $this->membershipOptions, 'value', 'text', $this->state->get('filter.membership'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Membership Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCUSTOMER_CUSTOMER_MEMBERSHIP_LABEL').' -',
					'batch[membership]',
					JHtml::_('select.options', $this->membershipOptions, 'value', 'text')
				);
			}
		}

		// Set Communication Selection
		$this->communicationOptions = $this->getTheCommunicationSelections();
		// We do some sanitation for Communication filter
		if (SpcustomerHelper::checkArray($this->communicationOptions) &&
			isset($this->communicationOptions[0]->value) &&
			!SpcustomerHelper::checkString($this->communicationOptions[0]->value))
		{
			unset($this->communicationOptions[0]);
		}
		// Only load Communication filter if it has values
		if (SpcustomerHelper::checkArray($this->communicationOptions))
		{
			// Communication Filter
			JHtmlSidebar::addFilter(
				'- Select '.JText::_('COM_SPCUSTOMER_CUSTOMER_COMMUNICATION_LABEL').' -',
				'filter_communication',
				JHtml::_('select.options', $this->communicationOptions, 'value', 'text', $this->state->get('filter.communication'))
			);

			if ($this->canBatch && $this->canCreate && $this->canEdit)
			{
				// Communication Batch Selection
				JHtmlBatch_::addListSelection(
					'- Keep Original '.JText::_('COM_SPCUSTOMER_CUSTOMER_COMMUNICATION_LABEL').' -',
					'batch[communication]',
					JHtml::_('select.options', $this->communicationOptions, 'value', 'text')
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
		$this->document->setTitle(JText::_('COM_SPCUSTOMER_CUSTOMERS'));
		$this->document->addStyleSheet(JURI::root() . "administrator/components/com_spcustomer/assets/css/customers.css", (SpcustomerHelper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
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
			return SpcustomerHelper::htmlEscape($var, $this->_charset, true);
		}
		// use the helper htmlEscape method instead.
		return SpcustomerHelper::htmlEscape($var, $this->_charset);
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
			'a.spot' => JText::_('COM_SPCUSTOMER_CUSTOMER_SPOT_LABEL'),
			'a.username' => JText::_('COM_SPCUSTOMER_CUSTOMER_USERNAME_LABEL'),
			'a.firstname' => JText::_('COM_SPCUSTOMER_CUSTOMER_FIRSTNAME_LABEL'),
			'a.lastname' => JText::_('COM_SPCUSTOMER_CUSTOMER_LASTNAME_LABEL'),
			'a.mobile_phone' => JText::_('COM_SPCUSTOMER_CUSTOMER_MOBILE_PHONE_LABEL'),
			'a.dateofbirth' => JText::_('COM_SPCUSTOMER_CUSTOMER_DATEOFBIRTH_LABEL'),
			'a.sex' => JText::_('COM_SPCUSTOMER_CUSTOMER_SEX_LABEL'),
			'a.zipcode' => JText::_('COM_SPCUSTOMER_CUSTOMER_ZIPCODE_LABEL'),
			'a.membership' => JText::_('COM_SPCUSTOMER_CUSTOMER_MEMBERSHIP_LABEL'),
			'a.communication' => JText::_('COM_SPCUSTOMER_CUSTOMER_COMMUNICATION_LABEL'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}

	protected function getTheSexSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('sex'));
		$query->from($db->quoteName('#__spcustomer_customer'));
		$query->order($db->quoteName('sex') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $sex)
			{
				// Translate the sex selection
				$text = $model->selectionTranslation($sex,'sex');
				// Now add the sex and its text to the options array
				$_filter[] = JHtml::_('select.option', $sex, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheZipcodeSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('zipcode'));
		$query->from($db->quoteName('#__spcustomer_customer'));
		$query->order($db->quoteName('zipcode') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $zipcode)
			{
				// Now add the zipcode and its text to the options array
				$_filter[] = JHtml::_('select.option', $zipcode, $zipcode);
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheMembershipSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('membership'));
		$query->from($db->quoteName('#__spcustomer_customer'));
		$query->order($db->quoteName('membership') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $membership)
			{
				// Translate the membership selection
				$text = $model->selectionTranslation($membership,'membership');
				// Now add the membership and its text to the options array
				$_filter[] = JHtml::_('select.option', $membership, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}

	protected function getTheCommunicationSelections()
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select the text.
		$query->select($db->quoteName('communication'));
		$query->from($db->quoteName('#__spcustomer_customer'));
		$query->order($db->quoteName('communication') . ' ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		$results = $db->loadColumn();

		if ($results)
		{
			// get model
			$model = $this->getModel();
			$results = array_unique($results);
			$_filter = array();
			foreach ($results as $communication)
			{
				// Translate the communication selection
				$text = $model->selectionTranslation($communication,'communication');
				// Now add the communication and its text to the options array
				$_filter[] = JHtml::_('select.option', $communication, JText::_($text));
			}
			return $_filter;
		}
		return false;
	}
}
