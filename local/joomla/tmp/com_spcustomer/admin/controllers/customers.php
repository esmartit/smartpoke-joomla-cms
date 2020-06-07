<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		24th April, 2020
	@package		SP Customer
	@subpackage		customers.php
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

use Joomla\Utilities\ArrayHelper;

/**
 * Customers Controller
 */
class SpcustomerControllerCustomers extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SPCUSTOMER_CUSTOMERS';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Customer', $prefix = 'SpcustomerModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('customer.export', 'com_spcustomer') && $user->authorise('core.export', 'com_spcustomer'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Customers');
			// get the data to export
			$data = $model->getExportData($pks);
			if (SpcustomerHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				SpcustomerHelper::xls($data,'Customers_'.$date->format('jS_F_Y'),'Customers exported ('.$date->format('jS F, Y').')','customers');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPCUSTOMER_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_spcustomer&view=customers', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('customer.import', 'com_spcustomer') && $user->authorise('core.import', 'com_spcustomer'))
		{
			// Get the import model
			$model = $this->getModel('Customers');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (SpcustomerHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('customer_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'customers');
				$session->set('dataType_VDM_IMPORTINTO', 'customer');
				// Redirect to import view.
				$message = JText::_('COM_SPCUSTOMER_IMPORT_SELECT_FILE_FOR_CUSTOMERS');
				$this->setRedirect(JRoute::_('index.php?option=com_spcustomer&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPCUSTOMER_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_spcustomer&view=customers', false), $message, 'error');
		return;
	}
}
