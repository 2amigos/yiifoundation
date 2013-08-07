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
 * Clearing creates responsive lightboxes with any size image
 *
 * @see http://foundation.zurb.com/docs/components/clearing.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Clearing extends base\Widget
{
    /**
     * @var array $items the items to be displayed on the gallery. The syntax is the following:
     *
     * <pre>
     * 'items' => array(
     *      array(
     *          'img' => 'large image source',
     *          'th' => 'thumbnail image',
     *          'featured' => true, // whether is featured image or not
     *          'caption' => 'caption of the image',
     *          'options' => array(...)
     *      )
     * )
     * </pre>
     */
    public $items;


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.clearing.js' : 'foundation.min.js'
        );
        Html::addCssClass($this->htmlOptions, Enum::CLEARING_THUMBS);
        ArrayHelper::addValue('data-clearing', 'data-clearing', $this->htmlOptions);
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderClearing();
    }

    /**
     * Renders the clearing widget
     * @return bool|string the resulting element
     */
    public function renderClearing()
    {
        if (empty($this->items)) {
            return true;
        }
        $list = array();
        foreach ($this->items as $item) {
            $list[] = $this->renderItem($item);
        }
        return \CHtml::tag('ul', $this->htmlOptions, implode("\n", $list));
    }

    /**
     * Renders a clearing (lightbox) item
     * @param array $item
     * @return string the resulting LI tag item
     */
    public function renderItem($item)
    {
        $options = ArrayHelper::getValue($item, 'options', array());
        if (isset($item['featured'])) {
            Html::addCssClass($this->htmlOptions, Enum::ClEARING_FEATURE);
            Html::addCssClass($options, Enum::CLEARING_FEATURE_IMG);
        }
        $imgOptions                 = array();
        $imgOptions['src']          = ArrayHelper::getValue($item, 'th', '#');
        $imgOptions['data-caption'] = ArrayHelper::getValue($item, 'caption', null);
        $imgOptions['class']        = 'th';
        $url                        = ArrayHelper::getValue($item, 'img', '#');

        return \CHtml::tag('li', $options, \CHtml::link(\CHtml::tag('img', $imgOptions), $url));

    }
}