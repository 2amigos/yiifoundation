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
 * Reveal renders the markup for the modal dialog plugin of Foundation
 *
 * @see http://foundation.zurb.com/docs/components/reveal.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Reveal extends base\Widget
{
    /**
     * @var string the size of the modal
     */
    public $size = Enum::DIALOG_MEDIUM;
    /**
     * @var string header. The string will be wrapped on a H2 tag
     */
    public $header;
    /**
     * @var array the header html options
     */
    public $headerHtmlOptions = array();
    /**
     * @var string the body of the modal
     */
    public $body;
    /**
     * @var array the plugin options. The following is the list of supported options and their default values:
     *
     * ´´´php
     * array(
     *  'animation' => 'fadeAndPop',
     *  'animationSpeed' => 250,
     *  'closeOnBackgroundClick' => true,
     *  'dismissModalClass' => 'close-reveal-modal',
     *  'bgClass' => 'reveal-modal-bg',
     *  'bg' => 'js:$("reveal-modal-bg")', // jquery element
     *  'css' => array(
     *      'open' => array(
     *          'opacity' => 0,
     *          'visibility' => 'visible',
     *          'display' => 'block'
     *      ),
     *      'close' => array(
     *          'opacity': 1,
     *          'visibility': 'hidden',
     *          'display': 'none'
     *      ),
     *  )
     * ´´´
     */
    public $pluginOptions = array();
    /**
     * @var string[] the events of the modal. The following list is the supported events:
     *
     * - open
     * - opened
     * - close
     * - closed
     */
    public $events = array();
    /**
     * @var array the options for rendering the toggle button tag.
     * The toggle button is used to toggle the visibility of the modal window.
     * If this property is null, no toggle button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to 'Show'.
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://foundation.zurb.com/docs/components/reveal.html)
     * for the supported HTML attributes.
     */
    public $toggleButton;
    /**
     * @var array the options for rendering the close button tag.
     * The close button is displayed in the header of the modal window. Clicking
     * on the button will hide the modal window. If this is null, no close button will be rendered.
     *
     * The following special options are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     * - options: array, the html options fo the button. Forced attribute: array('class' => 'close-reveal-modal')
     *
     * The rest of the options will be rendered as the HTML attributes of the button tag.
     * Please refer to the [Modal plugin help](http://foundation.zurb.com/docs/components/reveal.html)
     * for the supported HTML attributes.
     */
    public $closeButton = array();

    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.reveal.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::DIALOG);
        $this->setId(ArrayHelper::removeValue($this->htmlOptions, 'id', $this->getId()));
        $this->registerClientScript();
        parent::init();

        $this->htmlOptions['id'] = $this->getId();

        echo $this->renderToggleButton() . "\n";
        echo \CHtml::openTag('div', $this->htmlOptions) . "\n";
        echo $this->renderHeader() . "\n";
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo "\n" . $this->body . "\n";
        echo $this->renderCloseButton() . "\n";
        echo \CHtml::closeTag('div') . "\n";
    }

    /**
     * @return string
     */
    public function renderHeader()
    {
        return \CHtml::tag('h2', $this->headerHtmlOptions, $this->header);
    }

    /**
     * Renders the toggle button
     * @return null|string the rendering result
     */
    public function renderToggleButton()
    {
        if ($this->toggleButton !== null) {
            $tag   = ArrayHelper::removeValue($this->toggleButton, 'tag', 'button');
            $label = ArrayHelper::removeValue($this->toggleButton, 'label', 'Show');
            if ($tag === 'button' && !isset($this->toggleButton['type'])) {
                $this->toggleButton['type'] = 'button';
            }
            $this->toggleButton['data-reveal-id'] = $this->getId();
            return \CHtml::tag($tag, $this->toggleButton, $label);
        } else {
            return null;
        }
    }

    /**
     * Renders the close button.
     * @return string the rendering result
     */
    protected function renderCloseButton()
    {
        if ($this->closeButton !== null) {
            $tag   = ArrayHelper::removeValue($this->closeButton, 'tag', 'a');
            $label = ArrayHelper::removeValue($this->closeButton, 'label', '&times;');
            if ($tag === 'button' && !isset($this->closeButton['type'])) {
                $this->closeButton['type'] = 'button';
            }
            Html::addCssClass($this->closeButton, Enum::DIALOG_CLOSE);
            return \CHtml::tag($tag, $this->closeButton, $label);
        } else {
            return null;
        }
    }

    /**
     * Registers plugin options and events (if any)
     */
    public function registerClientScript()
    {
        if (!empty($this->pluginOptions)) {
            $options = \CJavaScript::encode($this->pluginOptions);
            \Yii::app()->clientScript
                ->registerScript('Reveal#' . $this->getId(), "$(document).foundation('reveal', {$options});");
        }

        if (!empty($this->events)) {
            $this->registerEvents("#{$this->getId()}", $this->events);
        }

        // move the reveal to the end of the body tag
        \Yii::app()->clientScript
            ->registerScript('Reveal#placement#' . $this->getId(), "$('#{$this->getId()}').appendTo(document.body);");
    }
}