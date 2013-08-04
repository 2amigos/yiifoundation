<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

use foundation\exception\InvalidConfigException;
use foundation\helpers\ArrayHelper;
use foundation\helpers\Html;
use foundation\enum\Enum;
use foundation\exception\InvalidConfigurationException;

/**
 * Alert renders a Foundation style alert from messages stored on user session variables -named Flash messages.
 *
 * @see http://foundation.zurb.com/docs/components/alert-boxes.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Alert extends base\Widget
{
    /**
     * @var array the alerts configurations (style=>config)
     */
    public $config;
    /**
     * @var string|boolean the close link text. If this is set false, no close link will be displayed.
     */
    public $closeText = '&times;';
    /**
     * @var string[] the JavaScript event configuration (name=>handler).
     */
    public $events = array();


    /**
     * Initializes the widget
     * @throws \foundation\exception\InvalidConfigException
     */
    public function init()
    {
        if (is_string($this->config)) {
            throw new InvalidConfigException('"config" must be of type array.');
        }
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.alerts.js' : 'foundation.min.js'
        );

        if (!isset($this->config)) {
            $this->config = array(
                Enum::COLOR_REGULAR   => array(),
                Enum::COLOR_ALERT     => array(),
                Enum::COLOR_SECONDARY => array(),
                Enum::COLOR_SUCCESS   => array(),
            );
        }
        $this->htmlOptions = ArrayHelper::defaultValue('id', $this->getId(), $this->htmlOptions);
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderAlert();
    }

    /**
     * Renders the alert
     * @return string the rendering result
     */
    public function renderAlert()
    {
        $user = \Yii::app()->user;
        if (count($user->getFlashes(false)) == 0) {
            return;
        }
        $alerts = array();
        foreach ($this->config as $style => $config) {
            if ($user->hasFlash($style)) {
                $options = ArrayHelper::getValue($config, 'htmlOptions', array());
                Html::addCssClass($options, $style);
                $close    = ArrayHelper::getValue($config, 'close', '&times;');
                $alerts[] = \foundation\helpers\Alert::alert($user->getFlash($style), $options, $close);
            }
        }
        $this->registerEvents("#{$this->htmlOptions['id']} > .alert-box", $this->events);

        return \CHtml::tag('div', $this->htmlOptions, implode("\n", $alerts));
    }
}
