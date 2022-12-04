<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spvisitfrequency
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */


defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$usertimezone = ModSPVisitFrequencyHelper::getTimeZone();
require JModuleHelper::getLayoutPath('mod_spvisitfrequency', $params->get('layout', 'default'));

