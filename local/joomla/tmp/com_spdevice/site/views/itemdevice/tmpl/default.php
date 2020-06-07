<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		14th April, 2020
	@package		SP Device
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


/***[JCBGUI.site_view.php_view.39.$$$$]***/
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.39.$$$$]-->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPDEVICE_VIEW_DEVICE'); ?><small></small></h2>
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
            <form id="newDevice" data-parsley-validate class="form-horizontal form-label-left">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="device"><?php echo JText::_('COM_SPDEVICE_DEVICE'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="device" disabled class="form-control " value="<?php echo $this->item->device; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPDEVICE_TYPE'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <div id="type" class="btn-group" data-toggle="buttons">
                            <?php if ($this->item->type == 0)
                                {
                                    $value_o = 'Other';
                                    $checked_o = 'checked';
                                    $focus_o = 'focus';
                                    $checked_f = '';
                                    $focus_f = '';
                                } else {
                                    $value_f = 'FM';
                                    $checked_o = '';
                                    $focus_o = '';
                                    $checked_f = 'checked';
                                    $focus_f = 'focus';
                                }
                            ?>
                            <label class="btn btn-secondary <?php echo $focus_f; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="type" value="<?php echo $value_f; ?>" <?php echo $checked_f; ?> class="join-btn"> <?php echo JText::_('FM'); ?>
                            </label>
                            <label class="btn btn-primary <?php echo $focus_o; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="type" value="<?php echo $value_o; ?>" <?php echo $checked_o; ?> class="join-btn"> <?php echo JText::_('COM_SPDEVICE_OTHER'); ?>
                            </label>                        
                        </div>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-light" href="index.php?option=com_spdevice&view=listdevice"><?php echo JText::_('COM_SPDEVICE_BACK'); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

