<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spactivityhotspot
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$usertimezone = ModSPActivityHotSpotHelper::getTimeZone();
require JModuleHelper::getLayoutPath('mod_spactivityhotspot', $params->get('layout', 'default'));
