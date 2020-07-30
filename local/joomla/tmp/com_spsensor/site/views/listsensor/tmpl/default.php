<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Sensor
	@subpackage		default.php
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/***[JCBGUI.site_view.php_view.36.$$$$]***/
$document = JFactory::getDocument();

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

// bootstrap-daterangepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.css');
// bootstrap-datetimepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');
// Ion.RangeSlider
$document->addStyleSheet('/templates/smartpokex/vendors/normalize-css/normalize.css');
$document->addStyleSheet('/templates/smartpokex/vendors/ion.rangeSlider/css/ion.rangeSlider.css');
$document->addStyleSheet('/templates/smartpokex/vendors/ion.rangeSlider/css/ion.rangeSlider.skinNice.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
// bootstrap-daterangepicker
$document->addScript('/templates/smartpokex/vendors/moment/min/moment.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.js');
// bootstrap-datetimepicker
$document->addScript('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
// Ion.RangeSlider
$document->addScript('/templates/smartpokex/vendors/ion.rangeSlider/js/ion.rangeSlider.min.js');

$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.36.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPSENSOR_LIST_OF_SENSORS'); ?><small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Settings 1</a>
                        <a class="dropdown-item" href="#">Settings 2</a>
                    </div>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <?php if ($this->user->authorise('core.create', 'com_spsensor')): ?>
            <button type="button" class="open-sensorModal btn btn-light" data-toggle="modal" data-target="#sensorModal" data-title="New" data-info='{"id":"", "spot":"", "sensorId":"", "location":"", "zoneId":"", "pwrIn":"", "pwrLimit":"", "pwrOut":"", "option":"C"}'><?php echo JText::_('COM_SPSENSOR_NEW_SENSOR'); ?></button>
            <br />
        <?php endif; ?>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="headings">
                                <th class='column-title'><?php echo JText::_('COM_SPSENSOR_SPOT'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSENSOR_SENSOR_ID'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSENSOR_LOCATION'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSENSOR_ZONE'); ?></th>
                                <th class='column-title'><?php echo JText::_('IN'); ?></th>
                                <th class='column-title'><?php echo JText::_('LIMIT'); ?></th>
                                <th class='column-title'><?php echo JText::_('OUT'); ?></th>
                                <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPSENSOR_ACTION'); ?></span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->items as $item): ?>
                                <?php
                                $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
                                $userChkOut = JFactory::getUser($item->checked_out);
                                $canDo = SpsensorHelper::getActions('sensor',$item,'sensors');
                                ?>
                                <tr>
                                    <td class=""><?php echo $item->spot_name; ?></td>
                                    <td class=""><?php echo $item->sensor_id; ?></td>
                                    <td class=""><?php echo $item->location; ?></td>
                                    <td class=""><?php echo $item->zone_name; ?></td>
                                    <td class=""><?php echo $item->pwr_in; ?></td>
                                    <td class=""><?php echo $item->pwr_limit; ?></td>
                                    <td class=""><?php echo $item->pwr_out; ?></td>
                                    <td class=" last">
                                        <a type="button" class="open-sensorModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#sensorModal" data-title="View" data-info='{"id":"<?php echo $item->id; ?>", "spot":"<?php echo $item->spot; ?>", "sensorId":"<?php echo $item->sensor_id; ?>", "location":"<?php echo $item->location; ?>", "zoneId":"<?php echo $item->zone; ?>", "pwrIn":"<?php echo $item->pwr_in; ?>", "pwrLimit":"<?php echo $item->pwr_limit; ?>", "pwrOut":"<?php echo $item->pwr_out; ?>",  "option":"R"}'><i class="fa fa-eye"></i></a>
                                        <?php if ($canDo->get('core.edit')): ?>
                                            <a type="button" class="open-sensorModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#sensorModal" data-title="Edit" data-info='{"id":"<?php echo $item->id; ?>", "spot":"<?php echo $item->spot; ?>", "sensorId":"<?php echo $item->sensor_id; ?>", "location":"<?php echo $item->location; ?>", "zoneId":"<?php echo $item->zone; ?>", "pwrIn":"<?php echo $item->pwr_in; ?>", "pwrLimit":"<?php echo $item->pwr_limit; ?>", "pwrOut":"<?php echo $item->pwr_out; ?>",  "option":"U"}'><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if ($canDo->get('core.delete')): ?>
                                            <a type="button" class="open-sensorModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#sensorModal" data-title="Delete" data-info='{"id":"<?php echo $item->id; ?>", "spot":"<?php echo $item->spot; ?>", "sensorId":"<?php echo $item->sensor_id; ?>", "location":"<?php echo $item->location; ?>", "zoneId":"<?php echo $item->zone; ?>", "pwrIn":"<?php echo $item->pwr_in; ?>", "pwrLimit":"<?php echo $item->pwr_limit; ?>", "pwrOut":"<?php echo $item->pwr_out; ?>",  "option":"D"}'><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="sensorModal" tabindex="-1" role="dialog" aria-labelledby="sensorModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sensorModalLabel">Sensor</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modalForm" class="form-horizontal form-label-left>
                    <div class="item form-group">
                <div class="col-md-6 col-sm-6">
                    <input type="hidden" class="form-control" id="id">
                    <input type="hidden" class="form-control" id="option">
                </div>
            </div>
            <div class="item form-group">
                <label for="spotId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSENSOR_SPOT'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <select id="selSpot" class="form-control" name="spotId"">
                    <option value="" selected disabled><?php echo JText::_('COM_SPSENSOR_SELECT_SPOT'); ?></option>
                    <?php $selSpot = $this->getSpotList();
                    foreach ($selSpot as $item) {
                        echo "<option value=".$item[0].">".$item[1]."</option>";
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label for="sensorId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSENSOR_SENSOR_ID'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" id="sensorId" required="required">
                </div>
            </div>
            <div class="item form-group">
                <label for="location" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSENSOR_LOCATION'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" id="location" required="required">
                </div>
            </div>
            <div class="item form-group">
                <label for="zoneId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSENSOR_ZONE'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <select id="selZone" class="form-control" name="zoneId"">
                    <option value="" selected disabled><?php echo JText::_('COM_SPSENSOR_SELECT_ZONE'); ?></option>
                    <?php $selZone = $this->getZoneList();
                    foreach ($selZone as $item) {
                        echo "<option value=".$item[0].">".$item[1]."</option>";
                    }
                    ?>
                    </select>
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('IN'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" id="range_pwrIn" value="" name="pwrIn" />
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('LIMIT'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" id="range_pwrLimit" value="" name="pwrLimit" />
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('OUT'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" id="range_pwrOut" value="" name="pwrOut" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPSENSOR_CLOSE'); ?></button>
                <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPSENSOR_SAVE'); ?></button>
            </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

