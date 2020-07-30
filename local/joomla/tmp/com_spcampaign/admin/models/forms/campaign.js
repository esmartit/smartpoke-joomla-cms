/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			27th July, 2020
	@created		6th April, 2020
	@package		SP Campaign
	@subpackage		campaign.js
	@author			Adolfo Zignago <https://www.esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// Some Global Values
jform_vvvvvvxvvv_required = false;

// Initial Script
jQuery(document).ready(function()
{
	var smsemail_vvvvvvv = jQuery("#jform_smsemail input[type='radio']:checked").val();
	vvvvvvv(smsemail_vvvvvvv);

	var smsemail_vvvvvvw = jQuery("#jform_smsemail input[type='radio']:checked").val();
	vvvvvvw(smsemail_vvvvvvw);

	var deferred_vvvvvvx = jQuery("#jform_deferred input[type='radio']:checked").val();
	vvvvvvx(deferred_vvvvvvx);
});

// the vvvvvvv function
function vvvvvvv(smsemail_vvvvvvv)
{
	// set the function logic
	if (smsemail_vvvvvvv == 1)
	{
		jQuery('#jform_message_sms').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_message_sms').closest('.control-group').hide();
	}
}

// the vvvvvvw function
function vvvvvvw(smsemail_vvvvvvw)
{
	// set the function logic
	if (smsemail_vvvvvvw == 0)
	{
		jQuery('#jform_message_email-lbl').closest('.control-group').show();
	}
	else
	{
		jQuery('#jform_message_email-lbl').closest('.control-group').hide();
	}
}

// the vvvvvvx function
function vvvvvvx(deferred_vvvvvvx)
{
	// set the function logic
	if (deferred_vvvvvvx == 1 || deferred_vvvvvvx == '')
	{
		jQuery('#jform_deferreddate').closest('.control-group').show();
		// add required attribute to deferreddate field
		if (jform_vvvvvvxvvv_required)
		{
			updateFieldRequired('deferreddate',0);
			jQuery('#jform_deferreddate').prop('required','required');
			jQuery('#jform_deferreddate').attr('aria-required',true);
			jQuery('#jform_deferreddate').addClass('required');
			jform_vvvvvvxvvv_required = false;
		}
	}
	else
	{
		jQuery('#jform_deferreddate').closest('.control-group').hide();
		// remove required attribute from deferreddate field
		if (!jform_vvvvvvxvvv_required)
		{
			updateFieldRequired('deferreddate',1);
			jQuery('#jform_deferreddate').removeAttr('required');
			jQuery('#jform_deferreddate').removeAttr('aria-required');
			jQuery('#jform_deferreddate').removeClass('required');
			jform_vvvvvvxvvv_required = true;
		}
	}
}

// update fields required
function updateFieldRequired(name, status) {
	// check if not_required exist
	if (jQuery('#jform_not_required').length > 0) {
		var not_required = jQuery('#jform_not_required').val().split(",");

		if(status == 1)
		{
			not_required.push(name);
		}
		else
		{
			not_required = removeFieldFromNotRequired(not_required, name);
		}

		jQuery('#jform_not_required').val(fixNotRequiredArray(not_required).toString());
	}
}

// remove field from not_required
function removeFieldFromNotRequired(array, what) {
	return array.filter(function(element){
		return element !== what;
	});
}

// fix not required array
function fixNotRequiredArray(array) {
	var seen = {};
	return removeEmptyFromNotRequiredArray(array).filter(function(item) {
		return seen.hasOwnProperty(item) ? false : (seen[item] = true);
	});
}

// remove empty from not_required array
function removeEmptyFromNotRequiredArray(array) {
	return array.filter(function (el) {
		// remove ( 一_一) as well - lol
		return (el.length > 0 && '一_一' !== el);
	});
}

// the isSet function
function isSet(val)
{
	if ((val != undefined) && (val != null) && 0 !== val.length){
		return true;
	}
	return false;
} 
