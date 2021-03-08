<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.1
	@build			1st October, 2020
	@created		1st October, 2020
	@package		SP HotSpot
	@subpackage		listhotspot.php
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
 * Sphotspot Model for Listhotspot
 */
class SphotspotModelListhotspot extends JModelList
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

        // Get from #__sphotspot_hotspot as a
        $query->select($db->quoteName(
            array('a.id','a.spot','a.name','a.alias','a.tags','a.published','a.created_by','a.created','a.version','a.hits','a.ordering','a.checked_out','a.checked_out_time'),
            array('id','spot','name','alias','tags','published','created_by','created','version','hits','ordering','checked_out','checked_out_time')));
        $query->from($db->quoteName('#__sphotspot_hotspot', 'a'));

        // Get from #__spspot_spot as b
        $query->select($db->quoteName(
            array('b.name'),
            array('spot_name')));
        $query->join('LEFT', ($db->quoteName('#__spspot_spot', 'b')) . ' ON (' . $db->quoteName('a.spot') . ' = ' . $db->quoteName('b.spot_id') . ')');
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
        if (!$user->authorise('site.listhotspot.access', 'com_sphotspot'))
        {
            $app = JFactory::getApplication();
            $app->enqueueMessage(JText::_('COM_SPHOTSPOT_NOT_AUTHORISED_TO_VIEW_LISTHOTSPOT'), 'error');
            // redirect away to the home page if no access allowed.
            $app->redirect(JURI::root());
            return false;
        }
        // load parent items
        $items = parent::getItems();

        // Get the global params
        $globalParams = JComponentHelper::getParams('com_sphotspot', true);

        // Insure all item fields are adapted where needed.
        if (SphotspotHelper::checkArray($items))
        {
            // Load the JEvent Dispatcher
            JPluginHelper::importPlugin('content');
            $this->_dispatcher = JEventDispatcher::getInstance();
            foreach ($items as $nr => &$item)
            {
                // Always create a slug for sef URL's
                $item->slug = (isset($item->alias) && isset($item->id)) ? $item->id.':'.$item->alias : $item->id;
                // Check if item has params, or pass whole item.
                $params = (isset($item->params) && SphotspotHelper::checkJson($item->params)) ? json_decode($item->params) : $item;
                // Make sure the content prepare plugins fire on tags
                $_tags = new stdClass();
                $_tags->text =& $item->tags; // value must be in text
                // Since all values are now in text (Joomla Limitation), we also add the field name (tags) to context
                $this->_dispatcher->trigger("onContentPrepare", array('com_sphotspot.listhotspot.tags', &$_tags, &$params, 0));
            }
        }

        // return items
        return $items;
    }

    public function saveHotspot($values = null, $option = null)
    {
        $this->user = JFactory::getUser();
        $this->userId = $this->user->get('id');

        $objTable = new stdClass();
        $objTable->spot = $values['spot'];
        $objTable->name = $values['name'];
        $objTable->tags = $values['tags'];
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
            $result = $db->insertObject('#__sphotspot_hotspot', $objTable, 'id');
        } else {
            if ($option == 'U') {
                $objTable->id = $values['id'];
                $objTable->modified_by = $this->userId;
                $objTable->modified = date("Y-m-d H:i:s");
                $result = $db->updateObject('#__sphotspot_hotspot', $objTable, 'id');
            } else {
                $query = $db->getQuery(true);

                // delete all custom keys for user 1001.
                $conditions = array(
                    $db->quoteName('id') . ' = '.$values['id']
                );

                $query->delete($db->quoteName('#__sphotspot_hotspot'));
                $query->where($conditions);
                $db->setQuery($query);

                $result = $db->execute();
            }
        }
        return $result;
    }
}
