<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			29th July, 2020
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
 * Customers Model
 */
class SpcustomerModelCustomers extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
        {
			$config['filter_fields'] = array(
				'a.id','id',
				'a.published','published',
				'a.ordering','ordering',
				'a.created_by','created_by',
				'a.modified_by','modified_by',
				'a.spot','spot',
				'a.username','username',
				'a.firstname','firstname',
				'a.lastname','lastname',
				'a.mobile_phone','mobile_phone',
				'a.dateofbirth','dateofbirth',
				'a.sex','sex',
				'a.zipcode','zipcode',
				'a.membership','membership',
				'a.communication','communication'
			);
		}

		parent::__construct($config);
	}
	
	/**
	 * Method to auto-populate the model state.
	 *
	 * @return  void
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		$app = JFactory::getApplication();

		// Adjust the context to support modal layouts.
		if ($layout = $app->input->get('layout'))
		{
			$this->context .= '.' . $layout;
		}
		$spot = $this->getUserStateFromRequest($this->context . '.filter.spot', 'filter_spot');
		$this->setState('filter.spot', $spot);

		$username = $this->getUserStateFromRequest($this->context . '.filter.username', 'filter_username');
		$this->setState('filter.username', $username);

		$firstname = $this->getUserStateFromRequest($this->context . '.filter.firstname', 'filter_firstname');
		$this->setState('filter.firstname', $firstname);

		$lastname = $this->getUserStateFromRequest($this->context . '.filter.lastname', 'filter_lastname');
		$this->setState('filter.lastname', $lastname);

		$mobile_phone = $this->getUserStateFromRequest($this->context . '.filter.mobile_phone', 'filter_mobile_phone');
		$this->setState('filter.mobile_phone', $mobile_phone);

		$dateofbirth = $this->getUserStateFromRequest($this->context . '.filter.dateofbirth', 'filter_dateofbirth');
		$this->setState('filter.dateofbirth', $dateofbirth);

		$sex = $this->getUserStateFromRequest($this->context . '.filter.sex', 'filter_sex');
		$this->setState('filter.sex', $sex);

		$zipcode = $this->getUserStateFromRequest($this->context . '.filter.zipcode', 'filter_zipcode');
		$this->setState('filter.zipcode', $zipcode);

		$membership = $this->getUserStateFromRequest($this->context . '.filter.membership', 'filter_membership');
		$this->setState('filter.membership', $membership);

		$communication = $this->getUserStateFromRequest($this->context . '.filter.communication', 'filter_communication');
		$this->setState('filter.communication', $communication);
        
		$sorting = $this->getUserStateFromRequest($this->context . '.filter.sorting', 'filter_sorting', 0, 'int');
		$this->setState('filter.sorting', $sorting);
        
		$access = $this->getUserStateFromRequest($this->context . '.filter.access', 'filter_access', 0, 'int');
		$this->setState('filter.access', $access);
        
		$search = $this->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $this->getUserStateFromRequest($this->context . '.filter.published', 'filter_published', '');
		$this->setState('filter.published', $published);
        
		$created_by = $this->getUserStateFromRequest($this->context . '.filter.created_by', 'filter_created_by', '');
		$this->setState('filter.created_by', $created_by);

		$created = $this->getUserStateFromRequest($this->context . '.filter.created', 'filter_created');
		$this->setState('filter.created', $created);

		// List state information.
		parent::populateState($ordering, $direction);
	}
	
	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 */
	public function getItems()
	{
		// check in items
		$this->checkInNow();

		// load parent items
		$items = parent::getItems();

		// set selection value to a translatable value
		if (SpcustomerHelper::checkArray($items))
		{
			foreach ($items as $nr => &$item)
			{
				// convert sex
				$item->sex = $this->selectionTranslation($item->sex, 'sex');
				// convert membership
				$item->membership = $this->selectionTranslation($item->membership, 'membership');
				// convert communication
				$item->communication = $this->selectionTranslation($item->communication, 'communication');
			}
		}

        
		// return items
		return $items;
	}

	/**
	 * Method to convert selection values to translatable string.
	 *
	 * @return translatable string
	 */
	public function selectionTranslation($value,$name)
	{
		// Array of sex language strings
		if ($name === 'sex')
		{
			$sexArray = array(
				1 => 'COM_SPCUSTOMER_CUSTOMER_FEMALE',
				0 => 'COM_SPCUSTOMER_CUSTOMER_MALE'
			);
			// Now check if value is found in this array
			if (isset($sexArray[$value]) && SpcustomerHelper::checkString($sexArray[$value]))
			{
				return $sexArray[$value];
			}
		}
		// Array of membership language strings
		if ($name === 'membership')
		{
			$membershipArray = array(
				1 => 'COM_SPCUSTOMER_CUSTOMER_YES',
				0 => 'COM_SPCUSTOMER_CUSTOMER_NO'
			);
			// Now check if value is found in this array
			if (isset($membershipArray[$value]) && SpcustomerHelper::checkString($membershipArray[$value]))
			{
				return $membershipArray[$value];
			}
		}
		// Array of communication language strings
		if ($name === 'communication')
		{
			$communicationArray = array(
				1 => 'COM_SPCUSTOMER_CUSTOMER_YES',
				0 => 'COM_SPCUSTOMER_CUSTOMER_NO'
			);
			// Now check if value is found in this array
			if (isset($communicationArray[$value]) && SpcustomerHelper::checkString($communicationArray[$value]))
			{
				return $communicationArray[$value];
			}
		}
		return $value;
	}
	
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Get the user object.
		$user = JFactory::getUser();
		// Create a new query object.
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);

		// Select some fields
		$query->select('a.*');

		// From the spcustomer_item table
		$query->from($db->quoteName('#__spcustomer_customer', 'a'));

		// Filter by published state
		$published = $this->getState('filter.published');
		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.published = 0 OR a.published = 1)');
		}

		// Join over the asset groups.
		$query->select('ag.title AS access_level');
		$query->join('LEFT', '#__viewlevels AS ag ON ag.id = a.access');
		// Filter by access level.
		if ($access = $this->getState('filter.access'))
		{
			$query->where('a.access = ' . (int) $access);
		}
		// Implement View Level Access
		if (!$user->authorise('core.options', 'com_spcustomer'))
		{
			$groups = implode(',', $user->getAuthorisedViewLevels());
			$query->where('a.access IN (' . $groups . ')');
		}
		// Filter by search.
		$search = $this->getState('filter.search');
		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->quote('%' . $db->escape($search) . '%');
				$query->where('(a.username LIKE '.$search.' OR a.firstname LIKE '.$search.' OR a.lastname LIKE '.$search.' OR a.mobile_phone LIKE '.$search.' OR a.email LIKE '.$search.' OR a.zipcode LIKE '.$search.')');
			}
		}

		// Filter by Sex.
		if ($sex = $this->getState('filter.sex'))
		{
			$query->where('a.sex = ' . $db->quote($db->escape($sex)));
		}
		// Filter by Zipcode.
		if ($zipcode = $this->getState('filter.zipcode'))
		{
			$query->where('a.zipcode = ' . $db->quote($db->escape($zipcode)));
		}
		// Filter by Membership.
		if ($membership = $this->getState('filter.membership'))
		{
			$query->where('a.membership = ' . $db->quote($db->escape($membership)));
		}
		// Filter by Communication.
		if ($communication = $this->getState('filter.communication'))
		{
			$query->where('a.communication = ' . $db->quote($db->escape($communication)));
		}

		// Add the list ordering clause.
		$orderCol = $this->state->get('list.ordering', 'a.id');
		$orderDirn = $this->state->get('list.direction', 'asc');
		if ($orderCol != '')
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Method to get list export data.
	 *
	 * @param   array  $pks  The ids of the items to get
	 * @param   JUser  $user  The user making the request
	 *
	 * @return mixed  An array of data items on success, false on failure.
	 */
	public function getExportData($pks, $user = null)
	{
		// setup the query
		if (SpcustomerHelper::checkArray($pks))
		{
			// Set a value to know this is export method. (USE IN CUSTOM CODE TO ALTER OUTCOME)
			$_export = true;
			// Get the user object if not set.
			if (!isset($user) || !SpcustomerHelper::checkObject($user))
			{
				$user = JFactory::getUser();
			}
			// Create a new query object.
			$db = JFactory::getDBO();
			$query = $db->getQuery(true);

			// Select some fields
			$query->select('a.*');

			// From the spcustomer_customer table
			$query->from($db->quoteName('#__spcustomer_customer', 'a'));
			$query->where('a.id IN (' . implode(',',$pks) . ')');
			// Implement View Level Access
			if (!$user->authorise('core.options', 'com_spcustomer'))
			{
				$groups = implode(',', $user->getAuthorisedViewLevels());
				$query->where('a.access IN (' . $groups . ')');
			}

			// Order the results by ordering
			$query->order('a.ordering  ASC');

			// Load the items
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				$items = $db->loadObjectList();

				// Set values to display correctly.
				if (SpcustomerHelper::checkArray($items))
				{
					foreach ($items as $nr => &$item)
					{
						// unset the values we don't want exported.
						unset($item->asset_id);
						unset($item->checked_out);
						unset($item->checked_out_time);
					}
				}
				// Add headers to items array.
				$headers = $this->getExImPortHeaders();
				if (SpcustomerHelper::checkObject($headers))
				{
					array_unshift($items,$headers);
				}
				return $items;
			}
		}
		return false;
	}

	/**
	* Method to get header.
	*
	* @return mixed  An array of data items on success, false on failure.
	*/
	public function getExImPortHeaders()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// get the columns
		$columns = $db->getTableColumns("#__spcustomer_customer");
		if (SpcustomerHelper::checkArray($columns))
		{
			// remove the headers you don't import/export.
			unset($columns['asset_id']);
			unset($columns['checked_out']);
			unset($columns['checked_out_time']);
			$headers = new stdClass();
			foreach ($columns as $column => $type)
			{
				$headers->{$column} = $column;
			}
			return $headers;
		}
		return false;
	}
	
	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * @return  string  A store id.
	 *
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.id');
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.published');
		$id .= ':' . $this->getState('filter.ordering');
		$id .= ':' . $this->getState('filter.created_by');
		$id .= ':' . $this->getState('filter.modified_by');
		$id .= ':' . $this->getState('filter.spot');
		$id .= ':' . $this->getState('filter.username');
		$id .= ':' . $this->getState('filter.firstname');
		$id .= ':' . $this->getState('filter.lastname');
		$id .= ':' . $this->getState('filter.mobile_phone');
		$id .= ':' . $this->getState('filter.dateofbirth');
		$id .= ':' . $this->getState('filter.sex');
		$id .= ':' . $this->getState('filter.zipcode');
		$id .= ':' . $this->getState('filter.membership');
		$id .= ':' . $this->getState('filter.communication');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to checkin all items left checked out longer then a set time.
	 *
	 * @return  a bool
	 *
	 */
	protected function checkInNow()
	{
		// Get set check in time
		$time = JComponentHelper::getParams('com_spcustomer')->get('check_in');

		if ($time)
		{

			// Get a db connection.
			$db = JFactory::getDbo();
			// reset query
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__spcustomer_customer'));
			$db->setQuery($query);
			$db->execute();
			if ($db->getNumRows())
			{
				// Get Yesterdays date
				$date = JFactory::getDate()->modify($time)->toSql();
				// reset query
				$query = $db->getQuery(true);

				// Fields to update.
				$fields = array(
					$db->quoteName('checked_out_time') . '=\'0000-00-00 00:00:00\'',
					$db->quoteName('checked_out') . '=0'
				);

				// Conditions for which records should be updated.
				$conditions = array(
					$db->quoteName('checked_out') . '!=0', 
					$db->quoteName('checked_out_time') . '<\''.$date.'\''
				);

				// Check table
				$query->update($db->quoteName('#__spcustomer_customer'))->set($fields)->where($conditions); 

				$db->setQuery($query);

				$db->execute();
			}
		}

		return false;
	}
}
