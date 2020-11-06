<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sptraffichotspot
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/media/mod_sptraffichotspot/js/traffichotspot.js');

?>
<div class="col-md-6 col-sm-12">
    <div class="tile_count">
        <div class="col-md-4 col-sm-12  tile_stats_count">
            <span class="count_top"><i class="fa fa-arrows-v"></i> <?php echo JText::_('MOD_SPTRAFFICHOTSPOT'); ?></span>
            <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
            <div id="totalTraffic" class="count">0</div>
        </div>
        <div class="col-md-4 col-sm-12 tile_stats_count">
            <span class="count_top"><i class="fa fa-arrow-up"></i> <?php echo JText::_('MOD_SPTRAFFICUPHOTSPOT'); ?></span>
            <div id="upTraffic" class="count">0</div>
        </div>
        <div class="col-md-4 col-sm-12  tile_stats_count">
            <span class="count_top"><i class="fa fa-arrow-down"></i> <?php echo JText::_('MOD_SPTRAFFICDOWNHOTSPOT'); ?></span>
            <div id="downTraffic" class="count">0</div>
        </div>
    </div>
</div>
