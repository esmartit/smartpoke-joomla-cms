<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sptopcampaign
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('ModSPTopCampaignHelper', __DIR__ . '/helper.php');

$usertimezone = ModSPTopCampaignHelper::getTimeZone();

require JModuleHelper::getLayoutPath('mod_sptopcampaign', $params->get('layout', 'default'));
