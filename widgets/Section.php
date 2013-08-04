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
 * Section renders Foundation sections, which are similar to tabs as a way to selectively show a single panel of content
 * at a time. Sections replace Accordion, Tabs, Vertical Nav & Horizontal Nav.
 *
 * For example:
 *
 * <pre>
 * echo Tabs::widget(array(
 *     'items' => array(
 *         array(
 *             'label' => 'One',
 *             'content' => 'Anim pariatur cliche...',
 *             'active' => true
 *         ),
 *         array(
 *             'label' => 'Two',
 *             'content' => 'Anim pariatur cliche...',
 *             'options' => array('id' => 'myveryownID'),
 *         ),
 *     ),
 * ));
 * </pre>
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class Section extends base\Widget
{

    /**
     * @var array list of tabs in the tabs widget. Each array element represents a single
     * tab with the following structure:
     *
     * - label: string, required, the tab header label.
     * - headerOptions: array, optional, the HTML attributes of the tab header.
     * - content: array, required if `items` is not set. The content (HTML) of the section pane.
     * - options: array, optional, the HTML attributes of the content pane container.
     * - active: boolean, optional, whether the item section header and pane should be visible or not.
     */
    public $items = array();
    /**
     * @var string style of the sections. Defaults to 'auto', which means that will switch between tabs and
     * accordion based on the resolution of the device.
     */
    public $style = Enum::SECTION_STYLE_AUTO;
    /**
     * @var array the plugin options. The following is the list of supported options and their default values:
     *
     * ´´´php
     * array(
     *  'deep_linking' => 'false',
     *  'one_up' => 'true',
     *  'rtl' => 'false',
     *  'callback' => 'js:function(){}',
     * )
     * ´´´
     */
    public $pluginOptions = array();

    /**
     * Initilizes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.section.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::SECTION_CONTAINER);
        Html::addCssClass($this->htmlOptions, $this->style);
        ArrayHelper::addValue('data-section', $this->style, $this->htmlOptions);
        $this->registerClientScript();
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderSection();
    }

    /**
     * Renders the section
     * @return string the rendering result
     */
    public function renderSection()
    {
        $sections = array();
        foreach ($this->items as $item) {
            $sections[] = $this->renderItem($item);
        }
        return \CHtml::tag('div', $this->htmlOptions, implode("\n", $sections));
    }

    /**
     * Renders a section item
     * @param array $item the section item
     * @return string the section result
     */
    public function renderItem($item)
    {
        $sectionItem   = array();
        $sectionItem[] = \CHtml::tag(
            'p',
            array('class' => 'title', 'data-section-title' => 'data-section-title'),
            \CHtml::link(ArrayHelper::getValue($item, 'label', 'Section Title'), '#')
        );
        $options       = ArrayHelper::getValue($item, 'options', array());
        Html::addCssClass($options, 'content');
        ArrayHelper::addValue('data-section-content', 'data-section-content', $options);
        $sectionOptions = array();
        if (ArrayHelper::getValue($item, 'active')) {
            ArrayHelper::addValue('class', 'active', $sectionOptions);
        }
        $sectionItem[] = \CHtml::tag('div', $options, ArrayHelper::getValue($item, 'content', 'Section Content'));
        return \CHtml::tag('section', $sectionOptions, implode("\n", $sectionItem));
    }

    /**
     * Registers the client options to initialize the plugin -if set.
     */
    public function registerClientScript()
    {
        if (!empty($this->pluginOptions)) {
            $options = \CJavaScript::encode($this->pluginOptions);
            \Yii::app()->clientScript
                ->registerScript('Section#' . $this->getId(), "$(document).foundation('section', {$options}");
        }
    }
}