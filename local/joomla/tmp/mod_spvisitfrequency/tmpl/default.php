<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spvisitfrequency
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/media/mod_spvisitfrequency/js/visitfrequency.js');

?>
<div class="tile_count">
    <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"> <?php echo 'Monthly IN'; ?></span></br>
        <span class="count_top"> <?php echo JText::_('MOD_SPVISITFREQUENCY'); ?></span>
        <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
        <div id="visitqualified" style="display:none" class="count">0</div>
        <div id="uniquedevices" style="display:none" class="count">0</div>
        <div id="visitfrequency" class="count">0</div>
    </div>
</div>



