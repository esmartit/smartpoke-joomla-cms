<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Device
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
 * Spdevice View class for the Listdevice
 */
class SpdeviceViewListdevice extends JViewLegacy
{
    /**
     * This display function returns in json format
     */
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $id = $input->get('id');
        $opt = $input->get('opt');
        $device = $input->getString('device');
        $type = $input->get('type');

        $publish = 1;
        if ($opt == 'D') {
            $publish = 0;
        }

        $model = $this->getModel();

        $values = array($id, $device, $type, $publish);
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
        $status = $model->saveDevice($values, $opt);
        if ($status) {
            $arr_result[] = array("section" => $opt, "data" => "Device: ".$device." ".$message);
        } else {
            $arr_result[] = array("section" => "error", "data" => "Some error on table device");
        }
        echo new JResponseJson($arr_result);
    }
}
