<?php
/**
 * @category Library
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */

namespace \Tbs;

use \Tbs\DocBlock\Collection;

/**
 * DocBlock Parser Class.
 *
 * @category Library
 * @package Tbs
 * @subpackage DocBlock
 * @author Leonardo Thibes <eu@leonardothibes.com>
 * @copyright Copyright (c) The Authors
 */
class DocBlock
{
    /**
     * Parse the DocBlock of a function.
     *
     * @param  string $function Function name.
     * @return \Tbs\DocBlock\Collection
     * @throws \Tbs\DocBlock\Exception
     */
    public static function ofFunction($function)
    {
        if (!strlen($function)) {
            throw new \Tbs\DocBlock\Exception('Function name cannot be blank');
        }
        $reflection = new ReflectionFunction($function);
        return self::of($reflection);
    }

    /**
     * Parse the DocBlock of a class.
     *
     * @param  string|object $class Name or instance of a class.
     * @return \Tbs\DocBlock\Collection
     * @throws \Tbs\DocBlock\Exception
     */
    public static function ofClass($class)
    {
        if (is_string($class) and !strlen($class)) {
            throw new \Tbs\DocBlock\Exception('Class name cannot be blank');
        }
        if (is_object($class)) {
            $class = get_class($class);
        }
        $class = new ReflectionClass($class);
        return self::of($class);
    }

    /**
     * Parse the DockBlock of a class property.
     *
     * @param string|object $class    Name or instance of a class.
     * @param string        $property Property name.
     *
     * @return \Tbs\DocBlock\Collection
     * @throws \Tbs\DocBlock\Exception
     */
    public static function ofProperty($class, $property)
    {
        if (is_string($class) and !strlen($class)) {
            throw new \Tbs\DocBlock\Exception('Class name cannot be blank');
        }
        if (!strlen($property)) {
            throw new \Tbs\DocBlock\Exception('Property name cannot be blank');
        }
        if (is_object($class)) {
            $class = get_class($class);
        }
        $reflection = new ReflectionProperty($class, $property);
        return self::of($reflection);
    }

    /**
     * Parse the DocBlock of a class method.
     *
     * @param string|object $class  Name or instance of a class.
     * @param string        $method Method name.
     *
     * @return \Tbs\DocBlock\Collection
     * @throws \Tbs\DocBlock\Exception
     */
    public static function ofMethod($class, $method)
    {
        if (is_string($class) and !strlen($class)) {
            throw new \Tbs\DocBlock\Exception('Class name cannot be blank');
        }
        if (!strlen($method)) {
            throw new \Tbs\DocBlock\Exception('Method name cannot be blank');
        }
        if (is_object($class)) {
            $class = get_class($class);
        }
        $reflection = new ReflectionMethod($class, $method);
        return self::of($reflection);
    }

    /**
     * Parse the DocBlock of a reflection object.
     *
     * @param  Reflector $reflection
     * @return \Tbs\DocBlock\Collection
     * @throws \Tbs\DocBlock\Exception
     */
    protected static function of(Reflection $reflection)
    {
        $docComment = $reflection->getDocComment();
        if (!strlen($docComment)) {
            throw new \Tbs\DocBlock\Exception('Invalid DocBlock');
        }
        return new Collection($docComment);
    }
}
