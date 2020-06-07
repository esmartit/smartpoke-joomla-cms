<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		14th April, 2020
	@package		SP Sensor
	@subpackage		listsensor.php
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
 * Spsensor Model for Listsensor
 */
class SpsensorModelListsensor extends JModelList
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

		// Get from #__spsensor_sensor as a
		$query->select($db->quoteName(
			array('a.id','a.spot','a.sensor_id','a.location','a.zone','a.alias','a.pwr_in','a.pwr_limit','a.pwr_out','a.published','a.created_by','a.created','a.version','a.hits','a.ordering','a.checked_out','a.checked_out_time'),
			array('id','spot','sensor_id','location','zone','alias','pwr_in','pwr_limit','pwr_out','published','created_by','created','version','hits','ordering','checked_out','checked_out_time')));
		$query->from($db->quoteName('#__spsensor_sensor', 'a'));

		// Get from #__spspot_spot as b
		$query->select($db->quoteName(
			array('b.name'),
			array('spot_name')));
		$query->join('LEFT', ($db->quoteName('#__spspot_spot', 'b')) . ' ON (' . $db->quoteName('a.spot') . ' = ' . $db->quoteName('b.spot_id') . ')');

		// Get from #__spzone_zone as c
		$query->select($db->quoteName(
			array('c.name'),
			array('zone_name')));
		$query->join('LEFT', ($db->quoteName('#__spzone_zone', 'c')) . ' ON (' . $db->quoteName('a.zone') . ' = ' . $db->quoteName('c.id') . ')');
		// Get where a.published is 1
		$query->where('a.published = 1');
		$query->order('a.sensor_id ASC');

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
		if (!$user->authorise('site.listsensor.access', 'com_spsensor'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPSENSOR_NOT_AUTHORISED_TO_VIEW_LISTSENSOR'), 'error');
			// redirect away to the home page if no access allowed.
			$app->redirect(JURI::root());
			return false;
		}
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = JComponentHelper::getParams('com_spsensor', true);

		// Insure all item fields are adapted where needed.
		if (SpsensorHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// Always create a slug for sef URL's
				$item->slug = (isset($item->alias) && isset($item->id)) ? $item->id.':'.$item->alias : $item->id;
			}
		}

		// return items
		return $items;
	}
}
