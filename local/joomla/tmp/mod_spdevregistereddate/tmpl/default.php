<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_spdevregistereddate
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/media/mod_spdevregistereddate/js/devregistereddate.js');

?>
<div class="tile_count">
    <div class="col-md-2 col-sm-4  tile_stats_count">
        <span class="count_top"><i class="fa fa-users"></i> <?php echo JText::_('MOD_SPDEVREGISTEREDDATE'); ?></span>
        <div id="devregistereddate" class="count green">0</div>
    </div>
</div>



