<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_login
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');

JHtml::_('behavior.keepalive');
JHtml::_('bootstrap.tooltip');

?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-inline">
    <?php if ($params->get('pretext')) : ?>
        <div class="pretext">
            <p><?php echo $params->get('pretext'); ?></p>
        </div>
    <?php endif; ?>
    <div class="userdata">
        <div id="form-login-username" class="control-group">
            <div class="controls">
                <?php if (!$params->get('usetext', 0)) : ?>
                    <div class="input-prepend">
                        <input name="username" id="username" type="text" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" required="" autofocus=""/>
                    </div>
                <?php else : ?>
                    <label for="username" class="sr-only"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
                    <input name="username" id="username" type="text" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" required="" autofocus=""/>
                <?php endif; ?>
            </div>
        </div>
        <br/>
        <div id="form-login-password" class="control-group">
            <div class="controls">
                <?php if (!$params->get('usetext', 0)) : ?>
                    <div class="input-prepend">
                        <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" required="" />
                    </div>
                <?php else : ?>
                    <label for="password" class="sr-only"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" required="" />
                <?php endif; ?>
            </div>
        </div>
        <br/>
        <div id="form-login-submit" class="control-group">
            <div class="controls">
                <button type="submit" tabindex="0" name="Submit" class="btn btn-lg btn-primary btn-block"><?php echo JText::_('JLOGIN'); ?></button>
            </div>
        </div>
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.login" />
        <input type="hidden" name="return" value="<?php echo $return; ?>" />
        <?php echo JHtml::_('form.token'); ?>
    </div>
    <?php if ($params->get('posttext')) : ?>
        <div class="posttext">
            <p><?php echo $params->get('posttext'); ?></p>
        </div>
    <?php endif; ?>
</form>
