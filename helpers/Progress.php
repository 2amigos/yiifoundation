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
 * Progress helpers deals with the different progress bars of Foundation.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Progress
{
    /**
     * Generates success coloured progress bar
     * @param $percent
     * @param array $htmlOptions
     * @return string
     */
    public static function success($percent, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::COLOR_SUCCESS, $htmlOptions);
        return static::bar($percent, $htmlOptions);
    }

    public static function important($percent, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::COLOR_ALERT, $htmlOptions);
        return static::bar($percent, $htmlOptions);
    }

    public static function secondary($percent, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::COLOR_SECONDARY, $htmlOptions);
        return static::bar($percent, $htmlOptions);
    }

    public static function bar($percent, $htmlOptions = array())
    {
        $percent = substr(trim($percent), -1) !== '%'
            ? $percent . '%'
            : $percent;

        ArrayHelper::addValue('class', Enum::PROGRESS, $htmlOptions);
        ob_start();
        echo \CHtml::openTag('div', $htmlOptions);
        echo \CHtml::openTag('span', array('class' => Enum::PROGRESS_METER, 'style' => 'width:' . $percent));
        echo \CHtml::closeTag('span');
        echo \CHtml::closeTag('div');
        return ob_get_clean();
    }
}