<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\helpers;

/**
 * Typo facilitates the rendering of HTML components as specified on Typography section at Foundation's site. Most
 * common are not included as we believe they can be easily done with [[\CHtml]] yii helper class.
 *
 * @see http://foundation.zurb.com/docs/components/type.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Typo
{
    /**
     * Renders a subheader
     * @param string $text the text to render within
     * @param string $tag the header tag to render. From h1 till h6.
     * @return string the generated subheader
     */
    public static function subHeader($text, $tag = 'h1')
    {
        return \CHtml::tag($tag, array('class' => 'subheader'), $text);
    }

    /**
     * Makes a text italic.
     * @param string $text the text to make italic
     * @param array $htmlOptions the HTML attributes
     * @return string the generated tag
     */
    public static function i($text, $htmlOptions = array())
    {
        return \CHtml::tag('em',$htmlOptions, $text);
    }

    /**
     * Renders a blockquote. Included as they have special style for them.
     * @param string $text the text to render within the blockquote
     * @param array $htmlOptions the HTML attributes
     * @return string the generated blockquote
     */
    public static function blockquote($text, $htmlOptions = array())
    {
        return \CHtml::tag('blockquote', $htmlOptions, $text);
    }

    /**
     * Renders a handy microformat-friendly list for addresses
     * @param string $name
     * @param string $address
     * @param string $locality
     * @param string $state
     * @param string $zip
     * @param string $email
     * @return string the generated vcard
     */
    public static function vCard($name, $address = '', $locality = '', $state = '', $zip = '', $email = '')
    {
        $items   = array();
        $items[] = \CHtml::tag('li', array('class' => 'fn'), $name);
        $items[] = \CHtml::tag('li', array('class' => 'street-address'), $address);
        $items[] = \CHtml::tag('li', array('class' => 'locality'), $locality);
        $sub     = array();
        $sub[]   = \CHtml::tag('span', array('class' => 'state'), $state);
        $sub[]   = \CHtml::tag('span', array('class' => 'zip'), $zip);
        $items[] = \CHtml::tag('li', array(), implode(", ", $sub));
        $items[] = \CHtml::tag('li', array('class' => 'email'), $email);

        return \CHtml::tag('ul', array('class' => 'vcard'), implode("\n", $items));
    }

    /**
     * Renders and inline list
     * @param array $items the items to render
     * @param array $htmlOptions the HTML attributes
     * @return string the generated list
     */
    public static function inlineList($items, $htmlOptions = array())
    {
        $listItems = array();
        Html::addCssClass($htmlOptions, 'inline-list');
        foreach ($items as $item) {
            $listItems[] = \CHtml::tag('li', $htmlOptions, $item);
        }

        if (!empty($listItems)) {
            return \CHtml::tag('ul', $htmlOptions, implode("\n", $listItems));
        }
    }

    /**
     * Renders a Foundation label
     * @param string $text the text to render within the label
     * @param array $htmlOptions the HTML attributes
     * @return string the generated label
     */
    public static function label($text, $htmlOptions = array())
    {
        ArrayHelper::addValue('class', 'label', $htmlOptions);
        return \CHtml::tag('span', $htmlOptions, $text);
    }

    /**
     * Renders a special kbd tag
     * @param string $text the text (command) to render within
     * @param array $htmlOptions the HTML attributes
     * @return string the generated tag
     */
    public static function kbd($text, $htmlOptions = array())
    {
        return \CHtml::tag('kbd', $htmlOptions, $text);
    }
}
