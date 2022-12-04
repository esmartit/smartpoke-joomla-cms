<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spqualifiedvisits
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

$document->addScript('/media/mod_spqualifiedvisits/js/qualifiedvisits.js');

?>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2><div id="title"><?php echo JText::_('MOD_SPQUALIFIEDVISITS');?> </div><small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="row tile_count">
                <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-bar-chart"></i> TOTAL</span>
                    <div id="totalVisits" class="count">0</div>
                    <span class="count_bottom">
						<div id="rateTotal" class="grey">100%</div>
					</span>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-download"></i> IN</span>
                    <div id="inVisits" class="count green">0</div>
                    <span class="count_bottom">
						<div id="rateIn" class="green">0%</div>
					</span>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-minus"></i> LIMIT</span>
                    <div id="limitVisits" class="count blue">0</div>
                    <span class="count_bottom">
						<div id="rateLimit" class="blue">0%</div>
					</span>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-upload"></i> OUT</span>
                    <div id="outVisits" class="count red">0</div>
                    <span class="count_bottom">
						<div id="rateOut" class="red">0%</div>
					</span>
                </div>
            </div>
        </div>
    </div>
</div>