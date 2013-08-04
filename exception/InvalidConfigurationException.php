<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */
namespace foundation\exception;
/**
 * InvalidConfigException represents an exception caused by incorrect object configuration.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\exception
 */
class InvalidConfigException extends \Exception
{
    /**
     * @return string the user-friendly name of this exception
     */
    public function getName()
    {
        return \Yii::t('yii', 'Invalid Configuration');
    }
}