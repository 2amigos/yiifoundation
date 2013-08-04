<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */

namespace foundation\helpers;

use foundation\widgets\Dropdown;
use foundation\enum\Enum;

/**
 * Button helper renders different foundation buttons
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Button
{
    /**
     * Generates a button
     * @param string $label
     * @param array $htmlOptions
     * @return string the generated button.
     */
    public static function button($label = 'button', $htmlOptions = array())
    {
        $htmlOptions = ArrayHelper::defaultValue('name', \CHtml::ID_PREFIX . \CHtml::$count++, $htmlOptions);
        Html::clientChange('click', $htmlOptions);
        return static::btn('button', $label, $htmlOptions);
    }

    /**
     * Generates a link button.
     * @param string $label the button label text.
     * @param array $htmlOptions the HTML attributes for the button.
     * @return string the generated button.
     */
    public static function link($label = 'submit', $htmlOptions = array())
    {
        ArrayHelper::addValue('class', 'button', $htmlOptions);
        return static::btn('a', $label, $htmlOptions);
    }

    /**
     * Generates a group of link buttons
     * @param array $buttons the link buttons to render in a group
     * @param array $htmlOptions
     * @return string
     * @see http://foundation.zurb.com/docs/components/button-groups.html
     */
    public static function group($buttons, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', 'button-group', $htmlOptions);

        ob_start();
        echo \CHtml::openTag('ul', $htmlOptions);
        foreach ($buttons as $button) {
            echo $button;
        }
        echo \CHtml::closeTag('ul');

        return ob_get_clean();
    }

    /**
     * Generates a button bar by wrapping multiple button groups into a button-bar
     * @param array $groups the button group to wrap
     * @param array $htmlOptions
     * @return string
     */
    public static function bar($groups, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', 'button-bar', $htmlOptions);

        ob_start();
        echo \CHtml::openTag('div', $htmlOptions);
        foreach ($groups as $group) {
            echo $group;
        }
        echo \CHtml::closeTag('div');
        
        return ob_get_clean();
    }

    /**
     * Generates a button.
     * @param string $tag the HTML tag.
     * @param string $label the button label text.
     * @param array $htmlOptions additional HTML attributes.
     * @return string the generated button.
     */
    public static function btn($tag, $label, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', 'button', $htmlOptions);

        $icon = ArrayHelper::removeValue($htmlOptions, 'icon');
        if (isset($icon))
            $label = Icon::icon($icon) . '&nbsp;' . $label;

        return \CHtml::tag($tag, $htmlOptions, $label);
    }

    /**
     * Generates a dropdown button. Important: This method does not formats your list items into links, you have to pass
     * them as link tags. For a more flexible solution use the widget.
     *
     * @param string $label
     * @param array $list of link items to be displayed on the dropdown menu
     * @param array $htmlOptions the HTML attributes. It allows a special attribute `dropHtmlOptions` to set your
     * custom attributes to the dropdown list.
     * @return string
     */
    public static function dropdown($label, $list, $htmlOptions = array())
    {
        $id = Enum::ID_PREFIX . '-' . Html::$count++;

        ArrayHelper::addValue('data-dropdown', $id, $htmlOptions);
        ArrayHelper::addValue('class', Enum::DROPDOWN, $htmlOptions);

        $dropHtmlOptions                          = ArrayHelper::removeValue($htmlOptions, 'dropHtmlOptions', array());
        $dropHtmlOptions['id']                    = $id;
        $dropHtmlOptions['data-dropdown-content'] = '';

        ArrayHelper::addValue('class', Enum::DROPDOWN_LIST, $dropHtmlOptions);

        ob_start();
        echo static::link($label, $htmlOptions);
        echo Dropdown::display(
            array(
                'items'       => $list,
                'htmlOptions' => $dropHtmlOptions
            )
        );
        return ob_get_clean();
    }

    /**
     * Generates a split button.
     * Important: Currently split buttons require the dropdown list items to be rendered before the body tag, so the
     * dropdown list hides on document.click. You will have to click again on dropdown to hide the list.
     * Please, use the button widget for better performance. At the moment, Foundation uses a hack until its new release 4.2
     * @param $label
     * @param $list
     * @param array $htmlOptions
     * @return string
     */
    public static function split($label, $list, $htmlOptions = array())
    {
        $id = Enum::ID_PREFIX . '-' . ++Html::$count;

        ArrayHelper::addValue('class', Enum::DROPDOWN_SPLIT, $htmlOptions);

        $label .= ' <span data-dropdown="' . $id . '"></span>';

        $dropHtmlOptions       = ArrayHelper::removeValue($htmlOptions, 'dropHtmlOptions', array());
        $dropHtmlOptions['id'] = $id;

        ArrayHelper::addValue('class', Enum::DROPDOWN_LIST, $dropHtmlOptions);

        ob_start();
        echo '<div style="position:relative">'; // hack
        echo static::link($label, $htmlOptions);
        echo Dropdown::display(
            array(
                'items'       => $list,
                'htmlOptions' => $dropHtmlOptions
            )
        );
        echo '</div>';
        return ob_get_clean();
    }
}
