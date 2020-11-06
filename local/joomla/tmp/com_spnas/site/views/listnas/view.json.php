<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
	@created		7th April, 2020
	@package		SP Nas
	@subpackage		view.html.php
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
 * Spnas View class for the Listnas
 */
class SpnasViewListnas extends JViewLegacy
{
    // Overwriting JView display method
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $id = $input->get('id');
        $opt = $input->get('opt');
        $name = $input->getString('name');
        $shortName = $input->getString('shortName');
        $type = $input->getString('type');
        $secret = $input->getString('secret');
        $ports = $input->getString('ports');
        $server = $input->getString('server');
        $community = $input->getString('community');
        $description = $input->getString('description');

        $model = $this->getModel();

        $values = array("id" => $id,
            "name" => $name,
            "shortName" => $shortName,
            "type" => $type,
            "secret" => $secret,
            "ports" => $ports,
            "server" => $server,
            "community" => $community,
            "description" => $description);

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
        $status = $model->saveNas($values, $opt);
        if ($status) {
            $arr_result[] = array("section" => $opt, "data" => "Nas: ".$shortName." ".$message);
        } else {
            $arr_result[] = array("section" => "error", "data" => "Some error on table nas");
        }
        echo new JResponseJson($arr_result);
    }
}
