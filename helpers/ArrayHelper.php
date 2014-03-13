<?php
/**
 * @copyright Copyright &copy; 2amigOS! Consulting Group 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package foundation.components
 * @version 1.0.0
 */

namespace foundation\helpers;

/**
 * ArrayHelper has array utility methods
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @package foundation\helpers
 */
class ArrayHelper
{
    /**
     * Copies the values from one option array to another.
     * @param array $names the items names to copy.
     * @param array $from the items to copy from.
     * @param array $to the items to copy to.
     * @return array with copied items.
     */
    public static function copy($names, $from, &$to)
    {
        if (is_array($from) && is_array($to)) {
            foreach ($names as $key) {
                if (isset($from[$key]) && !isset($to[$key])) {
                    $to[$key] = static::getValue($from, $key);
                }
            }
        }
        return $to;
    }

    /**
     * Moves the item values from one array to another.
     * @param array $names the item names to move.
     * @param array $from the values to move from.
     * @param array $to the items to move to.
     * @return array with moved items.
     */
    public static function move($names, &$from, &$to)
    {
        if (is_array($from) && is_array($to)) {
            foreach ($names as $key) {
                if (isset($from[$key]) && !isset($to[$key])) {
                    $to[$key] = static::getValue($from, $key);
                    $moved[$key] = static::removeValue($from, $key);
                }
            }
        }
        return $moved;
    }

    /**
     * Sets multiple default values for the given array.
     * @param array $array the items to set defaults for.
     * @param array $defaults the default items.
     * @return array the array with default values.
     */
    public static function multipleDefaultValues($array, $defaults)
    {
        foreach ($defaults as $name => $value) {
            $array = static::defaultValue($name, $value, $array);
        }

        return $array;
    }

    /**
     * Sets the default value for an item in the given array.
     * @param string $name the name of the item.
     * @param mixed $value the default value.
     * @param array $array the items.
     * @return mixed
     */
    public static function defaultValue($name, $value, $array)
    {
        if (!isset($array[$name]))
            $array[$name] = $value;

        return $array;
    }

    /**
     * Adds a new option to the given array. If the key does not exists, it will create one, if it exists it will append
     * the value and also makes sure the uniqueness of them.
     *
     * @param string $key the key name at the array
     * @param string $value the value to add / append
     * @param array $array the options to modify
     * @param string $glue how the values will be joined
     * @return array
     */
    public static function addValue($key, $value, &$array, $glue = ' ')
    {
        if (isset($array[$key])) {
            if (!is_array($array[$key]))
                $array[$key] = explode($glue, $array[$key]);
            $array[$key][] = $value;
            $array[$key]   = array_unique($array[$key]);
            $array[$key]   = implode($glue, $array[$key]);
        } else
            $array[$key] = $value;
        return $array;
    }

