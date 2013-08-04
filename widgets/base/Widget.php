<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets\base;

use foundation\helpers\Foundation;

/**
 * Class Widget
 * @package foundation\widgets\base
 */
class Widget extends \CWidget
{

    /**
     * @var array the HTML attributes for the breadcrumbs.
     */
    public $htmlOptions = array();
    /**
     * @var array list of links to appear in the breadcrumbs.
     */
    public $links = array();
    /**
     * @var array list of the assets the plugin requires. it holds the following format:
     * <pre>
     *  'assets' => array(
     *      'css' => 'file.css',
     *      'js' => 'file.js')
     *  ),
     * ...
     *  'assets' => array(
     *      'css' => array(
     *          'file1.css',
     *          'file2.css'
     *      ),
     *      'js' => array(
     *          'file1.js',
     *          'file2.js'
     *      )
     *  )
     * </pre>
     */
    public $assets = array();


    /**
     * Initializes the widget
     */
    public function init()
    {
        Foundation::registerCoreCss();
        Foundation::registerCoreScripts(false, !YII_DEBUG, \CClientScript::POS_HEAD);
        $this->registerAssets();
    }

    /**
     * Registers a specific plugin using the given selector and options.
     * @param string $name the plugin name.
     * @param string $selector the CSS selector.
     * @param array $options the JavaScript options for the plugin.
     * @param int $position the position of the JavaScript code.
     */
    public function registerPlugin($name, $selector, $options = array(), $position = \CClientScript::POS_READY)
    {
        Foundation::registerPlugin($name, $selector, $options, $position);
    }

    /**
     * Registers events using the given selector.
     * @param string $selector the CSS selector.
     * @param string[] $events the JavaScript event configuration (name=>handler).
     * @param int $position the position of the JavaScript code.
     */
    public function registerEvents($selector, $events, $position = \CClientScript::POS_READY)
    {
        Foundation::registerEvents($selector, $events, $position);
    }

    /**
     * Registers the assets. Makes sure the assets pre-existed on the published folder prior registration.
     */
    public function registerAssets()
    {
        // make sure core hasn't been registered previously

        $dirs = array('css', 'js');
        foreach ($this->assets as $key => $files) {
            if (in_array($key, $dirs)) {
                $files = is_array($files) ? $files : array($files);
                foreach ($files as $file) {
                    $filePath = Foundation::getAssetsPath() . DIRECTORY_SEPARATOR . $key . DIRECTORY_SEPARATOR . $file;
                    if (file_exists($filePath) && is_file($filePath)) {
                        $method = strcasecmp($key, 'css') === 0 ? 'registerCssFile' : 'registerScriptFile';
                        call_user_func(
                            array(\Yii::app()->clientScript, "$method"),
                            Foundation::getAssetsUrl() . "/$key/$file"
                        );
                    }
                }
            }
        }

    }

    /**
     * Ported from Yii2 widget's function. Creates a widget instance and runs it. We cannot use 'widget' name as it
     * conflicts with CBaseController component.
     *
     * The widget rendering result is returned by this method.
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @return string the rendering result of the widget.
     */
    public static function display($config = array())
    {
        ob_start();
        ob_implicit_flush(false);
        /** @var Widget $widget */
        $config['class'] = get_called_class();
        $widget          = \Yii::createComponent($config);
        $widget->init();
        $widget->run();
        return ob_get_clean();
    }
}