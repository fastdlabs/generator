<?php
/**
 * Created by PhpStorm.
 * User: janhuang
 * Date: 16/2/19
 * Time: 下午7:38
 * Github: https://www.github.com/janhuang
 * Coding: https://www.coding.net/janhuang
 * SegmentFault: http://segmentfault.com/u/janhuang
 * Blog: http://segmentfault.com/blog/janhuang
 * Gmail: bboyjanhuang@gmail.com
 * WebSite: http://www.janhuang.me
 */

namespace FastD\Generator\Factory;

/**
 * Class Object
 *
 * @package FastD\Generator\Factory
 */
class Object extends Generate
{
    const OBJECT_CLASS = 'class';
    const OBJECT_ABSTRACT = 'abstract class';
    const OBJECT_INTERFACE = 'interface';

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
     * @var self
     */
    protected $extend;

    /**
     * @var self[]
     */
    protected $interfaces = [];

    /**
     * @var array
     */
    protected $usages = [];

    /**
     * Object constructor.
     * @param $name
     * @param null $namespace
     * @param string $type
     */
    public function __construct($name, $namespace = null, $type = self::OBJECT_CLASS)
    {
        $this->namespace = $namespace;

        parent::__construct($name, $type, 'Class ' . $name);
    }

    /**
     * @return null|string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @param array $usages
     * @return $this
     */
    public function setUsages(array $usages)
    {
        $this->usages = $usages;

        return $this;
    }

    /**
     * @return array
     */
    public function getUsages()
    {
        return $this->usages;
    }

    /**
     * @param Object $object
     * @return $this
     */
    public function setExtends(Object $object)
    {
        $this->extend = $object;

        return $this;
    }

    /**
     * @return string
     */
    public function getExtends()
    {
        return $this->extend;
    }

    /**
     * @param Object[] $interfaces
     * @return $this
     */
    public function appendImplements(array $interfaces)
    {
        $this->interfaces = array_merge($this->interfaces, $interfaces);

        return $this;
    }

    /**
     * @param Object[] $interfaces
     * @return $this
     */
    public function setImplements(array $interfaces)
    {
        $this->interfaces = $interfaces;

        return $this;
    }

    /**
     * @return Object[]
     */
    public function getImplements()
    {
        return $this->interfaces;
    }

    /**
     * @param Property[] $properties
     * @return $this
     */
    public function appendProperties(array $properties)
    {
        $this->properties = array_merge($this->properties, $properties);

        return $this;
    }

    /**
     * @param Property[] $properties
     * @return $this
     */
    public function setProperties(array $properties)
    {
        $this->properties = $properties;

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
     * @param $name
     * @return Property|null
     */
    public function getProperty($name)
    {
        return isset($this->properties[$name]) ? $this->properties[$name] : null;
    }

    /**
     * @param Method[] $methods
     * @return $this
     */
    public function appendMethods(array $methods)
    {
        $this->methods = array_merge($this->methods, $methods);

        return $this;
    }

    /**
     * @param Method[] $methods
     * @return $this
     */
    public function setMethods(array $methods)
    {
        $this->methods = $methods;

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
     * @param $name
     * @return Method|null
     */
    public function getMethod($name)
    {
        return isset($this->methods[$name]) ? $this->methods[$name] : null;
    }

    /**
     * @return string
     */
    public function generate()
    {
        // property
        $properties = [];

        foreach ($this->properties as $property) {
            $properties[] = $property->generate();
        }

        if (!empty($properties)) {
            $properties = PHP_EOL . implode(PHP_EOL . PHP_EOL, $properties) . PHP_EOL;
        } else {
            $properties = '';
        }

        // extend
        $extend = null === $this->getExtends() ? '' : ' extends ' . str_replace('\\\\', '\\', '\\' . implode('\\', [$this->extend->getNamespace(), $this->extend->getName()]));

        // implements
        $interfaces = [];

        foreach ($this->interfaces as $interface) {
            $interfaces[] = str_replace('\\\\', '\\', '\\' . implode('\\', [$interface->getNamespace(), $interface->getName()]));
        }

        if (!empty($interfaces)) {
            $interfaces = ' implements ' . implode(',', $interfaces);
        } else {
            $interfaces = '';
        }

        // methods
        $methods = [];

        foreach ($this->methods as $method) {
            $methods[] = $method->generate();
        }

        if (!empty($methods)) {
            $methods = PHP_EOL . implode(PHP_EOL . PHP_EOL, $methods) . PHP_EOL;
        } else {
            $methods = '';
        }
        $methods = rtrim($methods);

        // use
        $usages = [];

        foreach ($this->usages as $usage) {
            $usages[] = 'use ' . $usage . ';';
        }

        if (!empty($usages)) {
            $usages = PHP_EOL . implode(PHP_EOL, $usages) . PHP_EOL;
        } else {
            $usages = '';
        }

        // namespace
        $namespace = $this->namespace ? PHP_EOL . "namespace {$this->getNamespace()};" : '';

        return <<<M
{$namespace}
{$usages}
{$this->getType()} {$this->getName()}{$extend}{$interfaces}
{{$properties}{$methods}
}
M;
    }

    /**
     * @return string
     */
    public function skeleton()
    {
        return $this->generate();
    }
}