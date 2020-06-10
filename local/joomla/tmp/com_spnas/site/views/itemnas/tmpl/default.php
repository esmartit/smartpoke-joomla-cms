<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			3rd June, 2020
	@created		7th April, 2020
	@package		SP Nas
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


/***[JCBGUI.site_view.php_view.45.$$$$]***/
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.45.$$$$]-->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPNAS_VIEW_NAS'); ?><small></small></h2>
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
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="nasname"><?php echo JText::_('COM_SPNAS_NAS_NAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="nasname" disabled class="form-control " value="<?php echo $this->item->name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="shortname"><?php echo JText::_('COM_SPNAS_SHORT_NAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="shortname" disabled class="form-control " value="<?php echo $this->item->shortName; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="type"><?php echo JText::_('COM_SPNAS_TYPE'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6 ">
                        <input type="text" id="type" disabled class="form-control " value="<?php echo $this->item->type; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="secret"><?php echo JText::_('COM_SPNAS_SECRET'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="password" id="secret" disabled class="form-control " value="<?php echo $this->item->secret; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="ports"><?php echo JText::_('COM_SPNAS_PORTS'); ?></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="ports" disabled class="form-control " value="<?php echo $this->item->ports; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="server"><?php echo JText::_('COM_SPNAS_SERVER'); ?></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="serve" disabled class="form-control " value="<?php echo $this->item->server; ?>">
                    </div>
                </div>                
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="community"><?php echo JText::_('COM_SPNAS_COMMUNITY'); ?></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="community" disabled class="form-control " value="<?php echo $this->item->community; ?>">
                    </div>
                </div>                           
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="description"><?php echo JText::_('COM_SPNAS_DESCRIPTION'); ?></label>
                    <div class="col-md-6 col-sm-6">
                        <textarea id="description" disabled class="resizable_textarea form-control" ><?php echo $this->item->description; ?></textarea>
                    </div>
                </div>                           
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-light" href="index.php?option=com_spnas&view=listnas"><?php echo JText::_('COM_SPNAS_BACK'); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

