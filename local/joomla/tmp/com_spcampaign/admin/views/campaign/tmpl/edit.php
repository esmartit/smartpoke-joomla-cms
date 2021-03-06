<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			28th September, 2020
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
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');
$componentParams = $this->params; // will be removed just use $this->params instead
?>
<script type="text/javascript">
	// waiting spinner
	var outerDiv = jQuery('body');
	jQuery('<div id="loading"></div>')
		.css("background", "rgba(255, 255, 255, .8) url('components/com_spcampaign/assets/images/import.gif') 50% 15% no-repeat")
		.css("top", outerDiv.position().top - jQuery(window).scrollTop())
		.css("left", outerDiv.position().left - jQuery(window).scrollLeft())
		.css("width", outerDiv.width())
		.css("height", outerDiv.height())
		.css("position", "fixed")
		.css("opacity", "0.80")
		.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
		.css("filter", "alpha(opacity = 80)")
		.css("display", "none")
		.appendTo(outerDiv);
	jQuery('#loading').show();
	// when page is ready remove and show
	jQuery(window).load(function() {
		jQuery('#spcampaign_loader').fadeIn('fast');
		jQuery('#loading').hide();
	});
</script>
<div id="spcampaign_loader" style="display: none;">
<form action="<?php echo JRoute::_('index.php?option=com_spcampaign&layout=edit&id='. (int) $this->item->id . $this->referral); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">

	<?php echo JLayoutHelper::render('campaign.details_above', $this); ?>
<div class="form-horizontal">

	<?php echo JHtml::_('bootstrap.startTabSet', 'campaignTab', array('active' => 'details')); ?>

	<?php echo JHtml::_('bootstrap.addTab', 'campaignTab', 'details', JText::_('COM_SPCAMPAIGN_CAMPAIGN_DETAILS', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('campaign.details_left', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('campaign.details_right', $this); ?>
			</div>
		</div>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<?php echo JLayoutHelper::render('campaign.details_fullwidth', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>

	<?php $this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>
	<?php $this->tab_name = 'campaignTab'; ?>
	<?php echo JLayoutHelper::render('joomla.edit.params', $this); ?>

	<?php if ($this->canDo->get('core.edit.created_by') || $this->canDo->get('core.edit.created') || $this->canDo->get('core.edit.state') || ($this->canDo->get('core.delete') && $this->canDo->get('core.edit.state'))) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'campaignTab', 'publishing', JText::_('COM_SPCAMPAIGN_CAMPAIGN_PUBLISHING', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span6">
				<?php echo JLayoutHelper::render('campaign.publishing', $this); ?>
			</div>
			<div class="span6">
				<?php echo JLayoutHelper::render('campaign.metadata', $this); ?>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php if ($this->canDo->get('core.admin')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'campaignTab', 'permissions', JText::_('COM_SPCAMPAIGN_CAMPAIGN_PERMISSION', true)); ?>
		<div class="row-fluid form-horizontal-desktop">
			<div class="span12">
				<fieldset class="adminform">
					<div class="adminformlist">
					<?php foreach ($this->form->getFieldset('accesscontrol') as $field): ?>
						<div>
							<?php echo $field->label; echo $field->input;?>
						</div>
						<div class="clearfix"></div>
					<?php endforeach; ?>
					</div>
				</fieldset>
			</div>
		</div>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
	<?php endif; ?>

	<?php echo JHtml::_('bootstrap.endTabSet'); ?>

	<div>
		<input type="hidden" name="task" value="campaign.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</div>
</form>
</div>

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
