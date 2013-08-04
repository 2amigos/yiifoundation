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
 * Pricing renders foundation pricing tables
 *
 * @see http://foundation.zurb.com/docs/components/pricing-tables.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Pricing
{
    /**
     *
     * @param $title
     * @param $price
     * @param $description
     * @param array $items
     * @param string/null $button
     * @return string
     */
    public static function table($title, $price, $description, $items = array(), $button = null)
    {
        $list   = array();
        $list[] = \CHtml::tag('li', array('class' => 'title'), $title);
        $list[] = \CHtml::tag('li', array('class' => 'price'), $price);
        $list[] = \CHtml::tag('li', array('class' => 'description'), $description);
        foreach ($items as $item) {
            $list[] = \CHtml::tag('li', array('class' => 'bullet-item'), $item);
        }
        if ($button !== null) {
            $list[] = \CHtml::tag('li', array('class' => 'cta-button'), $button);
        }

        return \CHtml::tag('ul', array('class' => 'pricing-table'), implode("\n", $list));
    }
}