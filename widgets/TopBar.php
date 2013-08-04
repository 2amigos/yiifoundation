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
use foundation\helpers\Nav;
use foundation\enum\Enum;
use foundation\exception\InvalidConfigurationException;

/**
 * TopBar widget renders a nav HTML component.
 *
 * For example:
 *
 * <pre>
 * echo TopBar::widget(array(
 *     'leftItems' => array(
 *         array(
 *             'label' => 'Home',
 *             'url' => '/',
 *             'linkOptions' => array(...),
 *             'active' => true,
 *         ),
 *         array(
 *             'label' => 'Dropdown',
 *             'items' => array(
 *                  array(
 *                      'label' => 'Dropdown item A',
 *                      'url' => '#',
 *                  ),
 *                  array(
 *                      'label' => 'Dropdown item B',
 *                      'url' => '#',
 *                  ),
 *             ),
 *         ),
 *     ),
 *      'rightItems' => array(
 *         array(
 *             'label' => 'I am at right',
 *             'url' => '/',
 *             'linkOptions' => array(...),
 *             'active' => true,
 *         ),
 *         array(
 *             'label' => 'Dropdown',
 *             'items' => array(
 *                  array(
 *                      'label' => 'Dropdown item A',
 *                      'url' => '#',
 *                  ),
 *                  array(
 *                      'label' => 'Dropdown item B',
 *                      'url' => '#',
 *                  ),
 *             ),
 *         ),
 *     ),
 * ));
 * </pre>
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class TopBar extends base\Widget
{
    /**
     * @var string $title the menu title
     */
    public $title = '';
    /**
     * @var string $titleUrl the menu url
     */
    public $titleUrl = '#';
    /**
     * @var array $titleOptions the HTML-attributes of the title
     */
    public $titleOptions = array();
    /**
     * @var array list of left menu items in the topbar widget. Each array element represents a single
     * menu item with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - dropdown: array|string, optional, the items configuration array to render [[Nav::dropdown]],
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     */
    public $leftItems = array();
    /**
     * @var array list of right menu items in the topbar widget. Each array element represents a single
     * menu item with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - options: array, optional, the HTML attributes of the item container (LI).
     * - active: boolean, optional, whether the item should be on active state or not.
     * - dropdown: array|string, optional, the items configuration array to render [[Nav::dropdown]],
     *   or a string representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     */
    public $rightItems = array();
    /**
     * @var bool whether the left|right items should be HTML-encoded
     */
    public $encodeLabels = true;
    /**
     * @var bool whether to make the bar fixed or not
     */
    public $fixed = false;
    /**
     * @var bool whether to make the top bar contained to grid.
     */
    public $containToGrid = false;
    /**
     * @var bool whether to make the top bar sticky. Sticky means that when the navigation its the top of the browser, it
     * will act like the fixed top bar and stick to the top as users continue to scroll.
     */
    public $sticky = false;
    /**
     * @var array the HTML-attributes of the layer wrapping the nav tag. If empty, the wrapper wont be displayed.
     */
    protected $wrapperOptions = array();


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.topbar.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::NAV_TOPBAR);
        if ($this->fixed) {
            Html::addCssClass($this->htmlOptions, Enum::NAV_FIXED);
        }
        if ($this->sticky) {
            Html::addCssClass($this->htmlOptions, Enum::NAV_STICKY);
        }
        if ($this->containToGrid) {
            Html::addCssClass($this->htmlOptions, Enum::NAV_CONTAINED);
        }

        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderNavigation();
    }

    /**
     * Renders the navigation
     */
    protected function renderNavigation()
    {
        $nav = array();
        if (!empty($this->wrapperOptions)) {
            $nav[] = \CHtml::openTag('div', $this->wrapperOptions);
        }
        $nav[] = \CHtml::openTag('nav', $this->htmlOptions);
        $nav[] = $this->renderTitle();
        $nav[] = $this->renderItems();
        $nav[] = \CHtml::closeTag('nav');

        if (!empty($this->wrapperOptions)) {
            $nav[] = \CHtml::closeTag('div');
        }
        return implode("\n", $nav);
    }

    /**
     * Renders the title of navigation
     * @return string
     */
    protected function renderTitle()
    {
        $items   = array();
        $title   = \CHtml::tag('h1', array(), \CHtml::link($this->title, $this->titleUrl, $this->titleOptions));
        $items[] = \CHtml::tag('li', array('class' => 'name'), $title);
        $items[] = \CHtml::tag(
            'li',
            array('class' => 'toggle-topbar menu-icon'),
            \CHtml::link('<span>Menu</span>', '#')
        );
        return \CHtml::tag('ul', array('class' => 'title-area'), implode("\n", $items));
    }

    /**
     * Renders widget's items.
     * @return string
     */
    protected function renderItems()
    {
        $items = array();
        if (!empty($this->leftItems)) {
            $tItems = array();
            foreach ($this->leftItems as $item) {
                $tItems[] = $this->renderItem($item);
            }
            $items[] = \CHtml::openTag('ul', array('class' => Enum::POS_LEFT)) . implode(
                    "\n",
                    $tItems
                ) . \CHtml::closeTag(
                    'ul'
                );
        }
        if (!empty($this->rightItems)) {
            $tItems = array();
            foreach ($this->rightItems as $item) {
                $tItems[] = $this->renderItem($item);
            }
            $items[] = \CHtml::openTag('ul', array('class' => Enum::POS_RIGHT)) . implode(
                    "\n",
                    $tItems
                ) . \CHtml::closeTag(
                    'ul'
                );
        }

        return \CHtml::tag('section', array('class' => 'top-bar-section'), implode("\n", $items), true);
    }

    /**
     * Renders a widget's item
     * @param mixed $item the item to render
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    protected function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $label       = $this->encodeLabels ? \CHtml::encode($item['label']) : $item['label'];
        $options     = ArrayHelper::getValue($item, 'options', array());
        $items       = ArrayHelper::getValue($item, 'items');
        $url         = \CHtml::normalizeUrl(ArrayHelper::getValue($item, 'url', '#'));
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', array());

        if (ArrayHelper::getValue($item, Enum::STATE_ACTIVE)) {
            ArrayHelper::addValue('class', Enum::STATE_ACTIVE, $options);
        }

        if ($items !== null) {
            Html::addCssClass($options, Enum::DROPDOWN_HAS);
            if (is_array($items)) {
                $items = Nav::dropdown($items, $this->encodeLabels);
            }
        }

        return \CHtml::tag('li', $options, \CHtml::link($label, $url, $linkOptions) . $items);
    }
}