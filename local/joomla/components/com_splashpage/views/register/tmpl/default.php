<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_splashpage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

?>
<form action="<?php echo $this->login_url; ?>" method="post">
    <div class="span12">
        <div class="span4"></div>
        <div class="span4" align="center">
            <h2 class="form-signin-heading">Demo eSmartIT</h2>
            <br/>
            <h4>HotSpot Name</h4>
            <br/>
            <div class="span3">
                <label class="label-align"><?php echo JText::_('Pin'); ?><span class="required">*</span></label>
            </div>
            <div class="span3">
                <input type="hidden" placeholder="Enter Username" name="username" required>
                <input type="hidden" placeholder="Enter Password" name="password" required>
                <input type="text" id="pin" name="pin" required autofocus class="form-control">
                <br/>
                <br/>
                <div class="span3"></div>
                <div class="span6">
                    <button id="btnlogin" type="submit" name="btnlogin" class="btn btn-secondary" value="submit" ><?php echo JText::_('Enter'); ?></button>
                </div>
                <div class="span3"></div>
            </div>
        </div>
        <div class="span4"></div>
    </div>
    <div>
        <input type="hidden" name="task" value="" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
</form>
