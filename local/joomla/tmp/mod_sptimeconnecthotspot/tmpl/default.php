<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sptimeconnecthotspot
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');

// NProgress
$document->addScript('/templates/smartpokex/vendors/nprogress/nprogress.js');

$document->addScript('/templates/smartpokex/vendors/echarts/dist/echarts.min.js');
$document->addScript('/media/mod_sptimeconnecthotspot/js/echarttimeconnecthotspot.js');

?>
<div class="col-md-12 col-sm-12">
    <div class="dashboard_graph">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPTIMECONNECTHOTSPOT');?> <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
            <div id="echart_timeconnect_hotspot" class="demo-placeholder" style="height:350px;"></div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="dashboard_graph">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPTIMECONNECTTRAFFICHOTSPOT');?> <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div id="echart_traffic_hotspot" class="demo-placeholder" style="height:350px;"></div>
        </div>
    </div>
</div>