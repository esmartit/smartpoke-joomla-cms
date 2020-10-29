<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spactivitybigdata
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
$document->addScript('/media/mod_spactivitybigdata/js/echartactivitybigdata.js');

?>
<div class="col-md-12 col-sm-12">
    <div class="col-md-12 col-sm-12">
        <div class="dashboard_graph">
            <div class="x_title">
                <h2><?php echo JText::_('MOD_SPACTIVITYBIGDATA'); ?> <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
                <div id="echart_activity_bigdata_r" class="demo-placeholder" style="height:350px;"></div>
            </div>
        </div>
        <div class="dashboard_graph" id="graphCompare">
            <div class="x_title">
                <h2><?php echo JText::_('MOD_SPACTIVITYBIGDATA_COMPARE'); ?> <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="echart_activity_bigdata_c" class="demo-placeholder" style="height:350px;"></div>
            </div>
        </div>
    </div>
</div>
