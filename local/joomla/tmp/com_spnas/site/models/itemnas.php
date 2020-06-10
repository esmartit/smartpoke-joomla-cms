<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			3rd June, 2020
	@created		7th April, 2020
	@package		SP Nas
	@subpackage		itemnas.php
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
 * Spnas Itemnas Model
 */
class SpnasModelItemnas extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_spnas.itemnas';

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
	protected $plugin;
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
		$this->setState('itemnas.id', $id);

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
		if (!$this->user->authorise('site.itemnas.access', 'com_spnas'))
		{
			$app = JFactory::getApplication();
			$app->enqueueMessage(JText::_('COM_SPNAS_NOT_AUTHORISED_TO_VIEW_ITEMNAS'), 'error');
			// redirect away to the default view if no access allowed.
			$app->redirect(JRoute::_('index.php?option=com_spnas&view=listnas'));
			return false;
		}
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->initSet = true;

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('itemnas.id');

		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
                $this->plugin = JPluginHelper::getPlugin('system', 'backend_plugin');
                $base_uri = json_decode($this->plugin->params, true);

                $ch = curl_init();

                $dir_req = $base_uri['ms_radius'].'/api/nas/'.$pk;

                curl_setopt($ch, CURLOPT_URL, $dir_req);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

                $headers = array();
                $headers[] = "Content-Type: application/json";
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

                $res = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close ($ch);
                $data = json_decode($res);

				if (empty($data))
				{
					$app = JFactory::getApplication();
					// If no data is found redirect to default page and show warning.
					$app->enqueueMessage(JText::_('COM_SPNAS_NOT_FOUND_OR_ACCESS_DENIED'), 'warning');
					$app->redirect(JRoute::_('index.php?option=com_spnas&view=listnas'));
					return false;
				}
			    // Load the JEvent Dispatcher
			    JPluginHelper::importPlugin('content');
			    $this->_dispatcher = JEventDispatcher::getInstance();
				// Check if item has params, or pass whole item.
				$params = (isset($data->params) && SpnasHelper::checkJson($data->params)) ? json_decode($data->params) : $data;
				// Make sure the content prepare plugins fire on description
				$_description = new stdClass();
				$_description->text =& $data->description; // value must be in text
				// Since all values are now in text (Joomla Limitation), we also add the field name (description) to context
				$this->_dispatcher->trigger("onContentPrepare", array('com_spnas.itemnas.description', &$_description, &$params, 0));

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
