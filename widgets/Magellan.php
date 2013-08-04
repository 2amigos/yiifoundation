<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

use foundation\helpers\ArrayHelper;
use foundation\helpers\Nav;
use foundation\enum\Enum;

/**
 * Magellan renders the Magellan Foundation 4 plugin. Magellan is a style agnostic plugin that lets you style a sticky
 * navigation that denotes where you are on the page.
 *
 * @see http://foundation.zurb.com/docs/components/clearing.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Magellan extends base\Widget
{
    /**
     * @var array the navigation items. They have the following syntax:
     *
     * <pre>
     * 'items' => array(
     *      array('id' => 'anchor on page', 'label' => 'item label')
     * )
     * </pre>
     */
    public $items = array();


    /**
     * Widget's initialization widget
     */
    public function init()
    {
        $this->assets                                  = array(
            'js' => YII_DEBUG ? 'foundation/foundation.magellan.js' : 'foundation.min.js'
        );
        $this->htmlOptions['data-magellan-expedition'] = Enum::NAV_FIXED;
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderMagellan();
    }

    /**
     * Renders magellan
     * @return string the resulting tag
     */
    public function renderMagellan()
    {
        $list = array();
        foreach ($this->items as $item) {
            $listItem['url']         = '#' . $item['id'];
            $listItem['label']       = $item['label'];
            $listItem['itemOptions'] = array('data-magellan-arrival' => $item['id']);
            $list[]                  = $listItem;
        }

        return \CHtml::tag('div', $this->htmlOptions, Nav::sub($list));
    }
}