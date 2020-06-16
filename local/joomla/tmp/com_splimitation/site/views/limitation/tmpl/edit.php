<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			15th June, 2020
	@created		12th June, 2020
	@package		SP Limitation
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

if ($this->item->name == '') {
    $this->item->maxUpload->rate = 'MBPS';
    $this->item->maxDownload->rate = 'MBPS';
    $this->item->maxTraffic->traffic = 'MB';
    $this->item->accessPeriod->period = 'MINUTES';
    $this->item->dailySession->period = 'MINUTES';
}

?>
<?php //echo $this->toolbar->render(); ?>
<form action="<?php echo JRoute::_('index.php?option=com_splimitation&layout=edit&name='. (string) $this->item->name ); ?>" method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
    <div class="col-md-12 col-sm-12 ">
        <div class="x_panel">
            <div class="x_title">
                <?php if ($this->item->name != ''): ?>
                    <h2><?php echo JText::_('New Limitation'); ?><small></small></h2>
                <?php else: ?>
                    <h2><?php echo JText::_('Edit Limitation'); ?><small></small></h2>
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
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_name"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_NAME_LABEL'); ?> </label>
                    <div class="col-md-4 col-sm-4 col-xs-12">
                        <input type="text" id="jform_name" name="jform[name]" class="form-control" value="<?php echo $this->item->name; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_maxupload"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_MAXUPLOAD_LABEL'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="jform_maxupload" name="jform[maxupload]" class="form-control" value="<?php echo $this->item->maxUpload->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selValueUp" class="btn btn-default" name="valueUpload">
                            <option value="<?php echo $this->item->maxUpload->rate; ?>" selected="true"><?php echo $this->item->maxUpload->rate; ?></option>
                            <option value="KBPS">KBPS</option>
                            <option value="MBPS">MBPS</option>
                            <option value="GBPS">GBPS</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_maxdownload"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_MAXDOWNLOAD_LABEL'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="jform_maxdownload" name="jform[maxdownload]" class="form-control" value="<?php echo $this->item->maxDownload->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selValueDown" class="btn btn-default" name="valueDownload">
                            <option value="<?php echo $this->item->maxDownload->rate; ?>" selected="true"><?php echo $this->item->maxDownload->rate; ?></option>
                            <option value="KBPS">KBPS</option>
                            <option value="MBPS">MBPS</option>
                            <option value="GBPS">GBPS</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_maxtraffic"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_MAXTRAFFIC_LABEL'); ?></label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="jform_maxtraffic" name="jform[maxtraffic]" class="form-control" value="<?php echo $this->item->maxTraffic->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selValueTraffic" class="btn btn-default" name="valueTraffic">
                            <option value="<?php echo $this->item->maxTraffic->traffic; ?>" selected="true"><?php echo $this->item->maxTraffic->traffic; ?></option>
                            <option value="KB">KB</option>
                            <option value="MB">MB</option>
                            <option value="GB">GB</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jfomr_urlredirect"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_URLREDIRECT_LABEL'); ?> </label>
                    <div class="col-md-6 col-sm-6 ">
                        <input type="text" id="jfomr_urlredirect" name="jform[urlredirect]" class="form-control" value="<?php echo $this->item->urlRedirect; ?>">
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_accessperiod"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_ACCESSPERIOD_LABEL'); ?></label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="jform_accessperiod" name="jform[accessperiod]" class="form-control" value="<?php echo $this->item->accessPeriod->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selAccessPeriod" class="btn btn-default" name="valueAccessPeriod">
                            <option value="<?php echo $this->item->accessPeriod->period; ?>" selected="true"><?php echo $this->item->accessPeriod->period; ?></option>
                            <option value="MINUTES">MINUTES</option>
                            <option value="HOURS">HOURS</option>
                            <option value="DAYS">DAYS</option>
                        </select>
                    </div>
                </div>
                <div class="item form-group">
                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="jform_dailysession"><?php echo JText::_('COM_SPLIMITATION_LIMITATION_DAILYSESSION_LABEL'); ?> </label>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <input type="text" id="jform_dailysession" name="jform[dailysession]" class="form-control" value="<?php echo $this->item->dailySession->value; ?>">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-12">
                        <select id="selDailySession" class="btn btn-default" name="valueDailySession">
                            <option value="<?php echo $this->item->dailySession->period; ?>" selected="true"><?php echo $this->item->dailySession->period; ?></option>
                            <option value="MINUTES">MINUTES</option>
                            <option value="HOURS">HOURS</option>
                        </select>
                    </div>
                </div>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a href="index.php?option=com_splimitation&view=listlimitation" class="btn btn-secondary"><?php echo JText::_('Cancel'); ?></a>
                        <button onclick="Joomla.submitbutton('limitation.save')" class="btn btn-success"><?php echo JText::_('Save'); ?></button>
                    </div>
                </div>
                <div>
                    <input type="hidden" name="task" value="limitation.save" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </div>
        </div>
    </div>
</form>

