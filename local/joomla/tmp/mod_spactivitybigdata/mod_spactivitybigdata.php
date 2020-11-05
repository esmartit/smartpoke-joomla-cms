<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spactivitybigdata
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$usertimezone = ModSPActivityBigDataHelper::getTimeZone();
$graphBy = ModSPActivityBigDataHelper::showGraphBigDataAjax();
require JModuleHelper::getLayoutPath('mod_spactivitybigdata', $params->get('layout', 'default'));
