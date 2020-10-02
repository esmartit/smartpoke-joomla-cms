<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  com_sphotspotpage
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\HTML\HTMLHelper;

defined('_JEXEC') or die;

// What is the request state?
$isLoginRequest = 'cxx';
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
    $data['ap']['tags'] = '';

    $groupname = 'E1';
    $hotspot_title = 'Demo HotSpot Lab';
    $hotspot_name = 'eSmartIT';
    $spot_id = 'esmartit-001';

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
        <div class="row-fluid">
            <div class="span12" align="center">
                <h2 class="form-signin-heading"><?php echo $hotspot_title; ?></h2>
                <h4><?php echo $hotspot_name; ?></h4>
                <br/>

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
            </div>
            <div class="row-fluid">
                <div class="span4"></div>
                <div class="span4">
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
                        <!--                    <tr><td colspan="2"><a type="button" id="btnlogin" name="btnlogin" class="btn btn-md btn-primary btn-block" onclick="userLogin()">--><?php //echo JText::_('Login'); ?><!--</a></td></tr>-->
                        <tr><td colspan="2"><button type="submit" id="btnlogin" name="btnlogin" class="btn btn-md btn-primary btn-block"><?php echo JText::_('Login'); ?></button></td></tr>
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
                                <td><input type="text" id="firstname" name="firstname" required readonly="true" class="form-control"></td>
                            </tr>
                            <tr>
                                <td align="left"><?php echo JText::_('Last Name'); ?></td>
                                <td><input type="text" id="lastname" name="lastname" class="form-control"></td>
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
                                <td align="right" padding-right="5"><input type="checkbox" id="chkboxTC" class="form-control" name="chkboxTC" required readonly="true"></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tcModal"><?php echo JText::_('Terms and Conditions'); ?></button></td>
                            </tr>
                            <tr><td colspan="2">&nbsp;</td></tr>
                            <!--                        <tr><td colspan="2"><button type="button" id="btnregister" name="btnregister" class="btn btn-lg btn-primary btn-block" onclick="userRegister()">--><?php //echo JText::_('Register'); ?><!--</button></td></tr>-->
                            <tr><td colspan="2"><button type="submit" id="btnregister" name="btnregister" class="btn btn-lg btn-primary btn-block"><?php echo JText::_('Register'); ?></button></td></tr>
                            </tbody>
                        </table>
                    </fieldset>
                </div>
                <div class="span4"></div>
            </div>
        </div>
    <?php } else  if ($isLoggedIn) { ?>
        <div class="alert alert-info"> <?php echo JText::_('Already logged in?');?> <a href="/logout.php">Logout</a></div>
    <?php } else { ?>
        <div class="alert alert-danger"><?php echo JText::_('Hmmm... not sure what you are doing here...');?></div>
    <?php } ?>

</form>

<!-- Modal HTML -->
<div id="adsModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ads Video</h4>
            </div>
            <div align="center" class="modal-body">
                <!--                <iframe id="adsVideo" width="100%" height="auto" src="//www.youtube.com/embed/fsBDbOUGwWQ?autoplay=1" frameborder="0" allowfullscreen></iframe>-->
                <video class="video-fluid z-depth-1" autoplay controls muted style="width: 50%; height:auto;">
                    <source src="../images/videos/ads_video.mp4" type="video/mp4" />
                </video>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="tcModal" tabindex="-1" role="dialog" aria-labelledby="tcModalTitle" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tcModalTitle">Terms and Conditions</h5>
            </div>
            <div class="modal-body" style="height: 250px; overflow-y: auto;">
                <p>Al acceder y utilizar la red WI-FI, usted declara que ha leído, entendido y acepta los términos y condiciones para su utilización. Si usted no está de acuerdo con esta norma, no podrá acceder a este servicio.</p>
                <p>La red WI-FI está destinada únicamente para el uso exclusivo de los clientes. Usted acepta y reconoce que hay riesgos potenciales a través de un servicio WI-FI. Debe tener cuidado al transmitir datos como: número de tarjeta de crédito, contraseñas u otra información personal sensible a través de redes WI-FI.</p>
                <p><b>SmartPoke</b> no puede y no garantiza la privacidad y seguridad de sus datos y de las comunicaciones al utilizar este servicio.</p>
                <p><b>SmartPoke</b> no garantiza el nivel de funcionamiento de la red WI-FI. El servicio puede no estar disponible o ser limitado en cualquier momento y por cualquier motivo, incluyendo emergencias, sobre carga de conexiones, fallo del enlace, problemas en equipos de red, interferencias o fuerza de la señal.</p>
                <p><b>SmartPoke</b>, no se responsabiliza por datos, mensajes o páginas perdidas, no guardadas o retrasos por interrupciones o problemas de rendimiento con el servicio.</p>
                <p><b>SmartPoke</b>, puede establecer límites de uso, suspender el servicio o bloquear ciertos comportamientos, acceso a ciertos servicios o dominios para proteger la red del establecimiento de fraudes o actividades que atenten contra las leyes nacionales o internacionales.</p>
                <p>Asimismo, acepta que se pueda hacer uso de sus datos con fines estrictamente comerciales o de publicidad y comunicación pudiendo darse de baja en cualquier momento de nuestra WI-FI. Para ello tendrá que enviar un correo a info@esmartit.es indicando el numero de móvil y el motivo de su baja.</p>
                <p>NO se podrá utilizar la red WI-FI con los siguientes fines: Transmisión de contenido fraudulento, difamatorio, obsceno, ofensivo o de vandalismo, insultante o acosador, sea este material o mensajes.</p>
                <p>Interceptar, recopilar o almacenar datos sobre terceros sin su conocimiento o consentimiento. Escanear o probar la vulnerabilidad de equipos, sistemas o segmentos de red. Enviar mensajes no solicitados (spam), virus, o ataques internos o externos a la red del establecimiento.</p>
                <p>Obtener acceso no autorizado a equipos, sistemas o programas tanto al interior de la red del establecimiento como fuera. Tampoco podrá utilizar la red WI-FI para obtener, manipular y compartir cualquier archivo sin tener los derechos de propiedad intelectual.</p>
                <p>Transmitir, copiar y/o descargar cualquier material que viole cualquier ley. Esto incluye entre otros: material con derecho de autor, pornografía infantil, material amenazante u obsceno, o material protegido por secreto comercial o patentes.</p>
                <p>Dañar equipos, sistemas informáticos o redes y/o perturbar el normal funcionamiento de la red. Ser usada con fines de lucro, actividades comerciales o ilegales, por ejemplo hacking. Ser utilizada para crear y/o la infectar con virus informático o malware en la red.</p>
                <p>He leído y entendido estas condiciones de uso de red WI-FI y declaro conocer las políticas y normas establecidas por <b>SmartPoke</b>. Estoy de acuerdo en cumplir las directrices anteriores y entender que el incumplimiento de éstas, pueden resultar el bloqueo de mis derechos para usar la red WI-FI y asumir las sanciones legales si corresponde.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnaccept" data-dismiss="modal"><?php echo JText::_('COM_SPHOTSPOTPAGE_ACCEPT'); ?></button>
            </div>
        </div>
    </div>
</div>
