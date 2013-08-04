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
 * Panel renders foundation panels
 *
 * @see http://foundation.zurb.com/docs/components/panels.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Panel
{
    /**
     * Generates a panel
     *
     * @param string $content the content to display
     * @param array $htmlOptions the HTML attributes of the panel
     * @return string
     * @see http://foundation.zurb.com/docs/components/panels.html
     */
    public static function panel($content, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::PANEL, $htmlOptions);
        return \CHtml::tag('div', $htmlOptions, $content);
    }

    /**
     * Generates a callout panel
     *
     * @param string $content the content to display
     * @param array $htmlOptions the HTML attributes of the panel
     * @return string
     */
    public static function callout($content, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::PANEL_CALLOUT, $htmlOptions);
        return static::panel($content, $htmlOptions);
    }
}