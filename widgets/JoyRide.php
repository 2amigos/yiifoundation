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
 * JoyRide renders a foundation tour plugin.
 *
 * @see http://foundation.zurb.com/docs/components/joyride.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class JoyRide extends base\Widget
{
    /**
     * @var array plugin initialization options. The following are available:
     *
     * <pre>
     *  array(
     *      'tipLocation'           => 'bottom',            // 'top' or 'bottom' in relation to parent
     *      'nubPosition'           => 'auto',              // override on a per tooltip bases
     *      'scrollSpeed'           => '300',               // Page scrolling speed in milliseconds
     *      'timer'                 => '0',                 // 0 = no timer , all other numbers = timer in milliseconds
     *      'startTimerOnClick      => 'true',              // true or false - true requires clicking the first button start the timer
     *      'startOffset'           => '0',                 // the index of the tooltip you want to start on (index of the li)
     *      'nextButton'            => 'true',              // true or false to control whether a next button is used
     *      'tipAnimation'          => 'fade',              // 'pop' or 'fade' in each tip
     *      'pauseAfter'            => array(),             // array of indexes where to pause the tour after
     *      'tipAnimationFadeSpeed' => '300',               // when tipAnimation = 'fade' this is speed in milliseconds for the transition
     *      'cookieMonster'         => 'false',             // true or false to control whether cookies are used
     *      'cookieName'            => 'joyride',           // Name the cookie you'll use
     *      'cookieDomain'          => 'false',             // Will this cookie be attached to a domain, ie. '.notableapp.com'
     *      'cookieExpires'         => '365',               // set when you would like the cookie to expire.
     *      'tipContainer'          => 'body',              // Where will the tip be attached
     *      'postRideCallback'      => 'js:function (){},   // A method to call once the tour closes (canceled or complete)
     *      'postStepCallback'      => 'js:function (){},   // A method to call after each step
     *      'template' => array( // HTML segments for tip layout
     *          'link' => '<a href="#close" class="joyride-close-tip">&times;</a>',
     *          'timer' => '<div class="joyride-timer-indicator-wrap"><span class="joyride-timer-indicator"></span></div>',
     *          'tip' => '<div class="joyride-tip-guide"><span class="joyride-nub"></span></div>',
     *          'wrapper' => '<div class="joyride-content-wrapper"></div>',
     *          'button' => '<a href="#" class="small button joyride-next-tip"></a>'
     *      ),
     *  )
     * </pre>
     */
    public $pluginOptions = array();
    /**
     * The tour stops. Each stop has the following syntax
     *
     * <pre>
     * 'stops' => array(
     *      array(
     *          'id' => 'id-of-element', // if null will be displayed as a modal
     *          'title' => 'title of the box',
     *          'body' => 'content of the box',
     *          'text' => 'Next', // button text,
     *          'button' => 'Next', // button text,
     *          'class' => 'custom css class',
     *          'options' => array(...), // optional joyride options for the element
     *      )
     * )
     * </pre>
     */
    public $stops = array();
    /**
     * @var bool whether to autostart joyride plugin or not
     */
    public $autoStart = true;


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.joyride.js' : 'foundation.min.js'
        );

        Html::addCssClass($this->htmlOptions, Enum::JOYRIDE_LIST);
        ArrayHelper::addValue('data-joyride', 'data-joyride', $this->htmlOptions);
        $this->registerClientScript();

        parent::init();
    }

    /**
     * Initializes the widget
     */
    public function run()
    {
        echo $this->renderJoyRide();
    }

    public function renderJoyRide()
    {
        if (empty($this->stops)) {
            return true;
        }
        $items = array();

        foreach ($this->stops as $stop) {
            $items[] = $this->renderStop($stop);
        }

        return \CHtml::tag('ol', $this->htmlOptions, implode("\n", $items));
    }

    /**
     * Renders a single stop
     * @param array $stop the stop configuration
     * @return string the resulting li tag
     */
    public function renderStop($stop)
    {
        $options                 = array();
        $options['data-id']      = ArrayHelper::getValue($stop, 'id');
        $options['data-text']    = ArrayHelper::getValue($stop, 'text');
        $options['data-button']  = ArrayHelper::getValue($stop, 'button');
        $options['data-class']   = ArrayHelper::getValue($stop, 'class');
        $options['data-options'] = ArrayHelper::getValue($stop, 'options');
        if ($options['data-options'] !== null) {
            $config = array();
            foreach ($options['data-options'] as $key => $option) {
                $config[] = $key . ':' . $option;
            }
            $options['data-options'] = implode(';', $config);
        }
        $title = ArrayHelper::getValue($stop, 'title');
        if (!empty($title)) {
            $title = "<h4>{$title}</h4>";
        }
        $content = '<p>' . ArrayHelper::getValue($stop, 'body', '') . '</p>';

        return \CHtml::tag('li', $options, $title . $content);
    }

    /**
     * Starts joyride if [[autostart]] has been set to true.
     * @return bool
     */
    public function registerClientScript()
    {
        if (!$this->autoStart) {
            return true;
        }
        $options = !empty($this->pluginOptions)
            ? \CJavaScript::encode($this->pluginOptions)
            : '{}';
        \Yii::app()->clientScript
            ->registerScript('JoyRide#' . $this->getId(), "$(document).foundation('joyride','start',{$options});");
    }
}