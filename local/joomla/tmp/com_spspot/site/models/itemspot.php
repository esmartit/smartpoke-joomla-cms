<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			24th June, 2020
	@created		14th April, 2020
	@package		SP Spot
	@subpackage		itemspot.php
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
 * Spspot Itemspot Model
 */
class SpspotModelItemspot extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_spspot.itemspot';

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
		$this->setState('itemspot.id', $id);

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
		if (!$this->user->authorise('site.itemspot.access', 'com_spspot'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPSPOT_NOT_AUTHORISED_TO_VIEW_ITEMSPOT'), 'error');
			// redirect away to the default view if no access allowed.
			$app->redirect(JRoute::_('index.php?option=com_spspot&view=listspot'));
			return false;
		}
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->initSet = true;

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('itemspot.id');
		
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

				// Get from #__spspot_spot as a
				$query->select($db->quoteName(
			array('a.id','a.spot_id','a.alias','a.city','a.name','a.business','a.latitude','a.longitude','a.published','a.created_by','a.created','a.version','a.hits','a.ordering'),
			array('id','spot_id','alias','city','name','business','latitude','longitude','published','created_by','created','version','hits','ordering')));
				$query->from($db->quoteName('#__spspot_spot', 'a'));

				// Get from #__spbusiness_businesstype as b
				$query->select($db->quoteName(
			array('b.name'),
			array('businesstype')));
				$query->join('LEFT', ($db->quoteName('#__spbusiness_businesstype', 'b')) . ' ON (' . $db->quoteName('a.business') . ' = ' . $db->quoteName('b.id') . ')');
				$query->where('a.id = ' . (int) $pk);

				// Reset the query using our newly populated query object.
				$db->setQuery($query);
				// Load the results as a stdClass object.
				$data = $db->loadObject();

				if (empty($data))
				{
					$app = JFactory::getApplication();
					// If no data is found redirect to default page and show warning.
					$app->enqueueMessage(JText::_('COM_SPSPOT_NOT_FOUND_OR_ACCESS_DENIED'), 'warning');
					$app->redirect(JRoute::_('index.php?option=com_spspot&view=listspot'));
					return false;
				}

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
