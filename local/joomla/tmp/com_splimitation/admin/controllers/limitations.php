<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			15th June, 2020
	@created		12th June, 2020
	@package		SP Limitation
	@subpackage		limitations.php
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
 * Limitations Controller
 */
class SplimitationControllerLimitations extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SPLIMITATION_LIMITATIONS';

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
	public function getModel($name = 'Limitation', $prefix = 'SplimitationModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('limitation.export', 'com_splimitation') && $user->authorise('core.export', 'com_splimitation'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Limitations');
			// get the data to export
			$data = $model->getExportData($pks);
			if (SplimitationHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				SplimitationHelper::xls($data,'Limitations_'.$date->format('jS_F_Y'),'Limitations exported ('.$date->format('jS F, Y').')','limitations');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPLIMITATION_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_splimitation&view=limitations', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('limitation.import', 'com_splimitation') && $user->authorise('core.import', 'com_splimitation'))
		{
			// Get the import model
			$model = $this->getModel('Limitations');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (SplimitationHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('limitation_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'limitations');
				$session->set('dataType_VDM_IMPORTINTO', 'limitation');
				// Redirect to import view.
				$message = JText::_('COM_SPLIMITATION_IMPORT_SELECT_FILE_FOR_LIMITATIONS');
				$this->setRedirect(JRoute::_('index.php?option=com_splimitation&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPLIMITATION_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_splimitation&view=limitations', false), $message, 'error');
		return;
	}
}
