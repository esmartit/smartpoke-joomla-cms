<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
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


/***[JCBGUI.site_view.php_view.46.$$$$]***/
$document = JFactory::getDocument();

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.46.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPLIMITATION_LIST_OF_LIMITATIONS'); ?><small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#">Settings 1</a>
                        <a class="dropdown-item" href="#">Settings 2</a>
                    </div>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <?php if ($this->user->authorise('core.create', 'com_splimitation')): ?>
            <button type="button" class="open-limitationModal btn btn-light" data-toggle="modal" data-target="#limitationModal" data-title="New" data-info='{"name":"", "maxUpload":"", "upload":"", "maxDownload":"", "download":"", "maxTraffic":"", "traffic":"", "urlRedirect":"", "accessPeriod":"", "period":"", "dailySession":"", "session":"", "option":"C"}'><?php echo JText::_('COM_SPLIMITATION_NEW_LIMITATION'); ?></button>
            <br />
        <?php endif; ?>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="headings">
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_NAME'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_MAX_UPLOAD'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_MAX_DOWNLOAD'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_MAX_TRAFFIC'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_URL_REDIRECT'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_ACCESS_PERIOD'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPLIMITATION_DAILY_SESSION'); ?></th>
                                <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPLIMITATION_ACTION'); ?></span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->items as $item): ?>
                                <?php
                                $canDo = SplimitationHelper::getActions('limitation',$item,'limitations');
                                ?>
                                <tr>
                                    <td class="a-right a-right "><?php echo $item->name; ?></td>
                                    <td class="a-right a-right "><?php echo $item->maxUpload->value.' '.$item->maxUpload->rate; ?></td>
                                    <td class="a-right a-right "><?php echo $item->maxDownload->value.' '.$item->maxDownload->rate; ?></td>
                                    <td class="a-right a-right "><?php echo $item->maxTraffic->value.' '.$item->maxTraffic->traffic; ?></td>
                                    <td class="a-right a-right "><?php echo $item->urlRedirect; ?></td>
                                    <td class="a-right a-right "><?php echo $item->accessPeriod->value.' '.$item->accessPeriod->period; ?></td>
                                    <td class="a-right a-right "><?php echo $item->dailySession->value.' '.$item->dailySession->period; ?></td>
                                    <td class=" last">
                                        <a type="button" class="open-limitationModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#limitationModal" data-title="View" data-info='{"name":"<?php echo $item->name; ?>", "maxUpload":"<?php echo $item->maxUpload->value; ?>", "upload":"<?php echo $item->maxUpload->rate; ?>", "maxDownload":"<?php echo $item->maxDownload->value; ?>", "download":"<?php echo $item->maxDownload->rate; ?>", "maxTraffic":"<?php echo $item->maxTraffic->value; ?>", "traffic":"<?php echo $item->maxTraffic->traffic; ?>", "urlRedirect":"<?php echo $item->urlRedirect; ?>", "accessPeriod":"<?php echo $item->accessPeriod->value; ?>", "period":"<?php echo $item->accessPeriod->period; ?>", "dailySession":"<?php echo $item->dailySession->value; ?>", "session":"<?php echo $item->dailySession->period; ?>", "option":"R"}'><i class="fa fa-eye"></i></a>
                                        <?php if ($canDo->get('core.edit')): ?>
                                            <a type="button" class="open-limitationModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#limitationModal" data-title="Edit" data-info='{"name":"<?php echo $item->name; ?>", "maxUpload":"<?php echo $item->maxUpload->value; ?>", "upload":"<?php echo $item->maxUpload->rate; ?>", "maxDownload":"<?php echo $item->maxDownload->value; ?>", "download":"<?php echo $item->maxDownload->rate; ?>", "maxTraffic":"<?php echo $item->maxTraffic->value; ?>", "traffic":"<?php echo $item->maxTraffic->traffic; ?>", "urlRedirect":"<?php echo $item->urlRedirect; ?>", "accessPeriod":"<?php echo $item->accessPeriod->value; ?>", "period":"<?php echo $item->accessPeriod->period; ?>", "dailySession":"<?php echo $item->dailySession->value; ?>", "session":"<?php echo $item->dailySession->period; ?>", "option":"U"}'><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if ($canDo->get('core.delete')): ?>
                                            <a type="button" class="open-limitationModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#limitationModal" data-title="Delete" data-info='{"name":"<?php echo $item->name; ?>", "maxUpload":"<?php echo $item->maxUpload->value; ?>", "upload":"<?php echo $item->maxUpload->rate; ?>", "maxDownload":"<?php echo $item->maxDownload->value; ?>", "download":"<?php echo $item->maxDownload->rate; ?>", "maxTraffic":"<?php echo $item->maxTraffic->value; ?>", "traffic":"<?php echo $item->maxTraffic->traffic; ?>", "urlRedirect":"<?php echo $item->urlRedirect; ?>", "accessPeriod":"<?php echo $item->accessPeriod->value; ?>", "period":"<?php echo $item->accessPeriod->period; ?>", "dailySession":"<?php echo $item->dailySession->value; ?>", "session":"<?php echo $item->dailySession->period; ?>", "option":"D"}'><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="limitationModal" tabindex="-1" role="dialog" aria-labelledby="limitationModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="limitationModalLabel">Limitation</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modalForm" class="form-horizontal form-label-left">
                    <div class="item form-group">
                        <div class="col-md-6 col-sm-6">
                            <input type="hidden" class="form-control" id="id">
                            <input type="hidden" class="form-control" id="option">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="name"><?php echo JText::_('COM_SPLIMITATION_NAME'); ?></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <input type="text" id="name" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="maxUpload"><?php echo JText::_('COM_SPLIMITATION_MAX_UPLOAD'); ?></label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="maxUpload" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <select id="selUpload" class="btn btn-default" name="upload">
                                <option value="" selected disabled><?php echo JText::_('COM_SPLIMITATION_SELECT_UPLOAD'); ?></option>
                                <option value="KBPS">KBPS</option>
                                <option value="MBPS">MBPS</option>
                                <option value="GBPS">GBPS</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="maxDownload"><?php echo JText::_('COM_SPLIMITATION_MAX_DOWNLOAD'); ?> </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="maxDownload" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <select id="selDownload" class="btn btn-default" name="download">
                                <option value="" selected disabled><?php echo JText::_('COM_SPLIMITATION_SELECT_DOWNLOAD'); ?></option>
                                <option value="KBPS">KBPS</option>
                                <option value="MBPS">MBPS</option>
                                <option value="GBPS">GBPS</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="maxTraffic"><?php echo JText::_('COM_SPLIMITATION_MAX_TRAFFIC'); ?></label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="maxTraffic" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <select id="selTraffic" class="btn btn-default" name="traffic">
                                <option value="" selected disabled><?php echo JText::_('COM_SPLIMITATION_SELECT_TRAFFIC'); ?></option>
                                <option value="KB">KB</option>
                                <option value="MB">MB</option>
                                <option value="GB">GB</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="urlRedirect"><?php echo JText::_('COM_SPLIMITATION_URL_REDIRECT'); ?> </label>
                        <div class="col-md-6 col-sm-6 ">
                            <input type="text" id="urlRedirect" class="form-control">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="accessPeriod"><?php echo JText::_('COM_SPLIMITATION_ACCESS_PERIOD'); ?></label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="accessPeriod" class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <select id="selPeriod" class="btn btn-default" name="period">
                                <option value="" selected disabled><?php echo JText::_('COM_SPLIMITATION_SELECT_PERIOD'); ?></option>
                                <option value="MINUTES">MINUTES</option>
                                <option value="HOURS">HOURS</option>
                                <option value="DAYS">DAYS</option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align" for="dailySession"><?php echo JText::_('COM_SPLIMITATION_DAILY_SESSION'); ?> </label>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <input type="text" id="dailySession"class="form-control">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-12">
                            <select id="selSession" class="btn btn-default" name="session">
                                <option value="" selected disabled><?php echo JText::_('COM_SPLIMITATION_SELECT_SESSION'); ?></option>
                                <option value="MINUTES">MINUTES</option>
                                <option value="HOURS">HOURS</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPLIMITATION_CLOSE'); ?></button>
                        <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPLIMITATION_SAVE'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

