<?php
/*----------------------------------------------------------------------------------|  www.vdm.io  |----/
				eSmartIT 
/-------------------------------------------------------------------------------------------------------/

	@version		1.0.0
	@build			5th June, 2020
	@created		24th April, 2020
	@package		SP Customer
	@subpackage		default.php
	@author			Adolfo Zignago <https://esmartit.es>	
	@copyright		Copyright (C) 2020. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html
  ____  _____  _____  __  __  __      __       ___  _____  __  __  ____  _____  _  _  ____  _  _  ____ 
 (_  _)(  _  )(  _  )(  \/  )(  )    /__\     / __)(  _  )(  \/  )(  _ \(  _  )( \( )( ___)( \( )(_  _)
.-_)(   )(_)(  )(_)(  )    (  )(__  /(__)\   ( (__  )(_)(  )    (  )___/ )(_)(  )  (  )__)  )  (   )(  
\____) (_____)(_____)(_/\/\_)(____)(__)(__)   \___)(_____)(_/\/\_)(__)  (_____)(_)\_)(____)(_)\_) (__) 

/------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/***[JCBGUI.site_view.php_view.42.$$$$]***/
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
<form action="<?php echo JRoute::_('index.php?option=com_spcustomer'); ?>" method="post" name="adminForm" id="adminForm">
<?php echo $this->toolbar->render(); ?>
<!--[JCBGUI.site_view.default.42.$$$$]-->
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2><?php echo JText::_('COM_SPCUSTOMER_LIST_OF_CUSTOMERS'); ?><small></small></h2>
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
            <?php if ($this->user->authorise('core.create', 'com_spcustomer')): ?>
                <a href="?option=com_spcustomer&view=customer&layout=edit" class="btn btn-light"><?php echo JText::_('COM_SPCUSTOMER_NEW_CUSTOMER'); ?></a>
                <br />
            <?php endif; ?>
            <div class="x_content">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card-box table-responsive">
                            <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                <tr class="headings">
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_ID'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_SPOT'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_USERNAME'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_FIRSTNAME'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_LASTNAME'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_MOBILE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_EMAIL'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_BIRTHDATE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_SEX'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_ZIP_CODE'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_MEMBERSHIP'); ?></th>
                                    <th class='column-title'><?php echo JText::_('COM_SPCUSTOMER_COMMUNICATION'); ?></th>
                                    <th class="column-title no-link last"><span class="nobr"><?php echo JText::_('COM_SPCUSTOMER_ACTION'); ?></span></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($this->items as $item): ?>
                                    <?php
                                        $canCheckin = $this->user->authorise('core.manage', 'com_checkin') || $item->checked_out == $this->user->id || $item->checked_out == 0;
                                        $userChkOut = JFactory::getUser($item->checked_out);
                                        $canDo = SpcustomerHelper::getActions('customer',$item,'customers');
                                    ?>
                                    <tr>
                                        <td class="a-right a-right "><?php echo $item->id; ?></td>
                                        <td class="a-right a-right "><?php echo $item->spot_name; ?></td>
                                        <td class="a-right a-right "><?php echo $item->username; ?></td>
                                        <td class="a-right a-right "><?php echo $item->firstname; ?></td>
                                        <td class="a-right a-right "><?php echo $item->lastname; ?></td>
                                        <td class="a-right a-right "><?php echo $item->mobile_phone; ?></td>
                                        <td class="a-right a-right "><?php echo $item->email; ?></td>
                                        <td class="a-right a-right "><?php echo $item->dateofbirth; ?></td>
                                        <?php if ($item->sex == 0): ?>
                                            <td class=""><?php echo JText::_('M'); ?></td>
                                        <?php else : ?>
                                            <td class=""><?php echo JText::_('F'); ?></td>
                                        <?php endif; ?>
                                        <td class="a-right a-right "><?php echo $item->zipcode; ?></td>
                                        <?php if ($item->membership == 0): ?>
                                            <td><input type="checkbox" id="check-all" disabled></td>
                                        <?php else : ?>
                                            <td><input type="checkbox" id="check-all" checked disabled></td>
                                        <?php endif; ?>
                                        <?php if ($item-> communication == 0): ?>
                                            <td><input type="checkbox" id="check-all" disabled></td>
                                        <?php else : ?>
                                            <td><input type="checkbox" id="check-all" checked disabled></td>
                                        <?php endif; ?>
                                        <td class=" last">
                                            <a href="<?php echo JRoute::_(SpcustomerHelperRoute::getItemcustomerRoute($item->slug)); ?>" class="btn-sm btn-outline-secondary"><i class="fa fa-eye"></i></a>
                                            <?php if ($canDo->get('core.edit')): ?>
                                                <a href="index.php?option=com_spcustomer&view=customers&task=customer.edit&id=<?php echo $item->id; ?>" class="btn-sm btn-outline-secondary"><i class="fa fa-edit"></i></a>
                                            <?php endif; ?>
                                            <?php if ($canDo->get('core.delete')): ?>
                                                <a href="" class="btn-sm btn-outline-secondary"><i class="fa fa-trash"></i></a>
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
