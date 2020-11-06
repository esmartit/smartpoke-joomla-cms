<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.2
	@build			29th July, 2020
	@created		14th April, 2020
	@package		SP Spot
	@subpackage		listzipcode.php
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
 * Spspot Model for Listzipcode
 */
class SpspotModelListzipcode extends JModelList
{
    public function getZipCodeList($cityId = null) {

        $db = JFactory::getDbo();

        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('zipcode', 'location')));
        $query->from($db->quoteName('#__spzipcode_zipcode'));
        $query->where($db->quoteName('city_id') . ' = ' . $db->quote($cityId));

        $db->setQuery($query);
        $zipcodeList = $db->loadObjectList();

        return $zipcodeList;

    }
}
