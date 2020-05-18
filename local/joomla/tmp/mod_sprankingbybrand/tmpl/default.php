<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sprankingbybrand
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/echarts/dist/echarts.min.js');
$document->addScript('/media/mod_sprankingbybrand/js/echartrankingbybrand.js');

?>
<div class="col-md-4 col-sm-4 ">
    <div class="x_panel tile fixed_height_320 overflow_hidden">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPRANKINGBYBRAND');?> <small></small></h2>
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
            <div id="echart_rankingby_brand" style="height:350px;"></div>
        </div>
    </div>
</div>

