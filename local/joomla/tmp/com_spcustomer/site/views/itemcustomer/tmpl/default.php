<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
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


/***[JCBGUI.site_view.php_view.43.$$$$]***/
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.43.$$$$]-->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPCUSTOMER_VIEW_CUSTOMER'); ?><small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-item" href="#">Settings 1</a></li>
                        <li><a class="dropdown-item" href="#">Settings 2</a></li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
        <br />
            <form id="newCustomer" data-parsley-validate class="form-horizontal form-label-left">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="spot"><?php echo JText::_('COM_SPCUSTOMER_SPOT'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="spot" disabled class="form-control " value="<?php echo $this->item->spot_name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="username"><?php echo JText::_('COM_SPCUSTOMER_USERNAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="username" disabled class="form-control " value="<?php echo $this->item->username; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="firstname"><?php echo JText::_('COM_SPCUSTOMER_FIRSTNAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="firstname" disabled class="form-control " value="<?php echo $this->item->firstname; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="lastname"><?php echo JText::_('COM_SPCUSTOMER_LASTNAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="lastname" disabled class="form-control " value="<?php echo $this->item->lastname; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="mobile"><?php echo JText::_('COM_SPCUSTOMER_MOBILE'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="mobile" disabled class="form-control " value="<?php echo $this->item->mobile_phone; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email"><?php echo JText::_('COM_SPCUSTOMER_EMAIL'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="email" disabled class="form-control " value="<?php echo $this->item->email; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="dateofbirth"><?php echo JText::_('COM_SPCUSTOMER_BIRTH_DATE'); ?> <span class="required">*</span></label>
                    <div class="col-md-4 col-sm-4 ">
                        <div class='input-group date' id='dateofbirth'>
                            <input type='text' class="form-control" readonly="readonly" value="<?php echo $this->item->dateofbirth; ?>"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_SEX'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php if ($this->item->sex == 0)
                            {
                                $value_m = 0;
                                $checked_m = 'checked';
                                $focus_m = 'focus';
                                $checked_f = '';
                                $focus_f = '';
                            } else {
                                $value_f = 1;
                                $checked_f = 'checked';
                                $focus_f = 'focus';
                                $checked_m = '';
                                $focus_m = '';
                            }
                        ?>
                        <div id="type" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary <?php echo $focus_m; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="type" value="<?php echo $value_m; ?>" <?php echo $checked_m; ?> class="join-btn"> <?php echo JText::_('COM_SPCUSTOMER_MALE'); ?>
                            </label>
                            <label class="btn btn-primary <?php echo $focus_f; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="type" value="<?php echo $value_f; ?>" <?php echo $checked_f; ?> class="join-btn"> <?php echo JText::_('COM_SPCUSTOMER_FEMALE'); ?>
                            </label>                        
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="zipcode"><?php echo JText::_('COM_SPCUSTOMER_ZIP_CODE'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-3 ">
                        <input type="text" id="zipcode" disabled class="form-control " value="<?php echo $this->item->zipcode; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_MEMBERSHIP'); ?> </label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php if ($this->item->membership == 0)
                            {
                                $value_n = 0;
                                $checked_n = 'checked';
                                $focus_n = 'focus';
                                $checked_y = '';
                                $focus_y = '';
                            } else {
                                $value_y = 1;
                                $checked_y = 'checked';
                                $focus_y = 'focus';
                                $checked_n = '';
                                $focus_n = '';
                            }
                        ?>
                        <div id="type" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary <?php echo $focus_y; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="deferred" value="<?php echo $value_y; ?>" <?php echo $checked_y; ?> class="join-btn"> <?php echo JText::_('COM_SPCUSTOMER_YES'); ?>
                            </label>
                            <label class="btn btn-primary <?php echo $focus_n; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="deferred" value="<?php echo $value_n; ?>" <?php echo $checked_n; ?> class="join-btn"> <?php echo JText::_('COM_SPCUSTOMER_NO'); ?>
                            </label>                        
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCUSTOMER_COMMUNICATION'); ?> </label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php if ($this->item->communication == 0)
                            {
                                $value_n = 0;
                                $checked_n = 'checked';
                                $focus_n = 'focus';
                                $checked_y = '';
                                $focus_y = '';
                            } else {
                                $value_y = 1;
                                $checked_y = 'checked';
                                $focus_y = 'focus';
                                $checked_n = '';
                                $focus_n = '';
                            }
                        ?>
                        <div id="type" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary <?php echo $focus_y; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="deferred" value="<?php echo $value_y; ?>" <?php echo $checked_y; ?> class="join-btn"> <?php echo JText::_('COM_SPCUSTOMER_YES'); ?>
                            </label>
                            <label class="btn btn-primary <?php echo $focus_n; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="deferred" value="<?php echo $value_n; ?>" <?php echo $checked_n; ?> class="join-btn"> <?php echo JText::_('COM_SPCUSTOMER_NO'); ?>
                            </label>                        
                        </div>
                    </div>
                </div>              
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-light" href="index.php?option=com_spcustomer&view=listcustomer"><?php echo JText::_('COM_SPCUSTOMER_BACK'); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

