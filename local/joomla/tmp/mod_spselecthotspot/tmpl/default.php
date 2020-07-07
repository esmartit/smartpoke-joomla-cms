<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spselectbigdata
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
// Ion.RangeSlider
$document->addStyleSheet('/templates/smartpokex/vendors/normalize-css/normalize.css');
$document->addStyleSheet('/templates/smartpokex/vendors/ion.rangeSlider/css/ion.rangeSlider.css');
$document->addStyleSheet('/templates/smartpokex/vendors/ion.rangeSlider/css/ion.rangeSlider.skinNice.css');

$document->addScript('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js');
$document->addScript('//geodata.solutions/includes/countrystatecity.js');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
// bootstrap-daterangepicker
$document->addScript('/templates/smartpokex/vendors/moment/min/moment.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.js');
// bootstrap-datetimepicker
$document->addScript('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
// Ion.RangeSlider
$document->addScript('/templates/smartpokex/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js');
$document->addScript('/media/mod_spselecthotspot/js/spselecthotspot.js');

$currDate = date('Y-m-d H:i:s');
$datestart = date("Y-m-d", strtotime("-29 day", strtotime($currDate)));
$dateend = date("Y-m-d", strtotime($currDate));

?>
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPSELECTHOTSPOT');?> <small></small></h2>
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
            <form id="bigdata_select_form" class="form-horizontal form-label-left" method="POST">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?php echo JText::_('Dates Range');?></label>
                            <div id="daterange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span>October 24, 1971 - October 24, 1971</span> <b class="caret"></b>
                            </div>
                        </div>
                        <input type="hidden" name="datestart" id="datestart" value='<?php echo $datestart; ?>'/>
                        <input type="hidden" name="dateend" id="dateend" value='<?php echo $dateend; ?>'/>
                        <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select name="country" class="countries order-alpha form-control" id="countryId">
                                <option value="" selected>Select Country</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select name="state" class="states order-alpha form-control" id="stateId">
                                <option value="" selected>Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select name="city" class="cities order-alpha form-control" id="cityId" onblur="getSpotCity()">
                                <option value="" selected>Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select id="selSpot" class="form-control" name="spot">
                                <option value="" selected><?php echo JText::_('All HotSpots'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- / select -->
                <!-- filters -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="ln_solid"></div>
                    <h2><?php echo JText::_('Filters');?> <small></small></h2>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <label><?php echo JText::_('Range Age'); ?></label>
                        <input type="text" id="range_age" value="" name="range" />
                        <input type="hidden" id="from_value" value="18" name="from_value" />
                        <input type="hidden" id="to_value" value="85" name="to_value" />
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?php echo JText::_('Sex'); ?></label>
                            <select id="selSex" class="form-control" name="sex">
                                <option value="" selected><?php echo JText::_('Both'); ?></option>
                                <option value="0"><?php echo JText::_('Man'); ?></option>
                                <option value="1"><?php echo JText::_('Woman'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
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
                    <div class="col-md-2 col-sm-2 col-xs-12">
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