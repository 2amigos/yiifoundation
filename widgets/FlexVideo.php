<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets;

use foundation\helpers\Html;
use foundation\enum\Enum;
use foundation\exception\InvalidConfigException;

/**
 * FlexVideo embeds a video from YouTube, Vimeo or another site that uses iframe, embed or object elements, creating
 * an intrinsic ration that will properly scale the video to any device.
 *
 * @see http://foundation.zurb.com/docs/components/flex-video.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class FlexVideo extends base\Widget
{
    /**
     * @var string the source of the video
     */
    public $source;
    /**
     * @var int the width of the video
     */
    public $width = 420;
    /**
     * @var int the height of the video
     */
    public $height = 315;
    /**
     * @var bool whether to allow fullscreen or not
     */
    public $allowFullScreen = true;
    /**
     * @var bool whether to give the player a widescreen aspect ratio or not
     */
    public $widescreen = false;
    /**
     * @var bool whether to ensure not adding extra padding since Vimeo has control with the player, itself
     */
    public $vimeo = false;


    /**
     * Initializes the widget
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->source === null) {
            throw new InvalidConfigException('"source" cannot be null.');
        }
        Html::addCssClass($this->htmlOptions, Enum::VIDEO_FLEXVIDEO);
        if ($this->widescreen) {
            Html::addCssClass($this->htmlOptions, Enum::VIDEO_WIDESCREEN);
        }
        if ($this->vimeo) {
            Html::addCssClass($this->htmlOptions, Enum::VIDEO_VIMEO);
        }
        parent::init();
    }

    /**
     * Renders the widget
     */
    public function run()
    {
        echo $this->renderVideo();
    }

    /**
     * Renders video
     * @return string the resulting tag
     */
    public function renderVideo()
    {
        $iframe = \CHtml::openTag(
            'iframe',
            array(
                'height'          => $this->height,
                'width'           => $this->width,
                'src'             => $this->source,
                'allowfullscreen' => $this->allowFullScreen ? 'allowfullscreen' : null,
                'frameborder'     => 0,
            )
        );
        $iframe .= \CHtml::closeTag('iframe');
        return \CHtml::tag('div', $this->htmlOptions, $iframe);
    }
}