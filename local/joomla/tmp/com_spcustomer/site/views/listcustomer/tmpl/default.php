<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		24th April, 2020
	@package		SP Customer
	@subpackage		default.php
	@author			Adolfo Zignago <https://esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/***[JCBGUI.site_view.php_view.42.$$$$]***/
$document = JFactory::getDocument();

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

// bootstrap-daterangepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.css');
// bootstrap-datetimepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');

// bootstrap-daterangepicker
$document->addScript('/templates/smartpokex/vendors/moment/min/moment.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.js');
// bootstrap-datetimepicker
$document->addScript('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');

// iCheck
$document->addScript('/templates/smartpokex/vendors/iCheck/icheck.min.js');

$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.42.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPCUSTOMER_LIST_OF_CUSTOMER'); ?><small></small></h2>
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
        <?php if ($this->user->authorise('core.create', 'com_spcustomer')): ?>
            <button type="button" class="open-customerModal btn btn-light" data-toggle="modal" data-target="#customerModal" data-title="New" data-info='{"id":"", "spot":"", "userName":"", "firstName":"", "lastName":"", "mobilePhone":"", "email":"", "birthDate":"",  "sex":"", "zipcode":"", "memberShip":"", "communication":"", "option":"C"}'><?php echo JText::_('COM_SPCUSTOMER_NEW_CUSTOMER'); ?></button>
            <br />
        <?php endif; ?>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="headings">
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_USERNAME'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_FIRST_NAME'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_LAST_NAME'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_MOBILE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_EMAIL'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_BIRTH_DATE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_SEX'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_ZIPCODE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_SPOT'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_MEMBERSHIP'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_COMMUNICATION'); ?></th>
                                <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPCUSTOMER_ACTION'); ?></span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->items as $item): ?>
                                <?php
                                $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
                                $userChkOut = JFactory::getUser($item->checked_out);
                                $canDo = SpcustomerHelper::getActions('customer',$item,'customers');
                                ?>
                                <tr>
                                    <td class="a-right a-right "><?php echo $item->username; ?></td>
                                    <td class="a-right a-right "><?php echo $item->firstname; ?></td>
                                    <td class="a-right a-right "><?php echo $item->lastname; ?></td>
                                    <td class="a-right a-right "><?php echo $item->mobile_phone; ?></td>
                                    <td class="a-right a-right "><?php echo $item->email; ?></td>
                                    <td class="a-right a-right "><?php echo $item->dateofbirth; ?></td>
                                    <?php if ($item-> sex == 0): ?>
                                        <td class="" align="center"><span class='fa fa-male'></td>
                                    <?php else : ?>
                                        <td class="" align="center"><span class='fa fa-female'></td>
                                    <?php endif; ?>
                                    <td class="" align="center"><?php echo $item->zipcode; ?></td>
                                    <td class="a-right a-right "><?php echo $item->spot_name; ?></td>
                                    <?php if ($item-> membership == 0): ?>
                                        <td class="" align="center"><span class='glyphicon glyphicon-remove' style='color:#FF0000'></td>
                                    <?php else : ?>
                                        <td class="" align="center"><span class='glyphicon glyphicon-ok' style='color:#00FF00'></td>
                                    <?php endif; ?>
                                    <?php if ($item-> communication == 0): ?>
                                        <td class="" align="center"><span class='glyphicon glyphicon-remove' style='color:#FF0000'></td>
                                    <?php else : ?>
                                        <td class="" align="center"><span class='glyphicon glyphicon-ok' style='color:#00FF00'></td>
                                    <?php endif; ?>
                                    <td class=" last">
                                        <a type="button" class="open-customerModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#customerModal" data-title="View" data-info='{"id":"<?php echo $item->id; ?>", "spot":"<?php echo $item->spot; ?>", "userName":"<?php echo $item->username; ?>", "firstName":"<?php echo $item->firstname; ?>", "lastName":"<?php echo $item->lastname; ?>", "mobilePhone":"<?php echo $item->mobile_phone; ?>", "email":"<?php echo $item->email; ?>", "birthDate":"<?php echo $item->dateofbirth; ?>",  "sex":"<?php echo $item->sex; ?>", "zipcode":"<?php echo $item->zipcode; ?>", "memberShip":"<?php echo $item->membership; ?>", "communication":"<?php echo $item->communication; ?>", "option":"R"}'><i class="fa fa-eye"></i></a>
                                        <?php if ($canDo->get('core.edit')): ?>
                                            <a type="button" class="open-customerModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#customerModal" data-title="Edit" data-info='{"id":"<?php echo $item->id; ?>", "spot":"<?php echo $item->spot; ?>", "userName":"<?php echo $item->username; ?>", "firstName":"<?php echo $item->firstname; ?>", "lastName":"<?php echo $item->lastname; ?>", "mobilePhone":"<?php echo $item->mobile_phone; ?>", "email":"<?php echo $item->email; ?>", "birthDate":"<?php echo $item->dateofbirth; ?>",  "sex":"<?php echo $item->sex; ?>", "zipcode":"<?php echo $item->zipcode; ?>", "memberShip":"<?php echo $item->membership; ?>", "communication":"<?php echo $item->communication; ?>", "option":"U"}'><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if ($canDo->get('core.delete')): ?>
                                            <a type="button" class="open-customerModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#customerModal" data-title="Delete" data-info='{"id":"<?php echo $item->id; ?>", "spot":"<?php echo $item->spot; ?>", "userName":"<?php echo $item->username; ?>", "firstName":"<?php echo $item->firstname; ?>", "lastName":"<?php echo $item->lastname; ?>", "mobilePhone":"<?php echo $item->mobile_phone; ?>", "email":"<?php echo $item->email; ?>", "birthDate":"<?php echo $item->dateofbirth; ?>",  "sex":"<?php echo $item->sex; ?>", "zipcode":"<?php echo $item->zipcode; ?>", "memberShip":"<?php echo $item->membership; ?>", "communication":"<?php echo $item->communication; ?>", "option":"D"}'><i class="fa fa-trash"></i></a>
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

