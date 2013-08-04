<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

use foundation\helpers\Html;
use foundation\helpers\Foundation;
use foundation\enum\Enum;

/**
 * Pager renders a Foundation pagination component.
 *
 * @see http://foundation.zurb.com/docs/components/pagination.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Pager extends \CLinkPager
{
    const CSS_FIRST_PAGE    = 'arrow';
    const CSS_LAST_PAGE     = 'arrow';
    const CSS_PREVIOUS_PAGE = 'arrow';
    const CSS_NEXT_PAGE     = 'arrow';
    const CSS_HIDDEN_PAGE   = 'hide-for-landscape hide-for-portrait';
    const CSS_SELECTED_PAGE = 'current';
    const CSS_INTERNAL_PAGE = 'page';
    /**
     * @var string the text label for the next page button.
     */
    public $nextPageLabel = '&rsaquo;';
    /**
     * @var string the text label for the previous page button.
     */
    public $prevPageLabel = '&lsaquo;';
    /**
     * @var string the text label for the first page button.
     */
    public $firstPageLabel = '&laquo;';
    /**
     * @var string the text label for the last page button.
     */
    public $lastPageLabel = '&raquo;';
    /**
     * @var boolean whether the "first" and "last" buttons should be hidden.
     * Defaults to false.
     */
    public $hideFirstAndLast = false;
    /**
     * @var bool whether to center the pager or not
     */
    public $centered = true;

    /**
     * Initializes the widget.
     */
    public function init()
    {
        Html::addCssClass($this->htmlOptions, Enum::PAGINATION);
        parent::init();
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        $this->registerClientScript();
        $buttons = $this->createPageButtons();

        if (empty($buttons))
            return true;
        if ($this->centered) {
            echo \CHtml::openTag('div', array('class' => Enum::PAGINATION_CENTERED));
        }
        echo \CHtml::tag('ul', $this->htmlOptions, implode("\n", $buttons));
        if ($this->centered) {
            echo \CHtml::closeTag('div');
        }
    }


    /**
     * Registers the needed CSS file.
     * @param string $url the CSS URL. If null, a default CSS URL will be used.
     */
    public static function registerCssFile($url = null)
    {
        if ($url !== null) {
            \Yii::app()->getClientScript()->registerCssFile($url);

        } else {
            Foundation::registerCoreCss();
        }
    }

    /**
     * Ported from Yii2 widget's function. Creates a widget instance and runs it. We cannot use 'widget' name as it
     * conflicts with CBaseController component.
     *
     * The widget rendering result is returned by this method.
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @return string the rendering result of the widget.
     */
    public static function display($config = array())
    {
        ob_start();
        ob_implicit_flush(false);
        /** @var Widget $widget */
        $config['class'] = get_called_class();
        $widget          = \Yii::createComponent($config);
        $widget->init();
        $widget->run();
        return ob_get_clean();
    }
}
