<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.2
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Spot
	@subpackage		listspot.php
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
 * Spspot Model for Listspot
 */
class SpspotModelListspot extends JModelList
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

		// Get from #__spspot_spot as a
		$query->select($db->quoteName(
			array('a.id','a.spot_id','a.name','a.alias','a.business','a.latitude','a.longitude','a.country','a.state','a.city','a.zipcode','a.published','a.created_by','a.created','a.version','a.hits','a.ordering','a.checked_out','a.checked_out_time'),
			array('id','spot_id','name','alias','business','latitude','longitude','country','state','city','zipcode','published','created_by','created','version','hits','ordering','checked_out','checked_out_time')));
		$query->from($db->quoteName('#__spspot_spot', 'a'));

		// Get from #__spbusiness_businesstype as b
		$query->select($db->quoteName(
			array('b.name'),
			array('businesstype')));
		$query->join('LEFT', ($db->quoteName('#__spbusiness_businesstype', 'b')) . ' ON (' . $db->quoteName('a.business') . ' = ' . $db->quoteName('b.id') . ')');

		// Get from #__spcountry_country as c
		$query->select($db->quoteName(
			array('c.name'),
			array('countryName')));
		$query->join('LEFT', ($db->quoteName('#__spcountry_country', 'c')) . ' ON (' . $db->quoteName('a.country') . ' = ' . $db->quoteName('c.country_code_isotwo') . ')');

		// Get from #__spstate_state as d
		$query->select($db->quoteName(
			array('d.name'),
			array('stateName')));
		$query->join('LEFT', ($db->quoteName('#__spstate_state', 'd')) . ' ON (' . $db->quoteName('a.state') . ' = ' . $db->quoteName('d.state_code') . ')');

		// Get from #__spcity_city as e
		$query->select($db->quoteName(
			array('e.name'),
			array('cityName')));
		$query->join('LEFT', ($db->quoteName('#__spcity_city', 'e')) . ' ON (' . $db->quoteName('a.city') . ' = ' . $db->quoteName('e.city_code') . ')');

		// Get from #__spzipcode_zipcode as f
		$query->select($db->quoteName(
			array('f.location'),
			array('location')));
		$query->join('LEFT', ($db->quoteName('#__spzipcode_zipcode', 'f')) . ' ON (' . $db->quoteName('a.zipcode') . ' = ' . $db->quoteName('f.zipcode') . ')');
		// Get where a.published is 1
		$query->where('a.published = 1');
		// Get where a.country is d.country_id
		$query->where('a.country = d.country_id');
		// Get where a.state is e.state_id
		$query->where('a.state = e.state_id');
		// Get where a.city is f.city_id
		$query->where('a.city = f.city_id');
		$query->order('a.name ASC');

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
		if (!$user->authorise('site.listspot.access', 'com_spspot'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPSPOT_NOT_AUTHORISED_TO_VIEW_LISTSPOT'), 'error');
			// redirect away to the home page if no access allowed.
			$app->redirect(JURI::root());
			return false;
		}
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = JComponentHelper::getParams('com_spspot', true);

		// Insure all item fields are adapted where needed.
		if (SpspotHelper::checkArray($items))
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

    public function saveSpot($values = null, $option = null)
    {
        $this->user = JFactory::getUser();
        $this->userId = $this->user->get('id');

        $objTable = new stdClass();
        $objTable->spot_id = $values['spot'];
        $objTable->name = $values['name'];
        $objTable->business = $values['business'];
        $objTable->latitude = $values['latitude'];
        $objTable->longitude = $values['longitude'];
        $objTable->country = $values['country'];
        $objTable->state = $values['state'];
        $objTable->city = $values['city'];
        $objTable->zipcode = $values['zipcode'];
        $objTable->published = $values['publish'];
        $objTable->alias = strtolower($values['name']);

        $db = JFactory::getDBO();
        if ($option == 'C') {
            $objTable->id = null;
            $objTable->created_by = $this->userId;
            $objTable->created = date("Y-m-d H:i:s");
            $objTable->access = 1;
            $objTable->params = '';
            $objTable->metakey= '';
            $objTable->metadesc = '';
            $objTable->metadata = '{"robots":"","author":"","rights":""}';
            $result = $db->insertObject('#__spspot_spot', $objTable, 'id');
        } else {
            if ($option == 'U') {
                $objTable->id = $values['id'];
                $objTable->modified_by = $this->userId;
                $objTable->modified = date("Y-m-d H:i:s");
                $result = $db->updateObject('#__spspot_spot', $objTable, 'id');
            } else {

                $result = false;
                if ($this->getSensorsCount($values['id']) > 0) {

                    $query = $db->getQuery(true);

                    // delete all custom keys for user 1001.
                    $conditions = array(
                        $db->quoteName('id') . ' = '.$values['id']
                    );

                    $query->delete($db->quoteName('#__spspot_spot'));
                    $query->where($conditions);
                    $db->setQuery($query);

                    $result = $db->execute();
                }
            }
        }
        return $result;
    }

    public function getSensorsCount($id = null) {
        $spotId = $id;

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select('COUNT(*)');
        $query->from($db->quoteName('#__spsensor_sensor', 'a'));
        $query->where($db->quoteName('spot_id'). " = ". $db->quote($spotId));

        $db->setQuery($query);
        $value = $db->loadResult();
        return $value;

    }
}
