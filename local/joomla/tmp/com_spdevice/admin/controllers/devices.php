<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Device
	@subpackage		devices.php
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

use Joomla\Utilities\ArrayHelper;

/**
 * Devices Controller
 */
class SpdeviceControllerDevices extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SPDEVICE_DEVICES';

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
	public function getModel($name = 'Device', $prefix = 'SpdeviceModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('device.export', 'com_spdevice') && $user->authorise('core.export', 'com_spdevice'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Devices');
			// get the data to export
			$data = $model->getExportData($pks);
			if (SpdeviceHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				SpdeviceHelper::xls($data,'Devices_'.$date->format('jS_F_Y'),'Devices exported ('.$date->format('jS F, Y').')','devices');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPDEVICE_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_spdevice&view=devices', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('device.import', 'com_spdevice') && $user->authorise('core.import', 'com_spdevice'))
		{
			// Get the import model
			$model = $this->getModel('Devices');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (SpdeviceHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('device_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'devices');
				$session->set('dataType_VDM_IMPORTINTO', 'device');
				// Redirect to import view.
				$message = JText::_('COM_SPDEVICE_IMPORT_SELECT_FILE_FOR_DEVICES');
				$this->setRedirect(JRoute::_('index.php?option=com_spdevice&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPDEVICE_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_spdevice&view=devices', false), $message, 'error');
		return;
	}
}
