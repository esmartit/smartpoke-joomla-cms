<?php
/**
 * @package    SmartPoke.joomla
 *
 * @author     gustavo.rodriguez <tech@esmartit.es>
 * @copyright  A copyright
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @link       https://www.esmartit.es
 */

use Clue\React\Buzz\Browser;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Plugin\CMSPlugin;
use Joomla\Database\DatabaseDriver;
use React\Promise\Stream;

defined('_JEXEC') or die;

require_once __DIR__ . '/vendor/autoload.php';


/**
 * Backend_plugin plugin.
 *
 * @package   joomla
 * @since     1.0.0
 */
class plgSystemBackend_plugin extends CMSPlugin
{
    /**
     * Application object
     *
     * @var    CMSApplication
     * @since  1.0.0
     */
    protected $app;

    /**
     * Database object
     *
     * @var    DatabaseDriver
     * @since  1.0.0
     */
    protected $db;

    /**
     * Affects constructor behavior. If true, language files will be loaded automatically.
     *
     * @var    boolean
     * @since  1.0.0
     */
    protected $autoloadLanguage = true;

    /**
     * onAfterInitialise.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterInitialise()
    {
    }

    /**
     * onAfterRoute.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterRoute()
    {

    }

    /**
     * onAfterDispatch.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterDispatch()
    {

    }

    /**
     * onAfterRender.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterRender()
    {

    }

    public function onBeforeRender()
    {
        if ($this->app->getDocument()->getMimeEncoding() == "text/event-stream") {

            // Access to plugin parameters
//            $base_url = $this->params->get('base_url', 'https://tech.cluster.smartpoke.es/test-sd');
            $jinput = $this->app->input;
            $base_url = $this->params->get($jinput->get('base_url'));
            $resourcePath = $jinput->get('resource_path', null, 'STRING');

            header("Cache-Control: no-cache");
            header("Content-Type: text/event-stream");
            $this->download($base_url.$resourcePath);
        }
    }

    private function download($url) {
        ob_implicit_flush(true);
        $loop = React\EventLoop\Factory::create();
        $client = new React\HttpClient\Client($loop);

        $request = $client->request('GET', $url);
        $request->on('response', function ($response) {
            $response->on('data', function ($chunk) {
                echo $chunk;
            });
            $response->on('end', function() {
                echo "event: complete \n";
                $curDate = date(DATE_ISO8601);
                echo 'data: {"time": "' . $curDate . '"}';
                echo "\n\n";
            });
        });
        $request->on('error', function (\Exception $e) {
            echo $e;
        });
        $request->end();
        $loop->run();
        ob_implicit_flush(false);
    }

    /**
     * onAfterCompileHead.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterCompileHead()
    {

    }

    /**
     * OnAfterCompress.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterCompress()
    {

    }

    /**
     * onAfterRespond.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAfterRespond()
    {

    }

    /**
     * onAjaxSession.
     *
     * @return  void
     *
     * @since   1.0.0
     */
    public function onAjaxBackend_plugin()
    {

    }
}