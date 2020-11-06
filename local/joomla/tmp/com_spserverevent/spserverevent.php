<?php
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

$app = Factory::getApplication();
$app->getDocument()->setMimeEncoding("text/event-stream");
$app->allowCache(false);
