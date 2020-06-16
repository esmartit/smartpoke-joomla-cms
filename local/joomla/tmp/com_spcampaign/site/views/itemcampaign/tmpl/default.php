<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			16th June, 2020
	@created		6th April, 2020
	@package		SP Campaign
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


/***[JCBGUI.site_view.php_view.41.$$$$]***/
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.41.$$$$]-->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPCAMPAIGN_VIEW_CAMPAIGN'); ?><small></small></h2>
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
            <form id="newCampaign" data-parsley-validate class="form-horizontal form-label-left">
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="campaign"><?php echo JText::_('COM_SPCAMPAIGN_CAMPAIGN'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="campaign" disabled class="form-control " value="<?php echo $this->item->name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="validdate"><?php echo JText::_('COM_SPCAMPAIGN_VALID_DATE'); ?> <span class="required">*</span></label>
                    <div class="col-md-4 col-sm-4 ">
                        <div class='input-group date' id='validdate'>
                            <input type='text' class="form-control" readonly="readonly" value="<?php echo $this->item->validdate; ?>"/>
                            <span class="input-group-addon">
                               <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_SMSEMAIL'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php if ($this->item->smsemail == 0)
                            {
                                $value_e = 0;
                                $checked_e = 'checked';
                                $focus_e = 'focus';
                                $checked_s = '';
                                $focus_s = '';
                            } else {
                                $value_s = 1;
                                $checked_s = 'checked';
                                $focus_s = 'focus';
                                $checked_e = '';
                                $focus_e = '';
                            }
                        ?>
                        <div id="type" class="btn-group" data-toggle="buttons">
                            <label class="btn btn-secondary <?php echo $focus_s; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="type" value="<?php echo $value_s; ?>" <?php echo $checked_s; ?> class="join-btn"> <?php echo JText::_('SMS'); ?>
                            </label>
                            <label class="btn btn-primary <?php echo $focus_e; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="type" value="<?php echo $value_e; ?>" <?php echo $checked_e; ?> class="join-btn"> <?php echo JText::_('COM_SPCAMPAIGN_EMAIL'); ?>
                            </label>                        
                        </div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="campaign"><?php echo JText::_('COM_SPCAMPAIGN_TYPE'); ?> <span class="required">*</span></label>
                    <div class="col-md-3 col-sm-6 ">
                        <input type="text" id="type" disabled class="form-control " value="<?php echo $this->item->type; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="message"><?php echo JText::_('COM_SPCAMPAIGN_MESSAGE'); ?> <span class="required">*</span></label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php if ($this->item->smsemail == 0) {
                            $message = $this->item->message_email;
                        } else {
                            $message = $this->item->message_sms;
                        }; ?>
                        <div class="text-body" id="message"><?php echo $message; ?></div>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_DEFERRED'); ?> </label>
                    <div class="col-md-6 col-sm-6 ">
                        <?php if ($this->item->deferred == 0)
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
                                <input type="radio" name="deferred" value="<?php echo $value_y; ?>" <?php echo $checked_y; ?> class="join-btn"> <?php echo JText::_('COM_SPCAMPAIGN_YES'); ?>
                            </label>
                            <label class="btn btn-primary <?php echo $focus_n; ?>" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
                                <input type="radio" name="deferred" value="<?php echo $value_n; ?>" <?php echo $checked_n; ?> class="join-btn"> <?php echo JText::_('COM_SPCAMPAIGN_NO'); ?>
                            </label>                        
                        </div>
                    </div>
                </div>
                <?php if ($this->item->deferred == 1): ?>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="deferreddate"><?php echo JText::_('COM_SPCAMPAIGN_DEFERRED_DATE'); ?> <span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 ">
                            <div class='input-group date' id='deferreddate'>
                                <input type='text' class="form-control" readonly="readonly" value="<?php echo $this->item-> deferreddate; ?>"/>
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-light" href="index.php?option=com_spcampaign&view=listcampaign"><?php echo JText::_('COM_SPCAMPAIGN_BACK'); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

