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
use foundation\helpers\Icon;
use foundation\enum\Enum;

/**
 * Breadcrumbs renders a Foundation breadcrumb
 *
 * @see http://foundation.zurb.com/docs/components/breadcrumbs.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Breadcrumbs extends base\Widget
{
    /**
     * @var boolean whether to HTML encode the link labels.
     */
    public $encodeLabel = true;
    /**
     * @var string the label for the first link in the breadcrumb.
     */
    public $homeLabel;
    /**
     * @var array the url for the first link in the breadcrumb
     */
    public $homeUrl;
    /**
     * @var string the tag name to be used. Possible: 'nav' | 'ul'. Defaults to 'ul'.
     */
    public $tagName = 'ul';
    /**
     * @var array $items the items of breadcrumbs. The format is as follows:
     * <pre>
     *  'label'=>'#',
     *  'label'=>array('url'=>'#', 'options'=>array())
     * </pre>
     */
    public $items = array();


    /**
     * Widget's init method
     */
    public function init()
    {
        parent::init();
        $this->initItems();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        $this->renderItems();
    }

    /**
     * Initializes menu items
     */
    public function initItems()
    {
        if (!empty($this->items)) {
            $links = array();
            if ($this->homeLabel !== false) {
                $label         = $this->homeLabel !== null ? $this->homeLabel : Icon::icon(Enum::ICON_HOME);
                $links[$label] = array('href' => $this->homeUrl !== null ? $this->homeUrl : \Yii::app()->homeUrl);
            }

            foreach ($this->items as $label => $options) {
                if (is_string($label)) {
                    if ($this->encodeLabel)
                        $label = \CHtml::encode($label);
                    if (is_string($options))
                        $links[$label] = array('href' => \CHtml::normalizeUrl($options));
                    else {
                        $url             = ArrayHelper::removeValue($options, 'url', '');
                        $options['href'] = \CHtml::normalizeUrl($url);
                        $links[$label]   = $options;
                    }
                } else
                    $links[$options] = array('href' => '#');
            }
            $this->items = $links;
        }
    }

    /**
     * Renders breadcrumbs
     */
    public function renderItems()
    {
        if (empty($this->items))
            return;

        Html::addCssClass($this->htmlOptions, Enum::BREADCRUMBS);
        echo \CHtml::openTag($this->tagName, $this->htmlOptions);
        foreach ($this->items as $label => $options) {
            $this->renderItem($label, $options);
        }
        echo \CHtml::closeTag($this->tagName);

    }

    /**
     * Generates the rendering of a breadcrumb item
     * @param string $label
     * @param array $options
     */
    public function renderItem($label, $options = array())
    {
        if ($this->tagName === 'nav') {
            $url         = ArrayHelper::removeValue($options, 'href', '#');
            $htmlOptions = ArrayHelper::removeValue($options, 'options', array());
            echo \CHtml::openTag('li', $htmlOptions);
            echo \CHtml::link($label, $url);
            echo \CHtml::closeTag('li');
        } else {
            $htmlOptions = ArrayHelper::removeValue($options, 'options', array());
            echo \CHtml::tag('a', array_merge($htmlOptions, $options), $label);
        }
    }
}