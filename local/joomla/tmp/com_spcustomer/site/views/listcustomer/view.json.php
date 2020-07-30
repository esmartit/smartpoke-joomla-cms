<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		24th April, 2020
	@package		SP Customer
	@subpackage		view.html.php
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

/**
 * Spcustomer View class for the Listcustomer
 */
class SpcustomerViewListcustomer extends JViewLegacy
{
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $id = $input->get('id');
        $opt = $input->get('opt');
        $spot = $input->getString('spot');
        $userName = $input->getString('userName');
        $firstName = $input->getString('firstName');
        $lastName = $input->getString('lastName');
        $mobilePhone = $input->getString('mobilePhone');
        $email = $input->getString('email');
        $birthDate = $input->getString('birthDate');
        $bdate = date('Y-m-d', strtotime($birthDate));
        $sex = $input->getString('sex');
        $zipCode = $input->getString('zipCode');
        $memberShip = $input->getString('memberShip');
        $communication = $input->getString('communication');

        $publish = 1;
        if ($opt == 'D') {
            $publish = 0;
        }

        $model = $this->getModel();

        $values = array($id, $spot, $userName, $firstName, $lastName, $mobilePhone, $email, $bdate, $sex, $zipCode, $memberShip, $communication, $publish);
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
        $status = $model->saveCustomer($values, $opt);
        if ($status) {
            $arr_result[] = array("section" => $opt, "data" => "Customer: ".$userName." ".$message);
        } else {
            $arr_result[] = array("section" => "error", "data" => "Some error on table customer");
        }
        echo new JResponseJson($arr_result);
    }
}
