<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spdailygoal
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$dailygoaldevice = ModSPDailyGoalHelper::getValueDev($params);
$dailygoalregistered = ModSPDailyGoalHelper::getValueReg($params);
$usertimezone = ModSPDailyGoalHelper::getTimeZone($params);

require JModuleHelper::getLayoutPath('mod_spdailygoal', $params->get('layout', 'default'));
