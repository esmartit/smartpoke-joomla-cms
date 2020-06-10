<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			3rd June, 2020
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
<form action="<?php echo JRoute::_('index.php?option=com_spnas'); ?>" method="post" name="adminForm" id="adminForm">
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
                <a href="?option=com_spnas&view=nas&layout=edit" class="btn btn-light"><?php echo JText::_('New Nas'); ?></a>
            <?php endif; ?>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr class="headings">
                                    <th class='column-title'><?php echo JText::_('COM_SPNAS_ID'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPNAS_NAS_NAME'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPNAS_SHORT_NAME'); ?></th>
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
                                    <tr>
                                        <td class="a-right a-right"><?php echo $item->id; ?></td>
                                        <td class="a-right a-right"><?php echo $item->name; ?></td>
                                        <td class="a-right a-righ"><?php echo $item->shortName; ?></td>
                                        <td class="a-right a-right"><?php echo $item->type; ?></td>
                                        <td class="a-right a-right"><input type="password" disabled value="<?php echo $item->secret; ?>"></td>
                                        <td class="a-right a-right"><?php echo $item->ports; ?></td>
                                        <td class="a-right a-right"><?php echo $item->server; ?></td>
                                        <td class="a-right a-right"><?php echo $item->community; ?></td>
                                        <td class="a-right a-right"><?php echo $item->description; ?></td>
                                        <td class=" last">
                                            <a href="<?php echo JRoute::_(SpnasHelperRoute::getItemnasRoute($item->id)); ?>" class="btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                                            <a href="index.php?option=com_spnas&view=nas&layout=edit&id=<?php echo $item->id; ?>" class="btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <a href="" onlick="" class="btn-sm btn-outline-secondary"><i class="fa fa-trash"></i></a>
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
</div><!--[/JCBGUI$$$$]-->


<?php //if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>
<!--	<div class="pagination">-->
<!--		--><?php //if ($this->params->def('show_pagination_results', 1)) : ?>
<!--			<p class="counter pull-right"> --><?php //echo $this->pagination->getPagesCounter(); ?><!-- --><?php //echo $this->pagination->getLimitBox(); ?><!--</p>-->
<!--		--><?php //endif; ?>
<!--		--><?php //echo $this->pagination->getPagesLinks(); ?>
<!--	</div>-->
<?php //endif; ?>
<input type="hidden" name="task" value="" />
<?php echo JHtml::_('form.token'); ?>
</form>
