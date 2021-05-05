<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			12th August, 2020
	@created		7th April, 2020
	@package		SP Nas
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


/***[JCBGUI.site_view.php_view.44.$$$$]***/
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

<!--[JCBGUI.site_view.default.44.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPNAS_LIST_OF_NASES'); ?><small></small></h2>
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
        <?php if ($this->user->authorise('core.create', 'com_spnas')): ?>
            <button type="button" class="open-nasModal btn btn-light" data-toggle="modal" data-target="#nasModal" data-title="New" data-info='{"id":"", "name":"", "shortName":"", "type":"", "secret":"", "ports":"", "server":"", "community":"",  "description":"", "option":"C"}'><?php echo JText::_('COM_SPNAS_NEW_NAS'); ?></button>
            <br />
        <?php endif; ?>
        <div class="x_content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                            <tr class="headings">
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_NAS_NAMEIP'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_SHORTNAME'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_TYPE'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_SECRET'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_PORTS'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_SERVER'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_COMMUNITY'); ?></th>
                                <th class='column-title'><?php echo JText::_('COM_SPNAS_DESCRIPTION'); ?></th>
                                <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPNAS_ACTION'); ?></span></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($this->items as $item): ?>
                                <?php
//                                $canDo = SpnasHelper::getActions('nas',$item,'nases');
                                ?>
                                <tr>
                                    <td class="a-right a-right"><?php echo $item->name; ?></td>
                                    <td class="a-right a-righ"><?php echo $item->shortName; ?></td>
                                    <td class="a-right a-right"><?php echo $item->type; ?></td>
                                    <td class="a-right a-right"><input type="password" disabled value="<?php echo $item->secret; ?>"></td>
                                    <td class="a-right a-right"><?php echo $item->ports; ?></td>
                                    <td class="a-right a-right"><?php echo $item->server; ?></td>
                                    <td class="a-right a-right"><?php echo $item->community; ?></td>
                                    <td class="a-right a-right"><?php echo $item->description; ?></td>
                                    <td class=" last">
                                        <a type="button" class="open-nasModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#nasModal" data-title="View" data-info='{"id":"<?php echo $item->id; ?>", "name":"<?php echo $item->name; ?>", "shortName":"<?php echo $item->shortName; ?>", "type":"<?php echo $item->type; ?>", "secret":"<?php echo $item->secret; ?>", "ports":"<?php echo $item->ports; ?>", "server":"<?php echo $item->server; ?>", "community":"<?php echo $item->community; ?>", "description":"<?php echo $item->description; ?>", "option":"R"}'><i class="fa fa-eye"></i></a>
                                        <?php if ($this->user->authorise('core.edit', 'com_spnas')): ?>
                                            <a type="button" class="open-nasModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#nasModal" data-title="Edit" data-info='{"id":"<?php echo $item->id; ?>", "name":"<?php echo $item->name; ?>", "shortName":"<?php echo $item->shortName; ?>", "type":"<?php echo $item->type; ?>", "secret":"<?php echo $item->secret; ?>", "ports":"<?php echo $item->ports; ?>", "server":"<?php echo $item->server; ?>", "community":"<?php echo $item->community; ?>", "description":"<?php echo $item->description; ?>", "option":"U"}'><i class="fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if ($this->user->authorise('core.delete', 'com_spnas')): ?>
                                            <a type="button" class="open-nasModal btn-sm btn-outline-secondary" data-toggle="modal" data-target="#nasModal" data-title="Delete" data-info='{"id":"<?php echo $item->id; ?>", "name":"<?php echo $item->name; ?>", "shortName":"<?php echo $item->shortName; ?>", "type":"<?php echo $item->type; ?>", "secret":"<?php echo $item->secret; ?>", "ports":"<?php echo $item->ports; ?>", "server":"<?php echo $item->server; ?>", "community":"<?php echo $item->community; ?>", "description":"<?php echo $item->description; ?>", "option":"D"}'><i class="fa fa-trash"></i></a>
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

<div class="modal fade" id="nasModal" tabindex="-1" role="dialog" aria-labelledby="nasModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nasModalLabel">Nas</h5>
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
                        <label for="name" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_NAS_NAMEIP'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="name" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="shortName" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_SHORTNAME'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="shortName" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="type" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_TYPE'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <select id="selType" class="form-control" name="type">
                                <option value="" selected disabled><?php echo JText::_('COM_SPNAS_SELECT_TYPE'); ?></option>
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
                        <label for="secret" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_SECRET'); ?><span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="secret" required="required">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="ports" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_PORTS'); ?></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="ports">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="server" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_SERVER'); ?></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="server">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="community" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_COMMUNITY'); ?></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" id="community">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="description" class="col-form-label col-md-3 col-sm-3 label-align"><?php echo JText::_('COM_SPNAS_DESCRIPTION'); ?></label>
                        <div class="col-md-6 col-sm-6">
                            <textarea class="resizable_textarea form-control" id="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeModal()"><?php echo JText::_('COM_SPNAS_CLOSE'); ?></button>
                        <button type="submit" class="btn btn-success" id="btnSave"><?php echo JText::_('COM_SPNAS_SAVE'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><!--[/JCBGUI$$$$]-->

