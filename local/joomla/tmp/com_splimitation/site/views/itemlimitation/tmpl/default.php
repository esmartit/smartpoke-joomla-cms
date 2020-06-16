<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			15th June, 2020
	@created		12th June, 2020
	@package		SP Limitation
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


/***[JCBGUI.site_view.php_view.47.$$$$]***/
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.47.$$$$]-->
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPLIMITATION_VIEW_LIMITATION'); ?><small></small></h2>
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
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="name"><?php echo JText::_('COM_SPLIMITATION_NAME'); ?> <span class="required">*</span></label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" id="name" disabled class="form-control " value="<?php echo $this->item->name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="maxupload"><?php echo JText::_('COM_SPLIMITATION_MAX_UPLOAD'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="maxupload" disabled class="form-control " value="<?php echo $this->item->maxUpload->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selValueUp" class="btn btn-default" disabled name="valueUpload">
                            <option value="<?php echo $this->item->maxUpload->rate; ?>" selected="true"><?php echo $this->item->maxUpload->rate; ?></option>
                            <option value="KBPS">KBPS</option>
                            <option value="MBPS">MBPS</option>
                            <option value="GBPS">GBPS</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="maxdownload"><?php echo JText::_('COM_SPLIMITATION_MAX_DOWNLOAD'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="maxdownload" disabled class="form-control " value="<?php echo $this->item->maxDownload->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selValueDown" class="btn btn-default" disabled name="valueDownload">
                            <option value="<?php echo $this->item->maxDownload->rate; ?>" selected="true"><?php echo $this->item->maxDownload->rate; ?></option>
                            <option value="KBPS">KBPS</option>
                            <option value="MBPS">MBPS</option>
                            <option value="GBPS">GBPS</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="maxtraffic"><?php echo JText::_('COM_SPLIMITATION_MAX_TRAFFIC'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="maxtraffic" disabled class="form-control " value="<?php echo $this->item->maxTraffic->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selValueTraffic" class="btn btn-default" disabled name="valueTraffic">
                            <option value="<?php echo $this->item->maxTraffic->traffic; ?>" selected="true"><?php echo $this->item->maxTraffic->traffic; ?></option>
                            <option value="KB">KB</option>
                            <option value="MB">MB</option>
                            <option value="GB">GB</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="urlredirect"><?php echo JText::_('COM_SPLIMITATION_URL_REDIRECT'); ?> </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="text" id="urlredirect" disabled class="form-control " value="<?php echo $this->item->urlRedirect; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="accessperiod"><?php echo JText::_('COM_SPLIMITATION_ACCESS_PERIOD'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="accessperiod" disabled class="form-control " value="<?php echo $this->item->accessPeriod->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selAccessPeriod" class="btn btn-default" disabled name="valueAccessPeriod">
                            <option value="<?php echo $this->item->accessPeriod->period; ?>" selected="true"><?php echo $this->item->accessPeriod->period; ?></option>
                            <option value="MINUTES">MINUTES</option>
                            <option value="HOURS">HOURS</option>
                            <option value="DAYS">DAYS</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="dailysession"><?php echo JText::_('COM_SPLIMITATION_DAILY_SESSION'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="dailysession" disabled class="form-control " value="<?php echo $this->item->dailySession->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selDailySession" class="btn btn-default" disabled name="valueDailySession">
                            <option value="<?php echo $this->item->dailySession->period; ?>" selected="true"><?php echo $this->item->dailySession->period; ?></option>
                            <option value="MINUTES">MINUTES</option>
                            <option value="HOURS">HOURS</option>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-light" href="index.php?option=com_splimitation&view=listlimitation"><?php echo JText::_('COM_SPLIMITATION_BACK'); ?></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

