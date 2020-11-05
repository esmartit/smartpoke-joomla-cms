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
<div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPACTIVITYBIGDATA_RANGE'); ?> <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="tile_count col-md-6 col-sm-6 col-xs-12">
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-mobile-phone"></i> <?php echo JText::_('MOD_VISITORSBIGDATA_RANGE'); ?></span>
                <div id="totalvisitorsbigdata_r" class="count">0</div>
            </div>
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-users"></i> <?php echo JText::_('MOD_SPREGISTEREDBIGDATA_RANGE'); ?></span>
                <div id="registeredbigdata_r" class="count green">0</div>
            </div>
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-clock-o"></i> <?php echo JText::_('MOD_SPAVGTIMEBIGDATA_RANGE'); ?></span>
                <div id="avgtimebigdata_r" class="count">0</div>
            </div>
        </div>

        <div class="x_panel col-md-6 col-sm-6 col-xs-12">
            <div class="x_title">
                <h2><?php echo JText::_('MOD_SPQUALIFIEDVISITS_RANGE');?> <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="row tile_count">
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-bar-chart"></i> TOTAL</span>
                    <div id="totalVisits_r" class="count">0</div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-download"></i> IN</span>
                    <div id="inVisits_r" class="count green">0</div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-minus"></i> LIMIT</span>
                    <div id="limitVisits_r" class="count blue">0</div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-upload"></i> OUT</span>
                    <div id="outVisits_r" class="count red">0</div>
                </div>
            </div>
        </div>
        <div class="dashboard_graph">
            <div class="x_title">
                <h2><?php echo JText::_('MOD_SPACTIVITYBIGDATA'); ?> <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="echart_activity_bigdata_r" class="demo-placeholder" style="height:350px;"></div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12" id="graphCompare" style="display:none">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPACTIVITYBIGDATA_COMPARE'); ?> <small></small></h2>
            <div class="clearfix"></div>
        </div>
        <div class="tile_count col-md-6 col-sm-6 col-xs-12">
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-mobile-phone"></i> <?php echo JText::_('MOD_VISITORSBIGDATA_COMPARE'); ?></span>
                <div id="totalvisitorsbigdata_c" class="count">0</div>
            </div>
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-users"></i> <?php echo JText::_('MOD_SPREGISTEREDBIGDATA_COMPARE'); ?></span>
                <div id="registeredbigdata_c" class="count green">0</div>
            </div>
            <div class="col-md-4 col-sm-4  tile_stats_count">
                <span class="count_top"> <i class="fa fa-clock-o"></i> <?php echo JText::_('MOD_SPAVGTIMEBIGDATA_COMPARE'); ?></span>
                <div id="avgtimebigdata_c" class="count">0</div>
            </div>
        </div>

        <div class="x_panel col-md-6 col-sm-6 col-xs-12">
            <div class="x_title">
                <h2><?php echo JText::_('MOD_SPQUALIFIEDVISITS_COMPARE');?> <small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="row tile_count">
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-bar-chart"></i> TOTAL</span>
                    <div id="totalVisits_c" class="count">0</div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-download"></i> IN</span>
                    <div id="inVisits_c" class="count green">0</div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-minus"></i> LIMIT</span>
                    <div id="limitVisits_c" class="count blue">0</div>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-upload"></i> OUT</span>
                    <div id="outVisits_c" class="count red">0</div>
                </div>
            </div>
        </div>
        <div class="dashboard_graph">
            <div class="x_title">
                <h2><?php echo JText::_('MOD_SPACTIVITYBIGDATA'); ?> <small></small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="echart_activity_bigdata_c" class="demo-placeholder" style="height:350px;"></div>
            </div>
        </div>
    </div>
</div>
