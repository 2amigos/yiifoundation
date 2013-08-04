<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

use foundation\helpers\Html;
use foundation\enum\Enum;

/**
 * SwitchButton renders a foundation switch.
 *
 * @see http://foundation.zurb.com/docs/components/switch.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class SwitchButton extends base\Input
{
    /**
     * @var string size of the switch button
     */
    public $size = Enum::SIZE_SMALL;
    /**
     * @var string radius style of the switch button
     */
    public $radius = ENum::RADIUS_ROUND;
    /**
     * @var string the On Label
     */
    public $onLabel = 'On';
    /**
     * @var string the Off Label
     */
    public $offLabel = 'Off';


    /**
     * Widget's initialization
     */
    public function init()
    {
        Html::addCssClass($this->htmlOptions, Enum::SWITCH_BUTTON);
        if ($this->size) {
            Html::addCssClass($this->htmlOptions, $this->size);
        }
        if ($this->radius) {
            Html::addCssClass($this->htmlOptions, $this->radius);
        }
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderButtons();
    }

    /**
     * Returns the formatted button
     * @return string the resulting HTML
     */
    public function renderButtons()
    {
        list($name, $id) = $this->resolveNameID();
        $buttons   = array();
        $checked   = $this->hasModel() ? (!$this->model->{$this->attribute}) : true;
        $buttons[] = \CHtml::radioButton($name, $checked, array('id' => $id . '_on', 'value' => 1));
        $buttons[] = \CHtml::label($this->offLabel, $id . '_on');
        $checked   = $checked ? false : true;
        $buttons[] = \CHtml::radioButton($name, $checked, array('id' => $id . '_off', 'value' => 1));
        $buttons[] = \CHtml::label($this->onLabel, $id . '_off');
        $buttons[] = '<span></span>';

        return \CHtml::tag('div', $this->htmlOptions, implode("\n", $buttons));
    }
}