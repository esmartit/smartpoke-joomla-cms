<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectsmartpoke
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

// Switchery
$document->addStyleSheet('/templates/smartpokex/vendors/switchery/dist/switchery.min.css');
// bootstrap-daterangepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.css');
// bootstrap-datetimepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');
// Ion.RangeSlider
$document->addStyleSheet('/templates/smartpokex/vendors/normalize-css/normalize.css');
$document->addStyleSheet('/templates/smartpokex/vendors/ion.rangeSlider/css/ion.rangeSlider.css');
$document->addStyleSheet('/templates/smartpokex/vendors/ion.rangeSlider/css/ion.rangeSlider.skinNice.css');

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
// Switchery
$document->addScript('/templates/smartpokex/vendors/switchery/dist/switchery.min.js');
// bootstrap-daterangepicker
$document->addScript('/templates/smartpokex/vendors/moment/min/moment.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.js');
// bootstrap-datetimepicker
$document->addScript('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
// Ion.RangeSlider
$document->addScript('/templates/smartpokex/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js');

// DataTables
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

$document->addScript('/media/mod_spexportcustomer/js/spexportcustomer.js');

$currDate = date('Y-m-d H:i:s');
$datestart = date("Y-m-d", strtotime("-29 day", strtotime($currDate)));
$dateend = date("Y-m-d", strtotime($currDate));

?>
<div class="col-md-12 col-sm-12 ">
    <p>
        <a class="btn btn-outline-secondary" data-toggle="collapse" href="#collapseSelect" role="button" aria-expanded="false" aria-controls="collapseSelect">
            <?php echo JText::_('MOD_SPEXPORTCUSTOMER');?>
        </a>
    </p>
    <div class="collapse" id="collapseSelect">
        <div class="x_panel">
            <div class="x_content">
                <form id="export_select_form" class="form-horizontal form-label-left" method="POST" enctype="multipart/form-data">
                    <!-- select -->
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div id="daterange" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                    <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                    <span>October 24, 1971 - October 24, 1971</span><b class="caret"></b>
                                </div>
                            </div>
                            <input type="hidden" name="datestart" id="datestart" value='<?php echo $datestart; ?>'/>
                            <input type="hidden" name="dateend" id="dateend" value='<?php echo $dateend; ?>'/>
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
                        <div id="spotSelect" class="col-md-2 col-sm-2 col-xs-12">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <br/>
                                <select id="selSpot" class="form-control" name="spot">
                                    <option value="" selected><?php echo JText::_('All HotSpots'); ?></option>
                                </select>
                            </div>
                            <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
                        </div>
                    </div>
                    <!-- / select -->
                    <!-- filters -->
                    <div id="filters" class="col-md-12 col-sm-12 col-xs-12">
                        <div class="ln_solid"></div>
                        <h2><?php echo JText::_('Filters');?>
                            <input id="checkFilter" type="checkbox" class="js-switch" /></h2>
                        <div id="filterAge" class="col-md-4 col-sm-4 col-xs-12" style="display: none">
                            <label><?php echo JText::_('Range Age'); ?></label>
                            <input type="text" id="range_age" value="" name="range" />
                            <input type="hidden" id="from_value" value="18" name="from_value" />
                            <input type="hidden" id="to_value" value="85" name="to_value" />
                        </div>
                        <div id="filterSex" class="col-md-2 col-sm-2 col-xs-12" style="display: none">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo JText::_('Sex'); ?></label>
                                <select id="selSex" class="form-control" name="sex">
                                    <option value="" selected><?php echo JText::_('Both'); ?></option>
                                    <option value="MALE"><?php echo JText::_('Man'); ?></option>
                                    <option value="FEMALE"><?php echo JText::_('Woman'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div id="filterZipCode" class="col-md-2 col-sm-2 col-xs-12" style="display: none">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo JText::_('ZipCodes');?></label>
                                <select id="selZipCode" class="form-control" name="zipcode" multiple="multiple">
                                    <option value="" selected><?php echo JText::_('All'); ?></option>
                                    <?php foreach ($zipcodes as $item): ?>
                                        <option value="<?php echo $item->zipcode; ?>"><?php echo $item->zipcode; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div id="filterMember" class="col-md-2 col-sm-2 col-xs-12" style="display: none">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo JText::_('Membership');?></label>
                                <select id="selMembership" class="form-control" name="membership">
                                    <option value="" selected><?php echo JText::_('Both'); ?></option>
                                    <option value="0"><?php echo JText::_('No'); ?></option>
                                    <option value="1"><?php echo JText::_('Yes'); ?></option>
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
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPEXPORTCUSTOMER_USERS');?><small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
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
            <form id="smartpoke_form" method="POST">
                <div id="database" class="table-responsive">
                    <table id="datatable-database" class="table table-striped table-bordered bulk_action">
                        <thead>
                        <tr>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_FIRSTNAME'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_LASTNAME'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_MOBILE PHONE'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_EMAIL'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_USERNAME'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_AGE'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_SEX'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_ZIPCODE'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_MEMBER'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_COMMUNICATION'); ?></th>
                            <th class='column-title'><?php echo JText::_('MOD_SPEXPORTCUSTOMER_SPOT'); ?></th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>