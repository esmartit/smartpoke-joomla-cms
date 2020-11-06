<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-vertical">

    <nav class="nav navbar-nav">
        <ul class=" navbar-right">
            <li class="nav-item dropdown open" style="padding-left: 15px;">
                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                    <img src="images/esmartit.jpg" alt=""><?php echo JText::sprintf('MOD_LOGIN_HINAME', htmlspecialchars($user->get('name'), ENT_COMPAT, 'UTF-8')); ?>
                </a>
                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="<?php echo JRoute::_('index.php?option=com_users&view=profile&layout=edit'); ?>"> Profile</a>
                    <div class="logout-button">
                        <input type="submit" name="Submit" class="dropdown-item" value="<?php echo JText::_('JLOGOUT'); ?>" />
                        <input type="hidden" name="option" value="com_users" />
                        <input type="hidden" name="task" value="user.logout" />
                        <input type="hidden" name="return" value="<?php echo $return; ?>" />
                        <?php echo JHtml::_('form.token'); ?>
                    </div>
                </div>
            </li>
        </ul>
    </nav>
</form>
