<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		7th April, 2020
	@package		SP Nas
	@subpackage		edit.php
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

$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');

if ($this->item->id == 0) $this->item->type = 'Other';

?>
<?php //echo $this->toolbar->render(); ?>
<form action="<?php echo JRoute::_('index.php?option=com_spnas&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($this->item->id == 0): ?>
                    <h2><?php echo JText::_('New Nas'); ?><small></small></h2>
                <?php else: ?>
                    <h2><?php echo JText::_('Edit Nas'); ?><small></small></h2>
                <?php endif; ?>
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
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_name"><?php echo JText::_('COM_SPNAS_NAS_NAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="hidden" id="id" name="id" class="form-control" value="<?php echo $this->item->id; ?>">
                        <input type="text" id="jform_name" name="jform[name]" class="form-control required" required value="<?php echo $this->item->name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_shortName"><?php echo JText::_('COM_SPNAS_SHORT_NAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="jform_shortName" name="jform[shortName]" class="form-control required" required value="<?php echo $this->item->shortName; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_type"><?php echo JText::_('COM_SPNAS_TYPE'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6 ">
                        <select id="jform_type" name="jform[type]" class="form-control" required>
                            <option value="<?php echo $this->item->type; ?>" selected="true"><?php echo $this->item->type; ?></option>
                            <option value="Meraki" >Meraki</option>
                            <option value="Huawei">Huawei</option>
                            <option value="Galugs">Galgus</option>
                            <option value="Ignite">Ignite</option>
                            <option value="Ubiquiti">Ubiquiti</option>
                            <option value="Aruba">Aruba</option>
                            <option value="Ruckus">Ruckus</option>
                            <option value="Mikrotik">Mikrotik</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_secret"><?php echo JText::_('COM_SPNAS_SECRET'); ?></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="password" id="secret" name="jform[secret]" readonly="true" class="form-control" value="<?php echo '3Sm4rt1T'; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_ports"><?php echo JText::_('COM_SPNAS_PORTS'); ?></label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="jform_ports" name="jform[ports]" class="form-control" value="<?php echo $this->item->ports; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jfomr_server"><?php echo JText::_('COM_SPNAS_SERVER'); ?> </label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="jfomr_server" name="jform[server]" class="form-control" value="<?php echo $this->item->server; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_community"><?php echo JText::_('COM_SPNAS_COMMUNITY'); ?> </label>
                    <div class="col-md-3 col-sm-6">
                        <input type="text" id="jform_community" name="jform[community]" class="form-control" value="<?php echo $this->item->community; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform[description]"><?php echo JText::_('COM_SPNAS_DESCRIPTION'); ?> </label>
                    <div class="col-md-6 col-sm-6">
                        <textarea id="jform[description]" name="jform[description]" class="resizable_textarea form-control"><?php echo $this->item->description; ?></textarea>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a href="index.php?option=com_spnas&view=listnas" class="btn btn-secondary"><?php echo JText::_('Cancel'); ?></a>
                        <button onclick="Joomla.submitbutton('nas.save')" class="btn btn-success"><?php echo JText::_('Save'); ?></button>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="task" value="nas.save" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </div>
        </div>
    </div>
</form>