<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="customerModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="customerModalLabel">Customer</h5>
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
                        <label for="spotId" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_SPOT'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="selSpot" class="form-control" name="spotId">
                                <option value="" selected disabled><?php echo JText::_('COM_SPCUSTOMER_SELECT_SPOT'); ?></option>
                                <?php $selSpot = $this->getSpotList();
                                foreach ($selSpot as $item) {
                                    echo "<option value=".$item[0].">".$item[1]."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="userName" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_USERNAME'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="userName" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="firstName" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_FIRST_NAME'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="firstName" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="lastName" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_LAST_NAME'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="lastName" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="mobilePhone" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_MOBILE'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="mobilePhone" required="required">
                            <span class="fa fa-phone form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="email" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_EMAIL'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="email" required="required">
                            <span class="fa fa-envelope form-control-feedback right" aria-hidden="true"></span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="birthDate" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_BIRTH_DATE'); ?></label>
                        <div class="col-md-6 col-sm-6 input-group date" id="birthD">
                            <input type='text' class="form-control" id="birthDate">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="radioSex" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_SEX'); ?></label>
                        <div id="radioSex" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="radioSex" id="radioMan" value="0" class="join-btn"> &nbsp; <span class='fa fa-male'> &nbsp;
                            </label>
                            <label class="btn btn-success" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="radioSex" id="radioWoman" value="1" class="join-btn"> &nbsp; <span class='fa fa-female'> &nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="zipCode" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_ZIPCODE'); ?></label>
                        <div class="col-md-3 col-sm-3">
                            <input type="text" class="form-control" id="zipCode">
                        </div>
                    </div>
                    <div class="item form-group">
                        <div class="col-md-12 col-sm-12">
                            <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_MEMBERSHIP'); ?></label>
                            <div class="col-md-3 col-sm-3">
                                <div class="checkbox">
                                    <input id="member" name="member" type="checkbox" class="flat">
                                </div>
                            </div>
                            <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_COMMUNICATION'); ?></label>
                            <div class="col-md-3 col-sm-3">
                                <div class="checkbox">
                                    <input id="communication" name="communication" type="checkbox" class="flat">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPCUSTOMER_CLOSE'); ?></button>
                        <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPCUSTOMER_SAVE'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

