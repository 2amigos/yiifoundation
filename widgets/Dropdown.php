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
use foundation\exception\InvalidConfigurationException;

/**
 * Dropdown renders a foundation dropdown. It differs from MenuDropdown helper.
 *
 * @see http://foundation.zurb.com/docs/components/dropdown.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Dropdown extends base\Widget
{
    /**
     * @var array list of menu items in the dropdown. Each array element represents a single
     * menu with the following structure:
     * - label: string, required, the label of the item link
     * - url: string, optional, the url of the item link. Defaults to "#".
     * - linkOptions: array, optional, the HTML attributes of the item link.
     * - options: array, optional, the HTML attributes of the item.
     *
     * If its a content dropdown style, this property will be ignored and will $dropdownContent used instead.
     */
    public $items = array();
    /**
     * @var string the content to be rendered if $type = '
     */
    public $dropdownContent = '';
    /**
     * @var string $type the type of dropdown, whether is Enum::DROPDOWN_CONTENT or Enum::DROPDOWN_LIST
     */
    public $type = Enum::DROPDOWN_LIST;
    /**
     * @var boolean whether the labels for header items should be HTML-encoded.
     */
    public $encodeLabels = true;


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.dropdown.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::DROPDOWN_LIST);
        ArrayHelper::addValue('data-dropdown-content', '-', $this->htmlOptions);

        if ($this->type === Enum::DROPDOWN_CONTENT) {
            Html::addCssClass($this->htmlOptions, Enum::CONTENT);
        }

        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderItems();
    }

    /**
     * Renders dropdown items
     * @return string
     * @throws InvalidConfigException
     */
    protected function renderItems()
    {
        $lines = array();

        if ($this->type === Enum::DROPDOWN_CONTENT) {
            $lines[] = $this->dropdownContent;
        }
        if ($this->type === Enum::DROPDOWN_LIST) {
            foreach ($this->items as $item) {
                if (is_string($item)) {
                    $lines[] = $item;
                    continue;
                }
                if (!isset($item['label'])) {
                    throw new InvalidConfigException("The 'label' option is required.");
                }
                $label                   = $this->encodeLabels ? \CHtml::encode($item['label']) : $item['label'];
                $options                 = ArrayHelper::getValue($item, 'options', array());
                $linkOptions             = ArrayHelper::getValue($item, 'linkOptions', array());
                $linkOptions['tabindex'] = '-1';
                $content                 = \CHtml::link($label, ArrayHelper::getValue($item, 'url', '#'), $linkOptions);

                $lines[] = \CHtml::tag('li', $options, $content);
            }
        }

        return \CHtml::tag('ul', $this->htmlOptions, implode("\n", $lines));
    }
}