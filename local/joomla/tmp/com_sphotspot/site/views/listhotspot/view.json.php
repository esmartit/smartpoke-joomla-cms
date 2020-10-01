<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.1
	@build			1st October, 2020
	@created		1st October, 2020
	@package		SP HotSpot
	@subpackage		view.json.php
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

/**
 * Sphotspot View class for the Listhotspot
 */
class SphotspotViewListhotspot extends JViewLegacy
{
    /**
     * This display function returns in json format
     */
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $id = $input->get('id');
        $opt = $input->get('opt');
        $spot = $input->getString('spot');
        $name = $input->getString('name');
        $tags = $input->getString('tags');

        $publish = 1;
        if ($opt == 'D') {
            $publish = 0;
        }

        $model = $this->getModel();

        $values = array("id" => $id,
            "spot" => $spot,
            "name" => $name,
            "tags" => $tags,
            "publish" => $publish
        );
        switch ($opt) {
            case 'C':
                $message = " saved.";
                break;
            case 'U':
                $message = " updated.";
                break;
            case 'D':
                $message = " deleted.";
                break;
        }

        $status = $model->saveHotspot($values, $opt);
        if ($status) {
            $arr_result[] = array("section" => $opt, "data" => "HotSpot: ".$name." ".$message);
        } else {
            $arr_result[] = array("section" => "error", "data" => "Some error on table hotspot");
        }
        echo new JResponseJson($arr_result);
    }
}
