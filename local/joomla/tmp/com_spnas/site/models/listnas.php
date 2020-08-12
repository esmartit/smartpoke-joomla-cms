<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
	@created		7th April, 2020
	@package		SP Nas
	@subpackage		listnas.php
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
 * Spnas Model for Listnas
 */
class SpnasModelListnas extends JModelList
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

        $this->plugin = JPluginHelper::getPlugin('system', 'backend_plugin');
        $base_uri = json_decode($this->plugin->params, true);

        $ch = curl_init();

        $dir_req = $base_uri['ms_radius'].'/api/nas';

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
        $result = json_decode($res);

        return $result->_embedded->nas;
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
        if (!$user->authorise('site.listnas.access', 'com_spnas'))
        {
            $app = JFactory::getApplication();
            $app->enqueueMessage(JText::_('COM_SPNAS_NOT_AUTHORISED_TO_VIEW_LISTNAS'), 'error');
            // redirect away to the home page if no access allowed.
            $app->redirect(JURI::root());
            return false;
        }
        $items = $this->getListQuery();

        // Get the global params
        $globalParams = JComponentHelper::getParams('com_spnas', true);

        // Insure all item fields are adapted where needed.
        if (SpnasHelper::checkArray($items))
        {
            // Load the JEvent Dispatcher
            JPluginHelper::importPlugin('content');
            $this->_dispatcher = JEventDispatcher::getInstance();
            foreach ($items as $nr => &$item)
            {
                // Always create a slug for sef URL's
//				$item->slug = (isset($item->alias) && isset($item->id)) ? $item->id.':'.$item->alias : $item->id;
                // Check if item has params, or pass whole item.
                $params = (isset($item->params) && SpnasHelper::checkJson($item->params)) ? json_decode($item->params) : $item;
                // Make sure the content prepare plugins fire on description
                $_description = new stdClass();
                $_description->text =& $item->description; // value must be in text
                // Since all values are now in text (Joomla Limitation), we also add the field name (description) to context
                $this->_dispatcher->trigger("onContentPrepare", array('com_spnas.listnas.description', &$_description, &$params, 0));
            }
        }

        // return items
        return $items;
    }

    public function saveNas($values = null, $option = null)
    {
        $input = JFactory::getApplication()->input;

        $this->plugin = JPluginHelper::getPlugin('system', 'backend_plugin');
        $base_uri = json_decode($this->plugin->params, true);

        $id = $input->get('id');
        $ch = curl_init();

        $dir_req = $base_uri['ms_radius'] . '/api/nas/';
        switch ($option) {
            case 'C':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POST, 1);
                break;
            case 'U':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
                $dir_req .= $id;
                break;
            case 'D':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                $dir_req .= $id;
                break;
        }

        $param = json_encode($values);

        curl_setopt($ch, CURLOPT_URL, $dir_req);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $res = curl_exec($ch);
        $result = json_decode($res);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        if ($option != 'D') {
            if ($result->id > 0) {
                return true;
            }
        } else {
            if ($res == "") {
                return true;
            }
        }
        return false;
    }
}
