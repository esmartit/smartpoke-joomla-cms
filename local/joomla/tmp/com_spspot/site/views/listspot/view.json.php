<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.2
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Spot
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
 * Spspot View class for the Listspot
 */
class SpspotViewListspot extends JViewLegacy
{
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $id = $input->get('id');
        $opt = $input->get('opt');
        $spotId = $input->getString('spotId');
        $spotName = $input->getString('spotName');
        $businessId = $input->getString('businessId');
        $latitude = $input->getString('latitude');
        $longitude = $input->getString('longitude');
        $countryId = $input->getString('countryId');
        $stateId = $input->getString('stateId');
        $cityId = $input->getString('cityId');
        $selZipCode = $input->getString('zipCode');

        $publish = 1;
        if ($opt == 'D') {
            $publish = 0;
        }

        $model = $this->getModel();

        $values = array($id, $spotId, $spotName, $businessId, $latitude, $longitude, $countryId, $stateId, $cityId, $selZipCode, $publish);
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
        $status = $model->saveSpot($values, $opt);
        if ($status) {
            $arr_result[] = array("section" => $opt, "data" => "Spot: ".$spotName." ".$message);
        } else {
            $arr_result[] = array("section" => "error", "data" => "Some error on table spot");
        }
        echo new JResponseJson($arr_result);
    }
}
