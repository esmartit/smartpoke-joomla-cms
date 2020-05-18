<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spspotsmap
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addStyleSheet('templates/smartpokex/vendors/jqvmap/dist/jqvmap.css', array('version'=>'auto', 'relative'=>true));
$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('templates/smartpokex/vendors/jqvmap/dist/jquery.vmap.js');
$document->addScript('/media/mod_spspotsmap/js/jquery.vmap.spain.js');
$document->addScript('/media/mod_spspotsmap/js/jvmapspotsmap.js');

?>

<div class="col-md-8 col-sm-8 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPSPOTSMAP');?> <small></small></h2>
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
                <div class="col-md-4 hidden-small">
                    <table class="countries_list">
                        <tbody>
                        <tr>
                            <td>Madrid</td>
                            <td class="fs15 fw700 text-right">33%</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div id="vmap_spain" class="col-md-8 col-sm-12 " style="height:230px;"></div>
            </div>
        </div>
    </div>
</div>

