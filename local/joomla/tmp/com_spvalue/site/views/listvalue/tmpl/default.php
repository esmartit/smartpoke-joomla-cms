<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			30th July, 2020
	@created		14th April, 2020
	@package		SP Value
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


/***[JCBGUI.site_view.php_view.32.$$$$]***/
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

<!--[JCBGUI.site_view.default.32.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPVALUE_LIST_OF_VALUES'); ?><small></small></h2>
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
            <?php if ($this->user->authorise('core.create', 'com_spvalue')): ?>
                <button type="button" class="open-valueModal btn btn-light" data-toggle="modal" data-target="#valueModal" data-title="New" data-info='{"id":"", "code":"", "name":"", "value":"", "option":"C"}'><?php echo JText::_('COM_SPVALUE_NEW_VALUE'); ?></button>
                <br />
            <?php endif; ?>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr class="headings">
                                    <th class='column-title'><?php echo JText::_('COM_SPVALUE_NAME'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPVALUE_CODE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPVALUE_VALUE'); ?></th>
                                    <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPVALUE_ACTION'); ?></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($this->items as $item): ?>
                                    <?php
                                        $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
                                        $userChkOut = JFactory::getUser($item->checked_out);
                                        $canDo = SpvalueHelper::getActions('value',$item,'values');
                                    ?>
                                    <tr>
                                        <td class=""><?php echo $item->name; ?></td>
                                        <td class=""><?php echo $item->code_value; ?></td>
                                        <td class=""><?php echo $item->value; ?></td>
                                        <td class=" last">
                                            <a type="button" class="open-valueModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#valueModal" data-title="View" data-info='{"id":"<?php echo $item->id; ?>", "code":"<?php echo $item->code_value; ?>", "name":"<?php echo $item->name; ?>", "value":"<?php echo $item->value; ?>", "option":"R"}'><i class="fa fa-eye"></i></a>
                                            <?php if ($canDo->get('core.edit')): ?>
                                                <a type="button" class="open-valueModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#valueModal" data-title="Edit" data-info='{"id":"<?php echo $item->id; ?>", "code":"<?php echo $item->code_value; ?>", "name":"<?php echo $item->name; ?>", "value":"<?php echo $item->value; ?>", "option":"U"}'><i class="fa fa-edit"></i></a>
                                            <?php endif; ?>
                                            <?php if ($canDo->get('core.delete')): ?>
                                                <a type="button" class="open-valueModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#valueModal" data-title="Delete" data-info='{"id":"<?php echo $item->id; ?>", "code":"<?php echo $item->code_value; ?>", "name":"<?php echo $item->name; ?>", "value":"<?php echo $item->value; ?>", "option":"D"}'><i class="fa fa-trash"></i></a>
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

<div class="modal fade" id="valueModal" tabindex="-1" role="dialog" aria-labelledby="valueModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="valueModalLabel">Value</h5>
                <button type="button" class="close" data-dismiss="modal" onclick="closeModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="modalForm" class="form-horizontal form-label-left>
                    <div class="item form-group">
                <div class="col-md-6 col-sm-6">
                    <input type="hidden" class="form-control" id="id">
                    <input type="hidden" class="form-control" id="option">
                </div>
            </div>
            <div class="item form-group">
                <label for="name" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPVALUE_NAME'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" id="name" required="required">
                </div>
            </div>
            <div class="item form-group">
                <label for="code" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPVALUE_CODE'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" id="code" required="required">
                </div>
            </div>
            <div class="item form-group">
                <label for="value" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPVALUE_VALUE'); ?><span class="required">*</span></label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" class="form-control" id="value" required="required">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPVALUE_CLOSE'); ?></button>
                <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPVALUE_SAVE'); ?></button>
            </div>
            </form>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

