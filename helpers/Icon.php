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
 * Icon helper contains methods to work with Foundation icons -ie assets registrations (fonts), icon rendering.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Icon
{
    /**
     * Generates an icon.
     * @param string $icon the icon type.
     * @param array $htmlOptions additional HTML attributes.
     * @param string $tagName the icon HTML tag.
     * @return string the generated icon.
     */
    public static function icon($icon, $htmlOptions = array(), $tagName = 'i')
    {
        if (is_string($icon)) {
            if (strpos($icon, 'foundicon-') === false) {
                $icon = 'foundicon-' . implode(' foundicon-', array_unique(explode(' ', $icon)));
            }
            ArrayHelper::addValue('class', $icon, $htmlOptions);
            return \CHtml::openTag($tagName, $htmlOptions) . \CHtml::closeTag($tagName);
        }
        return '';
    }

    /**
     * Registers a specific Icon Set. They are registered individually
     * @param $fontName
     * @param $forceCopyAssets
     * @return bool
     */
    public static function registerIconFontSet($fontName, $forceCopyAssets = false)
    {
        if (!in_array($fontName, static::getAvailableIconFontSets())) {
            return false;
        }

        $fontPath = \Yii::getPathOfAlias('foundation.fonts.foundation_icons_' . $fontName);
        $fontUrl  = \Yii::app()->assetManager->publish($fontPath, true, -1, $forceCopyAssets);

        \Yii::app()->clientScript->registerCssFile($fontUrl . "/stylesheets/{$fontName}_foundicons.css");

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
            \Yii::app()->clientScript->registerCssFile($fontUrl . "/stylesheets/{$fontName}_foundicons_ie7.css");
        }
    }

    /**
     * Returns foundation available sets
     * @return array the available sets
     */
    public static function getAvailableIconFontSets()
    {
        return array(
            Enum::ICONS_SET_ACCESSIBILITY,
            Enum::ICONS_SET_GENERAL,
            Enum::ICONS_SET_GENERAL_ENCLOSED,
            Enum::ICONS_SET_SOCIAL
        );
    }
}