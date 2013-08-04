<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */

namespace foundation\helpers;

/**
 * Foundation helper contains functions to work with the core assets.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Foundation
{
    /**
     * @var string holds the url of Foundation's assets folder
     */
    protected static $assetsUrl;

    /**
     * Registers all core css and js scripts for foundation
     */
    public static function register($useZepto = false, $ie8Support = false)
    {
        static::registerCoreCss();
        static::registerCoreScripts($useZepto);

        if ($ie8Support)
            static::registerBlockGridIeSupport();
    }

    /**
     * Registers jQuery and Foundation JavaScript.
     * @param bool $useZepto whether to use zepto or not
     * @param bool $minimized whether to register full minimized library or not
     * @param int $position the position to register the core script
     */
    public static function registerCoreScripts(
        $useZepto = false,
        $minimized = true,
        $position = \CClientScript::POS_END
    ) {
        /** @var CClientScript $cs */
        $cs = \Yii::app()->getClientScript();

        if ($useZepto) {
            $cs->registerScriptFile(static::getAssetsUrl() . '/js/vendor/zepto.js');
        } else {
            $cs->registerCoreScript('jquery');
        }
        // normalizer goes at the head no matter what
        $cs->registerScriptFile(static::getAssetsUrl() . '/js/vendor/custom.modernizr.js', \CClientScript::POS_HEAD);
        $script = $minimized
            ? '/js/foundation.min.js'
            : '/js/foundation/foundation.js';
        $cs->registerScriptFile(static::getAssetsUrl() . $script, $position);
        $cs->registerScript(__CLASS__, '$(document).foundation();');
    }

    /**
     * Checks whether the core script has been registered or not
     * @param bool $minimized whether to check full minimized library or not
     * @param int $position the position to register the core script
     * @return bool
     */
    public static function isCoreRegistered($minimized = true, $position = \CClientScript::POS_END)
    {
        $script = $minimized
            ? '/js/foundation.min.js'
            : '/js/foundation/foundation.js';

        return \Yii::app()->getClientScript()
            ->isScriptFileRegistered(static::getAssetsUrl() . $script, $position);
    }

    /**
     * Registers foundation fonts
     * @param mixed $fonts the array or string name to register.
     */
    public static function registerFonts($fonts = array())
    {
        if (empty($fonts))
            return;

        foreach ($fonts as $font) {
            Icon::registerIconFontSet($font);
        }
    }

    /**
     * Registers the Foundation CSS.
     */
    public static function registerCoreCss()
    {
        $fileName = \YII_DEBUG ? 'foundation.css' : 'foundation.min.css';

        \Yii::app()->clientScript->registerCssFile(static::getAssetsUrl() . '/css/normalize.css');
        \Yii::app()->clientScript->registerCssFile(static::getAssetsUrl() . '/css/' . $fileName);
    }

    /**
     * Returns the url to the published assets folder.
     * @param bool $forceCopyAssets whether to force assets registration or not
     * @param bool $cdn whether to use CDN version or not
     * @return string the url.
     */
    public static function getAssetsUrl($forceCopyAssets = false, $cdn = false)
    {
        if (!isset(static::$assetsUrl)) {
            if ($cdn) {
                static::$assetsUrl = '//cdn.jsdelivr.net/foundation/4.3.1/';
            } else {
                $assetsPath        = static::getAssetsPath();
                static::$assetsUrl = \Yii::app()->assetManager->publish($assetsPath, true, -1, $forceCopyAssets);
            }
        }
        return static::$assetsUrl;
    }

    /**
     * Returns the full path of foundation assets
     * @return mixed the full path
     */
    public static function getAssetsPath()
    {
        return \Yii::getPathOfAlias('foundation.assets');
    }

    /**
     * Registers a specific plugin using the given selector and options.
     * @param string $name the plugin name.
     * @param string $selector the CSS selector.
     * @param array $options the JavaScript options for the plugin.
     * @param int $position the position of the JavaScript code.
     */
    public static function registerPlugin($name, $selector, $options = array(), $position = \CClientScript::POS_READY)
    {
        $options = !empty($options) ? \CJavaScript::encode($options) : '';
        $script  = ";jQuery('{$selector}').{$name}({$options});";
        \Yii::app()->clientScript->registerScript(static::getUniqueScriptId(), $script, $position);
    }

    /**
     * Registers a specific js assets file
     * @param string $asset the assets file (ie 'foundation/foundation.abide.js'
     * @param int $position the position where the script should be registered on the page
     */
    public static function registerScriptFile($asset, $position = \CClientScript::POS_END)
    {
        \Yii::app()->clientScript->registerScriptFile(static::getAssetsUrl() . "/{$asset}", $position);
    }

    /**
     * Registers events using the given selector.
     * @param string $selector the CSS selector.
     * @param string[] $events the JavaScript event configuration (name=>handler).
     * @param int $position the position of the JavaScript code.
     */
    public static function registerEvents($selector, $events, $position = \CClientScript::POS_READY)
    {
        if (empty($events)) {
            return;
        }

        $script = '';
        foreach ($events as $name => $handler) {
            $handler = ($handler instanceof \CJavaScriptExpression)
                ? $handler
                : new \CJavaScriptExpression($handler);

            $script .= ";jQuery('{$selector}').on('{$name}', {$handler});";
        }
        \Yii::app()->clientScript->registerScript(static::getUniqueScriptId(), $script, $position);
    }

    /**
     * Generates a "somewhat" random id string.
     * @return string the id
     */
    public static function getUniqueScriptId()
    {
        return uniqid(__CLASS__ . '#', true);
    }

    /**
     * Registers block-grid support for ie8 if set by its `ie8Support` attribute.
     * @param int $position the position to render the script
     */
    public static function registerBlockGridIeSupport($position = \CClientScript::POS_END)
    {
        \Yii::app()->getClientScript()
            ->registerScript(
                __CLASS__,
                "(function($){ $(function(){
                $('.block-grid.two-up>li:nth-child(2n+1)').css({clear: 'both'});
                $('.block-grid.three-up>li:nth-child(3n+1)').css({clear: 'both'});
                $('.block-grid.four-up>li:nth-child(4n+1)').css({clear: 'both'});
                $('.block-grid.five-up>li:nth-child(5n+1)').css({clear: 'both'});
                });})(jQuery);
                ",
                $position
            );
    }
}