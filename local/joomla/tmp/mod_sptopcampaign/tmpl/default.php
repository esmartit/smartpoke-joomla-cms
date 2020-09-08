<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  mod_sptopcampaign
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$document = JFactory::getDocument();
$document->addStyleSheet('/templates/smartpokex/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css');
$document->addStyleSheet('/templates/smartpokex/vendors/nprogress/nprogress.css');
$document->addStyleSheet('/templates/smartpokex/vendors/iCheck/skins/flat/green.css');

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');
$document->addScript('/templates/smartpokex/vendors/fastclick/lib/fastclick.js');
$document->addScript('/templates/smartpokex/vendors/nprogress/nprogress.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js');

$document->addScript('/media/mod_sptopcampaign/js/sptopcampaign.js');

?>

<div class="col-md-3 col-sm-3  bg-white">
    <div class="x_title">
        <h2><?php echo JText::_('MOD_SPTOPCAMPAIGN');?></h2>
        <div class="clearfix"></div>
        <div id="userTimeZone" style="display:none"><b><?php echo $usertimezone; ?></b></div>
        <input type="hidden" id="itotalIn"/>
    </div>

    <div class="col-md-12 col-sm-12 ">
        <div><span id="campaign_0"></span>
            <div class="">
                <div class="progress progress_sm" style="width: 80%;">
                    <div id="value_0" class="progress-bar bg-green" role="progressbar"></div>
                </div>
            </div>
        </div>
        <div><span id="campaign_1"></span>
            <div class="">
                <div class="progress progress_sm" style="width: 80%;">
                    <div id="value_1" class="progress-bar bg-blue" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 ">
        <div><span id="campaign_2"></span>
            <div class="">
                <div class="progress progress_sm" style="width: 80%;">
                    <div id="value_2" class="progress-bar bg-orange" role="progressbar"></div>
                </div>
            </div>
        </div>
        <div><span id="campaign_3"></span>
            <div class="">
                <div class="progress progress_sm" style="width: 80%;">
                    <div id="value_3" class="progress-bar bg-red" role="progressbar"></div>
                </div>
            </div>
        </div>
    </div>

</div>