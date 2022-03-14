<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spdevuniquedate
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/media/mod_spdevuniquedate/js/devuniquedate.js');

$currDate = date('Y-m-d H:i:s');
$datestart = date("Y-m-d", strtotime($currDate));
$dateend = date("Y-m-d", strtotime($currDate));

?>
<div class="tile_count">
    <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-mobile-phone"></i> <?php echo JText::_('MOD_SPDEVUNIQUEDATE'); ?></span>
        <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
        <input type="hidden" name="datestart" id="datestart" value='<?php echo $datestart; ?>'/>
        <input type="hidden" name="dateend" id="dateend" value='<?php echo $dateend; ?>'/>
        <div id="devuniquedate" class="count">0</div>
    </div>
</div>


