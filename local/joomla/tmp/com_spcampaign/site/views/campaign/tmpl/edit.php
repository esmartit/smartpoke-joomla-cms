<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		6th April, 2020
	@package		SP Campaign
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

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
//JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
//JHtml::_('behavior.tabstate');
JHtml::_('behavior.calendar');
$componentParams = $this->params; // will be removed just use $this->params instead

$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');

?>
<?php //echo $this->toolbar->render(); ?>
<form action="<?php echo JRoute::_('index.php?option=com_spcampaign&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($this->item->id == 0): ?>
                    <h2><?php echo JText::_('New Campaign'); ?><small></small></h2>
                <?php else: ?>
                    <h2><?php echo JText::_('Edit Campaign'); ?><small></small></h2>
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
                    <label class="col-form-label col-md-1 col-sm-1 label-align"></label>
                    <div class="col-md-3 col-sm-6">
                        <?php echo JLayoutHelper::render('campaign.details_above', $this); ?>
                    </div>
                </div>

                <div class="item form-group">
                    <label class="col-form-label col-md-1 col-sm-1 label-align"></label>
                    <div class="col-md-6 col-sm-6">
                        <?php echo JLayoutHelper::render('campaign.details_left', $this); ?>
                        <?php echo JLayoutHelper::render('campaign.details_fullwidth', $this); ?>
                    </div>
                    <label class="col-form-label col-md-1 col-sm-1 label-align"></label>
                    <div class="col-md-3 col-sm-6">
                        <?php echo JLayoutHelper::render('campaign.details_right', $this); ?>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-1 col-sm-1 label-align"></label>
                    <div class="col-md-9 col-sm-6">
                        <?php if ($this->canDo->get('core.delete') || $this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.state') || $this->canDo->get('core.edit.created')) : ?>
                            <?php echo JLayoutHelper::render('campaign.publishing', $this); ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a href="index.php?option=com_spcampaign&view=listcampaign" class="btn btn-secondary"><?php echo JText::_('Cancel'); ?></a>
                        <button onclick="Joomla.submitbutton('campaign.save');" class="btn btn-success"><?php echo JText::_('Save'); ?></button>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="task" value="campaign.save" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">

// #jform_smsemail listeners for smsemail_vvvvvvv function
jQuery('#jform_smsemail').on('keyup',function()
{
	var smsemail_vvvvvvv = jQuery("#jform_smsemail input[type='radio']:checked").val();
	vvvvvvv(smsemail_vvvvvvv);

});
jQuery('#adminForm').on('change', '#jform_smsemail',function (e)
{
	e.preventDefault();
	var smsemail_vvvvvvv = jQuery("#jform_smsemail input[type='radio']:checked").val();
	vvvvvvv(smsemail_vvvvvvv);

});

// #jform_smsemail listeners for smsemail_vvvvvvw function
jQuery('#jform_smsemail').on('keyup',function()
{
	var smsemail_vvvvvvw = jQuery("#jform_smsemail input[type='radio']:checked").val();
	vvvvvvw(smsemail_vvvvvvw);

});
jQuery('#adminForm').on('change', '#jform_smsemail',function (e)
{
	e.preventDefault();
	var smsemail_vvvvvvw = jQuery("#jform_smsemail input[type='radio']:checked").val();
	vvvvvvw(smsemail_vvvvvvw);

});

// #jform_deferred listeners for deferred_vvvvvvx function
jQuery('#jform_deferred').on('keyup',function()
{
	var deferred_vvvvvvx = jQuery("#jform_deferred input[type='radio']:checked").val();
	vvvvvvx(deferred_vvvvvvx);

});
jQuery('#adminForm').on('change', '#jform_deferred',function (e)
{
	e.preventDefault();
	var deferred_vvvvvvx = jQuery("#jform_deferred input[type='radio']:checked").val();
	vvvvvvx(deferred_vvvvvvx);

});

</script>
