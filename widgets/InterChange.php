<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

/**
 * InterChange utilizes the data-interchange attribute for specifying your media queries and their respective images.
 *
 * @see http://foundation.zurb.com/docs/components/interchange.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Interchange extends base\Widget
{
    /**
     * @var string the image source
     */
    public $src;
    /**
     * @var array interchange rules. The syntax is:
     *
     * <pre>
     *  'iterchange' => array(
     *      array('pathtoimage', 'rule'),
     *      array('pathtoimage', 'rule')
     * )
     * </pre>
     */
    public $rules = array();


    /**
     * Initializes the widget
     */
    public function init()
    {
        $this->assets = array(
            'js' => YII_DEBUG ? 'foundation/foundation.interchange.js' : 'foundation.min.js'
        );

        $this->htmlOptions['src'] = $this->src;

        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderImage();
    }

    /**
     * Renders the interchange image
     * @return string the resulting img tag
     */
    public function renderImage()
    {
        $rules = array();
        foreach ($this->rules as $rule) {
            $rules[] = '[' . implode(", ", $rule) . ']';
        }
        $this->htmlOptions['data-interchange'] = implode(", ", $rules);
        return \CHtml::tag('img', $this->htmlOptions);
    }
}