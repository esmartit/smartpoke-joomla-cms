<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Device
	@subpackage		listdevice.php
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
 * Spdevice Model for Listdevice
 */
class SpdeviceModelListdevice extends JModelList
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
		// Make sure all records load, since no pagination allowed.
		$this->setState('list.limit', 0);
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get from #__spdevice_device as a
		$query->select($db->quoteName(
			array('a.id','a.device','a.type','a.alias','a.published','a.created_by','a.created','a.version','a.hits','a.ordering','a.checked_out','a.checked_out_time'),
			array('id','device','type','alias','published','created_by','created','version','hits','ordering','checked_out','checked_out_time')));
		$query->from($db->quoteName('#__spdevice_device', 'a'));
		// Get where a.published is 1
		$query->where('a.published = 1');
		$query->order('a.device ASC');

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
		if (!$user->authorise('site.listdevice.access', 'com_spdevice'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPDEVICE_NOT_AUTHORISED_TO_VIEW_LISTDEVICE'), 'error');
			// redirect away to the home page if no access allowed.
			$app->redirect(JURI::root());
			return false;
		}
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = JComponentHelper::getParams('com_spdevice', true);

		// Insure all item fields are adapted where needed.
		if (SpdeviceHelper::checkArray($items))
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

    public function saveDevice($values = null, $option = null)
    {
        $this->user = JFactory::getUser();
        $this->userId = $this->user->get('id');

        $objTable = new stdClass();
        $objTable->device = $values['device'];
        $objTable->type = $values['type'];
        $objTable->published = $values['publish'];
        $objTable->alias = strtolower($values['device']);
        $db = JFactory::getDBO();
        if ($option == 'C') {
            $objTable->id = null;
            $objTable->created_by = $this->userId;
            $objTable->created = date("Y-m-d h:i:sa");
            $objTable->access = 1;
            $objTable->params = '';
            $objTable->metakey= '';
            $objTable->metadesc = '';
            $objTable->metadata = '{"robots":"","author":"","rights":""}';
            $result = $db->insertObject('#__spdevice_device', $objTable, 'id');
        } else {
            $objTable->id = $values['id'];
            $objTable->modified_by = $this->userId;
            $objTable->modified = date("Y-m-d h:i:sa");
            $result = $db->updateObject('#__spdevice_device', $objTable, 'id');
        }
        return $result;
    }
}
