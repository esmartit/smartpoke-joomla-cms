<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
	@created		12th June, 2020
	@package		SP Limitation
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
 * Splimitation View class for the Listlimitation
 */
class SplimitationViewListlimitation extends JViewLegacy
{
    // Overwriting JView display method
    function display($tpl = null)
    {
        $input = JFactory::getApplication()->input;

        $opt = $input->get('opt');
        $name = $input->getString('name');
        $maxUpload = $input->getInt('maxUpload');
        $upload = $input->getString('upload');
        $maxDownload = $input->getInt('maxDownload');
        $download = $input->getString('download');
        $maxTraffic = $input->getInt('maxTraffic');
        $traffic = $input->getString('traffic');
        $urlRedirect = $input->getString('urlRedirect');
        $accessPeriod = $input->getInt('accessPeriod');
        $period = $input->getString('period');
        $dailySession = $input->getInt('dailySession');
        $session = $input->getString('session');

        $model = $this->getModel();

        $values['name'] = $name;
        if (!empty($maxUpload)) $values['maxUpload'] = array("value" => $maxUpload, "rate" => $upload);
        if (!empty($maxDownload)) $values['maxDownload'] = array("value" => $maxDownload, "rate" => $download);
        if (!empty($maxTraffic)) $values['maxTraffic'] = array("value" => $maxTraffic, "traffic" => $traffic);
        if (!empty($urlRedirect)) $values['urlRedirect'] = $urlRedirect;
        if (!empty($accessPeriod)) $values['accessPeriod'] = array("value" => $accessPeriod, "period" => $period);
        if (!empty($dailySession)) $values['dailySession'] = array("value" => $dailySession, "period" => $session);

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
        $status = $model->saveLimitation($values, $opt);
        if ($status) {
            $arr_result[] = array("section" => $opt, "data" => "Limitation: ".$name." ".$message);
        } else {
            $arr_result[] = array("section" => "error", "data" => "Some error on tables radgroupcheck, radgroupreply and/or radusergroup");
        }
        echo new JResponseJson($arr_result);
    }
}
