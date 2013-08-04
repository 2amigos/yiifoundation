<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\widgets\base;

use foundation\exception\InvalidConfigException;

/**
 * Input is the base class for widgets that collect user inputs.
 *
 * @see http://foundation.zurb.com/docs/components/dropdown.html
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\widgets
 */
class Input extends Widget
{
    /**
     * @var CModel the data model associated with this widget.
     */
    public $model;
    /**
     * @var string the attribute associated with this widget.
     * The name can contain square brackets (e.g. 'name[1]') which is used to collect tabular data input.
     */
    public $attribute;
    /**
     * @var string the input name. This must be set if {@link model} is not set.
     */
    public $name;
    /**
     * @var string the input value
     */
    public $value;


    /**
     * @return array the name and the ID of the input.
     * @throws \foundation\exception\InvalidConfigException
     */
    protected function resolveNameID()
    {
        if ($this->name !== null)
            $name = $this->name;
        elseif (isset($this->htmlOptions['name']))
            $name = $this->htmlOptions['name']; elseif ($this->hasModel())
            $name = \CHtml::activeName($this->model, $this->attribute); else
            throw new InvalidConfigException(\Yii::t(
                'yii',
                '{class} must specify "model" and "attribute" or "name" property values.',
                array('{class}' => get_class($this))
            ));

        if (($id = $this->getId(false)) === null) {
            if (isset($this->htmlOptions['id']))
                $id = $this->htmlOptions['id'];
            else
                $id = \CHtml::getIdByName($name);
        }

        return array($name, $id);
    }

    /**
     * @return boolean whether this widget is associated with a data model.
     */
    protected function hasModel()
    {
        return $this->model instanceof CModel && $this->attribute !== null;
    }
}