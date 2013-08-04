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
 * Tooltip renders Foundation tooltips
 *
 * @see http://foundation.zurb.com/docs/components/reveal.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Tooltip extends base\Widget
{
    /**
     * @var string the tooltip text
     */
    public $tip;
    /**
     * @var string the text that will trigger the tooltip on hover
     */
    public $text;
    /**
     * @var string the position of the tooltip
     */
    public $position = Enum::TOOLTIP_TOP;
    /**
     * @var array the options of the plugin. For more information, see
     * http://foundation.zurb.com/docs/components/tooltips.html
     */
    public $pluginOptions = array();


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.tooltips.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::TOOLTIP);
        Html::addCssClass($this->htmlOptions, $this->position);
        ArrayHelper::addValue('title', $this->tip, $this->htmlOptions);
        ArrayHelper::addValue('data-tooltip', 'data-tooltip', $this->htmlOptions);
        if ($this->tip === null || $this->text === null) {
            throw new InvalidConfigException('"tip" and "text" cannot be null.');
        }
        $this->registerClientScript();

        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderTooltip();
    }

    /**
     * Returns the tooltip tag
     * @return string the rendering result
     */
    public function renderTooltip()
    {
        return \CHtml::tag('span', $this->htmlOptions, $this->text);
    }

    /**
     * Registers plugin options and events (if any)
     */
    public function registerClientScript()
    {
        if (!empty($this->pluginOptions)) {
            $options = \CJavaScript::encode($this->pluginOptions);
            \Yii::app()->clientScript
                ->registerScript('Tooltip#' . $this->getId(), "$(document).foundation('tooltip', {$options});");
        }
    }
}