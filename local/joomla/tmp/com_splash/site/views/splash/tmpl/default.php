<?php
/**
 * @package    smartpoke-cms
 *
 * @author     gustavo.rodriguez <your@email.com>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       http://your.url.com
 */

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;
$document = JFactory::getDocument();

$document->addScript('/templates/smartpokex/vendors/jquery/dist/jquery.min.js');
$document->addScript('/templates/smartpokex/vendors/bootstrap/dist/js/bootstrap.bundle.min.js');/***[/JCBGUI$$$$]***/



//HTMLHelper::_('script', 'com_splash/script.js', array('version' => 'auto', 'relative' => true));
//HTMLHelper::_('stylesheet', 'com_splash/style.css', array('version' => 'auto', 'relative' => true));

?>
<form action="<?php echo $this->login_url; ?>" method="post">
    <div class="container">
        <input type="hidden" name="continue_url" value="><?php echo $this->continue_url; ?>">
        <label for="username"><b>Username</b>
            <input type="text" placeholder="Enter Username" name="username" required>
        </label>
        <label for="password"><b>Password</b>
            <input type="password" placeholder="Enter Password" name="password" required>
        </label>
        <button type="submit">Login</button>
    </div>
</form>
