<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.3
	@build			17th June, 2020
	@created		16th June, 2020
	@package		SP Message
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


/***[JCBGUI.site_view.php_view.48.$$$$]***/
$document = JFactory::getDocument();

$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net/js/jquery.dataTables.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/dataTables.buttons.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/buttons.flash.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/buttons.html5.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-buttons/js/buttons.print.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive/js/dataTables.responsive.min.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js');
$document->addScript('/templates/smartpokex/vendors/datatables.net-scroller/js/dataTables.scroller.min.js');
$document->addScript('/templates/smartpokex/vendors/jszip/dist/jszip.min.js');
$document->addScript('/templates/smartpokex/vendors/pdfmake/build/pdfmake.min.js');
$document->addScript('/templates/smartpokex/vendors/pdfmake/build/vfs_fonts.js');
/***[/JCBGUI$$$$]***/

?>
<form action="<?php echo JRoute::_('index.php?option=com_spmessage'); ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->toolbar->render(); ?>
<!--[JCBGUI.site_view.default.48.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPMESSAGE_LIST_OF_MESSAGES'); ?><small></small></h2>
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
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr class="headings">
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_ID'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_CAMPAIGN'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_DEVICE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_USERNAME'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_DATE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_STATUS'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPMESSAGE_DESCRIPTION'); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($this->items as $item): ?>
                                    <?php 
                                        $status = "<span class='glyphicon glyphicon-ok' style='color:#00FF00'>";
                                        if ($item->status == 0) 
                                            $status = "<span class='glyphicon glyphicon-remove' style='color:#FF0000'>";
                                     ?>
                                    <tr>
                                        <td class="a-right a-right "><?php echo $item->id; ?></td>
                                        <td class="a-right a-right"><?php echo $item->campaign; ?></td>
                                        <td class="a-right a-right"><?php echo $item->device_sms; ?></td>
                                        <td class="a-right a-right"><?php echo $item->username; ?></td>
                                        <td class="a-right a-right"><?php echo $item->senddate; ?></td>
                                        <td class="a-right a-right"><?php echo $status; ?></td>
                                        <td class="a-right a-right"><?php echo $item->description; ?></td>
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
