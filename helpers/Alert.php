<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\helpers;

use foundation\enum\Enum;

/**
 * Alert renders a Foundation alert
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Alert
{
    /**
     * Generates a success alert
     *
     * @param string $content the text within the alert box
     * @param array $htmlOptions the HTML attributes of the alert box
     * @param string $close the label for the close button. Set to false if you don't wish to display it.
     * @return string the alert box
     */
    public static function success($content, $htmlOptions = array(), $close = '&times')
    {
        ArrayHelper::addValue('class', Enum::COLOR_SUCCESS, $htmlOptions);
        return static::alert($content, $htmlOptions, $close);
    }

    /**
     * Generates an red coloured alert box
     *
     * @param string $content the text within the alert box
     * @param array $htmlOptions the HTML attributes of the alert box
     * @param string $close the label for the close button. Set to false if you don't wish to display it.
     * @return string the alert box
     */
    public static function important($content, $htmlOptions = array(), $close = '&times')
    {
        ArrayHelper::addValue('class', Enum::COLOR_ALERT, $htmlOptions);
        return static::alert($content, $htmlOptions, $close);
    }

    /**
     * Generates a secondary alert box
     *
     * @param string $content the text within the alert box
     * @param array $htmlOptions the HTML attributes of the alert box
     * @param string $close the label for the close button. Set to false if you don't wish to display it.
     * @return string the alert box
     */
    public static function secondary($content, $htmlOptions = array(), $close = '&times')
    {
        ArrayHelper::addValue('class', Enum::COLOR_SECONDARY, $htmlOptions);
        return static::alert($content, $htmlOptions, $close);
    }

    /**
     * Returns an alert box
     *
     * @param string $content the text within the alert box
     * @param array $htmlOptions the HTML attributes of the alert box
     * @param string $close the label for the close button. Set to false if you don't wish to display it.
     * @return string the alert box
     * @see http://foundation.zurb.com/docs/components/alert-boxes.html
     */
    public static function alert($content, $htmlOptions = array(), $close = '&times')
    {
        ArrayHelper::addValue('class', 'alert-box', $htmlOptions);

        ob_start();
        echo '<div data-alert ' . \CHtml::renderAttributes($htmlOptions) . '>';
        echo $content;
        if ($close !== false)
            echo static::closeLink($close);
        echo '</div>';
        return ob_get_clean();
    }

    /**
     * Generates a close link.
     * @param string $label the link label text.
     * @param array $htmlOptions additional HTML attributes.
     * @return string the generated link.
     */
    public static function closeLink($label = '&times;', $htmlOptions = array())
    {
        $htmlOptions = ArrayHelper::defaultValue('href', '#', $htmlOptions);
        ArrayHelper::addValue('class', 'close', $htmlOptions);
        return \CHtml::openTag('a', $htmlOptions) . $label . \CHtml::closeTag('a');
    }
}
