<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
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


/***[JCBGUI.site_view.php_view.40.$$$$]***/
$document = JFactory::getDocument();

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');

//  bootstrap-wysiwyg
$document->addStyleSheet('/templates/smartpokex/vendors/google-code-prettify/bin/prettify.min.css');
//  Switchery
$document->addStyleSheet('/templates/smartpokex/vendors/switchery/dist/switchery.min.css');

// bootstrap-daterangepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.css');
// bootstrap-datetimepicker
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');

// bootstrap-daterangepicker
$document->addScript('/templates/smartpokex/vendors/moment/min/moment.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-daterangepicker/daterangepicker.js');
// bootstrap-datetimepicker
$document->addScript('/templates/smartpokex/vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');

// iCheck
$document->addScript('/templates/smartpokex/vendors/iCheck/icheck.min.js');

// bootstrap-wysiwyg
$document->addScript('/templates/smartpokex/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js');
$document->addScript('/templates/smartpokex/vendors/jquery.hotkeys/jquery.hotkeys.js');
$document->addScript('/templates/smartpokex/vendors/google-code-prettify/src/prettify.js');
// Switchery
$document->addScript('/templates/smartpokex/vendors/switchery/dist/switchery.min.js');

$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');/***[/JCBGUI$$$$]***/


?>
<?php echo $this->toolbar->render(); ?>

