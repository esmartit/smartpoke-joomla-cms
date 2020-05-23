<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');


// Load user_profile plugin language
$lang = JFactory::getLanguage();
$lang->load('plg_user_profile', JPATH_ADMINISTRATOR);

?>
<div class="col-md-12 col-sm-12 ">
    <div class="x_panel">
        <div class="x_title">
            <?php if ($this->params->get('show_page_heading')) : ?>
                <h2>
                    <?php echo $this->escape($this->params->get('page_heading')); ?>
                </h2>
            <?php else: ?>
                <h2>
                    <?php echo "PROFILE"; ?>
                </h2>
            <?php endif; ?>
            <script type="text/javascript">
                Joomla.twoFactorMethodChange = function(e)
                {
                    var selectedPane = 'com_users_twofactor_' + jQuery('#jform_twofactor_method').val();

                    jQuery.each(jQuery('#com_users_twofactor_forms_container>div'), function(i, el)
                    {
                        if (el.id != selectedPane)
                        {
                            jQuery('#' + el.id).hide(0);
                        }
                        else
                        {
                            jQuery('#' + el.id).show(0);
                        }
                    });
                }
            </script>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a class="dropdown-item" href="#">Settings 1</a>
                        </li>
                        <li><a class="dropdown-item" href="#">Settings 2</a>
                        </li>
                    </ul>
                </li>
                <li><a class="close-link"><i class="fa fa-close"></i></a>
                </li>
            </ul>
            <div class="clearfix"></div>
        </div>

        <div class="x_content">
            <br />
            <form id="member-profile" action="<?php echo JRoute::_('index.php?option=com_users&task=profile.save'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
                <?php // Iterate through the form fieldsets and display each one. ?>
                <?php foreach ($this->form->getFieldsets() as $group => $fieldset) : ?>
                    <?php $fields = $this->form->getFieldset($group); ?>
                    <?php if (count($fields)) : ?>
                        <fieldset>
                            <?php // If the fieldset has a label set, display it as the legend. ?>
                            <?php if (isset($fieldset->label)) : ?>
                                <legend>
                                    <?php echo JText::_($fieldset->label); ?>
                                </legend>
                            <?php endif; ?>
                            <?php if (isset($fieldset->description) && trim($fieldset->description)) : ?>
                                <p>
                                    <?php echo $this->escape(JText::_($fieldset->description)); ?>
                                </p>
                            <?php endif; ?>
                            <?php // Iterate through the fields in the set and display them. ?>
                            <?php foreach ($fields as $field) : ?>
                                <?php // If the field is hidden, just display the input. ?>
                                <?php if ($field->hidden) : ?>
                                    <?php echo $field->input; ?>
                                <?php else : ?>
                                    <div class="item form-group">
                                        <label class="col-form-label col-md-3 col-sm-3 label-align">
                                            <?php echo $field->label; ?>
                                            <?php if (!$field->required && $field->type !== 'Spacer') : ?>
                                                <span class="optional">
                                                    <?php echo JText::_('COM_USERS_OPTIONAL'); ?>
                                                </span>
                                            <?php endif; ?>
                                        </label>
                                        <?php if ($field->fieldname === 'password1') : ?>
                                            <?php // Disables autocomplete ?>
                                            <input class="form-control" type="password" style="display:none">
                                        <?php endif; ?>
                                        <?php echo $field->input; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </fieldset>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (count($this->twofactormethods) > 1) : ?>
                    <fieldset>
                        <legend><?php echo JText::_('COM_USERS_PROFILE_TWO_FACTOR_AUTH'); ?></legend>
                        <div class="item form-group">
                            <label id="jform_twofactor_method-lbl" for="jform_twofactor_method" class="hasTooltip"
                                   title="<?php echo '<strong>' . JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL') . '</strong><br />' . JText::_('COM_USERS_PROFILE_TWOFACTOR_DESC'); ?>">
                                <?php echo JText::_('COM_USERS_PROFILE_TWOFACTOR_LABEL'); ?>
                            </label>
                            <div class="item form-group">
                                <?php echo JHtml::_('select.genericlist', $this->twofactormethods, 'jform[twofactor][method]', array('onchange' => 'Joomla.twoFactorMethodChange()'), 'value', 'text', $this->otpConfig->method, 'jform_twofactor_method', false); ?>
                            </div>
                        </div>
                        <div id="com_users_twofactor_forms_container">
                            <?php foreach ($this->twofactorform as $form) : ?>
                                <?php $style = $form['method'] == $this->otpConfig->method ? 'display: block' : 'display: none'; ?>
                                <div id="com_users_twofactor_<?php echo $form['method']; ?>" style="<?php echo $style; ?>">
                                    <?php echo $form['form']; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>
                            <?php echo JText::_('COM_USERS_PROFILE_OTEPS'); ?>
                        </legend>
                        <div class="alert alert-info alert-dismissible">
                            <?php echo JText::_('COM_USERS_PROFILE_OTEPS_DESC'); ?>
                        </div>
                        <?php if (empty($this->otpConfig->otep)) : ?>
                            <div class="alert alert-warning alert-dismissible">
                                <?php echo JText::_('COM_USERS_PROFILE_OTEPS_WAIT_DESC'); ?>
                            </div>
                        <?php else : ?>
                            <?php foreach ($this->otpConfig->otep as $otep) : ?>
                                <span class="span3">
                                    <?php echo substr($otep, 0, 4); ?>-<?php echo substr($otep, 4, 4); ?>-<?php echo substr($otep, 8, 4); ?>-<?php echo substr($otep, 12, 4); ?>
                                </span>
                            <?php endforeach; ?>
                            <div class="clearfix"></div>
                        <?php endif; ?>
                    </fieldset>
                <?php endif; ?>
                <div class="ln_solid"></div>
                <div class="item form-group">
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <a class="btn btn-secondary" href="<?php echo JRoute::_('index.php'); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
                            <?php echo JText::_('JCANCEL'); ?>
                        </a>
                        <button type="submit" class="btn btn-success validate">
                            <?php echo JText::_('JSUBMIT'); ?>
                        </button>
                        <input type="hidden" name="option" value="com_users" />
                        <input type="hidden" name="task" value="profile.save" />
                    </div>
                </div>
                <?php echo JHtml::_('form.token'); ?>
            </form>
        </div>
    </div>
</div>
