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

// What is the request state?
$isLoginRequest = $this->ap_mac;
$isLoginError = isset($_REQUEST['error_message']);
$isLoggedIn = isset($_COOKIE['LogoutURL']);

$data = array();
$data['rootUrl'] = "https://" . $_SERVER['SERVER_NAME'];

if ($isLoginRequest) {
    // URLs
    $data['loginUrl'] = urldecode($_REQUEST['login_url']);
    $data['nextUrl'] = urldecode($_REQUEST['continue']);

    // Access Point Info
    $data['ap']['mac'] = $this->ap_mac;
    $data['ap']['name'] = $this->ap_name;
    $data['ap']['tags'] = explode(" ", $_REQUEST['ap_tags']);

    $groupname = substr($data['ap']['tags'][0], strpos($data['ap']['tags'][0], ':')+1, strlen($data['ap']['tags'][0]));
    $hotspot_name = substr($data['ap']['tags'][1], strpos($data['ap']['tags'][1], ':')+1, strlen($data['ap']['tags'][1]));
    $schema = substr($data['ap']['tags'][2], strpos($data['ap']['tags'][2], ':')+1, strlen($data['ap']['tags'][2]));
    $sensorname = substr($data['ap']['tags'][3], strpos($data['ap']['tags'][3], ':')+1, strlen($data['ap']['tags'][3]));
    $spot_id = substr($data['ap']['tags'][4], strpos($data['ap']['tags'][4], ':')+1, strlen($data['ap']['tags'][4]));

    // Client Info
    $data['client']['mac'] = $_REQUEST['client_mac'];
    $data['client']['ip'] = $_REQUEST['client_ip'];
}

if ($isLoginError) {
    // Error Message
    $data['errorMessage'] = $_REQUEST['error_message'] . " " . $data['errorPhone'] ;
}

if ($isLoggedIn) {
    // Get the logout URL from the cookie
    $data['logoutUrl'] = urldecode($_COOKIE['LogoutURL']);
}

