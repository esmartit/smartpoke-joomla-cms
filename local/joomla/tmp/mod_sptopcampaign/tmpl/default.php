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

?>

<div class="col-md-3 col-sm-3  bg-white">
    <div class="x_title">
        <h2><?php echo JText::_('MOD_SPTOPCAMPAIGN');?></h2>
        <div class="clearfix"></div>
    </div>

    <div class="col-md-12 col-sm-12 ">
        <div>
            <p>Campaign 1</p>
            <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $data[0];?>"><?php echo $data[0].'%';?></div>
                </div>
            </div>
        </div>
        <div>
            <p>Campaign 2</p>
            <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $data[1];?>"><?php echo $data[1].'%';?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-sm-12 ">
        <div>
            <p>Campaign 3</p>
            <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $data[2];?>"><?php echo $data[2].'%';?></div>
                </div>
            </div>
        </div>
        <div>
            <p>Campaign 4</p>
            <div class="">
                <div class="progress progress_sm" style="width: 76%;">
                    <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $data[3];?>"><?php echo $data[3].'%';?></div>
                </div>
            </div>
        </div>
    </div>

</div>