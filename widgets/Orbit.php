<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

use foundation\helpers\ArrayHelper;
use foundation\helpers\Html;
use foundation\enum\Enum;

/**
 * Orbit generates a foundation orbits.
 *
 * @see http://foundation.zurb.com/docs/components/orbit.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Orbit extends base\Widget
{
    /**
     * @var array the items to render in the orbit. The syntax is as follows:
     *
     * <pre>
     * 'items' => array(
     *      array('content', 'caption')
     * )
     * </pre>
     */
    public $items = array();

    /**
     * @var array the orbit plugin options. The options are (option: default value):
     *
     * - animation: 'fade'
     * - timer_speed: 10000
     * - pause_on_hover: true
     * - resume_on_mouseout: false
     * - animation_speed: 500
     * - stack_on_small: true
     * - navigation_arrows: true
     * - slide_number: true
     * - container_class: 'orbit-container'
     * - stack_on_small_class: 'orbit-stack-on-small'
     * - next_class: 'orbit-next'
     * - prev_class: 'orbit-prev'
     * - timer_container_class: 'orbit-timer'
     * - timer_paused_class: 'paused'
     * - timer_progress_class: 'orbit-progress'
     * - slides_container_class: 'orbit-slides-container'
     * - bullets_container_class: 'orbit-bullets'
     * - bullets_active_class: 'active'
     * - slide_number_class: 'orbit-slide-number'
     * - caption_class: 'orbit-caption'
     * - active_slide_class: 'active'
     * - orbit_transition_class: 'orbit-transitioning'
     * - bullets: true
     * - timer: true
     * - variable_height: false
     * - before_slide_change: function(){}
     * - after_slide_change: function(){}
     *
     */
    public $pluginOptions = array();
    /**
     * @var string[] the JavaScript event configuration (name=>handler). The following list shows the available ones:
     *
     * - orbit:ready, param: event,    Fires when the slider has loaded
     * - orbit:before-slide-change, param: event, Fires before a slide changes
     * - orbit:after-slide-change, param: event, Fires after a slide transition animation has finished. The orbit
     *  parameter contains slide_number and total_slides.
     * - orbit:timer-started, param: event, Fires each time the timer is started/resumed
     * - orbit:timer-stopped, param: event, Fires each time the timer is paused/stopped
     */
    public $events = array();
    /**
     * @var bool whether to display the preloader or not
     */
    public $showPreloader = true;


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.orbit.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::ORBIT_WRAPPER);
        $this->setId(ArrayHelper::removeValue($this->htmlOptions, 'id', $this->getId()));
        $this->registerClientScript();
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderOrbit();
    }

    /**
     * Renders the orbit plugin
     * @return string the generated HTML string
     */
    public function renderOrbit()
    {
        $contents = $list = array();

        foreach ($this->items as $item) {
            $list[] = $this->renderItem($item);
        }
        if ($this->showPreloader) {
            $contents[] = \CHtml::tag('div', array('class' => Enum::ORBIT_LOADER), '&nbsp;');
        }

        $contents[] = \CHtml::tag(
            'ul',
            array(
                'id'         => $this->getId(),
                'data-orbit' => 'data-orbit'
            ),
            implode("\n", $list)
        );
        return \CHtml::tag('div', $this->htmlOptions, implode("\n", $contents));
    }

    /**
     * Returns a generated LI tag item
     * @param array $item the item configuration
     * @return string the resulting li tag
     */
    public function renderItem($item)
    {
        $content = ArrayHelper::getValue($item, 'content', '');
        $caption = ArrayHelper::getValue($item, 'caption');

        if ($caption !== null) {
            $caption = \CHtml::tag('div', array('class' => Enum::ORBIT_CAPTION), $caption);
        }
        return \CHtml::tag('li', array(), $content . $caption);
    }

    /**
     * Registers the plugin script
     */
    public function registerClientScript()
    {
        if (!empty($this->pluginOptions)) {
            $options = \CJavaScript::encode($this->pluginOptions);
            \Yii::app()->clientScript
                ->registerScript('Orbit#' . $this->getId(), "$(document).foundation('orbit', {$options});");
        }

        if (!empty($this->events)) {
            $this->registerEvents("#{$this->getId()}", $this->events);
        }
    }
}
