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
<form action="<?php echo JRoute::_('index.php?option=com_splimitation'); ?>" method="post" name="adminForm" id="adminForm">
<!--[JCBGUI.site_view.default.44.$$$$]-->
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
                <a href="?option=com_splimitation&view=limitation&layout=edit" class="btn btn-light"><?php echo JText::_('COM_SPLIMITATION_NEW_LIMITATION'); ?></a>
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
                                    <tr>
                                        <td class="a-right a-right "><?php echo $item->name; ?></td>
                                        <td class="a-right a-right "><?php echo $item->maxUpload->value.' '.$item->maxUpload->rate; ?></td>
                                        <td class="a-right a-right "><?php echo $item->maxDownload->value.' '.$item->maxDownload->rate; ?></td>
                                        <td class="a-right a-right "><?php echo $item->maxTraffic->value.' '.$item->maxTraffic->traffic; ?></td>
                                        <td class="a-right a-right "><?php echo $item->urlRedirect; ?></td>
                                        <td class="a-right a-right "><?php echo $item->accessPeriod->value.' '.$item->accessPeriod->period; ?></td>
                                        <td class="a-right a-right "><?php echo $item->dailySession->value.' '.$item->dailySession->period; ?></td>
                                        <td class=" last">
                                            <a href="<?php echo JRoute::_(SplimitationHelperRoute::getItemlimitationRoute($item->name)); ?>" class="btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                                            <a href="index.php?option=com_splimitation&view=limitation&layout=edit&name=<?php echo $item->name; ?>" class="btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <a href="" class="btn-sm btn-outline-secondary"><i class="fa fa-trash"></i></a>
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
