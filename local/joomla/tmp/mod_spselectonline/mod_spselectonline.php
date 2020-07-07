<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectonline
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . '/helper.php';

$brands = ModSPSelectOnlineHelper::getBrands();
$zipcodes = ModSPSelectOnlineHelper::getZipCodes();
$usertimezone = ModSPSelectOnlineHelper::getTimeZone();

require JModuleHelper::getLayoutPath('mod_spselectonline', $params->get('layout', 'default'));
