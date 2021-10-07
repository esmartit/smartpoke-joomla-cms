<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tabstate');

// Set the component css/js
$document = JFactory::getDocument();
$document->addStyleSheet('components/com_spcaptiveportal/assets/css/site.css');
$document->addScript('components/com_spcaptiveportal/assets/js/site.js');

// Require helper files
//JLoader::register('SpnasHelper', __DIR__ . '/helpers/spnas.php');
//JLoader::register('SpnasHelperRoute', __DIR__ . '/helpers/route.php');

// Get an instance of the controller prefixed by Spnas
$controller = JControllerLegacy::getInstance('SpCaptivePortal');

// Perform the request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
