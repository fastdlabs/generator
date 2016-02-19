<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 15/10/11
 * Time: 上午1:13
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator;

use FastD\Generator\Factory\Method;
use FastD\Generator\Factory\Object;
use FastD\Generator\Factory\Property;

/**
 * Class Generator
 *
 * @package FastD\Generator
 */
class Generator implements GeneratorInterface
{
    /**
     * @var string
     */
    protected $file;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var Property[]
     */
    protected $properties = [];

    /**
     * @var Method[]
     */
    protected $methods = [];

    /**
     * Generator constructor.
     * @param $name
     * @param null $namespace
     */
    public function __construct($name, $namespace = null)
    {
        $this->file = $name;

        $this->namespace = $namespace;

        $this->class = pathinfo($name, PATHINFO_FILENAME);
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param Property $property
     * @return GeneratorInterface
     */
    public function setProperty(Property $property)
    {
        $this->properties[$property->getName()] = $property;

        return $this;
    }

    /**
     * @param $name
     * @return Property
     */
    public function getProperty($name)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param array Property[] $properties
     * @return GeneratorInterface
     */
    public function setProperties(array $properties)
    {
        $this->properties = array_merge($this->properties, $properties);

        return $this;
    }

    /**
     * @return Property[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @param Method $method
     * @return GeneratorInterface
     */
    public function setMethod(Method $method)
    {
        $this->methods[$method->getName()] = $method;

        return $this;
    }

    /**
     * @param $name
     * @return Method
     */
    public function getMethod($name)
    {
        return isset($this->methods[$name]) ? $this->methods[$name] : null;
    }

    /**
     * @param array Method[] $methods
     * @return GeneratorInterface
     */
    public function setMethods(array $methods)
    {
        $this->methods = array_merge($this->methods, $methods);

        return $this;
    }

    /**
     * @return Method[]
     */
    public function getMethods()
    {
        return $this->methods;
    }

    /**
     * @param bool $output
     * @return string|void
     */
    public function output($output = true)
    {
        $object = new Object($this->class, $this->namespace, $this->properties, $this->methods);

        if (!$output) {
            return $object->generate();
        }

        echo $object->generate();
    }

    /**
     * @param null|string $file
     * @return int
     */
    public function save($file = null)
    {
        // TODO: Implement save() method.
    }

    /**
     * @return mixed
     */
    public function getParser()
    {
        // TODO: Implement getParser() method.
    }
}