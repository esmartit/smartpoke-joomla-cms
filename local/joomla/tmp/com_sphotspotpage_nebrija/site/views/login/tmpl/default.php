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
$isLoginRequest = $this->ap_mac;
//$isLoginRequest = 'mac address';
$isLoginError = isset($_REQUEST['error_message']);
$isLoggedIn = isset($_COOKIE['LogoutURL']);

$data = array();
$data['rootUrl'] = "https://" . $_SERVER['SERVER_NAME'];
$dateVal = date('Y-m-d', strtotime('-16 years'));

if ($isLoginRequest) {
    // URLs
    $data['loginUrl'] = urldecode($_REQUEST['login_url']);
    $data['nextUrl'] = urldecode($_REQUEST['continue']);

    // Access Point Info
    $data['ap']['mac'] = $this->ap_mac;
    $data['ap']['name'] = $this->ap_name;
    $data['ap']['tags'] = '';

    $groupname = 'N1';
    $hotspot_title = '';
    $hotspot_name = 'Nebrija 01';
    $spot_id = 'nebrija-001';

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
                <!--<h2 class="form-signin-heading"><?php echo $hotspot_title; ?></h2>-->
                <!--<h4><?php echo $hotspot_name; ?></h4>-->
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
                                    <option value="52">MEX</option>
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
                                <td><input type="text" class="form-control" id="pin" name="pin" onblur="validPin()" required></td>
                            </tr>
                            <tr><td colspan="2"><div id="resultPin" class="alert alert-danger" style="display: none"></div></td></tr>
                            <tr><td>&nbsp;</td></tr>
                            <tr>
                                <td align="left"><?php echo JText::_('Email'); ?><span class="required">*</span></td>
                                <td><input type="email" class="form-control" id="email_cli" name="email_cli" onblur="validate()" required></td>
                            </tr>
                            <tr><td colspan="2"><div id="resultEmail" class="alert alert-danger" style="display: none"></div></td></tr>
                            <tr>
                                <td align="left"><?php echo JText::_('First Name'); ?><span class="required">*</span></td>
                                <td><input type="text" class="form-control" id="firstname" name="firstname" readonly="true" required></td>
                            </tr>
                            <tr>
                                <td align="left"><?php echo JText::_('Last Name'); ?></td>
                                <td><input type="text" id="lastname" name="lastname" class="form-control"></td>
                            </tr>
                            <tr>
                                <td align="left"><?php echo JText::_('Zip Code'); ?></td>
                                <td><input type="text" id="zipcode" name="zipcode" minlength="5" maxlength="5" onkeypress="return zipCode(event)" class="form-control"></td>
                            </tr>
                            <tr>
                                <td align="left"><?php echo JText::_('Birth Date'); ?><span class="required">*</span></td>
                                <td><input type="date" id="bdate" name="bdate" onblur=checkAge(16) value=<?php echo $dateVal; ?> readonly="true" required></td>
                            </tr>
                            <tr>
                                <!--<td align="left"><?php echo JText::_('Sex'); ?></td>
                                <td>
                                    <select id="sex" name="sex" required disabled="disabled" class="form-control">
                                        <option value="" selected="selected"><?php echo JText::_(''); ?></option>
                                        <option value="0"><?php echo JText::_('Man'); ?></option>
                                        <option value="1"><?php echo JText::_('Woman'); ?></option>
                                    </select>
                                </td>-->
                                <td>
                                    <input type="hidden" id="sex" name="sex" value="0">
                                </td>
                            </tr>
                            <tr>
                                <!--<td align="left"><?php echo JText::_('Membership'); ?></td>
                                <td>
                                    <select id="membership" name="membership" class="form-control">
                                        <option value="0" selected="selected"><?php echo JText::_('No'); ?></option>
                                        <option value="1"><?php echo JText::_('Yes'); ?></option>
                                        <option value="0"><?php echo JText::_('No'); ?></option>
                                    </select>
                                </td>-->
                                <td>
                                    <input type="hidden" id="membership" name="membership" value="0">
                                </td>
                            </tr>
                            <tr>
                                <td align="right" padding-right="5"><input type="checkbox" id="chkboxAge" class="form-control" name="chkboxAge" readonly="true" required></td>
                                <td><button type="button" class="btn btn-primary"><?php echo JText::_('Tengo más de 16 años'); ?></button></td>
                            </tr>
                            <tr>
                                <td align="right" padding-right="5"><input type="checkbox" id="chkboxAut" class="form-control" name="chkboxAut" readonly="true" required></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#autModal"><?php echo JText::_('Acepto comunicación comercial'); ?></button></td>
                            </tr>
                            <tr>
                                <td align="right" padding-right="5"><input type="checkbox" id="chkboxTC" class="form-control" name="chkboxTC" readonly="true" required></td>
                                <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tcModal"><?php echo JText::_('Términos y Condiciones'); ?></button></td>
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
                <video class="video-fluid z-depth-1" autoplay controls muted style="width: 50%; height:100px;">
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
                <h5 class="modal-title" id="tcModalTitle">Términos y Condiciones</h5>
            </div>
            <div class="modal-body" style="height: 100px; overflow-y: auto;">
                <p>Al acceder y utilizar la red WI-FI de la Universidad Nebrija, usted declara que ha leído, entendido y acepta los términos y condiciones para su utilización. Si usted no está de acuerdo con esta norma, no podrá acceder a este servicio.</p>
                <p>Usted acepta y reconoce que hay riesgos potenciales a través de un servicio WI-FI. Aunque la infraestructura WiFi garantiza los estándares habituales de seguridad, debe tener cuidado al transmitir datos como: número de tarjeta de crédito, contraseñas u otra información personal sensible a través de redes WI-FI. Universidad Nebrija no puede y no garantiza la privacidad y seguridad de sus datos y de las comunicaciones al utilizar este servicio.</p>
                <p>Universidad Nebrija no garantiza un nivel 100% de funcionamiento de la red WI-FI. El servicio puede no estar disponible o ser limitado en cualquier momento y por cualquier motivo, incluyendo emergencias, sobre carga de conexiones, fallo del enlace, problemas en equipos de red, interferencias o fuerza de la señal. Universidad Nebrija no se responsabiliza por datos, mensajes o páginas perdidas, no guardadas o retrasos por interrupciones o problemas de rendimiento con el servicio.</p>
                <p>Universidad Nebrija puede establecer límites de uso, suspender el servicio o bloquear ciertos comportamientos, acceso a ciertos servicios o dominios para proteger la red del Universidad Nebrija de fraudes o actividades que atenten contra las leyes nacionales o internacionales.</p>
                <p>Asimismo, acepta que Universidad Nebrija pueda hacer uso de sus datos con fines estrictamente comerciales o de publicidad y comunicación pudiendo darse de baja en cualquier momento de las campañas de comunicación/marketing.</p>
                <p>NO se podrá utilizar la red WI-FI con los siguientes fines:</p>
                <p>
                <li>Transmisión de contenido fraudulento, difamatorio, obsceno, ofensivo o de vandalismo, insultante o acosador, sea este material audiovisual o mensajes.</li>
                <li>Interceptar, recopilar o almacenar datos sobre terceros sin su conocimiento o consentimiento. Escanear o probar la vulnerabilidad de equipos, sistemas o segmentos de red. Enviar mensajes no solicitados (spam), virus, o ataques internos o externos a la red de Universidad Nebrija.</li>
                <li>Obtener acceso no autorizado a equipos, sistemas o programas tanto al interior de la red de Universidad Nebrija como fuera de ella. Tampoco podrá utilizar la red WI-FI para obtener, manipular y compartir cualquier archivo sin tener los derechos de propiedad intelectual.</li>
                <li>Transmitir, copiar y/o descargar cualquier material que viole cualquier ley. Esto incluye entre otros: material con derecho de autor, pornografía infantil, material amenazante u obsceno, o material protegido por secreto comercial o patentes.</li>
                <li>Dañar equipos, sistemas informáticos o redes y/o perturbar el normal funcionamiento de la red. Ser usada con fines de lucro, actividades comerciales o ilegales, por ejemplo hacking. Ser utilizada para crear y/o la infectar con virus informático o malware en la red.</li>
                </p>
                <p>Tratamiento de datos personales:</p>
                <p>
                    <b><u>Responsable del tratamiento de los datos</u></b>: Los datos personales facilitados durante el registro para el uso de la red Wifi serán tratados por la UNIVERSIDAD ANTONIO DE NEBRIJA (UNIVERSITAS NEBRISSENSIS, S.A.), en adelante, Universidad Nebrija, cuyos datos de contacto son los siguientes:
                <li>Domicilio social: Campus de Ciencias de la Vida en La Berzosa, 28248, Hoyo de Manzanares (Madrid).</li>
                <li>Teléfono: 91 452 11 00</li>
                <li>Dirección de Correo Electrónico:<a href="mailto:lopd@nebrija.es">lopd@nebrija.es</a></li>
                <b><u>Delegado de Protección de Datos</u></b>: La Universidad dispone de un Delegado de Protección de Datos (DPD), que es una figura legalmente prevista cuyas funciones principales son las de informar y asesorar a la entidad sobre las obligaciones que le afectan en materia de protección de datos personales y supervisar su cumplimiento. Además, el DPD actúa como punto de contacto con la entidad para cualquier cuestión relativa al tratamiento de datos personales, por lo que, si lo desea, puede usted dirigirse a él: <a href="mailto:dpo@nebrija.es">dpo@nebrija.es</a>
                </p>
                <p><b><u>Finalidad del tratamiento de los datos</u></b>:</p>
                <p>Tratamos los datos personales que nos facilite con las siguientes finalidades:</p>
                <p>
                <li>Permitirle la conexión a la red Wifi de la entidad. La entrega de los datos para esta finalidad es obligatoria, no pudiendo conectarse a la red Wifi en caso contrario.</li>
                <li>Remitirle información comercial de los servicios, ofertas y eventos desarrollados por la Universidad Nebrija. La autorización para el tratamiento de sus datos con este fin es voluntaria y su negativa sólo tendría como consecuencia que usted no recibiría comunicaciones comerciales de la Universidad.</li>
                </p>
                <p>Las categorías de datos tratadas son las siguientes: datos identificativos (nombre y teléfono) y datos de características personales (edad). </p>
                <p><b><u>Conservación de los datos</u></b>: Sólo conservamos sus datos por el periodo de tiempo necesario para cumplir con la finalidad para la que fueron recogidos, dar cumplimiento a las obligaciones legales que nos vienen impuestas y atender las posibles responsabilidades que pudieran derivar del cumplimiento de la finalidad para la que los datos fueron recabados. </p>
                <p>Los datos serán conservados durante el tiempo que dure la conexión y posteriormente, durante el tiempo exigido por la legislación aplicable y hasta que prescriban las eventuales responsabilidades reflejadas en la misma. </p>
                <p>No obstante, los datos personales para la remisión de comunicaciones comerciales serán conservados de manera indefinida, salvo que el usuario solicite su supresión o revoque su consentimiento. </p>
                <p><b>Base legitimadora</b>: La base legal para el tratamiento de sus datos es la ejecución de la relación contractual surgida como consecuencia de la aceptación de los términos y condiciones que rigen la conexión a la red Wifi de la Universidad. </p>
                <p>No obstante, el envío de comunicaciones comerciales tiene como base el consentimiento del interesado. Dicho consentimiento es revocable en cualquier momento, sin que ello tenga más consecuencias que dejar de recibir la publicidad y sin que ello afecte a los tratamientos de datos realizados con anterioridad. </p>
                <p><b>Destinatarios de los datos</b>: Los datos serán tratados de manera confidencial y no serán cedidos a ningún tercero, salvo a las Administraciones Públicas en los casos previstos en la Ley y para los fines en ella definidos. </p>
                <p>Aunque no se trata de una cesión de datos, puede ser que terceras empresas, que actúan como proveedores nuestros, accedan a su información para llevar a cabo el servicio. Estos encargados acceden a sus datos siguiendo nuestras instrucciones y sin que puedan utilizarlos para una finalidad diferente y manteniendo la más estricta confidencialidad y en base a un contrato en el que se comprometen a cumplir las exigencias de la vigente normativa en materia de protección de datos personales. </p>
                <p><b>Ejercicio de derechos RGPD</b>: Cualquier persona tiene derecho a obtener confirmación sobre si estamos tratando datos personales que le conciernan, o no. Las personas interesadas tienen derecho a acceder a sus datos personales, así como a solicitar la rectificación de los datos inexactos o, en su caso, solicitar su supresión cuando, entre otros motivos, los datos ya no sean necesarios para los fines para los que fueron recogidos. </p>
                <p>En las condiciones previstas en el Reglamento General de Protección de Datos, los interesados podrán solicitar la limitación del tratamiento de sus datos o su portabilidad, en cuyo caso únicamente los conservaremos para el ejercicio o la defensa de reclamaciones. </p>
                <p>En determinadas circunstancias y por motivos relacionados con su situación particular, los interesados podrán oponerse al tratamiento de sus datos. Si usted ha otorgado el consentimiento para alguna finalidad específica, tiene derecho a retirarlo en cualquier momento, sin que ello afecte a la licitud del tratamiento basado en el consentimiento previo a su retirada. En estos supuestos dejaremos de tratar los datos o, en su caso, dejaremos de hacerlo para esa finalidad en concreto, salvo por motivos legítimos imperiosos, o el ejercicio o la defensa de posibles reclamaciones. </p>
                <p>Además, la normativa en materia de protección de datos permite que pueda oponerse a ser objeto de decisiones basadas únicamente en el tratamiento automatizado de sus datos, cuando proceda. </p>
                <p>Los antedichos derechos se caracterizan por lo siguiente: <br/>
                <p>
                <li>Su ejercicio es gratuito, salvo que se trate de solicitudes manifiestamente infundadas o excesivas (p. ej., carácter repetitivo), en cuyo caso podrá cobrarse un canon proporcional a los costes administrativos soportados o negarse a actuar .</li>
                <li>Puede ejercer los derechos directamente o por medio de tu representante legal o voluntario.</li>
                <li>Se debe responder a su solicitud en el plazo de un mes, aunque, si se tiene en cuenta la complejidad y número de solicitudes, se puede prorrogar el plazo en otros dos meses más. </li>
                <li>Tenemos la obligación de informarle sobre los medios para ejercitar estos derechos, los cuales deben ser accesibles y sin poder denegarle el ejercicio del derecho por el solo motivo de optar por otro medio. Si la solicitud se presenta por medios electrónicos, la información se facilitará por estos medios cuando sea posible, salvo que nos solicite que sea de otro modo. </li>
                <li>Si, por cualquier motivo, no se diese curso a la solicitud, le informaremos, a más tardar en un mes, de las razones de ello y de la posibilidad de reclamar ante una Autoridad de Control .</li>
                </p>
                <p>Todos los derechos mencionados pueden ejercerse a través de los medios de contacto que figuran al principio de esta cláusula. </p>
                <p>En todos los casos, deberá acreditar su identidad acompañando, en su caso, fotocopia o copia escaneada, de su DNI o documento equivalente, o bien documento acreditativo de la representación, si el derecho se ejerce mediante representante. Todos los derechos mencionados pueden ejercerse a través de los medios de contacto con la entidad que figuran al principio de esta cláusula. </p>
                <p>Frente a cualquier vulneración de sus derechos, especialmente cuando usted no haya obtenido satisfacción en su ejercicio, puede presentar una reclamación ante la Agencia Española de Protección de Datos (datos de contacto accesibles en www.aepd.es), u otra autoridad de control competente. También puede obtener más información sobre los derechos que le asisten dirigiéndose a dichos organismos. Origen de los datos: Los datos personales son facilitados por los usuarios que se conectan a la red Wifi. </p>
                <p>En el caso de que se faciliten datos terceros, asume la responsabilidad de informarles previamente de todo lo previsto en el artículo 14 del Reglamento General de Protección de Datos en las condiciones establecidas en dicho precepto. </p>
                <p><b>Medidas de protección de los datos personales</b>: Tenemos el firme compromiso de proteger los datos personales que tratamos. Utilizamos medidas, controles y procedimientos de carácter físico, organizativo y tecnológico, razonablemente fiables y efectivos, orientados a preservar la integridad y la seguridad de sus datos y garantizar su privacidad. </p>
                <p>Además, todo el personal con acceso a los datos personales ha sido formado y tiene conocimiento de sus obligaciones con relación a los tratamientos de sus datos personales. </p>
                <p>En el caso de los contratos que suscribimos con nuestros proveedores incluimos cláusulas en las que se les exige mantener el deber de secreto respecto a los datos de carácter personal a los que hayan tenido acceso en virtud del encargo realizado, así como implantar las medidas de seguridad técnicas y organizativas necesarias para garantizar la confidencialidad, integridad, disponibilidad y resiliencia permanentes de los sistemas y servicios de tratamiento de los datos personales. </p>
                <p>Todas estas medidas de seguridad son revisadas de forma periódica para garantizar su adecuación y efectividad. </p>
                <p>Sin embargo, la seguridad absoluta no se puede garantizar y no existe ningún sistema de seguridad que sea impenetrable por lo que, en el caso de cualquier información objeto de tratamiento y bajo nuestro control se viese comprometida como consecuencia de una brecha de seguridad, tomaremos las medidas adecuadas para investigar el incidente, notificarlo a la Autoridad de Control y, en su caso, a aquellos usuarios que se hubieran podido ver afectados para que tomen las medidas adecuadas. </p>
                <p><b>Responsabilidad de los participantes</b>: Al facilitarnos sus datos personales, la persona que lo haga garantiza que es mayor de 16 años y que los datos facilitados son verdaderos, exactos, completos y actualizados. </p>
                <p>A estos efectos, el interesado responde de la veracidad de los datos y los deberá mantener convenientemente actualizados de modo que respondan a su situación real, haciéndose responsable de los datos falsos e inexactos que pudiera proporcionar, así como de los daños y perjuicios, directos o indirectos, que pudieran derivarse. </p>
                <p>He leído y entendido estas condiciones de uso de red WI-FI y declaro conocer las políticas y normas establecidas por Universidad Nebrija. Estoy de acuerdo en cumplir las directrices anteriores y entender que el incumplimiento de éstas, pueden resultar el bloqueo de mis derechos para usar la red WI-FI y asumir las sanciones legales si corresponde. </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnacceptTC" data-dismiss="modal"><?php echo JText::_('COM_SPHOTSPOTPAGE_ACCEPT'); ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="autModal" tabindex="-1" role="dialog" aria-labelledby="autModalTitle" aria-hidden="true" style="overflow-y: scroll;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="autModalTitle">Acepto comunicación comercial</h5>
            </div>
            <div class="modal-body" style="height: 100px; overflow-y: auto;">
                <table border = "1" style="width:100%">
                    <tr>
                        <th colspan="2">INFORMACIÓN BÁSICA SOBRE PROTECCIÓN DE DATOS</th>
                    </tr>
                    <tr>
                        <td><b>Entidad responsable del tratamiento</b></td>
                        <td>Universidad Nebrija.</td>
                    </tr>
                    <tr>
                        <td><b>Finalidad</b></td>
                        <td>Los datos se tratarán para permitirle la conexión a la red Wifi de la entidad y, en caso de autorización, la remisión de comunicaciones comerciales.</td>
                    </tr>
                    <tr>
                        <td><b>Derechos</b></td>
                        <td>En las condiciones legales, tiene derecho a acceder, rectificar y suprimir los datos, a la limitación de su tratamiento, a oponerse al mismo y a su portabilidad.</td>
                    </tr>
                    <tr>
                        <td><b>Información adicional</b></td>
                        <td>Puede consultar la información adicional sobre Protección de Datos en las bases del concurso disponibles en Términos y Condiciones.</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btnacceptAut" data-dismiss="modal"><?php echo JText::_('COM_SPHOTSPOTPAGE_ACCEPT'); ?></button>
            </div>
        </div>
    </div>
</div>