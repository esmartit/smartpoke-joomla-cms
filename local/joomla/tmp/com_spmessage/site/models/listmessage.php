<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			17th June, 2020
	@created		16th June, 2020
	@package		SP Message
	@subpackage		listmessage.php
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
 * Spmessage Model for Listmessage
 */
class SpmessageModelListmessage extends JModelList
{
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
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Get the current user for authorisation checks
		$this->user = JFactory::getUser();
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->app = JFactory::getApplication();
		$this->input = $this->app->input;
		$this->initSet = true; 
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get from #__spmessage_message as a
		$query->select($db->quoteName(
			array('a.id','a.asset_id','a.campaign_id','a.device_sms','a.username','a.senddate','a.status','a.description','a.published','a.created_by','a.created','a.version','a.hits','a.ordering'),
			array('id','asset_id','campaign_id','device_sms','username','senddate','status','description','published','created_by','created','version','hits','ordering')));
		$query->from($db->quoteName('#__spmessage_message', 'a'));

		// Get from #__spcampaign_campaign as b
		$query->select($db->quoteName(
			array('b.name'),
			array('campaign')));
		$query->join('LEFT', ($db->quoteName('#__spcampaign_campaign', 'b')) . ' ON (' . $db->quoteName('a.campaign_id') . ' = ' . $db->quoteName('b.id') . ')');
		// Get where a.published is 1
		$query->where('a.published = 1');
		$query->order('a.senddate ASC');

		// return the query object
		return $query;
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$user = JFactory::getUser();
		// check if this user has permission to access item
		if (!$user->authorise('site.listmessage.access', 'com_spmessage'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPMESSAGE_NOT_AUTHORISED_TO_VIEW_LISTMESSAGE'), 'error');
			// redirect away to the home page if no access allowed.
			$app->redirect(JURI::root());
			return false;
		}
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = JComponentHelper::getParams('com_spmessage', true);

		// Insure all item fields are adapted where needed.
		if (SpmessageHelper::checkArray($items))
		{
			// Load the JEvent Dispatcher
			JPluginHelper::importPlugin('content');
			$this->_dispatcher = JEventDispatcher::getInstance();
			foreach ($items as $nr => &$item)
			{
				// Always create a slug for sef URL's
				$item->slug = (isset($item->alias) && isset($item->id)) ? $item->id.':'.$item->alias : $item->id;
				// Check if item has params, or pass whole item.
				$params = (isset($item->params) && SpmessageHelper::checkJson($item->params)) ? json_decode($item->params) : $item;
				// Make sure the content prepare plugins fire on description
				$_description = new stdClass();
				$_description->text =& $item->description; // value must be in text
				// Since all values are now in text (Joomla Limitation), we also add the field name (description) to context
				$this->_dispatcher->trigger("onContentPrepare", array('com_spmessage.listmessage.description', &$_description, &$params, 0));
			}
		}

		// return items
		return $items;
	}
}
