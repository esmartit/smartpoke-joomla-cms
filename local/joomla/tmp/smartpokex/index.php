<?php
/**
 * @package     SmartPoke.Site
 * @subpackage  Templates.smartpoke
 *
 * @copyright   Copyright (C) 2020 eSmartIT. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

include_once JPATH_THEMES.'/'.$this->template.'/logic.php';

$app  = JFactory::getApplication();
$user = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename'), ENT_QUOTES, 'UTF-8');

if ($task === 'edit' || $layout === 'form') {
    $fullWidth = 1;
} else {
    $fullWidth = 0;
}

// Use of Google Font
if ($this->params->get('googleFont'))
{
    $font = $this->params->get('googleFontName');

    // Handle fonts with selected weights and styles, e.g. Source+Sans+Condensed:400,400i
    $fontStyle = str_replace('+', ' ', strstr($font, ':', true) ?: $font);

    JHtml::_('stylesheet', 'https://fonts.googleapis.com/css?family=' . $font);
    $this->addStyleDeclaration("
	h1, h2, h3, h4, h5, h6, .site-title {
		font-family: '" . $fontStyle . "', sans-serif;
	}");
}


// Adjusting content width
$rightModuleCount = $this->countModules('right');

$span = 'span12';
if ($rightModuleCount)
{
    $span = 'span9';
}

// Logo file or site title param
if ($this->params->get('logoFile'))
{
    $logo = '<img src="' . htmlspecialchars(JUri::root() . $this->params->get('logoFile'), ENT_QUOTES) . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle'))
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle'), ENT_COMPAT, 'UTF-8') . '</span>';
}
else
{
    $logo = '<span class="site-title" title="' . $sitename . '">' . $sitename . '</span>';
}

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <jdoc:include type="head" />
</head>

<body class="nav-md">
<div class="container body">

    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
                <div class="navbar nav_title" style="border: 0;">
                    <a href="index.php" class="site_title"><i class="fa fa-hand-o-right"></i> <span><?php echo $sitename; ?></span></a>
                </div>

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src="images/esmartit.jpg" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?php echo $user->name ;?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->
                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <h3>Dashboard</h3>
                        <ul class="nav side-menu">
                            <li><a href="/index.php/dashboard/online"><i class="fa fa-plug"></i> OnSite </a></li>
                            <li><a href="/index.php/dashboard/bigdata"><i class="fa fa-database"></i> BigData </a></li>
                            <li><a href="/index.php/dashboard/hotspot"><i class="fa fa-wifi"></i> HotSpot </a></li>
                            <li><a href="/index.php/dashboard/smartpoke"><i class="fa fa-comments-o"></i> SmartPoke </a></li>
                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>Configuration</h3>
                        <ul class="nav side-menu">
                            <li><a href="/index.php/configurations/campaigns"><i class="fa fa-send"></i> Campaign </a></li>
                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>Communication</h3>
                        <ul class="nav side-menu">
                            <li><a href="/index.php/communication/campaign-detailed"><i class="fa fa-list-alt"></i> Campaign Detailed </a></li>
                            <li><a href="/index.php/communication/campaign-effectiveness"><i class="fa fa-check-circle-o"></i> Campaign Effectiveness </a></li>
                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>BigData Reports</h3>
                        <ul class="nav side-menu">
<!--                            <li><a href="/index.php/bigdata-reports/report-bigdata-detailed"><i class="fa fa-list-ol"></i> Detailed </a></li>-->
                            <li><a href="/index.php/bigdata-reports/report-bigdata-detailed-daily"><i class="fa fa-list-ul"></i> Detailed Daily</a></li>
                            <li><a href="/index.php/bigdata-reports/report-bigdata-detailed-by-time"><i class="fa fa-clock-o"></i> Detailed by Time </a></li>
                        </ul>
                    </div>
                    <div class="menu_section">
                        <h3>HotSpot Reports</h3>
                        <ul class="nav side-menu">
                            <li><a href="/index.php/hotspot-reports/report-hotspot-detailed"><i class="fa fa-list-ol"></i> Detailed </a></li>
<!--                            <li><a href="/index.php/hotspot-reports/report-hotspot-comparative"><i class="fa fa-list"></i> Comparative </a></li>-->
                        </ul>
                    </div>

                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <jdoc:include type="message" />
            <div class="nav_menu">
                <div class="nav toggle">
                    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                </div>
                <?php if ($this->countModules('navbar')) : ?>
                    <nav class="navbar navbar-expand-lg navbar-light col-md-9" role="navigation">
                        <div class="nav-collapse">
                            <jdoc:include type="modules" name="navbar" style="xhtml" />
                        </div>
                    </nav>
                <?php endif; ?>
                <div class="header-search pull-right">
                    <jdoc:include type="modules" name="search" style="none" />
                </div>
            </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="row-fluid right_col">
            <main id="content" role="main" class="<?php echo $span; ?>" style="min-height: 1375px;">
                <!-- Begin Content -->
                <jdoc:include type="modules" name="topcenter" style="none" />
                <div class="row col-md-12 col-sm-12">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_title">
                            <h2></h2>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="x_content">
                        <jdoc:include type="component" />
                    </div>
                </div>
                <jdoc:include type="modules" name="breadcrumbs" style="none" />
                <!-- End Content -->
            </main>
            <?php if ($rightModuleCount) : ?>
                <div id="aside" class="span3">
                    <!-- Begin Right Sidebar -->
                    <jdoc:include type="modules" name="right" style="well" />
                    <!-- End Right Sidebar -->
                </div>
            <?php endif; ?>
        </div>
        <!-- /page content -->
    </div>
    <!-- footer content -->
    <footer class="footer" role="contentinfo">
        <div class="container<?php echo ($params->get('fluidContainer') ? '-fluid' : ''); ?>">
            <jdoc:include type="modules" name="footer" style="none" />
        </div>
    </footer>
    <jdoc:include type="modules" name="debug" style="none" />
    <!-- /footer content -->
</div>

<!-- jQuery -->
<!--<script src="--><?php //echo $tpath;?><!--/vendors/jquery/dist/jquery.min.js"></script>-->
<!-- Bootstrap -->
<!--<script src="--><?php //echo $tpath;?><!--/vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>-->
<!-- FastClick -->
<!--<script src="--><?php //echo $tpath;?><!--/vendors/fastclick/lib/fastclick.js"></script>-->
<!-- NProgress -->
<!--<script src="--><?php //echo $tpath;?><!--/vendors/nprogress/nprogress.js"></script>-->

<!-- Custom Theme Scripts -->
<script src="<?php echo $tpath;?>/build/js/custom.js"></script>

<input type="hidden" name="option" value="com_users" />
<input type="hidden" name="task" value="user.logout" />
<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', JURI::base())); ?>" />
<?php echo JHTML::_( 'form.token' ); ?>

</body>
</html>