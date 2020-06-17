<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.2
	@build			17th June, 2020
	@created		16th June, 2020
	@package		SP Message
	@subpackage		spmessage.php
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
JHtml::_('behavior.tabstate');

// Set the component css/js
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_spmessage/assets/css/site.css');
$document->addScript('components/com_spmessage/assets/js/site.js');

// Require helper files
JLoader::register('SpmessageHelper', __DIR__ . '/helpers/spmessage.php'); 
JLoader::register('SpmessageHelperRoute', __DIR__ . '/helpers/route.php'); 

// Get an instance of the controller prefixed by Spmessage
$controller = JControllerLegacy::getInstance('Spmessage');

// Perform the request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
