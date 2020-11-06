<?php

defined( '_JEXEC' ) or die;

include_once JPATH_THEMES.'/'.$this->template.'/logic.php';

// variables
$app = JFactory::getApplication();

// Output as HTML5
$this->setHtml5(true);

$fullWidth = 1;

// generator tag
$this->setGenerator(null);

// load css
JHtml::_('stylesheet', 'normalize.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'offline.css', array('version' => 'auto', 'relative' => true));

// Logo file or site title param
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

if ($this->params->get('logoFile'))
{
    $logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
}
else
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}
?>
<!DOCTYPE html>

<html lang="<?php echo $this->language; ?>">

<head>
    <jdoc:include type="head" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
</head>

<body class="text-center">
<div id="frame">
    <?php if (!empty($logo)) : ?>
        <h1><?php echo $logo; ?></h1>
    <?php else : ?>
        <h1><?php echo $sitename; ?></h1>
    <?php endif; ?>
    <?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) : ?>
        <img src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo $sitename; ?>" />
    <?php endif; ?>
    <?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) !== '') : ?>
        <p><?php echo $app->get('offline_message'); ?></p>
    <?php elseif ($app->get('display_offline_message', 1) == 2) : ?>
        <p><?php echo JText::_('JOFFLINE_MESSAGE'); ?></p>
    <?php endif; ?>
    <jdoc:include type="message" />
    <form action="<?php echo JRoute::_('index.php', true); ?>" method="post" name="login" id="form-login">
        <fieldset>
            <label for="username" class="sr-only"><?php echo JText::_('JGLOBAL_USERNAME'); ?></label>
            <input name="username" id="username" type="text" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_USERNAME'); ?>" required="" autofocus=""/>
            <br/>
            <label for="password" class="sr-only"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
            <input type="password" name="password" id="password" class="form-control" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" required="" />
<!--            --><?php //if (count($twofactormethods) > 1) : ?>
<!--                <br/>-->
<!--                <label for="secretkey" class="sr-only">--><?php //echo JText::_('JGLOBAL_SECRETKEY'); ?><!--</label>-->
<!--                <input type="text" name="secretkey" autocomplete="one-time-code" id="secretkey" class="form-control" placeholder="--><?php //echo JText::_('JGLOBAL_SECRETKEY'); ?><!--" />-->
<!--            --><?php //endif; ?>
            <br/>
            <input type="submit" name="Submit" class="btn btn-lg btn-primary btn-block" value="<?php echo JText::_('JLOGIN'); ?>" />
            <p><br />Copyright &copy; <?php echo date('Y'); ?> -
                <?php echo $app->get('sitename'); ?></p>
        </fieldset>
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="task" value="user.login" />
        <input type="hidden" name="return" value="<?php echo base64_encode(JURI::base()); ?>" />
        <?php echo JHTML::_( 'form.token' ); ?>
    </form>
</div>
</body>

</html>
