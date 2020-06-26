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
$document->addScript('/media/mod_spselectbigdata/js/spselectbigdata.js');

$currDate = date('Y-m-d H:i:s');
$datestart = date("Y-m-d", strtotime("-1 day", strtotime($currDate)));
$datestartspan = date("d M Y", strtotime($datestart));

$dateend = date("Y-m-d", strtotime("-1 day", strtotime($currDate)));
$dateendspan = date("d M Y", strtotime($dateend));

$datestart2 = date("Y-m-d", strtotime("-8 day", strtotime($currDate)));
$datestartspan2 = date("d M Y", strtotime($datestart2));

$dateend2 = date("Y-m-d", strtotime("-8 day", strtotime($currDate)));
$dateendspan2 = date("d M Y", strtotime($dateend2));

?>
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('MOD_SPSELECTBIGDATA');?> <small></small></h2>
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
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div id="selRadio" class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" value="0" id="radioRange" name="rangeCompare"> <?php echo JText::_('Range'); ?>
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" value="1" id="radioCompare" name="rangeCompare"> <?php echo JText::_('Compare'); ?>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input id="timestart" type="text" name="timestart" class="form-control"/>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input id="timeend" type="text" name="timeend" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?php echo JText::_('Range');?></label>
                            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span><?php echo $datestartspan.' - '.$dateendspan;?></span> <b class="caret"></b>
                            </div>
                        </div>
                        <input type="hidden" name="datestart" id="datestart" value='<?php echo $datestart;?>'/>
                        <input type="hidden" name="dateend" id="dateend" value='<?php echo $dateend;?>'/>
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12" id="daterange" style="display: none;">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?php echo JText::_('Range2');?></label>
                            <div id="reportrange_right" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                <span><?php echo $datestartspan2.' - '.$dateendspan2;?></span> <b class="caret"></b>
                            </div>
                        </div>
                        <input type="hidden" name="datestart2" id="datestart2" value='<?php echo $datestart2;?>'/>
                        <input type="hidden" name="dateend2" id="dateend2" value='<?php echo $dateend2;?>'/>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select name="country" class="countries order-alpha form-control" id="countryId">
                                <option value="">Select Country</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select name="state" class="states order-alpha form-control" id="stateId">
                                <option value="">Select State</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select name="city" class="cities order-alpha form-control" id="cityId" onblur="getSpotCity()">
                                <option value="">Select City</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select id="selSpot" class="form-control" name="spot" onblur="getSensorSpot()">
                                <option value=""><?php echo JText::_('All Spots'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select id="selSensor" class="form-control" name="sensor">
                                <option value=""><?php echo JText::_('All Sensors'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select id="selBrand" class="form-control" name="brand" multiple="multiple">
                                <option value=""><?php echo JText::_('All Brands'); ?></option>
                                <?php foreach ($brands as $item): ?>
                                    <option value="<?php echo $item->id; ?>"><?php echo $item->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <select id="selStatus" class="form-control" name="status">
                                <option value=""><?php echo JText::_('All Status'); ?></option>
                                <option value="IN"><?php echo JText::_('IN'); ?></option>
                                <option value="LIMIT"><?php echo JText::_('LIMIT'); ?></option>
                                <option value="OUT"><?php echo JText::_('OUT'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <br/>
                            <label class="col-md-6 col-sm-6 col-xs-12"><?php echo JText::_('Presence');?></label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input id="presence" type="text" name="presence" class="form-control" value="1">
                            </div>
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
                        <input type="hidden" id="from_value" value="" name="from_value" />
                        <input type="hidden" id="to_value" value="" name="to_value" />
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?php echo JText::_('Sex'); ?></label>
                            <select id="selSex" class="form-control" name="sex">
                                <option value=""><?php echo JText::_('Both'); ?></option>
                                <option value="0"><?php echo JText::_('Man'); ?></option>
                                <option value="1"><?php echo JText::_('Woman'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-2 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label><?php echo JText::_('ZipCodes');?></label>
                            <select id="selZipCode" class="form-control" name="zipcode" multiple="multiple">
                                <option value=""><?php echo JText::_('All'); ?></option>
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
                                <option value=""><?php echo JText::_('Both'); ?></option>
                                <option value="0"><?php echo JText::_('No'); ?></option>
                                <option value="1"><?php echo JText::_('Yes'); ?></option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- /filters -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <div id="selRadioGraph" class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" value="0" id="radioDay" name="radioGraph"> <?php echo JText::_('By Day'); ?>
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" value="1" id="radioWeek" name="radioGraph"> <?php echo JText::_('By Week'); ?>
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" value="2" id="radioMonth" name="radioGraph"> <?php echo JText::_('By Month'); ?>
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" value="3" id="radioYear" name="radioGraph"> <?php echo JText::_('By Year'); ?>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="ln_solid"></div>
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6 offset-md-3">
                            <button class="btn btn-primary" type="button"><?php echo JText::_('Cancel'); ?></button>
                            <button type="submit" class="btn btn-success"><?php echo JText::_('Submit'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>