<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		6th April, 2020
	@package		SP Campaign
	@subpackage		itemcampaign.php
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
 * Spcampaign Itemcampaign Model
 */
class SpcampaignModelItemcampaign extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_spcampaign.itemcampaign';

	/**
	 * Model user data.
	 *
	 * @var        strings
	 */
	protected $user;
	protected $userId;
	protected $guest;
	protected $groups;
	protected $levels;
	protected $app;
	protected $input;
	protected $uikitComp;

	/**
	 * @var object item
	 */
	protected $item;

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$this->app = JFactory::getApplication();
		$this->input = $this->app->input;
		// Get the itme main id
		$id = $this->input->getInt('id', null);
		$this->setState('itemcampaign.id', $id);

		// Load the parameters.
		$params = $this->app->getParams();
		$this->setState('params', $params);
		parent::populateState();
	}

	/**
	 * Method to get article data.
	 *
	 * @param   integer  $pk  The id of the article.
	 *
	 * @return  mixed  Menu item data object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		$this->user = JFactory::getUser();
		// check if this user has permission to access item
		if (!$this->user->authorise('site.itemcampaign.access', 'com_spcampaign'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPCAMPAIGN_NOT_AUTHORISED_TO_VIEW_ITEMCAMPAIGN'), 'error');
			// redirect away to the default view if no access allowed.
			$app->redirect(JRoute::_('index.php?option=com_spcampaign&view=listcampaign'));
			return false;
		}
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->initSet = true;

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('itemcampaign.id');
		
		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
				// Get a db connection.
				$db = JFactory::getDbo();

				// Create a new query object.
				$query = $db->getQuery(true);

				// Get from #__spcampaign_campaign as a
				$query->select($db->quoteName(
			array('a.id','a.smsemail','a.message_sms','a.deferred','a.deferreddate','a.message_email','a.name','a.alias','a.validdate','a.published','a.created_by','a.created','a.version','a.hits','a.ordering'),
			array('id','smsemail','message_sms','deferred','deferreddate','message_email','name','alias','validdate','published','created_by','created','version','hits','ordering')));
				$query->from($db->quoteName('#__spcampaign_campaign', 'a'));
				$query->where('a.id = ' . (int) $pk);

				// Reset the query using our newly populated query object.
				$db->setQuery($query);
				// Load the results as a stdClass object.
				$data = $db->loadObject();

				if (empty($data))
				{
					$app = JFactory::getApplication();
					// If no data is found redirect to default page and show warning.
					$app->enqueueMessage(JText::_('COM_SPCAMPAIGN_NOT_FOUND_OR_ACCESS_DENIED'), 'warning');
					$app->redirect(JRoute::_('index.php?option=com_spcampaign&view=listcampaign'));
					return false;
				}
			// Load the JEvent Dispatcher
			JPluginHelper::importPlugin('content');
			$this->_dispatcher = JEventDispatcher::getInstance();
				// Check if item has params, or pass whole item.
				$params = (isset($data->params) && SpcampaignHelper::checkJson($data->params)) ? json_decode($data->params) : $data;
				// Make sure the content prepare plugins fire on message_email
				$_message_email = new stdClass();
				$_message_email->text =& $data->message_email; // value must be in text
				// Since all values are now in text (Joomla Limitation), we also add the field name (message_email) to context
				$this->_dispatcher->trigger("onContentPrepare", array('com_spcampaign.itemcampaign.message_email', &$_message_email, &$params, 0));
				// Make sure the content prepare plugins fire on message_sms
				$_message_sms = new stdClass();
				$_message_sms->text =& $data->message_sms; // value must be in text
				// Since all values are now in text (Joomla Limitation), we also add the field name (message_sms) to context
				$this->_dispatcher->trigger("onContentPrepare", array('com_spcampaign.itemcampaign.message_sms', &$_message_sms, &$params, 0));

				// set data object to item.
				$this->_item[$pk] = $data;
			}
			catch (Exception $e)
			{
				if ($e->getCode() == 404)
				{
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseWaring(404, $e->getMessage());
				}
				else
				{
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}

		return $this->_item[$pk];
	}
}
