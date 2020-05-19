<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spdailygoal
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript('templates/smartpokex/vendors/gauge.js/dist/gauge.min.js');
$document->addScript('/media/mod_spdailygoal/js/gaugedailygoal.js');
$document->addScript('/media/mod_spdailygoal/js/gaugedailygoalreg.js');

?>
<div class="col-md-4 col-sm-4 ">
    <div class="x_panel tile fixed_height_320">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPDAILYGOAL');?> <small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Settings 1</a>
                        <a class="dropdown-item" href="#">Settings 2</a>
                    </div>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <div class="dashboard-widget-content">
                <div class="sidebar-widget">
                    <h4>Registered</h4>
                    <canvas width="150" height="80" id="chart_gauge_dailygoal_reg" class="" style="width: 160px; height: 100px;"></canvas>
                    <div class="goal-wrapper">
                        <span id="gauge-text-reg" class="gauge-value pull-center">0</span>
                        <span class="gauge-value pull-left">0%</span>
                        <span id="goal-text-reg" class="goal-value pull-right">100%</span>
                    </div>
                </div>
                <div class="sidebar-widget">
                    <h4>Devices</h4>
                    <canvas width="150" height="80" id="chart_gauge_dailygoal" class="" style="width: 160px; height: 100px;"></canvas>
                    <div id="dailygoalMaxValue"><b><?php echo $dailygoaldevice; ?></b></div>
                    <div class="goal-wrapper">
                        <span id="gauge-text" class="gauge-value pull-center">0</span>
                        <span class="gauge-value pull-left">0%</span>
                        <span id="goal-text" class="goal-value pull-right">100%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>