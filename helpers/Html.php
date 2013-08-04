<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */

namespace foundation\helpers;

/**
 * Html holds those modified methods from CHtml required for Foundation helpers and/or widgets.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Html
{
    /**
     * @var integer the counter for generating automatic input field names.
     */
    public static $count = 0;
    /**
     * @var int $_counter private widget counter
     */
    private static $_counter = 0;
    /**
     * Sets the default style for attaching jQuery event handlers.
     *
     * If set to true (default), event handlers are delegated.
     * Event handlers are attached to the document body and can process events
     * from descendant elements that are added to the document at a later time.
     *
     * If set to false, event handlers are directly bound.
     * Event handlers are attached directly to the DOM element, that must already exist
     * on the page. Elements injected into the page at a later time will not be processed.
     *
     * You can override this setting for a particular element by setting the htmlOptions delegate attribute
     * (see {@link clientChange}).
     *
     * For more information about attaching jQuery event handler see {@link http://api.jquery.com/on/}
     * @see http://www.yiiframework.com/doc/api/1.1/CHtml/#clientChange-detail
     * @see clientChange
     */
    public static $liveEvents = true;


    /**
     * Generates the JavaScript with the specified client changes.
     * @param string $event event name (without 'on')
     * @param array $htmlOptions HTML attributes which may contain the following special attributes
     * specifying the client change behaviors:
     * <ul>
     * <li>submit: string, specifies the URL to submit to. If the current element has a parent form, that form will be
     * submitted, and if 'submit' is non-empty its value will replace the form's URL. If there is no parent form the
     * data listed in 'params' will be submitted instead (via POST method), to the URL in 'submit' or the currently
     * requested URL if 'submit' is empty. Please note that if the 'csrf' setting is true, the CSRF token will be
     * included in the params too.</li>
     * <li>params: array, name-value pairs that should be submitted together with the form. This is only used when 'submit' option is specified.</li>
     * <li>csrf: boolean, whether a CSRF token should be automatically included in 'params' when {@link CHttpRequest::enableCsrfValidation} is true. Defaults to false.
     * You may want to set this to be true if there is no enclosing form around this element.
     * This option is meaningful only when 'submit' option is set.</li>
     * <li>return: boolean, the return value of the javascript. Defaults to false, meaning that the execution of
     * javascript would not cause the default behavior of the event.</li>
     * <li>confirm: string, specifies the message that should show in a pop-up confirmation dialog.</li>
     * <li>ajax: array, specifies the AJAX options (see {@link ajax}).</li>
     * <li>live: boolean, whether the event handler should be delegated or directly bound.
     * If not set, {@link liveEvents} will be used. This option has been available since version 1.1.11.</li>
     * </ul>
     * @see http://www.yiiframework.com/doc/api/1.1/CHtml/#clientChange-detail
     */
    public static function clientChange($event, &$htmlOptions)
    {
        if (!isset($htmlOptions['submit']) && !isset($htmlOptions['confirm']) && !isset($htmlOptions['ajax'])) {
            return;
        }

        $live = ArrayHelper::getValue($htmlOptions, 'live', static::$liveEvents);

        $return = (isset($htmlOptions['return']) && $htmlOptions['return'])
            ? 'return true'
            : 'return false';

        if (isset($htmlOptions['on' . $event])) {
            $handler = trim($htmlOptions['on' . $event], ';') . ';';
            unset($htmlOptions['on' . $event]);
        } else {
            $handler = '';
        }

        if (isset($htmlOptions['id'])) {
            $id = $htmlOptions['id'];
        } else {
            $id = $htmlOptions['id'] = isset($htmlOptions['name']) ? $htmlOptions['name'] : CHtml::ID_PREFIX . CHtml::$count++;
        }

        $cs = \Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');

        if (isset($htmlOptions['submit'])) {
            $cs->registerCoreScript('yii');
            $request = \Yii::app()->getRequest();
            if ($request->enableCsrfValidation && isset($htmlOptions['csrf']) && $htmlOptions['csrf']) {
                $htmlOptions['params'][$request->csrfTokenName] = $request->getCsrfToken();
            }
            if (isset($htmlOptions['params'])) {
                $params = \CJavaScript::encode($htmlOptions['params']);
            } else {
                $params = '{}';
            }
            if ($htmlOptions['submit'] !== '') {
                $url = \CJavaScript::quote(\CHtml::normalizeUrl($htmlOptions['submit']));
            } else {
                $url = '';
            }
            $handler .= ";jQuery.yii.submitForm(this,'$url',$params);{$return};";
        }

        if (isset($htmlOptions['ajax'])) {
            $handler .= \CHtml::ajax($htmlOptions['ajax']) . "{$return};";
        }

        if (isset($htmlOptions['confirm'])) {
            $confirm = 'confirm(\'' . \CJavaScript::quote($htmlOptions['confirm']) . '\')';
            if ($handler !== '') {
                $handler = "if($confirm) {" . $handler . "} else return false;";
            } else {
                $handler = "return $confirm;";
            }
        }

        if ($live) {
            $cs->registerScript(
                'Foundation.Html.#' . $id,
                "jQuery('body').on('$event','#$id',function(){{$handler}});"
            );
        } else {
            $cs->registerScript('Foundation.Html.#' . $id, "jQuery('#$id').on('$event', function(){{$handler}});");
        }

        $htmlOptions = ArrayHelper::removeKeys(
            $htmlOptions,
            array(
                'params',
                'submit',
                'ajax',
                'confirm',
                'return',
                'csrf'
            )
        );
    }

    /**
     * Renders a Foundation thumbnail
     * @param $src
     * @param string $url
     * @param array $htmlOptions
     * @return string
     */
    public static function thumb($src, $url = '#', $htmlOptions = array())
    {
        static::addCssClass($htmlOptions, 'th');
        return \CHtml::link(\CHtml::image($src), $url, $htmlOptions);
    }

    /**
     * Adds a CSS class to the specified options.
     * If the CSS class is already in the options, it will not be added again.
     * @param array $options the options to be modified.
     * @param string $class the CSS class to be added
     */
    public static function addCssClass(&$options, $class)
    {
        if (isset($options['class'])) {
            $classes = ' ' . $options['class'] . ' ';
            if (($pos = strpos($classes, ' ' . $class . ' ')) === false) {
                $options['class'] .= ' ' . $class;
            }
        } else {
            $options['class'] = $class;
        }
    }
}