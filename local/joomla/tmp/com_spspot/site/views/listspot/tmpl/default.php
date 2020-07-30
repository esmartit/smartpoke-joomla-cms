<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.2
	@build			29th July, 2020
	@created		14th April, 2020
	@package		SP Spot
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


/***[JCBGUI.site_view.php_view.30.$$$$]***/
$document = JFactory::getDocument();

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.30.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPSPOT_LIST_OF_SPOTS'); ?><small></small></h2>
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
        <?php if ($this->user->authorise('core.create', 'com_spspot')): ?>
            <button type="button" class="open-spotModal btn btn-light" data-toggle="modal" data-target="#spotModal" data-title="New" data-info='{"id":"", "spotId":"", "spotName":"", "businessId":"", "latitude":"", "longitude":"", "countryId":"", "stateId":"",  "cityId":"", "zipcode":"", "option":"C"}'><?php echo JText::_('COM_SPSPOT_NEW_SPOT'); ?></button>
            <br />
        <?php endif; ?>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="headings">
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_SPOT_ID'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_SPOT'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_BUSINESS_TYPE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_COUNTRY'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_STATE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_CITY'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_ZIPCODE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_LOCATION'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPSPOT_GEOPOSITION'); ?></th>
                                <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPSPOT_ACTION'); ?></span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->items as $item): ?>
                                <?php
                                $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
                                $userChkOut = JFactory::getUser($item->checked_out);
                                $canDo = SpspotHelper::getActions('spot',$item,'spots');
                                ?>
                                <tr>
                                    <td class="a-right a-right"><?php echo $item->spot_id; ?></td>
                                    <td class="a-right a-right"><?php echo $item->name; ?></td>
                                    <td class="a-right a-right"><?php echo $item->businesstype; ?></td>
                                    <td class="a-right a-right" ><?php echo $item->countryName; ?></td>
                                    <td class="a-right a-right"><?php echo $item->stateName; ?></td>
                                    <td class="a-right a-right"><?php echo $item->cityName; ?></td>
                                    <td class="a-right a-right"><?php echo $item->zipcode; ?></td>
                                    <td class="a-right a-right"><?php echo $item->location; ?></td>
                                    <td class="a-right a-right"><?php echo $item->latitude.", ".$item->longitude; ?></td>
                                    <td class=" last">
                                        <a type="button" class="open-spotModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#spotModal" data-title="View" data-info='{"id":"<?php echo $item->id; ?>", "spotId":"<?php echo $item->spot_id; ?>", "spotName":"<?php echo $item->name; ?>", "businessId":"<?php echo $item->business; ?>", "latitude":"<?php echo $item->latitude; ?>", "longitude":"<?php echo $item->longitude; ?>", "countryId":"<?php echo $item->country; ?>", "stateId":"<?php echo $item->state; ?>",  "cityId":"<?php echo $item->city; ?>", "zipcode":"<?php echo $item->zipcode; ?>", "option":"R"}'><i class="fa fa-eye"></i></a>
                                        <?php if ($canDo->get('core.edit')): ?>
                                            <a type="button" class="open-spotModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#spotModal" data-title="Edit" data-info='{"id":"<?php echo $item->id; ?>", "spotId":"<?php echo $item->spot_id; ?>", "spotName":"<?php echo $item->name; ?>", "businessId":"<?php echo $item->business; ?>", "latitude":"<?php echo $item->latitude; ?>", "longitude":"<?php echo $item->longitude; ?>", "countryId":"<?php echo $item->country; ?>", "stateId":"<?php echo $item->state; ?>",  "cityId":"<?php echo $item->city; ?>", "zipcode":"<?php echo $item->zipcode; ?>", "option":"U"}'><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if ($canDo->get('core.delete')): ?>
                                            <a type="button" class="open-spotModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#spotModal" data-title="Delete" data-info='{"id":"<?php echo $item->id; ?>", "spotId":"<?php echo $item->spot_id; ?>", "spotName":"<?php echo $item->name; ?>", "businessId":"<?php echo $item->business; ?>", "latitude":"<?php echo $item->latitude; ?>", "longitude":"<?php echo $item->longitude; ?>", "countryId":"<?php echo $item->country; ?>", "stateId":"<?php echo $item->state; ?>",  "cityId":"<?php echo $item->city; ?>", "zipcode":"<?php echo $item->zipcode; ?>", "option":"D"}'><i class="fa fa-trash"></i></a>
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

<div class="modal fade" id="spotModal" tabindex="-1" role="dialog" aria-labelledby="spotModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="spotModalLabel">Spot</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modalForm" class="form-horizontal form-label-left">
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden" class="form-control" id="id">
                            <input type="hidden" class="form-control" id="option">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="spotId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_SPOT_ID'); ?><span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" id="spotId" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="spotName" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_NAME'); ?><span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" id="spotName" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="businessId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_BUSINESS'); ?><span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4">
                            <select id="selBusiness" class="form-control" name="businessId">
                                <option value="" selected disabled><?php echo JText::_('COM_SPSPOT_SELECT_BUSINESS'); ?></option>
                                <?php $businessList = $this->getBusinessList();
                                foreach ($businessList as $item) {
                                    echo "<option value=".$item[0].">".$item[1]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="latitude" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_LATITUDE'); ?></label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" id="latitude">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="longitude" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_LONGITUDE'); ?></label>
                        <div class="col-md-4 col-sm-4">
                            <input type="text" class="form-control" id="longitude">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="countryId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_COUNTRY'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="selCountry" class="form-control" name="countryId" required onblur="getStates()">
                                <option value="" selected disabled><?php echo JText::_('COM_SPSPOT_SELECT_COUNTRY'); ?></option>
                                <?php $countryList = $this->getCountryList();
                                foreach ($countryList as $item) {
                                    echo "<option value=".$item[0].">".$item[1]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="stateId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_STATE'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="selState" class="form-control" name="stateId" required onblur="getCities()">
                                <option value="" selected disabled><?php echo JText::_('COM_SPSPOT_SELECT_STATE'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="cityId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_CITY'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="selCity" class="form-control" name="cityId" required onblur="getZipCodes()">
                                <option value="" selected disabled><?php echo JText::_('COM_SPSPOT_SELECT_CITY'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="zipCodeId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPSPOT_ZIPCODE'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="selZipCode" class="form-control" name="zipCodeId" required>
                                <option value="" selected disabled><?php echo JText::_('COM_SPSPOT_SELECT_ZIPCODE'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPSPOT_CLOSE'); ?></button>
                        <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPSPOT_SAVE'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