<!--[JCBGUI.site_view.default.40.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPCAMPAIGN_LIST_OF_CAMPAIGN'); ?><small></small></h2>
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
            <?php if ($this->user->authorise('core.create', 'com_spcampaign')): ?>
                <button type="button" class="open-campaignModal btn btn-light" data-toggle="modal" data-target="#campaignModal" data-title="New" data-info='{"id":"", "name":"", "validDate":"", "smsEmail":"", "messageSms":"", "messageEmail":"", "type":"", "deferred":"",  "deferredDate":"", "option":"C"}'><?php echo JText::_('COM_SPCAMPAIGN_NEW_CAMPAIGN'); ?></button>
                <br />
            <?php endif; ?>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr class="headings">
                                    <th class='column-title'><?php echo JText::_('Id'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_CAMPAIGN'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_VALID_DATE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_SMSEMAIL'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_TYPE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_PERCENT'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_DEFERRED'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCAMPAIGN_DEFERRED_DATE'); ?></th>
                                    <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPCAMPAIGN_ACTION'); ?></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($this->items as $item): ?>
                                    <?php
                                        $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
                                        $userChkOut = JFactory::getUser($item->checked_out);
                                        $canDo = SpcampaignHelper::getActions('campaign',$item,'campaigns');
                                    ?>
                                    <tr>
                                        <td class="a-right a-right "><?php echo $item->id; ?></td>
                                        <td class="a-right a-right "><?php echo $item->name; ?></td>
                                        <td align="center"><?php echo $item->validdate; ?></td>
                                        <?php if ($item->smsemail == 0): ?>
                                            <td class=""><div align='center'><?php echo JText::_('COM_SPCAMPAIGN_EMAIL'); ?> <span class='fa fa-envelope'></span></div></td>
                                        <?php else : ?>
                                            <td class=""><div align='center'><?php echo JText::_('SMS'); ?> <span class='fa fa-comment'></span></div></td>
                                        <?php endif; ?>
                                        <td class="a-right a-right "><?php echo $item->type; ?></td>
                                        <td align="center"><?php echo $item->percent; ?> %</td>
                                        <?php if ($item->deferred == 0): ?>
                                            <td align="center"><input type="checkbox" class="js-switch" disabled="disabled" /></td>
                                            <td class=""></td>
                                        <?php else : ?>
                                            <td align="center"><input type="checkbox" class="js-switch" disabled="disabled" checked="checked" /> <span class="glyphicon glyphicon-time"></span></td>
                                            <td align="center"><?php echo $item->deferreddate; ?></td>
                                        <?php endif; ?>
                                        <td class=" last">
                                            <a type="button" class="open-campaignModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#campaignModal" data-title="View" data-info='{"id":"<?php echo $item->id; ?>", "name":"<?php echo $item->name; ?>", "validDate":"<?php echo $item->validdate; ?>", "smsEmail":"<?php echo $item->smsemail; ?>", "messageSms":"<?php echo $item->message_sms; ?>", "messageEmail":"<?php echo $item->message_email; ?>", "type":"<?php echo $item->type; ?>", "deferred":"<?php echo $item->deferred; ?>",  "deferredDate":"<?php echo $item->deferreddate; ?>", "option":"R"}'><i class="fa fa-eye"></i></a>
                                            <?php if ($canDo->get('core.edit')): ?>
                                                <a type="button" class="open-campaignModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#campaignModal" data-title="Edit" data-info='{"id":"<?php echo $item->id; ?>", "name":"<?php echo $item->name; ?>", "validDate":"<?php echo $item->validdate; ?>", "smsEmail":"<?php echo $item->smsemail; ?>", "messageSms":"<?php echo $item->message_sms; ?>", "messageEmail":"<?php echo $item->message_email; ?>", "type":"<?php echo $item->type; ?>", "deferred":"<?php echo $item->deferred; ?>",  "deferredDate":"<?php echo $item->deferreddate; ?>", "option":"U"}'><i class="fa fa-edit"></i></a>
                                            <?php endif; ?>
                                            <?php if ($canDo->get('core.delete')): ?>
                                                <a type="button" class="open-campaignModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#campaignModal" data-title="Delete" data-info='{"id":"<?php echo $item->id; ?>", "name":"<?php echo $item->name; ?>", "validDate":"<?php echo $item->validdate; ?>", "smsEmail":"<?php echo $item->smsemail; ?>", "messageSms":"<?php echo $item->message_sms; ?>", "messageEmail":"<?php echo $item->message_email; ?>", "type":"<?php echo $item->type; ?>", "deferred":"<?php echo $item->deferred; ?>",  "deferredDate":"<?php echo $item->deferreddate; ?>", "option":"D"}'><i class="fa fa-trash"></i></a>
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
</div>

<div class="modal fade" id="campaignModal" tabindex="-1" role="dialog" aria-labelledby="campaignModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="campaignModalLabel">Campaign</h5>
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
                        <label for="name" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_CAMPAIGN'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="name" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="validDate" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_VALID_DATE'); ?><span class="required">*</span></label>
                        <div class="col-md-4 col-sm-4 input-group date" id="validD">
                            <input type='text' class="form-control" id="validDate">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </span>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="smsEmail" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_SMSEMAIL'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <div class="btn-group btn-group-toggle selSmsEmail" data-toggle="buttons">
                                <label class="btn btn-secondary">
                                    <input type="radio" value="1" id="radioSMS" name="radioCampaign"> <?php echo JText::_('SMS'); ?>
                                </label>
                                <label class="btn btn-success">
                                    <input type="radio" value="0" id="radioEmail" name="radioCampaign"> <?php echo JText::_('COM_SPCAMPAIGN_EMAIL'); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <div id="messageText" class="col-md-12 col-sm-12">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#msgType">
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                    <ul class="dropdown-menu"></ul>
                                </div>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a data-edit="fontSize 5">
                                                <p style="font-size:17px">Huge</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-edit="fontSize 3">
                                                <p style="font-size:14px">Normal</p>
                                            </a>
                                        </li>
                                        <li>
                                            <a data-edit="fontSize 1">
                                                <p style="font-size:11px">Small</p>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="btn-group">
                                    <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
                                    <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
                                    <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
                                    <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
                                    <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
                                    <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
                                    <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
                                    <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
                                    <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
                                    <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                    <div class="dropdown-menu input-append">
                                        <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                        <button class="btn" type="button">Add</button>
                                    </div>
                                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
                                </div>
                                <div class="btn-group">
                                    <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                </div>
                                <div class="btn-group">
                                    <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
                                    <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
                                </div>
                            </div>
                            <div id="msgType" class="editor-wrapper"></div>

                            <textarea name="descr" id="descr" style="display:none;"></textarea>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_TYPE'); ?><span class="required">*</span></label>
                        <div class="col-md-3 col-sm-3">
                            <select id="selType" class="form-control" name="type">
                                <option value="" selected disabled><?php echo JText::_('COM_SPCAMPAIGN_SELECT_TYPE'); ?></option>
                                <option value="LOGIN"><?php echo JText::_('COM_SPCAMPAIGN_LOGIN'); ?></option>
                                <option value="REGISTER"><?php echo JText::_('COM_SPCAMPAIGN_REGISTER'); ?></option>
                                <option value="CAMPAIGN"><?php echo JText::_('COM_SPCAMPAIGN_CAMPAIGN'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_DEFERRED'); ?></label>
                        <div class="col-md-3 col-sm-3">
                            <div class="checkbox">
                                <input id="deferred" name="deferred" type="checkbox" class="flat">
                            </div>
                        </div>
                    </div>
                    <div class="item form-group">
                        <div class="col-md-12 col-sm-12" id="dateDeferred" style="display: none">
                            <label for="deferredDate" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPCAMPAIGN_DEFERRED_DATE'); ?><span class="required">*</span></label>
                            <div class="col-md-6 col-sm-6 input-group date" id="deferredD">
                                <input type='text' class="form-control" id="deferredDate">
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPCAMPAIGN_CLOSE'); ?></button>
                        <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPCAMPAIGN_SAVE'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

