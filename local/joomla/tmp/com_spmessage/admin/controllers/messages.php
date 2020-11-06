<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			17th June, 2020
	@created		16th June, 2020
	@package		SP Message
	@subpackage		messages.php
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
 * Messages Controller
 */
class SpmessageControllerMessages extends JControllerAdmin
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_SPMESSAGE_MESSAGES';

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
	public function getModel($name = 'Message', $prefix = 'SpmessageModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('message.export', 'com_spmessage') && $user->authorise('core.export', 'com_spmessage'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Messages');
			// get the data to export
			$data = $model->getExportData($pks);
			if (SpmessageHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				SpmessageHelper::xls($data,'Messages_'.$date->format('jS_F_Y'),'Messages exported ('.$date->format('jS F, Y').')','messages');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPMESSAGE_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_spmessage&view=messages', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('message.import', 'com_spmessage') && $user->authorise('core.import', 'com_spmessage'))
		{
			// Get the import model
			$model = $this->getModel('Messages');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (SpmessageHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('message_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'messages');
				$session->set('dataType_VDM_IMPORTINTO', 'message');
				// Redirect to import view.
				$message = JText::_('COM_SPMESSAGE_IMPORT_SELECT_FILE_FOR_MESSAGES');
				$this->setRedirect(JRoute::_('index.php?option=com_spmessage&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_SPMESSAGE_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_spmessage&view=messages', false), $message, 'error');
		return;
	}
}