    /**
     * Retrieves the value of an array element or object property with the given key or property name.
     * If the key does not exist in the array, the default value will be returned instead.
     *
     * @param array|object $array array or object to extract value from
     * @param string|\Closure $key key name of the array element, or property name of the object,
     * or an anonymous function returning the value. The anonymous function signature should be:
     * `function($array, $defaultValue)`.
     * @param mixed $default the default value to be returned if the specified key does not exist
     * @return mixed the value of the
     */
    public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        } elseif (is_array($array)) {
            return isset($array[$key]) || array_key_exists($key, $array) ? $array[$key] : $default;
        } else {
            return $array->$key;
        }
    }

    /**
     * Removes an item from the given options and returns the value.
     *
     * If no key is found, then default value will be returned.
     *
     * @param $array
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function removeValue(&$array, $key, $default = null)
    {
        if (is_array($array)) {
            $value = static::getValue($array, $key, $default);
            unset($array[$key]);
            return static::value($value);
        }
        return self::value($default);
    }

    /**
     * Removes the array values from the given array.
     * @param array $array the items to remove from.
     * @param array $names names to remove from the array.
     * @return array the items.
     */
    public static function removeKeys($array, $names)
    {
        return array_diff_key($array, array_flip($names));
    }

    /**
     * Divide an array into two arrays. One with keys and the other with values.
     *
     * @param  array $array
     * @return array
     */
    public static function divide($array)
    {
        return array(array_keys($array), array_values($array));
    }

    /**
     * Pluck an array of values from an array.
     *
     * @param  array $array
     * @param  string $key
     * @return array
     */
    public static function pluck($array, $key)
    {
        return array_map(
            function ($v) use ($key) {
                return is_object($v) ? $v->$key : $v[$key];

            },
            $array
        );
    }

    /**
     * Get a subset of the items from the given array.
     *
     * @param  array $array
     * @param  array $keys
     * @return array
     */
    public static function only($array, $keys)
    {
        return array_intersect_key($array, array_flip((array)$keys));
    }

    /**
     * Get all of the given array except for a specified array of items.
     *
     * @param  array $array
     * @param  array $keys
     * @return array
     */
    public static function except($array, $keys)
    {
        return array_diff_key($array, array_flip((array)$keys));
    }

    /**
     * Return the first element in an array which passes a given truth test.
     *
     * <code>
     *        // Return the first array element that equals "Taylor"
     *        $value = ArrayX::first($array, function($k, $v) {return $v == 'Taylor';});
     *
     *        // Return a default value if no matching element is found
     *        $value = ArrayX::first($array, function($k, $v) {return $v == 'Taylor'}, 'Default');
     * </code>
     *
     * @param  array $array
     * @param  Closure $callback
     * @param  mixed $default
     * @return mixed
     */
    public static function first($array, $callback, $default = null)
    {
        foreach ($array as $key => $value) {
            if (call_user_func($callback, $key, $value)) {
                return $value;
            }
        }

        return self::value($default);
    }

    /**
     * Return the first element of an array.
     *
     * This is simply a convenient wrapper around the "reset" method.
     *
     * @param  array $array
     * @return mixed
     */
    public static function head($array)
    {
        return reset($array);
    }

    /**
     * Merges two or more arrays into one recursively.
     * If each array has an element with the same string key value, the latter
     * will overwrite the former (different from array_merge_recursive).
     * Recursive merging will be conducted if both arrays have an element of array
     * type and are having the same key.
     * For integer-keyed elements, the elements from the latter array will
     * be appended to the former array.
     * @param array $a array to be merged to
     * @param array $b array to be merged from. You can specifiy additional
     * arrays via third argument, fourth argument etc.
     * @return array the merged array (the original arrays are not changed.)
     */
    public static function merge($a, $b)
    {
        $args = func_get_args();
        $res  = array_shift($args);
        while (!empty($args)) {
            $next = array_shift($args);
            foreach ($next as $k => $v) {
                if (is_integer($k)) {
                    isset($res[$k]) ? $res[] = $v : $res[$k] = $v;
                } elseif (is_array($v) && isset($res[$k]) && is_array($res[$k])) {
                    $res[$k] = static::merge($res[$k], $v);
                } else {
                    $res[$k] = $v;
                }
            }
        }
        return $res;
    }

    /**
     * Searches for a given value in an array of arrays, objects and scalar
     * values. You can optionally specify a field of the nested arrays and
     * objects to search in.
     *
     * Credits to Util.php
     *
     * @param array $array  The array to search
     * @param string $search The value to search for
     * @param bool $field The field to search in, if not specified all fields will be searched
     * @return bool|mixed|string false on failure or the array key on
     * @link https://github.com/brandonwamboldt/utilphp/blob/master/util.php
     */
    public static function search(array $array, $search, $field = false)
    {
        $search = (string)$search;

        foreach ($array as $key => $elem) {

            $key = (string)$key;

            if ($field) {
                if ((is_object($elem) && $elem->{$field} === $search)
                    || (is_array($elem) && $elem[$field] === $search)
                    || (is_scalar($elem) && $elem === $search)
                ) {
                    return $key;
                }

            } else {
                if (is_object($elem)) {
                    $elem = (array)$elem;

                    if (in_array($search, $elem)) {
                        return $key;
                    }
                } else {
                    if ((is_array($elem) && in_array($search, $elem)) || (is_scalar($elem) && $elem === $search)) {
                        return $key;
                    }
                }
            }
        }
        return false;
    }

    /**
     * Returns an array containing all the elements of arr1 after applying
     * the callback function to each one.
     *
     * Credits to Util.php
     *
     * @param array $array an array to run through the callback function
     * @param $callback Callback function to run for each element in each array
     * @param bool $on_nonscalar whether or not to call the callback function on nonscalar values (objects, resr, etc)
     * @return array
     * @link https://github.com/brandonwamboldt/utilphp/blob/master/util.php
     */
    public static function map(array $array, $callback, $on_nonscalar = false)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $args        = array($value, $callback, $on_nonscalar);
                $array[$key] = call_user_func_array(array(__CLASS__, __FUNCTION__), $args);
            } else {
                if (is_scalar($value) || $on_nonscalar) {
                    $array[$key] = call_user_func($callback, $value);
                }
            }
        }

        return $array;
    }

    /**
     * Return the value of the given item.
     *
     * If the given item is a Closure the result of the Closure will be returned.
     *
     * @param  mixed $value
     * @return mixed
     */
    protected static function value($value)
    {
        return (is_callable($value) and !is_string($value)) ? call_user_func($value) : $value;
    }
}