?>
<form id="login_form" class="form-signin" role="form" method="POST">
    <?php if ($isLoginRequest) { ?>
        <div class="span12">
            <div class="span4"></div>
            <div class="span4" align="center">
                <h2 class="form-signin-heading">Demo eSmartIT</h2>
                <br/>
                <h4>HotSpot Name</h4>
                <br/>

                <input type="hidden" id="hotspotmac" name="hotspotmac" value="<?php echo $sensorname; ?>">
                <input type="hidden" id="hotspot_name" name="hotspot_name" value="<?php echo $hotspot_name; ?>">
                <input type="hidden" id="spot_id" name="spot_id" value="<?php echo $spot_id; ?>">
                <input type="hidden" id="groupname" name="groupname" value="<?php echo $groupname; ?>">
                <input type="hidden" id="loginUrl" name="loginUrl" value="<?= $data['loginUrl']; ?>">
                <input type="hidden" id="client_mac" name="client_mac" value="<?= $data['client']['mac']; ?>">
                <input type="hidden" id="client_ip" name="client_ip" value="<?= $data['client']['ip']; ?>">


                <input type="hidden" id="username" name="username" class="form-control" value="<?= $_REQUEST['username']; ?>">
                <input type="hidden" id="password" name="password" class="form-control">
                <div id="errorPhone" class="alert alert-danger" style="display: none"></div>
                <?php if ($isLoginError) { ?>
                    <div id="errorPhone" class="alert alert-danger"><?= $data['errorMessage'] ?></div>
                <?php } ?>
                <table border="0" cellpadding="1" cellspacing="1">
                    <tbody>
                    <tr>
                        <td><?php echo JText::_('Mobile'); ?><span class="required">*</span></td>
                    </tr>
                    <tr>
                        <td align="right">
                            <select id="selCountryCode" name="countrycode" class="form-control" style="width: auto">
                                <option value="57">COL</option>
                                <option value="506">CRI</option>
                                <option value="49">DEU</option>
                                <option value="45">DNK</option>
                                <option value="34" selected="true">ESP</option>
                                <option value="33">FRA</option>
                                <option value="44">GBR</option>
                                <option value="502">GTM</option>
                                <option value="39">ITA</option>
                                <option value="31">NLD</option>
                                <option value="51">PER</option>
                                <option value="351">PRT</option>
                                <option value="7">RUS</option>
                                <option value="1">USA</option>
                                <option value="58">VEN</option>
                            </select>
                        </td>
                        <td><input type="text" id="mobilephone" name="mobilephone" required autofocus class="form-control"></td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr><td colspan="2"><a type="button" id="btnlogin" name="btnlogin" class="btn btn-md btn-primary btn-block" onclick="userLogin()"><?php echo JText::_('Login'); ?></a></td></tr>
                    </tbody>
                </table>
                <fieldset id="register" style="display: none">
                    <table border="0" cellpadding="1" cellspacing="1">
                        <tbody>
                        <tr>
                            <td align="left"><?php echo JText::_('PIN'); ?><span class="required">*</span></td>
                            <td><input type="text" id="pin" name="pin" onblur="validPin()" required class="form-control"></td>
                        </tr>
                        <tr><td colspan="2"><div id="resultPin" class="alert alert-danger" style="display: none"></div></td></tr>
                        <tr><td>&nbsp;</td></tr>
                        <tr>
                            <td align="left"><?php echo JText::_('Email'); ?><span class="required">*</span></td>
                            <td><input type="email" id="email_cli" name="email_cli" onblur="validate()" required class="form-control"></td>
                        </tr>
                        <tr><td colspan="2"><div id="resultEmail" class="alert alert-danger" style="display: none"></div></td></tr>
                        <tr>
                            <td align="left"><?php echo JText::_('First Name'); ?><span class="required">*</span></td>
                            <td><input type="text" id="firstname" name="firstname" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td align="left"><?php echo JText::_('Last Name'); ?></td>
                            <td><input type="text" id="lastname" name="lastname" required class="form-control"></td>
                        </tr>
                        <tr>
                            <td align="left"><?php echo JText::_('Birth Date'); ?></td>
                            <td><input type="date" name="bdate" id="bdate" value=<?php echo ''; ?>></td>
                        </tr>
                        <tr>
                            <td align="left"><?php echo JText::_('Sex'); ?></td>
                            <td>
                                <select id="sex" name="sex" class="form-control">
                                    <option value="1" selected="selected"><?php echo JText::_('Woman'); ?></option>
                                    <option value="0"><?php echo JText::_('Man'); ?></option>
                                    <option value="1"><?php echo JText::_('Woman'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="left"><?php echo JText::_('Zip Code'); ?></td>
                            <td><input type="text" id="zipcode" name="zipcode" class="form-control"></td>
                        </tr>
                        <tr>
                            <td align="left"><?php echo JText::_('Membership'); ?></td>
                            <td>
                                <select id="membership" name="membership" class="form-control">
                                    <option value="0" selected="selected"><?php echo JText::_('No'); ?></option>
                                    <option value="1"><?php echo JText::_('Yes'); ?></option>
                                    <option value="0"><?php echo JText::_('No'); ?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" padding-right="5"><input type="checkbox" id="checkbox1" class="form-control" name="checkbox1" required value="check"></td>
                            <td><a href="terminos_condiciones.pdf"><?php echo JText::_('Terms and Conditions'); ?></a></td>
                        </tr>
                        <tr><td colspan="2">&nbsp;</td></tr>
                        <tr><td colspan="2"><button type="button" id="btnregister" name="btnregister" class="btn btn-lg btn-primary btn-block" onclick="userRegister()"><?php echo JText::_('Register'); ?></button></td></tr>
                        </tbody>
                    </table>
                </fieldset>
            </div>
            <div class="span4"></div>
        </div>
    <?php } else  if ($isLoggedIn) { ?>
        <div class="alert alert-info"> <?php echo JText::_('Already logged in?');?> <a href="/logout.php">Logout</a></div>
    <?php } else { ?>
        <div class="alert alert-danger"><?php echo JText::_('Hmmm... not sure what you are doing here...');?></div>
    <?php } ?>
</form>
