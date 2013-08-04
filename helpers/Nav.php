<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\helpers;

use foundation\enum\Enum;
use foundation\exception\InvalidConfigException;

/**
 * Nav Helper renders different type of navigation markups.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Nav
{

    /**
     * Generates a side nav
     *
     * @param array $items the link items to display as a side nav. The items have the following format:
     * <pre>
     * array('label'=>'Item', 'url'=>'#', 'linkOptions'=>array(), 'itemOptions'=>array())
     * </pre>
     * @param array $htmlOptions
     * @return string
     * @see http://foundation.zurb.com/docs/components/side-nav.html
     */
    public static function side($items, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::NAV_SIDE, $htmlOptions);
        ob_start();
        echo \CHtml::openTag('ul', $htmlOptions);
        foreach ($items as $item) {

            if (is_string($item)) // treat as divider
            echo \CHtml::tag('li', array('class' => Enum::NAV_DIVIDER));
            else {
                $itemOptions = ArrayHelper::getValue($item, 'itemOptions', array());
                $linkOptions = ArrayHelper::getValue($item, 'linkOptions', array());
                $label       = ArrayHelper::getValue($item, 'label', 'Item');
                $url         = ArrayHelper::getValue($item, 'url', '#');

                echo \CHtml::openTag('li', $itemOptions);
                echo \CHtml::link($label, $url, $linkOptions);
                echo \CHtml::closeTag('li');
            }
        }
        echo \CHtml::closeTag('ul');

        return ob_get_clean();
    }

    /**
     * Generates a foundation sub nav
     *
     * @param array $items the link items to display as a side nav. The items have the following format:
     * <pre>
     * array('label'=>'Item', 'url'=>'#', 'linkOptions'=>array(), 'itemOptions'=>array())
     * </pre>
     * @param array $htmlOptions
     * @return string
     * @see http://foundation.zurb.com/docs/components/sub-nav.html
     */
    public static function sub($items, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', Enum::NAV_SUB, $htmlOptions);
        ob_start();
        echo \CHtml::openTag('dl', $htmlOptions);
        foreach ($items as $item) {
            $itemOptions = ArrayHelper::getValue($item, 'itemOptions', array());
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', array());
            $label       = ArrayHelper::getValue($item, 'label', 'Item');
            $url         = ArrayHelper::getValue($item, 'url', '#');
            echo \CHtml::openTag('dt', $itemOptions);
            echo \CHtml::link($label, $url, $linkOptions);
            echo \CHtml::closeTag('dt');
        }
        echo \CHtml::closeTag('dl');

        return ob_get_clean();
    }

    /**
     * Renders menu items. It differs from [[Dropdown]] widget as it is factorial to render multi-level dropdown menus.
     * @param array $items the items to render
     * @param bool $encodeLabels whether to encode link labels or not
     * @return string the resulting dropdown element.
     * @throws \foundation\exception\InvalidConfigException
     */
    public static function dropdown($items, $encodeLabels = true)
    {
        $li = array();
        foreach ($items as $item) {
            if (is_string($item)) {
                $li[] = $item;
                continue;
            }
            if (!isset($item['label'])) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $label       = $encodeLabels ? \CHtml::encode($item['label']) : $item['label'];
            $options     = ArrayHelper::getValue($item, 'options', array());
            $items       = ArrayHelper::getValue($item, 'items');
            $url         = \CHtml::normalizeUrl(ArrayHelper::getValue($item, 'url', '#'));
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', array());

            if (ArrayHelper::getValue($item, 'active')) {
                ArrayHelper::addValue('class', 'active', $options);
            }

            if ($items !== null) {
                ArrayHelper::addValue('class', 'has-dropdown', $options);
                if (is_array($items)) {
                    $items = static::dropdown($items, $encodeLabels);
                }
            }
            $li[] = \CHtml::tag('li', $options, \CHtml::link($label, $url, $linkOptions) . $items);
        }

        return \CHtml::tag('ul', array('class' => 'dropdown'), implode("\n", $li));
    }
}