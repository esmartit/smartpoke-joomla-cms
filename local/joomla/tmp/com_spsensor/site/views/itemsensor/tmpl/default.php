<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
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


/***[JCBGUI.site_view.php_view.37.$$$$]***/
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.37.$$$$]-->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPSENSOR_VIEW_SENSOR'); ?><small></small></h2>
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
            <form id="newSensor" data-parsley-validate class="form-horizontal form-label-left">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="sensor_id"><?php echo JText::_('COM_SPSENSOR_SENSOR_ID'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="sensor_id" disabled class="form-control " value=<?php echo $this->item->sensor_id; ?>>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="spot"><?php echo JText::_('COM_SPSENSOR_SPOT'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="spot" disabled class="form-control " value="<?php echo $this->item->spot_name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="location"><?php echo JText::_('COM_SPSENSOR_LOCATION'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="location" disabled class="form-control " value="<?php echo $this->item->location; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="zone"><?php echo JText::_('COM_SPSENSOR_ZONE'); ?> </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="zone" disabled class="form-control " value="<?php echo $this->item->zone_name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="pwr_in"><?php echo JText::_('IN'); ?> </label>
                    <div class="col-md-3 col-sm-3 ">
                        <input type="text" id="pwr_in" disabled class="form-control " value=<?php echo $this->item->pwr_in; ?>>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="pwr_limit"><?php echo JText::_('LIMIT'); ?> </label>
                    <div class="col-md-3 col-sm-3 ">
                        <input type="text" id="pwr_limit" disabled class="form-control " value=<?php echo $this->item->pwr_limit; ?>>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="pwr_out"><?php echo JText::_('OUT'); ?> </label>
                    <div class="col-md-3 col-sm-3 ">
                        <input type="text" id="pwr_out" disabled class="form-control " value=<?php echo $this->item->pwr_out; ?>>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-light" href="index.php?option=com_spsensor&view=listsensor"><?php echo JText::_('COM_SPSENSOR_BACK'); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

