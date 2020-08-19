<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectcampaigneffectiveness
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

// bootstrap-daterangepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.css');
// bootstrap-datetimepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
// bootstrap-daterangepicker
$document->addScript('/templates/smartpokex/vendors/moment/min/moment.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.js');
// bootstrap-datetimepicker
$document->addScript('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');

$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/dataTables.buttons.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/buttons.flash.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/buttons.html5.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/buttons.print.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-scroller/js/dataTables.scroller.min.js');
$document->addScript('/templates/smartpokex/vendors/jszip/dist/jszip.min.js');
$document->addScript('/templates/smartpokex/vendors/pdfmake/build/pdfmake.min.js');
$document->addScript('/templates/smartpokex/vendors/pdfmake/build/vfs_fonts.js');

$document->addScript('/media/mod_spselectcampaigneffectiveness/js/spselectcampaigneffectiveness.js');

$currDate = date('Y-m-d H:i:s');
$datestart = date("Y-m-d", strtotime("-29 day", strtotime($currDate)));
$dateend = date("Y-m-d", strtotime($currDate));

?>
<div class="col-md-12 col-sm-12 ">
    <p>
        <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseSelect" role="button" aria-expanded="false" aria-controls="collapseSelect">
            <?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS');?>
        </a>
    </p>
    <div class="collapse" id="collapseSelect">
        <div class="x_panel">
<!--            <div class="x_title">-->
<!--                <h2>--><?php //echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS');?><!-- <small></small></h2>-->
<!--                <ul class="nav navbar-right panel_toolbox">-->
<!--                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>-->
<!--                    </li>-->
<!--                    <li class="dropdown">-->
<!--                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>-->
<!--                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">-->
<!--                            <a class="dropdown-item" href="#">Settings 1</a>-->
<!--                            <a class="dropdown-item" href="#">Settings 2</a>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li><a class="close-link"><i class="fa fa-close"></i></a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--                <div class="clearfix"></div>-->
<!--            </div>-->
            <div class="x_content">
                <form id="campaigndetail_select_form" class="form-horizontal form-label-left" method="POST">
                    <!-- select -->
                    <div id="selcampaigns" class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div id="selsmsemail" class="btn-group btn-group-toggle" data-toggle="buttons">
                                <label class="btn btn-secondary active">
                                    <input type="radio" value="1" id="radioSMS" name="radioCampaign"> <?php echo JText::_('SMS'); ?>
                                </label>
                                <label class="btn btn-secondary">
                                    <input type="radio" value="0" id="radioEmail" name="radioCampaign"> <?php echo JText::_('Email'); ?>
                                </label>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <select id="selCampaign" class="form-control" name="campaign" onblur="getSmsEmailTotal()">
                                    <option value="" selected><?php echo JText::_('Select Campaign'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- / select -->
                    <!-- filters -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="ln_solid"></div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <!--                            <label>--><?php //echo JText::_('Dates');?><!--</label>-->
                                <div id="daterange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>October 24, 1971 - October 24, 1971</span><b class="caret"></b>
                                </div>
                            </div>
                            <input type="hidden" name="datestart" id="datestart" value='<?php echo $datestart; ?>'/>
                            <input type="hidden" name="dateend" id="dateend" value='<?php echo $dateend; ?>'/>
                            <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <select id="selCountryS" class="form-control" name="country" onchange="getStateList()">
                                    <option value="" selected>All Countries</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <select id="selStateS" class="form-control" name="state" onchange="getCityList()">
                                    <option value="" selected>All States</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <select id="selCityS" class="form-control" name="city" onchange="getZipCodeList()">
                                    <option value="" selected>All Cities</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <select id="selZipCodeS" class="form-control" name="zipcodeS" multiple="multiple" onblur="getSpotList()">
                                    <option value="" selected>All ZipCodes</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-2 col-sm-2 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <select id="selSpot" class="form-control" name="spot">
                                    <option value="" selected><?php echo JText::_('All Spots'); ?></option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /filters -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="ln_solid"></div>
                        <div class="item form-group">
                            <div class="col-md-6 col-sm-6 offset-md-3">
                                <button class="btn btn-primary" type="submit"><?php echo JText::_('Cancel'); ?></button>
                                <button class="btn btn-success" type="button" onclick="sendForm()"><?php echo JText::_('Submit'); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_EFFECTIVENESS');?> <small></small></h2>
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
            <div class='row tile_count'>
                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-paper-plane"></i> <?php echo JText::_('Total SMS / Email');?></span>
                    <div id="totalMessage" class='count'>0</div>
                    <input type="hidden" id="itotalMessage"/>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top green"><i class="fa fa-download"></i> <?php echo JText::_('IN');?></span>
                    <div id="totalIn" class="count green">0</div>
                    <input type="hidden" id="itotalIn"/>
                </div>
                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top green"><i class="fa fa-pie-chart"></i> </span>
                    <div id="percentageIN" class="count green">0 %</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_TARGETUSERS');?> <small></small></h2>
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
            <div class='row tile_count'>
                <div class="col-md-4 col-sm-4 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-users"></i> <?php echo JText::_('Registered Users');?></span>
                    <div id="registeredUsers" class='count'>0</div>
                </div>
            </div>
            <div class='row tile_count'>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top"><i class="fa fa-users"></i> <?php echo JText::_('Total New Users');?></span>
                    <div id="totalUsers" class='count'>0</div>
                    <input type="hidden" id="itotalUsers"/>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top blue"><i class="fa fa-file-text-o"></i> <?php echo JText::_('Target New Users');?></span>
                    <div id="targetNew" class="count blue">0</div>
                    <input type="hidden" id="itargetNew"/>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top green"><i class="fa fa-file-o"></i> <?php echo JText::_('New Users');?></span>
                    <div id="newUsers" class="count green">0</div>
                    <input type="hidden" id="inewUsers"/>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 tile_stats_count">
                    <span class="count_top green"><i class="fa fa-pie-chart"></i> </span>
                    <div id="newUserPercentage" class="count green">0 %</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-12 col-sm-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_DETAIL');?> <small></small></h2>
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
            <div class="col-sm-12">
                <div class="card-box table-responsive">
                    <table id="datatable-cEffectivenes" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                        <tr class="headings">
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_CAMPAIGN'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_DEVICE'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_USERNAME'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_DATE'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_STATUS'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_DESCRIPTION'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPSELECTCAMPAIGNEFFECTIVENESS_SPOT'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>